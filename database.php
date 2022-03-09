<?php

class Database{
    public $host = "localhost";
    public $user = "root";
    public $password = "";
    public $dbName = "library";

    public $db;
    public function __construct(){
        $this->dbConnection();
    }

    public function dbConnection(){
        $this->db = new MySqli($this->host, $this->user, $this->password, $this->dbName);
        if(!$this->db){
            print($this->db->num_error);
            exit();
        }
    }

    public function save($table, $feilds){
        $insert = "INSERT INTO $table $feilds";
        $result = $this->db->query($insert);
        if($result){
            return true;
        }else{
            return false;
        }
    }

    public function getAllTable($field, $allTable, $where = NULL, $and = NULL, $orderField, $ordering = 'DESC', $limit = NULL){
        $getAll = "SELECT $field FROM $allTable $where $and ORDER BY $orderField $ordering $limit";

        $result = $this->db->query($getAll);

        return $result;

    }
    public function updateItems($field, $allTable, $where = NULL){

        $getAll = "SELECT $field FROM $allTable $where";

        $result = $this->db->query($getAll);

        return $result;

    }

    public function saveUpdate($table, $set, $where){
        $update = "UPDATE $table SET $set WHERE $where";
        $result = $this->db->query($update);
        if($result){
            return true;
        }else{
            return false;
        }
    }

    public function deleteRecord($from, $delete, $value){
        $delete = "DELETE FROM $from WHERE $delete = $value";
        $result = $this->db->query($delete);
        return $result;
     }

     public function getItems(){
        $stmt = "SELECT books.*, categories.Name AS Category_Name FROM books JOIN categories ON categories.ID = books.cat_id ORDER BY BookID DESC";
        $result = $this->db->query($stmt);
        if($result){
            return $result;
        }else{
            return false;
        }
    }
}

?>