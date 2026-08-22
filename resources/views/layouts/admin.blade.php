{{--
    ==================================================================
     admin.blade.php — Khung trang quản trị theo theme gốc Tailwick
    ------------------------------------------------------------------
     Dùng cùng bộ khung với trang người dùng (sidebar dọc .app-menu +
     topbar #page-topbar) để giao diện đồng nhất với source cũ, chỉ khác
     danh sách menu và sidebar đặt kiểu tối (data-sidebar="dark") cho
     phân biệt vùng quản trị — đúng như bản gốc.
    ==================================================================
--}}
<!DOCTYPE html>
<html lang="vi" class="light scroll-smooth group" data-layout="vertical" data-sidebar="dark"
      data-sidebar-size="lg" data-mode="light" data-topbar="light" data-skin="default"
      data-navbar="sticky" data-content="fluid" dir="ltr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Trang quản trị không cần lên kết quả tìm kiếm --}}
    <meta name="robots" content="noindex, nofollow">

    <title>@yield('title', 'Quản trị') — {{ \App\Models\Setting::get('title', 'Shop Roblox') }}</title>

    <script src="{{ asset('assets/js/layout.js') }}"></script>

    <link rel="stylesheet" href="{{ asset('assets/css/public-sans.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/tailwind2.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="text-base bg-body-bg text-body font-public dark:text-zink-100 dark:bg-zink-800 group-data-[skin=bordered]:bg-body-bordered group-data-[skin=bordered]:dark:bg-zink-700">

{{-- ==================================================================
     LƯU Ý BẢO MẬT QUAN TRỌNG
     ------------------------------------------------------------------
     Bản gốc "bảo vệ" trang admin bằng JavaScript:

         if ($user['level'] != 'admin') {
             echo '<script>location.href="/"</script>';
         }

     Đây KHÔNG phải bảo vệ — HTML đã được gửi kèm toàn bộ dữ liệu, chỉ
     cần tắt JS hoặc dùng curl là đọc được sạch. Nay quyền admin được
     kiểm tra ở tầng middleware `admin` (EnsureUserIsAdmin) TRƯỚC khi
     controller chạy, nên request không đủ quyền bị chặn từ server và
     không có byte dữ liệu nào được render.

     Các điều kiện @if bên dưới chỉ để hiển thị cho gọn, KHÔNG phải là
     lớp bảo vệ.
     ================================================================== --}}

@php
    /* Nhóm menu quản trị — tô sáng theo TÊN ROUTE (không dựa vào URL do
       người dùng gửi, tránh bị điều khiển hiển thị bằng query string). */
    $navGroups = [
        'Tổng quan' => [
            ['admin.home',           'Bảng điều khiển', 'layout-dashboard'],
            ['admin.security-log',   'Nhật ký bảo mật', 'shield-alert'],
        ],
        'Kho hàng' => [
            ['admin.accountrb.index',  'Nick Robux',    'coins'],
            ['admin.accountrb.orders', 'Đơn Robux',     'receipt'],
            ['admin.categories.index', 'Chuyên mục',    'folder-tree'],
            ['admin.nicks.index',      'Kho nick game', 'gamepad-2'],
        ],
        'Giao dịch' => [
            ['admin.deposits.index', 'Yêu cầu nạp tiền',  'wallet'],
            ['admin.orders.index',   'Lịch sử đơn hàng',  'shopping-cart'],
            ['admin.tickets.index',  'Yêu cầu bảo hành',  'life-buoy'],
        ],
        'Hệ thống' => [
            ['admin.users.index',    'Người dùng', 'users'],
            ['admin.banks.index',    'Ngân hàng',  'landmark'],
            ['admin.settings.index', 'Cấu hình',   'settings'],
        ],
    ];
@endphp

<div class="group-data-[sidebar-size=sm]:min-h-sm group-data-[sidebar-size=sm]:relative">

    {{-- Sidebar quản trị. Bắt buộc có class .app-menu vì assets/js/app.js
         dòng 4 đọc document.querySelector('.app-menu').innerHTML --}}
    <div class="app-menu w-vertical-menu bg-vertical-menu ltr:border-r rtl:border-l border-vertical-menu-border fixed bottom-0 top-0 z-[1003] transition-all duration-75 ease-linear group-data-[sidebar-size=md]:w-vertical-menu-md group-data-[sidebar-size=sm]:w-vertical-menu-sm group-data-[sidebar-size=sm]:pt-header group-data-[sidebar=dark]:bg-vertical-menu-dark group-data-[sidebar=dark]:border-vertical-menu-dark hidden md:block print:hidden group-data-[sidebar-size=sm]:absolute group-data-[sidebar=dark]:dark:bg-zink-700 group-data-[sidebar=dark]:dark:border-zink-600">

        <div class="flex items-center justify-center px-5 text-center h-header group-data-[sidebar-size=sm]:fixed group-data-[sidebar-size=sm]:top-0 group-data-[sidebar-size=sm]:bg-vertical-menu-dark group-data-[sidebar-size=sm]:z-10">
            <a href="{{ route('admin.home') }}" class="flex items-center gap-2">
                <i data-lucide="shield-check" class="w-5 h-5 text-custom-500"></i>
                {{-- Dùng biến thể `group-data-[sidebar=dark]:` vì theme CHỈ build
                     class này dưới dạng biến thể, không có bản trần
                     `text-vertical-menu-item-dark` (đã kiểm chứng trong
                     tailwind2.css). Viết trần thì chữ sẽ không có màu. --}}
                <span class="text-lg font-semibold group-data-[sidebar=dark]:text-vertical-menu-item-dark group-data-[sidebar-size=sm]:hidden">
                    Quản trị
                </span>
            </a>
        </div>

        <div id="scrollbar" class="group-data-[sidebar-size=md]:max-h-[calc(100vh_-_theme('spacing.header')_*_1.2)] group-data-[sidebar-size=lg]:max-h-[calc(100vh_-_theme('spacing.header')_*_1.2)]">
            <ul id="navbar-nav">
                @foreach ($navGroups as $group => $items)
                    {{-- Tiêu đề nhóm: dùng slate-400 (có sẵn trong theme) thay vì
                         `text-vertical-menu-item-dark/60` — theme không build sẵn
                         opacity modifier cho màu này nên `/60` sẽ vô hiệu. --}}
                    <li class="px-5 py-2 mt-2 text-xs font-semibold uppercase tracking-wide text-slate-400 group-data-[sidebar-size=sm]:hidden group-data-[sidebar-size=md]:text-center">
                        {{ $group }}
                    </li>

                    @foreach ($items as [$routeName, $label, $icon])
                        <li class="relative group/sm">
                            <a href="{{ route($routeName) }}"
                               class="{{ config('theme.lvl1Flat') }} {{ request()->routeIs($routeName) ? 'active' : '' }}">
                                <span class="{{ config('theme.iconWrap') }}">
                                    <i data-lucide="{{ $icon }}" class="{{ config('theme.iconCls') }}"></i>
                                </span>
                                <span class="{{ config('theme.labelCls') }}">{{ $label }}</span>
                            </a>
                        </li>
                    @endforeach
                @endforeach
            </ul>
        </div>
    </div>

    <div id="sidebar-overlay" class="absolute inset-0 z-[1002] bg-slate-500/30 hidden"></div>

    {{-- Topbar quản trị --}}
    <header id="page-topbar" class="ltr:md:left-vertical-menu rtl:md:right-vertical-menu group-data-[sidebar-size=md]:ltr:md:left-vertical-menu-md group-data-[sidebar-size=md]:rtl:md:right-vertical-menu-md group-data-[sidebar-size=sm]:ltr:md:left-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:md:right-vertical-menu-sm fixed right-0 z-[1000] left-0 print:hidden transition-all ease-linear duration-300 group/topbar">
        <div class="layout-width">
            <div class="flex items-center px-4 mx-auto bg-topbar border-b-2 border-topbar shadow-md h-header shadow-slate-200/50 dark:shadow-none group-data-[topbar=dark]:dark:bg-zink-700">
                <div class="flex items-center w-full navbar-header">

                    <button type="button" class="{{ config('theme.topBtn') }} hamburger-icon" id="topnav-hamburger-icon">
                        <i data-lucide="chevrons-left" class="w-5 h-5 group-data-[sidebar-size=sm]:hidden"></i>
                        <i data-lucide="chevrons-right" class="hidden w-5 h-5 group-data-[sidebar-size=sm]:block"></i>
                    </button>

                    <h5 class="hidden ml-3 text-16 md:block">@yield('title', 'Quản trị')</h5>

                    <div class="flex items-center gap-3 ms-auto">
                        <button type="button" class="{{ config('theme.topBtn') }}" id="light-dark-mode" aria-label="Đổi giao diện sáng/tối">
                            <i data-lucide="sun" class="w-5 h-5 group-data-[mode=dark]:hidden"></i>
                            <i data-lucide="moon" class="hidden w-5 h-5 group-data-[mode=dark]:block"></i>
                        </button>

                        <a href="{{ route('home') }}" class="bg-white btn text-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 h-9 px-4 dark:bg-zink-700">
                            Về trang shop
                        </a>

                        <div class="relative flex items-center h-header dropdown">
                            <button type="button" class="inline-flex items-center gap-2 px-2 text-topbar-item transition-all duration-200 ease-linear bg-topbar rounded-md dropdown-toggle btn hover:bg-slate-100 h-9" id="adminDropdown" data-bs-toggle="dropdown">
                                <i data-lucide="user" class="w-5 h-5"></i>
                                <span class="hidden text-sm md:inline">{{ Str::limit(auth()->user()->email, 20) }}</span>
                            </button>

                            <div class="absolute z-50 hidden py-2 ltr:text-left rtl:text-right bg-white rounded-md shadow-md !top-4 dropdown-menu min-w-[14rem] dark:bg-zink-600" aria-labelledby="adminDropdown">
                                <a href="{{ route('profile') }}" class="{{ config('theme.ddItem') }}">
                                    <i data-lucide="user" class="inline-block w-4 h-4 me-2"></i> Tài khoản
                                </a>

                                <hr class="my-2 border-slate-200 dark:border-zink-500">

                                {{-- Đăng xuất: POST + CSRF, không dùng link GET như bản cũ --}}
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="{{ config('theme.ddItem') }} w-full ltr:text-left rtl:text-right !text-red-500">
                                        <i data-lucide="log-out" class="inline-block w-4 h-4 me-2"></i> Đăng xuất
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    {{-- Vùng nội dung --}}
    <div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-0 min-h-screen flex flex-col transition-all duration-300 ease-linear">
        <div class="flex-1 p-4 mx-auto w-full container-fluid">
            <x-flash />
            @yield('content')
        </div>
    </div>
</div>

<script src="{{ asset('assets/js/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/js/lucide.js') }}"></script>
<script src="{{ asset('assets/js/popper.min.js') }}"></script>
<script src="{{ asset('assets/js/tailwick.bundle.js') }}"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>

@stack('scripts')
</body>
</html>
</content>
