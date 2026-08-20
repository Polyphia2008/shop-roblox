<?php
define("IN_SITE", true);
require_once("../../core/DB.php");
require_once("../../core/helpers.php");

if ($_POST['action'] == 'add') {
    $code = xss($_POST['code']);
    if (empty($_POST['token'])) {
        die(json_encode(['status' => '1', 'msg' => 'Vui lòng đăng nhập']));
    }
    if (!$getUser = $VCD->get_row("SELECT * FROM `users` WHERE `token` = '" . xss($_POST['token']) . "' AND `level` = '1' ")) {
        die(json_encode(['status' => '1', 'msg' => 'Chức Năng Này Chỉ Dành Cho Admin']));
    }
    if (empty($code)) {
        die(json_encode(['status' => '1', 'msg' => 'Vui Lòng Nhập Mục rate']));
    }
    } else {
    die(json_encode(['status' => '1', 'msg' => 'Không nhận được kết quả từ API']));
   }
    
    if (1==1) {
          $VCD->insert("mucrate", [
            'code'  => $code,
            'status'  => '1'
        ]);
        /* LƯU HOẠT ĐỘNG LẠI */
        $VCD->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $_SERVER['HTTP_USER_AGENT'],
            'create_date'    => gettime(),
            'action'        => 'thêm chuyên mục thành công (#' . $code . ')'
        ]);
        
        sendTele(templateTele($getUser['username']." thêm mục rate thành công (#" .$code . ")"));

        die(json_encode(['status' => '2', 'msg' => 'Thêm mục rate thành công']));
    } else {
    die(json_encode(['status' => '1', 'msg' => 'Không Thêm Được Mục rate']));
   }
   