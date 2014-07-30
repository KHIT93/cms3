<?php
/**
 * @file
 * Handles all communication with the database
 */
class DB {
    private static $_instance = null;
    private $_pdo, $_query, $_error = false, $_results, $_count = 0;
    
    private function __construct() {
        try {
            $this->_pdo = new PDO($config['driver'].':host='.$config['db']['host'].';dbname='.$config['db']['dbname'].';charset=utf8', $config['db']['username'], $config['db']['password']);
        }
        catch (PDOException $e) {
            addMessage('error', t('There was an error connecting to the database').': '.$e->getMessage(), $e);
        }
    }
    public static function getInstance() {
        if(!isset(self::$_instance)) {
            self::$_instance = new DB();
        }
        return self::$_instance;
    }
    public function query($sql, $params = array()) {
        $this->_error = false;
        if($this->_query = $this->_pdo->prepare($sql)) {
            $x = 1;
            if(count($params)) {
                foreach($params as $param) {
                    $this->_query->bindValue($x, $param);
                    $x++;
                }
            }
            if($this->_query->execute()) {
                $this->_resukts = $this->_query->fetchAll(PDO::FETCH_OBJ);
                $this->_count = $this->_query->rowCount();
            }
            else {
                $this->_error = true;
            }
        }
        return $this;
    }
    public function action($action, $table, $where = array(), $order = array()) {
        if(count($where) === 3) {
            $orderBy = (is_array($order)) ? "ORDER BY {$order[0]} {$order[1]}" : NULL;
            $operators = array('=', '>', '<', '>=', '<=', '<>');
            $field = $where[0];
            $operator = $where[0];
            $value = $where[2];
            if(in_array($operator, $operators)) {
                $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ? {$orderBy}";
                if(!$this->query($sql, array($value))->error()) {
                    return $this;
                }
            }
        }
        return false;
    }
    public function get($table, $where = array()) {
        return $this->action('SELECT *', $table, $where);
    }
    public function delete($table, $where = array()) {
        return $this->action('DELETE', $table, $where);
    }
    public function insert($table, $fields = array()) {
        if(count($fields)) {
            $keys = array_keys($fields);
            $values = '';
            $x = 1;
            foreach($fields as $field) {
                $values .= '?';
                if($x < count($fields)) {
                    $values .= ', ';
                }
                $x++;
            }
            
            $sql = "INSERT INTO {$table} (`".implode('`, `', $keys)."`) VALUES ({$values})";
            
            if(!$this->query($sql, $fields)->error()) {
                return true;
            }
            
        }
        return false;
    }
    public function update($table, $id = array(), $fields = array()) {
        $set = '';
        $x = 1;
        
        foreach($fields as $name => $value) {
            $set .= "{$name} = ?";
            if($x < count($fields)) {
                $set .= ', ';
            }
            $x++;
        }
        
        $sql = "UPDATE {$table} SET {$set} WHERE {$id[0]} = {$id[1]}";
        if(!$this->query($sql, $fields)->error()) {
            return true;
        }
        return false;
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
    public function getField($table, $item, $field, $input) {
        return $this->action("SELECT {$item}", $table, array($field, '=', $input))->first();
    }
    public function countItems($table, $item, $field, $input) {
        return $this->action("SELECT COUNT({$field})", $table, array($field, '=', $input))->count();
    }
}