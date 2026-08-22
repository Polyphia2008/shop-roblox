{{--
    ==================================================================
     auth.blade.php — Khung trang đăng nhập / đăng ký (theme gốc)
    ------------------------------------------------------------------
     Source cũ (login.php) CHỈ include header.php, KHÔNG include nav/footer
     -> trang đăng nhập không có sidebar, canh giữa trên nền hoa văn.
     Bản này giữ đúng như vậy.

     !!! KHÔNG nạp assets/js/app.js ở đây !!!
     app.js dòng 4:  document.querySelector(".app-menu").innerHTML
     Trang này không có `.app-menu` -> sẽ throw TypeError ngay khi tải,
     làm hỏng mọi JS phía sau. Source cũ cũng không nạp app.js ở đây.
     Chỉ cần lucide (vẽ icon) + tailwick (nút đổi sáng/tối).
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
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php $siteTitle = \App\Models\Setting::get('title', 'Shop Roblox'); @endphp
    <title>@yield('title', 'Đăng nhập') — {{ $siteTitle }}</title>
    <meta name="description" content="{{ \App\Models\Setting::get('description', '') }}">

    {{-- Trang đăng nhập không nên bị đánh chỉ mục --}}
    <meta name="robots" content="noindex, nofollow">

    @if ($favicon = \App\Models\Setting::get('favicon'))
        <link rel="icon" href="{{ $favicon }}">
    @endif

    <script src="{{ asset('assets/js/layout.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('assets/css/public-sans.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/tailwind2.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="flex items-center justify-center min-h-screen px-4 py-16 bg-cover bg-auth-pattern dark:bg-auth-pattern-dark dark:text-zink-100 font-public">

<div class="mb-0 border-none shadow-none xl:w-2/3 card bg-white/70 dark:bg-zink-500/70">
    <div class="grid grid-cols-1 gap-0 lg:grid-cols-12">
        <div class="lg:col-span-6">
            <div class="!px-10 !py-12 card-body">
                <a href="{{ route('home') }}" class="block mb-8">
                    @if ($logo = \App\Models\Setting::get('logo'))
                        <img src="{{ $logo }}" alt="{{ $siteTitle }}" class="h-6">
                    @else
                        <span class="text-xl font-semibold text-custom-500">{{ $siteTitle }}</span>
                    @endif
                </a>

                @yield('content')
            </div>
        </div>

        {{-- Nửa phải: chỉ trang trí, ẩn trên mobile --}}
        <div class="hidden lg:col-span-6 lg:block">
            <div class="relative h-full px-10 py-12 rounded-e-md bg-gradient-to-br from-custom-500 to-purple-500">
                <div class="absolute inset-0 bg-cover opacity-10 bg-auth-pattern"></div>
                <div class="relative flex flex-col h-full">
                    <h3 class="text-2xl font-semibold text-white">Chào mừng trở lại!</h3>
                    <p class="mt-3 text-white/70">Đăng nhập để tiếp tục mua nick game và quản lý đơn hàng của bạn.</p>
                    <div class="mt-auto text-sm text-white/70">
                        &copy; {{ date('Y') }} {{ $siteTitle }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Chỉ lucide + tailwick. Tuyệt đối không nạp app.js (xem chú thích đầu file). --}}
<script src="{{ asset('assets/js/lucide.js') }}"></script>
<script src="{{ asset('assets/js/tailwick.bundle.js') }}"></script>

@stack('scripts')
</body>
</html>
</content>
