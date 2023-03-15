<?php

require __DIR__.'/src/autoload.php';

clear();

function migrate(){
    $db = new Db();

    $db->createTable("tasks", [
        "id INTEGER PRIMARY KEY AUTOINCREMENT", 
        "username VARCHAR NOT NULL", 
        "email VARCHAR NOT NULL", 
        "text VARCHAR NOT NULL",
        "status INT NOT NULL DEFAULT 0",
        "created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP",
        "updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP"
    ]);
}

function clear(){
    $db = new Db();
    $db->table('tasks')->clear();
}

function seed(){
    $db = new Db();

    for ($i = 1; $i<10; $i++){
        $db->table("tasks")->insert([
            substr(md5(microtime()), 0, 5), 
            substr(md5(microtime()), -5, 5)."@mail.com",
            "text"
        ],
        ["username", "email", "text"]);
    }
}
