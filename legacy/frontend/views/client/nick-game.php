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

/* SỬA LỖI: biến $RateCode được dùng ở 3 chỗ bên dưới nhưng KHÔNG hề được
   khai báo trong file này (bản gốc chỉ khai báo trong home.php)
   => PHP Warning "Undefined variable $RateCode". Nay khai báo mặc định. */
$RateCode = isset($_POST['rate_code']) ? xss($_POST['rate_code']) : (isset($_GET['rate_code']) ? xss($_GET['rate_code']) : '');
$RateId   = isset($RateId) ? $RateId : (isset($_POST['rate_id']) ? xss($_POST['rate_id']) : '');
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
            <h5 class="text-16 mr-2">Tài Khoản</h5>
           
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
            
                                  </div> 
        
        
        
        <!-- mã nguồn được phát triển bởi Văn Công Đức ✓ -->
        <div class="col-span-12 card 2xl:col-span-12">
        <div class="card-body">
            <div class="grid items-center grid-cols-1 gap-3 mb-5 2xl:grid-cols-12">
                <div class="2xl:col-span-3 ">
                    <h6 class="text-15">Mua nick game ngay</h6>

                </div><!--end col-->

            </div><!--end grid-->

            <form wire:submit="search" class="mt-2" data-gtm-form-interact-id="0">
                <div class="grid grid-cols-1 gap-x-5 md:grid-cols-2 xl:grid-cols-4">
         
                    <div class="mb-6">
                        <label for="firstNameInput2" class="inline-block mb-2 text-base font-medium">Sắp xếp theo</label>
                        <select wire:model="sortBy" class="form-select border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200" id="stateInput">
                            <option selected="" value="">Không</option>
                            <option value="price-low">Giá từ thấp đến cao</option>
                            <option value="price-high">Giá từ cao đến thấp</option>
                           
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
$total_items = $VCD->get_row("SELECT COUNT(*) as total FROM `chuyenmuc` WHERE `status` = '1' ")['total']; 
$total_pages = ceil($total_items / $items_per_page);  
//mã nguồn được phát triển bởi Văn Công Đức ✓
$chuyenmuc = $VCD->get_list("SELECT * FROM `chuyenmuc` WHERE `status` = '1' LIMIT $items_per_page OFFSET $offset"); 
?>

 <?php foreach ($chuyenmuc as $checkgame): ?>  
                                    <div class="card border border-custom-200 dark:border-custom-500/20">
                        <div class="card-body ">
                            <div class="text-right">
                                    <span class="px-2.5 py-0.5 text-xs font-medium inline-block rounded border bg-red-500 border-red-500 text-red-50">
                                    #<?=$checkgame['code'];?> </span>
                            </div>
                            <div class="flex justify-center items-center">
                                <img src="<?=$checkgame['logo'];?> " width="25" class="group-data-[sidebar=dark]:hidden">
                                <img src="<?=$checkgame['logo'];?> " width="25" class="hidden group-data-[sidebar=dark]:block">
                                <h4> <?=$checkgame['title'];?> </h4>
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-x-2 p-2 mt-2  border border-custom-100 dark:border-custom-500/20">
                                <div>
                                   <span class="text-green-500 dark:text-yellow-200 font-bold">Còn:</span> 
