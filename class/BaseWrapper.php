<?php


namespace app\Wrapper;

use app\Wrapper\Enum\CalendarType;
use Vipip\VipIP;
use app\Wrapper\Request\Request;

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
    public $api_obj;

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
        $this->api_obj = VipIP::module($this->wrapper_type)->create($name, $type, $params);
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

    // https://vipip.ru/help/izmenenie-balansa.html
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

    // https://vipip.ru/help/poluchenie-stran-regionov-i-gorodov.html
    public function getAllGeography()
    {
        $request = new Request();
        $request->setLink('https://api.vipip.ru/v0.1/settings/placetargetlist');
        $request->setParam('access_token', $this->auth_token);
        $result = $request->get();
        return $result;
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
            return -1;
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
                    return -2;
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
                return -1;
            }
        } else {
            $this->error = "Last error: Wrong format of \$calendar, it must be 7 rows x 24 columns";
            return -2;
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
            return -1;
        }
    }

// TODO: mb add time functions that actually edit existing calendar instead of replacing it
// TODO: add get for each set? not that there is a need for now
// TODO: explain return codes and make them more consistent. mb enum to make it pretty?
// TODO: override construct methods in children to make it a bit fancier
}
