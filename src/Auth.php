<?php

class Auth {
    public $isAuth = false;

    //userpass
    private $validUser = "admin";
    private $validPass = "123";

    public function __construct()
    {
        if (session_start()){
            $this->check();
        } else {
            throw new Exception("Unable to init session");
        }
        
    }

    public function login($user, $pass){
        if ($user == $this->validUser && $pass == $this->validPass){
            $this->set();
        }
        return false;
    }

    public function logout(){
        $this->unset();
    }

    private function check(){
        if (isset($_SESSION["isAuth"])){
            if (!empty($_SESSION["isAuth"]) && $_SESSION["isAuth"] == true){
                $this->isAuth = true;
            }
        }
    }

    private function set(){
        $this->isAuth = true;
        $_SESSION["isAuth"] = true;
    }

    private function unset(){
        $this->isAuth = false;
        $_SESSION["isAuth"] = false;
    }
}