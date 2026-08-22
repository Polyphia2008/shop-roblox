@extends('layouts.app')
@section('title', 'Nick Robux đã mua')

@section('content')
<h1 class="mb-6 text-xl font-semibold">Nick Robux đã mua</h1>

{{-- ================================================================
     Thông tin đăng nhập của nick (trường `information`) được model
     AccountRb cast sang 'encrypted': lưu mã hoá trong DB, chỉ giải mã
     khi render cho đúng chủ sở hữu. Bản gốc lưu plaintext nên chỉ cần
     một lỗi SQLi là lộ toàn bộ kho nick.
     ================================================================ --}}
<div class="mb-4 flex flex-wrap items-center justify-between gap-3">
    <h2 class="text-base font-semibold">Tài khoản của bạn</h2>
    <span class="text-sm text-muted-foreground">{{ $accounts->total() }} nick</span>
</div>

@if ($accounts->isEmpty())
    <div class="card">
        <div class="card-body space-y-3 text-center">
            <p class="text-muted-foreground">Bạn chưa mua nick Robux nào.</p>
            <a href="{{ route('home') }}" class="btn-primary">Xem nick Robux</a>
        </div>
    </div>
@else
    <div class="space-y-4">
        @foreach ($accounts as $account)
            <div class="card" x-data="{ show: false, report: false }">
                <div class="card-body space-y-4">

                    <div class="flex flex-wrap items-start justify-between gap-3">
                        <div class="space-y-1">
                            <p class="font-semibold">Nick #{{ $account->id }}</p>
                            <p class="text-sm text-muted-foreground">
                                {{ number_format((int) $account->robux, 0, ',', '.') }} Robux ·
                                Rate {{ $account->rate }} ·
                                Bảo hành {{ $account->guarantee ?: '—' }}
                            </p>
                            <p class="text-xs text-muted-foreground">
                                Mã GD: <span class="font-mono">{{ $account->magd }}</span>
                            </p>
                        </div>

                        <div class="text-right">
                            @if ($account->status === \App\Models\AccountRb::STATUS_WARRANTY)
                                <span class="badge-warning">Đang bảo hành</span>
                            @else
                                <span class="badge-success">Đã sở hữu</span>
                            @endif
                            <p class="mt-1 font-semibold text-primary">
                                {{ number_format((int) $account->price, 0, ',', '.') }}đ
                            </p>
                        </div>
                    </div>

                    {{-- Ẩn/hiện thông tin đăng nhập để tránh lộ khi
                         chia sẻ màn hình. Toggle bằng Alpine, dữ liệu
                         chỉ được server gửi cho chủ sở hữu. --}}
                    <div class="rounded-md border border-border bg-muted/30 p-4">
                        <div class="mb-2 flex items-center justify-between gap-2">
                            <span class="text-sm font-medium">Thông tin đăng nhập</span>
                            <button type="button" class="btn-outline btn-sm"
                                    x-on:click="show = !show"
                                    x-text="show ? 'Ẩn' : 'Hiện'">Hiện</button>
                        </div>
                        <pre x-show="show" x-cloak
                             class="overflow-x-auto whitespace-pre-wrap break-all font-mono text-xs"
                        >{{ $account->information }}</pre>
                        <p x-show="!show" class="font-mono text-xs text-muted-foreground">
                            ••••••••••••••••
                        </p>
                    </div>

                    {{-- Gửi yêu cầu bảo hành. Chỉ gửi account_id;
                         server tự kiểm tra nick có thuộc user này không
                         (chống báo cáo nick của người khác). --}}
                    <div>
                        <button type="button" class="btn-outline btn-sm"
                                x-on:click="report = !report">
                            Yêu cầu bảo hành / hỗ trợ
                        </button>

                        <form x-show="report" x-cloak method="POST"
                              action="{{ route('tickets.store') }}"
                              class="mt-4 space-y-3 border-t border-border pt-4">
                            @csrf
                            <input type="hidden" name="account_id" value="{{ $account->id }}">

                            <div>
                                <label for="dichvu-{{ $account->id }}" class="label mb-2 block">
                                    Loại yêu cầu
                                </label>
                                <select id="dichvu-{{ $account->id }}" name="dichvu"
                                        required class="input">
                                    <option value="baohanh">Bảo hành nick</option>
                                    <option value="doipass">Đổi mật khẩu</option>
                                    <option value="khac">Khác</option>
                                </select>
                            </div>

                            <div>
                                <label for="lydo-{{ $account->id }}" class="label mb-2 block">
                                    Mô tả vấn đề
                                </label>
                                <textarea id="lydo-{{ $account->id }}" name="lydo" rows="3"
                                          minlength="10" maxlength="1000" required class="input h-auto"
                                          placeholder="Mô tả chi tiết ít nhất 10 ký tự..."></textarea>
                            </div>

                            <button type="submit" class="btn-primary btn-sm">Gửi yêu cầu</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6">{{ $accounts->links() }}</div>
@endif

{{-- ================================================================
     Đơn đặt mua theo rate (bảng accountorder) — phân trang riêng bằng
     pageName 'order_page' nên hai bảng không đạp trang của nhau.
     ================================================================ --}}
<h2 class="mb-4 mt-10 text-base font-semibold">Đơn đặt theo rate</h2>

@if ($orders->isEmpty())
    <div class="card">
        <div class="card-body text-center text-muted-foreground">Chưa có đơn đặt nào.</div>
    </div>
@else
    <div class="card overflow-hidden">
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Mã GD</th>
                        <th class="text-right">Robux</th>
                        <th>Rate</th>
                        <th class="text-right">Số tiền</th>
                        <th>Giao hàng</th>
                        <th>Trạng thái</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($orders as $order)
                        <tr>
                            <td class="font-mono text-xs">{{ $order->magd }}</td>
                            <td class="text-right">
                                {{ number_format((int) $order->robux, 0, ',', '.') }}
                            </td>
                            <td>{{ $order->rate }}</td>
                            <td class="text-right whitespace-nowrap font-semibold text-primary">
                                {{ number_format((int) $order->price, 0, ',', '.') }}đ
                            </td>
                            <td>{{ $order->giaohang ?: '—' }}</td>
                            <td>
                                @if ($order->status === '1')
                                    <span class="badge-success">Hoàn tất</span>
                                @elseif ($order->status === '2')
                                    <span class="badge-destructive">Đã huỷ</span>
                                @else
                                    <span class="badge-warning">Đang xử lý</span>
                                @endif
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
