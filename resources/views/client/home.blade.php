@extends('layouts.app')
@section('title', 'Trang chủ')

@section('content')
{{-- Bộ lọc theo mức rate --}}
@if ($rates->isNotEmpty())
    <div class="card mb-6">
        <div class="card-body">
            <h2 class="mb-3 text-base font-semibold">Chọn mức rate</h2>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('home') }}"
                   class="{{ $rateCode === '' ? 'btn-primary' : 'btn-outline' }} text-sm">
                    Tất cả
                </a>

                @foreach ($rates as $rate)
                    <a href="{{ route('home', ['rate_code' => $rate->code]) }}"
                       class="{{ $rateCode === (string) $rate->code ? 'btn-primary' : 'btn-outline' }} text-sm">
                        {{ $rate->code }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endif

<div class="mb-4 flex items-center justify-between">
    <h1 class="text-lg font-semibold">Tài khoản đã nạp Robux</h1>
    <span class="text-sm text-muted-foreground">{{ $accounts->total() }} tài khoản</span>
</div>

@if ($accounts->isEmpty())
    <div class="card"><div class="card-body text-center text-muted-foreground">
        Hiện chưa có tài khoản nào đang bán.
    </div></div>
@else
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
        @foreach ($accounts as $account)
            <div class="card flex flex-col">
                <div class="card-body flex-1 space-y-2">
                    <div class="flex items-start justify-between gap-2">
                        <span class="badge-secondary">#{{ $account->id }}</span>

                        @if ($account->premium === '1')
                            <span class="badge-primary">Premium</span>
                        @endif
                    </div>

                    <p class="text-2xl font-bold text-primary">
                        {{ number_format((int) $account->robux, 0, ',', '.') }}
                        <span class="text-sm font-normal text-muted-foreground">Robux</span>
                    </p>

                    <dl class="space-y-1 text-sm text-muted-foreground">
                        <div class="flex justify-between">
                            <dt>Rate</dt><dd class="font-medium text-foreground">{{ $account->rate }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt>Bảo hành</dt>
                            <dd class="font-medium text-foreground">{{ $account->guarantee ?: 'Không' }}</dd>
                        </div>
                        @if ($account->datejoin)
                            <div class="flex justify-between">
                                <dt>Ngày tạo</dt><dd class="font-medium text-foreground">{{ $account->datejoin }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>

                <div class="card-footer flex items-center justify-between gap-2">
                    <span class="font-semibold">{{ number_format((int) $account->price, 0, ',', '.') }}đ</span>

                    @auth
                        {{--
                            Form chỉ gửi ID. KHÔNG có input giá — giá luôn
                            đọc lại từ DB trong PurchaseService. Bản gốc gửi
                            giá từ client nên có thể sửa DevTools mua 0đ.
                        --}}
                        <form method="POST" action="{{ route('purchase.robux') }}"
                              onsubmit="return confirm('Xác nhận mua tài khoản #{{ $account->id }}?')">
                            @csrf
                            <input type="hidden" name="id" value="{{ $account->id }}">
                            <button type="submit" class="btn-primary text-sm">Mua ngay</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn-outline text-sm">Đăng nhập để mua</a>
                    @endauth
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6">{{ $accounts->links() }}</div>
@endif

{{-- Chuyên mục nick thường --}}
@if ($categories->isNotEmpty())
    <h2 class="mb-4 mt-10 text-lg font-semibold">Nick game theo chuyên mục</h2>

    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ($categories as $category)
            <a href="{{ route('category', $category->code) }}" class="card transition hover:border-primary">
                <div class="card-body space-y-2">
                    @if ($category->logo)
                        {{-- lazysizes: ảnh chỉ tải khi cuộn tới --}}
                        <img data-src="{{ $category->logo }}" alt="{{ $category->title }}"
                             class="lazyload h-32 w-full rounded-md object-cover" loading="lazy">
                    @endif

                    <h3 class="font-medium">{{ $category->title }}</h3>
                    <p class="text-sm text-muted-foreground">Đã bán: {{ number_format((int) $category->buy, 0, ',', '.') }}</p>
                    <p class="font-semibold text-primary">{{ number_format((int) $category->price, 0, ',', '.') }}đ</p>
                </div>
            </a>
        @endforeach
    </div>
@endif
@endsection
