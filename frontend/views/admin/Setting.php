<?php
if (!defined('IN_SITE')) {
    die('The Request Not Found');
}
$title = 'Cài Đặt Hệ Thống | ' . $VCD->site('title');
$body = [
    'title' => 'Dashboard'
];
$body['header'] = '';
$body['footer'] = '';
require_once(__DIR__ . '/Header.php');
require_once(__DIR__ . '/Navbar.php');
require_once(__DIR__ . '/../../../core/is_user.php');
CheckLogin();
CheckAdmin();
?>

<?php
if (isset($_POST['SaveSettings']) && $getUser['level'] == 1) {
      if ($VCD->site('status_demo') != 0) {
        die('<script type="text/javascript"> showMessage("Không được dùng chức năng này vì đây là trang web demo", "error"); setTimeout(function(){ window.location.href = ""; }, 2000);</script>');
    }
    foreach ($_POST as $key => $value) {
        $VCD->update("settings", array(
            'value' => $value
        ), " `name` = '$key' ");
    }
    die('<script type="text/javascript">if(!alert("Lưu thành công !")){window.history.back().location.reload();}</script>');
} ?>
<?php
if (isset($_POST['SaveThongBao']) && $getUser['level'] == 1) {
    if ($VCD->site('status_demo') != 0) {
        die('<script type="text/javascript"> showMessage("Không được dùng chức năng này vì đây là trang web demo", "error"); setTimeout(function(){ window.location.href = ""; }, 2000);</script>');
    }
    foreach ($_POST as $key => $value) {
        
        $VCD->update("settings", array(
            'value' => base64_encode($value)
        ), " `name` = '$key' ");
    }
    die('<script type="text/javascript">if(!alert("Lưu thành công !")){window.history.back().location.reload();}</script>');
}
?>
<div class="main-content app-content">
    <div class="container-fluid">
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <h1 class="page-title fw-semibold fs-18 mb-0"><i class="fa-solid fa-gear"></i> Cài đặt</h1>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-xl-2">
                                <nav class="nav nav-tabs flex-column nav-style-5 mb-3" role="tablist">
                                    <a class="nav-link active" data-bs-toggle="tab" role="tab" aria-current="page"
                                        href="#cai-dat-chung" aria-selected="false"><i
                                            class="bx bx-cog me-2 align-middle d-inline-block"></i>Cài đặt chung</a>
                                    <a class="nav-link" data-bs-toggle="tab" role="tab" aria-current="page"
                                        href="#ket-noi" aria-selected="false"><i
                                            class="bx bx-plug me-2 align-middle d-inline-block"></i>Kết nối</a>
                                     <a class="nav-link" data-bs-toggle="tab" role="tab" aria-current="page"
                                        href="#thong-bao" aria-selected="false"><i
                                            class="bx bx-plug me-2 align-middle d-inline-block"></i>Thông báo</a>
                                   
                                   
                                </nav>
                            </div>
                            <div class="col-xl-10">
                                <div class="tab-content">
                                    <div class="tab-pane text-muted show active" id="cai-dat-chung" role="tabpanel">
                                        <h4>Cài đặt chung</h4>
                                        <form action="" method="POST">
                                            <div class="row push mb-3">
                                                <div class="col-md-6">
                                                    <table class="table table-bordered table-striped table-hover">
                                                        <tbody>
                                                            
                                                             <tr>
                                                                <td>Title</td>
                                                                <td>
                                                                    <input type="text" name="title"
                                                                        value="<?= $VCD->site('title') ?>"
                                                                        class="form-control">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Description</td>
                                                                <td>
                                                                    <textarea name="description"
                                                                        class="form-control"><?= $VCD->site('description') ?></textarea>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Keywords</td>
                                                                <td>
                                                                    <textarea name="keywords"
                                                                        class="form-control"><?= $VCD->site('keywords') ?></textarea>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Author</td>
                                                                <td>
                                                                    <input type="text" name="author"
                                                                        value="<?= $VCD->site('author') ?>"
                                                                        class="form-control">
                                                                </td>
                                                            </tr>
                                                            
                                                            <tr>
                                                                <td>Email</td>
                                                                <td>
                                                                    <input type="text" name="email"
                                                                        value="<?= $VCD->site('email') ?>"
                                                                        class="form-control">
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Hotline</td>
                                                                <td>
                                                                    <input type="text" name="hotline"
                                                                        value="<?= $VCD->site('hotline') ?>"
                                                                        class="form-control">
                                                                </td>
                                                            </tr>
                                                           <tr>
                                                                <td>Fanpage</td>
                                                                <td>
                                                                    <input type="text" name="fanpage"
                                                                        value="<?= $VCD->site('link_facebook') ?>"
                                                                        class="form-control">
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="col-md-6">
                                                    <table class="table table-bordered table-striped table-hover">
                                                        <tbody>
                                                          
                                                              <tr>
                                                                <td>Logo</td>
                                                                <td>
                                                                    <div class="input-group">
                                                                    <input type="text" name="logo"
                                                                        value="<?= $VCD->site('logo') ?>"
                                                                        class="form-control">
                                                                        </div>
                                                                        
                                                                </td>
                                                            </tr>
                                                              <tr>
                                                                <td>favicon</td>
                                                                <td>
                                                                    <div class="input-group">
                                                                    <input type="text" name="favicon"
                                                                        value="<?= $VCD->site('favicon') ?>"
                                                                        class="form-control">
                                                                        </div>
                                                                        <small>Icon nhỏ ở tab nhé</small>
                                                                </td>
                                                            </tr>
                                                              <tr>
                                                                <td>Ảnh giới thiệu</td>
                                                                <td>
                                                                    <div class="input-group">
                                                                    <input type="text" name="anhbia"
                                                                        value="<?= $VCD->site('anhbia') ?>"
                                                                        class="form-control">
                                                                        </div>
                                                                        <small>Ảnh Bìa Ở Ngoài ( cũng là ảnh khi share lên các mxh)</small>
                                                                </td>
                                                            </tr>
                                                           
                                                         
                                                         

                                                            <tr>
                                                                <td>Thời gian lưu đăng nhập</td>
                                                                <td>
                                                                    <div class="input-group">
                                                                        <input name="session_login" type="text" class="form-control" value="<?= $VCD->site('session_login') ?>" required>
                                                                
                                                                    </div>
                                                                    <small>Tính bằng giây (2592000 =
                                                        4 tuần)</small>
                                                                </td>
                                                            </tr>
                                                             
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <button type="submit" name="SaveSettings"
                                                class="btn btn-primary w-100 mb-3">
                                                <i class="fa fa-fw fa-save me-1"></i> Save                                            </button>
                                        </form> </div>
                                           <div class="tab-pane text-muted" id="thong-bao" role="tabpanel">
                                        <h4>Thông Báo</h4>
                                        <form action="" method="POST">
                                            <div class="row push mb-3">
                                                <div class="col-md-12">
                                                    <table class="table table-bordered table-striped table-hover">
                                                        <tbody>
                                                            <tr>
                                                                <td>Thông Báo chạy </td>
                                                                <td>
                                                                    <textarea id="notice_home"
                                                    name="notification"> <?= base64_decode($VCD->site('notification')) ?> </textarea>
                                                                </td>
                                                            </tr>
                                                        
                                                            <tr>
                                                                <td>Chế độ bảo hành</td>
                                                                <td>
                                                                    <textarea id="popup_noti"
                                                                        name="baohanh"><p> <?= base64_decode($VCD->site('baohanh')) ?>
