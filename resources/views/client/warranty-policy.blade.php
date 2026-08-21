@extends('layouts.app')
@section('title', 'Chính sách bảo hành')

@section('content')
<div class="mx-auto max-w-3xl">
    <h1 class="mb-6 text-xl font-semibold">Chính sách bảo hành</h1>

    {{-- Nội dung có thể được admin cấu hình qua bảng settings. Dù đặt
         trong DB, giá trị vẫn được in bằng {{ }} nên tự động escape —
         admin bị chiếm quyền cũng không chèn được <script> vào trang
         (chống stored XSS). --}}
    @if ($policy = \App\Models\Setting::get('warranty_policy'))
        <div class="card">
            <div class="card-body whitespace-pre-line text-sm leading-relaxed">{{ $policy }}</div>
        </div>
    @else
        <div class="space-y-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">1. Phạm vi bảo hành</h2>
                </div>
                <div class="card-body space-y-2 text-sm leading-relaxed">
                    <p>
                        Mỗi tài khoản đều ghi rõ thời hạn bảo hành ngay trên trang chi tiết
                        trước khi bạn thanh toán. Thời hạn được tính từ thời điểm đơn hàng
                        hoàn tất.
                    </p>
                    <p>
                        Trong thời hạn này, nếu tài khoản bị thu hồi hoặc không đăng nhập được
                        vì lý do từ phía shop, bạn được đổi tài khoản tương đương hoặc hoàn
                        tiền vào số dư.
                    </p>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">2. Trường hợp không bảo hành</h2>
                </div>
                <div class="card-body text-sm leading-relaxed">
                    <ul class="list-inside list-disc space-y-2">
                        <li>Đã tự thay đổi email, mật khẩu hoặc thông tin bảo mật của tài khoản.</li>
                        <li>Tài khoản bị khoá do vi phạm điều khoản của nhà phát hành.</li>
                        <li>Chia sẻ tài khoản cho người khác dẫn tới mất quyền kiểm soát.</li>
                        <li>Đã quá thời hạn bảo hành ghi trên đơn hàng.</li>
                    </ul>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">3. Cách gửi yêu cầu</h2>
                </div>
                <div class="card-body space-y-3 text-sm leading-relaxed">
                    <p>
                        Vào <span class="font-medium">Nick Robux đã mua</span>, chọn tài khoản
                        cần hỗ trợ rồi bấm <span class="font-medium">Yêu cầu bảo hành</span>.
                        Mỗi tài khoản chỉ có một yêu cầu đang mở tại một thời điểm.
                    </p>
                    <p>
                        Khi yêu cầu được chấp nhận, tiền sẽ được hoàn trực tiếp vào số dư và
                        bạn có thể xem lại ở trang
                        <span class="font-medium">Biến động số dư</span>.
                    </p>
                    <a href="{{ route('history-order') }}" class="btn-primary">
                        Tới danh sách nick đã mua
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
