<?php
class Page {
    private static $_instance;
    private $_db;
    public $data;
    private function __construct($pid) {
        $this->_db = DB::getInstance();
        //$id = (is_array($get_url)) ? (int)$get_url[1] : (int)$get_url;
        $page = array();
        $query = $this->_db->get('pages', array('pid', '=', $pid), PDO::FETCH_ASSOC);
        if(!$query->error()) {
            $this->data = $query->results()[0];
        }
        
    }
    public static function getInstance($pid) {
        if(!isset(self::$_instance)) {
            self::$_instance = new Page($pid);
        }
        return self::$_instance;
    }
    public static function exists($get_url) {
        if(is_array($get_url)) {
            //$url = implode('/', $get_url);
            addMessage('error', t('Expected string but got array'));
        }
        else {
            $url = $get_url;
        }
        $page = DB::getInstance()->getField('pages', 'pid', 'pid', $url);
        return (empty($page)) ? false : true;

    }
    public function getMetaRobots() {
        return explode(',', $this->data['robots']);
    }
    public function pageAccess($uid = 0) {
        $page_access = json_decode($this->_db->getField('pages', 'access', 'pid', 1), true);
        if(isset($page_access['any'])) {
            if($page_access['any'] == true) {
                return true;
            }
        }
        else {
            if(User::getInstance()->role() == DB::getInstance()->getField('roles', 'rid', 'name', 'Administrator')) {
                return true;
            }
            else {
                foreach ($this->_db->getAll('roles', PDO::FETCH_ASSOC) as $rid => $name) {
                    if(isset($page_access[$rid])) {
                        if($page_access[$rid] == true) {
                            return true;
                        }
                    }
                }
            }
        }
        return false;
    }
    public function create($formdata) {
        $db = DB::getInstance();
        $pid = $db->query("SHOW TABLE STATUS LIKE 'pages'")->first();
        $fields = array(
            'title' => $formdata['title'],
            'content' => $formdata['body'],
            'author' => User::getInstance()->name(),
            'status' => $formdata['status'],
            'access' => $formdata['access'],
            'keywords' => $formdata['keywords'],
            'description' => $formdata['description'],
            'robots' => implode(',', $formdata['robots']),
            'created' => date("Y-m-d"),
            'last_updated' => date("Y-m-d")
        );
        if($db->insert('pages', $fields)) {
            $alias = (hasValue($formdata['alias'])) ? $formdata['alias'] : generateURL($fields['title']);
            if(hasValue($alias)) {
                //Add url alias
                if(!$db->insert('url_alias', array('source' => 'pages/'.$pid, 'alias' => $alias))) {
                    System::addMessage('error', t('There was an error while creating the URL Alias for <i>@title</i>', array('@title' => $fields['title'])));
                }
            }
            if(isset($formdata['enable_item'])) {
                Menu::addMenuItem($formdata['inputMenu'], $formdata['title'], $alias);
            }
            System::addMessage('success', t('The page @page has been created', array('@page' => $fields['title'])));
            return true;
        }
        else {
            System::addMessage('error', t('The new page <i>@page</i> could not be created', array('@page' => $fields['title'])));
        }
        return false;
    }
    public function update($formdata) {
        $db = DB::getInstance();
        $pid = $formdata['pid'];
        $fields = array(
            'title' => $formdata['title'],
            'content' => $formdata['body'],
            'status' => $formdata['status'],
            'access' => $formdata['access'],
            'keywords' => $formdata['keywords'],
            'description' => $formdata['description'],
            'robots' => implode(',', $formdata['robots']),
            'last_updated' => date("Y-m-d")
        );
        if($db->update('pages', $pid, $fields)) {
            $alias = (hasValue($formdata['alias']) && $formdata['alias'] == $db->getField('url_alias', 'alias', 'source', 'pages/'.$pid)) ? $formdata['alias'] : generateURL($fields['title']);
            if(hasValue($alias)) {
                //Add url alias
                if(!$db->update('url_alias', array('source' => 'pages/'.$pid, 'alias' => $alias))) {
                    System::addMessage('error', t('There was an error while creating the URL Alias for <i>@title</i>', array('@title' => $fields['title'])));
                }
            }
            if(isset($formdata['enable_item'])) {
                Menu::updateMenuItem($formdata['inputMenu'], $formdata['title'], $alias);
            }
            System::addMessage('success', t('The page @page has been created', array('@page' => $fields['title'])));
            return true;
        }
        else {
            System::addMessage('error', t('The new page <i>@page</i> could not be created', array('@page' => $fields['title'])));
        }
        return false;
    }
    public function delete($page_id) {
        $db = DB::getInstance();
        $name = $db->getField('pages', 'title', 'pid', $page_id);
        $pid = (int)$page_id;
        $page = $db->get('pages', array('pid', '=', $pid))->count();
        if($page > 0) {
            //Check if the page has associated a menu-item
            $count = $db->get('menu_items', array('pid', '=', $pid))->count();
            if(isset($count) && $count > 0) {
                deleteMenuItem($item_id);
            }
            if($db->delete('pages', array('pid', '=', $pid))) {
                System::addMessage('error', t('The page <i>@page</i> has been deleted', array('@page', $name)));
            }
        }
        else {
            addMessage('error', t('Page does not exist or URL was not typed correctly'));
        }
    }
    public static function getPageData($pid) {
        $page = new Page($pid);
        return $page;
    }
    public static function getPageList() {
        $pages = array();
        if(has_permission('access_admin_content', Session::exists(Config::get('session/session_name'))) === true) {
            $query = DB::getInstance()->getAll('pages');
            if(!$query->error()) {
                foreach($query->results() as $data) {
                    $pages[] = new Page($data->pid);
                }
            }
        }
        return $pages;
    }
}