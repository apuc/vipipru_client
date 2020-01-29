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
$wrapper->getJob(779153);
//$wrapper->setInputPoints(['https://www.php.net/manual/en/function.explode.php'], ['1']);
//$wrapper->setCalendarByDates(4, ['2020-02-01' => 10, '2020-02-27' => 15]);
//$wrapper->getJob(779148);
//$answers = $wrapper->getTimezones();
//$wrapper->setGeography(null, null, ['UA']);
//$answers = $wrapper->getPollAnswers('https://vk.com/poll-116039030_328886683');
$i = 0;
