@extends('layouts.admin')
@section('title', 'Yêu cầu nạp tiền')

@section('content')
<h1 class="mb-6 text-xl font-semibold">Yêu cầu nạp tiền</h1>

{{-- ================================================================
     CHỐNG DUYỆT TRÙNG (double-spend)
     --------------------------------------------------------------
     Bản gốc chạy hai câu UPDATE rời rạc, không transaction, không khoá
     bản ghi. Nếu câu thứ hai lỗi thì tiền đã cộng mà đơn vẫn "chờ" —
     admin bấm lại là cộng tiền lần thứ hai. Hai admin bấm cùng lúc
     cũng cộng nhân đôi.

     Nay mỗi lần duyệt: mở transaction -> lockForUpdate() đơn -> ĐỌC
     LẠI trạng thái sau khi khoá -> nếu đã xử lý thì ném lỗi và rollback.
     Nhờ vậy bấm nhiều lần cũng chỉ cộng đúng một lần.
     ================================================================ --}}
<div class="card mb-6">
    <form method="GET" class="card-body grid grid-cols-1 gap-4 md:grid-cols-4">
        <div>
            <label for="status" class="label mb-2 block">Trạng thái đơn</label>
            <select id="status" name="status" class="input">
                <option value="">Tất cả</option>
                <option value="0" @selected(request()->query('status') === '0')>Chờ duyệt</option>
                <option value="1" @selected(request()->query('status') === '1')>Đã duyệt</option>
                <option value="2" @selected(request()->query('status') === '2')>Từ chối</option>
            </select>
        </div>
        <div>
            <label for="card_status" class="label mb-2 block">Trạng thái thẻ</label>
            <select id="card_status" name="card_status" class="input">
                <option value="">Tất cả</option>
                <option value="pending" @selected(request()->query('card_status') === 'pending')>Đang xử lý</option>
                <option value="success" @selected(request()->query('card_status') === 'success')>Thành công</option>
                <option value="failed" @selected(request()->query('card_status') === 'failed')>Thất bại</option>
            </select>
        </div>
        <div class="flex items-end gap-2">
            <button type="submit" class="btn-primary">Lọc</button>
            <a href="{{ route('admin.deposits.index') }}" class="btn-outline">Xoá lọc</a>
        </div>
    </form>
</div>

{{-- ============================================ CHUYỂN KHOẢN ============ --}}
<h2 class="mb-4 text-base font-semibold">
    Chuyển khoản <span class="text-muted-foreground">({{ $requests->total() }})</span>
</h2>

@if ($requests->isEmpty())
    <div class="card mb-8">
        <div class="card-body text-center text-muted-foreground">Không có yêu cầu nào.</div>
    </div>
@else
    <div class="mb-8 space-y-3">
        @foreach ($requests as $req)
            <div class="card">
                <div class="card-body">
                    <div class="flex flex-wrap items-start justify-between gap-3">
                        <div class="min-w-0 space-y-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="font-semibold">Đơn #{{ $req->id }}</span>
                                @if ($req->status === '1')
                                    <span class="badge-success">Đã duyệt</span>
                                @elseif ($req->status === '2')
                                    <span class="badge-destructive">Từ chối</span>
                                @else
                                    <span class="badge-warning">Chờ duyệt</span>
                                @endif
                                <span class="text-xs text-muted-foreground">
                                    user #{{ $req->userid }} ·
                                    {{ $req->created_at?->format('d/m/Y H:i') ?? '—' }}
                                </span>
                            </div>
                            <p class="text-sm break-all">{{ $req->noidung }}</p>
                        </div>

                        {{-- Chỉ đơn đang chờ mới hiện nút. Server vẫn kiểm
                             tra lại trạng thái SAU KHI khoá bản ghi, nên
                             việc ẩn nút chỉ để gọn giao diện. --}}
                        @if ($req->status === '0')
                            <div class="flex flex-wrap items-end gap-2">
                                <form method="POST"
                                      action="{{ route('admin.deposits.approve', $req) }}"
                                      class="flex items-end gap-2">
                                    @csrf
                                    <div>
                                        <label for="amount-{{ $req->id }}"
                                               class="label mb-1 block text-xs">Số tiền cộng</label>
                                        {{-- Admin phải tự nhập số tiền đối soát
                                             được, không lấy số khách khai. --}}
                                        <input id="amount-{{ $req->id }}" name="amount"
                                               type="number" min="1000" max="500000000"
                                               step="1000" required class="input w-40">
                                    </div>
                                    <button type="submit" class="btn-primary btn-sm">Duyệt</button>
                                </form>

                                <form method="POST"
                                      action="{{ route('admin.deposits.reject', $req) }}"
                                      onsubmit="return confirm('Từ chối đơn #{{ $req->id }}?')">
                                    @csrf
                                    <button type="submit" class="btn-destructive btn-sm">Từ chối</button>
                                </form>
                            </div>
                        @endif
                    </div>

                    @error('amount')
                        <p class="mt-2 text-xs text-destructive">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        @endforeach
    </div>

    <div class="mb-8">{{ $requests->links() }}</div>
