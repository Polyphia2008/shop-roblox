@extends('layouts.app')
@section('title', 'Đơn hàng '.$order->magd)

@section('content')
<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
    <div>
        <h1 class="text-xl font-semibold">Chi tiết đơn hàng</h1>
        <p class="mt-1 font-mono text-sm text-muted-foreground">{{ $order->magd }}</p>
    </div>
    <a href="{{ route('history-nick') }}" class="btn-outline">Về lịch sử mua</a>
</div>

{{-- ================================================================
     BẢN GỐC: SELECT * FROM orders WHERE magd = '$magd'
       -> vừa SQL injection, vừa IDOR (đổi mã trên URL là xem được đơn
          của người khác).

     BẢN MỚI:
       - {magd} bị ràng buộc regex [A-Za-z0-9-]+ ngay ở tầng route.
       - Truy vấn dùng binding của Eloquent (không nối chuỗi).
       - Kèm điều kiện `username = user hiện tại` rồi firstOrFail(),
         nên đơn của người khác trả về 404 thay vì lộ dữ liệu.
     ================================================================ --}}
<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Thông tin đơn</h2>
        </div>
        <div class="card-body space-y-3 text-sm">
            <div class="flex items-center justify-between gap-2">
                <span class="text-muted-foreground">Sản phẩm</span>
                <span class="text-right font-medium">{{ $order->title }}</span>
            </div>
            <div class="flex items-center justify-between gap-2">
                <span class="text-muted-foreground">Số lượng</span>
                <span class="font-medium">{{ (int) $order->soluong }}</span>
            </div>
            <div class="flex items-center justify-between gap-2">
                <span class="text-muted-foreground">Thành tiền</span>
                <span class="font-semibold text-primary">
                    {{ number_format((int) $order->money, 0, ',', '.') }}đ
                </span>
            </div>
            <div class="flex items-center justify-between gap-2">
                <span class="text-muted-foreground">Thời gian</span>
                <span class="font-medium">
                    {{ $order->created_at?->format('d/m/Y H:i') ?? '—' }}
                </span>
            </div>
            <div class="pt-2">
                <a href="{{ route('orders.download', $order->magd) }}"
                   class="btn-secondary w-full">Tải danh sách (.txt)</a>
            </div>
        </div>
    </div>

    <div class="card overflow-hidden lg:col-span-2">
        <div class="card-header">
            <h2 class="card-title">Danh sách nick ({{ $nicks->count() }})</h2>
            <p class="text-sm text-muted-foreground">
                Chỉ chủ đơn hàng xem được nội dung này.
            </p>
        </div>

        @if ($nicks->isEmpty())
            <div class="card-body text-sm text-muted-foreground">
                Đơn này chưa có nick nào được gán.
            </div>
        @else
            <div class="table-wrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tài khoản</th>
                            <th>Chuyên mục</th>
                            <th>Ghi chú</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($nicks as $index => $nick)
                            <tr>
                                <td class="text-muted-foreground">{{ $index + 1 }}</td>
                                {{-- Escaped bằng {{ }} nên nội dung nick
                                     kể cả có <script> cũng chỉ hiện ra
                                     dưới dạng văn bản (chống XSS). --}}
                                <td class="font-mono text-xs break-all">{{ $nick->code }}</td>
                                <td>{{ $nick->chuyenmuc }}</td>
                                <td class="text-muted-foreground">{{ $nick->note }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
