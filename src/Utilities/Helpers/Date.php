<?php

if (!function_exists('today')) {
    function today($format = 'Y-m-d') {
        return now()->format($format);
    }
}

if (!function_exists('tomorrow')) {
    function tomorrow($format = 'Y-m-d') {
        return date($format, strtotime(today() . ' + 1 day'));
    }
}


if (!function_exists('yesterday')) {
    function yesterday($format = 'Y-m-d') {
        return date($format, strtotime('-1 day',strtotime(today())));
    }
}
