@extends('layouts.admin')
@section('title', 'Cấu hình hệ thống')

@section('content')
{{-- ================================================================
     GHI CHÚ BẢO MẬT — ALLOW-LIST KHOÁ CẤU HÌNH
     --------------------------------------------------------------
     Bản gốc (views/admin/Setting.php):

         foreach ($_POST as $k => $v)
             UPDATE settings SET value = '$v' WHERE name = '$k'

     Hai lỗ hổng cùng lúc:
       1. Nối chuỗi -> SQL injection qua cả KHOÁ và GIÁ TRỊ.
       2. Ghi thẳng mọi khoá client gửi lên -> kẻ tấn công tự thêm hoặc
          ghi đè BẤT KỲ khoá cấu hình nội bộ nào (kể cả khoá dùng để
          phân quyền), một dạng mass-assignment ở tầng cấu hình.

     Nay controller chỉ validate + ghi 13 khoá trong hằng ALLOWED.
     Khoá lạ bị bỏ qua hoàn toàn, không cần view phải phòng gì thêm.
     Mọi form dưới đây đều là PATCH + CSRF.

     Riêng telegram_token: KHÔNG bao giờ in giá trị ra HTML. Ô nhập bị
     `disabled` cho tới khi admin bấm "Đổi token" — input disabled không
     được gửi lên, nhờ vậy lưu các mục khác không vô tình xoá token.
     ================================================================ --}}

@php
    /* $settings là collection keyBy('name') -> helper đọc giá trị an toàn */
    $val = fn (string $key, string $default = '') => (string) (optional($settings->get($key))->value ?? $default);

    $tab = match (true) {
        request()->routeIs('admin.rates.index')      => 'rates',
        request()->routeIs('admin.rateorders.index') => 'rateorders',
        default                                      => 'settings',
    };

    /* Khoá đang tồn tại trong DB nhưng KHÔNG nằm trong allow-list */
    $notEditable = $settings->keys()->reject(fn ($k) => in_array($k, $allowed, true))->values();
@endphp

<h1 class="mb-6 text-xl font-semibold">Cấu hình hệ thống</h1>

{{-- Ba route (Setting / muc-rate / order-rate) dùng chung controller index() --}}
<div class="mb-6 flex flex-wrap gap-2 border-b border-border pb-3">
    <a href="{{ route('admin.settings.index') }}"
       class="{{ $tab === 'settings' ? 'btn-primary' : 'btn-outline' }} btn-sm">Cấu hình chung</a>
    <a href="{{ route('admin.rates.index') }}"
       class="{{ $tab === 'rates' ? 'btn-primary' : 'btn-outline' }} btn-sm">Mức rate</a>
    <a href="{{ route('admin.rateorders.index') }}"
       class="{{ $tab === 'rateorders' ? 'btn-primary' : 'btn-outline' }} btn-sm">Mức rate order</a>
</div>

