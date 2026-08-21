@extends('layouts.admin')
@section('title', 'Ngân hàng')

@section('content')
<h1 class="mb-6 text-xl font-semibold">Tài khoản ngân hàng</h1>

{{-- ================================================================
     LƯU Ý VỀ TOKEN
     --------------------------------------------------------------
     `token` là API key đọc biến động số dư. Bản gốc lưu plaintext VÀ
     in thẳng ra bảng HTML admin — chỉ cần một lỗi XSS hoặc một lần
     chia sẻ màn hình là mất key.

     Nay: model Bank cast 'encrypted' (mã hoá trong DB) và view này
     KHÔNG bao giờ in giá trị token, chỉ cho biết đã cấu hình hay chưa.
     ================================================================ --}}
@if ($banks->isEmpty())
    <div class="card mb-8">
        <div class="card-body text-center text-muted-foreground">
            Chưa có tài khoản ngân hàng nào.
        </div>
    </div>
@else
    <div class="card mb-8 overflow-hidden">
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Ngân hàng</th>
                        <th>Số tài khoản</th>
                        <th>Chủ tài khoản</th>
                        <th>API token</th>
                        <th class="text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($banks as $bank)
                        <tr>
                            <td class="text-muted-foreground">{{ $bank->id }}</td>
                            <td class="font-medium">{{ $bank->short_name }}</td>
                            <td class="font-mono text-xs">{{ $bank->accountNumber }}</td>
                            <td>{{ $bank->accountName }}</td>
                            <td>
                                @if (filled($bank->token))
                                    <span class="badge-success">Đã cấu hình</span>
                                @else
                                    <span class="badge-secondary">Chưa có</span>
                                @endif
                            </td>
                            <td class="text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.banks.edit', $bank) }}"
                                       class="btn-outline btn-sm">Sửa</a>

                                    <form method="POST"
                                          action="{{ route('admin.banks.destroy', $bank) }}"
                                          onsubmit="return confirm('Xoá tài khoản {{ $bank->short_name }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-destructive btn-sm">Xoá</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endif

{{-- ================================================================ THÊM MỚI --}}
<div class="card mb-8">
    <div class="card-header">
        <h2 class="card-title">Thêm tài khoản ngân hàng</h2>
    </div>
    <form method="POST" action="{{ route('admin.banks.store') }}"
          class="card-body grid grid-cols-1 gap-4 sm:grid-cols-2">
        @csrf

        <div>
            <label for="short_name" class="label mb-2 block">Tên ngân hàng</label>
            <input id="short_name" name="short_name" type="text" maxlength="64" required
                   value="{{ old('short_name') }}" class="input" placeholder="VCB, MB, TCB...">
            @error('short_name')
                <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="accountNumber" class="label mb-2 block">Số tài khoản</label>
            {{-- Chỉ nhận chữ số (regex) và phải là duy nhất --}}
            <input id="accountNumber" name="accountNumber" type="text" inputmode="numeric"
                   maxlength="64" required value="{{ old('accountNumber') }}"
                   class="input font-mono">
            @error('accountNumber')
                <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="accountName" class="label mb-2 block">Chủ tài khoản</label>
            <input id="accountName" name="accountName" type="text" maxlength="190" required
                   value="{{ old('accountName') }}" class="input">
            @error('accountName')
                <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="logo" class="label mb-2 block">Logo (URL)</label>
            <input id="logo" name="logo" type="url" maxlength="255"
                   value="{{ old('logo') }}" class="input" placeholder="https://...">
            @error('logo')
                <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
            @enderror
        </div>

        <div class="sm:col-span-2">
            <label for="token" class="label mb-2 block">API token (không bắt buộc)</label>
            <input id="token" name="token" type="password" maxlength="2000"
                   autocomplete="new-password" class="input font-mono">
            <p class="mt-1 text-xs text-muted-foreground">
                Token được mã hoá trước khi lưu và không bao giờ hiển thị lại.
            </p>
            @error('token')
                <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
            @enderror
        </div>

        <div class="sm:col-span-2">
            <button type="submit" class="btn-primary">Thêm tài khoản</button>
        </div>
    </form>
</div>

{{-- ================================================================
     GIAO DỊCH TỰ ĐỘNG — dùng để đối soát khi khách báo đã chuyển tiền
     ================================================================ --}}
<div class="card overflow-hidden">
    <div class="card-header">
        <h2 class="card-title">Giao dịch tự động gần đây</h2>
    </div>

    @if ($recent->isEmpty())
        <div class="card-body text-sm text-muted-foreground">
            Chưa nhận được giao dịch nào từ API ngân hàng.
        </div>
    @else
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>TID</th>
                        <th>Ngân hàng</th>
                        <th class="text-right">Số tiền</th>
                        <th>Nội dung</th>
                        <th>Đã gán</th>
                        <th>Thời gian</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recent as $tx)
                        <tr>
                            <td class="font-mono text-xs break-all">{{ Str::limit($tx->tid, 18) }}</td>
                            <td>{{ $tx->bank }}</td>
                            <td class="text-right whitespace-nowrap font-semibold text-primary">
                                {{ number_format((int) $tx->amount, 0, ',', '.') }}đ
                            </td>
                            <td class="max-w-xs">{{ Str::limit($tx->description, 50) }}</td>
                            <td>
                                @if ($tx->user_id)
                                    <span class="badge-success">user #{{ $tx->user_id }}</span>
                                @else
                                    <span class="badge-warning">Chưa gán</span>
                                @endif
                            </td>
                            <td class="whitespace-nowrap text-muted-foreground">
                                {{ $tx->create_gettime ?: ($tx->created_at?->format('d/m H:i') ?? '—') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
