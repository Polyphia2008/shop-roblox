@extends('layouts.admin')
@section('title', 'Nhật ký bảo mật')

@section('content')
<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
    <div>
        <h1 class="text-xl font-semibold">Nhật ký bảo mật</h1>
        <p class="mt-1 text-sm text-muted-foreground">
            Các request bị middleware chặn vì có dấu hiệu tấn công.
        </p>
    </div>
    <span class="text-sm text-muted-foreground">{{ $events->total() }} bản ghi</span>
</div>

{{-- ================================================================
     Đây là LỚP PHÒNG THỦ THỨ HAI, không phải lớp chính.
     Lớp chính là prepared statement (Eloquent binding) — kể cả khi
     regex không nhận ra một payload, câu lệnh SQL vẫn không bị thay
     đổi cấu trúc. Nhật ký này để phát hiện ai đang thử tấn công.

     Payload được in bằng {{ }} nên nội dung như
     <script>fetch('/admin/...')</script> chỉ hiển thị dưới dạng văn
     bản — tránh biến trang nhật ký thành lỗ XSS đánh vào chính admin.
     ================================================================ --}}
@if ($events->isEmpty())
    <div class="card">
        <div class="card-body text-center text-muted-foreground">
            Chưa ghi nhận request đáng ngờ nào.
        </div>
    </div>
@else
    <div class="space-y-3">
        @foreach ($events as $event)
            <div class="card">
                <div class="card-body space-y-3">

                    <div class="flex flex-wrap items-center gap-2">
                        @if (in_array($event->severity, ['critical', 'high'], true))
                            <span class="badge-destructive">{{ $event->severity }}</span>
                        @elseif ($event->severity === 'medium')
                            <span class="badge-warning">{{ $event->severity }}</span>
                        @else
                            <span class="badge-secondary">{{ $event->severity }}</span>
                        @endif

                        <span class="text-sm font-medium">{{ $event->type }}</span>

                        <span class="ml-auto text-xs text-muted-foreground">
                            #{{ $event->id }} ·
                            {{ $event->created_at?->format('d/m/Y H:i:s') ?? '—' }}
                        </span>
                    </div>

                    <div class="grid grid-cols-1 gap-3 text-sm sm:grid-cols-2">
                        <div>
                            <p class="text-xs text-muted-foreground">Nguồn</p>
                            <p class="font-mono text-xs break-all">
                                {{ $event->ip ?: '—' }}
                                @if ($event->user_id)
                                    · user #{{ $event->user_id }}
                                @endif
                            </p>
                        </div>
                        <div>
                            <p class="text-xs text-muted-foreground">Đích</p>
                            <p class="font-mono text-xs break-all">
                                {{ $event->method }} {{ Str::limit($event->url, 90) }}
                            </p>
                        </div>
                    </div>

                    <div>
                        <p class="text-xs text-muted-foreground">
                            Tham số: <span class="font-mono">{{ $event->parameter ?: '—' }}</span>
                        </p>
                        <pre class="mt-1 overflow-x-auto rounded-md bg-muted/40 p-3 font-mono
                                    text-xs whitespace-pre-wrap break-all"
                        >{{ $event->payload }}</pre>
                    </div>

                    @if ($event->rule)
                        <p class="text-xs text-muted-foreground">
                            Quy tắc khớp: <span class="font-mono">{{ $event->rule }}</span>
                        </p>
                    @endif

                    @if ($event->user_agent)
                        <p class="text-xs text-muted-foreground break-all">
                            UA: {{ Str::limit($event->user_agent, 140) }}
                        </p>
                    @endif
                </div>
            </div>
        @endforeach
    </div>

    <div class="mt-6">{{ $events->links() }}</div>
@endif
@endsection
