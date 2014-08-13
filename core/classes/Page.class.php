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
        return explode(', ', $this->data->robots);
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
        $db = db_connect();
        $pid = $db->query("SHOW TABLE STATUS LIKE 'pages'")->first();
        $db = DB::getInstance();
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
        $alias = (hasValue($formdata['alias'])) ? $formdata['alias'] : generateURL($fields['title']);
        if(hasValue($alias)) {
            //Add url alias
        }
        if(isset($formdata['enable_item'])) {
            Menu::addMenuItem($formdata['inputMenu'], $formdata['title'], $alias);
        }
    }
    public function update($formdata) {
        $db = db_connect();
        //print_r($formdata);
        $fields = array();
        $values = array();
        $fields[] = 'page_id';
        $values[] = (int)$formdata['page_id'];
        $fields[] = 'page_title';
        $values[] = check_plain($formdata['title']);
        $fields[] = 'page_content';
        $values[] = $formdata['body'];
        $fields[] = 'page_access';
        $values[] = $formdata['published'];
        $fields[] = 'page_url';
        $values[] = $formdata['page_url'];
        $fields[] = 'update_date';
        $values[] = date('Y-m-d');
        if(isset($formdata['meta_keywords'])) {
            $fields[] = 'meta_keywords';
            $values[] = $formdata['meta_keywords'];
        }
        if(isset($formdata['meta_description'])) {
            $fields[] = 'meta_description';
            $values[] = $formdata['meta_description'];
        }
        if(isset($formdata['metaRobots'])) {
            $fields[] = 'meta_robots';
            $values[] = implode(', ', $formdata['metaRobots']);
        }
        if(isset($formdata['url_alias'])) {
            $fields[] = 'page_alias';
            $values[] = check_plain($formdata['url_alias']);
        }
        else {
            $fields[] = 'page_alias';
            $values[] = createPageURL($formdata['title']);
        }
        //print "<p>INSERT INTO `pages` ({$q_fields}) VALUES({$q_values})</p>";
        $query = $db->prepare("UPDATE `pages` SET `$fields[1]`='$values[1]', `$fields[2]`='$values[2]', `$fields[3]`='$values[3]', `$fields[4]`='$values[4]', `$fields[5]`='$values[5]', `$fields[6]`='$values[6]', `$fields[7]`='$values[7]', `$fields[8]`='$values[8]', `$fields[9]`='$values[9]' WHERE `$fields[0]`='$values[0]'");
        try {
            $query->execute();
            addMessage('success', t('Page has been successfully updated'));
        }
        catch(PDOException $e) {
            addMessage('error', t('There was an error updating the page').' '.check_plain($formdata['title']), $e);
            //die($e->getMessage());        
        }
        $db = NULL;
    }
    public function delete($page_id) {
        $db = db_connect();
        $page_id = (int)$page_id;
        $query = $db->prepare("SELECT COUNT(*) FROM `pages` WHERE `page_id`=:page_id");
        $query->bindValue(':page_id', $page_id, PDO::PARAM_INT);
        try {
            $query->execute(); //Executes query

            $page = $query->fetchColumn();
        }
        catch (Exception $e) {
            addMessage('error', t('There was an error while querying the pagedata'), $e);
            //die($e->getMessage());
        }
        if($page > 0) {
            //Check if page has associated a menu-item
            $query = $db->prepare("SELECT COUNT(*) FROM `menu_items` AS `m`, `pages` AS `p` WHERE `p`.`page_alias`=`m`.`item_link` AND `p`.`page_id`=:page_id");
            $query->bindValue(':page_id', $page_id, PDO::PARAM_INT);
            try {
                $query->execute(); //Executes query

                $count = $query->fetchColumn();
            }
            catch (Exception $e) {
                addMessage('error', t('There was an error while querying the menu items'), $e);
                //die($e->getMessage());
            }
            if(isset($count) && $count > 0) {
                $query = $db->prepare("SELECT `item_id` FROM `menu_items` AS `m`, `pages` AS `p` WHERE `p`.`page_alias`=`m`.`item_link` AND `p`.`page_id`=:page_id");
                $query->bindValue(':page_id', $page_id, PDO::PARAM_INT);
                try {
                    $query->execute(); //Executes query

                    $item_id = $query->fetchColumn();
                }
                catch (Exception $e) {
                    addMessage('error', t('There was an error while processing the request'), $e);
                    //die($e->getMessage());
                }
                deleteMenuItem($item_id);
                //Delete page
                $query = $db->prepare("DELETE FROM  `pages` WHERE `page_id`=:page_id");
                $query->bindValue(':page_id', $page_id, PDO::PARAM_INT);
                try {
                    $query->execute(); //Executes query
                    addMessage('success', t('The page has been deleted'));
                }
                catch (Exception $e) {
                    addMessage('error', t('There was an error while deleting the page'), $e);
                    //die($e->getMessage());
                }
            }
            else {
                //Delete page
                $query = $db->prepare("DELETE FROM  `pages` WHERE `page_id`=:page_id");
                $query->bindValue(':page_id', $page_id, PDO::PARAM_INT);
                try {
                    $query->execute(); //Executes query
                    addMessage('success', t('The page has been deleted'));
                }
                catch (Exception $e) {
                    addMessage('error', t('There was an error while deleting the page'), $e);
                    //die($e->getMessage());
                }
            }
        }
        else {
            addMessage('error', t('Page does not exist or URL was not typed correctly'));
        }
        $db = NULL;
    }
    public static function getPageData($pid) {
        $page = new Page($pid);
        return $page->data;
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