<header class="sticky top-0 z-40 border-b border-border bg-card/95 backdrop-blur">
    <div class="mx-auto flex h-16 max-w-7xl items-center gap-4 px-4">

        <a href="{{ route('home') }}" class="flex items-center gap-2 font-semibold">
            @if ($logo = \App\Models\Setting::get('logo'))
                <img src="{{ $logo }}" alt="Logo" class="h-8 w-8 rounded lazyload" data-src="{{ $logo }}">
            @endif
            <span class="text-primary">{{ \App\Models\Setting::get('title', 'Shop Roblox') }}</span>
        </a>

        <nav class="hidden items-center gap-1 md:flex">
            <a href="{{ route('home') }}" class="rounded-md px-3 py-2 text-sm hover:bg-accent">Trang chủ</a>
            <a href="{{ route('nick-game') }}" class="rounded-md px-3 py-2 text-sm hover:bg-accent">Nick game</a>
            <a href="{{ route('warranty-policy') }}" class="rounded-md px-3 py-2 text-sm hover:bg-accent">Bảo hành</a>
            <a href="{{ route('use-bot') }}" class="rounded-md px-3 py-2 text-sm hover:bg-accent">Hướng dẫn</a>
        </nav>

        <div class="ml-auto flex items-center gap-2">
            {{-- Nút đổi sáng/tối, xử lý bởi window.toggleTheme trong app.js --}}
            <button type="button" onclick="toggleTheme()"
                    class="rounded-md border border-border p-2 text-sm hover:bg-accent"
                    aria-label="Đổi giao diện sáng/tối">
                <svg class="size-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
                </svg>
            </button>

            @auth
                <span class="badge-secondary hidden sm:inline-flex" data-balance>
                    {{ number_format((int) auth()->user()->money, 0, ',', '.') }}đ
                </span>

                <a href="{{ route('deposit') }}" class="btn-primary text-sm">Nạp tiền</a>

                {{-- Menu người dùng bằng Alpine (đã bundle, không dùng CDN) --}}
                <div class="relative" x-data="{ open: false }" @click.outside="open = false">
                    <button type="button" @click="open = !open"
                            class="rounded-md border border-border px-3 py-2 text-sm hover:bg-accent">
                        {{ Str::limit(auth()->user()->email, 18) }}
                    </button>

                    <div x-show="open" x-cloak x-transition
                         class="absolute right-0 mt-1 w-56 rounded-md border border-border bg-popover p-1 shadow-lg">
                        <a href="{{ route('profile') }}" class="block rounded px-3 py-2 text-sm hover:bg-accent">Tài khoản</a>
                        <a href="{{ route('transaction') }}" class="block rounded px-3 py-2 text-sm hover:bg-accent">Biến động số dư</a>
                        <a href="{{ route('history-nick') }}" class="block rounded px-3 py-2 text-sm hover:bg-accent">Nick đã mua</a>
                        <a href="{{ route('history-order') }}" class="block rounded px-3 py-2 text-sm hover:bg-accent">Đơn Robux</a>

                        @if (auth()->user()->isAdmin())
                            <a href="{{ route('admin.home') }}"
                               class="block rounded px-3 py-2 text-sm font-medium text-primary hover:bg-accent">Quản trị</a>
                        @endif

                        {{-- Đăng xuất bằng POST + CSRF, không dùng link GET --}}
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full rounded px-3 py-2 text-left text-sm text-destructive hover:bg-accent">
                                Đăng xuất
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="btn-outline text-sm">Đăng nhập</a>
                <a href="{{ route('register') }}" class="btn-primary text-sm">Đăng ký</a>
            @endauth
        </div>
    </div>
</header>
