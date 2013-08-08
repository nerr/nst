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

    public static function tPregEmailAddress($str)
    {
        //$pattern = '/[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,4}\b/i';
        $pattern = '/[a-z\d._%+-]+@[a-z\d.-]+\.[a-z]{2,4}\b/i';
        preg_match_all($pattern, $str, $email);

        return $email[0];
    }

    public static function tPregMobileNum($str)
    {
        $pattern = '/(13|14|15|18)\d{9}\b/i';
        preg_match_all($pattern, $str, $mobile);

        return $mobile[0];
    }

    public static function uniqChineseCharacters($string)
    {
        $pattern = "/[\x{4e00}-\x{9fa5}]/u";

        preg_match_all($pattern, $string, $characters);

        if(count($characters[0]) > 0)
            return array_flip($characters[0]);
        else
            return false;
    }
}