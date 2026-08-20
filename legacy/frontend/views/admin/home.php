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
  require_once(__DIR__ . '/../../../version.php');
CheckLogin();
CheckAdmin();
$month = date('m');
$year = date('Y');
$day = date('d');

$VCD->remove("don_nap", "`id` > 0"); 

?>

     <div class="main-content app-content">
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <h1 class="page-title fw-semibold fs-18 mb-2">Dashboard</h1>
            <div class="float-right">
                <a class="btn btn-primary shadow-primary btn-wave btn-sm" type="button"
                    href="https://dichvuright.com/client/keybanquyen" target="_blank"><i
                        class="fa-solid fa-magnifying-glass"></i> KIỂM TRA BẢN QUYỀN</a>
            </div>
        </div>
               <div class="alert alert-secondary alert-dismissible fade show custom-alert-icon shadow-sm" role="alert">
            <h5>Sell Game Version: <strong style="color:blue;"><?=$config['version']?></strong></h5>
                        <h6>khi có bản update mới nó sẽ hiện lên để quý khách cập nhập.</h6>
                        <br><br>
            <h6>Giấy phép kích hoạt website của bạn là: <strong style="color:red;" id="copyKey"><?=$VCD->site("key_ban_quyen")?></strong> <button class="btn btn-info btn-sm shadow-sm btn-wave copy waves-effect waves-light" data-clipboard-target="#copyKey" onclick="copy()">Copy</button></h6>
            <small>Vui lòng bảo mật giấy phép của bạn.</small>
          
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i class="bi bi-x"></i></button>
        </div>
               <?php $check_version = $license_check['version'];  
    if ($config['version'] != $check_version) {?>
            <div class="col-12">
                                <div class="card">
                    <div class="card-header" style="border-bottom: 0">
                        <a href="<?=BASE_URL('update.php');?>" class="btn btn-success" data-toggle="tooltip" title="Cập nhật lên bản mới"> <i class="ace-icon fa fa-download"></i>Click update website </a>
                    </div>
                    <div class="card-body p-0">
                        <div class="card-body row">
                            <div class="col-md-12">
                            
                                <div class="form-group">
                                    <label for="name">Phiên bản hiện tại: </label>
                                    <input name="code" type="text" class="form-control" 
                                           value="<?= $config['version'];?>" readonly="readonly">
                                </div>
                                 <div class="form-group">
                                    <label for="name">Bản mới nhất là: </label>
                                    <input name="code" type="text" class="form-control" 
                                           value="<?= $response['version'];?>" readonly="readonly">
                                </div>
                            </div>

                        </div>
                        <!-- /.card-body -->
                        </form>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
      <?php }?>
                        <div class="row">
                        <div class="col-12">
                <div class="text-right mb-3">
                    <img src="https://zshopclone7.cmsnt.net/mod/img/gif-live.gif" width="60px">
                </div>
            </div>
            <!-- Thành viên đăng ký toàn thời gian -->
        <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-6">
    <div class="card custom-card hrm-main-card primary">
        <div class="card-body">
            <div class="d-flex align-items-top">
                <div class="me-3">
                    <span class="avatar bg-primary">
                        <i class="fa-solid fa-users fs-18"></i>
                    </span>
                </div>
                <div class="flex-fill">
                    <span class="fw-semibold text-muted d-block mb-2">Thành viên đăng ký</span>
                    <h5 class="fw-semibold mb-2"><?= format_cash($VCD->num_rows("SELECT * FROM `users`")) ?>
                        <div class="spinner" style="display: none;">
                            <i class="fas fa-spinner fa-spin"></i>
                        </div>
                    </h5>
                    <p class="mb-0">
                        <span class="badge bg-primary-transparent">Toàn thời gian</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Số Nick Có Robux -->