</textarea>
                                                                </td>
                                                            </tr>
                                                           
                                                            <tr>
                                                                <td>Cách sử dụng bot</td>
                                                                <td>
                                                                    <textarea id="page_policy"
                                                                        name="sudungbot"> <?= base64_decode($VCD->site('sudungbot')) ?>
</textarea>
                                                                </td>
                                                            </tr>
<tr>
                                                                <td>Hướng dẫn sử dụng report</td>
                                                                <td>
                                                                    <textarea id="popup_report"
                                                                        name="report"><p> <?= base64_decode($VCD->site('report')) ?>
</textarea>
                                                                </td>
                                                            </tr>
                                                           
                                                            <tr>
                                                                <td>Hướng dẫn login acc có 2FA Auth</td>
                                                                <td>
                                                                    <textarea id="p2falog"
                                                                        name="2falog"> <?= base64_decode($VCD->site('2falog')) ?>
</textarea>
                                                                </td>
                                                            </tr>
                                                        
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <button type="submit" name="SaveThongBao"
                                                class="btn btn-primary w-100 mb-3">
                                                <i class="fa fa-fw fa-save me-1"></i> Save                                            </button>
                                        </form>
                                    </div>  
                                    <div class="tab-pane text-muted" id="ket-noi" role="tabpanel">
                                        <h4>Kết nối</h4>
                                        <form action="" method="POST">
                                            <div class="row push mb-3">
                                                
                                                <div class="col-md-12">
                                                    <table class="mb-3 table table-bordered table-striped table-hover">
                                                        <thead class="table-dark">
                                                            <tr>
                                                                <th colspan="2" class="text-center">
                                                                    <img src="https://zshopclone7.cmsnt.net/assets/img/icon-bot-telegram.avif"
                                                                        width="25px"> Bot Telegram                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            
                                                            <tr>
                                                                <td>Telegram Token Thông báo</td>
                                                                <td>
                                                                    <input type="text" name="telegram_token"
                                                                        value="<?= $VCD->site('token_telegram') ?>"
                                                                        class="form-control">
                                                                    <small><a class="text-primary" 
                                                                            href="https://help.cmsnt.co/huong-dan/huong-dan-tich-hop-bot-telegram-vao-shopclone7/"
                                                                            target="_blank">Xem hướng dẫn</a></small>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Telegram Chat ID thông báo</td>
                                                                <td>
                                                                    <input type="text" name="chat_id_telegram"
                                                                        value="<?= $VCD->site('chat_id_telegram') ?>"
                                                                        class="form-control">
                                                                    <small><a class="text-primary"
                                                                            href="https://help.cmsnt.co/huong-dan/huong-dan-tich-hop-bot-telegram-vao-shopclone7/"
                                                                            target="_blank">Xem hướng dẫn</a></small>
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td>Telegram Token Check Đơn</td>
                                                                <td>
                                                                    <input type="text" name="token_bot_tele"
                                                                        value="<?= $VCD->site('token_bot_tele') ?>"
                                                                        class="form-control">
                                                                    <small class="text-primary" >https://api.telegram.org/bot<?= $VCD->site('token_bot_tele') ?>/setWebhook?url=https://<?=$_SERVER['HTTP_HOST'];?>/botcheck</small>
                                                                </td>
                                                            </tr>
                                                                                                                  <tr>
                                                                <td>Link Bot tele Check Đơn</td>
                                                                <td>
                                                                    <input type="text" name="link_bot_tele"
                                                                        value="<?= $VCD->site('link_bot_tele') ?>"
                                                                        class="form-control">
                                                                  
                                                                </td>
                                                            </tr>
                                                               <tr>
                                                                <td>Noti telegram cho thành viên</td>
                                                                <td>
                                                                    <textarea  name="noti_telegram"
                                                                        value="<?= $VCD->site('noti_telegram') ?>" placeholder="Viết thông báo gửi đến telegram cho mỗi thành viên nếu cần" style="width: 100%; height: 100px;"></textarea>

                                                                    <small class="text-primary"><a href="https://<?=$_SERVER['HTTP_HOST'];?>/botcheck/notification" class="text-primary" target="_blank">Sao khi lưu xong ấn vào đây sẽ hoạt động </a>
