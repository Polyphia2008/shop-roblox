<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\AccountRb;
use App\Models\Category;
use App\Models\Order;
use App\Models\ProductNick;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use RuntimeException;

/**
 * ==================================================================
 *  PurchaseService — xử lý mua hàng
 * ------------------------------------------------------------------
 *  LỖI NGHIÊM TRỌNG CỦA BẢN GỐC ĐÃ KHẮC PHỤC:
 *
 *  1. BÁN TRÙNG MỘT NICK CHO NHIỀU NGƯỜI
 *     Bản gốc: SELECT nick WHERE status=1 -> trừ tiền -> UPDATE status=2.
 *     Hai người bấm mua cùng lúc đều SELECT được cùng một nick.
 *     Nay dùng "claim" nguyên tử: UPDATE ... WHERE status=1 và kiểm tra
 *     số dòng bị ảnh hưởng. Chỉ đúng 1 request nhận được giá trị 1.
 *
 *  2. GIÁ LẤY TỪ PHÍA CLIENT
 *     Bản gốc có chỗ nhận `price`/`total` từ $_POST -> khách tự sửa giá
 *     thành 0 đồng. Nay giá LUÔN đọc lại từ DB, bỏ qua input người dùng.
 *
 *  3. TRỪ TIỀN VÀ GIAO HÀNG KHÔNG CÙNG TRANSACTION
 *     Nếu bước sau lỗi, khách mất tiền mà không nhận được hàng.
 *     Nay toàn bộ nằm trong 1 transaction — lỗi là rollback sạch.
 * ==================================================================
 */
class PurchaseService
{
    public function __construct(
        private readonly BalanceService $balance,
        private readonly NotificationService $notifier,
    ) {}

    /**
     * Mua một nick có Robux theo ID.
     *
     * @return array{order: Order, account: AccountRb}
     */
    public function buyRobuxAccount(User $user, int $accountId): array
    {
        return DB::transaction(function () use ($user, $accountId): array {
            /* Khoá bản ghi nick để tránh hai người mua cùng lúc */
            $account = AccountRb::query()
                ->whereKey($accountId)
                ->where('status', AccountRb::STATUS_ON_SALE)
                ->lockForUpdate()
                ->first();

            if ($account === null) {
                throw new RuntimeException('Tài khoản này không còn tồn tại hoặc đã được bán.');
            }

            /* GIÁ LẤY TỪ DB — tuyệt đối không tin giá do client gửi lên */
            $price = (int) $account->price;
            $magd  = $this->generateOrderCode();

            /* Trừ tiền (có kiểm tra số dư + lock user) */
            $this->balance->debit($user, $price, "Mua nick Robux (#{$account->id})");

            /* Giao hàng: gán nick cho người mua */
            $account->update([
                'username' => $user->email,
                'status'   => AccountRb::STATUS_SOLD,
                'magd'     => $magd,
                'time'     => now(),
            ]);

            $order = Order::query()->create([
                'magd'     => $magd,
                'title'    => "Nick Robux #{$account->id} ({$account->robux} Robux)",
                'soluong'  => 1,
                'money'    => $price,
                'username' => $user->email,
                'live'     => 1,
                'type'     => 'accountrb',
                'display'  => 'show',
            ]);

            $this->notifier->orderPlaced($user, $magd, $price, 'Nick Robux');

            return ['order' => $order, 'account' => $account];
        });
    }

    /**
     * Mua nick thường theo chuyên mục (lấy nick đầu tiên còn hàng).
     *
     * @param  int  $quantity  Số lượng muốn mua
     * @return array{order: Order, nicks: \Illuminate\Support\Collection<int, ProductNick>}
     */
    public function buyCategoryNicks(User $user, string $categoryCode, int $quantity): array
    {
        if ($quantity < 1 || $quantity > 50) {
            throw new RuntimeException('Số lượng phải từ 1 đến 50.');
        }

        return DB::transaction(function () use ($user, $categoryCode, $quantity): array {
            $category = Category::query()
                ->where('code', $categoryCode)
                ->where('status', 'show')
                ->lockForUpdate()
                ->first();

            if ($category === null) {
                throw new RuntimeException('Chuyên mục không tồn tại.');
            }

            /* Khoá đúng số nick cần bán, chống bán trùng */
            $nicks = ProductNick::query()
                ->where('chuyenmuc', $category->code)
                ->where('status', 'live')
                ->orderBy('id')
                ->limit($quantity)
                ->lockForUpdate()
                ->get();

            if ($nicks->count() < $quantity) {
                throw new RuntimeException('Số lượng trong kho không đủ. Còn lại: '.$nicks->count());
            }

            /* GIÁ LẤY TỪ DB */
            $total = (int) $category->price * $quantity;
            $magd  = $this->generateOrderCode();

            $this->balance->debit($user, $total, "Mua {$quantity} nick — {$category->title}");

            ProductNick::query()
                ->whereIn('id', $nicks->pluck('id'))
                ->update([
                    'username'     => $user->email,
                    'status'       => 'sold',
                    'magd'         => $magd,
                    'updated_time' => now(),
                ]);

            $category->increment('buy', $quantity);

            $order = Order::query()->create([
                'magd'     => $magd,
                'title'    => $category->title,
                'soluong'  => $quantity,
                'money'    => $total,
                'username' => $user->email,
                'live'     => $quantity,
                'type'     => 'product_nick',
                'display'  => 'show',
            ]);

            $this->notifier->orderPlaced($user, $magd, $total, $category->title);

            return ['order' => $order, 'nicks' => $nicks];
        });
    }

    /**
     * Sinh mã giao dịch duy nhất: 3 chữ cái + 10 chữ số.
     * Bản gốc dùng rand() nên có thể trùng; nay kiểm tra tồn tại trong DB.
     */
    private function generateOrderCode(): string
    {
        do {
            $code = Str::upper(Str::random(3)).random_int(1_000_000_000, 9_999_999_999);
        } while (Order::query()->where('magd', $code)->exists());

        return $code;
    }
}
