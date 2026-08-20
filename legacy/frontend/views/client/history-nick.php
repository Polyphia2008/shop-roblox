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
// mã nguồn được phát triển bởi Văn Công Đức ✓
?>

    <div class="relative min-h-screen group-data-[sidebar-size=sm]:min-h-sm">

        <div class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-2 px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
            <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">

                                <div style="min-height: calc(100vh - 350px)">
                    <div wire:snapshot="{&quot;data&quot;:{&quot;idReport&quot;:null,&quot;reason&quot;:null,&quot;content&quot;:null,&quot;label&quot;:null,&quot;canComment&quot;:null,&quot;order&quot;:null,&quot;paginators&quot;:[{&quot;page&quot;:1},{&quot;s&quot;:&quot;arr&quot;}]},&quot;memo&quot;:{&quot;id&quot;:&quot;K05QpNdJCydOZNvxkbo8&quot;,&quot;name&quot;:&quot;history-order.history&quot;,&quot;path&quot;:&quot;auth\/history-order&quot;,&quot;method&quot;:&quot;GET&quot;,&quot;children&quot;:[],&quot;scripts&quot;:[],&quot;assets&quot;:[],&quot;errors&quot;:[],&quot;locale&quot;:&quot;vi&quot;},&quot;checksum&quot;:&quot;87c88f93b13b9dd59e3758adaa827767166f4dde25410e3b230c5a93c4e61582&quot;}" wire:effects="{&quot;url&quot;:{&quot;paginators.page&quot;:{&quot;as&quot;:&quot;page&quot;,&quot;use&quot;:&quot;push&quot;,&quot;alwaysShow&quot;:false,&quot;except&quot;:null}}}" wire:id="K05QpNdJCydOZNvxkbo8" class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
    <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
        <div class="grow">
            <h5 class="text-16">Lịch sử mua hàng</h5>
        </div>
    </div>
     <!--mã nguồn được phát triển bởi Văn Công Đức ✓-->
    <div class="grid grid-cols-12 gap-x-4">
        <div class="col-span-12 card 2xl:col-span-12">
            <div class="card-body">
                <div class="grid items-center grid-cols-1 gap-3 mb-5 2xl:grid-cols-12">
                    <div class="2xl:col-span-3">
                        <h6 class="text-15">Danh sách đơn hàng</h6>

                    </div><!--end col-->
                </div><!--end grid-->
                <div class="overflow-x-auto">
                
                                        <table class="w-full whitespace-nowrap" id="table-pre">
                        <thead class="ltr:text-left rtl:text-right bg-slate-100 text-slate-500 dark:text-zink-200 dark:bg-zink-600">
                        <tr>
                            <th class="px-3.5 py-2.5 first:pl-5 last:pr-5 font-semibold border-y border-slate-200 dark:border-zink-500">
                                #Order ID
                            </th>
                            <th class="px-3.5 py-2.5 first:pl-5 last:pr-5 font-semibold border-y border-slate-200 dark:border-zink-500">
                                	Tài khoản
                            </th>
                                  <th class="px-3.5 py-2.5 first:pl-5 last:pr-5 font-semibold border-y border-slate-200 dark:border-zink-500">
                                Số lượng
                            </th>
                            <th class="px-3.5 py-2.5 first:pl-5 last:pr-5 font-semibold border-y border-slate-200 dark:border-zink-500">
                               	Số tiền
                            </th>
                            <th class="px-3.5 py-2.5 first:pl-5 last:pr-5 font-semibold border-y border-slate-200 dark:border-zink-500">
                               	Ngày mua
                            </th>

                            <th class="px-3.5 py-2.5 first:pl-5 last:pr-5 font-semibold border-y border-slate-200 dark:border-zink-500">
                                Hành động
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                               <?php $i=0; foreach ($VCD->get_list("SELECT * FROM `orders` WHERE `username` = '".$getUser['email']."'  ") as $rowacc)
                               {?>
                         

                            <tr>
    <td class="px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500">
                                       <?=$rowacc['magd'];?> 
                                     </td>
                                             <!-- First Table Cell (tknick) -->
                           <td class="px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500">
                        <?=$rowacc['title'];?>
                    
                         </td>
                            
                                    <td class="px-3.5 py-2.5 first:pl-5  last:pr-5 border-y border-slate-200 dark:border-zink-500">

                                    <?=format_cash($rowacc['soluong']);?> 
                                    </td>
                                       <td class="px-3.5 py-2.5 first:pl-5  last:pr-5 border-y border-slate-200 dark:border-zink-500">

                                    <?=format_cash($rowacc['money']);?> đ
                                    </td>
                                     <td class="px-3.5 py-2.5 first:pl-5  last:pr-5 border-y border-slate-200 dark:border-zink-500">

                                    <?=$rowacc['createdate'];?> 
                                    </td>
                                   <td>
    <a href="/orders/<?=$rowacc['magd'];?>" class="px-3.5 py-2.5 first:pl-5 last:pr-5 border-y border-slate-200 dark:border-zink-500">
        <i class="fas fa-eye f-20"></i> 
    </a>
    <a href="/DownloadFile/<?=$rowacc['magd'];?>" class="avtar avtar-xs btn-link-secondary">
        <i class="fas fa-download f-20"></i> 
    </a>
</td>

                                   </tr>   
                                    <?php }?>
                        </tbody>
                    </table>
                </div>
                <div class="flex flex-col items-center mt-5 md:flex-row">
                    <div class="flex justify-end">
    </div>

                </div>
                <script>
  function copyText(type) {
    var textToCopy;
    if (type === 'tknick') {
      textToCopy = "<?=$accountrb['tknick'];?>";
    } else if (type === 'pass') {
      textToCopy = "<?=$accountrb['pass'];?>";
    }
    var tempTextArea = document.createElement("textarea");
    document.body.appendChild(tempTextArea);
    tempTextArea.value = textToCopy;
    tempTextArea.select();
    document.execCommand("copy");
    document.body.removeChild(tempTextArea);
    
  }
