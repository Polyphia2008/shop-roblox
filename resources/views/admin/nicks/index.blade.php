@extends('layouts.admin')
@section('title', 'Kho nick game')

@section('content')
<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
    <div>
        <h1 class="text-xl font-semibold">Kho nick game</h1>
        <p class="mt-1 text-sm text-muted-foreground">{{ $nicks->total() }} nick</p>
    </div>
</div>

{{-- ================================================================
     NHẬP KHO HÀNG LOẠT
     --------------------------------------------------------------
     Dữ liệu được tách dòng, loại trùng, rồi insert theo lô 500 dòng
     bằng query builder (vẫn là prepared statement) trong một
     transaction. Bản gốc nối chuỗi từng dòng vào câu INSERT nên chỉ
     cần một nick chứa dấu nháy là vỡ câu lệnh.
     ================================================================ --}}
<div class="card mb-8">
    <div class="card-header">
        <h2 class="card-title">Nhập kho</h2>
        <p class="text-sm text-muted-foreground">
            Mỗi dòng một nick, dạng <span class="font-mono">taikhoan|ghichu</span>.
            Dòng trùng nhau sẽ tự động bị loại.
        </p>
    </div>
    <form method="POST" action="{{ route('admin.nicks.store') }}" class="card-body space-y-4">
        @csrf

        <div>
            <label for="chuyenmuc" class="label mb-2 block">Chuyên mục</label>
            {{-- Validate 'exists:chuyenmuc,code' nên mã chuyên mục lạ bị
                 từ chối, không tạo được nick mồ côi. --}}
            <select id="chuyenmuc" name="chuyenmuc" required class="input">
                <option value="">— Chọn chuyên mục —</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->code }}"
                            @selected(old('chuyenmuc') === $category->code)>
                        {{ $category->title }} ({{ $category->code }})
                    </option>
                @endforeach
            </select>
            @error('chuyenmuc')
                <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="data" class="label mb-2 block">Danh sách nick</label>
            <textarea id="data" name="data" rows="10" required maxlength="500000"
                      class="input h-auto font-mono text-xs"
                      placeholder="nick1|ghi chú&#10;nick2">{{ old('data') }}</textarea>
            @error('data')
                <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn-primary">Nhập kho</button>
    </form>
</div>

{{-- ================================================================ FILTER --}}
<div class="card mb-6">
    <form method="GET" action="{{ route('admin.nicks.index') }}"
          class="card-body grid grid-cols-1 gap-4 md:grid-cols-4">

        <div>
            <label for="filter-keyword" class="label mb-2 block">Tìm nick</label>
            <input id="filter-keyword" name="keyword" type="search"
                   value="{{ request()->query('keyword') }}" class="input">
        </div>

        <div>
            <label for="filter-chuyenmuc" class="label mb-2 block">Chuyên mục</label>
            <select id="filter-chuyenmuc" name="chuyenmuc" class="input">
                <option value="">Tất cả</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->code }}"
                            @selected(request()->query('chuyenmuc') === $category->code)>
                        {{ $category->title }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="filter-status" class="label mb-2 block">Trạng thái</label>
            <select id="filter-status" name="status" class="input">
                <option value="">Tất cả</option>
                <option value="live" @selected(request()->query('status') === 'live')>Còn hàng</option>
                <option value="sold" @selected(request()->query('status') === 'sold')>Đã bán</option>
            </select>
        </div>

        <div class="flex items-end gap-2">
            <button type="submit" class="btn-primary">Lọc</button>
            <a href="{{ route('admin.nicks.index') }}" class="btn-outline">Xoá lọc</a>
        </div>
    </form>
</div>

@if ($nicks->isEmpty())
    <div class="card">
        <div class="card-body text-center text-muted-foreground">
            Không tìm thấy nick nào.
        </div>
    </div>
@else
    @php
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
                        <th><a href="{{ $toggle('code') }}" class="hover:text-primary">Nick</a></th>
                        <th>Chuyên mục</th>
                        <th>Ghi chú</th>
                        <th>Mã GD</th>
                        <th>Người mua</th>
                        <th>Trạng thái</th>
                        <th class="text-right">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($nicks as $nick)
                        <tr>
                            <td class="text-muted-foreground">#{{ $nick->id }}</td>
                            <td class="font-mono text-xs break-all">{{ $nick->code }}</td>
                            <td>{{ $nick->chuyenmuc }}</td>
                            <td class="text-muted-foreground">{{ Str::limit($nick->note, 30) }}</td>
                            <td class="font-mono text-xs">{{ $nick->magd ?: '—' }}</td>
                            <td class="break-all">{{ $nick->username ?: '—' }}</td>
                            <td>
                                @if ($nick->status === 'live')
                                    <span class="badge-success">Còn hàng</span>
                                @else
                                    <span class="badge-secondary">Đã bán</span>
                                @endif
                            </td>
                            <td class="text-right">
                                {{-- Chỉ nick còn hàng mới xoá được; server
                                     kiểm tra lại nên ẩn nút chỉ là tiện lợi. --}}
                                @if ($nick->status === 'live')
                                    <form method="POST"
                                          action="{{ route('admin.nicks.destroy', $nick) }}"
                                          onsubmit="return confirm('Xoá nick #{{ $nick->id }}?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-destructive btn-sm">Xoá</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">{{ $nicks->links() }}</div>
@endif
@endsection
