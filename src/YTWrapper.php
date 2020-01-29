<?php

namespace VipIpRuClient;

use VipIpRuClient\Enum\YTType;

class YTWrapper extends SocialWrapper
{
    public function createJobLikeVideo($link, $name = "")
    {
        $type = YTType::LIKE()->getValue();
        $params = ['url' => $link];
        $service_name = $name == "" ? 'YT'." ".$name : 'YT';
        return $this->createJob($name, $type, $params);
    }

    public function createJobDislikeVideo($link, $name = "")
    {
        $type = YTType::DISLIKE()->getValue();
        $params = ['url' => $link];
        $service_name = $name == "" ? 'YT'." ".$name : 'YT';
        return $this->createJob($name, $type, $params);
    }

    public function createJobLikeComment($link, $name = "")
    {
        $type = YTType::LIKE_COMMENT()->getValue();
        $params = ['url' => $link];
        $service_name = $name == "" ? 'YT'." ".$name : 'YT';
        return $this->createJob($name, $type, $params);
    }

    public function createJobSubscribe($link, $name = "")
    {
        $type = YTType::SUBCRIBE()->getValue();
        $params = ['url' => $link];
        $service_name = $name == "" ? 'YT'." ".$name : 'YT';
        return $this->createJob($name, $type, $params);
    }
}
