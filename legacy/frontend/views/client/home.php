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
 
    <div class="relative min-h-screen group-data-[sidebar-size=sm]:min-h-sm">
<!--mã nguồn được phát triển bởi Văn Công Đức ✓-->
        <div
            class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-2 px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
            <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">

                                <div style="min-height: calc(100vh - 350px)">
                    <div wire:snapshot="{&quot;data&quot;:[],&quot;memo&quot;:{&quot;id&quot;:&quot;83EcNd29uUl8GhTDlSwL&quot;,&quot;name&quot;:&quot;index-page&quot;,&quot;path&quot;:&quot;\/&quot;,&quot;method&quot;:&quot;GET&quot;,&quot;children&quot;:{&quot;lw-3691177091-0&quot;:[&quot;div&quot;,&quot;iznBS95BvTbeVWpOQLUO&quot;],&quot;lw-3691177091-2&quot;:[&quot;div&quot;,&quot;FxhtEnDFmTUrPC8OtHyr&quot;],&quot;lw-3691177091-3&quot;:[&quot;div&quot;,&quot;lv057gBOm5QonCHqtV8l&quot;]},&quot;scripts&quot;:[],&quot;assets&quot;:[],&quot;errors&quot;:[],&quot;locale&quot;:&quot;vi&quot;},&quot;checksum&quot;:&quot;115eea5e2900fc8a45dcba38d802a381a6edbdcf803d99989f1a057d9f2b43da&quot;}" wire:effects="{&quot;listeners&quot;:[&quot;switchStyle&quot;]}" wire:id="83EcNd29uUl8GhTDlSwL" class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
    <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
        <div class="grow flex">
            <h5 class="text-16 mr-2">Trang chủ</h5>
            <div wire:snapshot="{&quot;data&quot;:[],&quot;memo&quot;:{&quot;id&quot;:&quot;iznBS95BvTbeVWpOQLUO&quot;,&quot;name&quot;:&quot;switch-style&quot;,&quot;path&quot;:&quot;\/&quot;,&quot;method&quot;:&quot;GET&quot;,&quot;children&quot;:[],&quot;scripts&quot;:[],&quot;assets&quot;:[],&quot;errors&quot;:[],&quot;locale&quot;:&quot;vi&quot;},&quot;checksum&quot;:&quot;9baa902e5d3bb624d51960055a0bdfc7eccee6f64af9d61baa4c5c26403c2fb4&quot;}" wire:effects="[]" wire:id="iznBS95BvTbeVWpOQLUO" class="flex items-center">
    <div class="relative inline-block w-10 align-middle transition duration-200 ease-in ltr:mr-2 rtl:ml-2">
        <input type="checkbox" wire:change="switchStyle($event.target.checked)" name="switchStyle"
               id="switchStyle"
               class="absolute block transition duration-300 ease-linear border-2 rounded-full appearance-none cursor-pointer size-5 border-slate-200 dark:border-zink-500 bg-white/80 dark:bg-zink-400 peer/published checked:bg-white dark:checked:bg-white ltr:checked:right-0 rtl:checked:left-0 checked:bg-none checked:border-custom-500 dark:checked:border-custom-500 arrow-none"
               
        >
        <label for="switchStyle"
               class="block h-5 overflow-hidden duration-300 ease-linear border rounded-full cursor-pointer cursor-pointertransition border-slate-200 dark:border-zink-500 bg-slate-200 dark:bg-zink-600 peer-checked/published:bg-custom-500 peer-checked/published:border-custom-500"></label>
    </div>
    <label for="switchStyle" class="inline-block text-base font-medium cursor-pointer">Giao diện mới</label>
</div>
        </div>
    </div>
    <div class="grid grid-cols-12 gap-x-4">
                    <div class="col-span-12 card 2xl:col-span-12">
                <div class="card-body">
                    <marquee class="tw-w-full" scrollamount="2">
                     <?=base64_decode($VCD->site('notification'));?>
                    </marquee>
                </div>
            </div>
            </div>
            <div id="form1" style="display: none;" wire:snapshot="{&quot;data&quot;:{&quot;idItem&quot;:null,&quot;account&quot;:null,&quot;rate&quot;:null,&quot;myAccount&quot;:false,&quot;rates&quot;:[[[{&quot;rate&quot;:99,&quot;count_rate&quot;:4,&quot;color&quot;:&quot;purple&quot;},{&quot;s&quot;:&quot;arr&quot;}],[{&quot;rate&quot;:100,&quot;count_rate&quot;:23,&quot;color&quot;:&quot;sky&quot;},{&quot;s&quot;:&quot;arr&quot;}],[{&quot;rate&quot;:101,&quot;count_rate&quot;:2,&quot;color&quot;:&quot;red&quot;},{&quot;s&quot;:&quot;arr&quot;}],[{&quot;rate&quot;:103,&quot;count_rate&quot;:141,&quot;color&quot;:&quot;red&quot;},{&quot;s&quot;:&quot;arr&quot;}],[{&quot;rate&quot;:104,&quot;count_rate&quot;:11,&quot;color&quot;:&quot;yellow&quot;},{&quot;s&quot;:&quot;arr&quot;}],[{&quot;rate&quot;:105,&quot;count_rate&quot;:63,&quot;color&quot;:&quot;purple&quot;},{&quot;s&quot;:&quot;arr&quot;}],[{&quot;rate&quot;:107,&quot;count_rate&quot;:1,&quot;color&quot;:&quot;red&quot;},{&quot;s&quot;:&quot;arr&quot;}],[{&quot;rate&quot;:108,&quot;count_rate&quot;:11,&quot;color&quot;:&quot;yellow&quot;},{&quot;s&quot;:&quot;arr&quot;}],[{&quot;rate&quot;:109,&quot;count_rate&quot;:39,&quot;color&quot;:&quot;red&quot;},{&quot;s&quot;:&quot;arr&quot;}],[{&quot;rate&quot;:110,&quot;count_rate&quot;:31,&quot;color&quot;:&quot;orange&quot;},{&quot;s&quot;:&quot;arr&quot;}],[{&quot;rate&quot;:113,&quot;count_rate&quot;:21,&quot;color&quot;:&quot;yellow&quot;},{&quot;s&quot;:&quot;arr&quot;}],[{&quot;rate&quot;:114,&quot;count_rate&quot;:4,&quot;color&quot;:&quot;yellow&quot;},{&quot;s&quot;:&quot;arr&quot;}],[{&quot;rate&quot;:115,&quot;count_rate&quot;:29,&quot;color&quot;:&quot;orange&quot;},{&quot;s&quot;:&quot;arr&quot;}],[{&quot;rate&quot;:117,&quot;count_rate&quot;:1,&quot;color&quot;:&quot;sky&quot;},{&quot;s&quot;:&quot;arr&quot;}],[{&quot;rate&quot;:118,&quot;count_rate&quot;:4,&quot;color&quot;:&quot;orange&quot;},{&quot;s&quot;:&quot;arr&quot;}],[{&quot;rate&quot;:120,&quot;count_rate&quot;:39,&quot;color&quot;:&quot;green&quot;},{&quot;s&quot;:&quot;arr&quot;}],[{&quot;rate&quot;:125,&quot;count_rate&quot;:1,&quot;color&quot;:&quot;purple&quot;},{&quot;s&quot;:&quot;arr&quot;}],[{&quot;rate&quot;:127,&quot;count_rate&quot;:1,&quot;color&quot;:&quot;sky&quot;},{&quot;s&quot;:&quot;arr&quot;}]],{&quot;class&quot;:&quot;Illuminate\\Support\\Collection&quot;,&quot;s&quot;:&quot;clctn&quot;}],&quot;sortDirection&quot;:&quot;desc&quot;,&quot;sortColumn&quot;:&quot;price&quot;,&quot;paginators&quot;:[{&quot;page&quot;:1},{&quot;s&quot;:&quot;arr&quot;}]},&quot;memo&quot;:{&quot;id&quot;:&quot;FxhtEnDFmTUrPC8OtHyr&quot;,&quot;name&quot;:&quot;index-home&quot;,&quot;path&quot;:&quot;\/&quot;,&quot;method&quot;:&quot;GET&quot;,&quot;children&quot;:{&quot;lw-2880588806-0&quot;:[&quot;div&quot;,&quot;90nLSHMijByFXXlzXjqE&quot;]},&quot;scripts&quot;:[],&quot;assets&quot;:[],&quot;errors&quot;:[],&quot;locale&quot;:&quot;vi&quot;},&quot;checksum&quot;:&quot;80294ce386d48850cc8c845a09cf8457d756d1c1cfe2f4bd037e2929a76968d9&quot;}" wire:effects="{&quot;listeners&quot;:[&quot;updateListAccInstant&quot;,&quot;switchAccount&quot;]}" wire:id="FxhtEnDFmTUrPC8OtHyr">
    <div class="grid grid-cols-12 gap-x-4" >
        <div class="col-span-12 card 2xl:col-span-12">
            <div class="card-body">
                <div class="grid items-center grid-cols-1 gap-3 mb-5 2xl:grid-cols-12">
                    <div class="2xl:col-span-3 ">
                        <h6 class="text-15">Tài khoản đã nạp Robux</h6>

                    </div><!--end col-->

                </div><!--end grid-->
       <?php
$rate = $VCD->get_list("SELECT * FROM `mucrate` WHERE `status` = '1'");
$RateId = $_POST['rate_id'] ?? null;
$RateCode = $_POST['rate_code'] ?? null;

?>
<!--mã nguồn được phát triển bởi Văn Công Đức ✓-->
<div class="overflow-x-auto" wire:ignore.self>
    <?php foreach ($rate as $setRate): ?>
        <form method="POST" style="display: inline;" onsubmit="handleFormSubmission(event, this);">
            <input type="hidden" name="rate_id" value="<?= $setRate['id']; ?>">
            <input type="hidden" name="rate_code" value="<?= $setRate['code']; ?>">
            <button type="submit"
                class="btn-rate py-1 px-0 font-bold mt-1 bg-white relative btn border-custom-500 hover:text-white hover:bg-custom-600">
                <svg class="spinner hidden opacity-50 w-4 h-4 ltr:mr-2 rtl:ml-2 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <?= $setRate['code']; ?>
                <span class="absolute flex items-center justify-center w-[16px] h-[16px] text-xs text-white bg-red-400 rounded-full -top-1 -right-1">
                    <?= $setRate['id']; ?>
                </span>
            </button>
        </form>
    <?php endforeach; ?>
