<?php
require __DIR__."./vendor/autoload.php";

use Vipip\VipIP;
use app\Wrapper\TwitchWrapper;
use app\Wrapper\VKWrapper;
use app\Wrapper\Enum\TwitchType;
use app\Wrapper\Enum\VKType;
use app\Wrapper\Enum\WrapperType;

$auth_token = "2188616.uChUhinkq4dP9JZZgQtQs6ffGpm4am4d";
VipIP::init($auth_token, [
    'lang'=>'ru'
]);

$wrapper = new VKWrapper(WrapperType::SOCIAL()->getValue(), $auth_token);
$wrapper->getJob(779148);
//$answers = $wrapper->getAllGeography();
$wrapper->setGeography(null, null, ['UA']);
$i = 0;
