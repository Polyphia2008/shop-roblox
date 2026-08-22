@extends('layouts.app')
@section('title', 'Thông tin tài khoản')

@section('content')
<h1 class="mb-6 text-xl font-semibold">Thông tin tài khoản</h1>

<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

    {{-- ============================================================
         Cột trái: tổng quan. Số dư CHỈ hiển thị — không có form nào ở
         phía client cho phép sửa money / level / banned. Các trường
         này bị loại khỏi $fillable của model User, nên kể cả khi kẻ
         tấn công thêm input `money` vào request thì Eloquent cũng bỏ
         qua (chống mass assignment).
         ============================================================ --}}
    <div class="space-y-6">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Tổng quan</h2>
            </div>
            <div class="card-body space-y-3 text-sm">
                <div class="flex items-center justify-between gap-2">
                    <span class="text-muted-foreground">Email</span>
                    <span class="truncate font-medium">{{ $user->email }}</span>
                </div>
                <div class="flex items-center justify-between gap-2">
                    <span class="text-muted-foreground">Số dư</span>
                    <span class="font-semibold text-primary">
                        {{ number_format((int) $user->money, 0, ',', '.') }}đ
                    </span>
                </div>
                <div class="flex items-center justify-between gap-2">
                    <span class="text-muted-foreground">Tổng đã nạp</span>
                    <span class="font-medium">
                        {{ number_format((int) $user->total_money, 0, ',', '.') }}đ
                    </span>
                </div>
                <div class="flex items-center justify-between gap-2">
                    <span class="text-muted-foreground">Cấp bậc</span>
                    <span class="badge-secondary">
                        {{ $user->isAdmin() ? 'Quản trị viên' : 'Thành viên' }}
                    </span>
                </div>
                <div class="flex items-center justify-between gap-2">
                    <span class="text-muted-foreground">Ngày tham gia</span>
                    <span class="font-medium">
                        {{ $user->created_at?->format('d/m/Y') ?? '—' }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Lịch sử đăng nhập giúp user tự phát hiện truy cập lạ --}}
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Đăng nhập gần đây</h2>
            </div>
            <div class="card-body">
                @if ($logins->isEmpty())
                    <p class="text-sm text-muted-foreground">Chưa có dữ liệu.</p>
                @else
                    <ul class="space-y-3 text-sm">
                        @foreach ($logins as $log)
                            <li class="border-b border-border pb-2 last:border-0 last:pb-0">
                                <p class="font-medium">{{ $log->action }}</p>
                                <p class="text-xs text-muted-foreground">
                                    IP {{ $log->ip }} · {{ Str::limit($log->device, 40) }}
                                </p>
                                <p class="text-xs text-muted-foreground">{{ $log->create_date }}</p>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>

    {{-- ============================================================
         Cột phải: hai form riêng biệt.
         Cả hai dùng @csrf + method spoofing (PATCH/PUT) thay vì GET
         như bản gốc, nên không thể bị kích hoạt bằng một thẻ
         <img src="..."> hay link chia sẻ (chống CSRF).
         ============================================================ --}}
    <div class="space-y-6 lg:col-span-2">

        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Cập nhật thông tin liên hệ</h2>
                <p class="text-sm text-muted-foreground">
                    Email đăng nhập không thể thay đổi.
                </p>
            </div>
            <form method="POST" action="{{ route('profile.update') }}" class="card-body space-y-4">
                @csrf
                @method('PATCH')

                <div>
                    <label for="username" class="label mb-2 block">Tên hiển thị</label>
                    <input id="username" name="username" type="text" maxlength="100"
                           value="{{ old('username', $user->username) }}" class="input">
                    @error('username')
                        <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="telegram" class="label mb-2 block">Telegram ID</label>
                    <input id="telegram" name="telegram" type="text" inputmode="numeric"
                           maxlength="32" value="{{ old('telegram', $user->telegram) }}"
                           class="input" placeholder="Chỉ gồm chữ số">
                    <p class="mt-1 text-xs text-muted-foreground">
                        Dùng để nhận thông báo đơn hàng.
                    </p>
                    @error('telegram')
                        <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <button type="submit" class="btn-primary">Lưu thay đổi</button>
                </div>
            </form>
        </div>

        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Đổi mật khẩu</h2>
                <p class="text-sm text-muted-foreground">
                    Sau khi đổi, mọi phiên đăng nhập khác sẽ bị đăng xuất.
                </p>
            </div>
            <form method="POST" action="{{ route('password.update') }}" class="card-body space-y-4">
                @csrf
                @method('PUT')

                {{-- Bắt buộc xác nhận mật khẩu hiện tại: nếu session bị
                     chiếm, kẻ tấn công vẫn không đổi được mật khẩu. --}}
                <div>
                    <label for="current_password" class="label mb-2 block">Mật khẩu hiện tại</label>
                    <input id="current_password" name="current_password" type="password"
                           autocomplete="current-password" required class="input">
                    @error('current_password')
                        <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password" class="label mb-2 block">Mật khẩu mới</label>
                    <input id="password" name="password" type="password"
                           autocomplete="new-password" required class="input">
                    <p class="mt-1 text-xs text-muted-foreground">
                        Tối thiểu {{ config('security.password.min_length', 8) }} ký tự,
                        có chữ hoa, chữ thường và số.
                    </p>
                    @error('password')
                        <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password_confirmation" class="label mb-2 block">
                        Nhập lại mật khẩu mới
                    </label>
                    <input id="password_confirmation" name="password_confirmation" type="password"
                           autocomplete="new-password" required class="input">
                </div>

                <div>
                    <button type="submit" class="btn-primary">Đổi mật khẩu</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
