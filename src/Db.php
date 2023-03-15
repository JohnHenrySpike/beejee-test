<?php

class Db extends \SQLite3{
    
    private string $table;
    private string $query_string;
    private string $dry_string;

    private \SQLite3Result|false $result;

    public function __construct()
    {
        $this->open(App::$root_path.'db.sql');
    }

    public function createTable(string $name, array $columns){
        $cols = implode(", ", $columns);
        $this->query_string = 'CREATE TABLE '.$name.'('.$cols.');';
        $this->get();
    }

    public function raw(string $query){
        $this->query_string = $query;
        return $this->get();
    }

    public function get(){
        $this->dry_string = $this->escapeString($this->query_string);
        $this->result = $this->query($this->dry_string);
        if ($this->lastErrorCode()!==0){
            $this->showError();
            $this->close();
        }
        return $this;
    }

    public function asArray(){
        $result = [];
        while($res = $this->result->fetchArray(SQLITE3_ASSOC)){
            $result[] = $res;
        }
        return $result;
    }

    public function listTables(){
        $this->query_string = "SELECT * FROM sqlite_schema WHERE type =\"table\" AND name NOT LIKE \"sqlite_%\";";
        return $this->get()->asArray();
    }

    public function table(string $name){
        $this->table = $name;
        return $this;
    }

    public function insert(array $values, array $cols = null){
        
        $vals = array_map(function($val){
            return is_string($val)?"\"".$val."\"":$val;
        }, $values);


        $columns = null;
        if (!empty($cols)) $columns = implode(",", $cols);
        
        $query = "INSERT INTO ". $this->table;
        
        if ($columns) $query .= " (".$columns.") ";
        
        $query .= " VALUES(";
        $query .= implode(", ", $vals);
        $query .= ");";

        $this->query_string = $query;
        $this->get();
        return $this->changes();
    }

    public function update(array $condition, array $colsAndVals){
        
        $vals = array_map(function($key, $val):string {
            $val = is_string($val)?"\"".$val."\"":$val;
            return $key." = ". $val;
        }, array_keys($colsAndVals), array_values($colsAndVals));

        if (!empty($vals)) $vals = implode(",", $vals);
        

        $conds = array_map(function($key, $val){
            $val = is_string($val)?"\"".$val."\"":$val;
            return $key. " = " . $val;
        }, array_keys($condition), array_values($condition));

        if (!empty($conds)) $conds = implode(",", $conds);

        $query = "UPDATE ". $this->table;
        
        $query .= " SET ".$vals." ";
        
        $query .= " WHERE(";
        $query .= $conds;
        $query .= ");";

        $this->query_string = $query;
        $this->get();
        return $this->changes();
    }

    public function list(array $cols = null){
        $this->query_string = "SELECT ";
        $this->query_string .= $cols ? implode(", ", $cols) : "*";
        $this->query_string .= " FROM ".$this->table;
        return $this;
    }

    public function countRows(): int{
        $this->query_string = "SELECT count(*) count";
        $this->query_string .= " FROM ".$this->table;
        return $this->get()->asArray()[0]["count"];
    }

    public function limit(int $rows, int $offset = 0){
        $this->query_string .= " LIMIT ". $rows . " OFFSET ".$offset;
        return $this;
    }

    public function order(string $expr, string $order){
        $this->query_string .= " ORDER BY ". $expr . " " . $order;
        return $this;
    }


    public function delete(string $cond){
        $this->query_string = "DELETE FROM ".$this->table;
        $this->query_string .= " WHERE ". $cond;
        $this->get();
        return $this->changes();
    }

    public function clear(){
        $this->query_string = "DELETE FROM ".$this->table;
        $this->get();
        return $this->changes();
    }

    public function drop(){
        $this->query_string = "DROP TABLE ".$this->table;
        $this->get();
        return true;
    }

    private function showError(){
        echo "Error code: " . $this->lastErrorCode() ."\n";
        echo "Error EXcode: " . $this->lastExtendedErrorCode()."\n";
        echo "Message: " . $this->lastErrorMsg()."\n";
        echo "<pre>".print_r($this, true)."</pre>";
    }

}