@endif

{{-- ================================================ THẺ CÀO ============= --}}
<h2 class="mb-4 text-base font-semibold">
    Thẻ cào <span class="text-muted-foreground">({{ $cards->total() }})</span>
</h2>

@if ($cards->isEmpty())
    <div class="card">
        <div class="card-body text-center text-muted-foreground">Không có thẻ nào.</div>
    </div>
@else
    <div class="space-y-3">
        @foreach ($cards as $card)
            <div class="card" x-data="{ show: false }">
                <div class="card-body space-y-3">
                    <div class="flex flex-wrap items-start justify-between gap-3">
                        <div class="min-w-0 space-y-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <span class="font-semibold">{{ $card->loaithe }}</span>
                                <span class="text-sm">
                                    {{ number_format((int) $card->menhgia, 0, ',', '.') }}đ
                                </span>
                                @if ($card->status === 'success')
                                    <span class="badge-success">Thành công</span>
                                @elseif ($card->status === 'failed')
                                    <span class="badge-destructive">Thất bại</span>
                                @else
                                    <span class="badge-warning">Đang xử lý</span>
                                @endif
                            </div>
                            <p class="text-xs text-muted-foreground break-all">
                                {{ $card->username }} ·
                                {{ $card->created_at?->format('d/m/Y H:i') ?? '—' }}
                            </p>
                        </div>

                        @if ($card->status === 'pending')
                            <form method="POST" action="{{ route('admin.cards.approve', $card) }}"
                                  class="flex items-end gap-2">
                                @csrf
                                <div>
                                    <label for="thucnhan-{{ $card->id }}"
                                           class="label mb-1 block text-xs">Thực nhận</label>
                                    <input id="thucnhan-{{ $card->id }}" name="thucnhan"
                                           type="number" min="0" max="500000000" step="1000"
                                           required class="input w-40"
                                           value="{{ (int) $card->menhgia }}">
                                </div>
                                <button type="submit" class="btn-primary btn-sm">Duyệt thẻ</button>
                            </form>
                        @endif
                    </div>

                    {{-- Seri/pin được cast 'encrypted' trong DB. Ở đây vẫn
                         mặc định che đi để không lộ khi chia sẻ màn hình. --}}
                    <div class="rounded-md border border-border bg-muted/30 p-3">
                        <div class="mb-2 flex items-center justify-between gap-2">
                            <span class="text-xs font-medium">Mã thẻ</span>
                            <button type="button" class="btn-outline btn-sm"
                                    x-on:click="show = !show"
                                    x-text="show ? 'Ẩn' : 'Hiện'">Hiện</button>
                        </div>
                        <div x-show="show" x-cloak class="space-y-1 font-mono text-xs break-all">
                            <p>Seri: {{ $card->seri }}</p>
                            <p>Pin: {{ $card->pin }}</p>
                        </div>
                        <p x-show="!show" class="font-mono text-xs text-muted-foreground">
                            ••••••••••••
                        </p>
                    </div>

                    @error('thucnhan')
                        <p class="text-xs text-destructive">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6">{{ $cards->links() }}</div>
@endif
@endsection
