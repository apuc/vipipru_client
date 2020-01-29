<?php

namespace VipIpRuClient;

use app\Wrapper\Enum\TwitchType;
use Vipip\VipIP;

class TwitchWrapper extends BaseWrapper
{
    /**
     * @param string $name Custom string to append to service name
     */
    public function createJobWatch($name = "")
    {
        if ($this->link) {
            $params = ['url' => $this->link];
            $type = TwitchType::WATCH()->value();
            $service_name = $name == "" ? 'Twitch'." ".$name : 'Twitch';
            return $this->createJob($service_name, $type, $params);
        } else {
            $this->error = "Link is not set";
            return -1;
        }
    }

    /**
     * @param integer $id Job ID, it's type must be one of the Twitch's otherwise result is null
     */
    public function getJob($id)
    {
        $api_obj = VipIP::module('social')->getOne($id);
        if ($api_obj) {
            $tariff = $api_obj->getTariff();
            if (in_array($tariff->id, TwitchType::values())) {
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