</script>

                <div class="grid items-center grid-cols-1 gap-3 mb-5 2xl:grid-cols-12">
                                            <div class="2xl:col-span-6 flex flex-wrap">
                            <h4>Hướng dẫn đăng nhập tài khoản 2FA</h4>
                            <iframe width="1280" height="400" src="https://www.youtube.com/embed/o1jtuT_itCY" title="Hướng dẫn đăng nhập tài khoản 2FA" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen=""></iframe>
                        </div>
                                                                <div class="2xl:col-span-6 flex flex-wrap">
                            <h4>Hướng dẫn repost tài khoản</h4>
                            <iframe width="1280" height="400" src="https://www.youtube.com/embed/bNfUFEEQimA" title="Hướng dẫn đăng nhập tài khoản 2FA" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen=""></iframe>
                        </div>
                                    </div>
            </div>
        </div>
    </div>
    <style>
textarea {
    border-color: #A1C4FD; 
}

textarea:focus {
    border-color: #A1C4FD;
    outline: none; 
}
</style>
   <div id="modalReport" wire:ignore.self modal-center="" class="fixed flex flex-col hidden transition-all duration-300 ease-in-out left-2/4 z-drawer -translate-x-2/4 -translate-y-2/4 show">
    <form method="post" wire:submit="report">
        <div class="w-screen md:w-[40rem] bg-white shadow rounded-md dark:bg-zink-600 flex flex-col h-full">
            <div class="flex items-center justify-between p-4 border-b border-slate-200 dark:border-zink-500">
                <h5 class="text-16">Report</h5>
                <button data-modal-close="modalReport" type="button" class="transition-all duration-200 ease-linear text-slate-500 hover:text-red-500 dark:text-zink-200 dark:hover:text-red-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="x" class="lucide lucide-x size-5"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
                </button>
            </div>
            <div class="max-h-[calc(theme('height.screen')_-_180px)] p-4 overflow-y-auto">
                 <input type="hidden" id="token" value="<?= empty($getUser['token']) ? '' : $getUser['token'] ?>">
                <label for="inputPlaceholder" class="inline-block mb-2 text-base font-medium">Chọn lí do</label>
                <br>
                <select wire:model="reason" wire:change="changeOption($event.target.value)" id="reasontype" class="form-select border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200">
                    <option value="">-- Chọn lí do --</option>
                    <option value="31f52919-ea7f-481d-9c64-8121cfafcb3d">LỖI 2 SLEP - LỖI TÀI KHOẢN CẦN DUYỆT THIẾT BỊ</option>
                    <option value="20d4a4c4-bcf4-4dd5-8e53-4b6e58e8b961">LỖI SAI TÀI KHOẢN - LỖI SAI MẬT KHẨU</option>
                    <option value="12e9ed15-6b63-45ef-8723-4aed40e84723">LỖI SAI SỐ LƯỢNG ROBUX</option>
                    <option value="1ce78562-2f02-400a-9505-052c1620818c">LỖI TÀI KHOẢN BỊ BAND - BỊ KHÓA</option>
                    <option value="693e176f-2369-47ef-8f7f-3f15186e2533">LỖI ACC KHÔNG CÓ ROBUX</option>
                    <option value="8284e50b-b7c1-407a-b93c-ca89fcb12c65">LỖI SAI DÃY SỐ CODE 2FA</option>
                </select>

                <div id="reportTextarea" class="mt-4 hidden">
                    <label for="lydo" class="block text-base font-medium mb-1">Hãy yêu cầu hoàn tiền hoặc yêu cầu cung cấp lại chính xác mật khẩu, tại đây chúng tôi sẽ xử lý đơn hàng cho bạn.</label>
                <textarea id="lydo" class="w-full p-2 border border-slate-200 dark:border-zink-500 rounded-md dark:bg-zink-700 dark:text-zink-100 focus:border-lightblue-400" rows="4"></textarea>
                </div>
            </div>
            <div class="flex items-center justify-between p-4 mt-auto border-t border-slate-200 dark:border-zink-500">
                <button name="submitReport" wire:loading.class="opacity-50" type="submit" class="text-white bg-red-500 border-red-500 btn hover:text-white hover:bg-red-600 hover:border-red-600 focus:text-white focus:bg-red-600 focus:border-red-600 focus:ring focus:ring-red-100 active:text-white active:bg-red-600 active:border-red-600 active:ring active:ring-red-100 dark:ring-custom-400/20">
                    <svg wire:loading="" class="w-4 h-4 ltr:mr-2 rtl:ml-2 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Gửi report
                </button>
                  <button name="GuiReport" onclick="Report(<?= $rowacc['id']; ?>)" wire:loading.class="opacity-50" type="submit" class="hidden text-white bg-red-500 border-red-500 btn hover:text-white hover:bg-red-600 hover:border-red-600 focus:text-white focus:bg-red-600 focus:border-red-600 focus:ring focus:ring-red-100 active:text-white active:bg-red-600 active:border-red-600 active:ring active:ring-red-100 dark:ring-custom-400/20">
                    <svg wire:loading="" class="w-4 h-4 ltr:mr-2 rtl:ml-2 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Gửi report
                </button>
               

            </div>
        </div>
    </form>
