@extends('layouts.admin')
@section('title', 'Ticket bảo hành')

@section('content')
<h1 class="mb-6 text-xl font-semibold">Ticket bảo hành</h1>

{{-- ================================================================
     GHI CHÚ BẢO MẬT
     --------------------------------------------------------------
     1. Bản gốc lọc bằng: WHERE status = '" . $_GET['status'] . "'
        -> inject trực tiếp. Nay controller ép giá trị về đúng một
        trong '0'/'1'/'2' trước khi đưa vào truy vấn tham số hoá.

     2. Hoàn tiền bảo hành bản gốc là UPDATE money trực tiếp, không
        transaction, không ghi log. Nay đi qua BalanceService::refund()
        (transaction + lockForUpdate + ghi sổ kép).

     3. Duyệt ticket khoá bản ghi rồi ĐỌC LẠI status -> bấm nhiều lần
        hoặc hai admin bấm cùng lúc cũng chỉ hoàn tiền đúng một lần.

     4. `lydo` do khách nhập nên luôn in bằng {{ }} (escape) — không
        bao giờ dùng {!! !!} kể cả trong trang admin.
     ================================================================ --}}

<div class="card mb-6">
    <form method="GET" class="card-body grid grid-cols-1 gap-4 md:grid-cols-4">
        <div>
            <label for="status" class="label mb-2 block">Trạng thái</label>
            <select id="status" name="status" class="input">
                <option value="">Tất cả</option>
                <option value="0" @selected(request()->query('status') === '0')>Chờ xử lý</option>
                <option value="1" @selected(request()->query('status') === '1')>Đã duyệt</option>
                <option value="2" @selected(request()->query('status') === '2')>Từ chối</option>
            </select>
        </div>
        <div>
            <label for="type" class="label mb-2 block">Loại ticket</label>
            <input id="type" name="type" value="{{ request()->query('type') }}"
                   class="input" maxlength="64" placeholder="VD: nick, robux…">
        </div>
        <div class="flex items-end gap-2">
            <button type="submit" class="btn-primary">Lọc</button>
            <a href="{{ route('admin.tickets.index') }}" class="btn-outline">Xoá lọc</a>
        </div>
    </form>
</div>

<p class="mb-4 text-sm text-muted-foreground">
    Tổng: <span class="font-semibold text-foreground">{{ number_format($tickets->total()) }}</span> ticket
</p>

@if ($tickets->isEmpty())
    <div class="card">
        <div class="card-body text-center text-muted-foreground">Không có ticket nào.</div>
    </div>
