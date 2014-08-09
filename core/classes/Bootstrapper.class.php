<?php
/**
 * @file
 * Handles the entire bootstrapping for loading a new page
 */
class Bootstrapper {
    public static function core_bootstrapper(&$init, $bootstrap_mode = EXEC_BOOTSTRAPPER_FULL) {
        //$init['site']['config'] = getSiteConfig();
        //$init['site']['advanced'] = getAdvSiteConfig();
        if($bootstrap_mode == EXEC_BOOTSTRAPPER_FULL) {
        $url = splitURL();
            switch($url[0]) {
                case 'admin':
                    $bootstrap_mode = EXEC_BOOTSTRAPPER_ADMIN;
                break;
                case 'login':
                    $bootstrap_mode = EXEC_BOOTSTRAPPER_ADMIN;
                break;
                default:
                    $bootstrap_mode = EXEC_BOOTSTRAPPER_FULL;
                break;
            }
        }
        $init['get_url'] = (isset($_GET['q'])) ? splitURL() : array(0 => page_front());
        self::exec_bootstrapper($init, $bootstrap_mode);
    }
    private static function exec_bootstrapper(&$init, $bootstrap_mode = EXEC_BOOTSTRAPPER_FULL) {
        //krumo($init);
        switch ($bootstrap_mode) {
            case 0:
                //krumo($init);
                self::exec_bootstrapper_full($init);
            break;
            case 1:
                self::exec_bootstrapper_admin($init);
            break;
            case 2:
                self::exec_bootstrapper_maintenance($init);
            break;
            case 3:
                self::exec_bootstrapper_install($init);
            break;
            default:
                die('Bootstrapping failed. The might be corrupted files in the application core. Please consult your system administrator for troubleshooting.');
                break;
        }
    }
    private static function exec_bootstrapper_full(&$init) {
        $init['modules'] = Module::activeModules();
        $init['template'] = (Theme::getTheme() == 'core') ? Theme::themeDetails(Theme::getTheme(), true): Theme::themeDetails(Theme::getTheme());
        Module::loadModules($init['modules']);
        foreach($init['modules'] as $item) {
            if(Module::moduleImplements($item, 'init')) {
                if(function_exists($item->module.'_init')) {
                    call_user_func($item->module.'_init');
                }
            }
        }
        //if(isset($_POST)){formBootstrapping($_POST);}
        $output['page'] = self::prepare_page(getPageId(implode('/', $init['get_url'])))->data;
        if(is_numeric($output['page'])) {
            throw_error($output['page']);
            $output = NULL;
            $init = NULL;
            exit();
        }
        $init['site']['header']['page_title'] = $output['page']['title'];
        $init['site']['header']['site_name'] = Config::get('site/site_name');
        $init['site']['header']['site_slogan'] = Config::get('site/site_slogan');
        $init['site']['header']['meta_keywords'] = $output['page']['keywords'];
        $init['site']['header']['meta_description'] = $output['page']['description'];
        $init['site']['header']['meta_robots'] = $output['page']['robots'];
        $init['site']['header']['styles'] = (isset($init['template']['styles'])) ? $init['template']['styles'] : '';
        $init['site']['header']['scripts'] = (isset($init['template']['scripts'])) ? $init['template']['scripts'] : '';
        theme_header_alter($init['site']['header'], $init['template']['machine_name'], ((Theme::getTheme() == 'core') ? true : false ));
        self::prepare_header($init['site']['header']);
        $output['header'] = $init['site']['header']['rendered'];
        $output['sections'] = self::prepare_sections($output['page']);
        $init['ready'] = $output;
    }
    private static function exec_bootstrapper_admin(&$init) {
        $init['modules'] = Module::activeModules();
        $init['template'] = Theme::themeDetails('admin', true);
        Module::loadModules($init['modules']);
        foreach($init['modules'] as $item) {
            if(Module::moduleImplements($item, 'init')) {
                if(function_exists($item->module.'_init')) {
                    call_user_func($item->module.'_init');
                }
            }
        }
        if(file_exists(Theme::path_to_theme().'/template.php')) {
            include_once Theme::path_to_theme().'/template.php';
        }
        //if(isset($_POST)){formBootstrapping($_POST);}
        $init['site']['header']['page_title'] = t('Administration');
        $init['site']['header']['site_name'] = $init['site']['config']['site_name'];
        $init['site']['header']['meta_keywords'] = '';
        $init['site']['header']['meta_description'] = '';
        $init['site']['header']['meta_robots'] ='';
        $init['site']['header']['styles'] = (isset($init['template']['styles'])) ? $init['template']['styles'] : '';
        $init['site']['header']['scripts'] = (isset($init['template']['scripts'])) ? $init['template']['scripts'] : '';
        theme_header_alter($init['site']['header'], 'admin', true);
        self::prepare_header($init['site']['header']);
        $init['ready']['header'] = $init['site']['header']['rendered'];
        $GLOBALS['core_param']['mode'] = $init['get_url'][0];
    }
    private static function exec_bootstrapper_maintenance(&$init) {
        
    }
    private static function exec_bootstrapper_install(&$init) {
        
    }
    private static function prepare_header(&$header) {
        $header['rendered']['charset'] = '<meta charset="'.((isset($header['charset'])) ? $header['charset']."\n" : 'utf-8').'">';
        $header['rendered']['ua'] = '<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">'."\n";
        $header['rendered']['title'] = '<title>'.((currentPageIsFront()) ? $header['site_name'].' - '.$header['site_slogan'] : $header['page_title'].' - '.$header['site_name']).'</title>'."\n";
        $header['rendered']['description'] = (isset($header['meta_description'])) ? '<meta name="description" content="'.$header['meta_description'].'">'."\n" : '';
        $header['rendered']['keywords'] = (isset($header['meta_keywords'])) ? '<meta name="description" content="'.$header['meta_keywords'].'">'."\n" : '';
        $header['rendered']['robots'] = (isset($header['meta_robots'])) ? '<meta name="robots" content="'.$header['meta_robots'].'">'."\n" : '';
        $header['rendered']['generator'] = '<meta name="generator" content="ModernCMS">'."\n";
        $header['rendered']['viewport'] = '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
        $header['rendered']['styles'] = self::prepare_styles($header['styles']);
        $header['rendered']['jscripts'] = self::prepare_jscripts($header['scripts']);
    }
    private static function prepare_styles($styles, $core_styles = true) {
        $rendered_styles = '';
        if($core_styles == true) {
            $rendered_styles .= self::prepare_core_styles();
        }
        if(is_array($styles)) {
            foreach ($styles as $media => $data) {
                for ($i=0; $i<count($data); $i++) {
                    $rendered_styles .= '<link href="/'.Theme::path_to_theme().'/'.$data[$i].'" rel="stylesheet" type="text/css" media="'.$media.'">'."\n";
                }
            }
        }
        else {
            $rendered_styles .= '';
        }
        return $rendered_styles;
    }
    private static function prepare_core_styles() {
        $core_css = Config::get('assets/styles');
        $styles = '';
        foreach ($core_css as $media => $data) {
            for ($i=0; $i<count($data); $i++) {
                $styles .= '<link href="/'.$data[$i].'" rel="stylesheet" type="text/css" media="'.$media.'">'."\n";
            }
        }
        return $styles;
    }
    private static function prepare_jscripts($jscripts, $core_jscripts = true) {
        $rendered_jscripts = '';
        if($core_jscripts == true) {
            $rendered_jscripts .= self::prepare_core_jscripts();
        }
        if(is_array($jscripts)) {
            foreach ($jscripts as $data) {
                $rendered_jscripts .= '<scripts src="/'.Theme::path_to_theme().'/'.$data.'"></scripts>'."\n";
            }
        }
        else {
            $rendered_jscripts .= '';
        }
        return $rendered_jscripts;
    }
    private static function prepare_core_jscripts() {
        $core_js = Config::get('assets/scripts');
        $jscripts = '<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>'."\n";
        foreach ($core_js as $data) {
            $jscripts .= '<script src="/'.$data.'"></script>'."\n";
        }
        return $jscripts;
    }
    private static function prepare_page($url) {
        $theme = Theme::themeDetails(Theme::path_to_theme());
        $template_func = $theme['machine_name'].'_theme_page_alter';
        if(Page::exists($url)) {
            //If the page exists establish a new page object
            //$page = new Page($url);
            $page = Page::getInstance($url);
            if($page->pageAccess(((isset($_SESSION['uid'])) ? $_SESSION['uid'] : 0))) {
                //$page = getPage($url);
                foreach (Module::activeModules() as $module) {
                    $func_name = $module->module.'_theme_page_alter';
                    if(Module::moduleImplements($module->module, 'theme_page_alter')) {
                        $func_name();
                    }
                }
                if(function_exists($template_func)) {
                    //Execute theme alter functions for header from template.php
                    $template_func($page);
                }
                return $page;
            }
            else {
                return 403;
            }
        }
        else {
            return 404;
        }
    }
    public static function prepare_sections($page) {
        $sections = Widget::getSections(Theme::getTheme());
        foreach ($sections as $section => $name) {
            $output[$section] = self::prepare_section($section, $page);
        }
        return $output;
    }
    public static function prepare_section($section, $page) {
        $widgets = Widget::getWidgets($section);
        $output['#prefix'] = '<div id="section-'.$section.'">'."\n";
        foreach ($widgets as $widget) {
            if($widget->title == 'Primary content' || $widget->title == 'Primary Content') {
                $output['elements'][] = '<div class="widget" id="widget-primary-content">'."\n"
                                            . self::inject_page($page)."\n"
                                        . '</div>'."\n";
            }
            else {
                $output['elements'][] = '<div class="widget" id="widget-'.$widget->wid.'">'."\n"
                                            . self::prepare_widget($widget)."\n"
                                        . '</div>'."\n";
            }
        }
        $output['#suffix'] = '</div>'."\n";
        return $output;
    }
    public static function inject_page($page) {
        $output = $page['content'];
        return $output;
    }
    public static function prepare_widget($widget) {
        if($widget->type == 'dynamic') {
            //Call function for dynamic widget
            $func_content = json_decode($widget->content);
            $function = $func_content->func;
            $parameters = (isset($func_content->param)) ? $func_content->param : NULL;
            $output = (!is_null($parameters)) ? $function($parameters): $function();
        }
        else if($widget->type == 'static') {
            //Render static widget content
            $output = $widget->content;
        }
        return $output;
    }
    public static function finalize_page(&$init) {
        if(Config::get('param/mode') == 'admin' || Config::get('param/mode') == 'login') {
            Theme::render_header($init['ready']['header']);
            Routing::backend($init['get_url']);
        }
        else {
            Routing::frontend($init['get_url']);
            Theme::render_header($init['ready']['header']);
            Theme::render_page($init['ready']['sections']);
        }
        //$init = NULL;
    }
}