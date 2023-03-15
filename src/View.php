<?php

class View {
    
    private $controller;

    protected $layout = "default";

    private $name = "index";

    private $data = null;

    public function __construct($controller)
    {
        $this->controller = $controller;
    }
    public function render(string $name = "index", array $data = [], $layout = null){
        $this->name = $name;
        $this->data = $data;
        if ($layout) $this->layout = $layout;
        $laout_path = App::$views_root.'layouts/'.$this->layout.".php";
        if (file_exists($laout_path)){
            include $laout_path;
        } else {
            throw new \Exception("Layout not found");
        }
    }

    public function renderContent(){
        $view_path = App::$views_root.$this->controller.'/'.$this->name;
        if (file_exists($view_path)){
            include $view_path;
        } else {
            throw new \Exception($view_path);
        }
    }

}