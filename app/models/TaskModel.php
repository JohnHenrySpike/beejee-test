<?php
namespace models;

use Model;

class TaskModel extends Model{

    public int $per_page = 3;

    protected string $table = "tasks";
}