</div>

    <div class="overflow-x-auto" wire:poll.30s>

                    <div class="my-2 col-span-12 overflow-x-auto lg:col-span-12">

                        <table class="display stripe group dataTable w-full text-sm align-middle ">
                            <thead
                                class="ltr:text-left rtl:text-right bg-slate-100 text-slate-500 dark:text-zink-200 dark:bg-zink-600">
                            <tr>


                                <th wire:click="doSort('robux')" class="p-3 group-[.bordered]:border group-[.bordered]:border-slate-200 group-[.bordered]:dark:border-zink-500 sorting px-3 py-4
    text-slate-900 text-15  bg-slate-200/50 font-semibold text-left dark:color-yellow-2x dark:bg-zink-600 dark:group-[.bordered]:border-zink-500"
    >
        Robux
    </th>
                                <th wire:click="doSort('rate')" class="p-3 group-[.bordered]:border group-[.bordered]:border-slate-200 group-[.bordered]:dark:border-zink-500 sorting px-3 py-4
    text-slate-900 text-15  bg-slate-200/50 font-semibold text-left dark:color-yellow-2x dark:bg-zink-600 dark:group-[.bordered]:border-zink-500"
    >
        Rate
    </th>
                                <th wire:click="doSort('price')" class="text-15 ltr:!text-left rtl:!text-right p-3 group-[.bordered]:border group-[.bordered]:border-slate-200
        group-[.bordered]:dark:border-zink-500 sorting px-3 py-4 text-slate-900 bg-slate-200/50
        font-semibold text-left dark:color-yellow-2x dark:bg-zink-600 dark:group-[.bordered]:border-zink-500 sorting_desc"
        aria-sort="descending"
    >
        Giá
    </th>
                                <th wire:click="doSort('warranty_period')" class="p-3 group-[.bordered]:border group-[.bordered]:border-slate-200 group-[.bordered]:dark:border-zink-500 sorting px-3 py-4
    text-slate-900 text-15  bg-slate-200/50 font-semibold text-left dark:color-yellow-2x dark:bg-zink-600 dark:group-[.bordered]:border-zink-500"
    >
        Bảo hành
    </th>
                                <th wire:click="doSort('is_premium')" class="p-3 group-[.bordered]:border group-[.bordered]:border-slate-200 group-[.bordered]:dark:border-zink-500 sorting px-3 py-4
    text-slate-900 text-15  bg-slate-200/50 font-semibold text-left dark:color-yellow-2x dark:bg-zink-600 dark:group-[.bordered]:border-zink-500"
    >
        Premium
    </th>
                                <th wire:click="doSort('acc_time')" class="p-3 group-[.bordered]:border group-[.bordered]:border-slate-200 group-[.bordered]:dark:border-zink-500 sorting px-3 py-4
    text-slate-900 text-15  bg-slate-200/50 font-semibold text-left dark:color-yellow-2x dark:bg-zink-600 dark:group-[.bordered]:border-zink-500"
    >
        Ngày tham gia
    </th>
                                <th class="text-15 p-3 group-[.bordered]:border group-[.bordered]:border-slate-200 group-[.bordered]:dark:border-zink-500  px-3 py-4
                                            text-slate-900 bg-slate-200/50 font-semibold text-left dark:color-yellow-2x dark:bg-zink-600 dark:group-[.bordered]:border-zink-500">Hành động</th>
                            </tr>
                            </thead>
                            <tbody>
                           <?php if (empty($RateId) && empty($RateCode)) { ?>
<?php 
$items_per_page = 10;  
$current_page = isset($_POST['page']) ? max(1, (int)$_POST['page']) : 1; 
$offset = ($current_page - 1) * $items_per_page;  

// Đếm tổng số bản ghi 
$total_items = $VCD->get_row("SELECT COUNT(*) as total FROM `accountrb` WHERE `status` = '1' ")['total']; 
$total_pages = ceil($total_items / $items_per_page);  

// Lấy danh sách tài khoản 
$accounts1 = $VCD->get_list("SELECT * FROM `accountrb` WHERE  `status` = '1' LIMIT $items_per_page OFFSET $offset"); 
?>

 <?php foreach ($accounts1 as $accountrb1): ?>
                                    <tr>
    <td class="px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500">
                                       <?=format_cash($accountrb1['robux']);?> 
                                    </td>
                                    <td class="px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500">
                                                                      <?=$accountrb1['rate'];?> 

                                                                            </td>
                                    <td class="px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500">
                                         <?=format_cash($accountrb1['price']);?> đ

                                    </td>
                                    <td class="px-3.5 py-2.5 first:pl-5  last:pr-5 border-y border-slate-200 dark:border-zink-500">

                                     <?=$accountrb1['guarantee'];?>
                                    </td>
                                    <td class="px-3.5 py-2.5 first:pl-5 font-bold last:pr-5 border-y border-slate-200 dark:border-zink-500">
                                                                       <?=premium1($accountrb1['premium']);?>     </td>
                                    <td class="px-3.5 py-2.5 first:pl-5 font-bold last:pr-5 border-y border-slate-200 dark:border-zink-500">
                                                                           <?=$accountrb1['datejoin'];?>  </td>
                                    <td class="px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500">
                                    <button type="button" 
        x-bind="buyItem" 
        data-id="<?=$accountrb1['id'];?>" 
        onclick="muanick(<?= $accountrb1['id']; ?>)"
        data-type="instant"
        class="text-white py-1 px-0 bg-red-500 border-red-500 btn hover:text-white hover:bg-red-600 hover:border-red-600 focus:text-white focus:bg-red-600 focus:border-red-600 focus:ring focus:ring-red-100 active:text-white active:bg-red-600 active:border-red-600 active:ring active:ring-green-100 dark:ring-red-400/10">
    Mua
</button>
                                        <button type="button"
                                            data-modal-target="detailItemModal<?= $accountrb1['id']; ?>" 
                                                wire:loading.attr="disabled"
                                                class="text-white py-1 px-0 bg-green-500 border-green-500 btn hover:text-white hover:bg-green-600 hover:border-green-600 focus:text-white focus:bg-green-600 focus:border-green-600 focus:ring focus:ring-green-100 active:text-white active:bg-green-600 active:border-green-600 active:ring active:ring-custom-100 dark:ring-green-400/10">
                                            <svg wire:loading wire:target="detail(152323)"
                                                 class="w-4 h-4 ltr:mr-2 rtl:ml-2 animate-spin"
                                                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                        stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                      d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            <span wire:loading.remove
                                                  wire:target="detail(152323)">Chi tiết</span>
                                        </button>
 
 <div id="detailItemModal<?= $accountrb1['id']; ?>" wire:ignore.self modal-center=""
         class="fixed flex flex-col transition-all duration-300 ease-in-out left-2/4 z-drawer -translate-x-2/4 -translate-y-2/4 show hidden">
        <div class="w-screen lg:w-[55rem] bg-white shadow rounded-md dark:bg-zink-600 flex flex-col h-full">
        <div class="max-h-[calc(theme('height.screen')_-_180px)] p-4 overflow-y-auto">
                                    <div wire:loading="" wire:target="account" class="text-center py-4">
                        <span>Loading...</span>
                    </div>
                    <div wire:snapshot="{&quot;data&quot;:{&quot;account&quot;:[null,{&quot;class&quot;:&quot;App\\Models\\AccountItem&quot;,&quot;key&quot;:190415,&quot;s&quot;:&quot;mdl&quot;}],&quot;accSuggest&quot;:[null,{&quot;keys&quot;:[190416,190442,190446,190414,190440],&quot;class&quot;:&quot;Illuminate\\Database\\Eloquent\\Collection&quot;,&quot;modelClass&quot;:&quot;App\\Models\\AccountItem&quot;,&quot;s&quot;:&quot;elcln&quot;}],&quot;idItem&quot;:190415},&quot;memo&quot;:{&quot;id&quot;:&quot;opP8fesAOGnorhgrgSot&quot;,&quot;name&quot;:&quot;detail.detail-roblox-instant&quot;,&quot;path&quot;:&quot;\/&quot;,&quot;method&quot;:&quot;GET&quot;,&quot;children&quot;:[],&quot;scripts&quot;:[],&quot;assets&quot;:[],&quot;errors&quot;:[],&quot;locale&quot;:&quot;vi&quot;},&quot;checksum&quot;:&quot;621fe16a4a15e8298f80478a7a965e1a2db5ab0124c65d21bbf9e8b33425ca48&quot;}" wire:effects="{&quot;dispatches&quot;:[{&quot;name&quot;:&quot;refresh&quot;,&quot;params&quot;:[]}]}" wire:id="opP8fesAOGnorhgrgSot" class="grid grid-cols-12 2xl:grid-cols-12 gap-x-5">
    <div class="col-span-12  2xl:col-span-8 flex justify-between" style="flex-direction: column">
        <div>
            <div class="flex border-b-2">
                <img width="100" src="<?= BASE_URL('public') ?>/assets/img/roblox-logo.png">
                <div class="my-auto">
                    <h4>Roblox</h4>
                    <h6 class="text-green-500">Giao ngay</h6>
                </div>
            </div>
            <div class="mt-1">
                <p><strong>Lưu ý:</strong>&nbsp;<br>Gặp lỗi trong quá trình mua bán acc vui lòng sử dụng nút khiếu nại<br>Nút khiếu nại lằm trong lịch sử mua hàng khi bạn mua sẽ xuất hiện trong 10p&nbsp;<br>Không sử dụng nút này đồng nghĩa với việc bạn tự đánh mất quyền được bảo hành<br>Chúng tôi không chấp nhận bất kỳ lý do vớ vẩn khi không chủ động kiểm tra tài khoản không báo lỗi</p>
            </div>
        </div>
        <div class="mt-2">


            <div class="mt-3 mb-2" x-data="{swiper: null}" x-init="
                 swiper = new Swiper($refs.accountSlide, {
                                             slidesPerView: 'auto',
                                             spaceBetween: 30
                                     });
                 ">
               
            </div>
        </div>
    </div>
    <div class="col-span-12  2xl:col-span-4 modal-detail-right p-2 flex justify-between" style="flex-direction: column">
        <div class="flex justify-center">
            <img width="250" src="<?= BASE_URL('public') ?>/assets/img/roblox-logo.png">
        </div>
        <div class="text-center">
            <p><span class="font-bold" id="accNumber">#ID:</span> <?=$accountrb1['id'];?> </p>
            <p><span class="font-bold">Rate:</span> <?=$accountrb1['rate'];?></p>
            <p><span class="font-bold">Roblox:</span>  <?=format_cash($accountrb1['robux']);?></p>
            <p><span class="font-bold">Price:</span>
                                     <?=format_cash($accountrb1['price']);?>đ
                            </p>
            <button type="button"        data-id="<?=$accountrb1['id'];?>" 
        onclick="muanick(<?= $accountrb1['id']; ?>)" wire:click="buyItemDetail" wire:loading.attr="disabled" class="relative font-medium px-8 btn-main py-2.5  text-15 text-white btn bg-custom-500 border-custom-500
                    hover:text-white focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100
                    active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">
                <svg wire:loading="" wire:target="buyItemDetail" class="w-4 h-4 ltr:mr-2 rtl:ml-2 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Mua
            </button>
        </div>
    </div>
</div>
                            </div>
        </div>
    </div>
                                    </td> </tr>
                                    <?php endforeach; ?>
                         
        </tbody>
    </table>     
    </div></div>
<div class="mt-2 flex justify-end">     
    <nav role="navigation" aria-label="Pagination Navigation">         
        <div class="dataTables_paginate paging_simple_numbers">             
            <span class="relative z-0 inline-flex flex-wrap rtl:flex-row-reverse rounded-md shadow-sm">                 
                <!-- Nút "Trước" -->
                <form method="POST" action="" style="display:inline;">
                    <input type="hidden" name="page" value="<?= max(1, $current_page - 1) ?>" />
                    <?php if ($current_page > 1): ?>                     
                        <button type="submit">  
                             <span aria-disabled="true" aria-label="Trước">
                                 <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-l-md leading-5 dark:border-zink-500 dark:active:border-zink-400 bg-white dark:bg-zink-700 text-slate-300 dark:text-slate-300" aria-hidden="true">
                                     <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                         <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                     </svg>
                                 </span>
                             </span>
                        </button>                 
                    <?php else: ?>                     
                        <span>
                            <span aria-disabled="true" aria-label="Trước">
                                <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-l-md leading-5 dark:border-zink-500 dark:active:border-zink-400 bg-white dark:bg-zink-700 text-slate-300 dark:text-slate-300" aria-hidden="true">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </span>
                            </span>
                        </span>                 
                    <?php endif; ?>  
                </form>  
<!--mã nguồn được phát triển bởi Văn Công Đức ✓-->
                <?php
                // mã nguồn được phát triển bởi Văn Công Đức ✓
                $range = 4; // Số trang hiển thị giữa
                $start = max(1, $current_page - $range);
                $end = min($total_pages, $current_page + $range);

                // mã nguồn được phát triển bởi Văn Công Đức ✓
                if ($current_page > $range + 2) {
                    echo '<span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 dark:border-zink-500 dark:active:border-zink-400 bg-white dark:bg-zink-700 text-slate-300 dark:text-slate-3000">...</span>';
                }

                for ($i = $start; $i <= $end; $i++): 
                    ?>
                    <form method="POST" action="" style="display:inline;">
                        <input type="hidden" name="page" value="<?= $i ?>" />
                        <button type="submit">      
                            <span class="<?= $i === $current_page ? 'relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 dark:border-zink-500 dark:active:border-zink-400 font-semibold bg-slate-100 dark:bg-zink-600 text-slate-800 hover:text-slate-900 hover:border-slate-200 hover:shadow-sm focus:ring focus:ring-slate-300 focus:ring-opacity-25 dark:text-slate-100 dark:hover:border-zink-500 dark:hover:text-zink-50 dark:focus:ring-zink-500 dark:focus:ring-opacity-40' : 'relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 dark:border-zink-500 dark:active:border-zink-400' ?>">
                                <?= $i ?>
                            </span>
                        </button>                     
                    </form>                 
                <?php endfor; ?>  

                <!--mã nguồn được phát triển bởi Văn Công Đức ✓ -->
                <?php if ($current_page + $range < $total_pages - 1) {
                    echo '<span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 dark:border-zink-500 dark:active:border-zink-400 bg-white dark:bg-zink-700 text-slate-300 dark:text-slate-3000">...</span>';
                }
                ?>

                <!-- Nút "Tiếp" -->
                <form method="POST" action="" style="display:inline;">
                    <input type="hidden" name="page" value="<?= min($total_pages, $current_page + 1) ?>" />
                    <?php if ($current_page < $total_pages): ?>                     
                         <button type="submit" class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:border-blue-300 focus:ring ring-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150 dark:border-zink-500 dark:active:border-zink-400 bg-white dark:bg-zink-700 text-slate-300 dark:text-slate-3000" aria-label="Sau">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                    <?php else: ?>                     
                         <button type="submit" class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:border-blue-300 focus:ring ring-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150 dark:border-zink-500 dark:active:border-zink-400 bg-white dark:bg-zink-700 text-slate-300 dark:text-slate-3000" aria-label="Sau">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </button>    
                    <?php endif; ?>  
                </form>             
            </span>         
        </div>     
    </nav> 
</div>  
<?php } else {?>
<?php 
$items_per_page = 10;  
$current_page = isset($_POST['page']) ? max(1, (int)$_POST['page']) : 1; 
$offset = ($current_page - 1) * $items_per_page;  
$total_items = $VCD->get_row("SELECT COUNT(*) as total FROM `accountrb` WHERE `rate` = '$RateCode' AND `status` = '1' ")['total']; 
$total_pages = ceil($total_items / $items_per_page);  
//mã nguồn được phát triển bởi Văn Công Đức ✓
$accounts = $VCD->get_list("SELECT * FROM `accountrb` WHERE  `rate` = '$RateCode' AND `status` = '1' LIMIT $items_per_page OFFSET $offset"); 
?>

 <?php foreach ($accounts as $accountrb): ?>  

   <tr>
    <td class="px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500">
                                       <?=format_cash($accountrb['robux']);?> 
                                    </td>
                                    <td class="px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500">
                                                                      <?=$accountrb['rate'];?> 

                                                                            </td>
                                    <td class="px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500">
                                         <?=format_cash($accountrb['price']);?> đ

                                    </td>
                                    <td class="px-3.5 py-2.5 first:pl-5  last:pr-5 border-y border-slate-200 dark:border-zink-500">

                                     <?=$accountrb['guarantee'];?>
                                    </td>
                                    <td class="px-3.5 py-2.5 first:pl-5 font-bold last:pr-5 border-y border-slate-200 dark:border-zink-500">
                                                                       <?=premium1($accountrb['premium']);?>     </td>
                                    <td class="px-3.5 py-2.5 first:pl-5 font-bold last:pr-5 border-y border-slate-200 dark:border-zink-500">
                                                                           <?=$accountrb['datejoin'];?>  </td>
                                    <td class="px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500">
                                     <button type="button" 
        x-bind="buyItem" 
        data-id="<?=$accountrb['id'];?>" 
        onclick="muanick(<?= $accountrb['id']; ?>)"
        data-type="instant"
        class="text-white py-1 px-0 bg-red-500 border-red-500 btn hover:text-white hover:bg-red-600 hover:border-red-600 focus:text-white focus:bg-red-600 focus:border-red-600 focus:ring focus:ring-red-100 active:text-white active:bg-red-600 active:border-red-600 active:ring active:ring-green-100 dark:ring-red-400/10">
    Mua
</button>
                                            <button type="button"
                                            data-modal-target="detailItemTGD<?= $accountrb['id']; ?>" 
                                                wire:loading.attr="disabled"
                                                class="text-white py-1 px-0 bg-green-500 border-green-500 btn hover:text-white hover:bg-green-600 hover:border-green-600 focus:text-white focus:bg-green-600 focus:border-green-600 focus:ring focus:ring-green-100 active:text-white active:bg-green-600 active:border-green-600 active:ring active:ring-custom-100 dark:ring-green-400/10">
                                            <svg wire:loading wire:target="detail(152323)"
                                                 class="w-4 h-4 ltr:mr-2 rtl:ml-2 animate-spin"
                                                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                        stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                      d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            <span wire:loading.remove
                                                  wire:target="detail(152323)">Chi tiết</span>
                                        </button>
 
 <div id="detailItemTGD<?= $accountrb['id']; ?>" wire:ignore.self modal-center=""
         class="fixed flex flex-col transition-all duration-300 ease-in-out left-2/4 z-drawer -translate-x-2/4 -translate-y-2/4 show hidden">
        <div class="w-screen lg:w-[55rem] bg-white shadow rounded-md dark:bg-zink-600 flex flex-col h-full">
        <div class="max-h-[calc(theme('height.screen')_-_180px)] p-4 overflow-y-auto">
                                    <div wire:loading="" wire:target="account" class="text-center py-4">
                        <span>Loading...</span>
                    </div>
                    <div wire:snapshot="{&quot;data&quot;:{&quot;account&quot;:[null,{&quot;class&quot;:&quot;App\\Models\\AccountItem&quot;,&quot;key&quot;:190415,&quot;s&quot;:&quot;mdl&quot;}],&quot;accSuggest&quot;:[null,{&quot;keys&quot;:[190416,190442,190446,190414,190440],&quot;class&quot;:&quot;Illuminate\\Database\\Eloquent\\Collection&quot;,&quot;modelClass&quot;:&quot;App\\Models\\AccountItem&quot;,&quot;s&quot;:&quot;elcln&quot;}],&quot;idItem&quot;:190415},&quot;memo&quot;:{&quot;id&quot;:&quot;opP8fesAOGnorhgrgSot&quot;,&quot;name&quot;:&quot;detail.detail-roblox-instant&quot;,&quot;path&quot;:&quot;\/&quot;,&quot;method&quot;:&quot;GET&quot;,&quot;children&quot;:[],&quot;scripts&quot;:[],&quot;assets&quot;:[],&quot;errors&quot;:[],&quot;locale&quot;:&quot;vi&quot;},&quot;checksum&quot;:&quot;621fe16a4a15e8298f80478a7a965e1a2db5ab0124c65d21bbf9e8b33425ca48&quot;}" wire:effects="{&quot;dispatches&quot;:[{&quot;name&quot;:&quot;refresh&quot;,&quot;params&quot;:[]}]}" wire:id="opP8fesAOGnorhgrgSot" class="grid grid-cols-12 2xl:grid-cols-12 gap-x-5">
    <div class="col-span-12  2xl:col-span-8 flex justify-between" style="flex-direction: column">
        <div>
            <div class="flex border-b-2">
                <img width="100" src="<?= BASE_URL('public') ?>/assets/img/roblox-logo.png">
                <div class="my-auto">
                    <h4>Roblox</h4>
                    <h6 class="text-green-500">Giao ngay</h6>
                </div>
            </div>
            <div class="mt-1">
                <p><strong>Lưu ý:</strong>&nbsp;<br>Gặp lỗi trong quá trình mua bán acc vui lòng sử dụng nút khiếu nại<br>Nút khiếu nại lằm trong lịch sử mua hàng khi bạn mua sẽ xuất hiện trong 10p&nbsp;<br>Không sử dụng nút này đồng nghĩa với việc bạn tự đánh mất quyền được bảo hành<br>Chúng tôi không chấp nhận bất kỳ lý do vớ vẩn khi không chủ động kiểm tra tài khoản không báo lỗi</p>
            </div>
        </div>
        <div class="mt-2">


            <div class="mt-3 mb-2" x-data="{swiper: null}" x-init="
                 swiper = new Swiper($refs.accountSlide, {
                                             slidesPerView: 'auto',
                                             spaceBetween: 30
                                     });
                 ">
               
            </div>
        </div>
    </div>
    <div class="col-span-12  2xl:col-span-4 modal-detail-right p-2 flex justify-between" style="flex-direction: column">
        <div class="flex justify-center">
            <img width="250" src="<?= BASE_URL('public') ?>/assets/img/roblox-logo.png">
        </div>
        <div class="text-center">
            <p><span class="font-bold" id="accNumber">#ID:</span> <?=$accountrb['id'];?> </p>
            <p><span class="font-bold">Rate:</span> <?=$accountrb['rate'];?></p>
            <p><span class="font-bold">Roblox:</span>  <?=format_cash($accountrb['robux']);?></p>
            <p><span class="font-bold">Price:</span>
                                     <?=format_cash($accountrb['price']);?>đ
                            </p>
            <button type="button"        data-id="<?=$accountrb['id'];?>" 
        onclick="muanick(<?= $accountrb['id']; ?>)" wire:click="buyItemDetail" wire:loading.attr="disabled" class="relative font-medium px-8 btn-main py-2.5  text-15 text-white btn bg-custom-500 border-custom-500
                    hover:text-white focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100
                    active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">
                <svg wire:loading="" wire:target="buyItemDetail" class="w-4 h-4 ltr:mr-2 rtl:ml-2 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Mua
            </button>
        </div>
    </div>
</div>
                            </div>
        </div>
    </div>

                                    </td>
                                     </tr>
                                    <?php endforeach; ?>
                               
        </tbody>
    </table>
</div></div>
<div class="mt-2 flex justify-end">     
    <nav role="navigation" aria-label="Pagination Navigation">         
        <div class="dataTables_paginate paging_simple_numbers">             
            <span class="relative z-0 inline-flex flex-wrap rtl:flex-row-reverse rounded-md shadow-sm">                 
                <form method="POST" action="" style="display:inline;">
                         <input type="hidden" name="rate_code" value="<?= $RateCode; ?>">
                    <input type="hidden" name="page" value="<?= max(1, $current_page - 1) ?>" />
                    <?php if ($current_page > 1): ?>                     
                        <button type="submit">  
                             <span aria-disabled="true" aria-label="Trước">
                                 <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-l-md leading-5 dark:border-zink-500 dark:active:border-zink-400 bg-white dark:bg-zink-700 text-slate-300 dark:text-slate-300" aria-hidden="true">
                                     <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                         <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                     </svg>
                                 </span>
                             </span>
                        </button>                 
                    <?php else: ?>                     
                        <span>
                            <span aria-disabled="true" aria-label="Trước">
                                <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-l-md leading-5 dark:border-zink-500 dark:active:border-zink-400 bg-white dark:bg-zink-700 text-slate-300 dark:text-slate-300" aria-hidden="true">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </span>
                            </span>
                        </span>                 
                    <?php endif; ?>  
                </form>  

                <?php
                $range = 4;
                $start = max(1, $current_page - $range);
                $end = min($total_pages, $current_page + $range);
                if ($current_page > $range + 2) {
                    echo '<span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 dark:border-zink-500 dark:active:border-zink-400 bg-white dark:bg-zink-700 text-slate-300 dark:text-slate-3000">...</span>';
                }

                for ($i = $start; $i <= $end; $i++): 
                    ?>
                    <form method="POST" action="" style="display:inline;">
                                        <input type="hidden" name="rate_code" value="<?= $RateCode; ?>">
                        <input type="hidden" name="page" value="<?= $i ?>" />
                        <button type="submit">      
                            <span class="<?= $i === $current_page ? 'relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 dark:border-zink-500 dark:active:border-zink-400 font-semibold bg-slate-100 dark:bg-zink-600 text-slate-800 hover:text-slate-900 hover:border-slate-200 hover:shadow-sm focus:ring focus:ring-slate-300 focus:ring-opacity-25 dark:text-slate-100 dark:hover:border-zink-500 dark:hover:text-zink-50 dark:focus:ring-zink-500 dark:focus:ring-opacity-40' : 'relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 dark:border-zink-500 dark:active:border-zink-400' ?>">
                                <?= $i ?>
                            </span>
                        </button>                     
                    </form>                 
                <?php endfor; ?>  
                <?php if ($current_page + $range < $total_pages - 1) {
                    echo '<span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 dark:border-zink-500 dark:active:border-zink-400 bg-white dark:bg-zink-700 text-slate-300 dark:text-slate-3000">...</span>';
                }
                ?>

                <!-- mã nguồn được phát triển bởi Văn Công Đức ✓ -->
                <form method="POST" action="" style="display:inline;">
                                    <input type="hidden" name="rate_code" value="<?= $RateCode; ?>">
                    <input type="hidden" name="page" value="<?= min($total_pages, $current_page + 1) ?>" />
                    <?php if ($current_page < $total_pages): ?>                     
                         <button type="submit" class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:border-blue-300 focus:ring ring-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150 dark:border-zink-500 dark:active:border-zink-400 bg-white dark:bg-zink-700 text-slate-300 dark:text-slate-3000" aria-label="Sau">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                    <?php else: ?>                     
                         <button type="submit" class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:border-blue-300 focus:ring ring-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150 dark:border-zink-500 dark:active:border-zink-400 bg-white dark:bg-zink-700 text-slate-300 dark:text-slate-3000" aria-label="Sau">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </button>    
                    <?php endif; ?>  
                </form>             
            </span>         
        </div>     
    </nav> 
</div>  

<?php } ?>

            </div>  
             </div>  
                         </div>  
                        </div>   
                                  </div> 
        
        
        
        <!-- mã nguồn được phát triển bởi Văn Công Đức ✓ -->
        <div class="col-span-12 card 2xl:col-span-12" id="form2" style=" display: none; ">
        <div class="card-body">
            <div class="grid items-center grid-cols-1 gap-3 mb-5 2xl:grid-cols-12">
                <div class="2xl:col-span-3 ">
                    <h6 class="text-15">Tài khoản đã nạp Robux</h6>

                </div><!--end col-->

            </div><!--end grid-->

            <form wire:submit="search" class="mt-2" data-gtm-form-interact-id="0">
                <div class="grid grid-cols-1 gap-x-5 md:grid-cols-2 xl:grid-cols-4">
                    <div class="mb-4">
                        <label for="firstNameInput2" class="inline-block mb-2 text-base font-medium">Premium</label>
                        <select wire:model="isPremium" class="form-select border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" id="stateInput" data-gtm-form-interact-field-id="0">
                            <option selected="" value="">Tất cả</option>
                            <option value="1">Có</option>
                            <option value="0">Không</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="firstNameInput2" class="inline-block mb-2 text-base font-medium">Sắp xếp theo</label>
                        <select wire:model="sortBy" class="form-select border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" id="stateInput">
                            <option selected="" value="">Không</option>
                            <option value="price-low">Giá từ thấp đến cao</option>
                            <option value="price-high">Giá từ cao đến thấp</option>
                            <option value="robux-high">Robux từ cao đến thấp</option>
                            <option value="robux-low">Robux từ thấp đến cao</option>
                            <option value="war-high">Thời gian bảo hành từ cao đến thấp</option>
                            <option value="war-low">Thời gian bảo hành từ thấp đến cao</option>
                            <option value="join-high">Ngày tham gia từ cao đến thấp</option>
                            <option value="join-low">Ngày tham gia từ thấp đến đến</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="firstNameInput2" class="inline-block mb-2 text-base font-medium">Rate</label>
                        <select wire:model="rate" class="form-select border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" id="stateInput">
                            <option selected="" value="">Tất cả</option>
                            <?php foreach ($VCD->get_list("SELECT * FROM `mucrate`") as $tgdev) {?>
                                            <option value="<?=$tgdev['code'];?>"><?=$tgdev['code'];?></option>
                                        <?php } ?>
                                                        
                                                    </select>
                    </div>
                    <div class="mb-4 flex items-end">
                        <button type="submit" class="text-white transition-all duration-200 ease-linear btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100">
                            <svg wire:loading="" class="w-4 h-4 ltr:mr-2 rtl:ml-2 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            Lọc
                        </button>
                    </div>
                </div>

            </form>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-x-2 gap-y-3 mt-2" wire:poll.30s="">
                <?php 
