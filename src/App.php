<?php

class App {

    public static $public_path = __DIR__;

    public static $root_path = __DIR__.'/../';

    public static $views_root = __DIR__.'/../app/views/';

    private static $title = "title";

    public static function run(){
        if (preg_match('/\.(?:js|css)$/', $_SERVER["REQUEST_URI"])) {
            return false;
        } else {
            Router::handle();
        }
    }

    public static function title(){
        return self::$title;
    }
}