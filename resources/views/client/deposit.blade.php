@extends('layouts.app')
@section('title', 'Nạp tiền')

@section('content')
<h1 class="mb-6 text-xl font-semibold">Nạp tiền</h1>

<div class="grid grid-cols-1 gap-6 lg:grid-cols-2">

    {{-- ============================================================
         CHUYỂN KHOẢN NGÂN HÀNG
         --------------------------------------------------------------
         Form này CHỈ tạo một yêu cầu đối soát với status = '0'.
         Tiền KHÔNG được cộng ở đây — chỉ admin mới cộng, và việc cộng
         nằm trong DB::transaction() + lockForUpdate() kèm kiểm tra lại
         status sau khi khoá, nên không thể duyệt trùng.
         ============================================================ --}}
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Chuyển khoản ngân hàng</h2>
            <p class="text-sm text-muted-foreground">
                Chuyển đúng nội dung để hệ thống đối soát nhanh.
            </p>
        </div>
        <div class="card-body space-y-4">

            @if ($banks->isEmpty())
                <p class="text-sm text-muted-foreground">
                    Hiện chưa có tài khoản ngân hàng nào. Vui lòng liên hệ hỗ trợ.
                </p>
            @else
                <div class="space-y-3">
                    @foreach ($banks as $bank)
                        <div class="rounded-md border border-border p-4">
                            <div class="flex items-start gap-3">
                                @if ($bank->logo)
                                    {{-- lazysizes: ảnh chỉ tải khi vào viewport --}}
                                    <img class="lazyload h-10 w-10 rounded object-contain"
                                         data-src="{{ $bank->logo }}"
                                         alt="{{ $bank->short_name }}">
                                @endif
                                <div class="min-w-0 flex-1 space-y-1 text-sm">
                                    <p class="font-semibold">{{ $bank->short_name }}</p>
                                    <p class="break-all">
                                        Số TK:
                                        <span class="font-mono font-medium">{{ $bank->accountNumber }}</span>
                                    </p>
                                    <p>Chủ TK: <span class="font-medium">{{ $bank->accountName }}</span></p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Nội dung chuyển khoản gắn với id user, do server sinh
                     ra (NAP{id}) nên user không thể tự đặt nội dung của
                     người khác để chiếm giao dịch. --}}
                <div class="alert-info">
                    <p class="font-medium">Nội dung chuyển khoản bắt buộc</p>
                    <p class="mt-1 font-mono text-base font-semibold">{{ $transferCode }}</p>
                    <p class="mt-1 text-xs">
                        Sai nội dung có thể khiến giao dịch phải đối soát thủ công.
                    </p>
                </div>
            @endif

            <form method="POST" action="{{ route('deposit.bank') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="amount" class="label mb-2 block">Số tiền đã chuyển (đ)</label>
                    <input id="amount" name="amount" type="number" min="10000"
                           max="500000000" step="1000" required
                           value="{{ old('amount') }}" class="input" placeholder="10000">
                    @error('amount')
                        <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="note" class="label mb-2 block">Ghi chú (không bắt buộc)</label>
                    <input id="note" name="note" type="text" maxlength="255"
                           value="{{ old('note') }}" class="input"
                           placeholder="Mã giao dịch ngân hàng...">
                    @error('note')
                        <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" class="btn-primary w-full">Gửi yêu cầu đối soát</button>
            </form>
        </div>
    </div>

    {{-- ============================================================
         NẠP THẺ CÀO
         --------------------------------------------------------------
         seri/pin được model Card cast sang 'encrypted' nên lưu trong
         DB dưới dạng mã hoá — đọc được DB cũng không dùng được thẻ.
         ============================================================ --}}
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Nạp thẻ cào</h2>
            <p class="text-sm text-muted-foreground">
                Nhập đúng mệnh giá để tránh bị trừ phí sai mệnh giá.
            </p>
        </div>
        <form method="POST" action="{{ route('deposit.card') }}" class="card-body space-y-4">
            @csrf

            <div>
                <label for="loaithe" class="label mb-2 block">Loại thẻ</label>
                {{-- Danh sách này cũng là allow-list phía server
                     ('in:VIETTEL,...') nên sửa option trong DevTools
                     sẽ bị validation chặn. --}}
                <select id="loaithe" name="loaithe" required class="input">
                    @foreach (['VIETTEL', 'MOBIFONE', 'VINAPHONE', 'GARENA', 'ZING'] as $type)
                        <option value="{{ $type }}" @selected(old('loaithe') === $type)>{{ $type }}</option>
                    @endforeach
                </select>
                @error('loaithe')
                    <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="menhgia" class="label mb-2 block">Mệnh giá</label>
                <select id="menhgia" name="menhgia" required class="input">
                    @foreach ([10000, 20000, 50000, 100000, 200000, 500000] as $value)
                        <option value="{{ $value }}" @selected((int) old('menhgia') === $value)>
                            {{ number_format($value, 0, ',', '.') }}đ
                        </option>
                    @endforeach
                </select>
                @error('menhgia')
                    <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="seri" class="label mb-2 block">Số serial</label>
                <input id="seri" name="seri" type="text" maxlength="32" required
                       autocomplete="off" class="input font-mono" value="{{ old('seri') }}">
                @error('seri')
                    <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="pin" class="label mb-2 block">Mã thẻ</label>
                <input id="pin" name="pin" type="text" maxlength="32" required
                       autocomplete="off" class="input font-mono" value="{{ old('pin') }}">
                @error('pin')
                    <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="btn-primary w-full">Nạp thẻ</button>
        </form>
    </div>
