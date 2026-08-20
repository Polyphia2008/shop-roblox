<?php
define("IN_SITE", true);
require_once("../../core/DB.php");
require_once("../../core/helpers.php");

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
      $row = $VCD->get_row(" SELECT * FROM `accountrb` WHERE `id` = '$id' AND `username`='".$getUser['email']."' ");
    
    if (!$row) {
        die(json_encode([
            'status'    => 'error',
            'msg'       => 'Acc này không tồn tại trong hệ thống'
        ]));
    }
      $ticket = $VCD->get_row(" SELECT * FROM `ticket` WHERE `status` = '0' AND `nickrb` = '".$row['id']."' ");
       if ($ticket) {
        die(json_encode([
            'status'    => 'error',
            'msg'       => 'Đơn đã được xử lí'
        ]));
    }


    if (1==1) {
      $VCD->update("ticket", [
    'status' => '2',
   ], " `nickrb` = '" . $row['id'] . "' ");

             $VCD->insert("logs", [
            'user_id'       => $getUser['id'],
            'ip'            => myip(),
            'device'        => $_SERVER['HTTP_USER_AGENT'],
            'create_date'    => gettime(),
            'action'        => 'Hủy report thành công (#' . $row['magd'] . ')'
        ]);
        
        sendTele(templateTele($getUser['username']." Hủy report thành công (#" .$row['magd'] . ")"));
        die(json_encode(['status' => 'success', 'msg' => ' Hủy report thành công']));
    }
}