<?php


namespace app\Wrapper;

use app\Wrapper\Enum\WrapperType;
use Vipip\VipIP;

class BaseWrapper
{
    protected $auth_token;
    /**
     * @var string Wrapper type
     */
    protected $wrapper_type;
    /**
     * @var string Last error
     */
    protected $error;

    /**
     * @return string
     */
    public function getError(): string
    {
        return $this->error;
    }

    /**
     * @var \Vipip\Service\Social current job;
     */
    protected $api_obj;

    /**
     * @param string $wrapper_type Wrapper type
     */
    public function __construct($wrapper_type, $auth_token)
    {
        $this->api_obj = null;
        $this->wrapper_type = $wrapper_type;
        $this->auth_token = $auth_token;
    }

    protected function createJob($name, $type, $params)
    {
        $service_name = $name == "" ? 'VK' . " " . $name : 'VK';
        $this->api_obj = VipIP::module($this->wrapper_type)->create($service_name, $type, $params);
        return 1;
    }

    /**
     * @param integer $id Job ID, it's type must be one of the VK's otherwise result is null
     */
    public function getJob($id)
    {
        $api_obj = VipIP::module($this->wrapper_type)->getOne($id);
        if ($api_obj) {
            $this->api_obj = $api_obj;
        } else {
            $this->error = "Last error: Job with {$id} is not found";
            return -2;
        }
    }

    // TODO: mb restructure following methods with builder pattern?

    /**
     * @param integer $views Amount of views to cheat in currency
     * @param string $view_type Currency type
     */
    public function setJobViews($views, $view_type)
    {
        if ($this->api_obj) {
            if (!$this->api_obj->changeBalance($views, $view_type)) {
                $this->error = "Last error: " . $this->api_obj->getLastError() . PHP_EOL;
                return -1;
            } else {
                return 1;
            }
        } else {
            $this->error = "Last error: Job is not set";
            return -2;
        }
    }

    /**
     * @param string $status Disabled or enabled
     */
    public function setJobStatus($status)
    {
        if ($this->api_obj) {
            if (!$this->api_obj->changeStatus($status)) {
                $this->error = "Last error: " . $this->api_obj->getLastError() . PHP_EOL;
                return -1;
            } else {
                return 1;
            }
        } else {
            $this->error = "Last error: Job is not set";
            return -2;
        }
    }

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

    public function getAllGeography()
    {
        $base_link = 'https://api.vipip.ru/v0.1/settings/placetargetlist?access_token=';
        $full_link = $base_link . $this->auth_token;
        $handle = curl_init();
        curl_setopt($handle, CURLOPT_URL, $full_link);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec($handle);
        curl_close($handle);
        $result = json_decode($output);
        return $result;
    }

    /**
     * @param integer_array|null $cities Optional array of integers containing selected cities
     * @param integer_array|null $regions Optional array of integers containing selected regions
     * @param integer_array|null $countries Optional array of integers containing selected countries
     */
    public function setGeography($cities = null, $regions = null, $countries = null)
    {
        if ($this->api_obj) {
            $geo = $this->api_obj->getGeo();
            if ($cities) $geo->setCities($cities);
            if ($regions) $geo->setRegions($regions);
            if ($countries) $geo->setCountries($countries);
            $this->api_obj->setGeo($geo);
            return 1;
        } else {
            $this->error = "Last error: no Job set";
            return -1;
        }
    }

    // TODO: add time (including timezone?)
    // TODO: add referer and inputpoint interaction
    // TODO: mb class for curl requests is worth it. mb using trait?
    // TODO: add get for each set
    // TODO: explain return code and make them more consistent. mb enum to make it pretty?
}
