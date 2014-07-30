<?php
/**
 * @file
 * Handles functionality related to users
 */
class User {
    private $_db, $_data, $_sessionName, $_cookieName, $_isLoggedIn;
    
    public function __construct($user = null) {
        $this->_db = DB::getInstance();
        $this->_sessionName = Config::get('session/session_name');
        $this->_cookieName = Config::get('remember/cookie_name');
        if(!$user) {
            if(Session::exists($this->_sessionName)) {
                $user = Session::get($this->_sessionName);
                if($htis->find($user)) {
                    $this->_isLoggedIn = true;
                }
                else {
                    //process logout
                }
            }
        }
        else {
            $this->find($user);
        }
    }
    public function create($fields = array()) {
        if(!$this->_db->insert('users', $fields)) {
            throw new Exception(t('There was an error creating the user'), 'SYS_U_C-1');
        }
    }
    public function update($fields = array(), $id = null) {
        if(!$id && $this->isLoggedIn()) {
            $id = $this->data()->id;
        }
        if(!$this->_db->update('users', $id, $fields)) {
            throw new Exception(t('There was an error updating your user information'), 'SYS_U_U-2');
        }
    }
    public function find($user = null) {
        if($user) {
            $field = (is_numeric($user)) ? 'id' : 'username';
            $data = $this->_db->get('users', array($field, '=', $user));
            if($data->count()) {
                $this->_data = $data->first();
            }
        }
        return false;
    }
    public function login($username = null, $password = null, $remember = false) {
        $user = $this->find($username);
        if(!$username && !$password && $this->exists()) {
            Session::put($this->_sessionName, $this->data()->id);
        }
        else {
            $user = $this->find($username);
        
            if($user) {
                if($this->data()->password === Hash::make($password, $this->data()->salt)) {
                    Session::put($this->_sessionName, $this->data()->id);
                    if($remember) {
                        $hash = Hash::unique();
                        $hashCheck = $this->_db->get('users_session', array('user_id', '=', $this->data()->id));
                        if(!$hashCheck->count()) {
                            $this->_db->insert('users_session', array('user_id' => $this->data()->id, 'hash' => $hash));
                        }
                        else {
                            $hash = $hashCheck->first->hash;
                        }
                        Cookie::put($this->_cookieNanme, $hash, Config::get('remember/cookie_expiry'));
                    }
                    return true;
                }
            }
        }
        return false;
    }
    public function exists() {
        return (!empty($this->_data)) ? true : false;
    }
    public function logout() {
        $this->_db->delete('users_session', array('user_id', '=', $this->data()->id));
        Session::delete($this->_sessionName);
        Cookie::delete($this->_cookieName);
    }
    public function data() {
        return $this->_data;
    }
    public function isLoggedIn() {
        return $this->_isLoggedIn;
    }
    public static function MakeRandPass($upper = 3, $lower = 3, $numeric = 3, $other = 2) {
        //we need these vars to create a password string
        $passOrder = Array();
        $passWord = '';
        //generate the contents of the password
        for ($i = 0; $i < $upper; $i++) {
            $passOrder[] = chr(rand(65, 90));
        }
        for ($i = 0; $i < $lower; $i++) {
            $passOrder[] = chr(rand(97, 122));
        }
        for ($i = 0; $i < $numeric; $i++) {
            $passOrder[] = chr(rand(48, 57));
        }
        for ($i = 0; $i < $other; $i++) {
            $passOrder[] = chr(rand(33, 47));
        }
        //randomize the order of characters
        shuffle($passOrder);
        //concatenate into a string
        foreach ($passOrder as $char) {
            $passWord .= $char;
        }
        //we're done
        return $passWord;
    }
}