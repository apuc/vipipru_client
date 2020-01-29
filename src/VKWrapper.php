<?php

namespace VipIpRuClient;

use VipIpRuClient\Enum\VKType;
use VipIpRuClient\Request\Request;

class VKWrapper extends SocialWrapper
{

    public function createJobJoinGroup($link, $name = "")
    {
        $type = VKType::JOIN_GROUP()->getValue();
        $params = ['url' => $link];
        $service_name = $name == "" ? $this->info_name." ".$name : $this->info_name;
        return $this->createJob($service_name, $type, $params);
    }

    public function createJobLike($link, $name = "")
    {
        $type = VKType::LIKE()->getValue();
        $params = ['url' => $link];
        $service_name = $name == "" ? $this->info_name." ".$name : $this->info_name;
        return $this->createJob($service_name, $type, $params);
    }

    public function createJobShareWithFriends($link, $name = "")
    {
        $type = VKType::SHARE_POST()->getValue();
        $params = ['url' => $link];
        $service_name = $name == "" ? $this->info_name." ".$name : $this->info_name;
        return $this->createJob($service_name, $type, $params);
    }

    public function createJobShareGroupWithFriends($link, $name = "")
    {
        $type = VKType::SHARE_GROUP()->getValue();
        $params = ['url' => $link];
        $service_name = $name == "" ? $this->info_name." ".$name : $this->info_name;
        return $this->createJob($service_name, $type, $params);
    }

    public function createJobCreatePost($message, $name = "")
    {
        $type = VKType::CREATE_POST()->getValue();
        $params = ["message" => $message];
        $service_name = $name == "" ? $this->info_name." ".$name : $this->info_name;
        return $this->createJob($service_name, $type, $params);
    }

    public function createJobShareSite($link, $name = "")
    {
        $type = VKType::SHARE_SITE()->getValue();
        $params = ["url" => $link];
        $service_name = $name == "" ? $this->info_name." ".$name : $this->info_name;
        return $this->createJob($service_name, $type, $params);
    }

    public function createJobAddFriends($link, $name = "")
    {
        $type = VKType::ADD_FRIENDS()->getValue();
        $params = ["url" => $link];
        $service_name = $name == "" ? $this->info_name." ".$name : $this->info_name;
        return $this->createJob($service_name, $type, $params);
    }

    public function createJobInstallApp($link, $name = "")
    {
        $type = VKType::INSTALL_APP()->getValue();
        $params = ["url" => $link];
        $service_name = $name == "" ? $this->info_name." ".$name : $this->info_name;
        return $this->createJob($service_name, $type, $params);
    }

    public function createJobWatchVideo($link, $name = "")
    {
        $type = VKType::WATCH_VIDEO()->getValue();
        $params = ["url" => $link];
        $service_name = $name == "" ? $this->info_name." ".$name : $this->info_name;
        return $this->createJob($service_name, $type, $params);
    }

    public function createJobWatchStream($link, $name = "")
    {
        $type = VKType::WATCH_STREAM()->getValue();
        $params = ["url" => $link];
        $service_name = $name == "" ? $this->info_name." ".$name : $this->info_name;
        return $this->createJob($service_name, $type, $params);
    }

    // must be called after getPollAnswers 'cause requires proper answerid and it ain't 1,2,3,4
    public function createJobVote($link, $answerid, $name = "")
    {
        $type = VKType::VOTE()->getValue();
        $params = ["url" => $link, 'answerid' => $answerid];
        $service_name = $name == "" ? $this->info_name." ".$name : $this->info_name;
        return $this->createJob($service_name, $type, $params);
    }

    // was forced to rewrite like this because it doesn't werk with in-box getVkPollAnswers function
    public function getPollAnswers($link)
    {
        $request = new Request();
        $request->setLink('https://vipip.ru/rest/social/pollvariants/');
        $request->setParam('url', $link);
        $result = $request->get();
        return $result;
    }
}
