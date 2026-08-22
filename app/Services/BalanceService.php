<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\LogBalance;
use App\Models\MoneyFlow;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use RuntimeException;

/**
 * ==================================================================
 *  BalanceService — quản lý số dư người dùng
 * ------------------------------------------------------------------
 *  LỖI NGHIÊM TRỌNG CỦA BẢN GỐC ĐÃ ĐƯỢC KHẮC PHỤC:
 *
 *  1. RACE CONDITION (lỗi mất tiền / bug tiền âm)
 *     Bản gốc: đọc số dư -> so sánh trong PHP -> rồi mới UPDATE.
 *     Hai request gửi cùng lúc đều đọc được số dư cũ, đều thấy "đủ tiền",
 *     và đều trừ -> người dùng mua được 2 nick với giá 1 nick.
 *     Nay: dùng transaction + lockForUpdate() (SELECT ... FOR UPDATE),
 *     request thứ hai buộc phải chờ request thứ nhất commit.
 *
 *  2. KHÔNG KIỂM TRA KẾT QUẢ TRỪ TIỀN
 *     Bản gốc dùng "UPDATE users SET money = money - x" rồi coi như
 *     thành công. Nếu số dư không đủ, MySQL vẫn trừ -> tiền âm.
 *     Nay kiểm tra trước trong transaction và ném exception nếu thiếu.
 *
 *  3. GHI LOG KHÔNG NGUYÊN TỬ
 *     Bản gốc trừ tiền xong mới ghi log; nếu ghi log lỗi thì tiền đã mất
 *     mà không có dấu vết. Nay cả hai nằm trong CÙNG một transaction.
 * ==================================================================
 */
class BalanceService
{
    /**
     * Trừ tiền của người dùng một cách an toàn.
     *
     * @param  int  $amount  Số tiền cần trừ (luôn > 0)
     * @return User Bản ghi người dùng đã cập nhật
     *
     * @throws RuntimeException Khi số dư không đủ
     */
    public function debit(User $user, int $amount, string $reason): User
    {
        $this->assertPositive($amount);

        return DB::transaction(function () use ($user, $amount, $reason): User {
            /* Khoá dòng dữ liệu: request khác phải chờ tới khi commit */
            $locked = User::query()
                ->whereKey($user->getKey())
                ->lockForUpdate()
                ->firstOrFail();

            $before = (int) $locked->money;

            if ($before < $amount) {
                throw new RuntimeException('Số dư của bạn không đủ để thực hiện giao dịch này.');
            }

            $after = $before - $amount;

            $locked->money = $after;
            $locked->save();

            $this->writeLogs($locked, $before, -$amount, $after, $reason);

            return $locked;
        });
    }

    /**
     * Cộng tiền cho người dùng.
     *
     * @param  bool  $countTowardsTotal  Có tính vào tổng nạp (total_money) hay không
     */
    public function credit(User $user, int $amount, string $reason, bool $countTowardsTotal = true): User
    {
        $this->assertPositive($amount);

        return DB::transaction(function () use ($user, $amount, $reason, $countTowardsTotal): User {
            $locked = User::query()
                ->whereKey($user->getKey())
                ->lockForUpdate()
                ->firstOrFail();

            $before = (int) $locked->money;
            $after  = $before + $amount;

            $locked->money = $after;

            if ($countTowardsTotal) {
                $locked->total_money = (int) $locked->total_money + $amount;
            }

            $locked->save();

            $this->writeLogs($locked, $before, $amount, $after, $reason);

            return $locked;
        });
    }

    /**
     * Hoàn tiền (dùng khi huỷ đơn / bảo hành thành công).
     * Không tính vào tổng nạp để tránh làm sai thống kê.
     */
    public function refund(User $user, int $amount, string $reason): User
    {
        return $this->credit($user, $amount, '[Hoàn tiền] '.$reason, countTowardsTotal: false);
    }

    /** Ghi song song 2 bảng log để giữ tương thích với dữ liệu cũ. */
    private function writeLogs(User $user, int $before, int $change, int $after, string $reason): void
    {
        MoneyFlow::query()->create([
            'sotientruoc'   => $before,
            'sotienthaydoi' => abs($change),
            'sotiensau'     => $after,
            'thoigian'      => now(),
            'noidung'       => $reason,
            'username'      => $user->email,
        ]);

        LogBalance::query()->create([
            'money_before' => $before,
            'money_change' => $change,
            'money_after'  => $after,
            'content'      => $reason,
            'user_id'      => $user->getKey(),
            'time'         => now(),
        ]);
    }

    private function assertPositive(int $amount): void
    {
        if ($amount <= 0) {
            throw new RuntimeException('Số tiền phải lớn hơn 0.');
        }
    }
}
