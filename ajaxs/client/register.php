<?php
define("IN_SITE", true);
require_once("../../core/DB.php");
require_once("../../core/helpers.php");


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (empty($_POST['email'])) {
        die(json_encode(['status' => 'error', 'msg' => 'Vui lòng nhập Email']));
    }
    if (empty($_POST['username'])) {
        die(json_encode(['status' => 'error', 'msg' => 'Vui lòng nhập tên']));
    }
    if (empty($_POST['password'])) {
        die(json_encode(['status' => 'error', 'msg' => 'Vui lòng nhập mật khẩu']));
    }
        if (empty($_POST['password_re'])) {
        die(json_encode(['status' => 'error', 'msg' => 'Vui lòng nhập mật khẩu xác nhận']));
    }
    $username = xss($_POST['username']);
    $email = xss($_POST['email']);
    $password = xss($_POST['password']);
    $password_re = xss($_POST['password_re']);
    if (check_email($email) != true) {
        die(json_encode(['status' => 'error', 'msg' => 'Định dạng Email không đúng']));
    }
    if ($VCD->num_rows("SELECT * FROM `users` WHERE `email` = '$email' ") > 0) {
        die(json_encode(['status' => 'error', 'msg' => 'Địa chỉ email đã tồn tại trong hệ thống']));
    }
      if ($password != $password_re) {
        die(json_encode(['status' => 'error', 'msg' => 'Xác nhận mật khẩu không đúng']));
    }
    if ($VCD->num_rows("SELECT * FROM `users` WHERE `ip` = '" . myip() . "' ") >= 10) {
        die(json_encode(['status' => 'error', 'msg' => 'IP của bạn đã đạt giới hạn tạo tài khoản cho phép']));
    }
    
    $token = md5(random('QWERTYUIOPASDGHJKLZXCVBNMqwertyuiopasdfghjklzxcvbnm0123456789', 6) . time());
    $isCreate = $VCD->insert("users", [
        'token'         => $token,
        'username'      => $username,
        'level' => '0',
        'email'         => $email,
        'password'      => sha1($password),
        'ip'            => myip(),
        'device'        => $_SERVER['HTTP_USER_AGENT'],
        'create_date'   => gettime(),
        'update_date'   => time(),
        'time_session'  => time()
    ]);
    if ($isCreate) {
        $VCD->insert("logs", [
            'user_id'       => $VCD->get_row("SELECT * FROM `users` WHERE `token` = '$token' ")['id'],
            'ip'            => myip(),
            'device'        => $_SERVER['HTTP_USER_AGENT'],
            'create_date'    => gettime(),
            'action'        => 'Đăng ký tài khoản thành công'
         ]);

         $VCD->update("users", [
            'time_session' => time(),
        ], " `id` = '".$VCD->get_row("SELECT * FROM `users` WHERE `token` = '$token' ")['id']."' ");

        setcookie("token", $token, time() + $VCD->site('session_login'), "/");
        $_SESSION['login'] = $token;
        sendTele(templateTele($username." đăng ký thành công"));
        die(json_encode(['status' => 'success', 'msg' => 'Đăng ký thành công']));
    } else {
        die(json_encode(['status' => 'error', 'msg' => 'Tạo tài khoản thất bại, vui lòng thử lại']));
    }
}
