  <a type="button" href="<?=$VCD->site('link_facebook');?>" target="_blank" class="custom-crisp-icon" id="customCrispIcon"></a>
  <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
    <div class="grid grid-cols-12 grid grid-cols-12 gap-x-5 ">
        <div class="order-6 col-span-12 2xl:order-1  2xl:col-span-4 mb-5">
            <div
                class="flex items-center  group-data-[layout=horizontal]:hidden group-data-[sidebar-size=sm]:fixed group-data-[sidebar-size=sm]:top-0 group-data-[sidebar-size=sm]:bg-vertical-menu group-data-[sidebar-size=sm]:group-data-[sidebar=dark]:bg-vertical-menu-dark group-data-[sidebar-size=sm]:group-data-[sidebar=brand]:bg-vertical-menu-brand group-data-[sidebar-size=sm]:group-data-[sidebar=modern]:bg-gradient-to-br group-data-[sidebar-size=sm]:group-data-[sidebar=modern]:to-vertical-menu-to-modern group-data-[sidebar-size=sm]:group-data-[sidebar=modern]:from-vertical-menu-form-modern group-data-[sidebar-size=sm]:group-data-[sidebar=modern]:bg-vertical-menu-modern group-data-[sidebar-size=sm]:z-10 group-data-[sidebar-size=sm]:w-[calc(theme('spacing.vertical-menu-sm')_-_1px)] group-data-[sidebar-size=sm]:group-data-[sidebar=dark]:dark:bg-zink-700">
                <a href="https://sellrobux.com"
                   class="group-data-[sidebar=dark]:hidden group-data-[sidebar=brand]:hidden group-data-[sidebar=modern]:hidden">
                    <span class="group-data-[sidebar-size=sm]:hidden">
                    <img src="https://sellrobux.com/assets/logo_new/2.png?v=2" alt="" class="h-7 mx-auto">
                </span>
                </a>
                <a href="https://sellrobux.com"
                   class="hidden group-data-[sidebar=dark]:block group-data-[sidebar=brand]:block group-data-[sidebar=modern]:block">
                    <span class="group-data-[sidebar-size=sm]:hidden">
                    <img src="https://sellrobux.com/assets/logo_new/2.png?v=2" alt="" class="h-7 mx-auto">
                </span>
                </a>
                <button type="button" class="hidden p-0 float-end" id="vertical-hover">
                    <i class="ri-record-circle-line"></i>
                </button>
            </div>
            <div>
                <p>Chúng tôi kết nối người bán và người mua hạn chế tối đa dủi do bị lừa đảo<br>Quá trình mua bán nếu gặp sự cố, sử dụng chức năng khiếu nại tại lịch sử mua hàng<br>Nếu khiếu nại không được giải quyết vui lòng liên hệ với chúng tôi qua mục hỗ trợ.</p>
            </div>
            <span class="block mt-2">
                © 2025 <?= $VCD->site('Author') ?> - Mua Bán Robux Giá Rẻ
            </span>
        </div>
        <div class="order-7 col-span-12 2xl:order-1  2xl:col-span-2">

        </div>
        <style>.footer-column ul {
    display: flex;
    gap: 40px; 
    flex-wrap: wrap;
}
.footer-column li[aria-label="Social Media"] {
    display: flex;
    flex-direction: column;
    align-items: flex-start; 
}
.footer-column h3 {
    margin-bottom: 6px; 
}

.footer-column ul ul {
    display: flex;
    flex-direction: column;
    gap: 5px; 
}

.footer-column a {
    text-decoration: none; 
}

