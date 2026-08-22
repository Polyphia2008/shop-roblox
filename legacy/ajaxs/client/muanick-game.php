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
     $soluong = xss($_POST['soluong']);
    $row = $VCD->get_row(" SELECT * FROM `chuyenmuc` WHERE `id` = '$id' AND `status`='1' ");
    if (!$row) {
        die(json_encode([
            'status'    => 'error',
            'msg'       => 'Mục này không tồn tại trong hệ thống'
        ]));
    }
        if (empty($soluong)) {
       
         die(json_encode([
            'status'    => 'error',
            'msg'       => 'Vui lòng nhập số lượng'
        ]));
    }
$nick_con = $VCD->num_rows("SELECT * FROM `product_nick` WHERE (`magd` IS NULL OR `magd` = '') AND (`username` IS NULL OR `username` = '') AND `chuyenmuc` = '".$row['id']."'");
 if ($nick_con < $soluong) {
      die(json_encode([
            'status'    => 'error',
            'msg'       => 'Số lượng acc không đủ. Vui lòng chọn dưới '.$nick_con.' nick'
        ]));
    }
    $total = $row['price'] * $soluong;
   
    if ($total > $getUser['money']) {
      die(json_encode([
            'status'    => 'error',
            'msg'       => 'Số dư của bạn không đủ'
        ]));
    }
       $isMoney = $VCD->tru("users", "money", $total, " `email` = '" . $getUser['email'] . "' ");
if ($isMoney) {
    $magd_chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $magd = randomnick($magd_chars, 3) . rand(1000000000, 9999999999);
    
 for ($i = 0; $i < $soluong; $i++) {
    $random_choice = rand(1, 3);
    if ($random_choice == 1) {
        $order_by = "ORDER BY id ASC";
    } elseif ($random_choice == 2) {
        $order_by = "ORDER BY id DESC";
    } else {
        $order_by = "ORDER BY ABS(id - (SELECT MAX(id) FROM product_nick)) ";
    }

    $VCD->update("product_nick", array(
        'username' => $getUser['email'],
        'status'   => 'offline',
        'magd'     => $magd, 
        'updated_time' => gettime(),
    ), " `chuyenmuc` = {$row['id']} AND (`magd` IS NULL OR `magd` = '') AND (`username` IS NULL OR `username` = '') $order_by LIMIT 1");
}


    $VCD->insert("orders", array(
        'magd'   => $magd, 
        'username' => $getUser['email'],
        'money'     => $total,
        'createdate' => gettime(),
        'type'       => $row['id'],
        'title'      => $row['title'],
        'display'    => 1,
        'soluong'       => $soluong
    ));

    $VCD->insert("dongtien", array(
        'sotientruoc'   => $getUser['money'],
        'sotienthaydoi' => $total,
        'sotiensau'     => $getUser['money'] - $total,
        'thoigian'      => gettime(),
        'noidung'       => 'Mua Nick Game (#' . $magd . ')',  
        'username'      => $getUser['email']
    ));
notiTele("🔔 Báo Cáo #{$magd} 🔔\nThanh toán {$soluong} nick với tổng tiền " . format_cash($total) . 'đ thành công! Lúc: ' . date('d/m/Y H:i:s'), $getUser['telegram']);

    // Thông báo kết quả
    die(json_encode([
        'status'    => 'success',
        'msg'       => 'Thanh toán '.$soluong .' nick với tổng tiền '.format_cash($total).'đ thành công'
    ]));
}

}
