@extends('layouts.app')
@section('title', 'Đăng nhập')

@section('content')
<div class="mx-auto max-w-md">
    <div class="card">
        <div class="card-header">
            <h1 class="text-xl font-semibold">Đăng nhập</h1>
            <p class="mt-1 text-sm text-muted-foreground">Nhập email và mật khẩu để tiếp tục.</p>
        </div>

        <form method="POST" action="{{ route('login.store') }}" class="card-body space-y-4">
            @csrf {{-- Bắt buộc: bản gốc không có CSRF nên bị ép đăng nhập từ site khác --}}

            <div>
                <label for="email" class="mb-2 block text-sm font-medium">Email</label>
                <input id="email" name="email" type="email" required autofocus autocomplete="email"
                       value="{{ old('email') }}" class="input" placeholder="email@example.com">
            </div>

            <div>
                <label for="password" class="mb-2 block text-sm font-medium">Mật khẩu</label>
                <input id="password" name="password" type="password" required autocomplete="current-password"
                       class="input" placeholder="••••••••">
            </div>

            <label class="flex items-center gap-2 text-sm">
                <input type="checkbox" name="remember" value="1" class="rounded border-border">
                Ghi nhớ đăng nhập
            </label>

            <button type="submit" class="btn-primary w-full">Đăng nhập</button>

            <p class="text-center text-sm text-muted-foreground">
                Chưa có tài khoản?
                <a href="{{ route('register') }}" class="font-medium text-primary hover:underline">Đăng ký</a>
            </p>
        </form>
    </div>
</div>
@endsection
