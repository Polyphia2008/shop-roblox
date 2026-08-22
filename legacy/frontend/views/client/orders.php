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
if (isset($_GET['magd'])) {
    $row = $VCD->get_row("SELECT * FROM `orders` WHERE `magd` = '" . check_string($_GET['magd']) . "' AND `username` = '".$getUser['email']."'");
    if (!$row) {
        die("Dữ liệu không tồn tại");
    }
} else {
    die("Thiếu thông tin ID");
}
 
// mã nguồn được phát triển bởi Văn Công Đức ✓
?><style>
   .form-control:hover {
     border: 2px solid #ccc;
    }
</style>


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
               <div class="col-12">
                        <div class="section-heading text-center">
                    
      
                                <div class="heading-title">Đơn Hàng #<?=$row['magd'];?> </div>
                                 <li>Loại tài khoản: <b><?=$row['title'];?></b></li>
                            <li>Số lượng: <b style="color: blue;"><?=format_cash($row['soluong']);?></b></li>
                            <li>Số tiền: <b style="color: red;"><?=format_cash($row['money']);?>đ</b></li>
                            <li>Thời gian thanh toán: <b><?=$row['createdate'];?></b></li>
                            <li>Định dạng tài khoản : tài khoản|mật khẩu (|2fa)</li>
                            </div>
                            
                    <div class="card-body">
<?php
   $nicks = $VCD->get_list("SELECT * FROM `product_nick` WHERE `magd` = '" . $row['magd'] . "' AND `username` = '".$getUser['email']."'");

    if ($nicks) {
        echo "<div class='form-group'><textarea id='copyClone' class='form-control' rows='8' cols='50' readonly='' 
            style='resize: horizontal; border: 2px solid #ccc; border-radius: 5px; padding: 2px; width: 100%; box-sizing: border-box;'>";
        foreach ($nicks as $nick) {
            $note = trim($nick['note']);
            $note = preg_replace('/\n+/', "\n", $note);
            if (!empty($note)) {
                echo $note . "\n"; 
            }
        }

        echo "</textarea></div>";
    } 
?>


    <div class="form-group mb-0 mt-4">
        <form action="" method="post">
            <!-- Nút Copy -->
            <button class="btn btn-info copy" type="button" id="copyBtn" style="border: 2px solid #17a2b8; padding: 10px 20px; border-radius: 5px; font-size: 16px; background-color: #17a2b8; color: white; transition: all 0.3s ease;">
                <i class="fas fa-copy"></i> Copy
            </button>
            
            <!-- Nút Download -->
            <a class="btn btn-danger" type="button" target="_blank" href="/DownloadFile/<?=$row['magd'];?>" style="border: 2px solid #dc3545; padding: 10px 20px; border-radius: 5px; font-size: 16px; background-color: #dc3545; color: white; text-decoration: none; transition: all 0.3s ease;">
                <i class="fas fa-arrow-alt-circle-down"></i> Download
            </a>
        </form><br>
    </div>
</div>

                        </div>
</div>
                </div>
           
                        </div>
</div>
                </div>
                  
                        </div>
<script>
    const copyBtn = document.getElementById('copyBtn');
    const copyTextarea = document.getElementById('copyClone');

    copyBtn.addEventListener('click', function() {
        // Chọn toàn bộ nội dung của textarea
        copyTextarea.select();
        copyTextarea.setSelectionRange(0, 99999); 

        // Sao chép vào clipboard
        try {
            document.execCommand('copy');
      showMessageDucapi("sao chép thành công", "success");
        } catch (err) {
             showMessageDucapi("Đã xảy ra lỗi, vui lòng thử lại sau!", "error");
        }
    });
</script>
  <?php require_once __DIR__ . '/footer.php'; ?>