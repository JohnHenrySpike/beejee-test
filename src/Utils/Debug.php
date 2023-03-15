<?php

namespace Utils;

class Debug {
    public static function pr($arg){
        echo '<pre>'.print_r($arg, true).'</pre>';
    }
}