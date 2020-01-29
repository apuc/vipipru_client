<?php

namespace VipIpRuClient;

use VipIpRuClient\Enum\RTType;

class RTWrapper extends SocialWrapper
{
    public function createJobLikeVideo($link, $name = "")
    {
        $type = RTType::LIKE()->getValue();
        $params = ['url' => $link];
        $service_name = $name == "" ? 'YT'." ".$name : 'YT';
        return $this->createJob($name, $type, $params);
    }

    public function createJobDislikeVideo($link, $name = "")
    {
        $type = RTType::DISLIKE()->getValue();
        $params = ['url' => $link];
        $service_name = $name == "" ? 'YT'." ".$name : 'YT';
        return $this->createJob($name, $type, $params);
    }

    public function createJobWatchVideo($link, $name = "")
    {
        $type = RTType::WATCH()->getValue();
        $params = ['url' => $link];
        $service_name = $name == "" ? 'YT'." ".$name : 'YT';
        return $this->createJob($name, $type, $params);
    }

    public function createJobSubscribe($link, $name = "")
    {
        $type = RTType::SUBCRIBE()->getValue();
        $params = ['url' => $link];
        $service_name = $name == "" ? 'YT'." ".$name : 'YT';
        return $this->createJob($name, $type, $params);
    }
}
