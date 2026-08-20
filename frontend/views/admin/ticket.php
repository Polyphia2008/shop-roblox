
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
$sourceCodes = $VCD->get_list("SELECT * FROM `ticket` ORDER BY id DESC");
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
if (isset($_POST['update_status']) && isset($_POST['id'])) {
    $id = check_string($_POST['id']);
    $status = isset($_POST['status']) && $_POST['status'] == '1' ? 1 : 0;
    $ticket = $VCD->update("ticket", array(
        'status' => $status
    ), "`id` = '$id'");

    if ($ticket) {
            $ticket_id = $VCD->get_row("SELECT * FROM ticket WHERE id = '".$id."'  `dichvu`='nick'");
        $accountorder = $VCD->get_row("SELECT * FROM accountorder WHERE id = '".$ticket_id['nickrb']."'");
        if ($accountorder) {
            $userGuest = $VCD->get_row("SELECT * FROM users WHERE email = '$accountorder[username]'");
            if ($userGuest) {
           notiTele("🔔 Báo Cáo #{$accountorder['magd']} 🔔\nTrạng thái khiếu nại của quý khách đã được duyệt vui lòng kiểm tra lại! Lúc: " . date('d/m/Y H:i:s'), $userGuest['telegram']);
            }
        }
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Thành công',
                text: 'Sửa trạng thái thành công!'
            }).then(function() {
                setTimeout(function() {
                    window.location.href = '/admin/ticket'; 
                }, 500); 
            });
        </script>";
    } else {
        echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Lỗi',
                text: 'Không thể sửa trạng thái!'
            });
        </script>";
    }
}
?>
 <style>
        input[type="checkbox"]:checked {
            background-color: #28a745;
            border-color: #28a745;
        }

        input[type="checkbox"]:not(:checked) {
            background-color: #fff; 
            border-color: #ccc;
        }
    </style>
<div class="main-content app-content">
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <h1 class="page-title fw-semibold fs-18 mb-0"><i class="fa-solid fa-tags"></i> Danh sách ticket</h1>
            <div class="ms-md-1 ms-0">
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item active" aria-current="page">Danh sách ticket</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            DANH SÁCH ticket
                        </div>
                       
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
                                    <a class="btn btn-hero btn-sm btn-danger" href="/admin/ticket"><i
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
                                        <th class="text-center">Tài Khoản </th>
                                             <th class="text-center">Loại</th>
                                                  <th class="text-center">Lý do </th>
                                                         <th class="text-center">Time Gửi</th>
                                          <th class="text-center">Trạng Thái</th>
                                        <th class="text-center">Thao tác</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     <?php $i=0; foreach ($VCD->get_list("SELECT * FROM `ticket` WHERE `dichvu`='nick' AND $where $order_by LIMIT $from,$limit") as $row) {?>
                                                                        <tr>
                                        <td><b>[<?=$row['id'];?>]</b>
                                        </td>
                                     <td class="text-center">
    <a href="/admin/edit-nick-robux/<?=$row['nickrb'];?>" style="font-size: 15px;" class="badge bg-danger-gradient">
       Nick #<?=$row['nickrb'];?>
    </a>
</td>
  <td class="text-center">
   <?=report($row['type']);?>
</td>
  <td class="text-center">
   <?=$row['lydo'];?>
</td>
  <td class="text-center">
   <?=$row['time'];?>
</td>
                                         <td class="text-center">

  <form action="" method="post" id="status-form-<?= $row['id']; ?>">
    <div class="form-group">
        <select class="form-control" name="status" id="status<?= $row['id']; ?>">
            <option value="1" <?= $row["status"] == 1 ? "selected" : ""; ?>>Đang xử lí</option>
            <option value="0" <?= $row["status"] == 0 ? "selected" : ""; ?>>Đã xử lí</option>
            <option value="2" <?= $row["status"] == 2 ? "selected" : ""; ?>>Đã Hủy</option>
        </select>
    </div>
    <input type="hidden" name="update_status" value="1">
    <input type="hidden" name="id" value="<?= $row['id']; ?>">
    <button type="submit" style="display: none;">Submit</button>
</form>

    </td>
    <script>
        document.getElementById('status<?= $row['id']; ?>').addEventListener('change', function() {
            document.getElementById('status-form-<?= $row['id']; ?>').submit();
        });
    </script>
                                          
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
                    <a class="page-link link" href="/admin/ticket?id=<?=$id;?>&code=<?=$code;?>&limit=<?=$limit;?>&shortByDate=&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                </li>
            <?php } else if (abs($i - $page) === 2) { ?>
                <li class="page-item">
                    <a class="page-link link" href="">...</a>
                </li>
            <?php } ?>
        <?php } ?>
        <li class="paginate_button page-item previous "><a class="page-link" href="/admin/ticket?id=<?=$id;?>&code=<?=$code;?>&limit=<?=$limit;?>&shortByDate=&page=<?=$page + 1;?>">Next</a></li>
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

<script>

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
                url: "<?=BASE_URL('')?>ajaxs/admin/remove_ticket.php",
                method: "POST",
                dataType: "JSON",
                data: {
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