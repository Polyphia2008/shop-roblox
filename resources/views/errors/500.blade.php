@extends('layouts.app')
@section('title', 'Lỗi hệ thống')

@section('content')
<div class="mx-auto max-w-lg py-16 text-center">
    <p class="text-6xl font-bold text-destructive">500</p>
    <h1 class="mt-4 text-2xl font-semibold">Có lỗi xảy ra</h1>

    {{-- Không in chi tiết exception ra ngoài để tránh lộ cấu trúc hệ thống --}}
    <p class="mt-2 text-muted-foreground">Hệ thống đang gặp sự cố. Vui lòng thử lại sau.</p>

    <div class="mt-6">
        <a href="{{ route('home') }}" class="btn-primary">Về trang chủ</a>
    </div>
</div>
@endsection
