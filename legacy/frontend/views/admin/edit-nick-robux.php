<?php 
if (!defined('IN_SITE')) {
    die('The Request Not Found');
}

$title = 'Chỉnh sửa Nick Có Robux | ' . $VCD->site('title');
$body = [
    'title' => 'Chỉnh Sửa Nick Có Robux'
];
$body['header'] = '';
$body['footer'] = '';
require_once(__DIR__.'/Header.php');
require_once(__DIR__.'/Navbar.php');
require_once(__DIR__ . '/../../../core/is_user.php');
CheckLogin();
CheckAdmin();

if (isset($_GET['id'])) {
    $row = $VCD->get_row("SELECT * FROM `accountrb` WHERE `id` = '" . check_string($_GET['id']) . "'");
    if (!$row) {
        die("Dữ liệu không tồn tại");
    }
} else {
    die("Thiếu thông tin ID");
}
$data = json_decode($row['information'], true);
?>
<div class="main-content app-content">
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <h1 class="page-title fw-semibold fs-18 mb-0">Chỉnh sửa nick có robux</h1>
        </div>

        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <h5 class="card-title">CHỈNH SỬA NICK CÓ ROBUX</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data" id="editNickForm">
                            <input type="hidden" value="<?=$getUser['token']?>" name="token" id="token">
                            <input type="hidden" value="edit" name="action" id="action">
                            <input type="hidden" value="<?=$row['id']?>" name="id" id="id">
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Chọn Rate Robux: <span class="text-danger">*</span></label>
                                <div class="col-sm-9 mb-2">
                                    <select class="form-control" id="rate" name="rate" required>
                                        <option value="">-- Chọn Rate --</option>
                                        <?php foreach ($VCD->get_list("SELECT * FROM `mucrate`") as $tgdev) { ?>
                                            <option value="<?=$tgdev['code'];?>" <?=($tgdev['code'] == $row['rate']) ? 'selected' : '';?>><?=$tgdev['code'];?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Số Robux</label>
                                <div class="col-sm-9 mb-2">
                                    <input type="number" id="robux" name="robux" class="form-control" value="<?=$row['robux']?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Giá bán</label>
                                <div class="col-sm-9 mb-2">
                                    <input type="number" id="price" name="price" class="form-control" value="<?=$row['price']?>" readonly>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Bảo hành</label>
                                <div class="col-sm-9 mb-2">
                                    <select class="form-control" id="guarantee" name="guarantee">
                                        <option value="4" <?=($row['premium'] == '4') ? 'selected' : '';?>>4 Phút</option>
                                        <option value="5" <?=($row['premium'] == '5') ? 'selected' : '';?>>5 Phút</option>
                                           <option value="6" <?=($row['premium'] == '6') ? 'selected' : '';?>>6 Phút</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Premium</label>
                                <div class="col-sm-9 mb-2">
                                    <select class="form-control" id="premium" name="premium">
                                        <option value="1" <?=($row['premium'] == '1') ? 'selected' : '';?>>Có</option>
                                        <option value="0" <?=($row['premium'] == '0') ? 'selected' : '';?>>Không</option>
                                    </select>
                                </div>
                            </div>
                             <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Status</label>
                                <div class="col-sm-9 mb-2">
                                    <select class="form-control" id="status" name="status">
                                        <option value="1" <?=($row['status'] == '1') ? 'selected' : '';?>>Hiển Thị</option>
                                        <option value="0" <?=($row['status'] == '0') ? 'selected' : '';?>>Ẩn</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Ngày tham gia</label>
                                <div class="col-sm-9 mb-2">
                                    <input type="text" id="datejoin" name="datejoin" class="form-control" value="<?=$row['datejoin']?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Tài Khoản Robux</label>
                                <div class="col-sm-9 mb-2">
                                    <input type="text" id="tknick" name="tknick" class="form-control" value="<?=$data['tknick'];?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Mật Khẩu Robux</label>
                                <div class="col-sm-9 mb-2">
                                    <input type="text" id="password" name="password" class="form-control" value="<?= $data['pass']?>" required>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-3 col-form-label">Mã 2FA Auth (Nếu có)</label>
                                <div class="col-sm-9 mb-2">
                                    <input type="text" id="auth2fa" name="auth2fa" class="form-control" value="<?=$data['2fa']?>">
                                </div>
                            </div>
                            <button type="submit" id="SuaTaiKhoan" class="btn btn-primary btn-block">
                                <span>CẬP NHẬT</span>
                            </button>
                            <a href="/admin/nick-robux" class="btn btn-danger btn-block">
                                <span>TRở LẠI</span>
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    function updatePrice() {
        const rate = parseFloat(document.getElementById('rate').value) || 0;
        const robux = parseFloat(document.getElementById('robux').value) || 0;
        document.getElementById('price').value = rate * robux;
    }

    document.getElementById('rate').addEventListener('change', updatePrice);
    document.getElementById('robux').addEventListener('input', updatePrice);

    $("#editNickForm").on('submit', function(e) {
        e.preventDefault();
        const formData = $(this).serialize();

        $('#SuaTaiKhoan').html('Loading...').prop('disabled', true);

        $.ajax({
            url: '<?=BASE_URL('ajaxs/admin/edit_nick_robux.php')?>',
            type: 'POST',
            dataType: "json",
            data: formData,
            success: function(response) {
                if (response.status == '2') {
                    showMessageDucapi(response.msg, "success");
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                } else {
                    showMessageDucapi(response.msg, "error");
                }
                $('#SuaTaiKhoan').html('CẬP NHẬT').prop('disabled', false);
            }
        });
    });
</script>
<?php 
    require_once(__DIR__ . "/Footer.php");
?>
