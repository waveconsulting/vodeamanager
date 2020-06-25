<?php

if (!function_exists('arr_key_equal')) {
    function arr_key_equal(array $array, string $key, $value) {
        if (is_array($value)) {
            return in_array($value, @$array[$key]);
        }

        return @$array[$key] == $value;
    }
}