{{-- ============================================================ TAB 1 ==== --}}
@if ($tab === 'settings')

    {{-- ---------------------------------------- Thông tin website ---------- --}}
    <div class="card mb-6">
        <div class="card-header">
            <h2 class="card-title">Thông tin website</h2>
            <p class="text-sm text-muted-foreground">Tiêu đề, mô tả, logo và trạng thái hoạt động.</p>
        </div>
        <form method="POST" action="{{ route('admin.settings.update') }}" class="card-body space-y-4">
            @csrf
            @method('PATCH')

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <label for="title" class="label mb-2 block">Tiêu đề trang</label>
                    <input id="title" name="title" value="{{ old('title', $val('title')) }}"
                           class="input" maxlength="190">
                    @error('title')<p class="mt-1 text-xs text-destructive">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="min_deposit" class="label mb-2 block">Nạp tối thiểu (đ)</label>
                    <input id="min_deposit" name="min_deposit" type="number" min="0" max="1000000000" step="1"
                           value="{{ old('min_deposit', $val('min_deposit', '0')) }}" class="input">
                    @error('min_deposit')<p class="mt-1 text-xs text-destructive">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="logo" class="label mb-2 block">Đường dẫn logo</label>
                    <input id="logo" name="logo" value="{{ old('logo', $val('logo')) }}"
                           class="input" maxlength="255" placeholder="/images/logo.png">
                    @error('logo')<p class="mt-1 text-xs text-destructive">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="favicon" class="label mb-2 block">Đường dẫn favicon</label>
                    <input id="favicon" name="favicon" value="{{ old('favicon', $val('favicon')) }}"
                           class="input" maxlength="255" placeholder="/favicon.ico">
                    @error('favicon')<p class="mt-1 text-xs text-destructive">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="maintenance" class="label mb-2 block">Chế độ bảo trì</label>
                    <select id="maintenance" name="maintenance" class="input">
                        <option value="0" @selected(old('maintenance', $val('maintenance', '0')) !== '1')>Đang mở bán</option>
                        <option value="1" @selected(old('maintenance', $val('maintenance', '0')) === '1')>Tạm bảo trì</option>
                    </select>
                    @error('maintenance')<p class="mt-1 text-xs text-destructive">{{ $message }}</p>@enderror
                </div>
            </div>

            <div>
                <label for="description" class="label mb-2 block">Mô tả (SEO)</label>
                <textarea id="description" name="description" rows="2" maxlength="500"
                          class="input">{{ old('description', $val('description')) }}</textarea>
                @error('description')<p class="mt-1 text-xs text-destructive">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="notification" class="label mb-2 block">Thông báo hiển thị cho khách</label>
                <textarea id="notification" name="notification" rows="4" maxlength="5000"
                          class="input">{{ old('notification', $val('notification')) }}</textarea>
                <p class="mt-1 text-xs text-muted-foreground">
                    Nội dung này được in ra bằng escape HTML, thẻ HTML sẽ hiện dưới dạng chữ
                    (chặn XSS lưu trữ).
                </p>
                @error('notification')<p class="mt-1 text-xs text-destructive">{{ $message }}</p>@enderror
            </div>

            <button type="submit" class="btn-primary">Lưu thông tin website</button>
        </form>
    </div>

    {{-- ---------------------------------------- Telegram ------------------- --}}
    <div class="card mb-6">
        <div class="card-header">
            <h2 class="card-title">Telegram</h2>
            <p class="text-sm text-muted-foreground">
                Bản gốc hardcode token bot ngay trong <code>core/helpers.php</code> — ai đọc được
                source là chiếm được bot. Nay token lưu trong cấu hình và không bao giờ hiển thị lại.
            </p>
        </div>
        <form method="POST" action="{{ route('admin.settings.update') }}"
              class="card-body space-y-4" x-data="{ changeToken: false }">
            @csrf
            @method('PATCH')

            <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                <div>
                    <span class="label mb-2 block">Token bot</span>

                    <div class="flex items-center gap-2">
                        @if ($val('telegram_token') !== '')
                            <span class="badge-success">Đã cấu hình</span>
                        @else
                            <span class="badge-warning">Chưa có</span>
                        @endif

                        <button type="button" class="btn-outline btn-sm" @click="changeToken = !changeToken"
                                x-text="changeToken ? 'Huỷ đổi token' : 'Đổi token'">Đổi token</button>
                    </div>

                    {{-- Input disabled không được submit -> lưu mục khác không xoá token cũ --}}
                    <input id="telegram_token" name="telegram_token" type="password" autocomplete="new-password"
                           class="input mt-2" maxlength="200" placeholder="Dán token mới"
                           x-bind:disabled="! changeToken" x-show="changeToken" x-cloak>

                    @error('telegram_token')<p class="mt-1 text-xs text-destructive">{{ $message }}</p>@enderror
                </div>

                <div>
                    <label for="telegram_group" class="label mb-2 block">ID nhóm nhận thông báo</label>
                    <input id="telegram_group" name="telegram_group"
                           value="{{ old('telegram_group', $val('telegram_group')) }}"
                           class="input" maxlength="64" placeholder="-1001234567890">
                    @error('telegram_group')<p class="mt-1 text-xs text-destructive">{{ $message }}</p>@enderror
                </div>
            </div>

            <button type="submit" class="btn-primary">Lưu cấu hình Telegram</button>
        </form>
    </div>

    {{-- ---------------------------------------- Nội dung trang tĩnh -------- --}}
    <div class="card mb-6">
        <div class="card-header">
            <h2 class="card-title">Nội dung các trang hướng dẫn</h2>
            <p class="text-sm text-muted-foreground">
                Dùng cho trang bảo hành, hướng dẫn bot, hướng dẫn report và hướng dẫn bật 2FA.
            </p>
        </div>
        <form method="POST" action="{{ route('admin.settings.update') }}" class="card-body space-y-4">
            @csrf
            @method('PATCH')

            @foreach ([
                'warranty_policy' => 'Chính sách bảo hành',
                'use_bot'         => 'Hướng dẫn dùng bot',
                'use_report'      => 'Hướng dẫn report',
                'guide_2fa'       => 'Hướng dẫn bật 2FA',
            ] as $key => $label)
                <div>
                    <label for="{{ $key }}" class="label mb-2 block">{{ $label }}</label>
                    <textarea id="{{ $key }}" name="{{ $key }}" rows="6" maxlength="20000"
                              class="input font-mono text-xs">{{ old($key, $val($key)) }}</textarea>
                    @error($key)<p class="mt-1 text-xs text-destructive">{{ $message }}</p>@enderror
                </div>
            @endforeach

            <button type="submit" class="btn-primary">Lưu nội dung</button>
        </form>
    </div>

    {{-- ---------------------------------------- Khoá ngoài allow-list ------ --}}
    @if ($notEditable->isNotEmpty())
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Khoá không sửa được qua giao diện</h2>
                <p class="text-sm text-muted-foreground">
                    Các khoá dưới đây tồn tại trong bảng <code>settings</code> nhưng không nằm trong
                    allow-list, nên form admin không thể ghi vào chúng. Đây là cơ chế chặn việc
                    ghi đè khoá cấu hình nội bộ.
                </p>
            </div>
            <div class="card-body">
                <div class="flex flex-wrap gap-2">
                    @foreach ($notEditable as $key)
                        <span class="badge-secondary font-mono">{{ $key }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

{{-- ====================================================== TAB 2 & 3 ==== --}}
@else
    @php
        $isRates  = $tab === 'rates';
        $records  = $isRates ? $rateLevels : $rateOrders;
        $heading  = $isRates ? 'Mức rate' : 'Mức rate order';
        $storeUrl = $isRates ? route('admin.rates.store') : route('admin.rateorders.store');
        $table    = $isRates ? 'mucrate' : 'rateorder';
    @endphp

    <div class="card mb-6">
        <div class="card-header">
            <h2 class="card-title">Thêm {{ mb_strtolower($heading) }}</h2>
            <p class="text-sm text-muted-foreground">
                Mã rate được kiểm tra trùng bằng rule <code>unique:{{ $table }},code</code> ở tầng
                server, không dựa vào kiểm tra phía trình duyệt.
            </p>
        </div>
        <form method="POST" action="{{ $storeUrl }}"
              class="card-body grid grid-cols-1 gap-4 md:grid-cols-3">
            @csrf

            <div>
                <label for="code" class="label mb-2 block">Mã rate</label>
                <input id="code" name="code" value="{{ old('code') }}" class="input"
                       maxlength="64" required>
                @error('code')<p class="mt-1 text-xs text-destructive">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="status" class="label mb-2 block">Trạng thái</label>
                <select id="status" name="status" class="input" required>
                    <option value="1" @selected(old('status', '1') === '1')>Bật</option>
                    <option value="0" @selected(old('status') === '0')>Tắt</option>
                </select>
                @error('status')<p class="mt-1 text-xs text-destructive">{{ $message }}</p>@enderror
            </div>

            <div class="flex items-end">
                <button type="submit" class="btn-primary">Thêm</button>
            </div>
        </form>
    </div>

    <h2 class="mb-4 text-base font-semibold">
        {{ $heading }} <span class="text-muted-foreground">({{ $records->count() }})</span>
    </h2>

    @if ($records->isEmpty())
        <div class="card">
            <div class="card-body text-center text-muted-foreground">Chưa có mức nào.</div>
        </div>
    @else
        <div class="card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead class="border-b border-border bg-muted/50 text-left">
                        <tr>
                            <th class="px-4 py-3 font-medium">ID</th>
                            <th class="px-4 py-3 font-medium">Mã rate</th>
                            <th class="px-4 py-3 font-medium">Trạng thái</th>
                            <th class="px-4 py-3 font-medium">Tạo lúc</th>
                            <th class="px-4 py-3 text-right font-medium">Hành động</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-border">
                        @foreach ($records as $record)
                            <tr>
                                <td class="px-4 py-3 font-mono text-xs">#{{ $record->id }}</td>
                                <td class="px-4 py-3 font-medium">{{ $record->code }}</td>
                                <td class="px-4 py-3">
                                    @if ((string) $record->status === '1')
                                        <span class="badge-success">Bật</span>
                                    @else
                                        <span class="badge-secondary">Tắt</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3 text-muted-foreground">
                                    {{ optional($record->created_at)->format('d/m/Y H:i') ?? '—' }}
                                </td>
                                <td class="px-4 py-3 text-right">
                                    <form method="POST"
                                          action="{{ $isRates
                                                ? route('admin.rates.destroy', $record)
                                                : route('admin.rateorders.destroy', $record) }}"
                                          class="inline"
                                          onsubmit="return confirm('Xoá mức rate {{ $record->code }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-destructive btn-sm">Xoá</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@endif
@endsection
