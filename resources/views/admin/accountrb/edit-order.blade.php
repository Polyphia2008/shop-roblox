@extends('layouts.admin')
@section('title', 'Xử lý đơn #'.$order->id)

@section('content')
<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
    <div>
        <h1 class="text-xl font-semibold">Xử lý đơn #{{ $order->id }}</h1>
        <p class="mt-1 text-sm text-muted-foreground break-all">
            Mã GD: <span class="font-mono">{{ $order->magd }}</span> · {{ $order->username }}
        </p>
    </div>
    <a href="{{ route('admin.accountrb.orders') }}" class="btn-outline">Về danh sách</a>
</div>

<div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

    <form method="POST" action="{{ route('admin.accountrb.orders.update', $order) }}"
          class="space-y-6 lg:col-span-2">
        @csrf
        @method('PATCH')

        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Cập nhật đơn</h2>
            </div>
            <div class="card-body grid grid-cols-1 gap-4 sm:grid-cols-2">

                <div>
                    <label for="robux" class="label mb-2 block">Số Robux</label>
                    <input id="robux" name="robux" type="number" min="0" max="100000000" required
                           value="{{ old('robux', $order->robux) }}" class="input">
                    @error('robux')
                        <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="price" class="label mb-2 block">Số tiền (đ)</label>
                    <input id="price" name="price" type="number" min="0" max="1000000000" required
                           value="{{ old('price', $order->price) }}" class="input">
                    @error('price')
                        <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="guarantee" class="label mb-2 block">Thời hạn bảo hành</label>
                    <input id="guarantee" name="guarantee" type="text" maxlength="64"
                           value="{{ old('guarantee', $order->guarantee) }}" class="input">
                    @error('guarantee')
                        <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status" class="label mb-2 block">Trạng thái</label>
                    {{-- Chỉ nhận 1/2/3 (validate 'in:1,2,3'); giá trị lạ bị
                         từ chối nên không có đường đưa trạng thái tuỳ ý vào DB. --}}
                    <select id="status" name="status" required class="input">
                        <option value="3" @selected((string) old('status', $order->status) === '3')>Đang xử lý</option>
                        <option value="1" @selected((string) old('status', $order->status) === '1')>Hoàn tất</option>
                        <option value="2" @selected((string) old('status', $order->status) === '2')>Đã huỷ</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Thông tin giao cho khách</h2>
                <p class="text-sm text-muted-foreground">
                    Nội dung được mã hoá khi lưu và chỉ khách sở hữu đơn xem được.
                </p>
            </div>
            <div class="card-body">
                <textarea id="information" name="information" rows="6" maxlength="5000"
                          class="input h-auto font-mono text-xs"
                >{{ old('information', $order->information) }}</textarea>
                @error('information')
                    <p class="mt-1 text-xs text-destructive">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <button type="submit" class="btn-primary">Lưu thay đổi</button>
    </form>

    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Thông tin đơn</h2>
        </div>
        <div class="card-body space-y-3 text-sm">
            <div class="flex items-center justify-between gap-2">
                <span class="text-muted-foreground">Khách</span>
                <span class="truncate font-medium">{{ $order->username }}</span>
            </div>
            <div class="flex items-center justify-between gap-2">
                <span class="text-muted-foreground">Người bán</span>
                <span class="truncate font-medium">{{ $order->seller ?: '—' }}</span>
            </div>
            <div class="flex items-center justify-between gap-2">
                <span class="text-muted-foreground">Rate</span>
                <span class="font-medium">{{ $order->rate }}</span>
            </div>
            <div class="flex items-center justify-between gap-2">
                <span class="text-muted-foreground">Giao hàng</span>
                <span class="font-medium">{{ $order->giaohang ?: '—' }}</span>
            </div>
            <div class="flex items-center justify-between gap-2">
                <span class="text-muted-foreground">Tạo lúc</span>
                <span class="font-medium">
                    {{ $order->created_at?->format('d/m/Y H:i') ?? '—' }}
                </span>
            </div>
        </div>
    </div>
</div>
@endsection
