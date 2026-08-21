@extends('layouts.admin')
@section('title', 'Bảng điều khiển')

@section('content')
<h1 class="mb-6 text-xl font-semibold">Bảng điều khiển</h1>

{{-- ================================================================
     THẺ SỐ LIỆU
     ================================================================ --}}
@php
    $cards = [
        ['Người dùng',      number_format($stats['users']),                     $stats['users_today'].' mới hôm nay'],
        ['Nick Robux',      number_format($stats['accounts']),                  'đang bán'],
        ['Kho nick game',   number_format($stats['nicks']),                     'còn hàng'],
        ['Đơn hôm nay',     number_format($stats['orders_today']),              'đơn'],
        ['Doanh thu hôm nay', number_format($stats['revenue_today'], 0, ',', '.').'đ', 'tổng tiền đơn'],
        ['Doanh thu tháng', number_format($stats['revenue_month'], 0, ',', '.').'đ',   'tính từ đầu tháng'],
    ];
@endphp

<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
    @foreach ($cards as [$label, $value, $hint])
        <div class="card">
            <div class="card-body">
                <p class="text-sm text-muted-foreground">{{ $label }}</p>
                <p class="mt-1 text-2xl font-semibold">{{ $value }}</p>
                <p class="mt-1 text-xs text-muted-foreground">{{ $hint }}</p>
            </div>
        </div>
    @endforeach
</div>

{{-- ================================================================
     VIỆC CẦN XỬ LÝ — bấm vào là tới đúng trang xử lý
     ================================================================ --}}
<h2 class="mb-4 mt-8 text-base font-semibold">Cần xử lý</h2>

<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
    <a href="{{ route('admin.deposits.index') }}" class="card transition hover:border-primary">
        <div class="card-body">
            <p class="text-sm text-muted-foreground">Yêu cầu nạp tiền</p>
            <p class="mt-1 text-2xl font-semibold">{{ number_format($stats['deposits_open']) }}</p>
        </div>
    </a>
    <a href="{{ route('admin.deposits.index') }}" class="card transition hover:border-primary">
        <div class="card-body">
            <p class="text-sm text-muted-foreground">Thẻ chờ duyệt</p>
            <p class="mt-1 text-2xl font-semibold">{{ number_format($stats['cards_pending']) }}</p>
        </div>
    </a>
    <a href="{{ route('admin.tickets.index') }}" class="card transition hover:border-primary">
        <div class="card-body">
            <p class="text-sm text-muted-foreground">Yêu cầu bảo hành</p>
            <p class="mt-1 text-2xl font-semibold">{{ number_format($stats['tickets_open']) }}</p>
        </div>
    </a>
    <a href="{{ route('admin.users.index') }}" class="card transition hover:border-primary">
        <div class="card-body">
            <p class="text-sm text-muted-foreground">Tài khoản bị khoá</p>
            <p class="mt-1 text-2xl font-semibold">{{ number_format($stats['banned']) }}</p>
        </div>
    </a>
</div>

<div class="mt-8 grid grid-cols-1 gap-6 xl:grid-cols-2">

    {{-- ============================================================
         NHẬT KÝ TẤN CÔNG
         --------------------------------------------------------------
         Do middleware DetectSqlInjection ghi lại. Ở đây CHỈ hiện tên
         tham số và mức độ — payload đầy đủ nằm ở trang nhật ký riêng,
         và luôn được in bằng {{ }} nên payload chứa <script> cũng chỉ
         là văn bản (không self-XSS chính admin).
         ============================================================ --}}
    <div class="card overflow-hidden">
        <div class="card-header flex-row items-center justify-between">
            <h2 class="card-title">Cảnh báo bảo mật gần đây</h2>
            <a href="{{ route('admin.security-log') }}" class="btn-outline btn-sm">Xem tất cả</a>
        </div>

        @if ($securityEvents->isEmpty())
            <div class="card-body text-sm text-muted-foreground">
                Chưa ghi nhận request đáng ngờ nào.
            </div>
        @else
            <div class="table-wrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Loại</th>
                            <th>Mức độ</th>
                            <th>IP</th>
                            <th>Tham số</th>
                            <th>Thời gian</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($securityEvents as $event)
                            <tr>
                                <td class="font-medium">{{ $event->type }}</td>
                                <td>
                                    @if (in_array($event->severity, ['critical', 'high'], true))
                                        <span class="badge-destructive">{{ $event->severity }}</span>
                                    @elseif ($event->severity === 'medium')
                                        <span class="badge-warning">{{ $event->severity }}</span>
                                    @else
                                        <span class="badge-secondary">{{ $event->severity }}</span>
                                    @endif
                                </td>
                                <td class="font-mono text-xs">{{ $event->ip }}</td>
                                <td class="font-mono text-xs">{{ $event->parameter }}</td>
                                <td class="whitespace-nowrap text-muted-foreground">
                                    {{ $event->created_at?->diffForHumans() ?? '—' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- Đơn hàng mới nhất --}}
    <div class="card overflow-hidden">
        <div class="card-header flex-row items-center justify-between">
            <h2 class="card-title">Đơn hàng mới nhất</h2>
            <a href="{{ route('admin.orders.index') }}" class="btn-outline btn-sm">Xem tất cả</a>
        </div>

        @if ($recentOrders->isEmpty())
            <div class="card-body text-sm text-muted-foreground">Chưa có đơn hàng nào.</div>
        @else
            <div class="table-wrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Mã GD</th>
                            <th>Khách</th>
                            <th class="text-right">Tiền</th>
                            <th>Thời gian</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($recentOrders as $order)
                            <tr>
                                <td class="font-mono text-xs">{{ $order->magd }}</td>
                                <td>{{ Str::limit($order->username, 22) }}</td>
                                <td class="text-right whitespace-nowrap font-semibold text-primary">
                                    {{ number_format((int) $order->money, 0, ',', '.') }}đ
                                </td>
                                <td class="whitespace-nowrap text-muted-foreground">
                                    {{ $order->created_at?->format('d/m H:i') ?? '—' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