$items_per_page = 10;  
$current_page = isset($_POST['page']) ? max(1, (int)$_POST['page']) : 1; 
$offset = ($current_page - 1) * $items_per_page;  
$total_items = $VCD->get_row("SELECT COUNT(*) as total FROM `accountrb` WHERE `status` = '1' ")['total']; 
$total_pages = ceil($total_items / $items_per_page);  
//mã nguồn được phát triển bởi Văn Công Đức ✓
$accounts2 = $VCD->get_list("SELECT * FROM `accountrb` WHERE `status` = '1' LIMIT $items_per_page OFFSET $offset"); 
?>

 <?php foreach ($accounts2 as $accountrb2): ?>  
                                    <div class="card border border-custom-200 dark:border-custom-500/20">
                        <div class="card-body ">
                            <div class="text-right">
                                    <span class="px-2.5 py-0.5 text-xs font-medium inline-block rounded border bg-red-500 border-red-500 text-red-50">
                                    #<?=$accountrb2['id'];?> </span>
                            </div>
                            <div class="flex justify-center items-center">
                                <img src="<?= BASE_URL('public') ?>/assets/images/dr1.jpg" width="25" class="group-data-[sidebar=dark]:hidden">
                                <img src="<?= BASE_URL('public') ?>/assets/images/dr2.png" width="25" class="hidden group-data-[sidebar=dark]:block">
                                <h4> <?=$accountrb2['robux'];?> </h4>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-x-2 p-2 mt-2  border border-custom-100 dark:border-custom-500/20">
                                <div>
                                        <span class="text-green-500 dark:color-yellow-2x font-bold ">Rate:</span> <?=$accountrb2['rate'];?> 
                                </div>
                                <div>
                                    <span class="text-green-500 dark:color-yellow-2x font-bold">Bảo hành:</span> <?=$accountrb2['guarantee'];?>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-2 p-2 mt-2 border border-custom-100 dark:border-custom-500/20">
                                <div>
                                        <span class="text-green-500 dark:color-yellow-2x font-bold">Premium:</span> <?=premium1($accountrb2['premium']);?>
                                </div>
                                <div>
                                    <span class="text-green-500 dark:color-yellow-2x font-bold">Ngày tham gia:</span> <?=$accountrb2['datejoin'];?> 
                                                                    </div>
                            </div>
                            <h5 class="mt-2 font-bold px-2.5 py-0.5 text-lg text-center rounded border
                                bg-custom-100 border-transparent text-custom-500 dark:color-yellow-2x dark:bg-custom-500/20 dark:border-transparent">
                                 <?=format_cash($accountrb2['price']);?> đ
                            </h5>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4 mt-2 ">
                                <div>
                                    <button type="button" x-bind="buyItem"   data-id="<?=$accountrb2['id'];?>" 
        onclick="muanick(<?= $accountrb2['id']; ?>)" data-type="instant" class="w-full text-white py-1 px-0 bg-red-500 border-red-500 btn hover:text-white hover:bg-red-600 hover:border-red-600 focus:text-white focus:bg-red-600 focus:border-red-600 focus:ring focus:ring-red-100 active:text-white active:bg-red-600 active:border-red-600 active:ring active:ring-red-100 dark:ring-red-400/10">

                                        Mua
                                    </button>
                                </div>
                                <div>
                                    <button type="button" onclick="detail(<?= $accountrb2['id']; ?>)" wire:loading.attr="disabled" class="w-full text-white py-1 px-0 bg-green-500 border-green-500 btn hover:text-white hover:bg-green-600 hover:border-green-600 focus:text-white focus:bg-green-600 focus:border-green-600 focus:ring focus:ring-green-100 active:text-white active:bg-green-600 active:border-green-600 active:ring active:ring-green-100 dark:ring-green-400/10">
                                        <svg wire:loading="" wire:target="detail(158240)" class="w-4 h-4 ltr:mr-2 rtl:ml-2 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                        </svg>
                                        <span wire:loading.remove="" wire:target="detail(158240)">Chi tiết</span>
                                    </button>
                                    
                                </div>
                            </div>

                        </div>
                    </div>
                                  <?php endforeach; ?>  
                            </div>

        <div class="mt-2 flex justify-end">     
    <nav role="navigation" aria-label="Pagination Navigation">         
        <div class="dataTables_paginate paging_simple_numbers">             
            <span class="relative z-0 inline-flex flex-wrap rtl:flex-row-reverse rounded-md shadow-sm">                 
                <form method="POST" action="" style="display:inline;">
                         <input type="hidden" name="rate_code" value="<?= $RateCode; ?>">
                    <input type="hidden" name="page" value="<?= max(1, $current_page - 1) ?>" />
                    <?php if ($current_page > 1): ?>                     
                        <button type="submit">  
                             <span aria-disabled="true" aria-label="Trước">
                                 <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-l-md leading-5 dark:border-zink-500 dark:active:border-zink-400 bg-white dark:bg-zink-700 text-slate-300 dark:text-slate-300" aria-hidden="true">
                                     <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                         <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                     </svg>
                                 </span>
                             </span>
                        </button>                 
                    <?php else: ?>                     
                        <span>
                            <span aria-disabled="true" aria-label="Trước">
                                <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-l-md leading-5 dark:border-zink-500 dark:active:border-zink-400 bg-white dark:bg-zink-700 text-slate-300 dark:text-slate-300" aria-hidden="true">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </span>
                            </span>
                        </span>                 
                    <?php endif; ?>  
                </form>  

                <?php
                $range = 4;
                $start = max(1, $current_page - $range);
                $end = min($total_pages, $current_page + $range);
                if ($current_page > $range + 2) {
                    echo '<span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 dark:border-zink-500 dark:active:border-zink-400 bg-white dark:bg-zink-700 text-slate-300 dark:text-slate-3000">...</span>';
                }

                for ($i = $start; $i <= $end; $i++): 
                    ?>
                    <form method="POST" action="" style="display:inline;">
                                        <input type="hidden" name="rate_code" value="<?= $RateCode; ?>">
                        <input type="hidden" name="page" value="<?= $i ?>" />
                        <button type="submit">      
                            <span class="<?= $i === $current_page ? 'relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 dark:border-zink-500 dark:active:border-zink-400 font-semibold bg-slate-100 dark:bg-zink-600 text-slate-800 hover:text-slate-900 hover:border-slate-200 hover:shadow-sm focus:ring focus:ring-slate-300 focus:ring-opacity-25 dark:text-slate-100 dark:hover:border-zink-500 dark:hover:text-zink-50 dark:focus:ring-zink-500 dark:focus:ring-opacity-40' : 'relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 dark:border-zink-500 dark:active:border-zink-400' ?>">
                                <?= $i ?>
                            </span>
                        </button>                     
                    </form>                 
                <?php endfor; ?>  
                <?php if ($current_page + $range < $total_pages - 1) {
                    echo '<span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 dark:border-zink-500 dark:active:border-zink-400 bg-white dark:bg-zink-700 text-slate-300 dark:text-slate-3000">...</span>';
                }
                ?>

                <!-- mã nguồn được phát triển bởi Văn Công Đức ✓ -->
                <form method="POST" action="" style="display:inline;">
                                    <input type="hidden" name="rate_code" value="<?= $RateCode; ?>">
                    <input type="hidden" name="page" value="<?= min($total_pages, $current_page + 1) ?>" />
                    <?php if ($current_page < $total_pages): ?>                     
                         <button type="submit" class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:border-blue-300 focus:ring ring-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150 dark:border-zink-500 dark:active:border-zink-400 bg-white dark:bg-zink-700 text-slate-300 dark:text-slate-3000" aria-label="Sau">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                    <?php else: ?>                     
                         <button type="submit" class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:border-blue-300 focus:ring ring-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150 dark:border-zink-500 dark:active:border-zink-400 bg-white dark:bg-zink-700 text-slate-300 dark:text-slate-3000" aria-label="Sau">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </button>    
                    <?php endif; ?>  
                </form>             
            </span>         
        </div>     
    </nav> 
