<?php

namespace app\Wrapper;

use app\Wrapper\Enum\YTType;
use Vipip\VipIP;

class YtWrapper extends BaseWrapper
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

    /**
     * @param integer $id Job ID, it's type must be one of the Twitch's otherwise result is null
     */
    public function getJob($id)
    {
        $api_obj = VipIP::module('social')->getOne($id);
        if ($api_obj) {
            $tariff = $api_obj->getTariff();
            if (in_array($tariff->id, YTType::values())) {
                $this->api_obj = $api_obj;
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
