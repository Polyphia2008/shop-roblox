@extends('layouts.admin')
@section('title', 'Lịch sử đơn hàng')

@section('content')
<h1 class="mb-6 text-xl font-semibold">Lịch sử đơn hàng</h1>

{{-- ================================================================
     GHI CHÚ BẢO MẬT — SẮP XẾP & TÌM KIẾM
     --------------------------------------------------------------
     1. Bản gốc: SELECT * FROM orders ORDER BY $sort $dir
        PDO KHÔNG bind được tên cột / chiều sắp xếp, nên chỗ này bắt
        buộc phải dùng ALLOW-LIST. Controller đã chạy:
            SqlInjectionGuard::column($sort, self::SORTABLE, 'id')
            SqlInjectionGuard::direction($dir, 'desc')
        View chỉ nhận lại $column/$direction ĐÃ được chuẩn hoá, nên
        các link sắp xếp bên dưới không thể mang payload vào SQL.

     2. Ô tìm kiếm chạy LIKE. Ký tự % và _ là wildcard của LIKE nên
        controller escape bằng addcslashes($kw, '%_\\') — nếu không,
        gõ "%" sẽ quét toàn bộ bảng (DoS nhẹ).

     3. Ẩn/hiện đơn dùng POST + CSRF, KHÔNG dùng link GET, để không bị
        thay đổi dữ liệu chỉ vì trình duyệt/crawler tải trước URL.
     ================================================================ --}}

@php
    /* Đảo chiều sắp xếp, giữ nguyên các tham số lọc đang có trên URL */
    $toggle = fn (string $col) => request()->fullUrlWithQuery([
        'sort' => $col,
        'dir'  => ($column === $col && $direction === 'asc') ? 'desc' : 'asc',
    ]);

    $arrow = fn (string $col) => $column === $col ? ($direction === 'asc' ? '▲' : '▼') : '';
@endphp

<div class="card mb-6">
    <form method="GET" class="card-body grid grid-cols-1 gap-4 md:grid-cols-5">
        <div class="md:col-span-2">
            <label for="keyword" class="label mb-2 block">Mã giao dịch / tài khoản</label>
            <input id="keyword" name="keyword" value="{{ request()->query('keyword') }}"
                   class="input" maxlength="100" placeholder="Nhập mã GD hoặc email khách">
        </div>
        <div>
            <label for="type" class="label mb-2 block">Loại đơn</label>
            <input id="type" name="type" value="{{ request()->query('type') }}"
                   class="input" maxlength="64" placeholder="VD: nick, robux…">
        </div>
        <div>
            <label for="from" class="label mb-2 block">Từ ngày</label>
            <input id="from" name="from" type="date" value="{{ request()->query('from') }}" class="input">
        </div>
        <div>
            <label for="to" class="label mb-2 block">Đến ngày</label>
            <input id="to" name="to" type="date" value="{{ request()->query('to') }}" class="input">
        </div>

        <div class="flex items-end gap-2 md:col-span-5">
            {{-- Giữ lại thứ tự sắp xếp khi lọc lại --}}
            <input type="hidden" name="sort" value="{{ $column }}">
            <input type="hidden" name="dir" value="{{ $direction }}">
            <button type="submit" class="btn-primary">Lọc</button>
            <a href="{{ route('admin.orders.index') }}" class="btn-outline">Xoá lọc</a>
        </div>
    </form>
</div>

<div class="mb-4 grid grid-cols-1 gap-4 sm:grid-cols-2">
    <div class="card">
        <div class="card-body">
            <p class="label">Số đơn khớp điều kiện</p>
            <p class="mt-1 text-2xl font-semibold">{{ number_format($orders->total()) }}</p>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            <p class="label">Tổng tiền (trang hiện tại)</p>
            <p class="mt-1 text-2xl font-semibold text-primary">{{ number_format($total) }}đ</p>
            <p class="mt-1 text-xs text-muted-foreground">
                Chỉ tính các đơn đang hiển thị ở trang này.
            </p>
        </div>
    </div>
</div>

@if ($orders->isEmpty())
    <div class="card">
        <div class="card-body text-center text-muted-foreground">Không có đơn hàng nào khớp điều kiện.</div>
    </div>
@else
    <div class="card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead class="border-b border-border bg-muted/50 text-left">
                    <tr>
                        <th class="px-4 py-3 font-medium">
                            <a href="{{ $toggle('id') }}" class="hover:text-primary">ID {{ $arrow('id') }}</a>
                        </th>
                        <th class="px-4 py-3 font-medium">Mã GD</th>
                        <th class="px-4 py-3 font-medium">Nội dung</th>
                        <th class="px-4 py-3 font-medium">Khách</th>
                        <th class="px-4 py-3 font-medium">
                            <a href="{{ $toggle('soluong') }}" class="hover:text-primary">SL {{ $arrow('soluong') }}</a>
                        </th>
                        <th class="px-4 py-3 font-medium">
                            <a href="{{ $toggle('money') }}" class="hover:text-primary">Số tiền {{ $arrow('money') }}</a>
                        </th>
                        <th class="px-4 py-3 font-medium">Loại</th>
                        <th class="px-4 py-3 font-medium">
                            <a href="{{ $toggle('created_at') }}" class="hover:text-primary">
                                Thời gian {{ $arrow('created_at') }}
                            </a>
                        </th>
                        <th class="px-4 py-3 text-right font-medium">Hiển thị</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-border">
                    @foreach ($orders as $order)
                        <tr class="{{ $order->display === 'hide' ? 'opacity-60' : '' }}">
                            <td class="px-4 py-3 font-mono text-xs">#{{ $order->id }}</td>
                            <td class="px-4 py-3 font-mono text-xs">{{ $order->magd ?: '—' }}</td>
                            <td class="max-w-xs truncate px-4 py-3" title="{{ $order->title }}">
                                {{ $order->title ?: '—' }}
                            </td>
                            <td class="px-4 py-3">{{ $order->username ?: '—' }}</td>
                            <td class="px-4 py-3">{{ number_format((int) $order->soluong) }}</td>
                            <td class="px-4 py-3 font-medium text-primary">
                                {{ number_format((int) $order->money) }}đ
                            </td>
                            <td class="px-4 py-3">
                                @if ($order->type)
                                    <span class="badge-secondary">{{ $order->type }}</span>
                                @else
                                    —
                                @endif
                            </td>
                            <td class="px-4 py-3 text-muted-foreground">
                                {{ optional($order->created_at)->format('d/m/Y H:i') ?? '—' }}
                            </td>
                            <td class="px-4 py-3 text-right">
                                {{-- Ẩn đơn chỉ đổi cờ `display`, KHÔNG xoá dữ liệu, để còn đối soát sổ sách --}}
                                <form method="POST" action="{{ route('admin.orders.toggle', $order) }}"
                                      class="inline">
                                    @csrf
                                    <button type="submit"
                                            class="{{ $order->display === 'hide' ? 'btn-primary' : 'btn-outline' }} btn-sm">
                                        {{ $order->display === 'hide' ? 'Đang ẩn — Hiện lại' : 'Đang hiện — Ẩn' }}
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">{{ $orders->links() }}</div>
@endif
@endsection
