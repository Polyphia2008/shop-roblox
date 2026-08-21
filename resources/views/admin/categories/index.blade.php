@extends('layouts.admin')
@section('title', 'Chuyên mục')

@section('content')
<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
    <div>
        <h1 class="text-xl font-semibold">Chuyên mục</h1>
        <p class="mt-1 text-sm text-muted-foreground">{{ $categories->total() }} chuyên mục</p>
    </div>
    <button type="button" class="btn-primary" onclick="document.getElementById('create-category').scrollIntoView({behavior:'smooth'})">
        Thêm chuyên mục
    </button>
</div>

{{-- ================================================================
     BẢN GỐC:
         DELETE FROM chuyenmuc WHERE id = '$_GET[id]'
     Vừa SQL injection (payload ' OR '1'='1 xoá trắng bảng), vừa dùng
     GET nên chỉ cần dụ admin bấm một link là mất dữ liệu.

     BẢN MỚI: xoá bằng DELETE + CSRF, id đi qua route binding (Eloquent
     tự bind tham số), và server chặn xoá khi chuyên mục còn hàng.
     ================================================================ --}}
@if ($categories->isEmpty())
    <div class="card mb-8">
        <div class="card-body text-center text-muted-foreground">Chưa có chuyên mục nào.</div>
    </div>
@else
    @php
        $toggle = fn (string $col) => request()->fullUrlWithQuery([
            'sort' => $col,
            'dir'  => ($column === $col && $direction === 'asc') ? 'desc' : 'asc',
        ]);
    @endphp

    <div class="space-y-4">
        @foreach ($categories as $category)
            <div class="card" x-data="{ open: false }">
                <div class="card-body">
                    <div class="flex flex-wrap items-start justify-between gap-3">
                        <div class="min-w-0 space-y-1">
                            <div class="flex flex-wrap items-center gap-2">
                                <h2 class="font-semibold">{{ $category->title }}</h2>
                                @if ($category->status === 'show')
                                    <span class="badge-success">Hiện</span>
                                @else
                                    <span class="badge-secondary">Ẩn</span>
                                @endif
                            </div>
                            <p class="text-sm text-muted-foreground">
                                Mã: <span class="font-mono">{{ $category->code }}</span> ·
                                Giá
                                <span class="font-semibold text-primary">
                                    {{ number_format((int) $category->price, 0, ',', '.') }}đ
                                </span>
                                · Tồn kho
                                <span class="font-medium">{{ (int) $category->stock_count }}</span>
                                · Đã bán {{ (int) $category->buy }}
                            </p>
                        </div>

                        <div class="flex gap-2">
                            <button type="button" class="btn-outline btn-sm"
                                    x-on:click="open = !open"
                                    x-text="open ? 'Đóng' : 'Sửa'">Sửa</button>

                            @if ((int) $category->stock_count === 0)
                                <form method="POST"
                                      action="{{ route('admin.categories.destroy', $category) }}"
                                      onsubmit="return confirm('Xoá chuyên mục {{ $category->code }}?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-destructive btn-sm">Xoá</button>
                                </form>
                            @endif
                        </div>
                    </div>

                    {{-- Form sửa: đổi `code` sẽ được controller cập nhật
                         cascade sang bảng product_nick trong cùng một
                         transaction, tránh kho nick bị mồ côi. --}}
                    <form x-show="open" x-cloak method="POST"
                          action="{{ route('admin.categories.update', $category) }}"
                          class="mt-4 grid grid-cols-1 gap-4 border-t border-border pt-4 sm:grid-cols-2">
                        @csrf
                        @method('PATCH')

                        <div>
                            <label for="code-{{ $category->id }}" class="label mb-2 block">Mã</label>
                            <input id="code-{{ $category->id }}" name="code" type="text"
                                   maxlength="64" required value="{{ $category->code }}" class="input">
                        </div>

                        <div>
                            <label for="title-{{ $category->id }}" class="label mb-2 block">Tên</label>
                            <input id="title-{{ $category->id }}" name="title" type="text"
                                   maxlength="255" required value="{{ $category->title }}" class="input">
                        </div>

                        <div>
                            <label for="price-{{ $category->id }}" class="label mb-2 block">Giá (đ)</label>
                            <input id="price-{{ $category->id }}" name="price" type="number"
                                   min="0" max="1000000000" required
                                   value="{{ (int) $category->price }}" class="input">
                        </div>

                        <div>
                            <label for="status-{{ $category->id }}" class="label mb-2 block">Trạng thái</label>
                            <select id="status-{{ $category->id }}" name="status" required class="input">
                                <option value="show" @selected($category->status === 'show')>Hiện</option>
                                <option value="hide" @selected($category->status !== 'show')>Ẩn</option>
                            </select>
                        </div>

                        <div class="sm:col-span-2">
                            <label for="logo-{{ $category->id }}" class="label mb-2 block">
                                Ảnh (URL)
                            </label>
                            <input id="logo-{{ $category->id }}" name="logo" type="url"
                                   maxlength="255" value="{{ $category->logo }}" class="input">
                        </div>

                        <div class="sm:col-span-2">
                            <label for="note-{{ $category->id }}" class="label mb-2 block">Mô tả</label>
                            <textarea id="note-{{ $category->id }}" name="note" rows="3"
                                      maxlength="5000" class="input h-auto">{{ $category->note }}</textarea>
                        </div>

                        <div class="sm:col-span-2">
                            <button type="submit" class="btn-primary">Lưu chuyên mục</button>
                        </div>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6">{{ $categories->links() }}</div>
