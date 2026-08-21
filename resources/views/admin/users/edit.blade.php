@extends('layouts.admin')
@section('title', 'Sửa người dùng #'.$user->id)

@section('content')
<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
    <div>
        <h1 class="text-xl font-semibold">Sửa người dùng #{{ $user->id }}</h1>
        <p class="mt-1 text-sm text-muted-foreground break-all">{{ $user->email }}</p>
    </div>
    <a href="{{ route('admin.users.index') }}" class="btn-outline">Về danh sách</a>
</div>

<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

    <form method="POST" action="{{ route('admin.users.update', $user) }}"
          class="space-y-6 lg:col-span-2">
        @csrf
        @method('PATCH')

        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Thông tin</h2>
            </div>
            <div class="card-body space-y-4">
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
                    <input id="telegram" name="telegram" type="text" maxlength="32"
                           value="{{ old('telegram', $user->telegram) }}" class="input">
                    @error('telegram')
                        <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- ========================================================
             QUYỀN & TRẠNG THÁI
             ----------------------------------------------------------
             `level` và `banned` KHÔNG nằm trong $fillable của model
             User, nên controller phải dùng forceFill() một cách tường
             minh. Nhờ vậy không tồn tại đường nào để leo thang đặc
             quyền bằng cách nhét thêm field vào một form khác.

             Server cũng chặn admin tự hạ quyền / tự khoá chính mình
             để không khoá chết hệ thống.
             ======================================================== --}}
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Quyền &amp; trạng thái</h2>
            </div>
            <div class="card-body space-y-4">

                @if ($user->is(auth()->user()))
                    <div class="alert-info">
                        Đây là tài khoản của bạn. Hệ thống không cho phép tự hạ quyền hoặc tự khoá.
                    </div>
                @endif

                <div>
                    <label for="level" class="label mb-2 block">Quyền</label>
                    <select id="level" name="level" required class="input">
                        <option value="0" @selected((int) old('level', $user->level) === 0)>Thành viên</option>
                        <option value="1" @selected((int) old('level', $user->level) === 1)>Quản trị viên</option>
                    </select>
                    @error('level')
                        <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="banned" class="label mb-2 block">Trạng thái</label>
                    <select id="banned" name="banned" required class="input">
                        <option value="0" @selected(! (bool) old('banned', $user->banned))>Đang hoạt động</option>
                        <option value="1" @selected((bool) old('banned', $user->banned))>Khoá tài khoản</option>
                    </select>
                    @error('banned')
                        <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- ========================================================
             ĐIỀU CHỈNH SỐ DƯ
             ----------------------------------------------------------
             Không sửa trực tiếp cột `money`. Giá trị nhập vào là mức
             điều chỉnh (+/-) và được đưa qua BalanceService, nơi việc
             cộng/trừ nằm trong DB::transaction() + lockForUpdate() và
             luôn ghi một dòng sổ vào bảng `dongtien` để đối soát.
             ======================================================== --}}
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Điều chỉnh số dư</h2>
                <p class="text-sm text-muted-foreground">
                    Số dư hiện tại:
                    <span class="font-semibold text-primary">
                        {{ number_format((int) $user->money, 0, ',', '.') }}đ
                    </span>
                </p>
            </div>
            <div class="card-body space-y-4">
                <div>
                    <label for="adjust" class="label mb-2 block">
                        Mức điều chỉnh (dương = cộng, âm = trừ)
                    </label>
                    <input id="adjust" name="adjust" type="number" step="1"
                           value="{{ old('adjust') }}" class="input" placeholder="0">
                    @error('adjust')
                        <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="reason" class="label mb-2 block">Lý do</label>
                    <input id="reason" name="reason" type="text" maxlength="255"
                           value="{{ old('reason') }}" class="input"
                           placeholder="Ghi rõ để đối soát về sau">
                    @error('reason')
                        <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Đặt lại mật khẩu</h2>
                <p class="text-sm text-muted-foreground">
                    Để trống nếu không muốn thay đổi.
                </p>
            </div>
            <div class="card-body space-y-4">
                <div>
                    <label for="password" class="label mb-2 block">Mật khẩu mới</label>
                    <input id="password" name="password" type="password"
                           autocomplete="new-password" class="input">
                    @error('password')
                        <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="password_confirmation" class="label mb-2 block">
                        Nhập lại mật khẩu
                    </label>
                    <input id="password_confirmation" name="password_confirmation"
                           type="password" autocomplete="new-password" class="input">
                </div>
            </div>
        </div>

        <button type="submit" class="btn-primary">Lưu thay đổi</button>
    </form>

    {{-- Lịch sử hoạt động — giúp truy vết khi có tranh chấp --}}
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Hoạt động gần đây</h2>
        </div>
        <div class="card-body">
            @if ($logs->isEmpty())
                <p class="text-sm text-muted-foreground">Chưa có dữ liệu.</p>
            @else
                <ul class="space-y-3 text-sm">
                    @foreach ($logs as $log)
                        <li class="border-b border-border pb-2 last:border-0 last:pb-0">
                            <p class="font-medium">{{ $log->action }}</p>
                            <p class="text-xs text-muted-foreground break-all">
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
@endsection
