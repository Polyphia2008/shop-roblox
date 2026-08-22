<?php
$title = 'TRANG CHỦ | ' . $VCD->site('title');
$body['header'] = '
';
$body['footer'] = '

';
require_once __DIR__ . '/../../../core/is_user.php';
require_once __DIR__ . '/header.php';
require_once __DIR__ . '/nav.php';
CheckLogin();
?>
<style>/* Ẩn tất cả các tab content mặc định */
.tab-content .tab-pane {
    display: none;
}

/* Hiển thị tab đang active */
.tab-content .tab-pane.active {
    display: block;
}

/* Đánh dấu tab được chọn */
.tab-list .tab-item.active {
    font-weight: bold;
    color: #007bff;
}
</style>
<div class="relative min-h-screen group-data-[sidebar-size=sm]:min-h-sm">

        <div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-2 px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
            <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">

                                <div style="min-height: calc(100vh - 350px)">
                    <div wire:snapshot="{&quot;data&quot;:{&quot;amount&quot;:null,&quot;method&quot;:null,&quot;password&quot;:null,&quot;cryptoMethod&quot;:[[[{&quot;type&quot;:&quot;crypto&quot;,&quot;data&quot;:[{&quot;network&quot;:&quot;TRON ( TRC20 )&quot;,&quot;uid&quot;:&quot;TBhZQB2AVbTagJTE3homEPTXUWiAQXsRfk&quot;,&quot;name&quot;:null,&quot;description&quot;:null,&quot;qr&quot;:&quot;qr\/01JCWVZECJYEEQ0SRRWXM9TVDQ.jpg&quot;,&quot;cr_uuid&quot;:&quot;5465bf9d-1278-4bca-af6c-38ada6683aa2&quot;,&quot;address&quot;:&quot;TLmu8AL46Hgrd5NtuFnhswhe3eRaGpS5MB&quot;},{&quot;s&quot;:&quot;arr&quot;}]},{&quot;s&quot;:&quot;arr&quot;}],[{&quot;type&quot;:&quot;crypto&quot;,&quot;data&quot;:[{&quot;network&quot;:&quot;BNS Smart chain (BEP20)&quot;,&quot;uid&quot;:&quot;0x15b2902160F5C6aA83B8066508cec7da831c32Bb&quot;,&quot;name&quot;:null,&quot;description&quot;:null,&quot;qr&quot;:&quot;qr\/01JCWVZECNYRC9NG90FMV26027.jpg&quot;,&quot;cr_uuid&quot;:&quot;41a2d2f5-fcf3-43eb-ab04-e07032a6edec&quot;,&quot;address&quot;:&quot;0x760fB09dF37503137894f9B88186aCC09E5E59FB&quot;},{&quot;s&quot;:&quot;arr&quot;}]},{&quot;s&quot;:&quot;arr&quot;}]],{&quot;s&quot;:&quot;arr&quot;}],&quot;vndDefault&quot;:100000},&quot;memo&quot;:{&quot;id&quot;:&quot;E9yclX6tc066iw5iFt14&quot;,&quot;name&quot;:&quot;deposit.b-i-d-v-bank&quot;,&quot;path&quot;:&quot;auth\/deposit\/bidv&quot;,&quot;method&quot;:&quot;GET&quot;,&quot;children&quot;:{&quot;lw-2007031391-0&quot;:[&quot;div&quot;,&quot;SCulwEhH0jzEukavsNK7&quot;]},&quot;scripts&quot;:[],&quot;assets&quot;:[],&quot;errors&quot;:[],&quot;locale&quot;:&quot;vi&quot;},&quot;checksum&quot;:&quot;34fdf70102d21c2cf612be311f4c19e8706734cb6f8ae0baf4c368a8c6a05d36&quot;}" wire:effects="[]" wire:id="E9yclX6tc066iw5iFt14" class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
    <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
        <div class="grow">
            <h5 class="text-16">Nạp tiền</h5>
        </div>
    </div>
    <div class="grid grid-cols-12 gap-x-4">
        <div class="col-span-12 card 2xl:col-span-4">
            <div class="card-body">
                <!--[if BLOCK]><![endif]-->                    <div>

                    <ul class="flex flex-wrap w-full text-sm font-medium text-center nav-tabs">
                                              
                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                            <!--[if BLOCK]><![endif]-->   <?php 
    $i = 0;
    foreach ($VCD->get_list("SELECT * FROM `bank`") as $bank_auto): ?>
        <li class="group ml-2 tab-item active" data-tab="tab-<?php echo $i; ?>">
            <a href="javascript:void(0)" class="inline-block px-4 py-2 text-base
                               transition-all duration-300 ease-linear rounded-md
                               text-slate-500 dark:text-zink-200 border border-transparent
                               group-[.active]:bg-custom-500 group-[.active]:text-white
                               hover:text-custom-500 active:text-custom-500
                               dark:hover:text-custom-500 dark:active:text-custom-500
                               dark:group-[.active]:hover:text-white -mb-[1px]">
                <?=$bank_auto['short_name']?> Bank
            </a>
        </li>
    <?php $i++; endforeach; ?>


                            <!--[if ENDBLOCK]><![endif]-->
                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->
                        
                           <li class="group  ml-2">
                                    <button type="button" data-modal-target="how_to_deposit" class="mb-2 px-2.5 py-2 text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">
                                        <i class="align-baseline ltr:pr-1 rtl:pl-1 ri-question-line"></i> Hướng dẫn nạp tiền
                                    </button>
                                </li>
                                                    </ul>
  <?php /* FIX: da GO the nap Alpine v2.8.2 o day.
           Ly do: footer.php dung Alpine.store()/Alpine.bind() la API cua
           Alpine v3, ma v2 khong co => nap ca 2 phien ban se xung dot va
           bao "Alpine is not defined". Alpine v3 nay duoc nap tap trung
           1 lan duy nhat o cuoi footer.php cho toan bo site. */ ?>
    <style>
        .spin {
            animation: spin 1s infinite linear;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .qr-container {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 300px;
        }
        .qr-image {
            display: block;
        }
    </style>
         <!-- Nội dung các tab -->

               <div class="mt-5 tab-content">
                            <!--[if BLOCK]><![endif]--> 
                             <?php 
    $i = 0;
    foreach ($VCD->get_list("SELECT * FROM `bank`") as $bank_auto): ?>
<div class="tab-pane <?php echo $i == 0 ? 'active' : ''; ?> block" id="tab-<?php echo $i; ?>" x-data="{
    amount: 100000,
    isLoading: false,
    randomCode: Math.floor(Math.random() * 1000000000).toString(),
    initRandomCode() {
        this.isLoading = true;

        const response = fetch('/ajaxs/client/updatebank.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({
                userId: '<?php echo $getUser['id']; ?>',
                randomCode: this.randomCode,
            }),
        }).then(response => response.json())
          .then(data => {
              if (data && data.randomCode) {
                  this.randomCode = data.randomCode;
              }
          }).finally(() => this.isLoading = false);
    },
    qrSrc() {
        return `https://img.vietqr.io/image/<?php echo $bank_auto['short_name']; ?>-<?php echo $bank_auto['accountNumber']; ?>-compact2.jpg?amount=${this.amount}&addInfo=<?php echo $VCD->site('noidungnap'); ?> ${this.randomCode}`;
    },
    generateQR() {
        this.isLoading = true;

        setTimeout(() => {
            this.randomCode = Math.floor(Math.random() * 1000000000).toString();

            const response = fetch('/ajaxs/client/updatebank.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    userId: '<?php echo $getUser['id']; ?>',
                    randomCode: this.randomCode,
                }),
            }).then(response => response.json())
              .then(data => {
                  if (data && data.randomCode) {
                      this.randomCode = data.randomCode;
                  }
              }).finally(() => this.isLoading = false);
        }, 300); 
    }
}" x-init="initRandomCode()">

    <div class="grid grid-cols-1 gap-x-5 xl:grid-cols-2">
     
        <div class="flex flex-wrap items-stretch w-full mb-4 relative">
            <div class="flex -mr-px">
                <span class="flex items-center leading-normal bg-grey-lighter rounded rounded-r-none border border-r-0 border-grey-light px-3 whitespace-no-wrap text-grey-dark text-sm">Ngân hàng</span>
            </div>
            <input type="text" value="<?=$bank_auto['short_name']?> Bank" readonly="" class="flex-shrink flex-grow flex-auto ltr:rounded-l-none rtl:rounded-r-none form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200 relative">
        </div>
        <div class="flex flex-wrap items-stretch w-full mb-4 relative">
            <div class="flex -mr-px">
                <span class="flex items-center leading-normal bg-grey-lighter rounded rounded-r-none border border-r-0 border-grey-light px-3 whitespace-no-wrap text-grey-dark text-sm">STK</span>
            </div>
            <input type="text" value="<?=$bank_auto['accountNumber']?>" readonly="" class="flex-shrink flex-grow flex-auto ltr:rounded-l-none rtl:rounded-r-none form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200 relative">
        </div>
    </div>

    <div class="grid grid-cols-1 gap-x-5 xl:grid-cols-2">
        <div class="flex flex-wrap items-stretch w-full mb-4 relative">
            <div class="flex -mr-px">
                <span class="flex items-center leading-normal bg-grey-lighter rounded rounded-r-none border border-r-0 border-grey-light px-3 whitespace-no-wrap text-grey-dark text-sm">Chủ Tài Khoản</span>
            </div>
            <input type="text" value="<?=$bank_auto['accountName']?>" readonly="" class="flex-shrink flex-grow flex-auto ltr:rounded-l-none rtl:rounded-r-none form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200 relative">
        </div>
        <div class="flex flex-wrap items-stretch w-full mb-4 relative">
            <div class="flex -mr-px">
                <span class="flex items-center leading-normal bg-grey-lighter rounded rounded-r-none border border-r-0 border-grey-light px-3 whitespace-no-wrap text-grey-dark text-sm">Nội Dung CK</span>
            </div>
            <input type="text" id="addInfo" :value="'<?=$VCD->site('noidungnap');?> ' + randomCode" readonly="" class="flex-shrink flex-grow flex-auto ltr:rounded-l-none rtl:rounded-r-none form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200 relative">
        </div>
    </div>

    <div class="flex flex-wrap items-stretch w-full mb-4 relative">
        <div class="flex -mr-px">
            <span class="flex items-center leading-normal bg-grey-lighter rounded rounded-r-none border border-r-0 border-grey-light px-3 whitespace-no-wrap text-grey-dark text-sm">Số tiền muốn nạp</span>
        </div>
        <input type="text" x-model="amount" @input="generateQR" class="flex-shrink flex-grow flex-auto ltr:rounded-l-none rtl:rounded-r-none form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200 relative">
    </div>

    <div class="rounded-md border flex justify-center">
        
        <div x-show="isLoading" class="spin">
            <svg class="w-4 h-4 ltr:mr-2 rtl:ml-2 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
        <img x-show="!isLoading" :src="qrSrc()" width="300" height="300" alt="QR Code" class="qr-image">
    </div>

    <div class="mt-1">
        <p class="font-bold" style="color: red">Lưu ý mỗi mã QR chỉ chuyển 1 lần, </p>
        <div class="text-right">
            <button type="button" @click="generateQR" class="text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-500/20 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-500/20 dark:ring-custom-400/20">
                <template x-if="isLoading">
                    <svg class="w-4 h-4 ltr:mr-2 rtl:ml-2 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </template>
                Tạo mã QR mới
            </button>
        </div>
    </div>