@else
    <div class="space-y-3">
        @foreach ($tickets as $ticket)
            @php $account = $accounts->get((int) $ticket->nickrb); @endphp

            <div class="card" x-data="{ open: {{ $ticket->status === '0' ? 'true' : 'false' }} }">
                <div class="card-body">
                    <div class="flex flex-wrap items-start justify-between gap-3">
                        <div class="min-w-0 space-y-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="font-semibold">Ticket #{{ $ticket->id }}</span>

                                @if ($ticket->status === '1')
                                    <span class="badge-success">Đã duyệt</span>
                                @elseif ($ticket->status === '2')
                                    <span class="badge-destructive">Từ chối</span>
                                @else
                                    <span class="badge-warning">Chờ xử lý</span>
                                @endif

                                @if ($ticket->type)
                                    <span class="badge">{{ $ticket->type }}</span>
                                @endif
                            </div>

                            <p class="text-sm text-muted-foreground">
                                Dịch vụ: <span class="text-foreground">{{ $ticket->dichvu ?: '—' }}</span>
                                &middot; Gửi lúc {{ optional($ticket->created_at)->format('d/m/Y H:i') ?? '—' }}
                            </p>

                            {{-- Thông tin nick nạp kèm (keyBy) để tránh N+1 query --}}
                            @if ($account)
                                <p class="text-sm text-muted-foreground">
                                    Nick #{{ $account->id }}
                                    &middot; Chủ đơn: <span class="text-foreground">{{ $account->username }}</span>
                                    &middot; {{ number_format((int) $account->robux) }} Robux
                                    &middot; Giá bán {{ number_format((int) $account->price) }}đ
                                    @if ($account->magd)
                                        &middot; Mã GD {{ $account->magd }}
                                    @endif
                                </p>
                            @elseif ($ticket->nickrb)
                                <p class="text-sm text-destructive">
                                    Không tìm thấy nick #{{ $ticket->nickrb }} (có thể đã bị xoá).
                                </p>
                            @endif
                        </div>

                        <div class="flex shrink-0 items-center gap-2">
                            @if ($ticket->status === '0')
                                <button type="button" class="btn-outline btn-sm" @click="open = !open"
                                        x-text="open ? 'Ẩn' : 'Xử lý'">Xử lý</button>
                            @endif

                            {{-- Xoá dùng DELETE + CSRF, không dùng link GET --}}
                            <form method="POST" action="{{ route('admin.tickets.destroy', $ticket) }}"
                                  onsubmit="return confirm('Xoá ticket #{{ $ticket->id }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-destructive btn-sm">Xoá</button>
                            </form>
                        </div>
                    </div>

                    {{-- Nội dung khách khai báo: escape tuyệt đối --}}
                    @if ($ticket->lydo)
                        <div class="mt-3 rounded-md border border-border bg-muted/40 p-3">
                            <p class="label mb-1">Lý do / nội dung khiếu nại</p>
                            <pre class="whitespace-pre-wrap break-words font-mono text-xs">{{ $ticket->lydo }}</pre>
                        </div>
                    @endif

                    {{-- =================== FORM XỬ LÝ =================== --}}
                    @if ($ticket->status === '0')
                        <form method="POST" action="{{ route('admin.tickets.resolve', $ticket) }}"
                              x-show="open" x-cloak class="mt-4 border-t border-border pt-4">
                            @csrf

                            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                                <div>
                                    <label for="refund-{{ $ticket->id }}" class="label mb-2 block">
                                        Số tiền hoàn (đ)
                                    </label>
                                    <input id="refund-{{ $ticket->id }}" name="refund" type="number"
                                           min="0" max="1000000000" step="1" value="0" class="input">
                                    <p class="mt-1 text-xs text-muted-foreground">
                                        Để 0 nếu duyệt mà không hoàn tiền. Admin tự nhập số đã đối soát,
                                        hệ thống không lấy số tiền do khách gửi lên.
                                    </p>
                                </div>

                                <div class="md:col-span-2">
                                    <label for="note-{{ $ticket->id }}" class="label mb-2 block">
                                        Ghi chú xử lý
                                    </label>
                                    <textarea id="note-{{ $ticket->id }}" name="note" rows="3"
                                              maxlength="1000" class="input"
                                              placeholder="Nội dung này được ghi kèm vào ticket."></textarea>
                                </div>
                            </div>

                            <div class="mt-4 flex flex-wrap gap-2">
                                <button type="submit" name="action" value="approve" class="btn-primary"
                                        onclick="return confirm('Duyệt ticket #{{ $ticket->id }} và hoàn tiền theo số đã nhập?');">
                                    Duyệt &amp; hoàn tiền
                                </button>
                                <button type="submit" name="action" value="reject" class="btn-outline"
                                        onclick="return confirm('Từ chối ticket #{{ $ticket->id }}?');">
                                    Từ chối
                                </button>
                            </div>

                            <p class="mt-3 text-xs text-muted-foreground">
                                Khi duyệt kèm hoàn tiền, nick sẽ được chuyển sang trạng thái
                                <span class="font-medium">đang bảo hành</span> và giao dịch hoàn tiền
                                được ghi vào sổ quỹ của khách.
                            </p>
                        </form>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6">{{ $tickets->links() }}</div>
@endif
@endsection
