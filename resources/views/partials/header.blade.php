{{--
    ==================================================================
     header.blade.php — Topbar `#page-topbar` của theme gốc Tailwick
    ------------------------------------------------------------------
     Giữ đúng cấu trúc source cũ (nav.php dòng 123+):
        header#page-topbar > .layout-width > .navbar-header
     Các id BẮT BUỘC giữ nguyên vì tailwick.bundle.js gắn sự kiện theo id:
        #topnav-hamburger-icon  -> thu/mở sidebar
        #light-dark-mode        -> đổi sáng/tối

     KHÁC BIỆT AN TOÀN so với bản cũ:
       - Đăng xuất dùng POST + @csrf (bản cũ dùng GET /auth/logout nên
         chỉ cần dụ nạn nhân mở 1 thẻ <img> là bị đăng xuất - CSRF).
       - Không còn dropdown đổi ngôn ngữ trỏ route không tồn tại.
    ==================================================================
--}}
<header id="page-topbar" class="ltr:md:left-vertical-menu rtl:md:right-vertical-menu group-data-[sidebar-size=md]:ltr:md:left-vertical-menu-md group-data-[sidebar-size=md]:rtl:md:right-vertical-menu-md group-data-[sidebar-size=sm]:ltr:md:left-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:md:right-vertical-menu-sm group-data-[layout=horizontal]:ltr:left-0 group-data-[layout=horizontal]:rtl:right-0 fixed right-0 z-[1000] left-0 print:hidden transition-all ease-linear duration-300 group-data-[navbar=hidden]:hidden group-data-[navbar=scroll]:absolute group/topbar group-data-[layout=horizontal]:z-[1004]">
    <div class="layout-width">
        <div class="flex items-center px-4 mx-auto bg-topbar border-b-2 border-topbar group-data-[topbar=dark]:bg-topbar-dark group-data-[topbar=dark]:border-topbar-dark group-data-[topbar=brand]:bg-topbar-brand group-data-[topbar=brand]:border-topbar-brand shadow-md h-header shadow-slate-200/50 group-data-[topbar=dark]:dark:bg-zink-700 group-data-[topbar=dark]:dark:border-zink-700 dark:shadow-none group-data-[layout=horizontal]:shadow-none">
            <div class="flex items-center w-full group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl navbar-header">

                {{-- Nút thu/mở sidebar --}}
                <button type="button" class="{{ config('theme.topBtn') }} group-data-[layout=horizontal]:flex group-data-[layout=horizontal]:md:hidden hamburger-icon" id="topnav-hamburger-icon">
                    <i data-lucide="chevrons-left" class="w-5 h-5 group-data-[sidebar-size=sm]:hidden"></i>
                    <i data-lucide="chevrons-right" class="hidden w-5 h-5 group-data-[sidebar-size=sm]:block"></i>
                </button>

                <div class="flex items-center gap-3 ms-auto">

                    {{-- Đổi sáng/tối: tailwick.bundle.js đặt lại [data-mode] trên <html> --}}
                    <button type="button" class="{{ config('theme.topBtn') }}" id="light-dark-mode" aria-label="Đổi giao diện sáng/tối">
                        <i data-lucide="sun" class="w-5 h-5 group-data-[mode=dark]:hidden"></i>
                        <i data-lucide="moon" class="hidden w-5 h-5 group-data-[mode=dark]:block"></i>
                    </button>

                    @auth
                        {{-- Số dư --}}
                        <div class="items-center hidden gap-2 px-3 py-1.5 rounded-md bg-slate-100 dark:bg-zink-600 sm:flex">
                            <i data-lucide="wallet" class="w-4 h-4 text-custom-500"></i>
                            <span class="text-sm font-semibold text-slate-600 dark:text-zink-100" data-balance>
                                {{ number_format((int) auth()->user()->money, 0, ',', '.') }}đ
                            </span>
                        </div>

                        <a href="{{ route('deposit') }}" class="text-white btn bg-custom-500 border-custom-500 hover:bg-custom-600 hover:border-custom-600 focus:bg-custom-600 focus:border-custom-600 h-9 px-4">
                            Nạp tiền
                        </a>

                        {{-- Dropdown người dùng (dropdown-toggle do tailwick.bundle.js xử lý) --}}
                        <div class="relative flex items-center h-header dropdown">
                            <button type="button" class="inline-flex items-center gap-2 px-2 text-topbar-item transition-all duration-200 ease-linear bg-topbar rounded-md dropdown-toggle btn hover:bg-slate-100 group-data-[topbar=dark]:dark:bg-zink-700 group-data-[topbar=dark]:dark:hover:bg-zink-600 h-9" id="userDropdown" data-bs-toggle="dropdown">
                                <i data-lucide="user" class="w-5 h-5"></i>
                                <span class="hidden text-sm md:inline">{{ Str::limit(auth()->user()->email, 18) }}</span>
                            </button>

                            <div class="absolute z-50 hidden py-2 ltr:text-left rtl:text-right bg-white rounded-md shadow-md !top-4 dropdown-menu min-w-[14rem] dark:bg-zink-600" aria-labelledby="userDropdown">
                                <a href="{{ route('profile') }}" class="{{ config('theme.ddItem') }}">
                                    <i data-lucide="user" class="inline-block w-4 h-4 me-2"></i> Tài khoản
                                </a>
                                <a href="{{ route('transaction') }}" class="{{ config('theme.ddItem') }}">
                                    <i data-lucide="arrow-left-right" class="inline-block w-4 h-4 me-2"></i> Biến động số dư
                                </a>
                                <a href="{{ route('history-nick') }}" class="{{ config('theme.ddItem') }}">
                                    <i data-lucide="gamepad-2" class="inline-block w-4 h-4 me-2"></i> Nick đã mua
                                </a>
                                <a href="{{ route('history-order') }}" class="{{ config('theme.ddItem') }}">
                                    <i data-lucide="receipt" class="inline-block w-4 h-4 me-2"></i> Đơn Robux
                                </a>

                                @if (auth()->user()->isAdmin())
                                    <a href="{{ route('admin.home') }}" class="{{ config('theme.ddItem') }} !text-custom-500">
                                        <i data-lucide="shield-check" class="inline-block w-4 h-4 me-2"></i> Quản trị
                                    </a>
                                @endif

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
                    @else
                        <a href="{{ route('login') }}" class="bg-white btn text-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 h-9 px-4 dark:bg-zink-700">
                            Đăng nhập
                        </a>
                        <a href="{{ route('register') }}" class="text-white btn bg-custom-500 border-custom-500 hover:bg-custom-600 hover:border-custom-600 h-9 px-4">
                            Đăng ký
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</header>
</content>
