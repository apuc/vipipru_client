<?php

namespace VipIpRuClient;

use VipIpRuClient\Enum\RtType;

class RtWrapper extends SocialWrapper
{
    public function createJobLikeVideo($link, $name = "")
    {
        $type = RtType::LIKE()->getValue();
        $params = ['url' => $link];
        $service_name = $name == "" ? 'YT'." ".$name : 'YT';
        return $this->createJob($name, $type, $params);
    }

    public function createJobDislikeVideo($link, $name = "")
    {
        $type = RtType::DISLIKE()->getValue();
        $params = ['url' => $link];
        $service_name = $name == "" ? 'YT'." ".$name : 'YT';
        return $this->createJob($name, $type, $params);
    }

    public function createJobWatchVideo($link, $name = "")
    {
        $type = RtType::WATCH()->getValue();
        $params = ['url' => $link];
        $service_name = $name == "" ? 'YT'." ".$name : 'YT';
        return $this->createJob($name, $type, $params);
    }

    public function createJobSubscribe($link, $name = "")
    {
        $type = RtType::SUBCRIBE()->getValue();
        $params = ['url' => $link];
        $service_name = $name == "" ? 'YT'." ".$name : 'YT';
        return $this->createJob($name, $type, $params);
    }
}
