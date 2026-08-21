@extends('layouts.app')
@section('title', 'Hướng dẫn gửi báo cáo')

@section('content')
<div class="mx-auto max-w-3xl">
    <h1 class="mb-6 text-xl font-semibold">Hướng dẫn gửi báo cáo</h1>

    @if ($guide = \App\Models\Setting::get('report_guide'))
        <div class="card">
            <div class="card-body whitespace-pre-line text-sm leading-relaxed">{{ $guide }}</div>
        </div>
    @else
        <div class="space-y-6">
            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Khi nào cần gửi báo cáo?</h2>
                </div>
                <div class="card-body text-sm leading-relaxed">
                    <ul class="list-inside list-disc space-y-2">
                        <li>Tài khoản vừa mua không đăng nhập được.</li>
                        <li>Thông tin tài khoản không đúng như mô tả trên đơn hàng.</li>
                        <li>Tài khoản bị thu hồi trong thời hạn bảo hành.</li>
                        <li>Đã nạp tiền nhưng số dư chưa được cộng.</li>
                    </ul>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Cách gửi</h2>
                </div>
                <div class="card-body space-y-3 text-sm leading-relaxed">
                    <ol class="list-inside list-decimal space-y-2">
                        <li>Mở trang <span class="font-medium">Nick Robux đã mua</span>.</li>
                        <li>Tìm tài khoản gặp vấn đề, bấm <span class="font-medium">Yêu cầu bảo hành / hỗ trợ</span>.</li>
                        <li>Chọn loại yêu cầu và mô tả vấn đề tối thiểu 10 ký tự.</li>
                        <li>Bấm gửi và theo dõi trạng thái ngay trên trang đó.</li>
                    </ol>

                    {{-- Nhắc rõ giới hạn phía server để user không bị bất
                         ngờ: mỗi nick chỉ 1 ticket đang mở, và chỉ gửi
                         được cho nick thuộc chính mình. --}}
                    <div class="alert-info">
                        Mỗi tài khoản chỉ có một yêu cầu đang mở tại một thời điểm. Bạn cũng
                        chỉ gửi được báo cáo cho tài khoản do chính bạn mua.
                    </div>

                    <a href="{{ route('history-order') }}" class="btn-primary">
                        Tới danh sách nick đã mua
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h2 class="card-title">Mô tả thế nào cho nhanh được xử lý?</h2>
                </div>
                <div class="card-body space-y-2 text-sm leading-relaxed">
                    <p>Nêu rõ ba điều: bạn đã làm gì, hệ thống báo lỗi gì, và vào lúc nào.</p>
                    <p class="text-muted-foreground">
                        Ví dụ: “Đăng nhập lúc 21:30 ngày 20/08 thì Roblox báo tài khoản bị khoá,
                        tôi chưa đổi mật khẩu hay email.”
                    </p>
                    <p>
                        Đừng gửi mật khẩu tài khoản shop trong nội dung báo cáo — nhân viên hỗ trợ
                        không cần thông tin đó.
                    </p>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
