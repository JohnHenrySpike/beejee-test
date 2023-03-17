<?php

namespace controllers;

use Controller;
use models\TaskModel;

class TaskController extends Controller{
    public function index(object $args = null){
            
        $page = $args->page ?? 1;
        $sort_by = $args->sort_by ?? null;
        
        $tasks = new TaskModel();
        
        $tasks->paginate($page);

        $paginate_link = "/task/index?";
        $sort = null;

        if ($sort_by) {
            $paginate_link .= "sort_by=".$sort_by."&";
            $exSort = explode("_", $sort_by);
            if (count($exSort) == 2){
                $sort = [
                    $exSort[0],
                    strtoupper($exSort[1])
                ];
            }
        }

        $paginate_link .= "page=";
        
        $data = [
            "data" => $tasks->list(null, $sort),
            "sort_by" => $sort_by,
            "paginate"=>[
                "pages"=>$tasks->getPagesCount(), 
                "current" => $page, 
                "link" => $paginate_link
            ],
            "isAdmin" => $this->auth->isAuth
        ];
        
        $this->render('index.php', $data);
    }

    public function add($data){
        $tasks = new TaskModel();
        $tasks->insert([$data->username, $data->email, htmlspecialchars($data->text)], ["username", "email", "text"]);
        $this->redirect("task", "index");
    }

    public function update($args){
        if (!$this->auth->isAuth) $this->redirect(null, "login");
        $old_model = new TaskModel();
        $old_model = $old_model->find($args->id);
        $tasks = new TaskModel();

        $values["status"]= isset($args->status)?1:0;
        if (isset($args->text) && $args->text !== $old_model["text"]) {
            $values = ["changed"=>true];
            $values["text"]= htmlspecialchars($args->text);
        }
        $tasks->updateById($args->id, $values);
        $this->redirect("task", "index");
    }
}