</div>    <?php $i++; endforeach; ?>

                            <!--[if ENDBLOCK]><![endif]-->
                            <!--[if BLOCK]><![endif]--><!--[if ENDBLOCK]><![endif]-->

                        </div>
                    </div>
                <!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>
        <div class="col-span-12 card 2xl:col-span-8">
            <div class="card-body">
                <h6 class="mb-4 text-15">Lịch sử nạp</h6>
                <div class="overflow-x-auto">
                    <div wire:id="SCulwEhH0jzEukavsNK7" wire:poll.5s="">
    <table class="w-full border">
        <thead class="ltr:text-left rtl:text-right">
        <tr>
            <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">
                ID
            </th>
            <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">
                Loại
            </th>
            <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">
                Nguồn
            </th>
            <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">
                Mệnh giá
            </th>
            <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">
                Ngày
            </th>
        </tr>
        </thead>
        <tbody>
               <?php $i=0; foreach ($VCD->get_list("SELECT * FROM `bank_auto` WHERE `user_id` = '".$getUser['id']."'  ") as $bank)
                               {?>
                         

                            <tr>
                                  <td class="px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500">
                                       #<?=$bank['tid'];?> 
                                     </td>
    <td class="px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500">
                                       <?=$bank['bank'];?> 
                                     </td>
                                             <!-- First Table Cell (tknick) -->
                           <td class="px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500">
                        <?=$bank['description'];?>
                    
                         </td>
                            
                                  
                                       <td class="px-3.5 py-2.5 first:pl-5  last:pr-5 border-y border-slate-200 dark:border-zink-500">

                                    <?=format_cash($bank['amount']);?> đ
                                    </td>
                                     <td class="px-3.5 py-2.5 first:pl-5  last:pr-5 border-y border-slate-200 dark:border-zink-500">

                                    <?=$bank['create_gettime'];?> 
                                    </td>
                                
                                   </tr>   
                                    <?php }?>
                </tbody>
    </table>
    <div class="mt-2">
        <div class="flex justify-end">
    </div>

    </div>


