<?php

if (!function_exists('kebab_to_pascal')) {
    function kebab_to_pascal($str) {
        return str_replace('-', '', ucwords($str, '-'));
    }
}
