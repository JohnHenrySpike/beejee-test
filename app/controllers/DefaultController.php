<?php
namespace controllers;

use Controller;

class DefaultController extends Controller{

    public function index(){
        $this->redirect("task", "index");
    }

    public function login($args){
        $data = [];
        if ($args){
            if ($this->auth->login($args->username, $args->password)){
                $this->redirect("task", "index");
            }else{
                $data = ["error"=>"Неверные реквизиты доступа!"];
            }
        }
        $this->render('login.php', $data);
        
    }

    public function logout(){
        $this->auth->logout();              
        $this->redirect("task", "index");
    }
    
} 