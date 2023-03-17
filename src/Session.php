<?php

class Session {

    public static function init(){
        if (session_start()){
            return session_id();
        } else {
            throw new Exception("Unable to init session");
        }
    }

    public static function get($key){
        if (self::isSet($key)){
            return $_SESSION[$key];
        }
        return null;
    }

    public static function set($key, $val){
        $_SESSION[$key]=$val;
    }

    public static function isSet($key){
        return array_key_exists($key, $_SESSION);
    }
}