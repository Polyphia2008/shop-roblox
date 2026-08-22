@extends('layouts.app')
@section('title', 'Biến động số dư')

@section('content')
<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
    <h1 class="text-xl font-semibold">Biến động số dư</h1>
    <span class="text-sm text-muted-foreground">{{ $flows->total() }} giao dịch</span>
</div>

{{-- ================================================================
     Bảng `dongtien` là sổ ghi kép: mỗi dòng lưu số dư trước, số tiền
     thay đổi và số dư sau. Mọi dòng đều do BalanceService ghi TRONG
     transaction cùng lúc với việc cập nhật số dư, nên sổ luôn khớp —
     bản gốc cộng/trừ tiền bằng UPDATE rời rạc nên dễ lệch khi có
     nhiều request đồng thời.

     Truy vấn ở controller kèm điều kiện `username = user hiện tại`,
     không nhận bất kỳ tham số nào từ URL để lọc, nên không thể xem
     sổ của người khác.
     ================================================================ --}}
@if ($flows->isEmpty())
    <div class="card">
        <div class="card-body text-center text-muted-foreground">
            Chưa có giao dịch nào.
        </div>
    </div>
@else
    <div class="card overflow-hidden">
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nội dung</th>
                        <th class="text-right">Số dư trước</th>
                        <th class="text-right">Thay đổi</th>
                        <th class="text-right">Số dư sau</th>
                        <th>Thời gian</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($flows as $flow)
                        @php($delta = (int) $flow->sotienthaydoi)
                        <tr>
                            <td class="text-muted-foreground">{{ $flow->id }}</td>
                            <td class="max-w-xs">{{ $flow->noidung }}</td>
                            <td class="text-right whitespace-nowrap">
                                {{ number_format((int) $flow->sotientruoc, 0, ',', '.') }}đ
                            </td>
                            <td class="text-right whitespace-nowrap font-medium
                                       {{ $delta < 0 ? 'text-destructive' : 'text-success' }}">
                                {{ $delta > 0 ? '+' : '' }}{{ number_format($delta, 0, ',', '.') }}đ
                            </td>
                            <td class="text-right whitespace-nowrap font-semibold">
                                {{ number_format((int) $flow->sotiensau, 0, ',', '.') }}đ
                            </td>
                            <td class="whitespace-nowrap text-muted-foreground">
                                {{ $flow->thoigian }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">{{ $flows->links() }}</div>
@endif
@endsection
