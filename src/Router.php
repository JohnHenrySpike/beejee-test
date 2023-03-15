<?php

class Router {

    private $controller = 'Default';
    private $ctrl_class;
    private $action = 'index';
    private $args = [];
    private $path_info = null;
    private $query_string = null;
    private $query = [];
    private $method = null;

    public static function handle(){
        $router = new self();
        $router->init();

        $controller = new $router->ctrl_class($router->controller);
        $controller->run($router->getActionName(), $router->getQuery());
    }

    private function init(){
        $this->path_info = $_SERVER['PATH_INFO'] ?? '/';
        $this->query_string = $_SERVER['QUERY_STRING'] ?? null;
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->parse();
    }

    private function getControllerName(){
        return $this->controller."Controller";
    }

    private function checkController(){
        if (class_exists('\\controllers\\'.$this->getControllerName())){
            $this->ctrl_class = '\\controllers\\'.$this->getControllerName();
        } else {
            throw new \Exception("Controller not found");
        }
    }

    private function getActionName(){
        return $this->action;
    }

    private function getQuery(){
        return $this->query;
    }

    private function setControllerName(string $name){
        $this->controller = ucfirst($name);
    }

    public static function redirect(string $conroller, string $action){
        header("Location: /".$conroller."/".$action);
        exit();
    }

    private function getData(){
        switch ($this->method) {
            case 'GET':
                $this->query = $this->parseQueryString();
                break;
            case 'POST':
                $this->query = array_merge($this->parseQueryString(), $this->parsePostData());
                break;
            default:
                $this->query = $this->parseQueryString();
                break;
        }
    }

    private function parsePostData(){
        return $_POST;
    }

    private function parseQueryString(){
        if ($this->query_string){
            $query = explode("&",$this->query_string);
            if (!empty($query)){
                $res = [];
                foreach ($query as $v) {
                    $tmp = explode("=",$v);
                    $res[$tmp[0]??null] = $tmp[1]??null;
                }
                return $res;
            }
        }
        return [];
    }
    

    private function parse(){

        $path = explode("/",$this->path_info);
        
        $path = array_filter($path, function($v){
            return strlen(trim($v))>0?true:false;
        });
        if (!empty($path)){
            $path = array_values($path);
            $argCount = count($path);

            if ($argCount == 1){
                $this->action = $path[0];
            } elseif ($argCount == 2){
                $this->setControllerName($path[0]);
                $this->checkController();
                $this->action = $path[1];
            } elseif ($argCount > 2){
                for ($i = 2; $i < $argCount; $i++) {
                    $this->args[] = $path[$i] ?? '';
                }
            }
        }

        $this->getData();

        $this->ctrl_class = '\\controllers\\'.$this->getControllerName();
    }
}