<div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-6">
    <div class="card custom-card hrm-main-card secondary">
        <div class="card-body">
            <div class="d-flex align-items-top">
                <div class="me-3">
                    <span class="avatar bg-info">
                        <i class="fa-solid fa-coins fs-18"></i>
                    </span>
                </div>
                <div class="flex-fill">
                    <span class="fw-semibold text-muted d-block mb-2">Số Nick Có Robux</span>
                    <h5 class="fw-semibold mb-2">
                        <?= format_cash($VCD->num_rows("SELECT * FROM `accountrb`")) ?>
                        <div class="spinner" style="display: none;">
                            <i class="fas fa-spinner fa-spin"></i>
                        </div>
                    </h5>
                    <p class="mb-0">
                        <span class="badge bg-info-transparent">Toàn thời gian</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Số Nick Có Robux -->
<div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-6">
    <div class="card custom-card hrm-main-card secondary">
        <div class="card-body">
            <div class="d-flex align-items-top">
                <div class="me-3">
                    <span class="avatar bg-info">
                        <i class="fa-solid fa-coins fs-18"></i>
                    </span>
                </div>
                <div class="flex-fill">
                    <span class="fw-semibold text-muted d-block mb-2">Số Nick order</span>
                    <h5 class="fw-semibold mb-2">
                        <?= format_cash($VCD->num_rows("SELECT * FROM `accountorder`")) ?>
                        <div class="spinner" style="display: none;">
                            <i class="fas fa-spinner fa-spin"></i>
                        </div>
                    </h5>
                    <p class="mb-0">
                        <span class="badge bg-info-transparent">Toàn thời gian</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Số Đơn Báo Lỗi -->
<div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-6">
    <div class="card custom-card hrm-main-card warning">
        <div class="card-body">
            <div class="d-flex align-items-top">
                <div class="me-3">
                    <span class="avatar bg-warning">
                        <i class="fa-solid fa-exclamation-circle fs-18"></i>
                    </span>
                </div>
                <div class="flex-fill">
                    <span class="fw-semibold text-muted d-block mb-2">Số Đơn Báo Lỗi</span>
                    <h5 class="fw-semibold mb-2"><?= format_cash($VCD->num_rows("SELECT * FROM `ticket` WHERE `status`='1'")) ?>
                        <div class="spinner" style="display: none;">
                            <i class="fas fa-spinner fa-spin"></i>
                        </div>
                    </h5>
                    <p class="mb-0">
                        <span class="badge bg-warning-transparent">Toàn thời gian</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Số Tiền Thành Viên -->
<div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-6">
    <div class="card custom-card hrm-main-card danger">
        <div class="card-body">
            <div class="d-flex align-items-top">
                <div class="me-3">
                    <span class="avatar bg-danger">
                        <i class="fa-solid fa-wallet fs-18"></i>
                    </span>
                </div>
                <div class="flex-fill">
                    <span class="fw-semibold text-muted d-block mb-2">Số Tiền Thành Viên</span>
                    <h5 class="fw-semibold mb-2"><?= format_cash($VCD->get_row("SELECT SUM(`money`) FROM `users`")['SUM(`money`)']); ?>đ
                        <div class="spinner" style="display: none;">
                            <i class="fas fa-spinner fa-spin"></i>
                        </div>
                    </h5>
                    <p class="mb-0">
                        <span class="badge bg-danger-transparent">Toàn thời gian</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Thành viên đăng ký tháng này -->
<div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-6">
    <div class="card custom-card hrm-main-card primary">
        <div class="card-body">
            <div class="d-flex align-items-top">
                <div class="me-3">
                    <span class="avatar bg-primary">
                        <i class="fa-solid fa-users fs-18"></i>
                    </span>
                </div>
                <div class="flex-fill">
                    <span class="fw-semibold text-muted d-block mb-2">Thành viên đăng ký</span>
                    <h5 class="fw-semibold mb-2"><?= format_cash($VCD->num_rows("SELECT * FROM `users` WHERE MONTH(create_date) = $month")) ?>
                        <div class="spinner" style="display: none;">
                            <i class="fas fa-spinner fa-spin"></i>
                        </div>
                    </h5>
                    <p class="mb-0">
                        <span class="badge bg-primary-transparent">Tháng <?= $month; ?></span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Đơn hàng đã bán tháng này -->