</small>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                   

                                                </div>
                                                <div class="col-md-6">
                                                    <table class="table table-bordered table-striped table-hover">
                                                        <tbody>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <button type="submit" name="SaveSettings"
                                                class="btn btn-primary w-100 mb-3">
                                                <i class="fa fa-fw fa-save me-1"></i> Save                                            </button>
                                        </form>
                                    </div>
                                
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
    function validateMinValue(input) {
        if (input.value < 1) {
            input.value = 1;
        }
    }
</script>
          
<?php
require_once(__DIR__ . '/Footer.php');
?>
<script>
     
CKEDITOR.replace("popup_noti");
CKEDITOR.replace("page_policy");
CKEDITOR.replace("page_contact");
CKEDITOR.replace("notice_home");
CKEDITOR.replace("popup_report");
CKEDITOR.replace("p2falog");
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get the active tab from Local Storage
    var activeTab = localStorage.getItem('activeTab');
    if (activeTab) {
        // Show the saved tab
        $('.nav-tabs a[href="#' + activeTab + '"]').tab('show');
    }

    // Save the selected tab to Local Storage
    $('.nav-tabs a').on('shown.bs.tab', function(e) {
        var selectedTab = $(e.target).attr('href').substr(1);
        localStorage.setItem('activeTab', selectedTab);
    });
});
</script>