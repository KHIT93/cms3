<?php
/**
 * @file
 * Handles the entire bootstrapping for loading a new page
 */
class Bootstrapper {
    public static function core_bootstrapper(&$init, $bootstrap_mode = EXEC_BOOTSTRAPPER_FULL) {
        $init['url'] = (isset($_GET['q'])) ? splitURL() : explode('/', page_front());
        switch($init['url'][0]) {
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
        self::exec_bootstrapper($init, $bootstrap_mode);
    }
    private static function exec_bootstrapper(&$init, $bootstrap_mode = EXEC_BOOTSTRAPPER_FULL) {
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
        $output['page'] = self::prepare_page(getPageId(implode('/', $init['get_url'])));
        if(is_numeric($output['page'])) {
            throw_error($output['page']);
            $output = NULL;
            $init = NULL;
            exit();
        }
        $init['site']['header']['page_title'] = $output['page']['page_title'];
        $init['site']['header']['site_name'] = Config::get('site/site_name');
        $init['site']['header']['site_slogan'] = Config::get('site/site_slogan');
        $init['site']['header']['meta_keywords'] = $output['page']['meta_keywords'];
        $init['site']['header']['meta_description'] = $output['page']['meta_description'];
        $init['site']['header']['meta_robots'] = $output['page']['meta_robots'];
        $init['site']['header']['styles'] = (isset($init['template']['styles'])) ? $init['template']['styles'] : '';
        $init['site']['header']['scripts'] = (isset($init['template']['scripts'])) ? $init['template']['scripts'] : '';
        theme_header_alter($init['site']['header'], $init['template']['machine_name'], ((Thene::getTheme() == 'core') ? true : false ));
        self::prepare_header($init['site']['header']);
        $output['header'] = $init['site']['header']['rendered'];
        $output['sections'] = self::prepare_sections($output['page']);
        $output['page'] = NULL;
        
    }
}