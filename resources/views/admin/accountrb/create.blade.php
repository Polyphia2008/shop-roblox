@extends('layouts.admin')
@section('title', 'Thêm nick Robux')

@section('content')
<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
    <h1 class="text-xl font-semibold">Thêm nick Robux</h1>
    <a href="{{ route('admin.accountrb.index') }}" class="btn-outline">Về danh sách</a>
</div>

<form method="POST" action="{{ route('admin.accountrb.store') }}" class="max-w-3xl space-y-6">
    @csrf

    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Thông số chung</h2>
            <p class="text-sm text-muted-foreground">
                Áp dụng cho tất cả tài khoản nhập ở bước dưới.
            </p>
        </div>
        <div class="card-body grid grid-cols-1 gap-4 sm:grid-cols-2">

            <div>
                <label for="robux" class="label mb-2 block">Số Robux</label>
                <input id="robux" name="robux" type="number" min="0" max="100000000"
                       required value="{{ old('robux') }}" class="input">
                @error('robux')
                    <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="rate" class="label mb-2 block">Rate</label>
                <input id="rate" name="rate" type="number" min="0" max="100000"
                       required value="{{ old('rate') }}" class="input">
                @error('rate')
                    <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="price" class="label mb-2 block">Giá bán (đ)</label>
                {{-- Giá do admin đặt và LUÔN được đọc lại từ DB khi khách
                     mua. Bản gốc nhận giá từ form của khách nên có thể sửa
                     bằng DevTools để mua nick 1đ. --}}
                <input id="price" name="price" type="number" min="0" max="1000000000"
                       required value="{{ old('price') }}" class="input">
                @error('price')
                    <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="guarantee" class="label mb-2 block">Thời hạn bảo hành</label>
                <input id="guarantee" name="guarantee" type="text" maxlength="64"
                       value="{{ old('guarantee') }}" class="input" placeholder="VD: 7 ngày">
                @error('guarantee')
                    <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="premium" class="label mb-2 block">Premium</label>
                <select id="premium" name="premium" required class="input">
                    <option value="0" @selected(old('premium', '0') === '0')>Không</option>
                    <option value="1" @selected(old('premium') === '1')>Có</option>
                </select>
                @error('premium')
                    <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="datejoin" class="label mb-2 block">Ngày tạo nick</label>
                <input id="datejoin" name="datejoin" type="text" maxlength="64"
                       value="{{ old('datejoin') }}" class="input" placeholder="VD: 2019">
                @error('datejoin')
                    <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Dữ liệu tài khoản</h2>
            <p class="text-sm text-muted-foreground">
                Mỗi dòng là một tài khoản. Dòng trống được bỏ qua.
            </p>
        </div>
        <div class="card-body space-y-4">
            <div>
                <label for="information" class="label mb-2 block">
                    Danh sách tài khoản (user|pass|...)
                </label>
                <textarea id="information" name="information" rows="12" required
                          maxlength="50000" class="input h-auto font-mono text-xs"
                          placeholder="taikhoan1|matkhau1&#10;taikhoan2|matkhau2"
                >{{ old('information') }}</textarea>
                @error('information')
                    <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
                @enderror
            </div>

            {{-- Nhắc admin biết dữ liệu được bảo vệ thế nào --}}
            <div class="alert-info">
                Thông tin đăng nhập được mã hoá trước khi lưu (cast
                <span class="font-mono">encrypted</span>). Toàn bộ số nick được thêm trong
                một transaction — nếu có lỗi giữa chừng thì không nick nào được lưu.
            </div>
        </div>
    </div>

    <button type="submit" class="btn-primary">Thêm vào kho</button>
</form>
@endsection
