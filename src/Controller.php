<?php

class Controller {
    
    private $view = "default";

    private $action = 'index';

    private $name = null;

    protected \Auth $auth;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->auth = new Auth();
    }

    public function run(string $action = "index", array|null $args = null){
        if (method_exists($this, $action)){
            $this->action = $action;
            
            if ($args){
                $this->{$this->action}(Helpers::arrToObject($args));
            } else {
                $this->{$this->action}();
            }
        } else {
            throw new \Exception("Method not found");
        }
    }

    protected function render(string $view_name, array $data){
        $v = new View($this->name);
        $v->render($view_name, $data);
    }

    protected function redirect($controller, $action){
        Router::redirect($controller, $action);
    }
}