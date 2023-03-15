<?php
namespace controllers;

use Controller;

class DefaultController extends Controller{

    public function index(){
        $this->redirect("task", "index");
    }

    public function login(object $args){
        $this->auth->login($args->username, $args->password);              
        $this->redirect("task", "index");
    }

    public function logout(){
        $this->auth->logout();              
        $this->redirect("task", "index");
    }
    
} 