<div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-6">
    <div class="card custom-card hrm-main-card secondary">
        <div class="card-body">
            <div class="d-flex align-items-top">
                <div class="me-3">
                    <span class="avatar bg-info">
                        <i class="fa-solid fa-box fs-18"></i>
                    </span>
                </div>
                <div class="flex-fill">
                    <span class="fw-semibold text-muted d-block mb-2">Số Acc Đã Đăng</span>
                    <h5 class="fw-semibold mb-2"><?= format_cash($VCD->num_rows("SELECT * FROM `accountrb` ")) ?>
                        <div class="spinner" style="display: none;">
                            <i class="fas fa-spinner fa-spin"></i>
                        </div>
                    </h5>
                    <p class="mb-0">
                        <span class="badge bg-info-transparent">Toàn thời gian</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Đơn hàng đã bán tháng này -->
<div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-6">
    <div class="card custom-card hrm-main-card secondary">
        <div class="card-body">
            <div class="d-flex align-items-top">
                <div class="me-3">
                    <span class="avatar bg-info">
                        <i class="fa-solid fa-box fs-18"></i>
                    </span>
                </div>
                <div class="flex-fill">
                    <span class="fw-semibold text-muted d-block mb-2">Số Nick Order Đã Đăng</span>
                    <h5 class="fw-semibold mb-2"><?= format_cash($VCD->num_rows("SELECT * FROM `accountorder` ")) ?>
                        <div class="spinner" style="display: none;">
                            <i class="fas fa-spinner fa-spin"></i>
                        </div>
                    </h5>
                    <p class="mb-0">
                        <span class="badge bg-info-transparent">Toàn thời gian</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-6">
    <div class="card custom-card hrm-main-card secondary">
        <div class="card-body">
            <div class="d-flex align-items-top">
                <div class="me-3">
                    <span class="avatar bg-info">
                        <i class="fa-solid fa-box fs-18"></i>
                    </span>
                </div>
                <div class="flex-fill">
                    <span class="fw-semibold text-muted d-block mb-2">Số Tài Khoản Đã Đăng</span>
                    <h5 class="fw-semibold mb-2"><?= format_cash($VCD->num_rows("SELECT * FROM `product_nick` ")) ?>
                        <div class="spinner" style="display: none;">
                            <i class="fas fa-spinner fa-spin"></i>
                        </div>
                    </h5>
                    <p class="mb-0">
                        <span class="badge bg-info-transparent">Toàn thời gian</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Số Acc Đã Bán -->
<div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-6">
    <div class="card custom-card hrm-main-card warning">
        <div class="card-body">
            <div class="d-flex align-items-top">
                <div class="me-3">
                    <span class="avatar bg-warning">
                        <i class="fa-solid fa-box-open fs-18"></i>
                    </span>
                </div>
                <div class="flex-fill">
                    <span class="fw-semibold text-muted d-block mb-2">Số Acc Đã Bán</span>
                    <h5 class="fw-semibold mb-2"><?= format_cash($VCD->num_rows("SELECT * FROM `accountrb` WHERE `status`='2' AND MONTH(time) = $month")) ?>
                        <div class="spinner" style="display: none;">
                            <i class="fas fa-spinner fa-spin"></i>
                        </div>
                    </h5>
                    <p class="mb-0">
                        <span class="badge bg-warning-transparent">Tháng <?= $month; ?></span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Số Acc Đã Bán -->
<div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-6">
    <div class="card custom-card hrm-main-card warning">
        <div class="card-body">
            <div class="d-flex align-items-top">
                <div class="me-3">
                    <span class="avatar bg-warning">
                        <i class="fa-solid fa-box-open fs-18"></i>
                    </span>
                </div>
                <div class="flex-fill">
                    <span class="fw-semibold text-muted d-block mb-2">Số Nick Order Đã Bán</span>
                    <h5 class="fw-semibold mb-2"><?= format_cash($VCD->num_rows("SELECT * FROM `accountorder` WHERE `status`='2' AND MONTH(time) = $month")) ?>
                        <div class="spinner" style="display: none;">
                            <i class="fas fa-spinner fa-spin"></i>
                        </div>
                    </h5>
                    <p class="mb-0">
                        <span class="badge bg-warning-transparent">Tháng <?= $month; ?></span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Số Acc Đã Bán -->
