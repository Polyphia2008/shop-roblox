@extends('layouts.app')
@section('title', 'Đăng ký')

@section('content')
<div class="mx-auto max-w-md">
    <div class="card">
        <div class="card-header">
            <h1 class="text-xl font-semibold">Tạo tài khoản</h1>
            <p class="mt-1 text-sm text-muted-foreground">Mật khẩu cần có chữ hoa, chữ thường, số và ký tự đặc biệt.</p>
        </div>

        <form method="POST" action="{{ route('register.store') }}" class="card-body space-y-4">
            @csrf

            <div>
                <label for="email" class="mb-2 block text-sm font-medium">Email</label>
                <input id="email" name="email" type="email" required autofocus autocomplete="email"
                       value="{{ old('email') }}" class="input" placeholder="email@example.com">
            </div>

            <div>
                <label for="name" class="mb-2 block text-sm font-medium">Tên hiển thị</label>
                <input id="name" name="name" type="text" autocomplete="name"
                       value="{{ old('name') }}" class="input" placeholder="Tên của bạn">
            </div>

            <div>
                <label for="telegram" class="mb-2 block text-sm font-medium">
                    Telegram ID <span class="text-muted-foreground">(tuỳ chọn, để nhận thông báo)</span>
                </label>
                <input id="telegram" name="telegram" type="text" inputmode="numeric"
                       value="{{ old('telegram') }}" class="input" placeholder="123456789">
            </div>

            <div>
                <label for="password" class="mb-2 block text-sm font-medium">Mật khẩu</label>
                <input id="password" name="password" type="password" required autocomplete="new-password"
                       class="input" placeholder="••••••••">
            </div>

            <div>
                <label for="password_confirmation" class="mb-2 block text-sm font-medium">Nhập lại mật khẩu</label>
                <input id="password_confirmation" name="password_confirmation" type="password" required
                       autocomplete="new-password" class="input" placeholder="••••••••">
            </div>

            <button type="submit" class="btn-primary w-full">Đăng ký</button>

            <p class="text-center text-sm text-muted-foreground">
                Đã có tài khoản?
                <a href="{{ route('login') }}" class="font-medium text-primary hover:underline">Đăng nhập</a>
            </p>
        </form>
    </div>
</div>
@endsection
