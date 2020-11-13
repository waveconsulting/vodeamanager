<?php

if (!function_exists('arr_key_equal')) {
    /**
     * @param array $array
     * @param string $key
     * @param $value
     *
     * @return bool
     */
    function arr_key_equal(array $array, string $key, $value) {
        if (is_array($value)) {
            return in_array($value, @$array[$key]);
        }

        return @$array[$key] == $value;
    }
}

if (!function_exists('arr_strict')) {
    /**
     * @param $value
     *
     * @return array
     */
    function arr_strict($value) {
        if (is_array($value)) {
            return $value;
        }

        return [$value];
    }
}

