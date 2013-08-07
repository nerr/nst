<?php

class Debug
{
    public static function dump($data)
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }
}