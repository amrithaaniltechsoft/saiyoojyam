<?php

if (!function_exists('new_booking_id')) {
    function new_booking_id($id, $pref)
    {
        $length_code = 6;
        $string_code = substr(str_repeat('0', $length_code) . $id, -$length_code);
        return $pref . $string_code;
    }
}

