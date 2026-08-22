@extends('layouts.app')
@section('title', $category->title)

@section('content')
<div class="mx-auto max-w-2xl">
    <div class="card">
        <div class="card-header">
            <h1 class="text-xl font-semibold">{{ $category->title }}</h1>
            <p class="mt-1 text-sm text-muted-foreground">Mã chuyên mục: {{ $category->code }}</p>
        </div>

        <div class="card-body space-y-4">
            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-muted-foreground">Giá mỗi nick</p>
                    <p class="text-lg font-semibold text-primary">
                        {{ number_format((int) $category->price, 0, ',', '.') }}đ
                    </p>
                </div>
                <div>
                    <p class="text-muted-foreground">Còn trong kho</p>
                    <p class="text-lg font-semibold">{{ number_format($stock, 0, ',', '.') }}</p>
                </div>
            </div>

            @if ($category->note)
                <div class="alert-info whitespace-pre-line">{{ $category->note }}</div>
            @endif

            @auth
                @if ($stock < 1)
                    <div class="alert-error">Chuyên mục này đã hết hàng.</div>
                @else
                    {{-- Chỉ gửi code + số lượng; tổng tiền tính ở server --}}
                    <form method="POST" action="{{ route('purchase.nick') }}" class="space-y-4"
                          x-data="{ qty: 1, price: {{ (int) $category->price }} }">
                        @csrf
                        <input type="hidden" name="code" value="{{ $category->code }}">

                        <div>
                            <label for="quantity" class="mb-2 block text-sm font-medium">Số lượng</label>
                            <input id="quantity" name="quantity" type="number" x-model.number="qty"
                                   min="1" max="{{ min(50, $stock) }}" value="1" required class="input">
                            <p class="mt-2 text-sm text-muted-foreground">
                                Tạm tính:
                                <span class="font-semibold text-foreground"
                                      x-text="(qty * price).toLocaleString('vi-VN') + 'đ'"></span>
                            </p>
                        </div>

                        <button type="submit" class="btn-primary w-full"
                                onclick="return confirm('Xác nhận mua nick?')">
                            Mua ngay
                        </button>
                    </form>
                @endif
            @else
                <a href="{{ route('login') }}" class="btn-primary w-full">Đăng nhập để mua</a>
            @endauth
        </div>
    </div>
</div>
@endsection