<div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-6">
    <div class="card custom-card hrm-main-card warning">
        <div class="card-body">
            <div class="d-flex align-items-top">
                <div class="me-3">
                    <span class="avatar bg-warning">
                        <i class="fa-solid fa-box-open fs-18"></i>
                    </span>
                </div>
                <div class="flex-fill">
                    <span class="fw-semibold text-muted d-block mb-2">Số Nick Order Đã Bán</span>
                    <h5 class="fw-semibold mb-2"><?= format_cash($VCD->num_rows("SELECT * FROM `orders` WHERE `display`='1' AND MONTH(createdate) = $month")) ?>
                        <div class="spinner" style="display: none;">
                            <i class="fas fa-spinner fa-spin"></i>
                        </div>
                    </h5>
                    <p class="mb-0">
                        <span class="badge bg-warning-transparent">Tháng <?= $month; ?></span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Số Tiền Acc Đã Bán -->
<div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-6">
    <div class="card custom-card hrm-main-card danger">
        <div class="card-body">
            <div class="d-flex align-items-top">
                <div class="me-3">
                    <span class="avatar bg-danger">
                        <i class="fa-solid fa-money-bill-wave fs-18"></i>
                    </span>
                </div>
                <div class="flex-fill">
                    <span class="fw-semibold text-muted d-block mb-2">Số Tiền Acc Đã Bán</span>
                    <h5 class="fw-semibold mb-2"><?= format_cash($VCD->get_row("SELECT SUM(`price`) FROM `accountrb` WHERE `status` = '2'")['SUM(`price`)']); ?>đ
                        <div class="spinner" style="display: none;">
                            <i class="fas fa-spinner fa-spin"></i>
                        </div>
                    </h5>
                    <p class="mb-0">
                        <span class="badge bg-danger-transparent">Toàn thời gian</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Số Tiền Acc Đã Bán -->
<div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-6">
    <div class="card custom-card hrm-main-card danger">
        <div class="card-body">
            <div class="d-flex align-items-top">
                <div class="me-3">
                    <span class="avatar bg-danger">
                        <i class="fa-solid fa-money-bill-wave fs-18"></i>
                    </span>
                </div>
                <div class="flex-fill">
                    <span class="fw-semibold text-muted d-block mb-2">Số Tiền Nick Order Đã Bán</span>
                    <h5 class="fw-semibold mb-2"><?= format_cash($VCD->get_row("SELECT SUM(`price`) FROM `accountorder` WHERE `status` = '2'")['SUM(`price`)']); ?>đ
                        <div class="spinner" style="display: none;">
                            <i class="fas fa-spinner fa-spin"></i>
                        </div>
                    </h5>
                    <p class="mb-0">
                        <span class="badge bg-danger-transparent">Toàn thời gian</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Số Tiền Acc Đã Bán -->
<div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-6">
    <div class="card custom-card hrm-main-card danger">
        <div class="card-body">
            <div class="d-flex align-items-top">
                <div class="me-3">
                    <span class="avatar bg-danger">
                        <i class="fa-solid fa-money-bill-wave fs-18"></i>
                    </span>
                </div>
                <div class="flex-fill">
                    <span class="fw-semibold text-muted d-block mb-2">Số Tiền Đơn Tài Khoảnr Đã Bán</span>
                    <h5 class="fw-semibold mb-2"><?= format_cash($VCD->get_row("SELECT SUM(`money`) FROM `orders` WHERE `display` = '1'")['SUM(`money`)']); ?>đ
                        <div class="spinner" style="display: none;">
                            <i class="fas fa-spinner fa-spin"></i>
                        </div>
                    </h5>
                    <p class="mb-0">
                        <span class="badge bg-danger-transparent">Toàn thời gian</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Thành viên đăng ký hôm nay -->
