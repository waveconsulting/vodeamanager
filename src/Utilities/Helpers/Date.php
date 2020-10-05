<?php

if (!function_exists('round_date')) {
    /**
     * @param $year
     * @param $month
     * @param $day
     * @param string $roundType ceil|floor
     *
     * @return string
     */
    function round_date($year, $month, $day, $roundType = 'ceil') {
        $date = new DateTime("$year-$month-01");
        if ($day > 28 && $day > $date->format('t')) {
            if ($roundType == 'floor') {
                return $date->format('Y-m-') . $date->format('t');
            } else if ($roundType == 'ceil') {
                $date->modify('+1 month');
                return $date->format('Y-m-01');
            }
        }

        return (new DateTime("$year-$month-$day"))
            ->format('Y-m-d');
    }
}

if (!function_exists('date_time_converter')) {
    /**
     * here you can customize how the function interprets input data and how it should return the result
     * example: you can add 'y'    => 'year'
     *                      's'    => 'seconds'
     *                      'u'    => 'microsecond'
     *
     * key, can be also a string
     * example              'us'  => 'microsecond'
     *
     * @param string $time
     * @return array
     * @throws Exception
     */
    function date_time_converter(string $time) {
        $dateTimeIndex = ['w' => 'week', 'd' => 'day', 'h' => 'hour', 'm' => 'minute'];
        $pattern = "#(([0-9]+)([a-z]+))#";
        $r = preg_match_all($pattern, $time, $matches);

        if ($r === FALSE) {
            throw new Exception('can not parse input data');
        }

        if (count($matches) != 4) {
            throw new Exception('something wrong with input data');
        }

        $dateI = $matches[2]; // contains number
        $dates = $matches[3]; // contains char or string
        $result = array();
        for ($i=0 ; $i<count ($dates) ; $i++) {
            if(!array_key_exists($dates[$i], $dateTimeIndex)) {
                throw new Exception ("date time index is not configured properly, please add this index : [" . $dates[$i] . "]");
            }

            $result[$dateTimeIndex[$dates[$i]]] = (int)$dateI[$i];
        }

        return $result;
    }
}
