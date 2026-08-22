<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| theme.php — TỪ ĐIỂN CLASS CỦA THEME GỐC (Tailwick)
|--------------------------------------------------------------------------
|
| Theme Tailwick dùng chuỗi class cực dài (mỗi link sidebar ~60 class để
| hỗ trợ 4 kiểu sidebar x 3 kiểu topbar x sáng/tối). Nhúng thẳng vào view
| khiến file không đọc được và rất dễ gõ sai.
|
| Đặt ở đây (thay vì @php trong partial) vì Blade TÁCH SCOPE giữa view cha
| và view được @include: biến khai báo trong partial KHÔNG chảy ngược ra
| view gọi nó. File config thì mọi view đọc được qua config('theme.*') và
| còn được `config:cache` gộp sẵn -> nhanh hơn.
|
| Toàn bộ class GIỮ NGUYÊN như theme gốc -> giao diện không đổi.
|
| ==========================================================================
| SỬA LỖI THẬT CỦA SOURCE CŨ (bug #2)
| --------------------------------------------------------------------------
| Trong source cũ (frontend/views/client/nav.php), tiền tố
| `text-vertical-menu-item` đã bị MẤT do một lần tìm-thay-thế lỗi, để lại
| các class RỖNG không tồn tại trong CSS:
|     -font-size    hover:-hover    [&.active]:-active    -dark    -brand
| Đã kiểm chứng: grep những tên này trong tailwind2.css -> 0 kết quả.
|
| Đối chiếu assets/js/app.js (bản template gốc của chính theme, chỗ nó tự
| sinh menu "More") thì tên ĐÚNG là:
|     text-vertical-menu-item-font-size
|     text-vertical-menu-item / -hover / -active / -dark / -brand ...
|
| => File này dùng TÊN ĐÚNG, nhờ vậy chữ sidebar mới nhận đúng màu và cỡ
|    chữ của theme. Source cũ mất phần này nên phải sống nhờ màu mặc định.
|
*/


    /* --- link cấp 1: phần gốc dùng chung --- */
    $lvl1Base = 'relative flex items-center ltr:pl-3 rtl:pr-3 ltr:pr-5 rtl:pl-5 mx-3 my-1 group/menu-link'
        .' text-vertical-menu-item-font-size font-normal transition-all duration-150 ease-linear rounded-md py-2.5'
        .' text-vertical-menu-item hover:text-vertical-menu-item-hover hover:bg-vertical-menu-item-bg-hover'
        .' [&.active]:text-vertical-menu-item-active [&.active]:bg-vertical-menu-item-bg-active'
        .' group-data-[sidebar=dark]:text-vertical-menu-item-dark'
        .' group-data-[sidebar=dark]:hover:text-vertical-menu-item-hover-dark'
        .' group-data-[sidebar=dark]:dark:hover:text-custom-500'
        .' group-data-[layout=horizontal]:dark:hover:text-custom-500'
        .' group-data-[sidebar=dark]:hover:bg-vertical-menu-item-bg-hover-dark'
        .' group-data-[sidebar=dark]:dark:hover:bg-zink-600'
        .' group-data-[sidebar=dark]:[&.active]:text-vertical-menu-item-active-dark'
        .' group-data-[sidebar=dark]:[&.active]:bg-vertical-menu-item-bg-active-dark'
        .' group-data-[sidebar=brand]:text-vertical-menu-item-brand'
        .' group-data-[sidebar=brand]:hover:text-vertical-menu-item-hover-brand'
        .' group-data-[sidebar=brand]:hover:bg-vertical-menu-item-bg-hover-brand'
        .' group-data-[sidebar=brand]:[&.active]:bg-vertical-menu-item-bg-active-brand'
        .' group-data-[sidebar=brand]:[&.active]:text-vertical-menu-item-active-brand'
        .' group-data-[sidebar=modern]:text-vertical-menu-item-modern'
        .' group-data-[sidebar=modern]:hover:bg-vertical-menu-item-bg-hover-modern'
        .' group-data-[sidebar=modern]:hover:text-vertical-menu-item-hover-modern'
        .' group-data-[sidebar=modern]:[&.active]:bg-vertical-menu-item-bg-active-modern'
        .' group-data-[sidebar=modern]:[&.active]:text-vertical-menu-item-active-modern'
        .' group-data-[sidebar-size=md]:block group-data-[sidebar-size=md]:text-center'
        ." group-data-[sidebar-size=sm]:group-hover/sm:w-[calc(theme('spacing.vertical-menu-sm')_*_3.63)]"
        .' group-data-[sidebar-size=sm]:group-hover/sm:bg-vertical-menu'
        .' group-data-[sidebar-size=sm]:group-data-[sidebar=dark]:group-hover/sm:bg-vertical-menu-dark'
        .' group-data-[sidebar-size=sm]:group-data-[sidebar=modern]:group-hover/sm:bg-vertical-menu-modern'
        .' group-data-[sidebar-size=sm]:group-data-[sidebar=brand]:group-hover/sm:bg-vertical-menu-brand'
        .' group-data-[sidebar-size=sm]:my-0 group-data-[sidebar-size=sm]:rounded-b-none'
        .' group-data-[layout=horizontal]:m-0 group-data-[layout=horizontal]:ltr:pr-8'
        .' group-data-[layout=horizontal]:rtl:pl-8 group-data-[layout=horizontal]:hover:bg-transparent'
        .' group-data-[layout=horizontal]:[&.active]:bg-transparent'
        .' group-data-[sidebar=dark]:dark:text-zink-200 group-data-[layout=horizontal]:dark:text-zink-200'
        .' group-data-[sidebar=dark]:[&.active]:dark:bg-zink-600'
        .' group-data-[layout=horizontal]:dark:[&.active]:text-custom-500';

    /* Mũi tên xổ xuống của link có submenu — dùng font Remix icon */
    $ddArrow = " [&.dropdown-button]:before:absolute"
        ." [&.dropdown-button]:[&.show]:before:content-['\\ea4e']"
        ." [&.dropdown-button]:before:content-['\\ea6e']"
        .' [&.dropdown-button]:before:font-remix'
        .' ltr:[&.dropdown-button]:before:right-2 rtl:[&.dropdown-button]:before:left-2'
        .' [&.dropdown-button]:before:text-16'
        .' group-data-[sidebar-size=sm]:[&.dropdown-button]:before:hidden'
        .' group-data-[sidebar-size=md]:[&.dropdown-button]:before:hidden'
        .' rtl:[&.dropdown-button]:before:rotate-180'
        .' group-data-[layout=horizontal]:[&.dropdown-button]:before:rotate-90'
        .' group-data-[layout=horizontal]:[&.dropdown-button]:[&.show]:before:rotate-0'
        .' rtl:[&.dropdown-button]:[&.show]:before:rotate-0';

    $lvl1     = 'dropdown-button '.$lvl1Base.$ddArrow;  // link có submenu
    $lvl1Flat = $lvl1Base;                              // link không submenu

    /* --- ô bọc icon --- */
    $iconWrap = 'min-w-[1.75rem] group-data-[sidebar-size=sm]:h-[1.75rem] inline-block text-start text-[16px]'
        .' group-data-[sidebar-size=md]:block group-data-[sidebar-size=sm]:flex'
        .' group-data-[sidebar-size=sm]:items-center';

    /* --- icon bên trong (svg / lucide) --- */
    $iconCls = 'h-4 group-data-[sidebar-size=sm]:h-5 group-data-[sidebar-size=sm]:w-5 transition'
        .' group-hover/menu-link:animate-icons'
        .' group-data-[sidebar-size=md]:block group-data-[sidebar-size=md]:mx-auto'
        .' group-data-[sidebar-size=md]:mb-2';

    /* --- nhãn chữ (ẩn khi sidebar thu nhỏ) --- */
    $labelCls = 'group-data-[sidebar-size=sm]:ltr:pl-10 group-data-[sidebar-size=sm]:rtl:pr-10 align-middle'
        .' group-data-[sidebar-size=sm]:group-hover/sm:block group-data-[sidebar-size=sm]:hidden';

    /* --- hộp chứa submenu --- */
    $ddWrap = 'dropdown-content group-data-[sidebar-size=sm]:ltr:left-vertical-menu-sm'
        .' group-data-[sidebar-size=sm]:rtl:right-vertical-menu-sm'
        ." group-data-[sidebar-size=sm]:w-[calc(theme('spacing.vertical-menu-sm')_*_2.8)]"
        .' group-data-[sidebar-size=sm]:absolute group-data-[sidebar-size=sm]:rounded-b-sm'
        .' bg-vertical-menu group-data-[sidebar=dark]:bg-vertical-menu-dark'
        .' group-data-[sidebar=dark]:dark:bg-zink-700 group-data-[sidebar=brand]:bg-vertical-menu-brand'
        .' group-data-[sidebar=modern]:bg-transparent group-data-[layout=horizontal]:md:absolute'
        .' group-data-[layout=horizontal]:top-full group-data-[layout=horizontal]:md:w-44'
        .' group-data-[layout=horizontal]:py-2 group-data-[layout=horizontal]:rounded-b-md'
        .' group-data-[layout=horizontal]:md:shadow-lg'
        .' group-data-[layout=horizontal]:md:shadow-slate-500/10'
        .' group-data-[layout=horizontal]:dark:bg-zink-700'
        .' group-data-[layout=horizontal]:dark:md:shadow-zink-600/20 hidden'
        .' group-data-[sidebar-size=sm]:group-hover/sm:block'
        .' group-data-[sidebar-size=sm]:rounded-br-md group-data-[sidebar-size=sm]:shadow-lg'
        .' group-data-[sidebar-size=sm]:shadow-slate-700/10';

    $ddList = 'ltr:pl-[1.75rem] rtl:pr-[1.75rem] group-data-[sidebar-size=md]:ltr:pl-0'
        .' group-data-[sidebar-size=md]:rtl:pr-0 group-data-[sidebar-size=sm]:ltr:pl-0'
        .' group-data-[sidebar-size=sm]:rtl:pr-0 group-data-[sidebar-size=sm]:py-2'
        .' group-data-[layout=horizontal]:ltr:pl-0 group-data-[layout=horizontal]:rtl:pr-0';

    /* --- link cấp 2 (trong submenu) --- */
    $lvl2 = 'relative flex items-center px-6 py-2 text-vertical-menu-item-font-size transition-all'
        .' duration-150 ease-linear text-vertical-menu-item hover:text-vertical-menu-item-hover'
        ." [&.active]:text-vertical-menu-item-active before:absolute ltr:before:left-1.5"
        ." rtl:before:right-1.5 before:content-['*']"
        .' group-data-[sidebar=dark]:text-vertical-menu-item-dark'
        .' group-data-[sidebar=dark]:hover:text-vertical-menu-item-hover-dark'
        .' group-data-[sidebar=dark]:[&.active]:text-vertical-menu-item-active-dark'
        .' group-data-[sidebar=brand]:text-vertical-menu-item-brand'
        .' group-data-[sidebar=brand]:hover:text-vertical-menu-item-hover-brand'
        .' group-data-[sidebar=brand]:[&.active]:text-vertical-menu-item-active-brand'
        .' group-data-[sidebar=modern]:text-vertical-menu-item-modern'
        .' group-data-[sidebar=modern]:hover:text-vertical-menu-item-hover-modern'
        .' group-data-[sidebar=modern]:[&.active]:text-vertical-menu-item-active-modern'
        .' group-data-[sidebar=dark]:dark:text-zink-200'
        .' group-data-[sidebar=dark]:dark:hover:text-custom-500'
        .' group-data-[sidebar=dark]:dark:[&.active]:text-custom-500'
        .' group-data-[layout=horizontal]:dark:text-zink-200'
        .' group-data-[layout=horizontal]:dark:hover:text-custom-500';

    /* --- nút trên topbar (hamburger, sáng/tối, ...) --- */
    $topBtn = 'inline-flex relative justify-center items-center p-0 text-topbar-item transition-all'
        .' w-[37.5px] h-[37.5px] duration-75 ease-linear bg-topbar rounded-md btn hover:bg-slate-100'
        .' group-data-[topbar=dark]:bg-topbar-dark group-data-[topbar=dark]:border-topbar-dark'
        .' group-data-[topbar=dark]:text-topbar-item-dark'
        .' group-data-[topbar=dark]:hover:bg-topbar-item-bg-hover-dark'
        .' group-data-[topbar=dark]:hover:text-topbar-item-hover-dark'
        .' group-data-[topbar=brand]:bg-topbar-brand group-data-[topbar=brand]:border-topbar-brand'
        .' group-data-[topbar=brand]:text-topbar-item-brand'
        .' group-data-[topbar=brand]:hover:bg-topbar-item-bg-hover-brand'
        .' group-data-[topbar=brand]:hover:text-topbar-item-hover-brand'
        .' group-data-[topbar=dark]:dark:bg-zink-700 group-data-[topbar=dark]:dark:text-zink-200'
        .' group-data-[topbar=dark]:dark:border-zink-700'
        .' group-data-[topbar=dark]:dark:hover:bg-zink-600'
        .' group-data-[topbar=dark]:dark:hover:text-zink-50';

    /* --- một dòng trong dropdown người dùng --- */
    $ddItem = 'block px-4 py-1.5 text-base font-medium transition-all duration-200 ease-linear'
        .' text-slate-600 hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100'
        .' focus:text-slate-500 dark:text-zink-100 dark:hover:bg-zink-500 dark:hover:text-zink-200'
        .' dark:focus:bg-zink-500 dark:focus:text-zink-200';

return [
    'lvl1' => $lvl1,
    'lvl1Flat' => $lvl1Flat,
    'iconWrap' => $iconWrap,
    'iconCls' => $iconCls,
    'labelCls' => $labelCls,
    'ddWrap' => $ddWrap,
    'ddList' => $ddList,
    'lvl2' => $lvl2,
    'topBtn' => $topBtn,
    'ddItem' => $ddItem,
];
