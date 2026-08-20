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
        $reasontype = xss($_POST['reasontype']);
          $dichvu = xss($_POST['dichvu']);
          $lydo = xss($_POST['lydo']);
    $row = $VCD->get_row(" SELECT * FROM `accountrb` WHERE `id` = '$id' AND `username`='".$getUser['email']."' ");
    
    if (!$row) {
        die(json_encode([
            'status'    => 'error',
            'msg'       => 'Acc này không tồn tại trong hệ thống'
        ]));
    }
      $ticket = $VCD->get_row(" SELECT * FROM `ticket` WHERE `nickrb` = '".$row['id']."' ");
       if ($ticket) {
        die(json_encode([
            'status'    => 'error',
            'msg'       => 'Bạn đã gửi hỗ trợ rồi'
        ]));
    }
    
  if (empty($reasontype || $lydo)) {
    die(json_encode([
        'status' => 'error',
        'msg'    => ' không được bỏ trống nhe'
    ]));
}
$time_row = strtotime($row['time']);
$time_limit = $time_row + 600; 

if (time() > $time_limit) { 
    die(json_encode([
        'status' => 'error',
        'msg'    => 'Thời gian gửi đã quá 10 phút!'
    ]));
}
   
    if (1==1) {
      
   $VCD->insert("ticket", array(
            'type'   => $reasontype,
              'dichvu'   => $dichvu,
            'status' => '1',
            'nickrb'     => $row['id'],
            'time'      => gettime(),
            'lydo'      => $lydo
        ));
   /* LƯU HOẠT ĐỘNG LẠI */
        $VCD->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $_SERVER['HTTP_USER_AGENT'],
            'create_date'    => gettime(),
            'action'        => 'Gửi report thành công (#' . $row['magd'] . ')'
        ]);
        
        sendTele(templateTele($getUser['username']." Gửi report thành công (#" .$row['magd'] . ")"));

        

      
        die(json_encode([
            'status'    => 'success',
            'msg'       => 'Gửi báo lỗi thành công'
        ]));
    }
}