</div>  

        </div>


    </div>
    
    
    
        <div wire:snapshot="{&quot;data&quot;:{&quot;sortDirection&quot;:&quot;desc&quot;,&quot;sortColumn&quot;:&quot;price&quot;,&quot;idItem&quot;:null,&quot;rate&quot;:null,&quot;rates&quot;:[null,{&quot;keys&quot;:[],&quot;class&quot;:&quot;Illuminate\\Database\\Eloquent\\Collection&quot;,&quot;modelClass&quot;:null,&quot;s&quot;:&quot;elcln&quot;}],&quot;account&quot;:null,&quot;myAccount&quot;:false,&quot;paginators&quot;:[{&quot;page&quot;:1},{&quot;s&quot;:&quot;arr&quot;}]},&quot;memo&quot;:{&quot;id&quot;:&quot;90nLSHMijByFXXlzXjqE&quot;,&quot;name&quot;:&quot;home.pre-oder-acc&quot;,&quot;path&quot;:&quot;\/&quot;,&quot;method&quot;:&quot;GET&quot;,&quot;children&quot;:[],&quot;scripts&quot;:[],&quot;assets&quot;:[],&quot;errors&quot;:[],&quot;locale&quot;:&quot;vi&quot;},&quot;checksum&quot;:&quot;59920fed35a98795aea3c8e251ae76d4697414ac23753063ac8ae922c9c655bd&quot;}" wire:effects="{&quot;listeners&quot;:[&quot;updateListAccOrder&quot;,&quot;switchAccount&quot;]}" wire:id="90nLSHMijByFXXlzXjqE" class="col-span-12 card 2xl:col-span-12" wire:poll.15s>
    <div class="card-body">
        <div class="grid items-center grid-cols-1 gap-3 mb-5 2xl:grid-cols-12">
            <div class="2xl:col-span-3">
                <h6 class="text-15">Tài khoản order</h6>
            </div><!--end col-->
        </div><!--end grid-->
         <?php
