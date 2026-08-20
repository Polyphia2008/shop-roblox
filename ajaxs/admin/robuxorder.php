<?php
define("IN_SITE", true);
require_once("../../core/DB.php");
require_once("../../core/helpers.php");

if ($_POST['action'] == 'add') {
      $rate = xss($_POST['rate']);
    $robux = xss($_POST['robux']);
        $guarantee = xss($_POST['guarantee']);
    $premium = xss($_POST['premium']);

     
    if (empty($_POST['token'])) {
        die(json_encode(['status' => '1', 'msg' => 'Vui lòng đăng nhập']));
    }
    if (!$getUser = $VCD->get_row("SELECT * FROM `users` WHERE `token` = '" . xss($_POST['token']) . "' AND `level` = '1' ")) {
        die(json_encode(['status' => '1', 'msg' => 'Chức Năng Này Chỉ Dành Cho Admin']));
    }
    
 $rowrate = $VCD->get_row(" SELECT * FROM `rateorder` WHERE `code` = '$rate' AND `status`='1' ");
    if (!$rowrate) {
        die(json_encode([
            'status'    => 'error',
            'msg'       => 'Rate Robux Không Tồn Tại!'
        ]));
    }
    $price= $rowrate['code']* $robux;

    if (1==1) {
      $VCD->insert("accountorder", [
     'seller' => $getUser['email'],
    'status' => '1',
    'rate' => $rate,
    'robux' => $robux,
    'price' => $price,
    'guarantee' => $guarantee,
    'premium' => $premium,
      ]);

        /* LƯU HOẠT ĐỘNG LẠI */
        $VCD->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $_SERVER['HTTP_USER_AGENT'],
            'create_date'    => gettime(),
            'action'        => 'thêm Nick Order Robux thành công'
        ]);
        
        die(json_encode(['status' => '2', 'msg' => 'Thêm Nick Order Robux thành công']));
    } else {
    die(json_encode(['status' => '1', 'msg' => 'Không Thêm Được Nick Order Robux']));
   }
} 

if ($_POST['action'] == 'edit') {
    $rowrate = $VCD->get_row(" SELECT * FROM `accountorder` WHERE `id` = '".xss($_POST['id'])."' AND `status`!='2' ");
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
          $status = xss($_POST['status']);
    if (empty($_POST['token'])) {
        die(json_encode(['status' => '1', 'msg' => 'Vui lòng đăng nhập']));
    }
    if (!$getUser = $VCD->get_row("SELECT * FROM `users` WHERE `token` = '" . xss($_POST['token']) . "' AND `level` = '1' ")) {
        die(json_encode(['status' => '1', 'msg' => 'Chức Năng Này Chỉ Dành Cho Admin']));
    }
    
 $rowrate = $VCD->get_row(" SELECT * FROM `rateorder` WHERE `code` = '$rate' AND `status`='1' ");
    if (!$rowrate) {
        die(json_encode([
            'status'    => 'error',
            'msg'       => 'Rate Robux Không Tồn Tại!'
        ]));
    }
    $price= $rowrate["code"]* $robux;


    if (1==1) {
      $VCD->update("accountorder", [
     'seller' => $getUser["email"],
    'status' => $status,
    'rate' => $rate,
    'robux' => $robux,
    'price' => $price,
    'guarantee' => $guarantee,
    'premium' => $premium
   ], " `id` = '" . xss($_POST['id']) . "' ");

        /* LƯU HOẠT ĐỘNG LẠI */
        $VCD->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $_SERVER['HTTP_USER_AGENT'],
            'create_date'    => gettime(),
            'action'        => 'Sửa Nick Có Robux thành công (#' . $code . ')'
        ]);
        
        sendTele(templateTele($getUser['username']." Sửa Nick Order Robux thành công (#" .$code . ")"));

        die(json_encode(['status' => '2', 'msg' => 'Sửa Nick Order robux thành công']));
    } else {
    die(json_encode(['status' => '1', 'msg' => 'Không Sửa Được Nick Order robux']));
   }
}
   
if ($_POST['action'] == 'editnick') {
    $rowrate = $VCD->get_row(" SELECT * FROM `accountorder` WHERE `id` = '".xss($_POST['id'])."' AND `status`!='2' ");
    if (!$rowrate) {
        die(json_encode([
            'status'    => 'error',
            'msg'       => 'Nick Có Robux Không Tồn Tại!'
        ]));
    }
            $tknick = xss($_POST['tknick']);
      $password = xss($_POST['password']);
     $auth2fa = xss($_POST['auth2fa']);
    if (empty($_POST['token'])) {
        die(json_encode(['status' => '1', 'msg' => 'Vui lòng đăng nhập']));
    }
    if (!$getUser = $VCD->get_row("SELECT * FROM `users` WHERE `token` = '" . xss($_POST['token']) . "' AND `level` = '1' ")) {
        die(json_encode(['status' => '1', 'msg' => 'Chức Năng Này Chỉ Dành Cho Admin']));
    }
     $information = json_encode([
    'tknick' => $tknick,
    'pass' => $password,
    '2fa' => $auth2fa,
    'dichvu' => 'order',
    'timeup' => gettime()
    ]);
    if (1==1) {
      $VCD->update("accountorder", [
   'information' => $information,
       'status'   => '2',
    'time'     => gettime()
   ], " `id` = '" . xss($_POST['id']) . "' ");

        /* LƯU HOẠT ĐỘNG LẠI */
        $VCD->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $_SERVER['HTTP_USER_AGENT'],
            'create_date'    => gettime(),
            'action'        => 'Add thông tin Nick thành công (#' . $code . ')'
        ]);
        
        sendTele(templateTele($getUser['username']." Add thông tin Nick thành công (#" .$code . ")"));

        die(json_encode(['status' => '2', 'msg' => 'Add thông tin Nick thành công']));
    } else {
    die(json_encode(['status' => '1', 'msg' => 'Không Add thông tin Nick được']));
   }
}
   
if ($_POST['action'] == 'delete') {
if (isset($_POST['id'])) {
    $getUser = $VCD->get_row(" SELECT * FROM `users` WHERE `token`='" . check_string($_POST['token']) . "' AND `level`='1'");
    if(!$getUser)
    {
        $data = json_encode([
            'status'    => 'error',
            'msg'       => 'Vui lòng đăng nhập'
        ]);
        die($data);
    }
    $id = check_string($_POST['id']);
    $row = $VCD->get_row("SELECT * FROM `accountorder` WHERE `id` = '$id' ");
    if (!$row) {
        $data = json_encode([
            'status'    => 'error',
            'msg'       => 'Nick Này không tồn tại trong hệ thống'
        ]);
        die($data);
    }
    $isRemove = $VCD->remove("accountorder", " `id` = '$id' ");
    if ($isRemove) {
        $VCD->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $_SERVER['HTTP_USER_AGENT'],
            'create_date'    => gettime(),
            'action'        => 'Xóa Nick Order Robux khỏi hệ thống'
         ]);
        $data = json_encode([
            'status'    => 'success',
            'msg'       => 'Xóa Nick Order Robux thành công'
        ]);
        die($data);
    }
} else {
    $data = json_encode([
        'status'    => 'error',
        'msg'       => 'Dữ liệu không hợp lệ'
    ]);
    die($data);
}
}