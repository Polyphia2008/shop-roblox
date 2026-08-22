@extends('layouts.app')
@section('title', 'Lịch sử mua nick')

@section('content')
<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
    <h1 class="text-xl font-semibold">Lịch sử mua nick</h1>
    <span class="text-sm text-muted-foreground">{{ $orders->total() }} đơn</span>
</div>

{{-- ================================================================
     Danh sách đơn của CHÍNH user đang đăng nhập.
     Controller không nhận tham số username/id nào từ request để lọc:
     điều kiện `username = auth()->user()->email` được gắn cứng, nên
     không tồn tại đường nào để xem đơn của người khác.
     ================================================================ --}}
@if ($orders->isEmpty())
    <div class="card">
        <div class="card-body space-y-3 text-center">
            <p class="text-muted-foreground">Bạn chưa mua nick nào.</p>
            <a href="{{ route('nick-game') }}" class="btn-primary">Xem kho nick</a>
        </div>
    </div>
@else
    <div class="card overflow-hidden">
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Mã giao dịch</th>
                        <th>Sản phẩm</th>
                        <th class="text-right">Số lượng</th>
                        <th class="text-right">Thành tiền</th>
                        <th>Thời gian</th>
                        <th class="text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td class="font-mono text-xs font-medium">{{ $order->magd }}</td>
                            <td>{{ $order->title }}</td>
                            <td class="text-right">{{ (int) $order->soluong }}</td>
                            <td class="text-right whitespace-nowrap font-semibold text-primary">
                                {{ number_format((int) $order->money, 0, ',', '.') }}đ
                            </td>
                            <td class="whitespace-nowrap text-muted-foreground">
                                {{ $order->created_at?->format('d/m/Y H:i') ?? '—' }}
                            </td>
                            <td class="text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('orders.show', $order->magd) }}"
                                       class="btn-outline btn-sm">Xem</a>
                                    {{-- Tải file cũng đi qua route có kiểm tra
                                         chủ sở hữu, không phải link file tĩnh
                                         đoán được như bản gốc. --}}
                                    <a href="{{ route('orders.download', $order->magd) }}"
                                       class="btn-secondary btn-sm">Tải</a>
                                </div>
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
