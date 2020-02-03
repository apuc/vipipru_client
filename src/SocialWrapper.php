<?php


namespace VipIpRuClient;

use VipIpRuClient\Enum;
use VipIpRuClient\Request\Request;

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
            if (!isset($this->tariff)) {
                $this->getTariff();
            }
            $this->tariff->age_min = $min;
            $this->tariff->age_max = $max;
            return 1;
        } else {
            $this->error = "Last error: Job is not set";
            return -2;
        }
    }

    // https://vipip.ru/help/opisanie-parametrov-sozz-seti.html
    /**
     * @param string $gender Requested gender
     */
    public function setGender($gender)
    {
        if ($this->api_obj) {
            if (!isset($this->tariff)) {
                $this->getTariff();
            }
            $this->tariff->sex = $gender;
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
            if (!isset($this->tariff)) {
                $this->getTariff();
            }
            $this->tarifftariff->setFriends_Id($option_id);
            return 1;
        } else {
            $this->error = "Last error: Job is not set";
            return -2;
        }
    }

    public function getSocialOptions()
    {
        $request = new Request();
        $request->setLink('https://vipip.ru/rest/social/settings/');
        $result = $request->get();
        return $result;
    }
}