</div>

{{-- ================================================================
     LỊCH SỬ — mọi truy vấn ở controller đều kèm điều kiện sở hữu
     (username / userid = user hiện tại) nên không xem được dữ liệu
     của người khác dù đổi tham số trên URL (chống IDOR).
     ================================================================ --}}
<div class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-2">

    <div class="card overflow-hidden">
        <div class="card-header">
            <h2 class="card-title">Yêu cầu chuyển khoản</h2>
        </div>
        @if ($requests->isEmpty())
            <div class="card-body text-sm text-muted-foreground">Chưa có yêu cầu nào.</div>
        @else
            <div class="table-wrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nội dung</th>
                            <th>Trạng thái</th>
                            <th>Thời gian</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($requests as $req)
                            <tr>
                                <td class="text-muted-foreground">{{ $req->id }}</td>
                                <td>{{ Str::limit($req->noidung, 50) }}</td>
                                <td>
                                    @if ($req->status === '1')
                                        <span class="badge-success">Đã duyệt</span>
                                    @elseif ($req->status === '2')
                                        <span class="badge-destructive">Từ chối</span>
                                    @else
                                        <span class="badge-warning">Chờ duyệt</span>
                                    @endif
                                </td>
                                <td class="whitespace-nowrap text-muted-foreground">
                                    {{ $req->created_at?->format('d/m/Y H:i') ?? '—' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <div class="card overflow-hidden">
        <div class="card-header">
            <h2 class="card-title">Thẻ đã nạp</h2>
        </div>
        @if ($cards->isEmpty())
            <div class="card-body text-sm text-muted-foreground">Chưa nạp thẻ nào.</div>
        @else
            <div class="table-wrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Loại</th>
                            <th>Mệnh giá</th>
                            <th>Thực nhận</th>
                            <th>Trạng thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cards as $card)
                            <tr>
                                <td class="font-medium">{{ $card->loaithe }}</td>
                                <td>{{ number_format((int) $card->menhgia, 0, ',', '.') }}đ</td>
                                <td>{{ number_format((int) $card->thucnhan, 0, ',', '.') }}đ</td>
                                <td>
                                    @if ($card->status === 'success')
                                        <span class="badge-success">Thành công</span>
                                    @elseif ($card->status === 'failed')
                                        <span class="badge-destructive">Thất bại</span>
                                    @else
                                        <span class="badge-warning">Đang xử lý</span>
                                    @endif
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
