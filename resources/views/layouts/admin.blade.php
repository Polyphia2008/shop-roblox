<!DOCTYPE html>
<html lang="vi" class="{{ request()->cookie('theme') === 'dark' ? 'dark' : '' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- Trang quản trị không cần lên kết quả tìm kiếm --}}
    <meta name="robots" content="noindex, nofollow">

    <title>@yield('title', 'Quản trị') — {{ \App\Models\Setting::get('title', 'Shop Roblox') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-background text-foreground antialiased">

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

<div x-data="{ nav: false }" class="flex min-h-screen flex-col lg:flex-row">

    {{-- Thanh trên cùng cho mobile --}}
    <div class="flex items-center gap-3 border-b border-border bg-card px-4 py-3 lg:hidden">
        <button type="button" x-on:click="nav = !nav"
                class="rounded-md border border-border p-2" aria-label="Mở menu quản trị">
            <svg class="size-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
        <span class="font-semibold text-primary">Quản trị</span>
        <a href="{{ route('home') }}" class="ml-auto text-sm text-muted-foreground">Về shop</a>
    </div>

    {{-- Sidebar --}}
    <aside x-bind:class="nav ? 'block' : 'hidden'"
           class="w-full shrink-0 border-b border-border bg-card lg:block lg:w-64 lg:border-b-0 lg:border-r">
        <div class="flex h-full flex-col">

            <div class="hidden items-center gap-2 border-b border-border px-5 py-4 lg:flex">
                <span class="font-semibold text-primary">Quản trị</span>
            </div>

            <nav class="flex-1 space-y-6 p-3">
                @php
                    /* Helper cục bộ: tô sáng mục đang mở dựa trên tên route
                       (không dựa vào URL do người dùng gửi). */
                    $navGroups = [
                        'Tổng quan' => [
                            ['admin.home',          'Bảng điều khiển'],
                            ['admin.security-log',  'Nhật ký bảo mật'],
                        ],
                        'Kho hàng' => [
                            ['admin.accountrb.index', 'Nick Robux'],
                            ['admin.accountrb.orders','Đơn Robux'],
                            ['admin.categories.index','Chuyên mục'],
                            ['admin.nicks.index',     'Kho nick game'],
                        ],
                        'Giao dịch' => [
                            ['admin.deposits.index', 'Yêu cầu nạp tiền'],
                            ['admin.orders.index',   'Lịch sử đơn hàng'],
                            ['admin.tickets.index',  'Yêu cầu bảo hành'],
                        ],
                        'Hệ thống' => [
                            ['admin.users.index',    'Người dùng'],
                            ['admin.banks.index',    'Ngân hàng'],
                            ['admin.settings.index', 'Cấu hình'],
                        ],
                    ];
                @endphp

                @foreach ($navGroups as $group => $items)
                    <div>
                        <p class="px-3 pb-2 text-xs font-semibold uppercase tracking-wide text-muted-foreground">
                            {{ $group }}
                        </p>
                        <div class="space-y-1">
                            @foreach ($items as [$routeName, $label])
                                <a href="{{ route($routeName) }}"
                                   class="block rounded-md px-3 py-2 text-sm transition-colors
                                          {{ request()->routeIs($routeName)
                                                ? 'bg-primary text-primary-foreground font-medium'
                                                : 'hover:bg-accent' }}">
                                    {{ $label }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            </nav>

            <div class="border-t border-border p-3">
                <p class="px-3 pb-2 text-xs text-muted-foreground">
                    {{ Str::limit(auth()->user()->email, 24) }}
                </p>
                <a href="{{ route('home') }}"
                   class="block rounded-md px-3 py-2 text-sm hover:bg-accent">Về trang shop</a>

                {{-- Đăng xuất bằng POST + CSRF --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="w-full rounded-md px-3 py-2 text-left text-sm text-destructive hover:bg-accent">
                        Đăng xuất
                    </button>
                </form>
            </div>
        </div>
    </aside>

    {{-- Nội dung --}}
    <main class="min-w-0 flex-1 p-4 lg:p-6">
        <div class="mx-auto max-w-6xl">
            <x-flash />
            @yield('content')
        </div>
    </main>
</div>

</body>
</html>
