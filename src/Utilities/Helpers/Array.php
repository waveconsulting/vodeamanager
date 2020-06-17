<?php

if (!function_exists('arr_get')) {
    function arr_get(array $array, string $key, $default) {
        return \Illuminate\Support\Arr::get($array, $key, $default);
    }
}

if (!function_exists('arr_has')) {
    function arr_has(array $array, string $key) {
        return \Illuminate\Support\Arr::has($array, $key);
    }
}