$rateorder = $VCD->get_list("SELECT * FROM `rateorder` WHERE `status` = '1'");
$RateorderId = $_POST['rateorder_id'] ?? null;
$RateorderCode = $_POST['rateorder_code'] ?? null;

?>
        <div class="overflow-x-auto" wire:ignore.self>
            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
               <?php foreach ($rateorder as $setRateorder): ?>
        <form method="POST" style="display: inline;" onsubmit="handleFormSubmission(event, this);">
            <input type="hidden" name="rateorder_id" value="<?= $setRateorder['id']; ?>">
            <input type="hidden" name="rateorder_code" value="<?= $setRateorder['code']; ?>">
            <button type="submit"
                class="btn-rate py-1 px-0 font-bold mt-1 bg-white relative btn border-custom-500 hover:text-white hover:bg-custom-600">
                <svg class="spinner hidden opacity-50 w-4 h-4 ltr:mr-2 rtl:ml-2 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <?= $setRateorder['code']; ?>
                <span class="absolute flex items-center justify-center w-[16px] h-[16px] text-xs text-white bg-red-400 rounded-full -top-1 -right-1">
                    <?= $setRateorder['id']; ?>
                </span>
            </button>
        </form>
    <?php endforeach; ?>
        </div>
        <div class="overflow-x-auto">
            <div class="my-2 col-span-12 overflow-x-auto lg:col-span-12">
                <table class="display stripe group dataTable w-full text-sm align-middle ">
                    <thead
                        class="ltr:text-left rtl:text-right bg-slate-100 text-slate-500 dark:text-zink-200 dark:bg-zink-600">
                    <tr>
                        <th wire:click="doSort('id')" class="p-3 group-[.bordered]:border group-[.bordered]:border-slate-200 group-[.bordered]:dark:border-zink-500 sorting px-3 py-4
    text-slate-900 text-15  bg-slate-200/50 font-semibold text-left dark:color-yellow-2x dark:bg-zink-600 dark:group-[.bordered]:border-zink-500"
    >
        #
    </th>
                        <th wire:click="doSort('robux')" class="p-3 group-[.bordered]:border group-[.bordered]:border-slate-200 group-[.bordered]:dark:border-zink-500 sorting px-3 py-4
    text-slate-900 text-15  bg-slate-200/50 font-semibold text-left dark:color-yellow-2x dark:bg-zink-600 dark:group-[.bordered]:border-zink-500"
    >
        Robux
    </th>
                        <th wire:click="doSort('rate')" class="p-3 group-[.bordered]:border group-[.bordered]:border-slate-200 group-[.bordered]:dark:border-zink-500 sorting px-3 py-4
    text-slate-900 text-15  bg-slate-200/50 font-semibold text-left dark:color-yellow-2x dark:bg-zink-600 dark:group-[.bordered]:border-zink-500"
    >
        Rate
    </th>
                        <th wire:click="doSort('price')" class="text-15 ltr:!text-left rtl:!text-right p-3 group-[.bordered]:border group-[.bordered]:border-slate-200
        group-[.bordered]:dark:border-zink-500 sorting px-3 py-4 text-slate-900 bg-slate-200/50
        font-semibold text-left dark:color-yellow-2x dark:bg-zink-600 dark:group-[.bordered]:border-zink-500 sorting_desc"
        aria-sort="descending"
    >
        Giá
    </th>
                        <th wire:click="doSort('warranty_period')" class="p-3 group-[.bordered]:border group-[.bordered]:border-slate-200 group-[.bordered]:dark:border-zink-500 sorting px-3 py-4
    text-slate-900 text-15  bg-slate-200/50 font-semibold text-left dark:color-yellow-2x dark:bg-zink-600 dark:group-[.bordered]:border-zink-500"
    >
        Bảo hành
    </th>
                        <th class="text-15 p-3 group-[.bordered]:border group-[.bordered]:border-slate-200 group-[.bordered]:dark:border-zink-500  px-3 py-4
    text-slate-900 bg-slate-200/50 font-semibold text-left dark:color-yellow-2x dark:bg-zink-600 dark:group-[.bordered]:border-zink-500">
                            Thời gian giao hàng
                        </th>
                        <th wire:click="doSort('is_premium')" class="p-3 group-[.bordered]:border group-[.bordered]:border-slate-200 group-[.bordered]:dark:border-zink-500 sorting px-3 py-4
    text-slate-900 text-15  bg-slate-200/50 font-semibold text-left dark:color-yellow-2x dark:bg-zink-600 dark:group-[.bordered]:border-zink-500"
    >
        Premium
    </th>
                        <th class="text-15 p-3 group-[.bordered]:border group-[.bordered]:border-slate-200 group-[.bordered]:dark:border-zink-500  px-3 py-4
    text-slate-900 bg-slate-200/50 font-semibold text-left dark:color-yellow-2x dark:bg-zink-600 dark:group-[.bordered]:border-zink-500">Hành động</th>
                    </tr>
                    </thead>
                    <tbody>
                    <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
               <?php if (empty($RateorderId) && empty($RateorderCode)) { ?>
<?php 
$items_per_page = 10;  
$current_page = isset($_POST['page']) ? max(1, (int)$_POST['page']) : 1; 
$offset = ($current_page - 1) * $items_per_page;  

// Đếm tổng số bản ghi 
$total_items = $VCD->get_row("SELECT COUNT(*) as total FROM `accountorder` WHERE `status` = '1' ")['total']; 
$total_pages = ceil($total_items / $items_per_page);  

// Lấy danh sách tài khoản 
$accountorders1 =  $VCD->get_list("SELECT * FROM `accountorder` WHERE  `status` = '1' LIMIT $items_per_page OFFSET $offset"); 
?>

 <?php $i = 1; foreach ($accountorders1 as $accountorder1): ?>
                                    <tr>
                                         <td class="px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500">
                                                                      <?=$i++;?> 

                                                                            </td>
                                      
    <td class="px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500">
                                       <?=format_cash($accountorder1['robux']);?> 
                                    </td>
                                    <td class="px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500">
                                                                      <?=$accountorder1['rate'];?> 

                                                                            </td>
                                    <td class="px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500">
                                         <?=format_cash($accountorder1['price']);?> đ

                                    </td>
                                    <td class="px-3.5 py-2.5 first:pl-5  last:pr-5 border-y border-slate-200 dark:border-zink-500">

                                     <?=$accountorder1['guarantee'];?> Phút
                                    </td>
                            
                                    <td class="px-3.5 py-2.5 first:pl-5 font-bold last:pr-5 border-y border-slate-200 dark:border-zink-500">
                                                                             1 - 20 phút   </td>
                                                                                     <td class="px-3.5 py-2.5 first:pl-5 font-bold last:pr-5 border-y border-slate-200 dark:border-zink-500">
                                                                       <?=premium1($accountorder1['premium']);?>     </td>
                                    <td class="px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500">
                                  <button type="button" x-bind="preBuyItem"  data-id="<?=$accountorder1['id'];?>" 
        onclick="ordernick(<?= $accountorder1['id']; ?>)" class="text-white py-1 px-0 bg-green-500 border-green-500 btn hover:text-white hover:bg-green-600 hover:border-green-600 focus:text-white focus:bg-green-600 focus:border-green-600 focus:ring focus:ring-green-100 active:text-white active:bg-green-600 active:border-green-600 active:ring active:ring-green-100 dark:ring-green-400/10">

                                    Đặt hàng
                                </button>
                                                            <button type="button"
                                                data-modal-target="detailItemModalPree<?= $accountorder1['id']; ?>" 
                                                wire:loading.attr="disabled"
                                                class="text-white py-1 px-0 bg-custom-500 border-custom-500 btn hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/10">
                                            <svg wire:loading wire:target="detail(152323)"
                                                 class="w-4 h-4 ltr:mr-2 rtl:ml-2 animate-spin"
                                                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                        stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                      d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            <span wire:loading.remove
                                                  wire:target="detail(152323)">Chi tiết</span>
                                        </button>
<div id="detailItemModalPree<?= $accountorder1['id']; ?>" wire:ignore.self="" modal-center="" class="fixed flex flex-col transition-all duration-300 ease-in-out left-2/4 z-drawer -translate-x-2/4 -translate-y-2/4  show hidden">
        <div class="w-screen lg:w-[55rem] bg-white shadow rounded-md dark:bg-zink-600 flex flex-col h-full">
            <div class="max-h-[calc(theme('height.screen')_-_180px)] p-4 overflow-y-auto">
                <!--[if BLOCK]><![endif]-->                    <div wire:loading="" wire:target="account" class="text-center py-4">
                        <span>Loading...</span>
                    </div>
                    <div wire:snapshot="{&quot;data&quot;:{&quot;account&quot;:[null,{&quot;class&quot;:&quot;App\\Models\\AccountItem&quot;,&quot;key&quot;:195113,&quot;s&quot;:&quot;mdl&quot;}],&quot;accSuggest&quot;:[null,{&quot;keys&quot;:[195111,195112],&quot;class&quot;:&quot;Illuminate\\Database\\Eloquent\\Collection&quot;,&quot;modelClass&quot;:&quot;App\\Models\\AccountItem&quot;,&quot;s&quot;:&quot;elcln&quot;}]},&quot;memo&quot;:{&quot;id&quot;:&quot;q9sFBoPMtk7f43hihI1d&quot;,&quot;name&quot;:&quot;detail.detail-roblox-order&quot;,&quot;path&quot;:&quot;\/&quot;,&quot;method&quot;:&quot;GET&quot;,&quot;children&quot;:[],&quot;scripts&quot;:[],&quot;assets&quot;:[],&quot;errors&quot;:[],&quot;locale&quot;:&quot;vi&quot;},&quot;checksum&quot;:&quot;495e0473bfff0fe763ca4bc45380b198a6992e93946f39d14b9a11819699c4d6&quot;}" wire:effects="[]" wire:id="q9sFBoPMtk7f43hihI1d" class="grid grid-cols-12 2xl:grid-cols-12 gap-x-5">
    <div class="col-span-12  2xl:col-span-8 flex justify-between" style="flex-direction: column">
        <div>
            <div class="flex border-b-2">
                <img width="100" src="<?= BASE_URL('public') ?>/assets/img/roblox-logo.png">
                <div class="my-auto">
                    <h4>Roblox</h4>
                    <h6 class="text-green-500">Order</h6>
                </div>
            </div>
            <div class="mt-1">
                <p><strong>LƯU Ý KHI MUA HÀNG ORDER</strong><br>Sau khi mua hàng tại mục này, bạn cần chờ đợi người bán hàng nạp đủ số lượng robux. <br>Sau đó sẽ nhận được tài khoản mật khẩu, khi đó hệ thống mới tính thời gian bảo hành.<br>Nếu hàng hóa quá thời gian order nhưng không được sử lý hãy liên hệ với admin để hỗ trợ.<br><strong>Lưu ý:</strong>&nbsp;<br>Gặp lỗi trong quá trình mua bán acc vui lòng sử dụng nút khiếu nại<br>Nút khiếu nại lằm trong lịch sử mua hàng khi bạn mua sẽ xuất hiện trong 10p&nbsp;<br>Không sử dụng nút này đồng nghĩa với việc bạn tự đánh mất quyền được bảo hành<br>Chúng tôi không chấp nhận bất kỳ lý do vớ vẩn khi không chủ động kiểm tra tài khoản không báo lỗi</p>
            </div>
        </div>
        <div class="mt-2">


            <div class="mt-3 mb-2" x-data="{swiper: null}" x-init="
                 swiper = new Swiper($refs.accountSlide, {
                                             slidesPerView: 'auto',
                                             spaceBetween: 30
                                     });
                 ">
              
           
            </div>
        </div>
    </div>
    <div class="col-span-12  2xl:col-span-4 modal-detail-right p-2 flex justify-between" style="flex-direction: column">
        <div class="flex justify-center">
            <img width="250" src="<?= BASE_URL('public') ?>/assets/img/roblox-logo.png">
        </div>
        <div class="text-center">
            <p><span class="font-bold">#ID:</span> <?= $accountorder1['id']; ?></p>
            <p><span class="font-bold">Rate:</span>          <?=$accountorder1['rate'];?> </p>
            <p><span class="font-bold">Roblox:</span>    <?=format_cash($accountorder1['robux']);?> </p>
            <p><span class="font-bold">Price:</span>
                                    <?=format_cash($accountorder1['price']);?>đ
                            </p>
            <button type="button"   data-id="<?=$accountorder1['id'];?>" 
        onclick="ordernick(<?= $accountorder1['id']; ?>)"  wire:click="buyItemDetail" wire:loading.attr="disabled" class="relative font-medium px-8 btn-main py-2.5  text-15 text-white btn bg-custom-500 border-custom-500
                    hover:text-white focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100
                    active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">
                <svg wire:loading="" wire:target="buyItemDetail" class="w-4 h-4 ltr:mr-2 rtl:ml-2 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Mua ngay
            </button>
        </div>
    </div>
</div>
                <!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>
    </div>
                                    </td> </tr>
                                    <?php endforeach; ?>
                         
        </tbody>
    </table>     
    </div></div>
 <div class="mt-2">
            <div class="flex justify-end">
    <nav role="navigation" aria-label="Pagination Navigation">         
        <div class="dataTables_paginate paging_simple_numbers">             
            <span class="relative z-0 inline-flex flex-wrap rtl:flex-row-reverse rounded-md shadow-sm">                 
                <!-- Nút "Trước" -->
                <form method="POST" action="" style="display:inline;">
                    <input type="hidden" name="page" value="<?= max(1, $current_page - 1) ?>" />
                    <?php if ($current_page > 1): ?>                     
                        <button type="submit">  
                             <span aria-disabled="true" aria-label="Trước">
                                 <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-l-md leading-5 dark:border-zink-500 dark:active:border-zink-400 bg-white dark:bg-zink-700 text-slate-300 dark:text-slate-300" aria-hidden="true">
                                     <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                         <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                     </svg>
                                 </span>
                             </span>
                        </button>                 
                    <?php else: ?>                     
                        <span>
                            <span aria-disabled="true" aria-label="Trước">
                                <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-l-md leading-5 dark:border-zink-500 dark:active:border-zink-400 bg-white dark:bg-zink-700 text-slate-300 dark:text-slate-300" aria-hidden="true">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </span>
                            </span>
                        </span>                 
                    <?php endif; ?>  
                </form>  
<!--mã nguồn được phát triển bởi Văn Công Đức ✓-->
                <?php
                // mã nguồn được phát triển bởi Văn Công Đức ✓
                $range = 4; // Số trang hiển thị giữa
                $start = max(1, $current_page - $range);
                $end = min($total_pages, $current_page + $range);

                // mã nguồn được phát triển bởi Văn Công Đức ✓
                if ($current_page > $range + 2) {
                    echo '<span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 dark:border-zink-500 dark:active:border-zink-400 bg-white dark:bg-zink-700 text-slate-300 dark:text-slate-3000">...</span>';
                }

                for ($i = $start; $i <= $end; $i++): 
                    ?>
                    <form method="POST" action="" style="display:inline;">
                        <input type="hidden" name="page" value="<?= $i ?>" />
                        <button type="submit">      
                            <span class="<?= $i === $current_page ? 'relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 dark:border-zink-500 dark:active:border-zink-400 font-semibold bg-slate-100 dark:bg-zink-600 text-slate-800 hover:text-slate-900 hover:border-slate-200 hover:shadow-sm focus:ring focus:ring-slate-300 focus:ring-opacity-25 dark:text-slate-100 dark:hover:border-zink-500 dark:hover:text-zink-50 dark:focus:ring-zink-500 dark:focus:ring-opacity-40' : 'relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 dark:border-zink-500 dark:active:border-zink-400' ?>">
                                <?= $i ?>
                            </span>
                        </button>                     
                    </form>                 
                <?php endfor; ?>  

                <!--mã nguồn được phát triển bởi Văn Công Đức ✓ -->
                <?php if ($current_page + $range < $total_pages - 1) {
                    echo '<span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 dark:border-zink-500 dark:active:border-zink-400 bg-white dark:bg-zink-700 text-slate-300 dark:text-slate-3000">...</span>';
                }
                ?>

                <!-- Nút "Tiếp" -->
                <form method="POST" action="" style="display:inline;">
                    <input type="hidden" name="page" value="<?= min($total_pages, $current_page + 1) ?>" />
                    <?php if ($current_page < $total_pages): ?>                     
                         <button type="submit" class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:border-blue-300 focus:ring ring-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150 dark:border-zink-500 dark:active:border-zink-400 bg-white dark:bg-zink-700 text-slate-300 dark:text-slate-3000" aria-label="Sau">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                    <?php else: ?>                     
                         <button type="submit" class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:border-blue-300 focus:ring ring-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150 dark:border-zink-500 dark:active:border-zink-400 bg-white dark:bg-zink-700 text-slate-300 dark:text-slate-3000" aria-label="Sau">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </button>    
                    <?php endif; ?>  
                </form>             
            </span>         
        </div>     
    </nav> 
</div>  </div>  
<?php } else {?>
<?php 
$items_per_page = 10;  
$current_page = isset($_POST['page']) ? max(1, (int)$_POST['page']) : 1; 
$offset = ($current_page - 1) * $items_per_page;  
$total_items = $VCD->get_row("SELECT COUNT(*) as total FROM `accountorder` WHERE `rate` = '$RateorderCode' AND `status` = '1' ")['total']; 
$total_pages = ceil($total_items / $items_per_page);  
//mã nguồn được phát triển bởi Văn Công Đức ✓
$accountorders = $VCD->get_list("SELECT * FROM `accountorder` WHERE  `rate` = '$RateorderCode' AND `status` = '1' LIMIT $items_per_page OFFSET $offset"); 
?>

 <?php $i = 1; foreach ($accountorders as $accountorder): ?>  

   <tr>
        <td class="px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500">
                                                                      <?=$i++;?> 

                                                                            </td>
    <td class="px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500">
                                       <?=format_cash($accountorder['robux']);?> 
                                    </td>
                                    <td class="px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500">
                                                                      <?=$accountorder['rate'];?> 

                                                                            </td>
                                    <td class="px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500">
                                         <?=format_cash($accountorder['price']);?> đ

                                    </td>
                                    <td class="px-3.5 py-2.5 first:pl-5  last:pr-5 border-y border-slate-200 dark:border-zink-500">

                                     <?=$accountorder['guarantee'];?> Phút
                                    </td>
                              
                                    <td class="px-3.5 py-2.5 first:pl-5 font-bold last:pr-5 border-y border-slate-200 dark:border-zink-500">
                                                                          1 - 20 phút  </td>
                                                                                <td class="px-3.5 py-2.5 first:pl-5 font-bold last:pr-5 border-y border-slate-200 dark:border-zink-500">
                                                                       <?=premium1($accountorder['premium']);?>     </td>
                                    <td class="px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500">
                                      <button type="button" x-bind="preBuyItem"  data-id="<?=$accountorder['id'];?>" 
        onclick="ordernick(<?= $accountorder['id']; ?>)" class="text-white py-1 px-0 bg-green-500 border-green-500 btn hover:text-white hover:bg-green-600 hover:border-green-600 focus:text-white focus:bg-green-600 focus:border-green-600 focus:ring focus:ring-green-100 active:text-white active:bg-green-600 active:border-green-600 active:ring active:ring-green-100 dark:ring-green-400/10">

                                    Đặt hàng
                                </button>
                                        <button type="button"
                                                data-modal-target="detailItemModalPre<?= $accountorder['id']; ?>" 
                                                wire:loading.attr="disabled"
                                                class="text-white py-1 px-0 bg-custom-500 border-custom-500 btn hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/10">
                                            <svg wire:loading wire:target="detail(152323)"
                                                 class="w-4 h-4 ltr:mr-2 rtl:ml-2 animate-spin"
                                                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                        stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor"
                                                      d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                            </svg>
                                            <span wire:loading.remove
                                                  wire:target="detail(152323)">Chi tiết</span>
                                        </button>
<div id="detailItemModalPre<?= $accountorder['id']; ?>" wire:ignore.self="" modal-center="" class="fixed flex flex-col transition-all duration-300 ease-in-out left-2/4 z-drawer -translate-x-2/4 -translate-y-2/4  show hidden">
        <div class="w-screen lg:w-[55rem] bg-white shadow rounded-md dark:bg-zink-600 flex flex-col h-full">
            <div class="max-h-[calc(theme('height.screen')_-_180px)] p-4 overflow-y-auto">
                <!--[if BLOCK]><![endif]-->                    <div wire:loading="" wire:target="account" class="text-center py-4">
                        <span>Loading...</span>
                    </div>
                    <div wire:snapshot="{&quot;data&quot;:{&quot;account&quot;:[null,{&quot;class&quot;:&quot;App\\Models\\AccountItem&quot;,&quot;key&quot;:195113,&quot;s&quot;:&quot;mdl&quot;}],&quot;accSuggest&quot;:[null,{&quot;keys&quot;:[195111,195112],&quot;class&quot;:&quot;Illuminate\\Database\\Eloquent\\Collection&quot;,&quot;modelClass&quot;:&quot;App\\Models\\AccountItem&quot;,&quot;s&quot;:&quot;elcln&quot;}]},&quot;memo&quot;:{&quot;id&quot;:&quot;q9sFBoPMtk7f43hihI1d&quot;,&quot;name&quot;:&quot;detail.detail-roblox-order&quot;,&quot;path&quot;:&quot;\/&quot;,&quot;method&quot;:&quot;GET&quot;,&quot;children&quot;:[],&quot;scripts&quot;:[],&quot;assets&quot;:[],&quot;errors&quot;:[],&quot;locale&quot;:&quot;vi&quot;},&quot;checksum&quot;:&quot;495e0473bfff0fe763ca4bc45380b198a6992e93946f39d14b9a11819699c4d6&quot;}" wire:effects="[]" wire:id="q9sFBoPMtk7f43hihI1d" class="grid grid-cols-12 2xl:grid-cols-12 gap-x-5">
    <div class="col-span-12  2xl:col-span-8 flex justify-between" style="flex-direction: column">
        <div>
            <div class="flex border-b-2">
                <img width="100" src="<?= BASE_URL('public') ?>/assets/img/roblox-logo.png">
                <div class="my-auto">
                    <h4>Roblox</h4>
                    <h6 class="text-green-500">Order</h6>
                </div>
            </div>
            <div class="mt-1">
                <p><strong>LƯU Ý KHI MUA HÀNG ORDER</strong><br>Sau khi mua hàng tại mục này, bạn cần chờ đợi người bán hàng nạp đủ số lượng robux. <br>Sau đó sẽ nhận được tài khoản mật khẩu, khi đó hệ thống mới tính thời gian bảo hành.<br>Nếu hàng hóa quá thời gian order nhưng không được sử lý hãy liên hệ với admin để hỗ trợ.<br><strong>Lưu ý:</strong>&nbsp;<br>Gặp lỗi trong quá trình mua bán acc vui lòng sử dụng nút khiếu nại<br>Nút khiếu nại lằm trong lịch sử mua hàng khi bạn mua sẽ xuất hiện trong 10p&nbsp;<br>Không sử dụng nút này đồng nghĩa với việc bạn tự đánh mất quyền được bảo hành<br>Chúng tôi không chấp nhận bất kỳ lý do vớ vẩn khi không chủ động kiểm tra tài khoản không báo lỗi</p>
            </div>
        </div>
        <div class="mt-2">


            <div class="mt-3 mb-2" x-data="{swiper: null}" x-init="
                 swiper = new Swiper($refs.accountSlide, {
                                             slidesPerView: 'auto',
                                             spaceBetween: 30
                                     });
                 ">
              
           
            </div>
        </div>
    </div>
    <div class="col-span-12  2xl:col-span-4 modal-detail-right p-2 flex justify-between" style="flex-direction: column">
        <div class="flex justify-center">
            <img width="250" src="<?= BASE_URL('public') ?>/assets/img/roblox-logo.png">
        </div>
        <div class="text-center">
            <p><span class="font-bold">#ID:</span> <?= $accountorder['id']; ?></p>
            <p><span class="font-bold">Rate:</span>          <?=$accountorder['rate'];?> </p>
            <p><span class="font-bold">Roblox:</span>    <?=format_cash($accountorder['robux']);?> </p>
            <p><span class="font-bold">Price:</span>
                                    <?=format_cash($accountorder['price']);?>đ
                            </p>
            <button type="button"   data-id="<?=$accountorder['id'];?>" 
        onclick="ordernick(<?= $accountorder['id']; ?>)"  wire:click="buyItemDetail" wire:loading.attr="disabled" class="relative font-medium px-8 btn-main py-2.5  text-15 text-white btn bg-custom-500 border-custom-500
                    hover:text-white focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100
                    active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">
                <svg wire:loading="" wire:target="buyItemDetail" class="w-4 h-4 ltr:mr-2 rtl:ml-2 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Mua ngay
            </button>
        </div>
    </div>
</div>
                <!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>
    </div>
                                    </td>
                                     </tr>
                                    <?php endforeach; ?>
                               
        </tbody>
    </table>

 <div class="mt-2">
            <div class="flex justify-end">   
    <nav role="navigation" aria-label="Pagination Navigation">         
        <div class="dataTables_paginate paging_simple_numbers">             
            <span class="relative z-0 inline-flex flex-wrap rtl:flex-row-reverse rounded-md shadow-sm">                 
                <form method="POST" action="" style="display:inline;">
                         <input type="hidden" name="rate_code" value="<?= $RateorderCode; ?>">
                    <input type="hidden" name="page" value="<?= max(1, $current_page - 1) ?>" />
                    <?php if ($current_page > 1): ?>                     
                        <button type="submit">  
                             <span aria-disabled="true" aria-label="Trước">
                                 <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-l-md leading-5 dark:border-zink-500 dark:active:border-zink-400 bg-white dark:bg-zink-700 text-slate-300 dark:text-slate-300" aria-hidden="true">
                                     <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                         <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                     </svg>
                                 </span>
                             </span>
                        </button>                 
                    <?php else: ?>                     
                        <span>
                            <span aria-disabled="true" aria-label="Trước">
                                <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-l-md leading-5 dark:border-zink-500 dark:active:border-zink-400 bg-white dark:bg-zink-700 text-slate-300 dark:text-slate-300" aria-hidden="true">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </span>
                            </span>
                        </span>                 
                    <?php endif; ?>  
                </form>  

                <?php
                $range = 4;
                $start = max(1, $current_page - $range);
                $end = min($total_pages, $current_page + $range);
                if ($current_page > $range + 2) {
                    echo '<span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 dark:border-zink-500 dark:active:border-zink-400 bg-white dark:bg-zink-700 text-slate-300 dark:text-slate-3000">...</span>';
                }

                for ($i = $start; $i <= $end; $i++): 
                    ?>
                    <form method="POST" action="" style="display:inline;">
                                        <input type="hidden" name="rate_code" value="<?= $RateorderCode; ?>">
                        <input type="hidden" name="page" value="<?= $i ?>" />
                        <button type="submit">      
                            <span class="<?= $i === $current_page ? 'relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 dark:border-zink-500 dark:active:border-zink-400 font-semibold bg-slate-100 dark:bg-zink-600 text-slate-800 hover:text-slate-900 hover:border-slate-200 hover:shadow-sm focus:ring focus:ring-slate-300 focus:ring-opacity-25 dark:text-slate-100 dark:hover:border-zink-500 dark:hover:text-zink-50 dark:focus:ring-zink-500 dark:focus:ring-opacity-40' : 'relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 dark:border-zink-500 dark:active:border-zink-400' ?>">
                                <?= $i ?>
                            </span>
                        </button>                     
                    </form>                 
                <?php endfor; ?>  
                <?php if ($current_page + $range < $total_pages - 1) {
                    echo '<span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 dark:border-zink-500 dark:active:border-zink-400 bg-white dark:bg-zink-700 text-slate-300 dark:text-slate-3000">...</span>';
                }
                ?>

                <!-- mã nguồn được phát triển bởi Văn Công Đức ✓ -->
                <form method="POST" action="" style="display:inline;">
                                    <input type="hidden" name="rate_code" value="<?= $RateorderCode; ?>">
                    <input type="hidden" name="page" value="<?= min($total_pages, $current_page + 1) ?>" />
                    <?php if ($current_page < $total_pages): ?>                     
                         <button type="submit" class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:border-blue-300 focus:ring ring-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150 dark:border-zink-500 dark:active:border-zink-400 bg-white dark:bg-zink-700 text-slate-300 dark:text-slate-3000" aria-label="Sau">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </button>
                    <?php else: ?>                     
                         <button type="submit" class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-r-md leading-5 hover:text-gray-400 focus:z-10 focus:outline-none focus:border-blue-300 focus:ring ring-blue-300 active:bg-gray-100 active:text-gray-500 transition ease-in-out duration-150 dark:border-zink-500 dark:active:border-zink-400 bg-white dark:bg-zink-700 text-slate-300 dark:text-slate-3000" aria-label="Sau">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </button>    
                    <?php endif; ?>  
                </form>             
            </span>         
        </div>     
    </nav> 
</div>  
</div>  
<?php } ?>

            </div>  
              
       
