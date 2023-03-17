<?php

namespace Utils;

class Debug {
    public static function pr($arg){
        if ($arg){
            echo '<pre>'.print_r($arg, true).'</pre>';
        }else var_dump($arg);    
    }
}