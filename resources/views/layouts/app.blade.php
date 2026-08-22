{{--
    ==================================================================
     app.blade.php — Khung trang theo ĐÚNG theme gốc Tailwick
    ------------------------------------------------------------------
     Các thuộc tính data-* trên <html> là BẮT BUỘC: toàn bộ CSS theme
     dựa vào chúng (group-data-[sidebar=...], group-data-[mode=dark]...)
     và assets/js/layout.js đọc/ghi chúng để nhớ lựa chọn của người dùng.
     Thiếu class `group` thì mọi biến thể group-data-[] mất tác dụng.

     THỨ TỰ NẠP giữ nguyên như source cũ:
       layout.js (TRƯỚC CSS, để không nháy sáng->tối)  ->  CSS theme
       ...cuối trang: simplebar -> lucide -> popper -> tailwick -> app.js

     KHÁC BIỆT AN TOÀN so với source cũ (vẫn giữ nguyên giao diện):
       - Không còn CDN nào (jquery, sweetalert2, fancybox, fontawesome,
         swiper, googletagmanager, xlsx). Tất cả self-host -> chạy được
         dưới CSP script-src 'self' và không rò dữ liệu sang bên thứ ba.
       - Font Public Sans self-host (kèm subset tiếng Việt).
       - Mọi biến hiển thị đều qua {{ }} nên được escape -> chặn XSS.
    ==================================================================
--}}
<!DOCTYPE html>
<html lang="vi" class="light scroll-smooth group" data-layout="vertical" data-sidebar="light"
      data-sidebar-size="lg" data-mode="light" data-topbar="light" data-skin="default"
      data-navbar="sticky" data-content="fluid" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- app.js (bản Laravel) đọc thẻ này để gắn header CSRF cho axios --}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        $siteTitle = \App\Models\Setting::get('title', 'Shop Roblox');
        $siteDesc = \App\Models\Setting::get('description', 'Shop tài khoản Roblox');
        $siteCover = \App\Models\Setting::get('anhbia');
    @endphp

    <title>@yield('title', 'Trang chủ') — {{ $siteTitle }}</title>
    <meta name="description" content="{{ $siteDesc }}">
    <meta name="keywords" content="{{ \App\Models\Setting::get('keywords', '') }}">

    {{-- Open Graph / Twitter: giữ như source cũ để không mất SEO khi chuyển đổi --}}
    <meta property="og:title" content="{{ $siteTitle }}">
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:description" content="{{ $siteDesc }}">
    <meta property="og:site_name" content="{{ $siteTitle }}">
    @if ($siteCover)
        <meta property="og:image" content="{{ $siteCover }}">
        <meta name="twitter:image:src" content="{{ $siteCover }}">
    @endif
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $siteTitle }}">
    <meta name="twitter:description" content="{{ $siteDesc }}">

    @if ($favicon = \App\Models\Setting::get('favicon'))
        <link rel="icon" href="{{ $favicon }}">
    @endif

    {{-- Cấu hình layout: phải chạy TRƯỚC CSS để tránh nháy màu --}}
    <script src="{{ asset('assets/js/layout.js') }}"></script>

    {{-- Font self-host thay cho @import Google Fonts (yêu cầu của CSP) --}}
    <link rel="stylesheet" href="{{ asset('assets/css/public-sans.css') }}">

    {{-- CSS theme gốc: giữ nguyên, quyết định toàn bộ giao diện --}}
    <link rel="stylesheet" href="{{ asset('assets/css/tailwind2.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/appv2-DmMK7LU4.css') }}">

    {{-- CSS/JS của Laravel: chỉ BỔ SUNG tiện ích, không nạp lại preflight --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="text-base bg-body-bg text-body font-public dark:text-zink-100 dark:bg-zink-800 group-data-[skin=bordered]:bg-body-bordered group-data-[skin=bordered]:dark:bg-zink-700">

<div class="group-data-[sidebar-size=sm]:min-h-sm group-data-[sidebar-size=sm]:relative">

    @include('partials.sidebar')
    @include('partials.header')

    {{-- Vùng nội dung: chừa lề đúng bằng chiều rộng sidebar và chiều cao topbar --}}
    <div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-0 group-data-[layout=horizontal]:ltr:ml-0 group-data-[layout=horizontal]:rtl:mr-0 min-h-screen flex flex-col transition-all duration-300 ease-linear">

        <div class="flex-1 p-4 group-data-[content=boxed]:max-w-boxed mx-auto w-full container-fluid">

            {{-- Thông báo do admin cấu hình --}}
            @if ($notice = \App\Models\Setting::get('notification'))
                <div class="alert-info mb-4">{{ $notice }}</div>
            @endif

            <x-flash />

            @yield('content')
        </div>

        @include('partials.footer')
    </div>
</div>

{{--
    JS theme: giữ ĐÚNG thứ tự của source cũ vì phụ thuộc lẫn nhau
      simplebar -> thanh cuộn sidebar (app.js gọi tới)
      lucide    -> vẽ icon (mọi <i data-lucide>)
      popper    -> định vị dropdown
      tailwick  -> dropdown, thu/mở sidebar, đổi sáng/tối
      app.js    -> nối tất cả lại; CẦN có .app-menu trong DOM
--}}
<script src="{{ asset('assets/js/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/js/lucide.js') }}"></script>
<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/tailwick.bundle.js') }}"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>

@stack('scripts')
</body>
</html>
</content>
