<?php
/**
 * @file
 * Acts as a Database abstraction layer for PDO and implements easy to use functionality that has been customized for use with core classes and functions, as well as third party modules
 */
class DB {
    private static $_instance = null;
    private $_pdo, $_query, $_error = false, $_results, $_count = 0;
    
    private function __construct() {
        try {
            $this->_pdo = new PDO(Config::get('db/driver').':host='.Config::get('db/host').';dbname='.Config::get('db/name').';charset=utf8', Config::get('db/username'), Config::get('db/password'));
        }
        catch (PDOException $e) {
            die($e->getMessage());
        }
    }
    public static function getInstance() {
        if(!isset(self::$_instance)) {
            self::$_instance = new DB();
        }
        return self::$_instance;
    }
    public function query($sql, $params = array(), $pdoFetch = PDO::FETCH_OBJ) {
        $this->_error = false;
        if($this->_query = $this->_pdo->prepare($sql)) {
            if(count($params) > 0) {
                $x = 1;
                foreach($params as $param) {
                    $this->_query->bindValue($x, $param, get_datatype($param));
                    $x++;
                }
            }
            try {
                $this->_query->execute();
                $this->_results = $this->_query->fetchAll($pdoFetch);
                $this->_count = $this->_query->rowCount();
            }
            catch (Exception $e) {
                System::addMessage('error', $e->getMessage(), $e);
                $this->_error = true;
            }
        }
        return $this;
    }
    public function action($action, $table, $where = array(), $pdoFetch = PDO::FETCH_OBJ) {
        if(count($where) === 3) {
            $operators = array('=', '>', '<', '>=', '<=', '<>');
            $field = $where[0];
            $operator = $where[1];
            $value = $where[2];
            if(in_array($operator, $operators)) {
                $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
                if(!$this->query($sql, array($value), $pdoFetch)->error()) {
                    return $this;
                }
            }
        }
        return false;
    }
    public function get($table, $where, $pdoFetch = PDO::FETCH_OBJ) {
        return $this->action("SELECT *", $table, $where, $pdoFetch);
    }
    public function getAll($table, $pdoFetch = PDO::FETCH_OBJ) {
        return $this->query("SELECT * FROM {$table}", NULL, $pdoFetch);
    }
    public function delete($table, $where) {
        return $this->action("DELETE", $table, $where);
    }
    public function insert($table, $fields = array()) {
        if(count($fields)) {
            $keys = array_keys($fields);
            $values = '';
            $x = 1;
            foreach ($fields as $field) {
                $values .= '?';
                if($x < count($fields)) {
                    $values .= ', ';
                }
                $x++;
            }
            $sql = "INSERT INTO {$table} (`".implode('`, `', $keys)."`) VALUES({$values})";
            if(!$this->query($sql, $fields)->error()) {
                return true;
            }
        }
        return false;
    }
    public function bulkInsert($table, $fields, $data = array()) {
        //Insert multiple rows in one query
//        if(count($fields)) {
//            $keys = array_keys($fields);
//            $values = '';
//            $x = 1;
//            foreach ($fields as $field) {
//                $values .= '?';
//                if($x < count($fields)) {
//                    $values .= ', ';
//                }
//                $x++;
//            }
//            $sql = "INSERT INTO {$table} (`".implode('`, `', $keys)."`) VALUES({$values})";
//            if(!$this->query($sql, $fields)->error()) {
//                return true;
//            }
//        }
//        return false;
    }
    public function update($table, array $where, $fields = array()) {
        $set = '';
        $x = 1;
        $operators = array('=', '>', '<', '>=', '<=', '<>');
        foreach($fields as $name => $value) {
            $set .= "{$name} = ?";
            if($x < count($fields)) {
                $set .= ', ';
            }
            $x++;
        }
        $sql = "UPDATE {$table} SET {$set} WHERE {$where[0]}={$where[1]}";
        if(!$this->query($sql, $fields)->error()) {
            return true;
        }
        return false;
    }
    public function bulkUpdate($table, $field = NULL, $where = array(), $data = array()) {
        //Update multiple rows in one query
        $set = '';
        $indexes = '';
        $x = 1;
        $operators = array('=', '>', '<', '>=', '<=', '<>');
        $params = array();
        
        foreach($where as $value) {
            $set .= "WHEN {$field} = ? THEN ?";
            $indexes .= $value;
            $params[] = $data[$value];
            if($x < count($where)) {
                $set .= ',';
            }
            $x++;
        }
        
        $sql = "UPDATE {$table} "
        . "SET {$field} = CASE "
        . "{$set} "
        . "END "
        . "WHERE {$field} IN ($indexes)";
        if(!$this->query($sql, $params)->error()) {
            return true;
        }
        return false;
        
    }
    public function getField($table, $item, $field, $input, $pdoFetch = PDO::FETCH_OBJ) {
        //$this->action("SELECT {$item}", $table, array($field, '=', $input));
        if(is_object($this->action("SELECT {$item}", $table, array($field, '=', $input))) && !empty($this->results())) {
            return $this->first()->{$item};
        
        } else {
            return NULL;
        }
    }
    public function countItems($table, $item, $field, $input, $pdoFetch = PDO::FETCH_OBJ) {
        return $this->action("SELECT COUNT({$field})", $table, array($field, '=', $input))->count();
    }
    public function results() {
        return $this->_results;
    }
    public function first() {
        return $this->results()[0];
    }
    public function error() {
        return $this->_error;
    }
    public function count() {
        return $this->_count;
    }
    public function version() {
        $version = '@@VERSION';
        return $this->query("SELECT @@VERSION")->first()->{$version};
    }
}