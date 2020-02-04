<?php


namespace VipIpRuClient;

use Vipip\RequestException;
use Vipip\Service\Social;
use Vipip\VipIP;
use VipIpRuClient\Enum\CalendarType;
use VipIpRuClient\Enum\StatusType;
use VipIpRuClient\Enum\WrapperType;
use VipIpRuClient\Request\Request;

class BaseWrapper
{
    protected $auth_token;
    /**
     * @var string Wrapper type
     */
    protected $wrapper_type;
    /**
     * @var string e.g. contains name like VkType for fancier calls
     */
    protected $info_type;
    /**
     * @var string e.g. contains name like VK for fancier errors
     */
    protected $info_name;
    /**
     * @var null|string Last error
     */
    protected $error;

    public function getError(): string
    {
        return $this->error;
    }

    /**
     * @var null|Social current job;
     */
    protected $api_obj;

    /**
     * @var VipIp\Service\Settings\Tariff Either Social or Link Tariff
     */
    protected $tariff;

    /**
     * @param string $auth_token Auth token
     */
    public function __construct($auth_token)
    {
        $this->api_obj = null;
        $this->auth_token = $auth_token;
        VipIP::init($auth_token, [
            'lang'=>'ru'
        ]);
        $this->info_name = explode('\\', explode('W', get_class($this))[0])[1];
        $this->info_type = $this->info_name.'Type';
    }

    /**
     * @param integer $id Job ID, it's type must be one of the Twitch's otherwise result is null
     */
    public function getJob($id)
    {
        $api_obj = VipIP::module($this->wrapper_type)->getOne($id);
        if ($api_obj) {
            $tariff = $api_obj->getTariff();
            $values = call_user_func("VipIpRuClient\\Enum\\$this->info_type::values");
            if (in_array($tariff->id, $values)) {
                $this->api_obj = $api_obj;
                return 1;
            } else {
                $this->error = "Last error: Job with {$id} is not $this->info_name job";
                $this->api_obj = null;
                return -1;
            }
        } else {
            $this->error = "Last error: Job with {$id} is not found";
            $this->api_obj = null;
            return -1;
        }
    }

    protected function createJob($name, $type, $params)
    {
        try {
            $this->api_obj = VipIP::module($this->wrapper_type)->create($name, $type, $params);
        }
        catch (RequestException $e) {
            $this->error = $e->getMessage();
            return -1;
        }
        return 1;
    }

    /**
     * @return int
     */
    public function getJobBalance()
    {
        if ($this->api_obj) {
            return new $this->api_obj->balance;
        } else {
            $this->error = "Last error: Job is not set";
            return -2;
        }
    }