</div>
<script>
    document.querySelector('button[name="submitReport"]').addEventListener('click', function(event) {
        event.preventDefault(); 
        
        var reportTextarea = document.getElementById('reportTextarea');
        var submitReport = document.querySelector('button[name="submitReport"]');
        var GuiReport = document.querySelector('button[name="GuiReport"]');

        reportTextarea.classList.remove('hidden');
        submitReport.classList.add('hidden');
        
        GuiReport.classList.remove('hidden');
    });
function Report(id) {
    const token = document.getElementById("token").value;
    const GuiReport = document.querySelector("[name='GuiReport']");

    GuiReport.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Đang xử lý...';
    GuiReport.disabled = true;

    $.ajax({
        url: "/ajaxs/client/HuyReport.php",
        method: "POST",
        dataType: "JSON",
        data: {
            id: id,
            token: token, 
            reasontype: $("#reasontype").val(),
            lydo: $("#lydo").val()
        },
        success: function (data) {
            if (data.status === "success") {
                showMessageDucapi(data.msg, "success");
                setTimeout(() => { location.reload(); }, 1000);
            } else {
                showMessageDucapi(data.msg, "error");
            }
            GuiReport.innerHTML = 'Gửi report';
            GuiReport.disabled = false;
        },
        error: function () {
            showMessageDucapi("Đã xảy ra lỗi, vui lòng thử lại sau!", "error");
            GuiReport.innerHTML = 'Gửi report';
            GuiReport.disabled = false;
        },
    });
}
function HuyReport(id) {
    const token = document.getElementById("token").value;
    const HuyReport = document.querySelector("[name='HuyReport']");

    HuyReport.innerHTML = '<i class="fa fa-spinner fa-spin"></i> Đang xử lý...';
    HuyReport.disabled = true;

    $.ajax({
        url: "/ajaxs/client/HuyReport.php",
        method: "POST",
        dataType: "JSON",
        data: {
            id: id,
            token: token
        },
        success: function (data) {
            if (data.status === "success") {
                showMessageDucapi(data.msg, "success");
                setTimeout(() => { location.reload(); }, 1000);
            } else {
                showMessageDucapi(data.msg, "error");
            }
            HuyReport.innerHTML = 'Hủy report';
            HuyReport.disabled = false;
        },
        error: function () {
            showMessageDucapi("Đã xảy ra lỗi, vui lòng thử lại sau!", "error");
            HuyReport.innerHTML = 'Hủy report';
            HuyReport.disabled = false;
        },
    });
}
</script>

    <div id="modalTips" modal-center="" class="fixed flex flex-col transition-all duration-300 ease-in-out left-2/4 z-drawer -translate-x-2/4 -translate-y-2/4 show hidden">
        <div class="w-screen lg:w-[55rem] bg-white shadow rounded-md dark:bg-zink-600 flex flex-col h-full">
            <div class="flex items-center justify-between p-4 border-b border-slate-200 dark:border-zink-500">
                <h5 class="text-16"> Hướng dẫn login acc có 2FA Auth</h5>
                <button data-modal-close="modalTips" class="transition-all duration-200 ease-linear text-slate-500 hover:text-red-500 dark:text-zink-200 dark:hover:text-red-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="x" class="lucide lucide-x size-5"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
                </button>
            </div>
            <div class="max-h-[calc(theme('height.screen')_-_180px)] p-4 overflow-y-auto">
                    <?= base64_decode($VCD->site('2falog')) ?> 
                    </div>
        </div>
    </div>
