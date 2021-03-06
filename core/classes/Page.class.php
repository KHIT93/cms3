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
        return (is_int($page) ||  is_string($page)) ? true : false;

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
    public static function create($formdata) {
        $db = DB::getInstance();
        $pid = getNextId('pages');
        $fields = array(
            'title' => $formdata['title'],
            'content' => $formdata['body'],
            'author' => User::getInstance()->uid(),
            'status' => $formdata['published'],
            'access' => '{"any" : "true"}',
            'keywords' => $formdata['keywords'],
            'description' => $formdata['description'],
            'robots' => implode(',', $formdata['robots']),
            'created' => date("Y-m-d"),
            'last_updated' => date("Y-m-d")
        );
        if(!$db->insert('pages', $fields)) {
            System::addMessage('error', t('The new page <i>@page</i> could not be created', array('@page' => $fields['title'])));
        }
        else {
            $alias = (hasValue($formdata['alias'])) ? $formdata['alias'] : generateURL($fields['title']);
            if(hasValue($alias)) {
                //Add url alias
                if(!$db->insert('url_alias', array('source' => 'pages/'.$pid, 'alias' => $alias))) {
                    System::addMessage('error', t('There was an error while creating the URL Alias for <i>@title</i>', array('@title' => $fields['title'])));
                }
            }
            if($formdata['menu'] != 'disabled' || is_numeric($formdata['menu'])) {
                $menudata = array(
                    'mid' => $formdata['inputMenu'],
                    'title' => $formdata['title'],
                    'link' => $alias,
                    'parent' => 0
                );
                Menu::addMenuItem($menudata);
            }
            System::addMessage('success', t('The page @page has been created', array('@page' => $fields['title'])));
            return true;
            
        }
        return false;
    }
    public static function update($formdata) {
        $db = DB::getInstance();
        $pid = array('pid', $formdata['pid']);
        $fields = array(
            'title' => $formdata['title'],
            'content' => $formdata['body'],
            'status' => $formdata['published'],
            'access' => '{"any" : "true"}',
            'keywords' => $formdata['keywords'],
            'description' => $formdata['description'],
            'robots' => implode(',', $formdata['robots']),
            'last_updated' => date("Y-m-d")
        );
        if($db->update('pages', $pid, $fields)) {
            $alias = (hasValue($formdata['alias']) && $formdata['alias'] == $db->getField('url_alias', 'alias', 'source', 'pages/'.$pid[1])) ? $formdata['alias'] : generateURL($fields['title']);
            if(hasValue($alias) && DB::getInstance('url_alias', 'alias', 'source', 'pages/'.$pid[1]) != $alias) {
                //Update url alias
                if(!$db->update('url_alias', array('aid', $db->getField('url_alias', 'aid', 'source', 'pages/'.$pid[1])), array('source' => 'pages/'.$pid[1], 'alias' => $alias))) {
                    System::addMessage('error', t('There was an error while creating the URL Alias for <i>@title</i>', array('@title' => $fields['title'])));
                }
            }
            if(isset($formdata['enable_item'])) {
                if($formdata['menu'] != 'disabled' || is_numeric($formdata['menu'])) {
                    $menudata = array(
                        'mlid' => $db->getField('menu_links', 'mlid', 'link', $alias),
                        'mid' => $formdata['menu'],
                        'title' => $formdata['title'],
                        'link' => $alias,
                        'parent' => 0
                    );
                    if(hasValue($menudata['mlid'])) {
                        Menu::updateMenuItem($menudata);
                    }
                    else {
                        Menu::addMenuItem($menudata);
                    }
                }
            }
            else {
                //Delete menu item
            }
            System::addMessage('success', t('The page @page has been updated', array('@page' => $fields['title'])));
            return true;
        }
        else {
            System::addMessage('error', t('The page <i>@page</i> could not be updated', array('@page' => $fields['title'])));
        }
        return false;
    }
    public static function delete($page_id) {
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
            if($db->delete('pages', array('pid', '=', $pid))->error()) {
                System::addMessage('error', t('The page <i>@page</i> has not been deleted', array('@page', $name)));
            }
            else {
                if(!$db->delete('url_alias', array('source', '=', 'pages/'.$pid))->error()) {
                    System::addMessage('success', t('The page <i>@page</i> has been deleted'));
                }
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