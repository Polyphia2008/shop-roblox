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

        {{--
            Nửa phải: chỉ trang trí, ẩn trên mobile.

            SỬA LỖI THẬT (bug #4) — xung đột gradient Tailwind 3 vs 4
            --------------------------------------------------------
            Trước đây dùng `bg-gradient-to-br from-custom-500 to-purple-500`.
            Cả tailwind2.css (theme, TW3) và bundle của ta (TW4) đều định nghĩa
            các class này, nhưng KHÁC CÚ PHÁP:
                TW3: --tw-gradient-from: #3b82f6 var(--tw-gradient-from-position)
                TW4: @property --tw-gradient-from { syntax:"<color>"; initial-value:#0000 }
            Bundle TW4 nạp sau nên thắng cascade, nhưng @property của nó ép kiểu
            `<color>`; giá trị "màu + vị trí" kiểu TW3 KHÔNG hợp kiểu -> bị loại
            -> quay về #0000. Đo trên trình duyệt:
                backgroundImage = linear-gradient(rgba(0,0,0,0), rgba(0,0,0,0))
            Gradient trong suốt hoàn toàn -> chữ trắng trên nền sáng, KHÔNG ĐỌC ĐƯỢC.

            Cách sửa: dùng class CSS thuần `.auth-hero` (định nghĩa trong
            resources/css/app.css) viết thẳng linear-gradient với ĐÚNG 2 màu của
            theme (custom-500 #3b82f6 -> purple-500 #a855f7), không phụ thuộc
            biến --tw-gradient-* nên miễn nhiễm với xung đột TW3/TW4.
        --}}
        <div class="hidden lg:col-span-6 lg:block">
            <div class="relative h-full px-10 py-12 rounded-e-md auth-hero">
                <div class="absolute inset-0 bg-cover opacity-10 bg-auth-pattern"></div>
                {{--
                    Tiêu đề cột trang trí do TỪNG TRANG tự đặt qua @section.
                    Trước đây layout ghi cứng "Chào mừng trở lại!" nên:
                      - trang đăng nhập bị LẶP tiêu đề (login.blade.php cũng có),
                      - trang đăng ký hiện SAI ngữ cảnh ("trở lại" cho người mới).
                --}}
                <div class="relative flex flex-col h-full">
                    <h3 class="text-2xl font-semibold text-white">@yield('hero_title', 'Chào mừng!')</h3>
                    <p class="mt-3 text-white/70">@yield('hero_text', 'Mua nick game và quản lý đơn hàng của bạn.')</p>
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
