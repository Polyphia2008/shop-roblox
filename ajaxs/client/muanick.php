<?php
define("IN_SITE", true);
require_once("../../core/DB.php");
require_once("../../core/helpers.php");
require_once("../../core/is_user.php");


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (empty($_POST['token'])) {
       
         die(json_encode([
            'status'    => 'error',
            'msg'       => 'Vui lòng đăng nhập'
        ]));
    }
    if (!$getUser = $VCD->get_row("SELECT * FROM `users` WHERE `token` = '" . xss($_POST['token']) . "' AND `banned` = '0' ")) {
         
         die(json_encode([
            'status'    => 'error',
            'msg'       => 'Vui lòng đăng nhập'
        ]));
    }

    $id = xss($_POST['id']);
    $row = $VCD->get_row(" SELECT * FROM `accountrb` WHERE `id` = '$id' AND `status`='1' ");
    if (!$row) {
        die(json_encode([
            'status'    => 'error',
            'msg'       => 'Acc này không tồn tại trong hệ thống'
        ]));
    }
  if (empty($row['username'] === NULL || $row['username'] === "" || $row['magd'] === NULL || $row['magd'] === "")) {
    die(json_encode([
        'status' => 'error',
        'msg'    => 'Acc này không tồn tại trong hệ thống'
    ]));
}

    $total = $row['price'];
   
    if ($total > $getUser['money']) {
      die(json_encode([
            'status'    => 'error',
            'msg'       => 'Số dư của bạn không đủ'
        ]));
    }
       $isMoney = $VCD->tru("users", "money", $total, " `email` = '" . $getUser['email'] . "' ");
    if ($isMoney) {
        /* GHI LOG DÒNG TIỀN */
  
        
         $VCD->insert("dongtien", array(
            'sotientruoc'   => $getUser['money'],
            'sotienthaydoi' => $total,
            'sotiensau'     => $getUser['money'] - $total,
            'thoigian'      => gettime(),
            'noidung'       => 'Mua Nick Có Robux (#' . $row['id'] . ')',
            'username'      => $getUser['email']
        ));


        $magd = random('ABCDEFGHIJKLMNOPQRSTUVWXYZ', 3) . rand(1000000000, 9999999999);

     $VCD->update("accountrb", array(
    'username' => $getUser['email'],
    'status'   => '2',
    'magd'     => $magd,
    'time'     => gettime(),
), " `id` = {$row['id']} ");


        

      notiTele("🔔 Báo Cáo #{$magd} 🔔\nThanh toán đơn tài khoản robux với giá " . format_cash($total) . 'đ thành công! Lúc: ' . date('d/m/Y H:i:s'), $getUser['telegram']);

        die(json_encode([
            'status'    => 'success',
            'msg'       => 'Thanh toán thành công'
        ]));
    }
}