</div>


  <?php require_once __DIR__ . '/buy.php'; ?>


    <a type="button" href="<?=$VCD->site('link_facebook');?>" target="_blank" class="custom-crisp-icon" id="customCrispIcon"></a>
</div>
                </div>
                 <script>
        const checkbox = document.getElementById('switchStyle');
        const form1 = document.getElementById('form1');
        const form2 = document.getElementById('form2');

        if (localStorage.getItem('form') === 'form2') {
            checkbox.checked = true;
            form1.style.display = 'none'; 
            form2.style.display = 'block';
        } else {
            form1.style.display = 'block'; 
            form2.style.display = 'none';  
        }

        checkbox.addEventListener('change', function () {
            if (checkbox.checked) {
                // Hiển thị Form 2 và ẩn Form 1
                form1.style.display = 'none';
                form2.style.display = 'block';
                localStorage.setItem('form', 'form2'); 
            } else {
                // Hiển thị Form 1 và ẩn Form 2
                form1.style.display = 'block';
                form2.style.display = 'none';
                localStorage.setItem('form', 'form1'); 
            }
        });
    </script>


  <?php require_once __DIR__ . '/footer.php'; ?>
<!-- Modal for confirmation -->
<div class="fixed inset-0 bg-slate-900/40 dark:bg-zink-800/70 z-[1049] backdrop-overlay" id="backDropDivApi" style="display: none; "></div>
<div id="confirmBuy" style="display: none;" wire:ignore.self="" modal-center="" class="fixed flex flex-col transition-all duration-300 ease-in-out left-2/4 z-drawer -translate-x-2/4 -translate-y-2/4" >
    <form method="post" wire:submit="buyItem">
   <input type="hidden" id="token" value="<?= empty($getUser['token']) ? '' : $getUser['token'] ?>">
        <input type="hidden" id="itemBuyId" wire:model="idItem" value="">
        <div class="w-screen md:w-[30rem] bg-white shadow rounded-md dark:bg-zink-600 flex flex-col h-full">
            <div class="flex items-center justify-between p-4 border-b border-slate-200 dark:border-zink-500">
                <h3 class="text-16">Xác nhận mua tài khoản #<span id="accNumber"></span></h3>
                <button type="button" data-modal-close="confirmBuy" class="transition-all duration-200 ease-linear text-slate-500 hover:text-red-500 dark:text-zink-200 dark:hover:text-red-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="x" class="lucide lucide-x size-5">
                        <path d="M18 6 6 18"></path>
                        <path d="m6 6 12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="max-h-[calc(theme('height.screen')_-_180px)] p-4 overflow-y-auto">
                <p>Sau khi mua, bạn có thể xem thông tin đăng nhập của mình trong phần "Tài khoản đã mua". Bạn có chắc chắn đã mua không?</p>
            </div>
            <div class="text-right p-4 mt-auto border-t border-slate-200 dark:border-zink-500">
                <button data-modal-close="confirmBuy" type="button" class="text-white btn bg-slate-500 border-slate-500 hover:text-white hover:bg-slate-600 hover:border-slate-600 focus:text-white focus:bg-slate-600 focus:border-slate-600 focus:ring focus:ring-slate-100 active:text-white active:bg-slate-600 active:border-slate-600 active:ring active:ring-slate-100 dark:ring-slate-400/10">
                    Hủy
                </button>
                <button type="submit" name="btnPayNick" wire:loading.class="opacity-50" class="text-white bg-red-500 border-red-500 btn hover:text-white hover:bg-red-600 hover:border-red-600 focus:text-white focus:bg-red-600 focus:border-red-600 focus:ring focus:ring-red-100 active:text-white active:bg-red-600 active:border-red-600 active:ring active:ring-red-100 dark:ring-custom-400/20">
                    <svg wire:loading="" wire:target="buyItem" class="w-4 h-4 ltr:mr-2 rtl:ml-2 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Có, tôi muốn mua
                </button>
            </div>
        </div>
    </form>
