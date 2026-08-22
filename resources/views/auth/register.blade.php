@extends('layouts.auth')
@section('title', 'Đăng ký')

@php
    // Gom class ô nhập của theme vào một biến cho gọn, giữ nguyên từng class.
    $inputCls = 'w-full py-2.5 px-4 text-15 rounded border-slate-200 dark:border-zink-500'
        .' focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600'
        .' disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200'
        .' disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800'
        .' placeholder:text-slate-400 dark:placeholder:text-zink-200 form-input';
@endphp

@section('content')
    <h4 class="mb-1 text-custom-500 dark:text-custom-500">Tạo tài khoản</h4>
    <p class="mb-6 text-slate-500 dark:text-zink-200">
        Mật khẩu cần có chữ hoa, chữ thường, số và ký tự đặc biệt.
    </p>

    <x-flash />

    <form method="POST" action="{{ route('register.store') }}" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="inline-block mb-2 text-base font-medium">Email</label>
            <input id="email" name="email" type="email" required autofocus autocomplete="email"
                   value="{{ old('email') }}" placeholder="email@example.com" class="{{ $inputCls }}">
            @error('email')
                <span class="block mt-1 text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="name" class="inline-block mb-2 text-base font-medium">Tên hiển thị</label>
            <input id="name" name="name" type="text" autocomplete="name"
                   value="{{ old('name') }}" placeholder="Tên của bạn" class="{{ $inputCls }}">
            @error('name')
                <span class="block mt-1 text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="telegram" class="inline-block mb-2 text-base font-medium">
                Telegram ID
                <span class="text-slate-500 dark:text-zink-200">(tuỳ chọn, để nhận thông báo)</span>
            </label>
            <input id="telegram" name="telegram" type="text" inputmode="numeric"
                   value="{{ old('telegram') }}" placeholder="123456789" class="{{ $inputCls }}">
            @error('telegram')
                <span class="block mt-1 text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="password" class="inline-block mb-2 text-base font-medium">Mật khẩu</label>
            <input id="password" name="password" type="password" required autocomplete="new-password"
                   placeholder="••••••••" class="{{ $inputCls }}">
            @error('password')
                <span class="block mt-1 text-sm text-red-500">{{ $message }}</span>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="inline-block mb-2 text-base font-medium">Nhập lại mật khẩu</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required
                   autocomplete="new-password" placeholder="••••••••" class="{{ $inputCls }}">
        </div>

        <div class="mt-2">
            <button type="submit"
                    class="w-full text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 dark:ring-custom-400/20">
                Đăng ký
            </button>
        </div>

        <div class="mt-4 text-center">
            <p class="mb-0 text-slate-500 dark:text-zink-200">
                Đã có tài khoản?
                <a href="{{ route('login') }}" class="underline transition-all duration-150 ease-linear text-slate-500 dark:text-zink-200 hover:text-custom-500 dark:hover:text-custom-500">
                    Đăng nhập
                </a>
            </p>
        </div>
    </form>
@endsection
</content>
