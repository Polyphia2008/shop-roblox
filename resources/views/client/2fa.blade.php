@extends('layouts.app')
@section('title', 'Bảo mật 2 lớp')

@section('content')
<div class="mx-auto max-w-3xl">
    <h1 class="mb-6 text-xl font-semibold">Hướng dẫn bật bảo mật 2 lớp (2FA)</h1>

    @if ($guide = \App\Models\Setting::get('twofa_guide'))
        <div class="card">
            <div class="card-body whitespace-pre-line text-sm leading-relaxed">{{ $guide }}</div>
        </div>
    @else
        <div class="space-y-6">
            <div class="alert-info">
                2FA là lớp bảo vệ hiệu quả nhất cho tài khoản Roblox sau khi mua: kể cả người
                khác biết mật khẩu, họ vẫn không đăng nhập được.
            </div>

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Bước 1 — Đổi mật khẩu ngay sau khi mua</h2>
                </div>
                <div class="card-body space-y-2 text-sm leading-relaxed">
                    <p>
                        Đăng nhập Roblox bằng thông tin trong đơn hàng, vào
                        <span class="font-medium">Settings → Account Info</span> và đổi mật khẩu
                        sang mật khẩu riêng của bạn.
                    </p>
                    <p class="text-muted-foreground">
                        Lưu ý: đổi mật khẩu sẽ kết thúc phạm vi bảo hành cho tài khoản đó, nên
                        hãy kiểm tra tài khoản đăng nhập được bình thường trước khi đổi.
                    </p>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Bước 2 — Thêm email của bạn</h2>
                </div>
                <div class="card-body text-sm leading-relaxed">
                    <p>
                        Vẫn trong <span class="font-medium">Account Info</span>, thay email sang
                        email bạn đang kiểm soát rồi xác nhận qua hộp thư. Đây là bước bắt buộc
                        để có thể khôi phục tài khoản sau này.
                    </p>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Bước 3 — Bật xác thực 2 lớp</h2>
                </div>
                <div class="card-body space-y-2 text-sm leading-relaxed">
                    <p>
                        Vào <span class="font-medium">Settings → Security</span>, bật
                        <span class="font-medium">Two Step Verification</span> và chọn phương thức
                        Authenticator App (khuyến nghị) hoặc Email.
                    </p>
                    <p>
                        Với Authenticator App, quét mã QR bằng Google Authenticator hoặc Authy,
                        sau đó nhập mã 6 số để hoàn tất.
                    </p>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Bước 4 — Lưu mã dự phòng</h2>
                </div>
                <div class="card-body space-y-2 text-sm leading-relaxed">
                    <p>
                        Roblox sẽ hiển thị các mã dự phòng dùng một lần. Lưu lại ở nơi an toàn —
                        nếu mất điện thoại, đây là cách duy nhất để lấy lại tài khoản.
                    </p>
                    <p class="text-muted-foreground">
                        Không gửi mã dự phòng cho bất kỳ ai, kể cả người tự nhận là nhân viên shop.
                    </p>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Bảo mật tài khoản shop</h2>
                </div>
                <div class="card-body space-y-3 text-sm leading-relaxed">
                    <p>
                        Với tài khoản trên shop, hãy đặt mật khẩu riêng (không dùng lại mật khẩu
                        của email hay game) và kiểm tra
                        <span class="font-medium">Đăng nhập gần đây</span> ở trang tài khoản để
                        phát hiện truy cập lạ. Khi đổi mật khẩu, mọi phiên đăng nhập khác sẽ tự
                        động bị đăng xuất.
                    </p>
                    <a href="{{ route('profile') }}" class="btn-primary">Kiểm tra tài khoản</a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
