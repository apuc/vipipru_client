<?php

namespace VipIpRuClient;

use VipIpRuClient\Enum\TwitterType;

class TwitterWrapper extends SocialWrapper
{

    public function createJobLikeTweet($link, $name = "")
    {
        $type = TwitterType::LIKE_TWEET()->getValue();
        $params = ['url' => $link];
        $service_name = $name == "" ? $this->info_name." ".$name : $this->info_name;
        return $this->createJob($service_name, $type, $params);
    }

    public function createJobFollowers($link, $name = "")
    {
        $type = TwitterType::FOLLOWERS()->getValue();
        $params = ['url' => $link];
        $service_name = $name == "" ? $this->info_name." ".$name : $this->info_name;
        return $this->createJob($service_name, $type, $params);
    }

    public function createJobRetweet($link, $name = "")
    {
        $type = TwitterType::RETWEET()->getValue();
        $params = ['url' => $link];
        $service_name = $name == "" ? $this->info_name." ".$name : $this->info_name;
        return $this->createJob($service_name, $type, $params);
    }

    public function createJobTweet($message, $name = "")
    {
        $type = TwitterType::TWEET()->getValue();
        $params = ['message' => $message];
        $service_name = $name == "" ? $this->info_name." ".$name : $this->info_name;
        return $this->createJob($service_name, $type, $params);
    }
}
