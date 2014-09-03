<?php
/**
 * @file
 * Handles functionality related to users
 */
class User {
    private static $_instance;
    private $_db, $_data, $_sessionName, $_cookieName, $_isLoggedIn;
    
    public function __construct($user = null) {
        $this->_db = DB::getInstance();
        $this->_sessionName = Config::get('session/session_name');
        $this->_cookieName = Config::get('remember/cookie_name');
        if(!$user) {
            if(Session::exists($this->_sessionName)) {
                $user = Session::get($this->_sessionName);
                if($this->find($user)) {
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
    public static function getInstance() {
        if(!isset(self::$_instance)) {
            self::$_instance = new User();
        }
        return self::$_instance;
    }
    public function create($fields = array()) {
        if(!$this->_db->insert('users', $fields)) {
            addMessage('error', t('The new user <i>@user</i> could not be created', array('@user' => $fields['username'])));
        }
        else {
            addMessage('success', t('The new user <i>@user</i> has been created', array('@user' => $fields['username'])));
        }
    }
    public function update($fields = array(), $id = null) {
        $username = '';
        if(!$id && $this->isLoggedIn()) {
            $id = $this->uid();
            $username = $this->username();
        }
        else {
            $username = $this->_db->getField('users', 'username', 'uid', $id);
        }
        if(!$this->_db->update('users', array('uid', $id), $fields)) {
            addMessage('error', t('The user <i>@user</i> could not be updated', array('@user' => $username)));
        }
        else {
            addMessage('success', t('The user <i>@user</i> has been updated', array('@user' => $username)));
        }
    }
    public function delete($uid) {
        $username = $this->_db->getField('users', 'username', 'uid', $uid);
        if(!$this->_db->delete('users', array('uid', '=', $uid))) {
            addMessage('error', t('The user <i>@user</i> could not be deleted', array('@user' => $username)));
        }
        else {
            addMessage('success', t('The user <i>@user</i> has been deleted', array('@user' => $username)));
        }
    }
    public function find($user = null) {
        if($user) {
            $field = (is_numeric($user)) ? 'uid' : 'username';
            $data = $this->_db->get('users', array($field, '=', $user));
            if($data->count()) {
                $this->_data = $data->first();
                return true;
            }
        }
        return false;
    }
    public function login($username = null, $password = null, $remember = false) {
        $user = $this->find($username);
        if(!$username && !$password && $this->exists()) {
            Session::put($this->_sessionName, $this->data()->uid);
        }
        else {
            $user = $this->find($username);
            if($user) {
                if($this->data()->password === Hash::validateHash($password, $this->data()->password)) {
                    Session::put($this->_sessionName, $this->data()->uid);
                    if($remember) {
                        $hash = Hash::unique();
                        $hashCheck = $this->_db->get('users_session', array('user_id', '=', $this->data()->uid));
                        if(!$hashCheck->count()) {
                            $this->_db->insert('users_session', array('user_id' => $this->data()->uid, 'hash' => $hash));
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
    
    public function enable($user_id) {
        $db = DB::getInstance();
        if($db->update('users', array('uid', $user_id), array('active' => 1))) {
            System::addMessage('success', t('The user <i>@user</i> has been enabled', array('@user' => $db->getField('users', 'name', 'uid', $user_id))));
            return true;
        }
        else {
            System::addMessage('error', t('There was an error while enabling the user'));
        }
        return false;
    }
    public function disable($user_id) {
        $db = DB::getInstance();
        if($db->update('users', array('uid', $user_id), array('active' => 1))) {
            System::addMessage('success', t('The user <i>@user</i> has been disabled', array('@user' => $db->getField('users', 'name', 'uid', $user_id))));
            return true;
        }
        else {
            System::addMessage('error', t('There was an error while disabling the user'));
        }
        return false;
    }
    public function logout() {
        $this->_db->delete('session', array('uid', '=', $this->uid()));
        Session::delete($this->_sessionName);
        Cookie::delete($this->_cookieName);
    }
    private function data() {
        return $this->_data;
    }
    public function username() {
        return (isset($this->_data->username)) ? $this->_data->username: false;
    }
    public function role() {
        return (isset($this->_data->role)) ? $this->_data->role: 0;
    }
    public function uid() {
        return (isset($this->_data->uid)) ? $this->_data->uid: false;
    }
    public function name() {
        return (isset($this->_data->name)) ? $this->_data->name: false;
    }
    public function email() {
        return (isset($this->_data->email)) ? $this->_data->email: false;
    }
    public function language() {
        return (isset($this->_data->language)) ? $this->_data->language: false;
    }
    public function active() {
        return $this->_data->active;
    }
    public function isLoggedIn() {
        return $this->_isLoggedIn;
    }
    public static function translateUID($uid, $field = 'name') {
        return ($uid != 0) ? DB::getInstance()->getField('users', $field, 'uid', $uid) : t('Anonymous user');
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
    public static function renderUserList($userlist) {
        if($userlist['uid'] == 1) {
            return '<tr>
                    <td>'.$userlist['user_name'].'</td><td>'.$userlist['username'].'</td>'.
                    ($userlist['user_role'] == 1) ? '<td>'.t('Admin').'</td>' : '<td>'.t('User').'</td>
                    <td><a href="/new_cms/admin/users/'.$userlist['uid'].'/edit" class="btn btn-rad btn-default">'.t('Edit User').'</a>
                    <a href="'.site_root().'/admin/users/'.$userlist['uid'].'/delete" class="btn btn-rad btn-danger disabled">'.t('Delete User').'</a>
                    <a href="'.site_root().'/admin/users/'.$userlist['uid'].'/disable" class="btn btn-rad btn-warning disabled">'.t('Disable User').'</a></td>
                </tr>';
        }
        else {
            return '<tr>
                    <td>'.$userlist['user_name'].'</td><td>'.$userlist['username'].'</td>'.
                    ($userlist['user_role'] == 1) ? '<td>Admin</td>' : '<td>User</td>
                    <td><a href="'.site_root().'/admin/users/'.$userlist['uid'].'/edit" class="btn btn-rad btn-default">'.t('Edit User').'</a>
                    <a href="'.site_root().'/admin/users/'.$userlist['uid'].'/delete" class="btn btn-rad btn-danger">'.t('Delete User').'</a>
                    <a href="'.site_root().'/admin/users/'.$userlist['uid'].'/disable" class="btn btn-rad btn-warning">'.t('Disable User').'</a></td>
                </tr>';
        }
    }
    public static function getUserList() {
        $db = DB::getInstance();
        $query = $db->getAll('users');
        $users = array();
        if(!$query->error()) {
            foreach($query->results() as $entity) {
                $users[] = new User($entity->uid);
            }
            return $users;
        }
        return false;
    }
}