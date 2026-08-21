<footer class="mt-10 border-t border-border bg-card">
    <div class="mx-auto flex max-w-7xl flex-col gap-2 px-4 py-6 text-sm text-muted-foreground md:flex-row md:items-center">
        <p>&copy; {{ date('Y') }} {{ \App\Models\Setting::get('title', 'Shop Roblox') }}. Bảo lưu mọi quyền.</p>

        <nav class="flex flex-wrap gap-4 md:ml-auto">
            <a href="{{ route('warranty-policy') }}" class="hover:text-foreground">Chính sách bảo hành</a>
            <a href="{{ route('use-report') }}" class="hover:text-foreground">Hướng dẫn báo cáo</a>
            <a href="{{ route('2fa') }}" class="hover:text-foreground">Bảo mật 2FA</a>
        </nav>
    </div>
</footer>
