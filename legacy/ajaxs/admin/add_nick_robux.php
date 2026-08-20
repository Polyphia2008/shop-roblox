<?php
define("IN_SITE", true);
require_once("../../core/DB.php");
require_once("../../core/helpers.php");

if ($_POST['action'] == 'add') {
      $rate = xss($_POST['rate']);
    $robux = xss($_POST['robux']);
        $guarantee = xss($_POST['guarantee']);
    $premium = xss($_POST['premium']);
    $datejoin = xss($_POST['datejoin']);
        $tknick = xss($_POST['tknick']);
      $password = xss($_POST['password']);
     $auth2fa = xss($_POST['auth2fa']);
     
    if (empty($_POST['token'])) {
        die(json_encode(['status' => '1', 'msg' => 'Vui lòng đăng nhập']));
    }
    if (!$getUser = $VCD->get_row("SELECT * FROM `users` WHERE `token` = '" . xss($_POST['token']) . "' AND `level` = '1' ")) {
        die(json_encode(['status' => '1', 'msg' => 'Chức Năng Này Chỉ Dành Cho Admin']));
    }
    } else {
    die(json_encode(['status' => '1', 'msg' => 'Không nhận được kết quả từ API']));
   }
 $rowrate = $VCD->get_row(" SELECT * FROM `mucrate` WHERE `code` = '$rate' AND `status`='1' ");
    if (!$rowrate) {
        die(json_encode([
            'status'    => 'error',
            'msg'       => 'Rate Robux Không Tồn Tại!'
        ]));
    }
    $price= $rowrate['code']* $robux;
  $information = json_encode([
    'tknick' => $tknick,
    'pass' => $password,
    '2fa' => $auth2fa,
    'dichvu' => 'nick',
    'timeup' => gettime()
    ]);

    if (1==1) {
      $VCD->insert("accountrb", [
     'seller' => $getUser['email'],
    'status' => '1',
    'rate' => $rate,
    'robux' => $robux,
    'price' => $price,
    'guarantee' => $guarantee,
    'premium' => $premium,
    'datejoin' => $datejoin,
    'information' => $information,
      ]);

        /* LƯU HOẠT ĐỘNG LẠI */
        $VCD->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $_SERVER['HTTP_USER_AGENT'],
            'create_date'    => gettime(),
            'action'        => 'thêm Nick Có Robux thành công (#' . $code . ')'
        ]);
        
        sendTele(templateTele($getUser['username']." thêm Nick Có robux thành công (#" .$code . ")"));

        die(json_encode(['status' => '2', 'msg' => 'Thêm Nick Có robux thành công']));
    } else {
    die(json_encode(['status' => '1', 'msg' => 'Không Thêm Được Nick Có robux']));
   }
   