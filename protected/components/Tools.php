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

    public static function tUniqChineseCharacters($string)
    {
        $pattern = "/[\x{4e00}-\x{9fa5}]/u";

        preg_match_all($pattern, $string, $characters);

        if(count($characters[0]) > 0)
            return array_flip($characters[0]);
        else
            return false;
    }

    /**
     * Get either a Gravatar URL or complete image tag for a specified email address.
     *
     * @param string $email The email address
     * @param string $s Size in pixels, defaults to 80px [ 1 - 2048 ]
     * @param string $d Default imageset to use [ 404 | mm | identicon | monsterid | wavatar ]
     * @param string $r Maximum rating (inclusive) [ g | pg | r | x ]
     * @param boole $img True to return a complete IMG tag False for just the URL
     * @param array $atts Optional, additional key/value attributes to include in the IMG tag
     * @return String containing either just a URL or a complete image tag
     * @source http://gravatar.com/site/implement/images/php/
     */
    public static function tGetGavatar( $email, $s = 80, $d = 'mm', $r = 'g', $img = false, $atts = array() ) {
        $url = 'http://www.gravatar.com/avatar/';
        $url .= md5( strtolower( trim( $email ) ) );
        $url .= "?s=$s&d=$d&r=$r";
        if ( $img ) {
            //$url = '<img src="' . $url . '"';
            foreach ( $atts as $key => $val )
                $url .= ' ' . $key . '="' . $val . '"';
            //$url .= ' />';
        }
        return $url;
    }
}