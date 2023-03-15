<?php

class Helpers {
    public static function toJson(array $data){
        $res = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_NUMERIC_CHECK);
        $errors = ["code" => json_last_error(),
            "msg" => json_last_error_msg()
        ];
        return $errors["code"]==0?$res:$errors;
    }

    public static function decodeJson(string $str){
        $res = json_decode($str, false);
        $errors = ["code" => json_last_error(),
            "msg" => json_last_error_msg()
        ];
        return $errors["code"]==0?$res:$errors;
    }

    public static function arrToObject(array $arr){
        return self::decodeJson(self::toJson($arr));
    }
}