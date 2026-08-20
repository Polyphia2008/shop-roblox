<?php
define("IN_SITE", true);
require_once("../../core/DB.php");
require_once("../../core/helpers.php");

if ($_POST['action'] == 'edit') {
    $rowrate = $VCD->get_row(" SELECT * FROM `accountrb` WHERE `id` = '".xss($_POST['id'])."' AND `status`!='2' ");
    if (!$rowrate) {
        die(json_encode([
            'status'    => 'error',
            'msg'       => 'Nick Có Robux Không Tồn Tại!'
        ]));
    }
      $rate = xss($_POST['rate']);
    $robux = xss($_POST['robux']);
        $guarantee = xss($_POST['guarantee']);
    $premium = xss($_POST['premium']);
    $datejoin = xss($_POST['datejoin']);
        $tknick = xss($_POST['tknick']);
      $password = xss($_POST['password']);
     $auth2fa = xss($_POST['auth2fa']);
          $status = xss($_POST['status']);
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
    $price= $rowrate["code"]* $robux;
  $information = json_encode([
    'tknick' => $tknick,
    'pass' => $password,
    '2fa' => $auth2fa,
     'dichvu' => 'nick',
    'timeup' => gettime()
    ]);

    if (1==1) {
      $VCD->update("accountrb", [
     'seller' => $getUser["email"],
    'status' => $status,
    'rate' => $rate,
    'robux' => $robux,
    'price' => $price,
    'guarantee' => $guarantee,
    'premium' => $premium,
    'datejoin' => $datejoin,
    'information' => $information,
   ], " `id` = '" . xss($_POST['id']) . "' ");

        /* LƯU HOẠT ĐỘNG LẠI */
        $VCD->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $_SERVER['HTTP_USER_AGENT'],
            'create_date'    => gettime(),
            'action'        => 'Sửa Nick Có Robux thành công (#' . $code . ')'
        ]);
        
        sendTele(templateTele($getUser['username']." Sửa Nick Có robux thành công (#" .$code . ")"));

        die(json_encode(['status' => '2', 'msg' => 'Sửa Nick Có robux thành công']));
    } else {
    die(json_encode(['status' => '1', 'msg' => 'Không Sửa Được Nick Có robux']));
   }
   