</style>
      <div class="order-7 col-span-12 2xl:order-1  2xl:col-span-6 footer-column ">
            <ul class="flex mt-4 gap-4rem">
             <li aria-label="Social Media">
                    <h3 class="font-semibold text-lg">Thông tin</h3>
                    <ul class="space-y-5 rounded-md mt-2">
                        <li aria-label="Twitter">
                            <a class="text-gray-1 transition-all duration-300 hover:text-custom-500" target="_blank" href="<?= $VCD->site('email') ?>">
                              Email: <?= $VCD->site('email') ?>
                            </a>
                        </li>
                    
                    </ul>
                </li>
                <li aria-label="Social Media">
                    <h3 class="font-semibold text-lg">Hỗ trợ</h3>
                    <ul class="space-y-5 rounded-md mt-2">
                        <li aria-label="Twitter">
                            <a class="text-gray-1 transition-all duration-300 hover:text-custom-500" target="_blank" href="<?= $VCD->site('link_facebook') ?>">
                                Fanpage hỗ trợ
                            </a>
                        </li>
                         <li aria-label="Twitter">
                            <a class="text-gray-1 transition-all duration-300 hover:text-custom-500" target="_blank" href="<?= $VCD->site('hotline') ?>">
                           Hotline
                            </a>
                        </li>
                        <li aria-label="Twitter">
                            <a class="text-gray-1 transition-all duration-300 hover:text-custom-500" target="_blank" href="<?= $VCD->site('link_bot_tele') ?>">
                                Nhóm thông báo đơn</a>
                        </li>
                    </ul>
                </li>
                <li aria-label="Social Media">
                    <h3 class="font-semibold text-lg">Tài nguyên</h3>
                    <ul class="space-y-5 rounded-md mt-2">
                        <li aria-label="Twitter">
                            <a class="text-gray-1 transition-all duration-300 hover:text-custom-500" wire:navigate="" href="/auth/nick-game">
                               Tài Khoản
                            </a>
                        </li>

                    </ul>
                </li>
                <li aria-label="Social Media">
                    <h3 class="font-semibold text-lg">Hợp pháp</h3>

                </li>
            </ul>
        </div>
    </div>

</div>

            </div>
        </div>
    </div>


</div>

<div class="fixed items-center hidden bottom-6 right-12 h-header group-data-[navbar=hidden]:flex">
    <button data-drawer-target="customizerButton" type="button"
            class="inline-flex items-center justify-center w-12 h-12 p-0 transition-all duration-200 ease-linear rounded-md shadow-lg text-sky-50 bg-sky-500">
        <i data-lucide="settings" class="inline-block w-5 h-5"></i>
    </button>
