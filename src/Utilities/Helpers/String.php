<?php

if (!function_exists('kebab_to_pascal')) {
    /**
     * @param $str
     *
     * @return string
     */
    function kebab_to_pascal($str) {
        return str_replace('-', '', ucwords($str, '-'));
    }
}
