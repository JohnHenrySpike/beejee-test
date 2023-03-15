<?php
class Response {

    public static function create(int $code, array $data, bool $jsonable = true){
        self::setStatusCode($code);
        if ($jsonable) self::setJsonHeader();
        return $jsonable?Helpers::toJson($data):$data;    
    }

    public static function noFound(){
        self::create(404, []);
        exit(file_get_contents("404.html"));
    }

    public static function setStatusCode(int $code = 200){
        http_response_code($code);
    }

    public static function setJsonHeader(){
        header("Content-Type: application/json");
    }
}