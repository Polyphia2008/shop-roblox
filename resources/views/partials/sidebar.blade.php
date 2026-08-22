{{--
    ==================================================================
     sidebar.blade.php — Menu dọc `.app-menu` của theme gốc Tailwick
    ------------------------------------------------------------------
     Giữ đúng cấu trúc và class của source cũ (nav.php):
        .app-menu > logo(h-header) > #scrollbar > ul#navbar-nav

     BẮT BUỘC có class `.app-menu`: assets/js/app.js dòng 4 gọi
        document.querySelector(".app-menu").innerHTML
     -> thiếu phần tử này là JS throw ngay, cả trang mất tương tác.

     Menu dựng theo quyền: khách chỉ thấy mục công khai; mục cần đăng
     nhập và mục Quản trị được lọc ở TẦNG SERVER (@auth / @if isAdmin),
     không phải ẩn bằng CSS như bản cũ.
    ==================================================================
--}}
@php
    $siteTitle = \App\Models\Setting::get('title', 'Shop Roblox');
    $logo = \App\Models\Setting::get('logo');
@endphp

<div class="app-menu w-vertical-menu bg-vertical-menu ltr:border-r rtl:border-l border-vertical-menu-border fixed bottom-0 top-0 z-[1003] transition-all duration-75 ease-linear group-data-[sidebar-size=md]:w-vertical-menu-md group-data-[sidebar-size=sm]:w-vertical-menu-sm group-data-[sidebar-size=sm]:pt-header group-data-[sidebar=dark]:bg-vertical-menu-dark group-data-[sidebar=dark]:border-vertical-menu-dark group-data-[sidebar=brand]:bg-vertical-menu-brand group-data-[sidebar=brand]:border-vertical-menu-brand group-data-[layout=horizontal]:w-full group-data-[layout=horizontal]:bottom-auto group-data-[layout=horizontal]:top-header hidden md:block print:hidden group-data-[sidebar-size=sm]:absolute group-data-[layout=horizontal]:dark:bg-zink-700 group-data-[layout=horizontal]:border-t group-data-[layout=horizontal]:dark:border-zink-500 group-data-[layout=horizontal]:border-r-0 group-data-[sidebar=dark]:dark:bg-zink-700 group-data-[sidebar=dark]:dark:border-zink-600">

    {{-- Logo: cao đúng chiều cao topbar để hai khối thẳng hàng --}}
    <div class="flex items-center justify-center px-5 text-center h-header group-data-[layout=horizontal]:hidden group-data-[sidebar-size=sm]:fixed group-data-[sidebar-size=sm]:top-0 group-data-[sidebar-size=sm]:bg-vertical-menu group-data-[sidebar-size=sm]:z-10">
        <a href="{{ route('home') }}" class="flex items-center gap-2">
            @if ($logo)
                <img src="{{ $logo }}" alt="{{ $siteTitle }}" class="h-6 mx-auto">
            @endif
            <span class="text-lg font-semibold text-vertical-menu-item group-data-[sidebar-size=sm]:hidden group-data-[sidebar=dark]:text-vertical-menu-item-dark dark:text-zink-100">
                {{ $siteTitle }}
            </span>
        </a>
    </div>

    <div id="scrollbar" class="group-data-[sidebar-size=md]:max-h-[calc(100vh_-_theme('spacing.header')_*_1.2)] group-data-[sidebar-size=lg]:max-h-[calc(100vh_-_theme('spacing.header')_*_1.2)] group-data-[layout=horizontal]:max-h-max">
        <ul class="group-data-[layout=horizontal]:flex group-data-[layout=horizontal]:flex-col group-data-[layout=horizontal]:md:flex-row" id="navbar-nav">

            {{-- Tài khoản: chỉ hiện khi đã đăng nhập --}}
            @auth
                @php $accActive = request()->routeIs('profile', 'transaction', 'history-order'); @endphp
                <li class="relative group-data-[layout=horizontal]:shrink-0 group/sm">
                    <a href="#!" class="{{ config('theme.lvl1') }} {{ $accActive ? 'active show' : '' }}">
                        <span class="{{ config('theme.iconWrap') }}">
                            <i data-lucide="user-circle" class="{{ config('theme.iconCls') }}"></i>
                        </span>
                        <span class="{{ config('theme.labelCls') }}">Tài khoản</span>
                    </a>
                    <div class="{{ config('theme.ddWrap') }} {{ $accActive ? '!block' : '' }}">
                        <ul class="{{ config('theme.ddList') }}">
                            <li>
                                <a href="{{ route('profile') }}" class="{{ config('theme.lvl2') }} {{ request()->routeIs('profile') ? 'active' : '' }}">Thông tin</a>
                            </li>
                            <li>
                                <a href="{{ route('history-order') }}" class="{{ config('theme.lvl2') }} {{ request()->routeIs('history-order') ? 'active' : '' }}">Lịch sử mua</a>
                            </li>
                            <li>
                                <a href="{{ route('transaction') }}" class="{{ config('theme.lvl2') }} {{ request()->routeIs('transaction') ? 'active' : '' }}">Biến động số dư</a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endauth

            {{-- Nick Game --}}
            @php $nickActive = request()->routeIs('nick-game', 'history-nick'); @endphp
            <li class="relative group-data-[layout=horizontal]:shrink-0 group/sm">
                <a href="#!" class="{{ config('theme.lvl1') }} {{ $nickActive ? 'active show' : '' }}">
                    <span class="{{ config('theme.iconWrap') }}">
                        <i data-lucide="gamepad-2" class="{{ config('theme.iconCls') }}"></i>
                    </span>
                    <span class="{{ config('theme.labelCls') }}">Nick Game</span>
                </a>
                <div class="{{ config('theme.ddWrap') }} {{ $nickActive ? '!block' : '' }}">
                    <ul class="{{ config('theme.ddList') }}">
                        <li>
                            <a href="{{ route('nick-game') }}" class="{{ config('theme.lvl2') }} {{ request()->routeIs('nick-game') ? 'active' : '' }}">Mua nick game</a>
                        </li>
                        @auth
                            <li>
                                <a href="{{ route('history-nick') }}" class="{{ config('theme.lvl2') }} {{ request()->routeIs('history-nick') ? 'active' : '' }}">Nick đã mua</a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </li>

            {{-- Nạp tiền --}}
            @auth
                <li class="relative group-data-[layout=horizontal]:shrink-0 group/sm">
                    <a href="{{ route('deposit') }}" class="{{ config('theme.lvl1Flat') }} {{ request()->routeIs('deposit*') ? 'active' : '' }}">
                        <span class="{{ config('theme.iconWrap') }}">
                            <i data-lucide="wallet" class="{{ config('theme.iconCls') }}"></i>
                        </span>
                        <span class="{{ config('theme.labelCls') }}">Nạp tiền</span>
                    </a>
                </li>
            @endauth

            {{-- Hướng dẫn --}}
            @php $guideActive = request()->routeIs('use-bot', 'use-report', 'warranty-policy', '2fa'); @endphp
            <li class="relative group-data-[layout=horizontal]:shrink-0 group/sm">
                <a href="#!" class="{{ config('theme.lvl1') }} {{ $guideActive ? 'active show' : '' }}">
                    <span class="{{ config('theme.iconWrap') }}">
                        <i data-lucide="book-open" class="{{ config('theme.iconCls') }}"></i>
                    </span>
                    <span class="{{ config('theme.labelCls') }}">Hướng dẫn</span>
                </a>
                <div class="{{ config('theme.ddWrap') }} {{ $guideActive ? '!block' : '' }}">
                    <ul class="{{ config('theme.ddList') }}">
                        <li>
                            <a href="{{ route('use-bot') }}" class="{{ config('theme.lvl2') }} {{ request()->routeIs('use-bot') ? 'active' : '' }}">Dùng bot</a>
                        </li>
                        <li>
                            <a href="{{ route('use-report') }}" class="{{ config('theme.lvl2') }} {{ request()->routeIs('use-report') ? 'active' : '' }}">Báo cáo</a>
                        </li>
                        <li>
                            <a href="{{ route('warranty-policy') }}" class="{{ config('theme.lvl2') }} {{ request()->routeIs('warranty-policy') ? 'active' : '' }}">Bảo hành</a>
                        </li>
                        <li>
                            <a href="{{ route('2fa') }}" class="{{ config('theme.lvl2') }} {{ request()->routeIs('2fa') ? 'active' : '' }}">Bảo mật 2FA</a>
                        </li>
                    </ul>
                </div>
            </li>

            {{-- Quản trị: kiểm tra quyền ở server, không chỉ ẩn link --}}
            @auth
                @if (auth()->user()->isAdmin())
                    <li class="relative group-data-[layout=horizontal]:shrink-0 group/sm">
                        <a href="{{ route('admin.home') }}" class="{{ config('theme.lvl1Flat') }}">
                            <span class="{{ config('theme.iconWrap') }}">
                                <i data-lucide="shield-check" class="{{ config('theme.iconCls') }}"></i>
                            </span>
                            <span class="{{ config('theme.labelCls') }}">Quản trị</span>
                        </a>
                    </li>
                @endif
            @endauth
        </ul>
    </div>
</div>

{{-- Lớp phủ khi mở sidebar trên mobile (tailwick.bundle.js điều khiển) --}}
<div id="sidebar-overlay" class="absolute inset-0 z-[1002] bg-slate-500/30 hidden"></div>
</content>