</div>
                </div>
            </div>
        </div>

    </div>
    <div id="how_to_deposit" modal-center="" class="fixed flex flex-col hidden transition-all duration-300 ease-in-out left-2/4 z-drawer -translate-x-2/4 -translate-y-2/4 show">
        <div class="w-screen lg:w-[55rem] bg-white shadow rounded-md dark:bg-zink-600 flex flex-col h-full">
            <div class="flex items-center justify-between p-4 border-b border-slate-200 dark:border-zink-500">
                <h5 class="text-16">Hướng dẫn nạp tiền</h5>
                <button data-modal-close="how_to_deposit" class="transition-all duration-200 ease-linear text-slate-500 hover:text-red-500 dark:text-zink-200 dark:hover:text-red-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="x" class="lucide lucide-x size-5"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
                </button>
            </div>
            <div class="max-h-[calc(theme('height.screen')_-_180px)] p-4 overflow-y-auto">
                <p><strong>Khách hàng lưu ý khi nạp tiền</strong><br>- Nạp tiền vui lòng f5 web quyét qr mới nhất<br>- Mỗi 1 QR chỉ sử dụng 1 lần<br>- Nếu gặp lỗi 10 phút sau không cộng tiền hãy liên hệ admin để được hỗ trợ.<br><strong>- Nạp số dư đủ dùng trong 6h đến 12h, tuyệt đối không được tích chữ tiền trên shop để tránh mất cắp, hoặc nếu web sập vĩnh viễn bạn có nguy cơ bị mất tiền không thể lấy lại.</strong></p>
            </div>

        </div>
    </div>
</div>
                </div>

<script>document.addEventListener('DOMContentLoaded', function () {
    const tabLinks = document.querySelectorAll('.tab-item'); // Tất cả các tab
    const tabPanes = document.querySelectorAll('.tab-pane'); // Tất cả các nội dung của tab

    tabLinks.forEach(tab => {
        tab.addEventListener('click', function () {
            // Xóa lớp active khỏi tất cả các tab và tab content
            tabLinks.forEach(link => link.classList.remove('active'));
            tabPanes.forEach(pane => pane.classList.remove('active'));

            // Thêm lớp active vào tab được chọn và nội dung của nó
            tab.classList.add('active');
            const targetTab = tab.getAttribute('data-tab');
            document.getElementById(targetTab).classList.add('active');
        });
    });
});

</script>

<?php require_once __DIR__ . '/footer.php'; ?>