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
        die(json_encode(['status' => '1', 'msg' => 'Vui Lòng Nhập Rate Order']));
    }
    } else {
    die(json_encode(['status' => '1', 'msg' => 'Không nhận được kết quả từ API']));
   }
    
    if (1==1) {
          $VCD->insert("rateorder", [
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
        

        die(json_encode(['status' => '2', 'msg' => 'Thêm Rate Order thành công']));
    } else {
    die(json_encode(['status' => '1', 'msg' => 'Không Thêm Được Rate Order']));
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
    $row = $VCD->get_row("SELECT * FROM `rateorder` WHERE `id` = '$id' ");
    if (!$row) {
        $data = json_encode([
            'status'    => 'error',
            'msg'       => 'Rate Order không tồn tại trong hệ thống'
        ]);
        die($data);
    }
    $isRemove = $VCD->remove("rateorder", " `id` = '$id' ");
    if ($isRemove) {
        $VCD->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $_SERVER['HTTP_USER_AGENT'],
            'create_date'    => gettime(),
            'action'        => 'Xóa Rate Order khỏi hệ thống'
         ]);
        $data = json_encode([
            'status'    => 'success',
            'msg'       => 'Xóa Rate Order thành công'
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