@extends('layouts.app')
@section('title', 'Hướng dẫn dùng bot')

@section('content')
<div class="mx-auto max-w-3xl">
    <h1 class="mb-6 text-xl font-semibold">Hướng dẫn dùng bot Telegram</h1>

    @if ($guide = \App\Models\Setting::get('bot_guide'))
        <div class="card">
            <div class="card-body whitespace-pre-line text-sm leading-relaxed">{{ $guide }}</div>
        </div>
    @else
        <div class="space-y-6">
            <div class="alert-info">
                Bot chỉ gửi thông báo đơn hàng. Bot
                <span class="font-medium">không bao giờ</span> hỏi mật khẩu của bạn —
                mọi tin nhắn yêu cầu mật khẩu đều là giả mạo.
            </div>

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Bước 1 — Lấy Telegram ID</h2>
                </div>
                <div class="card-body space-y-2 text-sm leading-relaxed">
                    <p>
                        Mở Telegram, tìm bot <span class="font-mono">@userinfobot</span> và bấm
                        Start. Bot sẽ trả về một dãy số, đó là Telegram ID của bạn.
                    </p>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Bước 2 — Lưu ID vào tài khoản</h2>
                </div>
                <div class="card-body space-y-3 text-sm leading-relaxed">
                    <p>
                        Dán dãy số đó vào ô <span class="font-medium">Telegram ID</span> ở trang
                        thông tin tài khoản. Hệ thống chỉ nhận chữ số nên nếu dán kèm ký tự lạ
                        sẽ bị từ chối.
                    </p>
                    <a href="{{ route('profile') }}" class="btn-primary">Mở trang tài khoản</a>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Bước 3 — Bắt đầu nhận thông báo</h2>
                </div>
                <div class="card-body space-y-2 text-sm leading-relaxed">
                    @if ($botName = \App\Models\Setting::get('telegram_bot'))
                        <p>
                            Nhắn <span class="font-mono">/start</span> cho bot
                            <span class="font-mono">{{ $botName }}</span> để mở kênh nhận tin.
                        </p>
                    @else
                        <p>
                            Nhắn <span class="font-mono">/start</span> cho bot của shop để mở kênh
                            nhận tin. Liên hệ hỗ trợ nếu bạn chưa biết tên bot.
                        </p>
                    @endif
                    <p class="text-muted-foreground">
                        Sau khi hoàn tất, mỗi đơn hàng thành công sẽ được gửi kèm mã giao dịch
                        để bạn đối chiếu.
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
