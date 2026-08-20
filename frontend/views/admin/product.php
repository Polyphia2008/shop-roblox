
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php 
if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$title = 'Trang Quản Trị | ' . $VCD->site('title');
$body = [
    'title' => 'Trang Quản Trị'
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
$sourceCodes = $VCD->get_list("SELECT * FROM `product_nick` ORDER BY id DESC");
$totalItems = count($sourceCodes);
$totalPages = ceil($totalItems / $limit);

$from = ($page - 1) * $limit;
$order_by = 'ORDER BY `id` DESC';
$where = '1=1';
$id = '';
$code = '';
if(!empty($_GET['id']))
{
    $id = xss($_GET['id']);
   $where .= " AND `id` = '$id'";
}

if(!empty($_GET['code']))
{
    $code = xss($_GET['code']);
  
        $where .= " AND `code` = '$code'";
}


?>

<div class="main-content app-content">
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <h1 class="page-title fw-semibold fs-18 mb-0"><i class="fa-solid fa-tags"></i> Tài khoản</h1>
            <div class="ms-md-1 ms-0">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item active" aria-current="page">Tài khoản</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                         Tài khoản 
                        </div>
                        <button type="button" data-bs-toggle="modal" data-bs-target="#exampleModalScrollable2"
                            class="btn btn-sm btn-primary shadow-primary"><i
                                class="ri-add-line fw-semibold align-middle"></i> Thên nick</button>
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
                                    <input class="form-control form-control-sm" value="" name="code"
                                        placeholder="Chuyên Mục">
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-hero btn-sm btn-primary"><i class="fa fa-search"></i>
                                        Search                                    </button>
                                    <a class="btn btn-hero btn-sm btn-danger" href="/admin/chuyen-muc"><i
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
                                           <th class="text-center">Image</th>
                                               <th class="text-center">Mã code </th>
                                           <th class="text-center">Nhóm chuyên mục</th>
                                          <th class="text-center">Thông tin</th>
                                          <th class="text-center">Trạng Thái</th>
                                        <th class="text-center">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     <?php $i=0; foreach ($VCD->get_list("SELECT * FROM `product_nick` WHERE $where $order_by LIMIT $from,$limit") as $row) {?>
                                                                        <tr>
                                        <td><b>[<?=$row['id'];?>]</b>
                                        </td>
                          <td class="text-center">
    <img src="<?= $VCD->get_row("SELECT `logo` FROM `chuyenmuc` WHERE `id` = {$row['chuyenmuc']}")['logo']; ?>" style="border-radius: 10px;" alt="pic" height="80px">
</td>
                             
                                        <td class="text-center"><span style="font-size: 15px;"
                                                class="badge bg-danger-gradient"><?=$row['code'];?></span>
                                        </td>
                                             <td class="text-center"><?= $VCD->get_row("SELECT `title` FROM `chuyenmuc` WHERE `id` = {$row['chuyenmuc']}")['title']; ?></td>
                                              <td class="text-center"><?=$row['note'];?> </td>
                                       <td class="text-center">   <?php

if (empty($row['username']) && empty($row['magd'])) {
    echo 'Chưa bán';  
} elseif (!empty($row['username']) || !empty($row['magd'])) {
    echo 'Đã bán'; 
} else {
    echo 'Nó cứ bị gì ý'; 
}
?></td>

                            
                                        <td class="text-center">
                                            <a type="button" onclick="RemoveRow(<?=$row['id'];?>)"
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
                    <a class="page-link link" href="/admin/product?id=<?=$id;?>&code=<?=$code;?>&limit=<?=$limit;?>&shortByDate=&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php } else if (abs($i - $page) === 2) { ?>
                <li class="page-item">
                    <a class="page-link link" href="">...</a>
                </li>
            <?php } ?>
        <?php } ?>
        <li class="paginate_button page-item previous "><a class="page-link" href="/admin/product?id=<?=$id;?>&code=<?=$code;?>&limit=<?=$limit;?>&shortByDate=&page=<?=$page + 1;?>">Next</a></li>
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
                <h6 class="modal-title" id="staticBackdropLabel2"><i class="fa-solid fa-plus"></i>Thêm nick
                </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="row mb-4">
                        <label class="col-sm-4 col-form-label" for="example-hf-email">Danh sách tài khoản (<span
                                class="text-danger">*</span>)</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                                 <textarea class="form-control" name="note" id="note" placeholder="TK|PASS|2FA" required rows="10" cols="10"></textarea>

                                <span class="input-group-text">
                                    <i class="fa-solid fa-code"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                  
                     <div class="row mb-4">
                        <label class="col-sm-4 col-form-label" for="example-hf-email">Chuyên mục(<span
                                class="text-danger">*</span>)</label>
                        <div class="col-sm-8">
                            <div class="input-group">
                              <select class="form-control" id="loai" name="loai" required>
                                        <option value="">-- Chọn Chuyên mục --</option>
                                        <?php foreach ($VCD->get_list("SELECT * FROM `chuyenmuc`") as $tgdev) {?>
                                            <option value="<?=$tgdev['id'];?>"><?=$tgdev['title'];?></option>
                                        <?php } ?>
                                    </select>
                                <span class="input-group-text">
                                    <i class="fa-solid fa-code"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light " data-bs-dismiss="modal">Close</button>
                    <button type="submit" id="btn-chuyemuc" class="btn btn-primary shadow-primary btn-wave"><i
                            class="fa fa-fw fa-plus me-1"></i>
                        Thêm Ngay</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
  $("#btn-chuyemuc").click(function() {
        $('#btn-chuyemuc').html('Loading...').prop('disabled',
            true);
        $.ajax({
            url: '<?=BASE_URL('ajaxs/admin/product.php')?>',
            type: 'POST',
            dataType: "json",
            data: {
                    action: "add",
                note: $('#note').val(),
                loai: $('#loai').val(),
                token: $("#token").val()
            },
            success: function(respone) {
               if (respone.status == '2') {
                     showMessageDucapi(respone.msg, "success");
                     setTimeout(function() {
                     location.reload(); }, 1000);
                  } else {
                     showMessageDucapi(respone.msg, "error");
                  }
                $('#btn-chuyemuc').html(' Thêm Ngay').prop('disabled', false);
            }
        });
    });
    
    
function RemoveRow(id) {
    cuteAlert({
        type: "question",
        title: "Xác Nhận Xóa",
        message: "Bạn có chắc chắn muốn xóa ID " + id + " không ?",
        confirmText: "Đồng Ý",
        cancelText: "Hủy"
    }).then((e) => {
        if (e) {
            $.ajax({
                url: "<?=BASE_URL('')?>ajaxs/admin/product.php",
                method: "POST",
                dataType: "JSON",
                data: {
                        action: "delete",
                    id: id,
                    token: $("#token").val()
                },
               success: function(respone) {
                  if (respone.status == 'success') {
                     showMessageDucapi(respone.msg, "success");
                     setTimeout(function() {
                     location.reload(); }, 3000);
                  } else {
                     showMessageDucapi(respone.msg, respone.status);
                  }
                },
                error: function() {
                    alert(html(respone));
                    location.reload();
                }
            });
        }
    })
}
</script>
<?php
require_once(__DIR__.'/Footer.php');
?>