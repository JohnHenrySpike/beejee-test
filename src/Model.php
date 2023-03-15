<?php

class Model {
    protected string $table;
    private Db $db;
    private $page_count = 0;
    private $usePaginate = false;
    private $curr_page = 1;

    protected int $per_page = 10;
    protected $fields;

    public function __construct()
    {
        $this->db = new Db();
        $this->db->table($this->table);
    }

    public function insert(array $values, array $columns = null){
        return $this->db->insert($values, $columns);
    }

    public function update(array $cond, array $colsAndVals){
        return $this->db->update($cond, $colsAndVals);
    }

    public function updateById(int $id, array $colsAndVals){
        return $this->db->update(["id"=>$id], $colsAndVals);
    }

    public function delete(int $id){
        return $this->db->delete($id);
    }

    public function list(array $cols = null, array $order, int $limit = 0, int $offset = 0){
        if ($this->usePaginate){
            $limit = $this->per_page;
            $offset = ($this->curr_page - 1) * $limit;
        }
        return $this->db->list($cols)->order($order[0], $order[1])->limit($limit, $offset)->get()->asArray();
    }

    private function count(){
        return $this->db->countRows();
    }

    public function getPagesCount(){
        if ($this->usePaginate){
            return $this->page_count;
        } else {
            return 0;
        }
    }

    public function paginate($page){
        $this->usePaginate = true;
        $this->page_count = ceil($this->count() / $this->per_page);
        $this->curr_page = $page;
        return $this;
    }
}