@endif

{{-- ================================================================
     THÊM MỚI
     `code` phải là alpha_dash + unique nên không thể chèn ký tự lạ
     hay tạo trùng mã (bản gốc không kiểm tra, sinh dữ liệu rác).
     ================================================================ --}}
<div id="create-category" class="card mt-8">
    <div class="card-header">
        <h2 class="card-title">Thêm chuyên mục</h2>
    </div>
    <form method="POST" action="{{ route('admin.categories.store') }}"
          class="card-body grid grid-cols-1 gap-4 sm:grid-cols-2">
        @csrf

        <div>
            <label for="code" class="label mb-2 block">Mã chuyên mục</label>
            <input id="code" name="code" type="text" maxlength="64" required
                   value="{{ old('code') }}" class="input" placeholder="nick-random">
            <p class="mt-1 text-xs text-muted-foreground">
                Chỉ chữ, số, gạch ngang và gạch dưới.
            </p>
            @error('code')
                <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="title" class="label mb-2 block">Tên hiển thị</label>
            <input id="title" name="title" type="text" maxlength="255" required
                   value="{{ old('title') }}" class="input">
            @error('title')
                <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="price" class="label mb-2 block">Giá (đ)</label>
            <input id="price" name="price" type="number" min="0" max="1000000000" required
                   value="{{ old('price') }}" class="input">
            @error('price')
                <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="new-status" class="label mb-2 block">Trạng thái</label>
            <select id="new-status" name="status" required class="input">
                <option value="show" @selected(old('status', 'show') === 'show')>Hiện</option>
                <option value="hide" @selected(old('status') === 'hide')>Ẩn</option>
            </select>
            @error('status')
                <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
            @enderror
        </div>

        <div class="sm:col-span-2">
            <label for="new-logo" class="label mb-2 block">Ảnh (URL)</label>
            <input id="new-logo" name="logo" type="url" maxlength="255"
                   value="{{ old('logo') }}" class="input" placeholder="https://...">
            @error('logo')
                <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
            @enderror
        </div>

        <div class="sm:col-span-2">
            <label for="new-note" class="label mb-2 block">Mô tả</label>
            <textarea id="new-note" name="note" rows="3" maxlength="5000"
                      class="input h-auto">{{ old('note') }}</textarea>
            @error('note')
                <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
            @enderror
        </div>

        <div class="sm:col-span-2">
            <button type="submit" class="btn-primary">Thêm chuyên mục</button>
        </div>
    </form>
</div>
@endsection
