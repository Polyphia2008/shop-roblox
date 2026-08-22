@extends('layouts.app')
@section('title', 'Không tìm thấy trang')

@section('content')
<div class="mx-auto max-w-lg py-16 text-center">
    <p class="text-6xl font-bold text-primary">404</p>
    <h1 class="mt-4 text-2xl font-semibold">Không tìm thấy trang</h1>
    <p class="mt-2 text-muted-foreground">Trang bạn tìm không tồn tại hoặc đã bị di chuyển.</p>

    <div class="mt-6">
        <a href="{{ route('home') }}" class="btn-primary">Về trang chủ</a>
    </div>
</div>
@endsection
