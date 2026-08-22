<?php 
require_once __DIR__ . '/../../../core/is_user.php';
CheckLogin();

if( isset($_GET['magd']) )
{
    $magd = check_string($_GET['magd']);

    $orders = $VCD->get_row("SELECT * FROM `orders` WHERE `magd` = '" . $magd . "' AND `username` = '".$getUser['email']."'");

    if (!$orders) {
        die('Đơn hàng không tồn tại hoặc không thuộc về bạn.');
    }

    $nicks = $VCD->get_list("SELECT * FROM `product_nick` WHERE `username` = '".$getUser['email']."' AND `magd` = '" . $magd . "'");

    $clone = ''; 

    foreach ($nicks as $nick) {
        $note = trim($nick['note']);
        
        if (!empty($note)) {
            $clone .= $note . PHP_EOL;
        }
    }

    $clone = rtrim($clone, PHP_EOL);

    $file = $magd . ".txt";  

    $txt = fopen($file, "w") or die("Unable to open file!");

    fwrite($txt, $clone);
    fclose($txt);

    header('Content-Description: File Transfer');
    header('Content-Disposition: attachment; filename='.basename($file));
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    header("Content-Type: text/plain");
    readfile($file);
    unlink($file);
}
?>
