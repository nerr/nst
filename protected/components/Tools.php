<?php

class Tools
{
    public static function tGetClientIp()
    {
        if (isset($_SERVER['HTTP_CLIENT_IP']) && !empty($_SERVER['HTTP_CLIENT_IP']))
            return $_SERVER['HTTP_CLIENT_IP'];
        if (isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR']))
            return strtok($_SERVER['HTTP_X_FORWARDED_FOR'], ',');
        if (isset($_SERVER['HTTP_PROXY_USER']) && !empty($_SERVER['HTTP_PROXY_USER']))
            return $_SERVER['HTTP_PROXY_USER'];
        if (isset($_SERVER['REMOTE_ADDR']) && !empty($_SERVER['REMOTE_ADDR']))
            return $_SERVER['REMOTE_ADDR'];
        else
            return "0.0.0.0";
    }
}