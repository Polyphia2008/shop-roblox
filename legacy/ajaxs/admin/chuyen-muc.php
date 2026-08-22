<?php
define("IN_SITE", true);
require_once("../../core/DB.php");
require_once("../../core/helpers.php");
function titlecode($string) {
    $string = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
    $string = preg_replace('/[^a-zA-Z0-9]/', '', $string);
    $string = str_replace(' ', '', $string);
    $random_dau = rand(10, 99); 
    $random_cuoi = rand(10, 99);
    return $random_dau . $string . $random_cuoi;
}
if ($_POST['action'] == 'add') {
    $title = xss($_POST['title']);
     $code = titlecode($title);
      $price = xss($_POST['price']);
        $logo = xss($_POST['logo']);
    if (empty($_POST['token'])) {
        die(json_encode(['status' => '1', 'msg' => 'Vui lòng đăng nhập']));
    }
    if (!$getUser = $VCD->get_row("SELECT * FROM `users` WHERE `token` = '" . xss($_POST['token']) . "' AND `level` = '1' ")) {
        die(json_encode(['status' => '1', 'msg' => 'Chức Năng Này Chỉ Dành Cho Admin']));
    }
    if (empty($title)) {
        die(json_encode(['status' => '1', 'msg' => 'Vui Lòng Nhập tên']));
    }
  if (empty($price)) {
        die(json_encode(['status' => '1', 'msg' => 'Vui Lòng Nhập giá tiền']));
    }
  if (empty($logo)) {
        die(json_encode(['status' => '1', 'msg' => 'Vui Lòng Nhập logo']));
    }
 
    
    if (1==1) {
          $VCD->insert("chuyenmuc", [
            'title'  => $title,
          'code'  => $code,
          'price'  => $price,
              'logo'  => $logo,
               'buy'  => '0',
            'status'  => '1'
        ]);
        /* LƯU HOẠT ĐỘNG LẠI */
        $VCD->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $_SERVER['HTTP_USER_AGENT'],
            'create_date'    => gettime(),
            'action'        => 'thêm chuyên mục thành công (#' . $title . ')'
        ]);
        
        sendTele(templateTele($getUser['username']." thêm chuyên mục thành công (#" .$code . ")"));

        die(json_encode(['status' => '2', 'msg' => 'Thêm chuyên mục thành công']));
    } else {
    die(json_encode(['status' => '1', 'msg' => 'Không Thêm Được chuyên mục']));
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
    $row = $VCD->get_row("SELECT * FROM `chuyenmuc` WHERE `id` = '$id' ");
    if (!$row) {
        $data = json_encode([
            'status'    => 'error',
            'msg'       => 'Nick Này không tồn tại trong hệ thống'
        ]);
        die($data);
    }
    $isRemove = $VCD->remove("chuyenmuc", " `id` = '$id' ");
    if ($isRemove) {
        $VCD->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $_SERVER['HTTP_USER_AGENT'],
            'create_date'    => gettime(),
            'action'        => 'Xóa Nick Chứa Robux khỏi hệ thống'
         ]);
        $data = json_encode([
            'status'    => 'success',
            'msg'       => 'Xóa Nick Chứa Robux thành công'
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