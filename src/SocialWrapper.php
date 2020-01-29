<?php


namespace VipIpRuClient;

use VipIpRuClient\Enum;

class SocialWrapper extends BaseWrapper
{
    public function __construct($auth_token)
    {
        parent::__construct($auth_token);
        $this->wrapper_type = Enum\WrapperType::SOCIAL()->getValue();
    }

    // https://vipip.ru/help/opisanie-parametrov-sozz-seti.html
    /**
     * @param integer $min Minimum age
     * @param integer $max Maximum age
     */
    public function setAge($min = 0, $max = 0)
    {
        if ($this->api_obj) {
            $tariff = $this->api_obj->getTariff();
            $tariff->age_min = $min;
            $tariff->age_max = $max;
            $this->api_obj->setTariff($tariff);
            return 1;
        } else {
            $this->error = "Last error: Job is not set";
            return -2;
        }
    }

    // https://vipip.ru/help/opisanie-parametrov-sozz-seti.html
    /**
     * @param integer $gender Requested gender
     */
    public function setGender($gender)
    {
        if ($this->api_obj) {
            $tariff = $this->api_obj->getTariff();
            $tariff->sex = $gender;
            $this->api_obj->setTariff($tariff);
            return 1;
        } else {
            $this->error = "Last error: Job is not set";
            return -2;
        }
    }

    // https://vipip.ru/help/spisok-druzey.html
    /**
     * @param integer $option_id Friends ID
     */
    public function setFriendsOptions($option_id)
    {
        if ($this->api_obj) {
            $tariff = $this->api_obj->getTariff();
            $tariff->friends_id = $option_id;
            $this->api_obj->setTariff($tariff);
            return 1;
        } else {
            $this->error = "Last error: Job is not set";
            return -2;
        }
    }
}
