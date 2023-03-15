<?php
class Autoloader
{
    public static function register()
    {
        $loaded = true;
        spl_autoload_register(function ($class) {
            $file = dirname(__DIR__) . '\\src\\' . $class . '.php';
            $file = str_replace('\\', DIRECTORY_SEPARATOR, $file);
            if (file_exists($file)) {
                require $file;
            }
            $loaded = false;
        });

        spl_autoload_register(function ($class) {
            $file = dirname(__DIR__) . '\\app\\' . $class . '.php';
            $file = str_replace('\\', DIRECTORY_SEPARATOR, $file);
            if (file_exists($file)) {
                require $file;
            }
            $loaded = false;
        });

        return $loaded;
    }
}
Autoloader::register();