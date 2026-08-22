@extends('layouts.admin')
@section('title', 'Người dùng')

@section('content')
<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
    <h1 class="text-xl font-semibold">Người dùng</h1>
    <span class="text-sm text-muted-foreground">{{ $users->total() }} tài khoản</span>
</div>

{{-- ================================================================
     BỘ LỌC
     --------------------------------------------------------------
     `keyword` đi vào truy vấn dưới dạng binding, và ký tự % _ \ được
     addcslashes() ở controller nên tìm "%" không quét cả bảng.

     `sort` / `dir` KHÔNG thể bind bằng PDO (tên cột và chiều sắp xếp
     không phải giá trị), nên chúng được lọc qua allow-list
     SqlInjectionGuard::column()/direction() — giá trị lạ bị thay bằng
     mặc định thay vì ghép thẳng vào SQL như bản gốc.
     ================================================================ --}}
<div class="card mb-6">
    <form method="GET" action="{{ route('admin.users.index') }}"
          class="card-body grid grid-cols-1 gap-4 md:grid-cols-4">

        <div class="md:col-span-2">
            <label for="keyword" class="label mb-2 block">Tìm kiếm</label>
            <input id="keyword" name="keyword" type="search" value="{{ $keyword }}"
                   class="input" placeholder="Email, tên hoặc Telegram ID">
        </div>

        <div>
            <label for="banned" class="label mb-2 block">Trạng thái</label>
            <select id="banned" name="banned" class="input">
                <option value="">Tất cả</option>
                <option value="0" @selected(request()->query('banned') === '0')>Đang hoạt động</option>
                <option value="1" @selected(request()->query('banned') === '1')>Đã khoá</option>
            </select>
        </div>

        <div class="flex items-end gap-2">
            <button type="submit" class="btn-primary">Lọc</button>
            <a href="{{ route('admin.users.index') }}" class="btn-outline">Xoá lọc</a>
        </div>
    </form>
</div>

@if ($users->isEmpty())
    <div class="card">
        <div class="card-body text-center text-muted-foreground">
            Không tìm thấy người dùng nào.
        </div>
    </div>
@else
    @php
        /* Đổi chiều sắp xếp khi bấm lại cùng một cột */
        $toggle = fn (string $col) => request()->fullUrlWithQuery([
            'sort' => $col,
            'dir'  => ($column === $col && $direction === 'asc') ? 'desc' : 'asc',
        ]);
    @endphp

    <div class="card overflow-hidden">
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr>
                        <th><a href="{{ $toggle('id') }}" class="hover:text-primary">ID</a></th>
                        <th><a href="{{ $toggle('email') }}" class="hover:text-primary">Email</a></th>
                        <th>Tên</th>
                        <th class="text-right">
                            <a href="{{ $toggle('money') }}" class="hover:text-primary">Số dư</a>
                        </th>
                        <th class="text-right">
                            <a href="{{ $toggle('total_money') }}" class="hover:text-primary">Đã nạp</a>
                        </th>
                        <th>Quyền</th>
                        <th>Trạng thái</th>
                        <th class="text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td class="text-muted-foreground">#{{ $user->id }}</td>
                            <td class="font-medium break-all">{{ $user->email }}</td>
                            <td>{{ Str::limit($user->username, 20) ?: '—' }}</td>
                            <td class="text-right whitespace-nowrap font-semibold text-primary">
                                {{ number_format((int) $user->money, 0, ',', '.') }}đ
                            </td>
                            <td class="text-right whitespace-nowrap">
                                {{ number_format((int) $user->total_money, 0, ',', '.') }}đ
                            </td>
                            <td>
                                @if ($user->isAdmin())
                                    <span class="badge-success">Admin</span>
                                @else
                                    <span class="badge-secondary">Thành viên</span>
                                @endif
                            </td>
                            <td>
                                @if ($user->isBanned())
                                    <span class="badge-destructive">Đã khoá</span>
                                @elseif ($user->isOnline())
                                    <span class="badge-success">Online</span>
                                @else
                                    <span class="badge-secondary">Offline</span>
                                @endif
                            </td>
                            <td class="text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('admin.users.edit', $user) }}"
                                       class="btn-outline btn-sm">Sửa</a>

                                    {{-- Xoá bằng DELETE + CSRF (bản gốc dùng
                                         link GET nên chỉ cần dụ admin bấm vào
                                         một URL là xoá được người dùng). --}}
                                    <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                          onsubmit="return confirm('Xoá người dùng #{{ $user->id }}?')">
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

    <div class="mt-6">{{ $users->links() }}</div>
@endif
@endsection
