@extends('layouts.app')
@section('title', 'Truy cập bị từ chối')

@section('content')
<div class="mx-auto max-w-lg py-16 text-center">
    <p class="text-6xl font-bold text-destructive">403</p>

    <h1 class="mt-4 text-2xl font-semibold">Yêu cầu bị từ chối</h1>

    <p class="mt-2 text-muted-foreground">
        {{ $message ?? 'Bạn không có quyền truy cập tài nguyên này.' }}
    </p>

    {{--
        Lưu ý bảo mật: KHÔNG in ra payload hay tên quy tắc đã khớp.
        Nếu hiển thị, kẻ tấn công sẽ biết chính xác bộ lọc nào bắt được
        mình và dò cách vượt qua. Chi tiết chỉ ghi vào bảng
        security_events và log channel `security` cho admin xem.
    --}}

    <div class="mt-6 flex justify-center gap-3">
        <a href="{{ route('home') }}" class="btn-primary">Về trang chủ</a>
        <a href="{{ url()->previous() }}" class="btn-outline">Quay lại</a>
    </div>
</div>
@endsection
