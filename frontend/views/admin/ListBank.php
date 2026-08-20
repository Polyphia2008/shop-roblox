<?php 
if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$title = 'Thêm Ngân Hàng | ' . $VCD->site('title');
$body = [
    'title' => 'Danh sách Tool'
];
$body['header'] = '';
$body['footer'] = '';
require_once(__DIR__.'/Header.php');
require_once(__DIR__.'/Navbar.php');
require_once(__DIR__ . '/../../../core/is_user.php');
CheckLogin();
CheckAdmin();
if(!empty($_GET['page']))
{
$page = xss(intval($_GET['page']));}
else
{
    $page = 1;
}
if(!empty($_GET['limit']))
{
$limit = xss(intval($_GET['limit']));}
else
{
    $limit = 10;
}
$sourceCodes = $VCD->get_list("SELECT * FROM `bank` ORDER BY id DESC");
$totalItems = count($sourceCodes);
$totalPages = ceil($totalItems / $limit);

$from = ($page - 1) * $limit;
$order_by = 'ORDER BY `id` DESC';
$where = '1=1';
$id = '';
$short_name = '';
if(!empty($_GET['id']))
{
    $id = xss($_GET['id']);
   $where .= " AND `id` = '$id'";
}

if(!empty($_GET['short_name']))
{
    $short_name = xss($_GET['short_name']);
  
        $where .= " AND `short_name` = '$short_name'";
}
?>
<?php
if (isset($_POST['ThemNganHang']) && $getUser['level'] == 1) {
    $isInsert = $VCD->insert("bank", [
                'token'    => check_string($_POST['token']),
        'short_name'    => check_string($_POST['short_name']),
        'accountNumber' => check_string($_POST['accountNumber']),
        'accountName'   => check_string($_POST['accountName'])
    ]);
    if ($isInsert) {
        die('<script type="text/javascript">if(!alert("Thêm thành công !")){window.history.back().location.reload();}</script>');
    } else {
        die('<script type="text/javascript">if(!alert("Thêm thất bại !")){window.history.back().location.reload();}</script>');
    }
}
?>
<div class="main-content app-content">
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <h1 class="page-title fw-semibold fs-18 mb-0"><i class="fa-solid fa-tags"></i> List Bank</h1>
            <div class="ms-md-1 ms-0">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item active" aria-current="page">List Bank</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            DANH SÁCH List Bank
                        </div>
                        <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModalScrollable2"
                            class="btn btn-sm btn-primary shadow-primary"><i
                                class="ri-add-line fw-semibold align-middle"></i> Tạo List Bank mới</button>
                    </div>
                    <div class="card-body">
                        <form action="" class="align-items-center mb-3" name="formSearch" method="GET">
                             <input type="hidden" value="<?=$getUser['token']?>" id="token">
                            <div class="row row-cols-lg-auto g-3 mb-3">
                                <div class="col-lg col-md-4 col-6">
                                      <input class="form-control form-control-sm" value="" name="id"
                                        placeholder="ID">
                                </div> 
                                <div class="col-lg col-md-4 col-6">
                                    <input class="form-control form-control-sm" value="" name="short_name"
                                        placeholder="List Bank">
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-hero btn-sm btn-primary"><i class="fa fa-search"></i>
                                        Search                                    </button>
                                    <a class="btn btn-hero btn-sm btn-danger" href="/admin/ListBank"><i
                                            class="fa fa-trash"></i>
                                        Clear filter                                    </a>
                                </div>
                            </div>
                            <div class="top-filter">
                                <div class="filter-show">
                                    <label class="filter-label">Show :</label>
                                    <select name="limit" onchange="this.form.submit()"
                                        class="form-select filter-select">
                                       <option <?= ($limit == '5') ? 'selected' : ''; ?> value="5">5</option>
                                        <option <?= ($limit == '10') ? 'selected' : ''; ?> value="10">10</option>
                                        <option <?= ($limit == '20') ? 'selected' : ''; ?> value="20">20</option>
                                        <option <?= ($limit == '50') ? 'selected' : ''; ?> value="50">50</option>
                                        <option <?= ($limit == '100') ? 'selected' : ''; ?> value="100">100</option>
                                        <option <?= ($limit == '500') ? 'selected' : ''; ?> value="500">500</option>
                                        <option <?= ($limit == '1000') ? 'selected' : ''; ?> value="1000">1.000</option>
                                    </select>
                                </div>
                                <div class="filter-short">
                                    <label class="filter-label">Short by Date:</label>
                                    <select name="shortByDate" onchange="this.form.submit()"
                                        class="form-select filter-select">
                                        <option value="">Tất cả</option>
                                        <option  value="1">Hôm nay                                        </option>
                                        <option  value="2">Tuần này                                        </option>
                                        <option  value="3">
                                            Tháng này                                        </option>
                                    </select>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive mb-3">
                            <table class="table text-nowrap table-striped table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th class="text-center">Logo</th>
                                               <th class="text-center">Link Cron</th>
                                        <th class="text-center">Ngân Hàng</th>
                                        <th class="text-center">STK</th>
                                        <th class="text-center">CTK</th>
                                        <th class="text-center">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     <?php $i=0; foreach ($VCD->get_list("SELECT * FROM `bank` WHERE $where $order_by LIMIT $from,$limit") as $bank) {
                                    
                                      
                                     ?>
                                                                        <tr>
                                        <td><b>[<?=$bank['id'];?>]</b>
                                        </td>
                                         <td class="text-center"><img src="https://img.vietqr.io/image/<?=$bank['short_name'];?>-96386910034-compact2.jpg" height="50">
                                        </td>
                                          <td class="text-center">
    <span style="font-size: 15px;" class="badge bg-danger-gradient">
       <?php if ($bank['short_name'] == 'MBBANK') {?><a href="https://ban.dichvugiare.net/cron/mbbank.php?token=<?=$bank['token']?>" target="_blank">
       <?=$bank['token']?>
    </a>  
    <?php } elseif ($bank['short_name'] == 'VietinBank'){?>
        <a href="https://ban.dichvugiare.net/cron/viettinbank.php?token=<?=$bank['token']?>" target="_blank">
       <?=$bank['token']?>
    </a>  
   <?php }?>
    </span>
  
</td>

                                        <td class="text-center"><span style="font-size: 15px;"
                                                class="badge bg-danger-gradient"><?=$bank['short_name']?></span>
                                        </td>
                                         <td class="text-center"><?=$bank['accountNumber']?>
                                        </td>
                                         <td class="text-center"><?=$bank['accountName']?>
                                        </td>
                                        <td class="text-center">
                                            <a type="button" onclick="RemoveRow(<?=$bank['id'];?>)"
                                                class="btn btn-sm btn-danger" data-bs-toggle="tooltip"
                                                title="Delete">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </td>
                                    </tr>
                                                     <?php }?>                     
                                                                    </tbody>
                            </table>
                        </div>
                        <div class="row">

                            <div class="col-sm-12 col-md-12 mb-3">
                                <div class="pagination-style-1">
                                    <div class="d-flex justify-content-center">
                                        <center> 
                                        <div class="paging_simple_numbers">
                                            <ul class="pagination">
                                                <?php for ($i = 1; $i <= $totalPages; $i++) { ?>
            <?php if ($i === $page) { ?>
                <li class="page-item active">
                    <a class="page-link link" href="#"><?php echo $i; ?></a>
                </li>
            <?php } else if ($i <= 4 || $i > $totalPages - 4 || abs($i - $page) <= 1) { ?>
                <li class="page-item <?php if($i == $page) { echo'active';}?>">
                    <a class="page-link link" href="/admin/ListBank?id=<?=$id;?>&short_name=<?=$short_name;?>&limit=<?=$limit;?>&shortByDate=&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php } else if (abs($i - $page) === 2) { ?>
                <li class="page-item">
                    <a class="page-link link" href="">...</a>
                </li>
            <?php } ?>
        <?php } ?>
        <li class="paginate_button page-item previous "><a class="page-link" href="/admin/ListBank?id=<?=$id;?>&short_name=<?=$short_name;?>&limit=<?=$limit;?>&shortByDate=&page=<?=$page + 1;?>">Next</a></li>
                                                </ul></div></center>                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="exampleModalScrollable2" tabindex="-1" aria-labelledby="exampleModalScrollable2"
    data-bs-keyboard="false" aria-hidden="true">
    <!-- Scrollable modal -->
    <div class="modal-dialog modal-dialog-centered modal-lg dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="staticBackdropLabel2"><i class="fa-solid fa-plus"></i> Tạo List Bank
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row mb-4">
                        <label class="col-sm-4 col-form-label" for="example-hf-email">Ngân Hàng (<span
                                class="text-danger">*</span>)</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                               <select class="form-control" name="short_name">
                                                    <option value="">--- chọn ngân hàng -- </option>
                                              
                                            <option value="MBBANK">MBBANK</option>
                                        <option value="VietinBank">viettinbank</option>
                                                </select>
                                <span class="input-group-text">
                                    <i class="fa-solid fa-code"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                         <div class="row mb-4">
                        <label class="col-sm-4 col-form-label" for="example-hf-email">Tên tài khoản Bank (<span
                                class="text-danger">*</span>)</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input type="text" class="form-control" name="accountName" id="accountName" required>
                                <span class="input-group-text">
                                    <i class="fa-solid fa-code"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                         <div class="row mb-4">
                        <label class="col-sm-4 col-form-label" for="example-hf-email">Số tài khoản Bank (<span
                                class="text-danger">*</span>)</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input type="text" class="form-control" name="accountNumber" id="accountNumber" required>
                                <span class="input-group-text">
                                    <i class="fa-solid fa-code"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                         <div class="row mb-4">
                        <label class="col-sm-4 col-form-label" for="example-hf-email">Token Bank Auto(<span
                                class="text-danger">Api sang <a href="https://api.sieuthicode.net" class="text-danger">api.sieuthicode.net</a></span>)</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                <input type="text" class="form-control" name="token" id="token" required>
                                <span class="input-group-text">
                                    <i class="fa-solid fa-code"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light " data-bs-dismiss="modal">Close</button>
                    <button type="submit" name="ThemNganHang" class="btn btn-primary shadow-primary btn-wave"><i
                            class="fa fa-fw fa-plus me-1"></i>
                        Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
function RemoveRow(id) {
    cuteAlert({
        type: "question",
        title: "Xác Nhận Xóa Bank",
        message: "Bạn có chắc chắn muốn xóa ID " + id + " không ?",
        confirmText: "Đồng Ý",
        cancelText: "Hủy"
    }).then((e) => {
        if (e) {
            $.ajax({
                url: "<?=BASE_URL('')?>ajaxs/admin/removeBank.php",
                method: "POST",
                dataType: "JSON",
                data: {
                    id: id,
                    token: $("#token").val()
                },
                success: function(respone) {
                    if (respone.status == 'success') {
                        cuteToast({
                            type: "success",
                            message: respone.msg,
                            timer: 5000
                        });
                        location.reload();
                    } else {
                        cuteAlert({
                            type: "error",
                            title: "Error",
                            message: respone.msg,
                            buttonText: "Okay"
                        });
                    }
                },
                error: function() {
                    alert(html(response));
                    location.reload();
                }
            });
        }
    })
}
</script>

<script>
$(function() {
    $('#datatable1').DataTable();
});
</script>
<script>
$(function() {
    $('#datatable2').DataTable();
});
</script>
<?php
require_once(__DIR__.'/Footer.php');
?>