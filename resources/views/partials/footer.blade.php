{{--
    ==================================================================
     footer.blade.php — Footer theo theme gốc Tailwick
    ------------------------------------------------------------------
     Giữ cấu trúc footer.php của source cũ: container-fluid + grid 12 cột,
     chữ nhỏ tông slate/zink, nằm trong vùng nội dung (sau sidebar).
    ==================================================================
--}}
<footer class="bg-white border-t border-slate-200 dark:bg-zink-700 dark:border-zink-500 print:hidden">
    <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto px-5 py-4">
        <div class="grid items-center grid-cols-12 gap-3">
            <div class="col-span-12 md:col-span-6">
                <p class="text-sm text-slate-500 dark:text-zink-200">
                    &copy; {{ date('Y') }} {{ \App\Models\Setting::get('title', 'Shop Roblox') }}. Bảo lưu mọi quyền.
                </p>
            </div>
            <div class="col-span-12 md:col-span-6">
                <nav class="flex flex-wrap gap-4 text-sm ltr:md:text-right rtl:md:text-left md:justify-end">
                    <a href="{{ route('warranty-policy') }}" class="text-slate-500 dark:text-zink-200 hover:text-custom-500">Chính sách bảo hành</a>
                    <a href="{{ route('use-report') }}" class="text-slate-500 dark:text-zink-200 hover:text-custom-500">Hướng dẫn báo cáo</a>
                    <a href="{{ route('2fa') }}" class="text-slate-500 dark:text-zink-200 hover:text-custom-500">Bảo mật 2FA</a>
                </nav>
            </div>
        </div>
    </div>
</footer>
</content>