<style>.form-control {
    width: 100%;
    padding: 0.5rem 1rem;
    border-radius: 0.375rem;
    border: 1px solid #e2e8f0;
    background-color: #fff;
    color: #4a4a4a;
}

.form-control[readonly] {
    background-color: #f3f4f6;
    cursor: not-allowed;
}

</style>
    <div id="detailOrder" wire:ignore.self="" modal-center="" class="fixed flex flex-col transition-all duration-300 ease-in-out left-2/4 z-drawer -translate-x-2/4 -translate-y-2/4 show hidden">
        <div class="w-screen lg:w-[55rem] bg-white shadow rounded-md dark:bg-zink-600 flex flex-col h-full">
            <div class="flex items-center justify-between p-4 border-b border-slate-200 dark:border-zink-500">
                <h5 class="text-16">Chi tiết #<?=$rowacc['id'];?></h5>
                <button data-modal-close="detailOrder" type="button" class="transition-all duration-200 ease-linear text-slate-500 hover:text-red-500 dark:text-zink-200 dark:hover:text-red-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="x" class="lucide lucide-x size-5"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
                </button>
                
            </div>
             
            <div class="max-h-[calc(theme('height.screen')_-_180px)] p-4 overflow-y-auto">
                <label class="">Chi tiết</label>
                                    <input type="text" class="form-control" value="<?=$rowacc['time'];?>" readonly>
                                   <h4 class="text-16">Báo lỗi</h4>
                                      <?php $rowticket = $VCD->get_row("SELECT * FROM `ticket` WHERE `nickrb` = '" . $rowacc['id'] . "'");
                                            if ($rowticket)  {?>
                                    <strong > Lỗi</strong>: <label class=""><?=report($rowticket['type']);?></label> <br>
                                    <label class="">Lý do: <?=$rowticket['lydo'];?></label>
                                             <?php } ?> 
            </div>
       
        </div>
    </div>
    
    <div id="useBoot" wire:ignore.self="" modal-center="" class="fixed flex flex-col transition-all duration-300 ease-in-out left-2/4 z-drawer -translate-x-2/4 -translate-y-2/4 show hidden">
        <div class="w-screen lg:w-[55rem] bg-white shadow rounded-md dark:bg-zink-600 flex flex-col h-full">
            <div class="flex items-center justify-between p-4 border-b border-slate-200 dark:border-zink-500">
                <h5 class="text-16">Cách sử dụng bot </h5>
                <button data-modal-close="useBoot" type="button" class="transition-all duration-200 ease-linear text-slate-500 hover:text-red-500 dark:text-zink-200 dark:hover:text-red-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="x" class="lucide lucide-x size-5"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
                </button>
            </div>
            <div class="max-h-[calc(theme('height.screen')_-_180px)] p-4 overflow-y-auto">
                <?= base64_decode($VCD->site('sudungbot')) ?> 
                </div>
        </div>
    </div>
    <div id="howToReport" wire:ignore.self="" modal-center="" class="fixed flex flex-col transition-all duration-300 ease-in-out left-2/4 z-drawer -translate-x-2/4 -translate-y-2/4 show hidden">
        <div class="w-screen lg:w-[55rem] bg-white shadow rounded-md dark:bg-zink-600 flex flex-col h-full">
            <div class="flex items-center justify-between p-4 border-b border-slate-200 dark:border-zink-500">
                <h5 class="text-16">Hướng dẫn sử dụng report </h5>
                <button data-modal-close="howToReport" type="button" class="transition-all duration-200 ease-linear text-slate-500 hover:text-red-500 dark:text-zink-200 dark:hover:text-red-500">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="x" class="lucide lucide-x size-5"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
                </button>
            </div>
            <div class="max-h-[calc(theme('height.screen')_-_180px)] p-4 overflow-y-auto">
                  <?= base64_decode($VCD->site('report')) ?>
                  </div>
        </div>
    </div>
</div>
                </div>

       
  <?php require_once __DIR__ . '/footer.php'; ?>