    // https://vipip.ru/help/izmenenie-balansa.html
    /**
     * @param integer $views Amount of views to cheat in currency
     * @param string $balance_type Currency type
     */
    public function setJobBalance($views, $balance_type)
    {
        if ($this->api_obj) {
            if (!$this->api_obj->changeBalance($views, $balance_type)) {
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
     * @return int|StatusType
     */
    public function getJobStatus()
    {
        if ($this->api_obj) {
            return new StatusType($this->api_obj->status);
        } else {
            $this->error = "Last error: Job is not set";
            return -2;
        }
    }

    // https://vipip.ru/help/vklyuchenie-i-viklyuchenie.html
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
     * @return int
     */
    public function getTariff()
    {
        if ($this->api_obj) {
            $this->tariff = $this->api_obj->getTariff();
            return 1;
        } else {
            $this->error = "Last error: Job is not set";
            return -1;
        }
    }

    /**
     * @return int
     */
    public function saveTariff()
    {
        if ($this->api_obj) {
            if (isset($this->tariff)) {
                $this->api_obj->setTariff($this->tariff);
                return 1;
            }
            else {
                $this->error = "Last error: Tariff is not set";
                return -1;
            }
        } else {
            $this->error = "Last error: Job is not set";
            return -1;
        }
    }

    // https://vipip.ru/help/poluchenie-stran-regionov-i-gorodov.html
    public function getAllGeography()
    {
        $request = new Request();
        $request->setLink('https://api.vipip.ru/v0.1/settings/placetargetlist');
        $request->setParam('access_token', $this->auth_token);
        $result = $request->get();
        return $result;
    }

    /**
     * @return null|Vipip\Service\Settings\Geo geo of a job
     */
    public function getGeography()
    {
        if ($this->api_obj) {
            return $this->api_obj->getGeo();
        } else {
            $this->error = "Last error: Job is not set";
            return null;
        }
    }

    // https://vipip.ru/help/dobavlenie-geografii.html
    // Should be called after getAllGeography 'cause ids are a bit ambiguous
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
            return -2;
        }
    }

    // https://vipip.ru/help/poluchenie-chasovikh-poyasov.html
    public function getTimezones()
    {
        $request = new Request();
        $request->setLink('https://api.vipip.ru/v0.1/settings/timezone');
        $request->setParam('access_token', $this->auth_token);
        $result = $request->get();
        return $result;
    }

    /**
     * @return Vipip\Service\Settings\Calendar calendar of a job
     */
    public function getCalendar()
    {
        if ($this->api_obj) {
            return $this->api_obj->getCalendar();
        } else {
            $this->error = "Last error: Job is not set";
            return null;
        }
    }

    /**
     * @param $timezone_id integer Id of timezone, look into getTimezones
     * @param $calendar array Array of arrays. Sunday is first. If type is by week then format is like described here https://vipip.ru/help/poluchenie-kalendarya.html .
     * NOTE: method gets existing calendar, clears it, sets type = 2 and then writes contents of $calendar to it
     */
    public function setCalendarByWeek($timezone_id, $calendar)
    {
        if (count($calendar) == 7) {
            foreach (range(0, 6) as $row) {
                if (count($calendar[$row]) != 24) {
                    $this->error = "Last error: Wrong format of \$calendar, it must be 7 rows x 24 columns";
                    return -1;
                }
            }
            if ($this->api_obj) {
                $cal = $this->api_obj->getCalendar();
                $cal->clear();
                $cal->setType(CalendarType::WEEK()->getValue());
                foreach (range(0, 6) as $day) {
                    foreach (range(0, 23) as $hour) {
                        $cal->setWeekDay($day, $hour, $calendar[$day][$hour]);
                    }
                }
                $cal->setTimeZone_Id($timezone_id);
                $this->api_obj->setCalendar($cal);
                return 1;
            } else {
                $this->error = "Last error: no Job set";
                return -2;
            }
        } else {
            $this->error = "Last error: Wrong format of \$calendar, it must be 7 rows x 24 columns";
            return -1;
        }
    }

    // TODO: mb change required $calendar format to be a bit more fancy, fashionable and actually usable? mb jk
    /**
     * @param $timezone_id integer Id of timezone, look into getTimezones
     * @param $calendar array Entries should look like [date_string(Y-m-d) => visits]. E.g. ['2019-12-31' => 100]
     *  If date is not set then it's views are unlimited
     *  NOTE: method gets existing calendar, clears it, sets type = 3 and then writes contents of $calendar to it
     */
    public function setCalendarByDates($timezone_id, $calendar)
    {
        if ($this->api_obj) {
            $cal = $this->api_obj->getCalendar();
            $cal->clear();
            $cal->setType(CalendarType::MONTH()->getValue());
            // TODO: mb there must be some ind of check for format of keys of $calendar
            foreach ($calendar as $date => $visitors) {
                $date_parts = explode('-', $date);
                $year = intval($date_parts[0]);
                $month = intval($date_parts[1]);
                $day = intval($date_parts[2]);
                $cal->setMonthDay($day, $month, $year, $visitors);
            }
            $cal->setTimeZone_Id($timezone_id);
            $this->api_obj->setCalendar($cal);
        } else {
            $this->error = "Last error: no Job set";
            return -2;
        }
    }

    /**
     * @return int|string
     */
    public function getTitle()
    {
        if ($this->api_obj) {
            return $this->api_obj->title;
        } else {
            $this->error = "Last error: no Job set";
            return -2;
        }
    }

    /**
     * @return int
     */
    public function setTitle($title)
    {
        // AFAIK, save() replaces specified attrs only
        if ($this->api_obj) {
            $this->api_obj->save(['title' => $title]);
            return 1;
        } else {
            $this->error = "Last error: no Job set";
            return -2;
        }
    }

    /**
     * @return int|string
     */
    public function getLinkId()
    {
        if ($this->api_obj) {
            return $this->api_obj->linkid;
        } else {
            $this->error = "Last error: no Job set";
            return -2;
        }
    }

// TODO: replace int result codes with constants? or maybe raise exceptions?
// TODO: add more getters for crucial info
// TODO: batch getJob using getList from VipIp SDK
// TODO: mb add time functions that actually edit existing calendar instead of replacing it
// TODO: explain return codes and make them more consistent. mb enum to make it pretty?
//TODO: mb restructure some of setters using builder pattern?
}
