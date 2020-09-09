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
