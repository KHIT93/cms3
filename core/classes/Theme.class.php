<?php
class Theme {
    public static function getTheme() {
        //Get the active theme
        return Config::get('site/site_theme');
    }
    public static function path_to_theme() {
        $url = Redirect::splitURL();
        $theme = self::getTheme();
        //Gettting the path to active theme
        if($url[0] == 'admin' || $url[0] == 'login') {
            return 'core/templates/admin';
        }
        else if($theme == 'core') {
            return 'core/templates/core';
        }
        else {
            return 'templates/'.$theme;
        }
    }
    public static function getThemeList() {
        $dir = scandir('templates/', SCANDIR_SORT_ASCENDING);
        unset ($dir[0]);
        unset ($dir[1]);
        if($dir[2] == '.DS_Store') {
            unset ($dir[2]);
        }
        $output = array();
        foreach ($dir as $folder) {
            $output[] = themeDetails($folder);
        }
        return $output;
    }
    public static function themeDetails($themepath, $core = false) {
        $readin = ($core == true) ? 'core/templates/'.$themepath.'/'.$themepath.'.info' : 'templates/'.$themepath.'/'.$themepath.'.info';
        $output = File::parse_info_file($readin);
        $output['machine_name'] = $themepath;
        return $output;
    }
    public static function applyTheme($themename) {
        //$db = DB::getInstance();
        if(!DB::getInstance()->update('config', array('property', 'site_theme'), array('contents' => $themename))) {
            throw new Exception(t('There was an error updating your user information'));
        }
        //DB::getInstance()->query("UPDATE `config` SET `config_value`=:theme WHERE `config_name`='site_theme'", array($themename));
        //$query->bindValue(':theme', $themename, PDO::PARAM_STR);
        try {
            $query->execute();
        }
        catch (Exception $e) {
            addMessage('error', t('We were unable to apply the theme'), $e);
        }
        $db = NULL;
    }
    public static function errorPage($error_code, $message = '') {
        if(file_exists(self::path_to_theme().'/'.$error_code.'.error.php')) {
            include_once self::path_to_theme().'/'.$error_code.'.error.php';
        }
        else {
            if(file_exists(self::path_to_theme().'/generic.error.php')) {
                include_once self::path_to_theme().'/generic.error.php';
            }
            else if(file_exists(ERROR_FILE_PATH.'/'.$error_code.'.error.php')) {
                include_once ERROR_FILE_PATH.'/'.$error_code.'.error.php';
            }
            else {
                include_once ERROR_FILE_PATH.'/generic.error.php';
            }
        }
    }
    public static function render(&$element) {
        if(is_array($element)) {
            //Render the renderable array
            return array_render($element);
        }
        else {
            //Print the string
            return $element;
        }
    }
    public static function array_render($array) {
        $output = '';
        if(isset($array['#prefix']) && isset($array['#suffix'])) {
            if(isset($array['elements'])) {
                $output .= $array['#prefix'];
                foreach ($array['elements'] as $value) {
                    $output .= $value;
                }
                $output .= $array['#suffix'];
            }
            else if(isset($array['#content'])) {
                $output .= $array['#prefix'];
                $output .= $array['#content'];
                $output .= $array['#suffix'];
            }
        }
        else {
            if(isset($array['elements'])) {
                foreach ($array['elements'] as $value) {
                    $output .= $value;
                }
            }
            else {
                foreach ($array as $value) {
                    $output .= $value;
                }
            }
        }
        return $output;
    }
    public static function render_header($header) {
        $head = $header['charset'].$header['ua'].$header['viewport'].$header['generator'];
        $header_title = $header['title'];
        $seo_tags = $header['description'].$header['keywords'].$header['robots'];
        $styles = $header['styles'];
        $jscripts = $header['jscripts'];
        $header = NULL;
        include_once (file_exists(SITE_ROOT.'/'.self::path_to_theme().'/head.tpl.php')) ? SITE_ROOT.'/'.self::path_to_theme().'/head.tpl.php': SITE_ROOT.'/core/templates/core/head.tpl.php';
        $head = NULL;
        $header_title = NULL;
        $seo_tags = NULL;
        $styles = NULL;
        $jscripts = NULL;
    }
    public static function render_page($page) {
        include_once (file_exists(SITE_ROOT.'/'.self::path_to_theme().'/page.tpl.php')) ? SITE_ROOT.'/'.self::path_to_theme().'/page.tpl.php': SITE_ROOT.'/core/templates/core/page.tpl.php';
        unset($page);
    }
}