<?= format_cash($VCD->num_rows("SELECT * FROM `product_nick` WHERE (`magd` IS NULL OR `magd` = '') AND (`username` IS NULL OR `username` = '') AND `chuyenmuc` = '".$checkgame['id']."'")) ?>

                                </div>
                                <div>
                                    <span class="text-green-500 dark:color-yellow-2x font-bold">Đã mua:</span> <?=$checkgame['buy'];?>
                                </div>
                            </div>
                          
                            <h5 class="mt-2 font-bold px-2.5 py-0.5 text-lg text-center rounded border
                                bg-custom-100 border-transparent text-custom-500 dark:color-yellow-2x dark:bg-custom-500/20 dark:border-transparent">
                                 <?=format_cash($checkgame['price']);?> đ
                            </h5>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-4 mt-2 ">
                                <div>
                                    <button type="button" x-bind="buyItem"   data-price="<?=$checkgame['price'];?>"  data-id="<?=$checkgame['id'];?>" 
        onclick="muanick(<?= $checkgame['id']; ?>)" data-type="instant" class="w-full text-white py-1 px-0 bg-red-500 border-red-500 btn hover:text-white hover:bg-red-600 hover:border-red-600 focus:text-white focus:bg-red-600 focus:border-red-600 focus:ring focus:ring-red-100 active:text-white active:bg-red-600 active:border-red-600 active:ring active:ring-red-100 dark:ring-red-400/10">

                                        Mua
                                    </button>
                                </div>
                                <div>
                                    <button type="button" onclick="detail(<?= $checkgame['id']; ?>)" wire:loading.attr="disabled" class="w-full text-white py-1 px-0 bg-green-500 border-green-500 btn hover:text-white hover:bg-green-600 hover:border-green-600 focus:text-white focus:bg-green-600 focus:border-green-600 focus:ring focus:ring-green-100 active:text-white active:bg-green-600 active:border-green-600 active:ring active:ring-green-100 dark:ring-green-400/10">
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
    
    <div id="detailItemModal" wire:ignore.self modal-center=""
         class="fixed flex flex-col transition-all duration-300 ease-in-out left-2/4 z-drawer -translate-x-2/4 -translate-y-2/4 show hidden">
        <div class="w-screen lg:w-[55rem] bg-white shadow rounded-md dark:bg-zink-600 flex flex-col h-full">
            <div class="max-h-[calc(theme('height.screen')_-_180px)] p-4 overflow-y-auto">
                           <p>Này kiểu dạng mua nhiều nick cùng lúc để vận may hay gì đó</p> </div>
        </div>
    </div>


  <?php require_once __DIR__ . '/buy.php'; ?>


  
</div>
                </div>


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
                <label>Số lượng cần mua: </label>
                            <div class="input-group ">
                                <input type="number" id="soluong" name="soluong"
                                 class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"  placeholder="Nhập số lượng cần mua" required>
                             
                            </div>
                            <hr>
                           Tổng tiền cần trả&nbsp;<span class="font-weight-bold"><b
                                    id="totalprice"> 0</b>đ</span>
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

    // Lấy giá trị price từ thuộc tính data-price của button
    const buyButton = document.querySelector(`button[data-id="${id}"]`);  // Lấy nút Mua theo id
    const price = parseFloat(buyButton.getAttribute("data-price"));  // Lấy giá trị data-price và chuyển thành số
    const totalPriceElement = document.getElementById("totalprice");

    // Hàm để định dạng số có dấu phân cách hàng nghìn
    function formatNumber(number) {
        return number.toLocaleString();  
    }

    // Khi người dùng nhập số lượng, tính tổng tiền
    const soluongInput = document.getElementById("soluong");
    soluongInput.addEventListener('input', function () {
        const soluong = soluongInput.value;
        const totalPrice = soluong * price;  // Tính tổng tiền
        if (totalPriceElement) {
            totalPriceElement.textContent = formatNumber(totalPrice);  // Cập nhật giá trị tổng tiền
        }
    });

    // Gán giá trị ban đầu cho tổng tiền khi chưa nhập số lượng
    const soluong = soluongInput.value || 0;
    const initialTotalPrice = soluong * price;
    if (totalPriceElement) {
        totalPriceElement.textContent = formatNumber(initialTotalPrice);  // Cập nhật tổng tiền ban đầu
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
        url: "/ajaxs/client/muanick-game.php",
        method: "POST",
        dataType: "JSON",
        data: {
            id: id,
            soluong: $("#soluong").val(),
            token: token,  
        },
        success: function (data) {
            if (data.status === "success") {
                showMessageDucapi(data.msg, "success");
                  setTimeout("location.href = '<?= BASE_URL('auth/history-nick'); ?>';", 1000);
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


<script>function detail(id) {
    const modalItem = document.getElementById("detailItemModal");
    const backDropDivv = document.getElementById("backDropDivApi");

    if (modalItem) {
        modalItem.style.display = "block";
        modalItem.classList.remove("ducapi-close");
        modalItem.classList.add("ducapi-open");
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

}
function closeModal() {
    const modalItem = document.getElementById("detailItemModal");
    const backDropDivv = document.getElementById("backDropDivApi");

    if (modalItem) {
        modalItem.classList.remove("ducapi-open");
        modalItem.classList.add("ducapi-close");

        // Đợi hiệu ứng đóng rồi mới ẩn modal
        setTimeout(() => {
            modalItem.style.display = "none";
        }, 200);
    }

    if (backDropDivv) {
        backDropDivv.style.display = "none";
    }
}

</script>
   