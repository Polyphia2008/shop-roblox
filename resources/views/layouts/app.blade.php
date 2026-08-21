<!DOCTYPE html>
<html lang="vi" class="{{ request()->cookie('theme') === 'dark' ? 'dark' : '' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- CSRF token: app.js đọc thẻ này để gắn header cho axios --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Trang chủ') — {{ \App\Models\Setting::get('title', 'Shop Roblox') }}</title>
    <meta name="description" content="{{ \App\Models\Setting::get('description', 'Shop tài khoản Roblox') }}">

    @if ($favicon = \App\Models\Setting::get('favicon'))
        <link rel="icon" href="{{ $favicon }}">
    @endif

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-background text-foreground antialiased">

    @include('partials.header')

    <main class="mx-auto w-full max-w-7xl px-4 py-6">
        {{-- Thông báo chạy từ cấu hình admin --}}
        @if ($notice = \App\Models\Setting::get('notification'))
            <div class="alert-info mb-4">{{ $notice }}</div>
        @endif

        <x-flash />

        @yield('content')
    </main>

    @include('partials.footer')
</body>
</html>