</div>

<div id="orderBuy" style="display: none;" wire:ignore.self="" modal-center="" class="fixed flex flex-col transition-all duration-300 ease-in-out left-2/4 z-drawer -translate-x-2/4 -translate-y-2/4" >
    <form method="post" wire:submit="buyItem">
   <input type="hidden" id="token" value="<?= empty($getUser['token']) ? '' : $getUser['token'] ?>">
        <input type="hidden" id="itemBuyIdorder" wire:model="idItem" value="">
        <div class="w-screen md:w-[30rem] bg-white shadow rounded-md dark:bg-zink-600 flex flex-col h-full">
            <div class="flex items-center justify-between p-4 border-b border-slate-200 dark:border-zink-500">
                <h3 class="text-16">Xác nhận mua tài khoản #<span id="accNumberorder"></span></h3>
                <button type="button" data-modal-close="orderBuy" class="transition-all duration-200 ease-linear text-slate-500 hover:text-red-500 dark:text-zink-200 dark:hover:text-red-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="x" class="lucide lucide-x size-5">
                        <path d="M18 6 6 18"></path>
                        <path d="m6 6 12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="max-h-[calc(theme('height.screen')_-_180px)] p-4 overflow-y-auto">
                <p>Sau khi mua, bạn có thể xem thông tin đăng nhập của mình trong phần "Tài khoản đã mua". Bạn có chắc chắn đã mua không?</p>
            </div>
            <div class="text-right p-4 mt-auto border-t border-slate-200 dark:border-zink-500">
                <button data-modal-close="orderBuy" type="button" class="text-white btn bg-slate-500 border-slate-500 hover:text-white hover:bg-slate-600 hover:border-slate-600 focus:text-white focus:bg-slate-600 focus:border-slate-600 focus:ring focus:ring-slate-100 active:text-white active:bg-slate-600 active:border-slate-600 active:ring active:ring-slate-100 dark:ring-slate-400/10">
                    Hủy
                </button>
                <button type="submit" name="btnPayNickorder" wire:loading.class="opacity-50" class="text-white bg-red-500 border-red-500 btn hover:text-white hover:bg-red-600 hover:border-red-600 focus:text-white focus:bg-red-600 focus:border-red-600 focus:ring focus:ring-red-100 active:text-white active:bg-red-600 active:border-red-600 active:ring active:ring-red-100 dark:ring-custom-400/20">
                    <svg wire:loading="" wire:target="buyItem" class="w-4 h-4 ltr:mr-2 rtl:ml-2 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Có, tôi muốn mua
                </button>
            </div>
        </div>
    </form>
