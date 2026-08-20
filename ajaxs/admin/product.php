<?php
define("IN_SITE", true);
require_once("../../core/DB.php");
require_once("../../core/helpers.php");
if ($_POST['action'] == 'add') {
    $thongtin = xss($_POST['note']);
    $loai = xss($_POST['loai']);
    
    // Kiểm tra token người dùng
    if (empty($_POST['token'])) {
        die(json_encode(['status' => '1', 'msg' => 'Vui lòng đăng nhập']));
    }
    
    // Kiểm tra quyền admin
    if (!$getUser = $VCD->get_row("SELECT * FROM `users` WHERE `token` = '" . xss($_POST['token']) . "' AND `level` = '1' ")) {
        die(json_encode(['status' => '1', 'msg' => 'Chức Năng Này Chỉ Dành Cho Admin']));
    }
    
    // Kiểm tra thông tin
    if (empty($thongtin)) {
        die(json_encode(['status' => '1', 'msg' => 'Vui Lòng nhập thông tin']));
    }
    if (empty($loai)) {
        die(json_encode(['status' => '1', 'msg' => 'Vui Lòng chọn loại']));
    }
    
    // Lấy thông tin chuyên mục
    $chuyenmuc = $VCD->get_row("SELECT * FROM `chuyenmuc` WHERE `id` = '$loai'");
    $row = $VCD->get_row("SELECT * FROM `product_nick` WHERE `chuyenmuc` = '$loai'");
    $id_random_acc = $chuyenmuc['code'];

    // Xử lý thông tin tài khoản
    $lines = explode("\n", $_POST['note']);
    if (!empty($lines)) {
        $countadd = 0;
        $success = true;

        foreach ($lines as $line) {
            $existing_account = $VCD->get_row("SELECT * FROM `product_nick` WHERE `note` = '$line' AND `chuyenmuc` = '$loai'");

            // Nếu tài khoản không tồn tại thì mới thêm
            if (!$existing_account) {
                $VCD->insert("product_nick", [
                    'note' => $line,
                    'code' => $id_random_acc,
                    'status' => 'live',
                     'seller' => $getUser['username'],
                    'chuyenmuc' => $loai
                ]);
                $countadd++;
                
                $VCD->insert("logs", [
                    'user_id' => $getUser['id'],
                    'ip' => myip(),
                    'device' => $_SERVER['HTTP_USER_AGENT'],
                    'create_date' => gettime(),
                    'action' => 'thêm tài khoản thành công (#' . $line . ')'
                ]);

                sendTele(templateTele($getUser['username']." thêm tài khoản thành công (#" .$line . ")"));
            }
        }
        
        if ($countadd > 0) {
            die(json_encode(['status' => '2', 'msg' => 'Thêm ' . format_cash($countadd) . ' tài khoản thành công']));
        } else {
            die(json_encode(['status' => '1', 'msg' => 'Không có tài khoản nào được thêm, có thể vì tài khoản đã tồn tại']));
        }
    } else {
        die(json_encode(['status' => '1', 'msg' => 'Không Thêm Được tài khoản']));
    }
} else {
    die(json_encode(['status' => '1', 'msg' => 'Không nhận được kết quả từ API']));
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
    $row = $VCD->get_row("SELECT * FROM `product_nick` WHERE `id` = '$id' ");
    if (!$row) {
        $data = json_encode([
            'status'    => 'error',
            'msg'       => 'Nick Này không tồn tại trong hệ thống'
        ]);
        die($data);
    }
    $isRemove = $VCD->remove("product_nick", " `id` = '$id' ");
    if ($isRemove) {
        $VCD->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $_SERVER['HTTP_USER_AGENT'],
            'create_date'    => gettime(),
            'action'        => 'Xóa Nick  khỏi hệ thống'
         ]);
        $data = json_encode([
            'status'    => 'success',
            'msg'       => 'Xóa Nickthành công'
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
} else {
    die(json_encode(['status' => '1', 'msg' => 'Không nhận được kết quả từ API']));
   }