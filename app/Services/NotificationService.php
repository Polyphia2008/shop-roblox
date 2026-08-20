<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Gửi thông báo qua Telegram.
 *
 * Nâng cấp so với bản gốc:
 *  - Bản gốc hard-code token bot ngay trong helpers.php (rò rỉ khi
 *    push code lên Git). Nay đọc từ .env / bảng settings.
 *  - Bản gốc dùng file_get_contents() không timeout -> Telegram chậm là
 *    treo cả website. Nay dùng Http client với timeout 5 giây.
 *  - Mọi lỗi gửi tin đều được bắt lại: không bao giờ làm sập đơn hàng.
 */
class NotificationService
{
    private const API = 'https://api.telegram.org/bot';

    /** Thông báo đặt hàng thành công. */
    public function orderPlaced(User $user, string $magd, int $amount, string $title): void
    {
        $message = sprintf(
            "🔔 <b>Đơn hàng mới</b> #%s\n👤 %s\n📦 %s\n💰 %s đ\n🕒 %s",
            $magd,
            e($user->email),
            e($title),
            number_format($amount, 0, ',', '.'),
            now()->format('d/m/Y H:i:s'),
        );

        /* Gửi cho admin + gửi riêng cho khách nếu khách có Telegram ID */
        $this->send($message);

        if (! empty($user->telegram)) {
            $this->send($message, (string) $user->telegram);
        }
    }

    /** Cảnh báo bảo mật cho admin. */
    public function securityAlert(string $type, string $ip, string $detail): void
    {
        $this->send(sprintf(
            "🚨 <b>CẢNH BÁO BẢO MẬT</b>\n⚠️ Loại: %s\n🌐 IP: %s\n📄 %s\n🕒 %s",
            e($type),
            e($ip),
            e($detail),
            now()->format('d/m/Y H:i:s'),
        ));
    }

    /**
     * Gửi tin nhắn Telegram.
     *
     * @param  string|null  $chatId  Bỏ trống = gửi cho admin
     */
    public function send(string $message, ?string $chatId = null): bool
    {
        $token  = $this->token();
        $chatId ??= $this->adminChatId();

        if ($token === null || $chatId === null) {
            /* Chưa cấu hình Telegram -> bỏ qua, không coi là lỗi */
            return false;
        }

        try {
            $response = Http::timeout(5)
                ->retry(2, 200)
                ->asForm()
                ->post(self::API.$token.'/sendMessage', [
                    'chat_id'    => $chatId,
                    'text'       => $message,
                    'parse_mode' => 'HTML',
                    'disable_web_page_preview' => true,
                ]);

            return $response->successful();
        } catch (\Throwable $e) {
            /* Telegram lỗi KHÔNG được làm sập luồng nghiệp vụ */
            Log::warning('Telegram send failed: '.$e->getMessage());

            return false;
        }
    }

    private function token(): ?string
    {
        return config('services.telegram.token')
            ?: Setting::get('telegram_token')
            ?: null;
    }

    private function adminChatId(): ?string
    {
        return config('services.telegram.chat_id')
            ?: Setting::get('telegram_chat_id')
            ?: null;
    }
}