<div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-6">
    <div class="card custom-card hrm-main-card primary">
        <div class="card-body">
            <div class="d-flex align-items-top">
                <div class="me-3">
                    <span class="avatar bg-primary">
                        <i class="fa-solid fa-users fs-18"></i>
                    </span>
                </div>
                <div class="flex-fill">
                    <span class="fw-semibold text-muted d-block mb-2">Thành viên đăng ký</span>
                    <h5 class="fw-semibold mb-2"><?= format_cash($VCD->num_rows("SELECT * FROM `users` WHERE DAY(create_date) = $day")) ?>
                        <div class="spinner" style="display: none;">
                            <i class="fas fa-spinner fa-spin"></i>
                        </div>
                    </h5>
                    <p class="mb-0">
                        <span class="badge bg-primary-transparent">Hôm nay</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Đơn hàng đã bán hôm nay -->
<div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-6">
    <div class="card custom-card hrm-main-card secondary">
        <div class="card-body">
            <div class="d-flex align-items-top">
                <div class="me-3">
                    <span class="avatar bg-info">
                        <i class="fa-solid fa-circle-check fs-18"></i>
                    </span>
                </div>
                <div class="flex-fill">
                    <span class="fw-semibold text-muted d-block mb-2">Số Acc Đã Bán</span>
                    <h5 class="fw-semibold mb-2"><?= format_cash($VCD->num_rows("SELECT * FROM `accountrb` WHERE DAY(time) = $day")) ?>
                        <div class="spinner" style="display: none;">
                            <i class="fas fa-spinner fa-spin"></i>
                        </div>
                    </h5>
                    <p class="mb-0">
                        <span class="badge bg-info-transparent">Hôm nay</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Đơn hàng đã bán hôm nay -->
<div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-6">
    <div class="card custom-card hrm-main-card secondary">
        <div class="card-body">
            <div class="d-flex align-items-top">
                <div class="me-3">
                    <span class="avatar bg-info">
                        <i class="fa-solid fa-circle-check fs-18"></i>
                    </span>
                </div>
                <div class="flex-fill">
                    <span class="fw-semibold text-muted d-block mb-2">Số Nick Order Đã Bán</span>
                    <h5 class="fw-semibold mb-2"><?= format_cash($VCD->num_rows("SELECT * FROM `accountorder` WHERE DAY(time) = $day")) ?>
                        <div class="spinner" style="display: none;">
                            <i class="fas fa-spinner fa-spin"></i>
                        </div>
                    </h5>
                    <p class="mb-0">
                        <span class="badge bg-info-transparent">Hôm nay</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Đơn hàng đã bán hôm nay -->
<div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-6">
    <div class="card custom-card hrm-main-card secondary">
        <div class="card-body">
            <div class="d-flex align-items-top">
                <div class="me-3">
                    <span class="avatar bg-info">
                        <i class="fa-solid fa-circle-check fs-18"></i>
                    </span>
                </div>
                <div class="flex-fill">
                    <span class="fw-semibold text-muted d-block mb-2">Số Đơn Tài Khoản Đã Bán</span>
                    <h5 class="fw-semibold mb-2"><?= format_cash($VCD->num_rows("SELECT * FROM `orders` WHERE DAY(createdate) = $day")) ?>
                        <div class="spinner" style="display: none;">
                            <i class="fas fa-spinner fa-spin"></i>
                        </div>
                    </h5>
                    <p class="mb-0">
                        <span class="badge bg-info-transparent">Hôm nay</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Doanh thu đơn hàng hôm nay -->
<div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 col-sm-6">
    <div class="card custom-card hrm-main-card warning">
        <div class="card-body">
            <div class="d-flex align-items-top">
                <div class="me-3">
                    <span class="avatar bg-warning">
                        <i class="fa-solid fa-triangle-exclamation fs-18"></i>
                    </span>
                </div>
                <div class="flex-fill">
                    <span class="fw-semibold text-muted d-block mb-2">Số Đơn Báo Lỗi</span>
                    <h5 class="fw-semibold mb-2"><?= format_cash($VCD->num_rows("SELECT * FROM `ticket` WHERE DAY(time) = $day")) ?>
                        <div class="spinner" style="display: none;">
                            <i class="fas fa-spinner fa-spin"></i>
                        </div>
                    </h5>
                    <p class="mb-0">
                        <span class="badge bg-warning-transparent">Hôm nay</span>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

    
                                
                    </div>
    </div>
</div>
<?php
require_once(__DIR__.'/Footer.php');
?>