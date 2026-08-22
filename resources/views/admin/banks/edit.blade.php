@extends('layouts.admin')
@section('title', 'Sửa ngân hàng #'.$bank->id)

@section('content')
<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
    <div>
        <h1 class="text-xl font-semibold">Sửa tài khoản ngân hàng</h1>
        <p class="mt-1 text-sm text-muted-foreground">
            {{ $bank->short_name }} · <span class="font-mono">{{ $bank->accountNumber }}</span>
        </p>
    </div>
    <a href="{{ route('admin.banks.index') }}" class="btn-outline">Về danh sách</a>
</div>

<form method="POST" action="{{ route('admin.banks.update', $bank) }}"
      class="max-w-2xl space-y-6">
    @csrf
    @method('PATCH')

    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Thông tin tài khoản</h2>
        </div>
        <div class="card-body grid grid-cols-1 gap-4 sm:grid-cols-2">

            <div>
                <label for="short_name" class="label mb-2 block">Tên ngân hàng</label>
                <input id="short_name" name="short_name" type="text" maxlength="64" required
                       value="{{ old('short_name', $bank->short_name) }}" class="input">
                @error('short_name')
                    <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="accountNumber" class="label mb-2 block">Số tài khoản</label>
                <input id="accountNumber" name="accountNumber" type="text" inputmode="numeric"
                       maxlength="64" required
                       value="{{ old('accountNumber', $bank->accountNumber) }}"
                       class="input font-mono">
                @error('accountNumber')
                    <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="accountName" class="label mb-2 block">Chủ tài khoản</label>
                <input id="accountName" name="accountName" type="text" maxlength="190" required
                       value="{{ old('accountName', $bank->accountName) }}" class="input">
                @error('accountName')
                    <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="logo" class="label mb-2 block">Logo (URL)</label>
                <input id="logo" name="logo" type="url" maxlength="255"
                       value="{{ old('logo', $bank->logo) }}" class="input">
                @error('logo')
                    <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    {{-- ============================================================
         TOKEN
         --------------------------------------------------------------
         Không đổ giá trị token hiện tại vào input. Để trống = giữ
         token cũ (controller unset field khi blank), nên admin không
         vô tình xoá key đang chạy chỉ vì bấm Lưu.
         ============================================================ --}}
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">API token</h2>
            <p class="text-sm text-muted-foreground">
                @if (filled($bank->token))
                    Token đã được cấu hình. Để trống nếu không muốn thay đổi.
                @else
                    Chưa cấu hình token cho tài khoản này.
                @endif
            </p>
        </div>
        <div class="card-body">
            <label for="token" class="label mb-2 block">Token mới</label>
            <input id="token" name="token" type="password" maxlength="2000"
                   autocomplete="new-password" class="input font-mono"
                   placeholder="Để trống để giữ nguyên">
            <p class="mt-1 text-xs text-muted-foreground">
                Giá trị được mã hoá trước khi lưu và không bao giờ hiển thị lại.
            </p>
            @error('token')
                <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <button type="submit" class="btn-primary">Lưu thay đổi</button>
</form>

<form method="POST" action="{{ route('admin.banks.destroy', $bank) }}"
      class="mt-6 max-w-2xl"
      onsubmit="return confirm('Xoá tài khoản {{ $bank->short_name }}?')">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn-destructive">Xoá tài khoản này</button>
</form>
@endsection
