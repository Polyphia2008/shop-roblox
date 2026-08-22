@extends('layouts.app')
@section('title', $notification ? 'Thông báo từ bot' : 'Kiểm tra bot')

@section('content')
<div class="mx-auto max-w-2xl">

    {{-- Route /botcheck và /botcheck/notification dùng chung view này.
         Biến $notification do controller tính từ query `id`, KHÔNG in
         thẳng giá trị query ra HTML — bản gốc echo tham số GET nên bị
         reflected XSS. --}}
    @if ($notification)
        <div class="card">
            <div class="card-header">
                <h1 class="card-title">Trạng thái thông báo</h1>
            </div>
            <div class="card-body space-y-4 text-sm leading-relaxed">
                <div class="alert-success">
                    Kênh thông báo đang hoạt động. Đơn hàng mới sẽ được gửi tới Telegram của bạn.
                </div>

                @auth
                    @if (auth()->user()->telegram)
                        <p>
                            Telegram ID đang liên kết:
                            <span class="font-mono font-medium">{{ auth()->user()->telegram }}</span>
                        </p>
                    @else
                        <p>
                            Tài khoản của bạn chưa liên kết Telegram ID nên chưa nhận được thông báo.
                        </p>
                        <a href="{{ route('profile') }}" class="btn-primary">Liên kết ngay</a>
                    @endif
                @else
                    <p>Đăng nhập để xem trạng thái liên kết của tài khoản bạn.</p>
                    <a href="{{ route('login') }}" class="btn-primary">Đăng nhập</a>
                @endauth
            </div>
        </div>
    @else
        <div class="card">
            <div class="card-header">
                <h1 class="card-title">Kiểm tra bot</h1>
                <p class="text-sm text-muted-foreground">
                    Trang này giúp bạn xác nhận bot của shop còn hoạt động.
                </p>
            </div>
            <div class="card-body space-y-4 text-sm leading-relaxed">
                <div class="alert-success">Hệ thống đang hoạt động bình thường.</div>

                <p>
                    Nếu bạn không nhận được thông báo đơn hàng, kiểm tra lần lượt:
                </p>
                <ul class="list-inside list-disc space-y-2">
                    <li>Đã lưu Telegram ID ở trang tài khoản chưa.</li>
                    <li>Đã nhắn <span class="font-mono">/start</span> cho bot chưa.</li>
                    <li>Có đang chặn (block) bot trong Telegram không.</li>
                </ul>

                <div class="flex flex-wrap gap-2 pt-2">
                    <a href="{{ route('use-bot') }}" class="btn-primary">Hướng dẫn dùng bot</a>
                    <a href="{{ route('botcheck.notification') }}" class="btn-outline">
                        Kiểm tra thông báo
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
