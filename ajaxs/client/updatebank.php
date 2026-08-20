<?php
define("IN_SITE", true);
require_once("../../core/DB.php");
require_once("../../core/helpers.php");
require_once("../../core/is_user.php");

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['userId']) && isset($data['randomCode'])) {
    $userId = $data['userId'];
    $randomCode = $data['randomCode'];
     $VCD->insert("don_nap", [
                'userid'    => $userId,
                'noidung'   => $randomCode,
                'status'   => 'xuly',
            ]);
} else {
    // Trả về phản hồi lỗi nếu không đủ dữ liệu
    echo json_encode(['success' => false]);
}

?>
