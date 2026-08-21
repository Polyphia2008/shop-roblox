@extends('layouts.admin')
@section('title', 'Sửa nick #'.$account->id)

@section('content')
<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
    <div>
        <h1 class="text-xl font-semibold">Sửa nick #{{ $account->id }}</h1>
        <p class="mt-1 text-sm text-muted-foreground">
            Mã GD: <span class="font-mono">{{ $account->magd ?: '—' }}</span>
            @if ($account->username)
                · Người mua: {{ $account->username }}
            @endif
        </p>
    </div>
    <a href="{{ route('admin.accountrb.index') }}" class="btn-outline">Về danh sách</a>
</div>

<form method="POST" action="{{ route('admin.accountrb.update', $account) }}"
      class="max-w-3xl space-y-6">
    @csrf
    @method('PATCH')

    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Thông số</h2>
        </div>
        <div class="card-body grid grid-cols-1 gap-4 sm:grid-cols-2">

            <div>
                <label for="robux" class="label mb-2 block">Số Robux</label>
                <input id="robux" name="robux" type="number" min="0" max="100000000" required
                       value="{{ old('robux', $account->robux) }}" class="input">
                @error('robux')
                    <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="rate" class="label mb-2 block">Rate</label>
                <input id="rate" name="rate" type="number" min="0" max="100000" required
                       value="{{ old('rate', $account->rate) }}" class="input">
                @error('rate')
                    <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="price" class="label mb-2 block">Giá bán (đ)</label>
                <input id="price" name="price" type="number" min="0" max="1000000000" required
                       value="{{ old('price', $account->price) }}" class="input">
                @error('price')
                    <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="guarantee" class="label mb-2 block">Thời hạn bảo hành</label>
                <input id="guarantee" name="guarantee" type="text" maxlength="64"
                       value="{{ old('guarantee', $account->guarantee) }}" class="input">
                @error('guarantee')
                    <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="premium" class="label mb-2 block">Premium</label>
                <select id="premium" name="premium" required class="input">
                    <option value="0" @selected((string) old('premium', $account->premium) !== '1')>Không</option>
                    <option value="1" @selected((string) old('premium', $account->premium) === '1')>Có</option>
                </select>
                @error('premium')
                    <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="status" class="label mb-2 block">Trạng thái</label>
                {{-- Chỉ nhận 1/2/3 (validate 'in:1,2,3') — giá trị khác bị
                     từ chối, không có đường đưa trạng thái lạ vào DB. --}}
                <select id="status" name="status" required class="input">
                    <option value="1" @selected((string) old('status', $account->status) === '1')>Đang bán</option>
                    <option value="2" @selected((string) old('status', $account->status) === '2')>Đã bán</option>
                    <option value="3" @selected((string) old('status', $account->status) === '3')>Bảo hành</option>
                </select>
                @error('status')
                    <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Thông tin đăng nhập</h2>
            <p class="text-sm text-muted-foreground">
                Được giải mã để hiển thị và mã hoá lại khi lưu.
            </p>
        </div>
        <div class="card-body">
            <textarea id="information" name="information" rows="6" required maxlength="5000"
                      class="input h-auto font-mono text-xs"
            >{{ old('information', $account->information) }}</textarea>
            @error('information')
                <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <div class="flex flex-wrap gap-2">
        <button type="submit" class="btn-primary">Lưu thay đổi</button>

        @if ($account->status === \App\Models\AccountRb::STATUS_ON_SALE)
            <a href="{{ route('admin.accountrb.index') }}" class="btn-outline">Huỷ</a>
        @endif
    </div>
</form>

{{-- Xoá đặt ngoài form chính để không lẫn với nút lưu --}}
@if ($account->status === \App\Models\AccountRb::STATUS_ON_SALE)
    <form method="POST" action="{{ route('admin.accountrb.destroy', $account) }}"
          class="mt-6 max-w-3xl"
          onsubmit="return confirm('Xoá nick #{{ $account->id }}?')">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn-destructive">Xoá nick này</button>
    </form>
@else
    <div class="alert-info mt-6 max-w-3xl">
        Nick đã bán không thể xoá — giữ lại để phục vụ bảo hành và đối soát doanh thu.
    </div>
@endif
@endsection
