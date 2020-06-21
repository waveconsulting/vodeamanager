<?php

use Illuminate\Support\Arr;

if (!function_exists('arr_key_equal')) {
    function arr_key_equal(array $array, string $key, $value) {
        if (is_array($value)) {
            return in_array($value, Arr::get($array, $key));
        }

        return Arr::get($array, $key) == $value;
    }
}

