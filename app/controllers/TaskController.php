<?php

namespace controllers;

use Controller;
use models\TaskModel;

class TaskController extends Controller{
    public function index(object $args = null){
            
        $page = $args->page ?? 1;

        $sort_by = $args->sort ?? "created_at";
        $tasks = new TaskModel();
        
        $tasks->paginate($page);
        $data = [
            "data" => $tasks->list(null, [$sort_by, "ASC"]),
            "paginate"=>[
                "pages"=>$tasks->getPagesCount(), 
                "current" => $page, 
                "link" => "/task/index?page="
            ],
            "isAdmin" => $this->auth->isAuth
        ];
        
        $this->render('index.php', $data);
    }

    public function add(object $data = null){
        $tasks = new TaskModel();
        $tasks->insert([$data->username, $data->email, $data->text], ["username", "email", "text"]);
        $this->redirect("task", "index");
    }

    public function update(object $args){
        $tasks = new TaskModel();

        $values = [];
        $values["status"]= isset($args->status)?1:0;
        if (isset($args->text)) {
            $values["text"]= $args->text;
        }

        $tasks->updateById($args->id, $values);
        $this->redirect("task", "index");
    }
}