<?php

class App {

    public static $public_path = __DIR__;

    public static $root_path = __DIR__.'/../';

    public static $views_root = __DIR__.'/../app/views/';

    private static $title = "Список задач";

    public static function run(){
        if (php_sapi_name() == 'cli-server'){
            if (preg_match('/\.(?:js|css)$/', $_SERVER["REQUEST_URI"])) {
                return false;
            }
        }
        Session::init();
        Router::handle();
    }

    public static function title(){
        return self::$title;
    }
}