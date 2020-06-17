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

if (!function_exists('snake_to_camel')) {
    function snake_to_camel($str) {
        return lcfirst(str_replace(' ', '', ucwords(str_replace('_', ' ', $str))));
    }
}

if (!function_exists('camel_to_snake')) {
    function camel_to_snake($str) {
        $str[0] = strtolower($str[0]);
        return preg_replace_callback('/([A-Z])/', function ($char) {
            return '_' . strtolower($char[1]);
        }, $str);
    }
}
