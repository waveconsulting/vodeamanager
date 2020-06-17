<?php

if (!function_exists('kebab_to_pascal')) {
    function kebab_to_pascal($str) {
        return str_replace('-', '', ucwords($str, '-'));
    }
}

if (!function_exists('snake_to_pascal')) {
    function snake_to_pascal($str) {
        return str_replace('_', '', ucwords($str, '_'));
    }
}

if (!function_exists('arr_get')) {
    function arr_get(array $data, string $key) {

    }
}
