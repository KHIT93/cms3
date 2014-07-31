<?php
class Menu {
    public function generateMenu($menu_id) {
        $db = db_connect();
        $menuitems = array();
        $query = $db->prepare("SELECT `item_id` AS `id`, `item_title` AS `title`, `item_parent` AS `parent`, `item_link` AS `link` FROM `menu_items` WHERE `menu_id`=:menu_id ORDER BY `item_position`");
        $query->bindValue(':menu_id', $menu_id, PDO::PARAM_INT);
        try {
            $query->execute();
            while($row = $query->fetch(PDO::FETCH_ASSOC)) {
                $menuitems[] = array('id' => $row['id'], 'title' => $row['title'], 'parent' => $row['parent'], 'link' => $row['link']);
            }
        }
        catch (Exception $e) {
            addMessage('error', t('There was an error while querying the database for the menu with ID:').' '.$menu_id.t('Please contact your administrator if the error persists'), $e);
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
        $db = db_connect();
        $query = $db->prepare("SELECT `item_id`, `item_title` FROM `menu_items` WHERE `menu_id`=:menu_id");
        $query->bindValue(':menu_id', (int)$menu_id, PDO::PARAM_INT);
        try {
            $query->execute();
            $menu_items = $query->fetchAll(PDO::FETCH_ASSOC);
            $db = NULL;
            return $menu_items;
        }
        catch (Exception $e) {
            addMessage('error', t('There was an error while processing the request'), $e);
            $db = NULL;
            return false;
        }
    }
    public function getMenuLinkData($item_id) {
        $db = db_connect();
        $query = $db->prepare("SELECT `item_id`, `item_title`, `item_link` FROM `menu_items` WHERE `item_id`=:item_id");
        $query->bindValue(':item_id', (int)$item_id, PDO::PARAM_INT);
        try {
            $query->execute();
            $menu_item = $query->fetchAll(PDO::FETCH_ASSOC);
            $db = NULL;
            return $menu_item[0];
        }
        catch (Exception $e) {
            addMessage('error', t('There was an error while processing the request'), $e);
            $db = NULL;
            return false;
        }
    }
    public function delete($menu_id) {
        $db = db_connect();
        $query = $db->prepare("SELECT COUNT(*) FROM `menus` WHERE `menu_id`=:menu_id");
        $query->bindValue(':menu_id', $menu_id, PDO::PARAM_INT);
        try {
            $query->execute(); //Executes query

            $count = $query->fetchColumn();
        }
        catch (Exception $e) {
            addMessage('error', t('There was an error while querying the menudata'), $e);
            //die($e->getMessage());
        }
        if($count > 0) {
            $query = $db->prepare("SELECT COUNT(*) FROM `menu_items` WHERE `menu_id`=:menu_id");
            $query->bindValue(':menu_id', $menu_id, PDO::PARAM_INT);
            try {
                $query->execute(); //Executes query

                $count_items = $query->fetchColumn();
            }
            catch (Exception $e) {
                addMessage('error', t('There was an error while querying the menudata'), $e);
                //die($e->getMessage());
            }
            if($count_items > 0) {
                //Delete menu-items
                $query = $db->prepare("DELETE FROM  `menu_items` WHERE `menu_id`=:menu_id");
                $query->bindValue(':menu_id', $item_id, PDO::PARAM_INT);
                try {
                    $query->execute(); //Executes query
                    addMessage('success', t('All attached menu items have been deleted'));
                }
                catch (Exception $e) {
                    addMessage('error', t('There was an error while deleting the menu items'), $e);
                    //die($e->getMessage());
                }
                //Delete menu
                $query = $db->prepare("DELETE FROM  `menus` WHERE `menu_id`=:menu_id");
                $query->bindValue(':item_id', $item_id, PDO::PARAM_INT);
                try {
                    $query->execute(); //Executes query
                    addMessage('success', t('The menu has been deleted'));
                }
                catch (Exception $e) {
                    addMessage('error', t('There was an error while deleting the menu'), $e);
                    //die($e->getMessage());
                }
            }
            else {
                //Delete menu
                $query = $db->prepare("DELETE FROM  `menus` WHERE `menu_id`=:menu_id");
                $query->bindValue(':item_id', $item_id, PDO::PARAM_INT);
                try {
                    $query->execute(); //Executes query
                    addMessage('success', t('The menu has been deleted'));
                }
                catch (Exception $e) {
                    addMessage('error', t('There was an error while deleting the menu'), $e);
                    //die($e->getMessage());
                }
            }

        }
        else {
            addMessage('error', t('Menu does not exist or URL was not typed correctly'));
        }
        $db = NULL;
    }
    public function addMenuItem($menu_id, $item_title, $item_link) {
        $db = db_connect();
        $query = $db->prepare("INSERT INTO `menu_items` (`menu_id`, `item_title`, `item_parent`, `item_link`, `item_position`) VALUES(:menu_id, :item_title, 0, :item_link, 0)");
        $query->bindValue(':menu_id', $menu_id, PDO::PARAM_INT);
        $query->bindValue(':item_title', $item_title, PDO::PARAM_STR);
        $query->bindValue(':item_link', $item_link, PDO::PARAM_STR);
        try {
            $query->execute();
            addMessage('success', t('New menu item has been created'));
        }
        catch(PDOException $e) {
            addMessage('error', t('There was an error creating the new menu item').' '.$item_title, $e);
        }
        $db = NULL;
    }
    public function updateMenuItem($formdata) {
        $db = db_connect();
        $query = $db->prepare("UPDATE `menu_items` SET `item_title`=:item_title, `item_link`=:item_link WHERE `item_id`=:item_id");
        $query->bindValue(':item_id', $formdata['inputId'], PDO::PARAM_INT);
        $query->bindValue(':item_title', $formdata['inputTitle'], PDO::PARAM_STR);
        $query->bindValue(':itel_link', $formdata['inputLink'], PDO::PARAM_STR);
        try {
            $query->execute();
            addMessage('success', t('Menu item has been saved succesfully'));
        }
        catch(PDOException $e) {
            addMessage('error', t('There was an error updating the menu item').' '.check_plan($formdata['inputTitle']), $e);
            //die($e->getMessage());
        }
        $db = NULL;
    }
    public function deleteMenuItem($item_id) {
        $db = db_connect();
        $query = $db->prepare("SELECT COUNT(*) FROM `menu_items` WHERE `item_id`=:item_id");
        $query->bindValue(':item_id', $item_id, PDO::PARAM_INT);
        try {
            $query->execute(); //Executes query

            $count = $query->fetchColumn();
        }
        catch (Exception $e) {
            addMessage('error', t('There was an error while processing the request'), $e);
            //die($e->getMessage());
        }
        print $count;
        if($count > 0) {
            //Delete menu-item
            $query = $db->prepare("DELETE FROM  `menu_items` WHERE `item_id`=:item_id");
            $query->bindValue(':item_id', $item_id, PDO::PARAM_INT);
            try {
                $query->execute(); //Executes query
                addMessage('success', t('The menu-item has been deleted'));
            }
            catch (PDOException $e) {
                addMessage('error', t('There was an error while deleting the menu item'), $e);
                //die($e->getMessage());
            }
        }
        else {
            addMessage('error', t('Menu-item does not exist or URL was not typed correctly'));
        }
        $db = NULL;
    }
    public static function getMenus() {
        $db = db_connect();
        $query = $db->prepare("SELECT `menu_id`, `menu_name` FROM `menus`");
        try {
            $query->execute(); //Executes query

            $menus = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (Exception $e) {
            addMessage('error', t('There was an error while querying the menudata'), $e);
            //die($e->getMessage());
        }
        $db = NULL;
        return $menus;
    }
}