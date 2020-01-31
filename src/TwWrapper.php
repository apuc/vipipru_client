<?php

namespace VipIpRuClient;

use VipIpRuClient\Enum\TwType;

class TwWrapper extends SocialWrapper
{

    public function createJobLikeTweet($link, $name = "")
    {
        $type = TwType::LIKE_TWEET()->getValue();
        $params = ['url' => $link];
        $service_name = $name == "" ? $this->info_name." ".$name : $this->info_name;
        return $this->createJob($service_name, $type, $params);
    }

    public function createJobFollowers($link, $name = "")
    {
        $type = TwType::FOLLOWERS()->getValue();
        $params = ['url' => $link];
        $service_name = $name == "" ? $this->info_name." ".$name : $this->info_name;
        return $this->createJob($service_name, $type, $params);
    }

    public function createJobRetweet($link, $name = "")
    {
        $type = TwType::RETWEET()->getValue();
        $params = ['url' => $link];
        $service_name = $name == "" ? $this->info_name." ".$name : $this->info_name;
        return $this->createJob($service_name, $type, $params);
    }

    public function createJobTweet($message, $name = "")
    {
        $type = TwType::TWEET()->getValue();
        $params = ['message' => $message];
        $service_name = $name == "" ? $this->info_name." ".$name : $this->info_name;
        return $this->createJob($service_name, $type, $params);
    }
}
