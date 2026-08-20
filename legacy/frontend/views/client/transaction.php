<?php
$title = 'TRANG CHỦ | ' . $VCD->site('title');
$body['header'] = '
';
$body['footer'] = '

';
require_once __DIR__ . '/../../../core/is_user.php';
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/nav.php';
//CheckLogin();
// mã nguồn được phát triển bởi Văn Công Đức ✓
?>
<div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-2 px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
            <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">

                                <div style="min-height: calc(100vh - 350px)">
                    <div wire:snapshot="{&quot;data&quot;:{&quot;sortDirection&quot;:&quot;desc&quot;,&quot;sortColumn&quot;:&quot;created_at&quot;,&quot;paginators&quot;:[{&quot;page&quot;:1},{&quot;s&quot;:&quot;arr&quot;}]},&quot;memo&quot;:{&quot;id&quot;:&quot;GXBJTURXXNEHfohlPORD&quot;,&quot;name&quot;:&quot;transaction.transaction-index&quot;,&quot;path&quot;:&quot;auth\/transaction&quot;,&quot;method&quot;:&quot;GET&quot;,&quot;children&quot;:[],&quot;scripts&quot;:[],&quot;assets&quot;:[],&quot;errors&quot;:[],&quot;locale&quot;:&quot;vi&quot;},&quot;checksum&quot;:&quot;903a4bf72136d3a6e92ed70e37b1db8bb16a34ce6a97e997dfadf1fab102cf3f&quot;}" wire:effects="{&quot;url&quot;:{&quot;paginators.page&quot;:{&quot;as&quot;:&quot;page&quot;,&quot;use&quot;:&quot;push&quot;,&quot;alwaysShow&quot;:false,&quot;except&quot;:null}}}" wire:id="GXBJTURXXNEHfohlPORD" class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
    <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
        <div class="grow">
            <h5 class="text-16">Biến động số dư</h5>
        </div>
    </div>
    <div class="grid grid-cols-12 gap-x-4">
        <div class="col-span-12 card 2xl:col-span-12">
            <div class="card-body">
                <div class="grid items-center grid-cols-1 gap-3 mb-5 2xl:grid-cols-12">
                    <div class="2xl:col-span-3">
                        <h6 class="text-15">Danh sách</h6>
                    </div><!--end col-->
                </div><!--end grid-->
                <div class="overflow-x-auto">
                    <table class="display stripe group dataTable w-full text-sm align-middle whitespace-nowrap">
                        <thead class="ltr:text-left rtl:text-right bg-slate-100 text-slate-500 dark:text-zink-200 dark:bg-zink-600">
                        <tr>
                            <th wire:click="doSort('id')" class="p-3 group-[.bordered]:border group-[.bordered]:border-slate-200 group-[.bordered]:dark:border-zink-500 sorting px-3 py-4
    text-slate-900 text-15  bg-slate-200/50 font-semibold text-left dark:color-yellow-2x dark:bg-zink-600 dark:group-[.bordered]:border-zink-500">
        #
    </th>

                            <th wire:click="doSort('amount')" class="p-3 group-[.bordered]:border group-[.bordered]:border-slate-200 group-[.bordered]:dark:border-zink-500 sorting px-3 py-4
    text-slate-900 text-15  bg-slate-200/50 font-semibold text-left dark:color-yellow-2x dark:bg-zink-600 dark:group-[.bordered]:border-zink-500">
        Số tiền
    </th>
                            <th wire:click="doSort('amount')" class="p-3 group-[.bordered]:border group-[.bordered]:border-slate-200 group-[.bordered]:dark:border-zink-500 sorting px-3 py-4
    text-slate-900 text-15  bg-slate-200/50 font-semibold text-left dark:color-yellow-2x dark:bg-zink-600 dark:group-[.bordered]:border-zink-500">
        Số dư trước
    </th>
                            <th wire:click="doSort('amount')" class="p-3 group-[.bordered]:border group-[.bordered]:border-slate-200 group-[.bordered]:dark:border-zink-500 sorting px-3 py-4
    text-slate-900 text-15  bg-slate-200/50 font-semibold text-left dark:color-yellow-2x dark:bg-zink-600 dark:group-[.bordered]:border-zink-500">
        Số dư sau
    </th>

                            <th wire:click="doSort('description')" class="p-3 group-[.bordered]:border group-[.bordered]:border-slate-200 group-[.bordered]:dark:border-zink-500 sorting px-3 py-4
    text-slate-900 text-15  bg-slate-200/50 font-semibold text-left dark:color-yellow-2x dark:bg-zink-600 dark:group-[.bordered]:border-zink-500">
        Nội dung
    </th>
                            <th wire:click="doSort('created_at')" class="text-15 ltr:!text-left rtl:!text-right p-3 group-[.bordered]:border group-[.bordered]:border-slate-200
        group-[.bordered]:dark:border-zink-500 sorting px-3 py-4 text-slate-900 bg-slate-200/50
        font-semibold text-left dark:color-yellow-2x dark:bg-zink-600 dark:group-[.bordered]:border-zink-500 sorting_desc" aria-sort="descending">
        Thời gian
    </th>


                        </tr>
                        </thead>
                        <tbody>
                               <?php $i=0;
                    /* SỬA LỖI: $getUser là NULL khi khách chưa đăng nhập -> PHP Warning
                       "Trying to access array offset on null". Nay kiểm tra an toàn. */
                    $__email = (isset($getUser) && is_array($getUser) && isset($getUser['email'])) ? $getUser['email'] : '';
                    $checkdongtien = $__email === '' ? array() : $VCD->get_list("SELECT * FROM `dongtien` WHERE `username` = '".check_string($__email)."'");

                 if (!empty($checkdongtien)) { 
                       foreach ($checkdongtien as $dongtien) { ?>
                     <tr>
                           <td class="px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500">
                <?=$i++?>
            </td>
            <td class="px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500">
                <?=format_cash($dongtien['sotienthaydoi']);?> đ
            </td>
                <td class="px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500">
                <?=format_cash($dongtien['sotientruoc']);?> đ
            </td>
              <td class="px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500">
                  <?=format_cash($dongtien['sotiensau']);?> đ
            </td>
            <td class="px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500">
                <?=$dongtien['noidung'];?> 
            </td>
             <td class="px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500">
                <?=$dongtien['thoigian'];?> 
            </td>
        </tr>   
    <?php } 
} else { ?>
    <tr>
        <td colspan="7" class="px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500 text-center">
            Không có dữ liệu
        </td>
    </tr>
<?php } ?>

                                                </tbody>
                    </table>
                </div>
                <div class="flex flex-col items-center mt-5 md:flex-row">
                    <div class="flex justify-end">
    </div>

                </div>
            </div>
        </div>
    </div>
</div>
     </div>
                    
  <?php require_once __DIR__ . '/footer.php'; ?>
<!-- Modal for confirmation -->

   