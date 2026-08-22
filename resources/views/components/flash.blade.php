{{--
    Hiển thị thông báo session.
    Dùng {{ }} (tự escape) chứ không dùng {!! !!} -> chống XSS.
    Bản gốc echo trực tiếp biến vào HTML nên chèn được thẻ script.
--}}
@if (session('success'))
    <div class="alert-success mb-4" role="status">{{ session('success') }}</div>
@endif

@if (session('error'))
    <div class="alert-error mb-4" role="alert">{{ session('error') }}</div>
@endif

{{--
    $errors do middleware ShareErrorsFromSession chèn vào view. Middleware
    đó thuộc nhóm `web` (chạy SAU session), nên khi một middleware TOÀN CỤC
    render view — ví dụ DetectSqlInjection trả về trang 403 — biến $errors
    CHƯA tồn tại. Nếu tham chiếu thẳng, trang 403 sẽ nổ thành 500 và kẻ tấn
    công lại nhận được stack trace. Vì vậy phải kiểm tra isset trước.
--}}
@if (isset($errors) && $errors->any())
    <div class="alert-error mb-4" role="alert">
        <ul class="list-inside list-disc space-y-1">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
