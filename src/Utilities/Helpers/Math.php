<?php

if (!function_exists('distance')) {
    /**
     * @param float $fromLat
     * @param float $fromLong
     * @param float $toLat
     * @param float $toLong
     * @param string $unit
     *
     * @return float
     */
    function distance(float $fromLat, float $fromLong, float $toLat, float $toLong, string $unit = 'KM') {
        $theta = $fromLong - $toLong;
        $dist = sin(deg2rad($fromLat)) * sin(deg2rad($toLat)) +  cos(deg2rad($fromLat)) * cos(deg2rad($toLat)) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        $unit = strtoupper($unit);

        switch ($unit) {
            case 'K':
            case 'KM':
                return $miles * 1.609344;
            default:
                return $miles;
        }
    }
}

if (!function_exists('ceil_thousand')) {
    /**
     * @param float $value
     *
     * @return float
     */
    function ceil_thousand(float $value) {
        if ($value >= 1000) {
            return ceil($value / 1000) * 1000;
        }

        return 1000;
    }
}

if (!function_exists('ceil_nearest')) {
    /**
     * @param float $value
     *
     * @return float
     */
    function ceil_nearest(float $value) {
        if ($value >= 1000) {
            return ceil($value / 1000) * 1000;
        }

        $length = strlen(ceil($value));
        $times = str_pad('1', $length, '0');

        return ceil($value / $times) * $times;
    }
}
