<?php
class Page {
    public function get($get_url) {
        $id = (is_array($get_url)) ? (int)$get_url[1] : $get_url;
        $db = db_connect();
        $page = array();
        $query = $db->prepare("SELECT * FROM `pages` WHERE `page_id`=:page_id");
        $query->bindValue(':page_id', $id, PDO::PARAM_INT);
        try {
            $query->execute(); //Executes query

            $page = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (Exception $e) {
            addMessage('error', t('There was an error while querying the database for the current page'), $e);
            //die($e->getMessage());
        }
        $db = NULL;
        return $page[0];

    }
    public function exists($get_url) {
        if(is_array($get_url)) {
            //$url = implode('/', $get_url);
            addMessage('error', t('Expected String but got Array'));
        }
        else {
            $url = $get_url;
        }
        $page = getFieldFromDB('pages', 'page_id', 'page_id', $url);
        return (empty($page)) ? false : true;

    }
    public function getMetaRobots($page) {
        return explode(', ', $page['meta_robots']);
    }
    public function pageAccess($page_id, $uid = 0) {
        $page_access = getFieldFromDB('pages', 'page_access', 'page_id', $page_id);
        if($page_access == 1) {
            return true;
        }
        else if($page_access == 2) {
            if(logged_in()) {
                return true;
            }
            else {
                return false;
            }
        }
        else {
            return false;
        }
    }
    public function create($formdata) {
        $db = db_connect();
        //print_r($formdata);
        $fields = array();
        $values = array();

        $fields[] = 'page_title';
        $values[] = check_plain($formdata['title']);
        $fields[] = 'page_content';
        $values[] = $formdata['body'];
        $fields[] = 'page_access';
        $values[] = $formdata['published'];
        $query = $db->query("SHOW TABLE STATUS LIKE 'pages'");
        $row = $query->fetchAll(PDO::FETCH_ASSOC);
        $page_id = $row[0]['Auto_increment'];
        $fields[] = 'page_url';
        $values[] = 'page/'.$page_id;
        $fields[] = 'create_date';
        $values[] = date('Y-m-d');
        $fields[] = 'update_date';
        $values[] = date('Y-m-d');
        if(isset($formdata['url_alias'])) {
            $fields[] = 'page_alias';
            $values[] = check_plain($formdata['url_alias']);
        }
        else {
            $fields[] = 'page_alias';
            $values[] = createPageURL($formdata['title']);
        }
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
        $q_fields = '`'.implode('`, `', $fields).'`';
        $q_values = "'".implode("', '", $values)."'";
        $query = $db->prepare("INSERT INTO `pages` ({$q_fields}) VALUES({$q_values})");
        try {
            $query->execute();
            addMessage('success', t('New page has been created'));
        }
        catch(PDOException $e) {
            addMessage('error', t('There was an error creating the new page').' '.check_plain($formdata['title']), $e);
            //die($e->getMessage());        
        }
        if(isset($formdata['enable_item'])) {
            addMenuItem($formdata['inputMenu'], $formdata['title'], $values[6]);
        }
        $db = NULL;
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
    public static function getPageData($get_url) {
        $id = (int)$get_url[2];
        $db = db_connect();
        $page = array();
        $query = $db->prepare("SELECT `page_id`, `page_title`, `page_content`, `page_access`, `page_url`, `page_alias`, `meta_keywords`, `meta_description`, `meta_robots`, `is_front` FROM `pages` WHERE `page_id`=:page_id");
        $query->bindValue(':page_id', $id, PDO::PARAM_INT);
        try {
            $query->execute(); //Executes query

            $page = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (Exception $e) {
            addMessage('error', t('There was an error while processing the request'), $e);
            //die($e->getMessage());
        }
        $db = NULL;
        return $page[0];
    }
    public static function getPageList() {
        if(has_permission('access_admin_content', $_SESSION['uid']) === true) {
            $db = db_connect();
            $query = $db->prepare("SELECT `page_id`, `page_title`, `page_author`, `page_access`, `update_date` FROM `pages`");
            try {
                $query->execute();
                $pages = $query->fetchAll(PDO::FETCH_ASSOC);
            }
            catch(PDOException $e) {
                addMessage('error', t('There was an error while generating the pagelist. Please contact your administrator if this error persists'), $e);
                //die($e->getMessage());
            }
            if(isset($pages) && is_array($pages)) {
                foreach($pages as $content) {
                    switch($content['page_access']) {
                        case 0:
                            $content['page_access'] = t('Unpublished');
                        break;
                        case 1:
                            $content['page_access'] = t('Published');
                        break;
                        case 2:
                            $content['page_access'] = t('Login required');
                        break;
                        case 3:
                            $content['page_access'] = t('Admin only');
                        break;
                        default :
                            $content['page_access'] = t('Invalid').' - '.$content['page_access'];
                        break;
                    }                
                }
            }
            $db = NULL;
        }
        return (isset($pages) && is_array($pages)) ? $pages : FALSE;
    }
}