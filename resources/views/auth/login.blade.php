@extends('layouts.auth')
@section('title', 'Đăng nhập')

@section('content')
    <h4 class="mb-1 text-custom-500 dark:text-custom-500">Chào mừng trở lại!</h4>
    <p class="mb-6 text-slate-500 dark:text-zink-200">Nhập email và mật khẩu để tiếp tục.</p>

    <x-flash />

    <form method="POST" action="{{ route('login.store') }}" class="space-y-4">
        {{-- Bắt buộc: bản gốc không có CSRF nên bị ép đăng nhập từ site khác --}}
        @csrf

        <div>
            <label for="email" class="inline-block mb-2 text-base font-medium">Email</label>
            <input id="email" name="email" type="email" required autofocus autocomplete="email"
                   value="{{ old('email') }}" placeholder="email@example.com"
                   class="w-full py-2.5 px-4 text-15 rounded border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200 form-input">
            @error('email')
                <span class="block mt-1 text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="password" class="inline-block mb-2 text-base font-medium">Mật khẩu</label>
            <input id="password" name="password" type="password" required autocomplete="current-password"
                   placeholder="••••••••"
                   class="w-full py-2.5 px-4 text-15 rounded border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200 form-input">
            @error('password')
                <span class="block mt-1 text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div class="flex items-center gap-2">
            <input id="remember" name="remember" type="checkbox" value="1"
                   class="border rounded-sm cursor-pointer bg-slate-100 border-slate-200 dark:bg-zink-600 dark:border-zink-500 checked:bg-custom-500 dark:checked:bg-custom-500 checked:border-custom-500 dark:checked:border-custom-500">
            <label for="remember" class="align-middle cursor-pointer">Ghi nhớ đăng nhập</label>
        </div>

        <div class="mt-2">
            <button type="submit"
                    class="w-full text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 dark:ring-custom-400/20">
                Đăng nhập
            </button>
        </div>

        <div class="mt-4 text-center">
            <p class="mb-0 text-slate-500 dark:text-zink-200">
                Chưa có tài khoản?
                <a href="{{ route('register') }}" class="underline transition-all duration-150 ease-linear text-slate-500 dark:text-zink-200 hover:text-custom-500 dark:hover:text-custom-500">
                    Đăng ký
                </a>
            </p>
        </div>
    </form>
@endsection
</content>
