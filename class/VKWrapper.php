<?php

namespace app\Wrapper;

use app\Wrapper\Enum\BalanceType;
use app\Wrapper\Enum\TwitchType;
use app\Wrapper\Enum\VKType;
use Vipip\VipIP;

class VKWrapper extends BaseWrapper
{

    public function createJobJoinGroup($link, $name = "")
    {
        $type = VKType::JOIN_GROUP()->getValue();
        $params = ['url' => $link];
        return $this->createJob($name, $type, $params);
    }

    public function createJobLike($link, $name = "")
    {
        $type = VKType::LIKE()->getValue();
        $params = ['url' => $link];
        return $this->createJob($name, $type, $params);
    }

    public function createJobShareWithFriends($link, $name = "")
    {
        $type = VKType::SHARE_POST()->getValue();
        $params = ['url' => $link];
        return $this->createJob($name, $type, $params);
    }

    public function createJobShareGroupWithFriends($link, $name = "")
    {
        $type = VKType::SHARE_GROUP()->getValue();
        $params = ['url' => $link];
        return $this->createJob($name, $type, $params);
    }

    public function createJobCreatePost($message, $name = "")
    {
        $type = VKType::CREATE_POST()->getValue();
        $params = ["message" => $message];
        return $this->createJob($name, $type, $params);
    }

    public function createJobShareSite($link, $name = "")
    {
        $type = VKType::SHARE_SITE()->getValue();
        $params = ["url" => $link];
        return $this->createJob($name, $type, $params);
    }

    public function createJobAddFriends($link, $name = "")
    {
        $type = VKType::ADD_FRIENDS()->getValue();
        $params = ["url" => $link];
        return $this->createJob($name, $type, $params);
    }

    public function createJobInstallApp($link, $name = "")
    {
        $type = VKType::INSTALL_APP()->getValue();
        $params = ["url" => $link];
        return $this->createJob($name, $type, $params);
    }

    public function createJobWatchVideo($link, $name = "")
    {
        $type = VKType::WATCH_VIDEO()->getValue();
        $params = ["url" => $link];
        return $this->createJob($name, $type, $params);
    }

    public function createJobWatchStream($link, $name = "")
    {
        $type = VKType::WATCH_STREAM()->getValue();
        $params = ["url" => $link];
        return $this->createJob($name, $type, $params);
    }

    // must be called after getPollAnswers 'cause requires proper answerid and it ain't 1,2,3,4
    public function createJobVote($link, $answerid, $name = "")
    {
        $type = VKType::VOTE()->getValue();
        $params = ["url" => $link, 'answerid' => $answerid];
        return $this->createJob($name, $type, $params);
    }

    // was forced to rewrite like this because it doesn't werk with in-box getVkPollAnswers function
    public function getPollAnswers($link)
    {
        $base_link = 'https://vipip.ru/rest/social/pollvariants/?url=';
        $full_link = $base_link.$link;
        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $full_link);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($handle);
        curl_close($handle);
        $result = json_decode($output);
        return $result;
    }

    public function getJob($id)
    {
        $api_obj = VipIP::module($this->wrapper_type)->getOne($id);
        if ($api_obj) {
            $tariff = $api_obj->getTariff();
            if (in_array($tariff->id, VKType::values())) {
                $this->api_obj = $api_obj;
                //$this->link = $this->api_obj->getLinkId();
                return 1;
            } else {
                $this->error = "Last error: Job with {$id} is not Twitch job";
                return -1;
            }
        } else {
            $this->error = "Last error: Job with {$id} is not found";
            return -2;
        }
    }
}