</div>
<div id="customizerButton" drawer-end
     class="fixed inset-y-0 flex flex-col w-full transition-transform duration-300 ease-in-out transform bg-white shadow ltr:right-0 rtl:left-0 md:w-96 z-drawer show dark:bg-zink-600">
    <div class="flex justify-between p-4 border-b border-slate-200 dark:border-zink-500">
        <div class="grow">
            <h5 class="mb-1 text-16">Customizer</h5>
            <p class="font-normal text-slate-500 dark:text-zink-200">Choose your themes & layouts etc.</p>
        </div>
        <div class="shrink-0">
            <button data-drawer-close="customizerButton"
                    class="transition-all duration-150 ease-linear text-slate-500 hover:text-slate-800 dark:text-zink-200 dark:hover:text-zink-50">
                <i data-lucide="x" class="w-4 h-4"></i></button>
        </div>
    </div>
    <div class="h-full p-6 overflow-y-auto">
        <div>
            <h5 class="mb-3 underline capitalize text-15">Choose Layouts</h5>
            <div class="grid grid-cols-1 mb-5 gap-7 sm:grid-cols-2">
                <div class="relative">
                    <input id="layout-one" name="dataLayout"
                           class="absolute w-4 h-4 border rounded-full appearance-none cursor-pointer ltr:right-2 rtl:left-2 top-2 vertical-menu-btn bg-slate-100 border-slate-300 checked:bg-custom-500 checked:border-custom-500 dark:bg-zink-400 dark:border-zink-500"
                           type="radio" value="vertical" checked>
                    <label
                        class="block w-full h-24 p-0 overflow-hidden border rounded-lg cursor-pointer border-slate-200 dark:border-zink-500"
                        for="layout-one">
                        <span class="flex h-full gap-0">
                            <span class="shrink-0">
                                <span
                                    class="flex flex-col h-full gap-1 p-1 ltr:border-r rtl:border-l border-slate-200 dark:border-zink-500">
                                    <span class="block p-1 px-2 mb-2 rounded bg-slate-100 dark:bg-zink-400"></span>
                                    <span class="block p-1 px-2 pb-0 bg-slate-100 dark:bg-zink-500"></span>
                                    <span class="block p-1 px-2 pb-0 bg-slate-100 dark:bg-zink-500"></span>
                                    <span class="block p-1 px-2 pb-0 bg-slate-100 dark:bg-zink-500"></span>
                                </span>
                            </span>
                            <span class="grow">
                                <span class="flex flex-col h-full">
                                    <span class="block h-3 bg-slate-100 dark:bg-zink-500"></span>
                                    <span class="block h-3 mt-auto bg-slate-100 dark:bg-zink-500"></span>
                                </span>
                            </span>
                        </span>
                    </label>
                    <h5 class="mt-2 text-center text-15">Vertical</h5>
                </div>

                <div class="relative">
                    <input id="layout-two" name="dataLayout"
                           class="absolute w-4 h-4 border rounded-full appearance-none cursor-pointer ltr:right-2 rtl:left-2 top-2 vertical-menu-btn bg-slate-100 border-slate-300 checked:bg-custom-500 checked:border-custom-500 dark:bg-zink-400 dark:border-zink-500"
                           type="radio" value="horizontal">
                    <label
                        class="block w-full h-24 p-0 overflow-hidden border rounded-lg cursor-pointer border-slate-200 dark:border-zink-500"
                        for="layout-two">
                        <span class="flex flex-col h-full gap-1">
                            <span class="flex items-center gap-1 p-1 bg-slate-100 dark:bg-zink-500">
                                <span class="block p-1 ml-1 bg-white rounded dark:bg-zink-500"></span>
                                <span class="block p-1 px-2 pb-0 bg-white dark:bg-zink-500 ms-auto"></span>
                                <span class="block p-1 px-2 pb-0 bg-white dark:bg-zink-500"></span>
                            </span>
                            <span class="block p-1 bg-slate-100 dark:bg-zink-500"></span>
                            <span class="block p-1 mt-auto bg-slate-100 dark:bg-zink-500"></span>
                        </span>
                    </label>
                    <h5 class="mt-2 text-center text-15">Horizontal</h5>
                </div>
            </div>

            <div id="semi-dark">
                <div class="flex items-center">
                    <div class="relative inline-block w-10 mr-2 align-middle transition duration-200 ease-in">
                        <input type="checkbox" name="customDefaultSwitch" value="dark" id="customDefaultSwitch"
                               class="absolute block w-5 h-5 transition duration-300 ease-linear border-2 rounded-full appearance-none cursor-pointer border-slate-200 bg-white/80 peer/published checked:bg-white checked:right-0 checked:border-custom-500 arrow-none dark:border-zink-500 dark:bg-zink-500 dark:checked:bg-zink-400 checked:bg-none">
                        <label for="customDefaultSwitch"
                               class="block h-5 overflow-hidden transition duration-300 ease-linear border rounded-full cursor-pointer border-slate-200 bg-slate-200 peer-checked/published:bg-custom-500 peer-checked/published:border-custom-500 dark:border-zink-500 dark:bg-zink-600"></label>
                    </div>
                    <label for="customDefaultSwitch" class="inline-block text-base font-medium">Semi Dark (Sidebar &
                        Header)</label>
                </div>
            </div>
        </div>

        <div class="mt-6">
            <!-- data-skin="" -->
            <h5 class="mb-3 underline capitalize text-15">Skin Layouts</h5>
            <div class="grid grid-cols-1 mb-5 gap-7 sm:grid-cols-2">
                <div class="relative">
                    <input id="layoutSkitOne" name="dataLayoutSkin"
                           class="absolute w-4 h-4 border rounded-full appearance-none cursor-pointer ltr:right-2 rtl:left-2 top-2 vertical-menu-btn bg-slate-100 border-slate-300 checked:bg-custom-500 checked:border-custom-500 dark:bg-zink-400 dark:border-zink-500"
                           type="radio" value="default">
                    <label
                        class="block w-full h-24 p-0 overflow-hidden border rounded-lg cursor-pointer border-slate-200 dark:border-zink-500 bg-slate-50 dark:bg-zink-600"
                        for="layoutSkitOne">
                        <span class="flex h-full gap-0">
                            <span class="shrink-0">
                                <span
                                    class="flex flex-col h-full gap-1 p-1 ltr:border-r rtl:border-l border-slate-200 dark:border-zink-500">
                                    <span class="block p-1 px-2 mb-2 rounded bg-slate-100 dark:bg-zink-400"></span>
                                    <span class="block p-1 px-2 pb-0 bg-slate-100 dark:bg-zink-500"></span>
                                    <span class="block p-1 px-2 pb-0 bg-slate-100 dark:bg-zink-500"></span>
                                    <span class="block p-1 px-2 pb-0 bg-slate-100 dark:bg-zink-500"></span>
                                </span>
                            </span>
                            <span class="grow">
                                <span class="flex flex-col h-full">
                                    <span class="block h-3 bg-slate-100 dark:bg-zink-500"></span>
                                    <span class="block h-3 mt-auto bg-slate-100 dark:bg-zink-500"></span>
                                </span>
                            </span>
                        </span>
                    </label>
                    <h5 class="mt-2 text-center text-15">Default</h5>
                </div>

                <div class="relative">
                    <input id="layoutSkitTwo" name="dataLayoutSkin"
                           class="absolute w-4 h-4 border rounded-full appearance-none cursor-pointer ltr:right-2 rtl:left-2 top-2 vertical-menu-btn bg-slate-100 border-slate-300 checked:bg-custom-500 checked:border-custom-500 dark:bg-zink-400 dark:border-zink-500"
                           type="radio" value="bordered" checked>
                    <label
                        class="block w-full h-24 p-0 overflow-hidden border rounded-lg cursor-pointer border-slate-200 dark:border-zink-500"
                        for="layoutSkitTwo">
                        <span class="flex h-full gap-0">
                            <span class="shrink-0">
                                <span
                                    class="flex flex-col h-full gap-1 p-1 ltr:border-r rtl:border-l border-slate-200 dark:border-zink-500">
                                    <span class="block p-1 px-2 mb-2 rounded bg-slate-100 dark:bg-zink-400"></span>
                                    <span class="block p-1 px-2 pb-0 bg-slate-100 dark:bg-zink-500"></span>
                                    <span class="block p-1 px-2 pb-0 bg-slate-100 dark:bg-zink-500"></span>
                                    <span class="block p-1 px-2 pb-0 bg-slate-100 dark:bg-zink-500"></span>
                                </span>
                            </span>
                            <span class="grow">
                                <span class="flex flex-col h-full">
                                    <span class="block h-3 border-b border-slate-200 dark:border-zink-500"></span>
                                    <span
                                        class="block h-3 mt-auto border-t border-slate-200 dark:border-zink-500"></span>
                                </span>
                            </span>
                        </span>
                    </label>
                    <h5 class="mt-2 text-center text-15">Bordered</h5>
                </div>
            </div>
        </div>

        <div class="mt-6">
            <!-- data-mode="" -->
            <h5 class="mb-3 underline capitalize text-15">Light & Dark</h5>
            <div class="flex gap-3">
                <button type="button" id="dataModeOne" name="dataMode" value="light"
                        class="transition-all duration-200 ease-linear bg-white border-dashed text-slate-500 btn border-slate-200 hover:text-slate-500 hover:bg-slate-50 hover:border-slate-200 [&.active]:text-custom-500 [&.active]:bg-custom-50 [&.active]:border-custom-200 dark:bg-zink-600 dark:text-zink-200 dark:border-zink-400 dark:hover:bg-zink-600 dark:hover:text-zink-100 dark:hover:border-zink-400 dark:[&.active]:bg-custom-500/10 dark:[&.active]:border-custom-500/30 dark:[&.active]:text-custom-500 active">
                    Light Mode
                </button>
                <button type="button" id="dataModeTwo" name="dataMode" value="dark"
                        class="transition-all duration-200 ease-linear bg-white border-dashed text-slate-500 btn border-slate-200 hover:text-slate-500 hover:bg-slate-50 hover:border-slate-200 [&.active]:text-custom-500 [&.active]:bg-custom-50 [&.active]:border-custom-200 dark:bg-zink-600 dark:text-zink-200 dark:border-zink-400 dark:hover:bg-zink-600 dark:hover:text-zink-100 dark:hover:border-zink-400 dark:[&.active]:bg-custom-500/10 dark:[&.active]:border-custom-500/30 dark:[&.active]:text-custom-500">
                    Dark Mode
                </button>
            </div>
        </div>

        <div class="mt-6">
            <!-- dir="ltr" -->
            <h5 class="mb-3 underline capitalize text-15">LTR & RTL</h5>
            <div class="flex flex-wrap gap-3">
                <button type="button" id="diractionOne" name="dir" value="ltr"
                        class="transition-all duration-200 ease-linear bg-white border-dashed text-slate-500 btn border-slate-200 hover:text-slate-500 hover:bg-slate-50 hover:border-slate-200 [&.active]:text-custom-500 [&.active]:bg-custom-50 [&.active]:border-custom-200 dark:bg-zink-600 dark:text-zink-200 dark:border-zink-400 dark:hover:bg-zink-600 dark:hover:text-zink-100 dark:hover:border-zink-400 dark:[&.active]:bg-custom-500/10 dark:[&.active]:border-custom-500/30 dark:[&.active]:text-custom-500 active">
                    LTR Mode
                </button>
                <button type="button" id="diractionTwo" name="dir" value="rtl"
                        class="transition-all duration-200 ease-linear bg-white border-dashed text-slate-500 btn border-slate-200 hover:text-slate-500 hover:bg-slate-50 hover:border-slate-200 [&.active]:text-custom-500 [&.active]:bg-custom-50 [&.active]:border-custom-200 dark:bg-zink-600 dark:text-zink-200 dark:border-zink-400 dark:hover:bg-zink-600 dark:hover:text-zink-100 dark:hover:border-zink-400 dark:[&.active]:bg-custom-500/10 dark:[&.active]:border-custom-500/30 dark:[&.active]:text-custom-500">
                    RTL Mode
                </button>
            </div>
        </div>

        <div class="mt-6">
            <!-- data-content -->
            <h5 class="mb-3 underline capitalize text-15">Content Width</h5>
            <div class="flex gap-3">
                <button type="button" id="datawidthOne" name="datawidth" value="fluid"
                        class="transition-all duration-200 ease-linear bg-white border-dashed text-slate-500 btn border-slate-200 hover:text-slate-500 hover:bg-slate-50 hover:border-slate-200 [&.active]:text-custom-500 [&.active]:bg-custom-50 [&.active]:border-custom-200 dark:bg-zink-600 dark:text-zink-200 dark:border-zink-400 dark:hover:bg-zink-600 dark:hover:text-zink-100 dark:hover:border-zink-400 dark:[&.active]:bg-custom-500/10 dark:[&.active]:border-custom-500/30 dark:[&.active]:text-custom-500 active">
                    Fluid
                </button>
                <button type="button" id="datawidthTwo" name="datawidth" value="boxed"
                        class="transition-all duration-200 ease-linear bg-white border-dashed text-slate-500 btn border-slate-200 hover:text-slate-500 hover:bg-slate-50 hover:border-slate-200 [&.active]:text-custom-500 [&.active]:bg-custom-50 [&.active]:border-custom-200 dark:bg-zink-600 dark:text-zink-200 dark:border-zink-400 dark:hover:bg-zink-600 dark:hover:text-zink-100 dark:hover:border-zink-400 dark:[&.active]:bg-custom-500/10 dark:[&.active]:border-custom-500/30 dark:[&.active]:text-custom-500">
                    Boxed
                </button>
            </div>
        </div>

        <div class="mt-6" id="sidebar-size">
            <!-- data-sidebar-size="" -->
            <h5 class="mb-3 underline capitalize text-15">Sidebar Size</h5>
            <div class="flex flex-wrap gap-3">
                <button type="button" id="sidebarSizeOne" name="sidebarSize" value="lg"
                        class="transition-all duration-200 ease-linear bg-white border-dashed text-slate-500 btn border-slate-200 hover:text-slate-500 hover:bg-slate-50 hover:border-slate-200 [&.active]:text-custom-500 [&.active]:bg-custom-50 [&.active]:border-custom-200 dark:bg-zink-600 dark:text-zink-200 dark:border-zink-400 dark:hover:bg-zink-600 dark:hover:text-zink-100 dark:hover:border-zink-400 dark:[&.active]:bg-custom-500/10 dark:[&.active]:border-custom-500/30 dark:[&.active]:text-custom-500 active">
                    Default
                </button>
                <button type="button" id="sidebarSizeTwo" name="sidebarSize" value="md"
                        class="transition-all duration-200 ease-linear bg-white border-dashed text-slate-500 btn border-slate-200 hover:text-slate-500 hover:bg-slate-50 hover:border-slate-200 [&.active]:text-custom-500 [&.active]:bg-custom-50 [&.active]:border-custom-200 dark:bg-zink-600 dark:text-zink-200 dark:border-zink-400 dark:hover:bg-zink-600 dark:hover:text-zink-100 dark:hover:border-zink-400 dark:[&.active]:bg-custom-500/10 dark:[&.active]:border-custom-500/30 dark:[&.active]:text-custom-500">
                    Compact
                </button>
                <button type="button" id="sidebarSizeThree" name="sidebarSize" value="sm"
                        class="transition-all duration-200 ease-linear bg-white border-dashed text-slate-500 btn border-slate-200 hover:text-slate-500 hover:bg-slate-50 hover:border-slate-200 [&.active]:text-custom-500 [&.active]:bg-custom-50 [&.active]:border-custom-200 dark:bg-zink-600 dark:text-zink-200 dark:border-zink-400 dark:hover:bg-zink-600 dark:hover:text-zink-100 dark:hover:border-zink-400 dark:[&.active]:bg-custom-500/10 dark:[&.active]:border-custom-500/30 dark:[&.active]:text-custom-500">
                    Small (Icon)
                </button>
            </div>
        </div>

        <div class="mt-6" id="navigation-type">
            <!-- data-navbar="" -->
            <h5 class="mb-3 underline capitalize text-15">Navigation Type</h5>
            <div class="flex flex-wrap gap-3">
                <button type="button" id="navbarTwo" name="navbar" value="sticky"
                        class="transition-all duration-200 ease-linear bg-white border-dashed text-slate-500 btn border-slate-200 hover:text-slate-500 hover:bg-slate-50 hover:border-slate-200 [&.active]:text-custom-500 [&.active]:bg-custom-50 [&.active]:border-custom-200 dark:bg-zink-600 dark:text-zink-200 dark:border-zink-400 dark:hover:bg-zink-600 dark:hover:text-zink-100 dark:hover:border-zink-400 dark:[&.active]:bg-custom-500/10 dark:[&.active]:border-custom-500/30 dark:[&.active]:text-custom-500 active">
                    Sticky
                </button>
                <button type="button" id="navbarOne" name="navbar" value="scroll"
                        class="transition-all duration-200 ease-linear bg-white border-dashed text-slate-500 btn border-slate-200 hover:text-slate-500 hover:bg-slate-50 hover:border-slate-200 [&.active]:text-custom-500 [&.active]:bg-custom-50 [&.active]:border-custom-200 dark:bg-zink-600 dark:text-zink-200 dark:border-zink-400 dark:hover:bg-zink-600 dark:hover:text-zink-100 dark:hover:border-zink-400 dark:[&.active]:bg-custom-500/10 dark:[&.active]:border-custom-500/30 dark:[&.active]:text-custom-500">
                    Scroll
                </button>
                <button type="button" id="navbarThree" name="navbar" value="bordered"
                        class="transition-all duration-200 ease-linear bg-white border-dashed text-slate-500 btn border-slate-200 hover:text-slate-500 hover:bg-slate-50 hover:border-slate-200 [&.active]:text-custom-500 [&.active]:bg-custom-50 [&.active]:border-custom-200 dark:bg-zink-600 dark:text-zink-200 dark:border-zink-400 dark:hover:bg-zink-600 dark:hover:text-zink-100 dark:hover:border-zink-400 dark:[&.active]:bg-custom-500/10 dark:[&.active]:border-custom-500/30 dark:[&.active]:text-custom-500">
                    Bordered
                </button>
                <button type="button" id="navbarFour" name="navbar" value="hidden"
                        class="transition-all duration-200 ease-linear bg-white border-dashed text-slate-500 btn border-slate-200 hover:text-slate-500 hover:bg-slate-50 hover:border-slate-200 [&.active]:text-custom-500 [&.active]:bg-custom-50 [&.active]:border-custom-200 dark:bg-zink-600 dark:text-zink-200 dark:border-zink-400 dark:hover:bg-zink-600 dark:hover:text-zink-100 dark:hover:border-zink-400 dark:[&.active]:bg-custom-500/10 dark:[&.active]:border-custom-500/30 dark:[&.active]:text-custom-500">
                    Hidden
                </button>
            </div>
        </div>

        <div class="mt-6" id="sidebar-color">
            <!-- data-sidebar="" light, dark, brand, modern-->
            <h5 class="mb-3 underline capitalize text-15">Sizebar Colors</h5>
            <div class="flex flex-wrap gap-3">
                <button type="button" id="sidebarColorOne" name="sidebarColor" value="light"
                        class="flex items-center justify-center w-10 h-10 bg-white border rounded-md border-slate-200 group active">
                    <i data-lucide="check" class="w-5 h-5 hidden group-[.active]:inline-block text-slate-600"></i>
                </button>
                <button type="button" id="sidebarColorTwo" name="sidebarColor" value="dark"
                        class="flex items-center justify-center w-10 h-10 border rounded-md border-zink-900 bg-zink-900 group">
                    <i data-lucide="check" class="w-5 h-5 hidden group-[.active]:inline-block text-white"></i>
                </button>
                <button type="button" id="sidebarColorThree" name="sidebarColor" value="brand"
                        class="flex items-center justify-center w-10 h-10 border rounded-md border-custom-800 bg-custom-800 group">
                    <i data-lucide="check" class="w-5 h-5 hidden group-[.active]:inline-block text-white"></i>
                </button>
                <button type="button" id="sidebarColorFour" name="sidebarColor" value="modern"
                        class="flex items-center justify-center w-10 h-10 border rounded-md border-purple-950 bg-gradient-to-t from-red-400 to-purple-500 group">
                    <i data-lucide="check" class="w-5 h-5 hidden group-[.active]:inline-block text-white"></i>
                </button>
            </div>
        </div>

        <div class="mt-6">
            <!-- data-topbar="" light, dark, brand, modern-->
            <h5 class="mb-3 underline capitalize text-15">Topbar Colors</h5>
            <div class="flex flex-wrap gap-3">
                <button type="button" id="topbarColorOne" name="topbarColor" value="light"
                        class="flex items-center justify-center w-10 h-10 bg-white border rounded-md border-slate-200 group active">
                    <i data-lucide="check" class="w-5 h-5 hidden group-[.active]:inline-block text-slate-600"></i>
                </button>
                <button type="button" id="topbarColorTwo" name="topbarColor" value="dark"
                        class="flex items-center justify-center w-10 h-10 border rounded-md border-zink-900 bg-zink-900 group">
                    <i data-lucide="check" class="w-5 h-5 hidden group-[.active]:inline-block text-white"></i>
                </button>
                <button type="button" id="topbarColorThree" name="topbarColor" value="brand"
                        class="flex items-center justify-center w-10 h-10 border rounded-md border-custom-800 bg-custom-800 group">
                    <i data-lucide="check" class="w-5 h-5 hidden group-[.active]:inline-block text-white"></i>
                </button>
            </div>
        </div>

    </div>
    <div class="flex items-center justify-between gap-3 p-4 border-t border-slate-200 dark:border-zink-500">
        <button type="button" id="reset-layout"
                class="w-full transition-all duration-200 ease-linear text-slate-500 btn bg-slate-200 border-slate-200 hover:text-slate-600 hover:bg-slate-300 hover:border-slate-300 focus:text-slate-600 focus:bg-slate-300 focus:border-slate-300 focus:ring focus:ring-slate-100">
            Reset
        </button>
    </div>
