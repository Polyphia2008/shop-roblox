@extends('layouts.app')
@section('title', 'Quá nhiều yêu cầu')

@section('content')
<div class="mx-auto max-w-lg py-16 text-center">
    <p class="text-6xl font-bold text-primary">429</p>
    <h1 class="mt-4 text-2xl font-semibold">Bạn thao tác quá nhanh</h1>
    <p class="mt-2 text-muted-foreground">Vui lòng chờ một lát rồi thử lại.</p>

    <div class="mt-6">
        <a href="{{ route('home') }}" class="btn-primary">Về trang chủ</a>
    </div>
</div>
@endsection
