<?php
require __DIR__."./vendor/autoload.php";

use Vipip\VipIP;
use app\Wrapper\TwitchWrapper;
use app\Wrapper\VKWrapper;
use app\Wrapper\Enum\TwitchType;
use app\Wrapper\Enum\VKType;

$auth_token = "2188616.uChUhinkq4dP9JZZgQtQs6ffGpm4am4d";
VipIP::init($auth_token, [
    'lang'=>'ru'
]);

$wrapper = new VKWrapper();
//$wrapper->getJob(779148);
$answers = $wrapper->getPollAnswers("https://vk.com/poll-190900980_361260722");
$k = $wrapper->createJobVote("https://vk.com/poll-190900980_361260722", $answers->answers[0]->id);
$i = 0;
