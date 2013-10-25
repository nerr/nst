<?php

class Debug
{
    public static function dump($data)
    {
        echo '<pre>';
        print_r($data);
        echo '</pre>';
    }

    public static function byte_ausrechnen($byte) {
    
        if($byte < 1024) {
            $ergebnis = round($byte, 2). ' Byte';
        }elseif($byte >= 1024 and $byte < pow(1024, 2)) {
            $ergebnis = round($byte/1024, 2).' KByte';
        }elseif($byte >= pow(1024, 2) and $byte < pow(1024, 3)) {
            $ergebnis = round($byte/pow(1024, 2), 2).' MByte';
        }elseif($byte >= pow(1024, 3) and $byte < pow(1024, 4)) {
            $ergebnis = round($byte/pow(1024, 3), 2).' GByte';
        }elseif($byte >= pow(1024, 4) and $byte < pow(1024, 5)) {
            $ergebnis = round($byte/pow(1024, 4), 2).' TByte';
        }elseif($byte >= pow(1024, 5) and $byte < pow(1024, 6)) {
            $ergebnis = round($byte/pow(1024, 5), 2).' PByte';
        }elseif($byte >= pow(1024, 6) and $byte < pow(1024, 7)) {
            $ergebnis = round($byte/pow(1024, 6), 2).' EByte';
        }

        return $ergebnis;
        
    }
}