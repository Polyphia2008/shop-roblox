<?php
require_once("../core/DB.php");
require_once("../core/helpers.php");

$rowbank = $VCD->get_row("SELECT * FROM `bank` WHERE `token` = '" . check_string($_GET['token']) . "' AND `short_name` = 'VietinBank'");
if (!$rowbank) {
    echo 'Lỗi rồi';
}
$response = file_get_contents("https://api.sieuthicode.net/historyapiviettinv2/" . $rowbank['token']);
$data = json_decode($response, true);
if ($data['status'] != 'success') {
          die('Lấy dữ liệu thất bại');
}
$noidungnap = strtolower($VCD->site('noidungnap')); 
foreach ($data["transactions"] as $transaction) {
    $tid = check_string($transaction["transactionID"]);
    $amount = check_string($transaction["amount"]);
    $description = check_string($transaction["description"]);
    if (strpos(strtolower($description), $noidungnap) !== false) { 
       
$startPos = strpos(strtolower($description), strtolower($noidungnap)) + strlen($noidungnap);
$bankid = trim(substr($description, $startPos));
$bankid = explode("-", $bankid)[0];
        if ($bankid) {
            $getDon = $VCD->get_row("SELECT * FROM don_nap WHERE noidung = '$bankid'");
            if ($getDon) {
                $insertSv2 = $VCD->insert("bank_auto", array(
                    'tid'               => $tid,
                    'bank'              => 'VietinBank',
                    'user_id'           => $getDon['userid'],
                    'description'       => $description,
                    'amount'            => $amount,
                    'received'          => $amount,
                    'create_gettime'    => gettime()
                ));
                $VCD->update("don_nap", array(
                    'status' => 'thanhcong',
                ), " `id` = '" . $getDon['id'] . "' ");

                if ($insertSv2) {
                    $received = $amount;
                    $isCong = PlusCredits($getDon['userid'], $received, "Nạp tiền tự động qua VietinBank (#$tid - $description - $amount)");

                    if ($isCong) {
                     echo '[<b style="color:green">-</b>] Xử lý thành công 1 hoá đơn.  ' . $bankid . '' . PHP_EOL;
                    } 
                } 
            } 
        } 
    } 
}  