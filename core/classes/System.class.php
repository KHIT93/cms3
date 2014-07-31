<?php
class System {
    public static function getAdminMenu() {
        $items = array();
        $menu = array();
        if(has_permission('access_admin', $_SESSION['uid']) === true) {
            $items[] = array(
                'title' => '<i class="fa fa-home fa-lg"></i> '.t('Site'),
                'link' => 'admin/dashboard',
                'children' => array(
                    array(
                        'title' => t('Go to homepage'),
                        'link' => 'admin/content/add/page'
                    ),
                    array(
                        'title' => t('Modules'),
                        'link' => 'admin/modules'
                    ),
                    array(
                        'title' => t('Users'),
                        'link' => 'admin/users'
                    ),
                    array(
                        'title' => t('Settings'),
                        'link' => 'admin/settings'
                    )
                )
            );
        }
        if(has_permission('access_admin', $_SESSION['uid']) === true) {
            $items[] = array(
                'title' => '<i class="fa fa-file-text-o"></i> '.t('Add content'),
                'link' => 'admin/content/add',
                'children' => array(
                    array(
                        'title' => t('Page'),
                        'link' => 'admin/content/add/page'
                    )
                )
            );
        }
        if(has_permission('access_admin', $_SESSION['uid']) === true) {
            $items[] = array(
                'title' => '<i class="fa fa-question fa-lg"></i> '.t('Help'),
                'link' => 'admin/help'
            );
        }
        $admin_menu = traverse($items, 'nav navbar-nav', true);
        return $admin_menu;
    }
    public static function getAdminSideBar() {
        $items = array();
        $menu = array();
        if(has_permission('access_admin_dashboard', $_SESSION['uid']) === true) {
            $items[] = array(
                'title' => '<i class="fa fa-dashboard nav-icon"></i><span>'.t('Dashboard').'</span>',
                'link' => 'admin'
            );
        }
        if(has_permission('access_admin_content', $_SESSION['uid']) === true) {
            $items[] = array(
                'title' => '<i class="fa fa-file nav-icon"></i><span>'.t('Content').'</span>',
                'link' => 'admin/content'
            );
        }
        if(has_permission('access_admin_layout', $_SESSION['uid']) === true) {
            $items[] = array(
                'title' => '<i class="fa fa-picture-o nav-icon"></i><span>'.t('Layout').'</span>',
                'link' => 'admin/layout',
                'children' => array(
                    array(
                        'title' => t('Menus'),
                        'link' => 'admin/layout/menus'
                    ),
                    array(
                        'title' => t('Themes'),
                        'link' => 'admin/layout/themes'
                    ),
                    array(
                        'title' => t('Widgets'),
                        'link' => 'admin/layout/widgets'
                    )
                )
            );
        }
        if(has_permission('access_admin_modules', $_SESSION['uid']) === true) {
            $items[] = array(
                'title' => '<i class="fa fa-cubes nav-icon"></i><span>'.t('Modules').'</span>',
                'link' => 'admin/modules'
            );
        }
        if(has_permission('access_admin_users', $_SESSION['uid']) === true) {
            $items[] = array(
                'title' => '<i class="fa fa-user nav-icon"></i><span>'.t('Users').'</span>',
                'link' => 'admin/users'
            );
        }
        if(has_permission('access_admin_settings', $_SESSION['uid']) === true) {
            $items[] = array(
                'title' => '<i class="fa fa-wrench nav-icon"></i><span>'.t('Settings').'</span>',
                'link' => 'admin/settings'
            );
        }
        $admin_menu = sidebar_traverse($items, 'cl-vnavigation');
        return $admin_menu;
    }
    public static function getDashboard() {
        $db = db_connect();
        $dashboard = array();
        $query = $db->prepare("SELECT `page_id`, `page_title`, `page_author` FROM `pages` ORDER BY `create_date` DESC LIMIT 5");
        try {
            $query->execute(); //Executes query

            $dashboard['pages'] = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (Exception $e) {
            addMessage('error', t('There was an error while querying the pagedata'), $e);
            //die($e->getMessage());
        }
        $query = $db->prepare("SELECT `uid`, `user_name`  FROM `users` ORDER BY `uid` DESC LIMIT 5");
        try {
            $query->execute(); //Executes query

            $dashboard['users'] = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (Exception $e) {
            addMessage('error', t('There was an error while querying the userdata'), $e);
            //die($e->getMessage());
        }
        $db = NULL;
        return $dashboard;
    }
    public static function runCron() {
        foreach(Modules::activeModules() as $module) {
            if(Modules::moduleImplements($module, 'cron')) {
                call_user_func($module.'_cron');
            }
        }
        sysguard_add_event(date("Y-m-d:H:i:s"), 'cron', 'Cron has been successfully executed');
        addMessage('info', t('Cron has been completed'));
    }
    public static function setDevMode($formdata) {
        $db = db_connect();
        $query = $db->prepare("UPDATE `config` SET `config_value`=:devmode WHERE `config_name`='enable_wysiwyg'");
        $query->bindValue(':devmode', $formdata['inputDevMode'], PDO::PARAM_INT);
        try {
            $query->execute();
            addMessage('success', t('Changes have been saved'));
        }
        catch (Exception $e) {
            addMessage('error', t('There was an error while updating the settings'), $e);
        }
        $db = NULL;
    }
    public static function root() {
        global $config;
        if(isset($config['site_root'])) {
            return $config['site_root'];
        }
        else {
            return $_SERVER['DOCUMENT_ROOT'];
        }
    }
    public static function print_messages() {
        //Outputs the different messages
        $output = array();
        if(!empty($_SESSION['messages']['info'])) {
            $output[] = '<div class="alert alert-info alert-box alert-dismissable fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><p><span class="glyphicon glyphicon-info-sign"></span> '.implode('</p><p><span class="glyphicon glyphicon-info-sign"></span> ', $_SESSION['messages']['info']).'</p></div>';
        }
        if(!empty($_SESSION['messages']['success'])) {
            $output[] = '<div class="alert alert-success alert-box alert-dismissable fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><p><span class="glyphicon glyphicon-saved"></span> '.implode('</p><p><span class="glyphicon glyphicon-saved"></span> ', $_SESSION['messages']['success']).'</p></div>';
        }
        if(!empty($_SESSION['messages']['warning'])) {
            $output[] = '<div class="alert alert-warning alert-box alert-dismissable fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4>'.t('Warning').'!</h4><p><span class="glyphicon glyphicon-warning-sign"></span> '.implode('</p><p><span class="glyphicon glyphicon-warning-sign"></span> ', $_SESSION['messages']['warning']).'</p></div>';
        }
        if(!empty($_SESSION['messages']['error'])) {
            $output[] = '<div class="alert alert-danger alert-box alert-dismissable fade in"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><h4>'.t('Error').'!</h4><p><span class="glyphicon glyphicon-remove"></span> '.implode('</p><p><span class="glyphicon glyphicon-remove"></span> ', $_SESSION['messages']['error']).'</p></div>';
        }
        /*if(empty($_SESSION['messages'])) {
            $output[] = '<div class="alert alert-info alert-box alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><p>No messages saved</p></div>';
        }*/
        unset($_SESSION['messages']);
        return implode('', $output);
    }
    public static function print_messages_simple() {
        //Outputs the different messages
        $output = array();
        if(!empty($_SESSION['messages']['info'])) {
            $output[] = '<div class="alert alert-info alert-box fade in"><p><span class="glyphicon glyphicon-info-sign"></span> '.implode('</p><p><span class="glyphicon glyphicon-info-sign"></span> ', $_SESSION['messages']['info']).'</p></div>';
        }
        if(!empty($_SESSION['messages']['success'])) {
            $output[] = '<div class="alert alert-success alert-box fade in"><p><span class="glyphicon glyphicon-saved"></span> '.implode('</p><p><span class="glyphicon glyphicon-saved"></span> ', $_SESSION['messages']['success']).'</p></div>';
        }
        if(!empty($_SESSION['messages']['warning'])) {
            $output[] = '<div class="alert alert-warning alert-box fade in"><p><span class="glyphicon glyphicon-warning-sign"></span> '.implode('</p><p><span class="glyphicon glyphicon-warning-sign"></span> ', $_SESSION['messages']['warning']).'</p></div>';
        }
        if(!empty($_SESSION['messages']['error'])) {
            $output[] = '<div class="alert alert-danger alert-box fade in"><p><span class="glyphicon glyphicon-remove"></span> '.implode('</p><p><span class="glyphicon glyphicon-remove"></span> ', $_SESSION['messages']['error']).'</p></div>';
        }
        /*if(empty($_SESSION['messages'])) {
            $output[] = '<div class="alert alert-info alert-box alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><p>No messages saved</p></div>';
        }*/
        unset($_SESSION['messages']);
        return implode('', $output);
    }
    public static function addMessage($type, $message, $error = NULL) {
        $_SESSION['messages'][$type][] = $message;
        if($type == 'error' || $type == 'warning') {
            if(is_object($error) && $error instanceof Exception) {
                $handle = openFile('logs/error_log', 'a');
                if($handle != FALSE) {
                    $string = date("Y-m-d H:i:s").' An error occured: '.$error->getCode()."\n".$error->getFile().' Line '.$error->getLine()."\n".$error->getMessage()."\n".'Trace: '.$error->getTraceAsString()."\n";
                    fwrite($handle, $string);
                    fclose($handle); 
               }
            }
            /*else {
                $handle = openFile('logs/error_log', 'a');
                if($handle != FALSE) {
                    $string = date("Y-m-d H:i:s").'An error occured: '.$error->getCode().' - '.$error->getFile().' Line '.$error->getLine().' - '.$error->getMessage()."\n".'Trace: '.$error->getTraceAsString()."\n";
                    fwrite($handle, $string);
                    fclose($handle); 
               }
            }*/
        }
    }
    public static function mail($to, $subject='', $message='', $from='', $cc='', $bcc='') {
        $from = escapeAddr($from);
        $header = 'From: '.$from.PHP_EOL
                . 'Return-Path: '.$from.PHP_EOL
                . 'Reply-To: '.$from.PHP_EOL
                . 'MIME-Version: 1.0'.PHP_EOL
                . 'Content-type: text/html; charset=UTF-8'.PHP_EOL
                . 'X-Mailer: PHP/'.phpversion().PHP_EOL
                . 'Content-Transfer-Encoding: 8bit'.PHP_EOL;
        if ($cc!='') $header .= 'Cc: '.escapeAddr($cc).PHP_EOL;
        if ($bcc!='') $header .= 'Bcc: '.escapeAddr($bcc).PHP_EOL;
        $header .= PHP_EOL;
        return mail($to, '=?UTF-8?B?'.base64_encode($subject).'?=', $message, $header);
    }
}