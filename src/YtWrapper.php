<?php

namespace VipIpRuClient;

use VipIpRuClient\Enum\YtType;

class YtWrapper extends SocialWrapper
{
    public function createJobLikeVideo($link, $name = "")
    {
        $type = YtType::LIKE()->getValue();
        $params = ['url' => $link];
        $service_name = $name == "" ? 'YT'." ".$name : 'YT';
        return $this->createJob($name, $type, $params);
    }

    public function createJobDislikeVideo($link, $name = "")
    {
        $type = YtType::DISLIKE()->getValue();
        $params = ['url' => $link];
        $service_name = $name == "" ? 'YT'." ".$name : 'YT';
        return $this->createJob($name, $type, $params);
    }

    public function createJobLikeComment($link, $name = "")
    {
        $type = YtType::LIKE_COMMENT()->getValue();
        $params = ['url' => $link];
        $service_name = $name == "" ? 'YT'." ".$name : 'YT';
        return $this->createJob($name, $type, $params);
    }

    public function createJobSubscribe($link, $name = "")
    {
        $type = YtType::SUBCRIBE()->getValue();
        $params = ['url' => $link];
        $service_name = $name == "" ? 'YT'." ".$name : 'YT';
        return $this->createJob($name, $type, $params);
    }
}