</div>

</body>
<script src="<?= BASE_URL('public') ?>/assets/js/simplebar.min.js"></script>

<script src="<?= BASE_URL('public') ?>/assets/js/lucide.js"></script>
<script src="<?= BASE_URL('public') ?>/assets/js/popper.min.js"></script>
<script src="<?= BASE_URL('public') ?>/assets/js/tailwick.bundle.js"></script>
<script src="<?= BASE_URL('public') ?>/assets/js/sweetalert2.min.js"></script>
<script src="<?= BASE_URL('public') ?>/assets/js/app.js?ver=1.0.1"></script>
<script src="<?= BASE_URL('public') ?>/assets/js/apexcharts.min.js"></script>
<script>
    window.addEventListener('error', function (e) {
        if (e.detail) {
            Swal.fire({
                title: e.detail.title || '',
                text: e.detail.content || '',
                icon: 'error',
                confirmButtonText: 'Ok'
            })
        }
    });
    window.addEventListener('success', function (e) {
        if (e.detail) {
            Swal.fire({
                title: e.detail.title || '',
                text: e.detail.content || '',
                icon: 'success',
                confirmButtonText: 'Ok'
            })
        }
    });
    window.addEventListener('noti-right', function (e) {
        Swal.fire({
            position: "top-end",
            icon: e.detail.icon || '',
            title: e.detail.title || '',
            showConfirmButton: false,
            timer: 1500
        });
    })

    window.addEventListener('hideModal',function (e) {
        toggleElementState(e.detail.modalId, false, 100);
    })
    window.addEventListener('showModal',function (e) {
        toggleElementState(e.detail.modalId, true, 100);
    })


    function toggleElementState(elementId, show, delay) {
        const backDropOverlay = document.getElementById("backDropDiv");
        const bodyElement = document.body;
        const element = document.getElementById(elementId);
        if (element) {
            if (!show) {
                element.classList.add('show');
                backDropOverlay.classList.add('hidden');
                setTimeout(() => {
                    element.classList.add("hidden");
                }, 100);
            } else {
                element.classList.remove("hidden");
                setTimeout(() => {
                    element.classList.remove('show');
                    backDropOverlay.classList.remove('hidden');
                }, delay);
            }
            bodyElement.classList.toggle('overflow-hidden', show);

        }
        backDropOverlay?.addEventListener('click', function () {
            if (elementId) {
                toggleElementState(elementId, false, 100);
            }
        });
    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.17.5/xlsx.full.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script src="/livewire/livewire.min.js?id=38dc8241"   data-csrf="B1xDFsgUOQRtOkyLwQeTFJZY0hyjuOhS2FYHPXrZ" data-update-uri="/livewire/update" data-navigate-once="true"></script>
<script>Alpine.store("editItem",{item:{},update(t){this.item=t}});Alpine.store("reportItem",{id:{},update(t){this.id=t,document.getElementById("report_id").value=t,document.getElementById("report_id").dispatchEvent(new Event("input"))}});Alpine.bind("exportExcel",()=>({type:"button","@click"(t){const e=t.target.getAttribute("data-id");e&&a(e)}}));Alpine.bind("buyItem",()=>({type:"button","@click"(t){const e=t.target.getAttribute("data-id");document.getElementById("itemBuyId").value=e,document.getElementById("itemBuyId").dispatchEvent(new Event("input")),document.getElementById("accNumber").innerText=e;const n=new CustomEvent("showModal",{detail:{modalId:"confirmBuy"}});
window.dispatchEvent(n)}}));Alpine.bind("detailItem",()=>({type:"button","@click"(t){t.target.getAttribute("data-id")}}));Alpine.bind("preBuyItem",()=>({type:"button","@click"(t){const e=t.target.getAttribute("data-id");document.getElementById("itemBuyPreId").value=e,document.getElementById("itemBuyPreId").dispatchEvent(new Event("input")),document.getElementById("accNumberPre").innerText=e;const n=new CustomEvent("showModal",{detail:{modalId:"confirmBuyOrder"}});window.dispatchEvent(n)}}));Alpine.bind("detailItemPre",()=>({type:"button","@click"(t){const e=t.target.getAttribute("data-id");
document.getElementById("accNumberDetailPre").innerText=e,document.getElementById("roboxDetailPre").innerText=t.target.getAttribute("data-robox"),document.getElementById("rateDetailPre").innerText=t.target.getAttribute("data-rate"),
document.getElementById("priceDetailPre").innerText=t.target.getAttribute("data-price"),document.getElementById("guaranteeDetailPre").innerText=t.target.getAttribute("data-guarantee"),
document.getElementById("btnBuyModelPre").setAttribute("data-id",e)}}));
function a(t){const e=document.getElementById(t),n=XLSX.utils.book_new(),d=XLSX.utils.aoa_to_sheet([["SELLROBUX.COM SHOP MUA BÁN ACC ROBUX GIÁ RẺ"]]),i=XLSX.utils.table_to_sheet(e);XLSX.utils.sheet_add_json(d,XLSX.utils.sheet_to_json(i),{origin:-1}),XLSX.utils.book_append_sheet(n,d,"Sheet1"),XLSX.writeFile(n,"SELLROBUX.COM SHOP MUA BÁN ACC ROBUX GIÁ RẺ.xlsx")}</script>
</html>
