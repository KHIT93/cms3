<?php
class Menu {
    private static $_instance;
    private $_db, $_data, $_menu;
    private function __construct($mid) {
        $this->_db = DB::getInstance();
        $query = $this->_db->get('menus', array('mid', '=', $mid), PDO::FETCH_ASSOC);
        if(!$query->error()) {
            $this->_data = $query->results();
        }
        $query = $this->_db->get('menu_links', array('mid', '=', $mid), PDO::FETCH_ASSOC);
        if(!$query->error()) {
            $this->_menu = $query->results();
        }
        else {
            $this->_data = array(0 => 'Unexpected error');
        }
    }
    public static function getInstance($mid = 1) {
        if(!isset(self::$_instance[$mid])) {
            self::$_instance[$mid] = new Menu($mid);
        }
        return self::$_instance[$mid];
    }
    public function menuItems() {
        return $this->_menu;
    }
    public function generateMenu() {
        $menuitems = array();
        foreach($this->_menu as $link) {
            $menuitems[] = array('id' => $link['mlid'], 'title' => $link['title'], 'parent' => $link['parent'], 'link' => $link['link']);
        }
        $tmp = array(0 => array('title' => 'root', 'children'=>array()));
        foreach($menuitems as $item) {
            $tmp[$item['id']] = isset($tmp[$item['id']]) ? array_merge($tmp[$item['id']],$item) : $item;
            $tmp[$item['parent']]['children'][] =& $tmp[$item['id']];
        }
        $db = NULL;
        $root = $tmp[0]['children'];
        return traverse($root, 'nav navbar-nav');
    }
    public function getMenuItems($menu_id) {
        $data = DB::getInstance()->get('menu_items', array('mid', '=', $menu_id));
        return (!$data->error()) ? $data->results() : false;
    }
    public static function getMenuLinkData($item_id) {
        $data = DB::getInstance()->get('menu_items', array('mlid', '=', $item_id));
        return (!$data->error()) ? $data->first() : false;
    }
    public function delete($menu_id) {
        $db = DB::getInstance();
        $count = $db->get('menus', array('mid', '=', $menu_id))->count();
        $name = $db->getField('menus', 'name', 'mid', $menu_id);
        if($count > 0) {
            $count_items = $db->get('menu_items', array('mid', '=', $menu_id))->count();
            if($count_items > 0) {
                //Delete associated menu items
                if($db->delete()->error()) {
                    System::addMessage('error', t('The menu items associated with <i>@menu</i> could not be deleted', array('@menu' => $name)));
                }
            }
            if($db->delete()->error()) {
                System::addMessage('error', t('The menu <i>@menu</i> could not be deleted', array('@menu' => $name)));
            }
            else {
                System::addMessage('success', t('The menu <i>@menu</i> has been deleted', array('@menu' => $name)));
                return true;
            }
        }
        return false;
    }
    public static function addMenuItem($mid, $title, $link, $parent) {
        $data = array(
            'mid' => $mid,
            'title' => $title,
            'link' => $link,
            'parent' => $parent,
            'position' => 0,
            'show' => 1
        );
        if(!$this->_db->insert('menu_items', $data)) {
            System::addMessage('error', t('There was an error while creating the new menu item <i>@menu_item</i> in the menu <i>@menu</i>', array('@menu' => $db->getField('menus', 'name', 'mid', $mid), '@menu_item' => $title)));
        }
    }
    public function updateMenuItem($formdata) {
        $fields = array(
            'mid' => $formdata['mid'],
            'title' => $formdata['title'],
            'link' => $formdata['link'],
            'parent' => $formdata['parent'],
            'position' => $formdata['position'],
            'show' => $formdata['show']
        );
        $id = $formdata['mlid'];
        if(!$this->_db->update('users', $id, $fields)) {
            System::addMessage('error', t('There was an error while updating the menu item <i>@menu_item</i> in the menu <i>@menu</i>', array('@menu' => $db->getField('menus', 'name', 'mid', $fields['mid']), '@menu_item' => $title)));
        }
    }
    public function deleteMenuItem($item_id) {
        $db = DB::getInstance();
        $name = $db->getField('menu_items', 'title', 'mlid', $item_id);
        $count = $db->get('menu_items', array('mlid', '=', $item_id))->count();
        if($count > 0) {
            if($db->delete('menu_items', array('mlid', '=', $item_id))->error()) {
                System::addMessage('error', t('The menu item @menu_item could not be deleted', array('@menu_item' => $name)));
            }
            else {
                System::addMessage('success', t('The menu item <i>@menu_item</i> has been deleted', array('@menu_item' => $name)));
                return true;
            }
        }
        else {
            System::addMessage('error', t('The menu item does not exist or URL was not typed correctly'));
        }
        return false;
    }
    public static function getMenus() {
        $data = DB::getInstance()->getAll('menus');
        return (!$data->error()) ? $data->results() : false;
    }
}