</div>
<style>

@keyframes DownDz {
    0% {
        transform: translate(-50%, -50%) perspective(400px) rotateX(-2deg) translateY(-10px);
        opacity: 0;
    }
    100% {
        transform: translate(-50%, -50%) perspective(400px) rotateX(0deg) translateY(0);
        opacity: 1;
    }
}

@keyframes UpDz {
    0% {
        transform: translate(-50%, -50%) perspective(400px) rotateX(0deg) translateY(0);
        opacity: 1;
    }
    100% {
        transform: translate(-50%, -50%) perspective(400px) rotateX(2deg) translateY(10px);
        opacity: 0;
    }
}

.ducapi-open {
    display: flex !important;
    animation: DownDz 0.3s ease-in-out forwards;
    opacity: 1;
}

.ducapi-close {
    animation: UpDz 0.3s ease-in-out forwards;
    opacity: 0;
}

</style>
<script>
function muanick(id) {
    const modalNick = document.getElementById("confirmBuy");
    const backDropDivv = document.getElementById("backDropDivApi");

    if (modalNick) {
        modalNick.style.display = "block";
        modalNick.classList.remove("ducapi-close");
        modalNick.classList.add("ducapi-open");
    }

    if (backDropDivv) {
        backDropDivv.style.display = "block";
    }

    const accNumberSpan = document.getElementById("accNumber");
    const itemBuyIdInput = document.getElementById("itemBuyId");

    if (accNumberSpan) {
        accNumberSpan.textContent = id;
    }
    if (itemBuyIdInput) {
        itemBuyIdInput.value = id;
    }

    const confirmButton = document.querySelector("[name='btnPayNick']");
    confirmButton.onclick = function () {
        PayNickRb(id);
    };
}

function closeModal() {
    const modalNick = document.getElementById("confirmBuy");
    const backDropDivv = document.getElementById("backDropDivApi");

    if (modalNick) {
        modalNick.classList.remove("ducapi-open");
        modalNick.classList.add("ducapi-close");

        // Đợi hiệu ứng đóng rồi mới ẩn modal
        setTimeout(() => {
            modalNick.style.display = "none";
        }, 200);
    }

    if (backDropDivv) {
        backDropDivv.style.display = "none";
    }
}

document.addEventListener("DOMContentLoaded", function () {
    const modalNick = document.getElementById("confirmBuy");
    const backDropDivv = document.getElementById("backDropDivApi");

    if (!modalNick || !backDropDivv) return;

    // Khi nhấn backdrop thì đóng modal
    backDropDivv.addEventListener("click", closeModal);
});

// Khi click vào nút đóng modal
document.querySelectorAll('[data-modal-close="confirmBuy"]').forEach(function (btn) {
    btn.addEventListener("click", closeModal);
});

function PayNickRb(id) {
    const token = document.getElementById("token").value;
    const btnPayNick = document.querySelector("[name='btnPayNick']");

    btnPayNick.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Đang xử lý...';
    btnPayNick.disabled = true;

    // AJAX request
    $.ajax({
        url: "/ajaxs/client/muanick.php",
        method: "POST",
        dataType: "JSON",
        data: {
            id: id,
            token: token,  
        },
        success: function (data) {
            if (data.status === "success") {
                showMessageDucapi(data.msg, "success");
                  setTimeout("location.href = '<?= BASE_URL('auth/history-order'); ?>';", 1000);
            } else {
                showMessageDucapi(data.msg, "error");
            }
        },
        error: function () {
            showMessageDucapi("Đã xảy ra lỗi, vui lòng thử lại sau!", "error");
        },
        complete: function () {
            btnPayNick.innerHTML = "Có, tôi muốn mua";
            btnPayNick.disabled = false;
        },
    });
}
</script>


<script>
function ordernick(id) {
    const modalorderBuy = document.getElementById("orderBuy");
    const backDropDivv = document.getElementById("backDropDivApi");

    if (modalorderBuy) {
        modalorderBuy.style.display = "block";
        modalorderBuy.classList.remove("ducapi-close");
        modalorderBuy.classList.add("ducapi-open");
    }

    if (backDropDivv) {
        backDropDivv.style.display = "block";
    }

    const accNumberorder = document.getElementById("accNumberorder");
    const orderBuyIdInput = document.getElementById("itemBuyIdorder");

    if (accNumberorder) {
        accNumberorder.textContent = id;
    }
    if (orderBuyIdInput) {
        orderBuyIdInput.value = id;
    }

    const confirmButtonorder = document.querySelector("[name='btnPayNickorder']");
    confirmButtonorder.onclick = function () {
        PayNickorder(id);
    };
}

function closeModal() {
    const modalNickorder = document.getElementById("orderBuy");
    const backDropDivv = document.getElementById("backDropDivApi");

    if (modalNickorder) {
        modalNickorder.classList.remove("ducapi-open");
        modalNickorder.classList.add("ducapi-close");

        // Đợi hiệu ứng đóng rồi mới ẩn modal
        setTimeout(() => {
            modalNickorder.style.display = "none";
        }, 200);
    }

    if (backDropDivv) {
        backDropDivv.style.display = "none";
    }
}

document.addEventListener("DOMContentLoaded", function () {
    const modalNickorder = document.getElementById("orderBuy");
    const backDropDivv = document.getElementById("backDropDivApi");

    if (!modalNickorder || !backDropDivv) return;

    // Khi nhấn backdrop thì đóng modal
    backDropDivv.addEventListener("click", closeModal);
});

// Khi click vào nút đóng modal
document.querySelectorAll('[data-modal-close="orderBuy"]').forEach(function (btn) {
    btn.addEventListener("click", closeModal);
});

function PayNickorder(id) {
    const token = document.getElementById("token").value;
    const btnPayNickorder = document.querySelector("[name='btnPayNickorder']");

    btnPayNickorder.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Đang xử lý...';
    btnPayNickorder.disabled = true;

    // AJAX request
    $.ajax({
        url: "/ajaxs/client/ordernick.php",
        method: "POST",
        dataType: "JSON",
        data: {
            id: id,
            token: token,  
        },
        success: function (data) {
            if (data.status === "success") {
                showMessageDucapi(data.msg, "success");
                  setTimeout("location.href = '<?= BASE_URL('auth/history-order'); ?>';", 1000);
            } else {
                showMessageDucapi(data.msg, "error");
            }
        },
        error: function () {
            showMessageDucapi("Đã xảy ra lỗi, vui lòng thử lại sau!", "error");
        },
        complete: function () {
            btnPayNickorder.innerHTML = "Có, tôi muốn mua";
            btnPayNickorder.disabled = false;
        },
    });
}
</script>

   