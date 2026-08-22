@extends('layouts.admin')
@section('title', 'Đơn Robux')

@section('content')
<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
    <div>
        <h1 class="text-xl font-semibold">Đơn Robux</h1>
        <p class="mt-1 text-sm text-muted-foreground">{{ $orders->total() }} đơn đặt theo rate</p>
    </div>
</div>

<div class="card mb-6">
    {{-- Lọc bằng GET. `status` đi vào truy vấn dưới dạng binding, còn
         `sort`/`dir` được lọc qua allow-list ở controller vì tên cột và
         chiều sắp xếp không thể bind bằng PDO. --}}
    <form method="GET" class="card-body grid grid-cols-1 gap-4 md:grid-cols-4">
        <div>
            <label for="status" class="label mb-2 block">Trạng thái</label>
            <select id="status" name="status" class="input">
                <option value="">Tất cả</option>
                <option value="3" @selected(request()->query('status') === '3')>Đang xử lý</option>
                <option value="1" @selected(request()->query('status') === '1')>Hoàn tất</option>
                <option value="2" @selected(request()->query('status') === '2')>Đã huỷ</option>
            </select>
        </div>
        <div class="flex items-end gap-2">
            <button type="submit" class="btn-primary">Lọc</button>
            <a href="{{ route('admin.accountrb.orders') }}" class="btn-outline">Xoá lọc</a>
        </div>
    </form>
</div>

@if ($orders->isEmpty())
    <div class="card">
        <div class="card-body text-center text-muted-foreground">Chưa có đơn nào.</div>
    </div>
@else
    @php
        $toggle = fn (string $col) => request()->fullUrlWithQuery([
            'sort' => $col,
            'dir'  => ($column === $col && $direction === 'asc') ? 'desc' : 'asc',
        ]);
    @endphp

    <div class="card overflow-hidden">
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th><a href="{{ $toggle('id') }}" class="hover:text-primary">ID</a></th>
                        <th>Mã GD</th>
                        <th>Khách</th>
                        <th class="text-right">
                            <a href="{{ $toggle('robux') }}" class="hover:text-primary">Robux</a>
                        </th>
                        <th><a href="{{ $toggle('rate') }}" class="hover:text-primary">Rate</a></th>
                        <th class="text-right">
                            <a href="{{ $toggle('price') }}" class="hover:text-primary">Số tiền</a>
                        </th>
                        <th>Giao hàng</th>
                        <th>Trạng thái</th>
                        <th class="text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td class="text-muted-foreground">#{{ $order->id }}</td>
                            <td class="font-mono text-xs">{{ $order->magd }}</td>
                            <td class="break-all">{{ $order->username }}</td>
                            <td class="text-right">
                                {{ number_format((int) $order->robux, 0, ',', '.') }}
                            </td>
                            <td>{{ $order->rate }}</td>
                            <td class="text-right whitespace-nowrap font-semibold text-primary">
                                {{ number_format((int) $order->price, 0, ',', '.') }}đ
                            </td>
                            <td>{{ $order->giaohang ?: '—' }}</td>
                            <td>
                                @if ((string) $order->status === '1')
                                    <span class="badge-success">Hoàn tất</span>
                                @elseif ((string) $order->status === '2')
                                    <span class="badge-destructive">Đã huỷ</span>
                                @else
                                    <span class="badge-warning">Đang xử lý</span>
                                @endif
                            </td>
                            <td class="text-right">
                                <a href="{{ route('admin.accountrb.orders.edit', $order) }}"
                                   class="btn-outline btn-sm">Xử lý</a>
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
