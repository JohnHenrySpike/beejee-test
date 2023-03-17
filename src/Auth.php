<?php

class Auth {
    public $isAuth = false;

    //userpass
    private $validUser = "admin";
    private $validPass = "123";

    private const ISAUTH = "isAuth";

    public function __construct()
    {
        $this->check();
    }

    public function login($user, $pass){
        if ($user == $this->validUser && $pass == $this->validPass){
            $this->set();
            return true;
        }
        return false;
    }

    public function logout(){
        $this->unset();
    }

    private function check(){
        if (Session::isSet(self::ISAUTH)){
            if (!empty(Session::get(self::ISAUTH)) && Session::get(self::ISAUTH) == true){
                $this->isAuth = true;
            }
        }
    }

    private function set(){
        $this->isAuth = true;
        Session::set("isAuth", true);
    }

    private function unset(){
        $this->isAuth = false;
        Session::set("isAuth", false);
    }
}