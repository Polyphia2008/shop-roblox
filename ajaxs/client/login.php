<?php
define("IN_SITE", true);
require_once("../../core/DB.php");
require_once("../../core/helpers.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (empty($_POST['email'])) {
        die(json_encode([
            'status'    => 'error',
            'msg'       => 'Vui lòng nhập Email'
        ]));
    }
    if (empty($_POST['password'])) {
        die(json_encode([
            'status'    => 'error',
            'msg'       => 'Vui lòng nhập mật khẩu'
        ]));
    }
    $email = xss($_POST['email']);
    $password = xss($_POST['password']);
    if (check_email($email) != true) {
        die(json_encode(['status' => 'error', 'msg' => 'Định dạng Email không đúng']));
    }
    $getUser = $VCD->get_row("SELECT * FROM `users` WHERE `email` = '$email' AND `password`='".sha1($password)."' ");
    if (!$getUser) {
        die(json_encode([
            'status'    => 'error',
            'msg'       => 'Sai email hoặc mật khẩu'
        ]));
    }
   if (time() > $getUser['time_request'] && (time() - $getUser['time_request']) < $config['max_time_load']) {
    die(json_encode([
        'status' => 'error',
        'msg' => 'Bạn thao tác quá nhanh'
    ]));
    }
    if ($getUser['banned'] == 1) {
        die(json_encode([
            'status'    => 'error',
            'msg'       => 'Tài khoản của bạn đã bị khoá truy cập'
        ]));
    }
     
    $VCD->insert("logs", [
        'user_id'       => $getUser['id'],
        'ip'            => myip(),
        'device'        => $_SERVER['HTTP_USER_AGENT'],
        'create_date'    => gettime(),
        'action'        => 'Đăng nhập thành công vào hệ thống'
     ]);
    $VCD->update("users", [
        'ip' => myip(),
        'time_session' => time(),
        'time_request'  => time(),
        'device' => $_SERVER['HTTP_USER_AGENT']
    ], " `id` = '".$getUser['id']."' ");

    setcookie("token", $getUser['token'], time() + $VCD->site('session_login'), "/");
    $_SESSION['login'] = $getUser['token'];
    sendTele(templateTele($username." đăng nhập thành công"));
    die(json_encode([
        'status' => 'success',
        'msg'    => 'Đăng nhập thành công'
    ]));
}
