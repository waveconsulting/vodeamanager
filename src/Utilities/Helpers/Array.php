<?php

if (!function_exists('arr_get')) {
    function arr_get(array $array, string $key, $default = null) {
        return \Illuminate\Support\Arr::get($array, $key, $default);
    }
}

if (!function_exists('arr_has')) {
    function arr_has(array $array, string $key) {
        return \Illuminate\Support\Arr::has($array, $key);
    }
}

if (!function_exists('arr_key_equal')) {
    function arr_key_equal(array $array, string $key, $value, $return) {
        if (is_array($value)) return in_array($value, arr_get($array, $key));
        return arr_get($array, $key) == $value;
    }
}
