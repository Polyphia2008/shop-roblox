<?php

if (isset($_GET['id']) && $_GET['id'] == 'noti') {
    $users = $VCD->get_list("SELECT * FROM `users` WHERE `banned` = '0' AND `telegram` IS NOT NULL AND `telegram` != ''");
    foreach ($users as $userGuest) {
        $telegramId = $userGuest['telegram'];  
        notiTele($VCD->site('noti_telegram'), $telegramId);  
    }
}

$data = file_get_contents('php://input');

class Bot {
    private $bot=NULL;
    function __construct($token){
        $this->bot = $token;
    }
    public function sendMessage($chatId, $text, $reply=""){
        return $this->GET('sendMessage?chat_id='.$chatId.'&text='.urlencode($text).'&reply_to_message_id='.$reply.'&allow_sending_without_reply=true')["ok"];
    }
    private function GET($param){
        $url = "https://api.telegram.org/bot".$this->bot."/".$param;
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $resp = curl_exec($curl);
        curl_close($curl);
        return json_decode($resp,1);
    }
}
$bot_token = $VCD->site('token_bot_tele');
$bot = new Bot($bot_token);

$json = json_decode($data, true);

if (isset($json['message']['text'])) {
    $message = $json['message']['text'];
    $chatId = $json['message']['chat']['id'];
    $messageId = $json['message']['message_id'];

    if (strpos($message, '/ma') === 0) {
        $notification = trim(str_replace('/ma', '', $message));

     if (!empty($notification)) {
    $telegram = $json['message']['from']['id'];
    $VCD->update("users", [
        'telegram' => $telegram,
    ], " `id` = '" . $notification . "' ");

    $bot->sendMessage($chatId, "Cập nhật thành công!", $messageId, 'HTML');
}

    }
}
?>
