<?php   

/**
 * @file Class for handling reporting
 */
class Report {
    public static function get() {
        //Generates report content
    }
    public static function generate($report) {
        $default_reports = Config::get('default_reports', true);
        $has_report = false;
        $data = '';
        if(in_array($report, $default_reports)) {
            $has_report = true;
            $data = self::$report();
            
        }
        else {
            foreach (Module::activeModules() as $module) {
                if(Module::moduleImplements($module, 'report')) {
                    $function = $module->module.'_report';
                    $data = $function($report);
                    $has_report = (hasValue($data)) ? true: false;
                }
            }
        }
        return ($has_report == true) ? $data : t('The requested report is unavailable');
    }
    public static function overview() {
        //$default_reports = Config::get('default_reports', true);
        $output[] = '<a href="/admin/reports/config" class="list-group-item">'
                    . '<h4 class="list-group-item-heading">'.t('System configuration').'</h4>'
                    . '<p class="list-group-item-text">'.t('View the system configuration and get information about the server hosting your website').'</p>'
                . '</a>';
        $output[] = '<a href="/admin/reports/status" class="list-group-item">'
                    . '<h4 class="list-group-item-heading">'.t('Status report').'</h4>'
                    . '<p class="list-group-item-text">'.t('View the status report and get an overview of any issues your site might have').'</p>'
                . '</a>';
        $output[] = '<a href="/admin/reports/sysguard" class="list-group-item">'
                    . '<h4 class="list-group-item-heading">'.t('Latest log messages').'</h4>'
                    . '<p class="list-group-item-text">'.t('View the latest events from the site log').'</p>'
                . '</a>';
        $output[] = '<a href="/admin/reports/translation" class="list-group-item">'
                    . '<h4 class="list-group-item-heading">'.t('Translation overview').'</h4>'
                    . '<p class="list-group-item-text">'.t('Shows how well the user interface is translated').'</p>'
                . '</a>';
        $output[] = '<a href="/admin/reports/not_found_erors" class="list-group-item">'
                    . '<h4 class="list-group-item-heading">'.t('Common \'Page not found\' 404 erors').'</h4>'
                    . '<p class="list-group-item-text">'.t('View a list of URL\'s that are returning 404 errors').'</p>'
                . '</a>';
        $output[] = '<a href="/admin/reports/access_denied_errors" class="list-group-item">'
                    . '<h4 class="list-group-item-heading">'.t('Common \'Access denid\' 403 erors').'</h4>'
                    . '<p class="list-group-item-text">'.t('View a list of URL\'s that are returning 403 errors').'</p>'
                . '</a>';
        foreach(Module::activeModules() as $module) {
            if(Module::moduleImplements($module, 'report_overview_alter')) {
                $function = $module->module.'_report_overview_alter';
                $data = $function();
                foreach($data as $item) {
                    $output[] = '<a href="/admin/reports/sysguard" class="list-group-item">'
                                . '<h4 class="list-group-item-heading">'.$item['title'].'</h4>'
                                . '<p class="list-group-item-text">'.$item['description'].'</p>'
                            . '</a>';
                }
            }
        }
        return implode("\n", $output);
        //return $output;
    }
    public static function config() {
        $output = '';
        $config = Config::get('site', true);
        $output .= '<div class="page-head">'
                . '<h2>'.t('Site configuration report').'</h2>'
                . get_breadcrumb()
                . '</div>'
                . '<div class="cl-mcont">'
                . '<div class="col-md-12">'
                . '<p>'.t('The site configuration report is listed below containing both site specific configuration and information about the configuration of the server hosting your website.').'</p>'
                . '<table class="table table-hover">'
                . '<thead style="background-color: #CCC;">'
                . '<tr>'
                . '<th><strong>'.t('Name').'</strong></th>'
                . '<th><strong>'.t('Value').'</strong></th>'
                . '</tr>'
                . '</thead>'
                . '<tbody>';
        foreach($config as $option => $value) {
            $output .= '<tr>'
                    . '<td>'.$option.'</td>'
                    . '<td>'.$value.'</td>'
                    . '</tr>';
        }
        $output .= '</tbody>'
                . '</table>'
                . '</div>';
        return $output;
    }
    public static function sysguard() {
        $url = splitURL();
        $output = '';
        if(isset($url[3])) {
            if(is_numeric($url[3])) {
                $output = self::sysguardDetails($url[3]);
            }
        }
        else {
            $events = Sysguard::get();
            $output = '<div class="page-head">'
                    . '<h2>'.t('Latest log messages').'</h2>'
                    . get_breadcrumb()
                    . '</div>'
                    . '<div class="cl-mcont">'
                    . '<div class="col-md-12">'
                    . '<p>'.t('The site configuration report is listed below containing both site specific configuration and information about the configuration of the server hosting your website.').'</p>'
                    . '<table class="table table-hover">'
                    . '<thead style="background-color: #CCC;">'
                    . '<tr>'
                    . '<th><strong>'.'Module'.'</strong></th>'
                    . '<th><strong>'.'Timestamp'.'</strong></th>'
                    . '<th><strong>'.'Header'.'</strong></th>'
                    . '<th><strong>'.'User'.'</strong></th>'
                    . '</tr>'
                    . '</thead>'
                    . '<tbody>';
            foreach($events as $event) {
                $output .= '<tr>'
                        . '<td>'.$event->module.'</td>'
                        . '<td>'.date("Y-m-d", $event->timestamp).'</td>'
                        . '<td><a href="/admin/reports/sysguard/'.$event->sid.'">'.$event->header.'</a></td>'
                        . '<td>'.$event->uid.'</td>'
                        . '</tr>';
            }
        }
        return $output;
    }
    private static function sysguardList() {
        
    }
    private static function sysguardDetails($event_id) {
        $event = Sysguard::get(array('sid', '=', $event_id));
                $output = '<div class="page-head">'
                . '<h2>'.t('Latest log messages').'</h2>'
                . get_breadcrumb()
                . '</div>'
                . '<div class="cl-mcont">'
                . '<div class="col-md-12">'
                . '<p>'.t('The site configuration report is listed below containing both site specific configuration and information about the configuration of the server hosting your website.').'</p>'
                . '<table class="table table-hover">'
                . '<thead style="background-color: #CCC;">'
                . '<tr>'
                . '<th><strong>'.'Module'.'</strong></th>'
                . '<th><strong>'.'Timestamp'.'</strong></th>'
                . '<th><strong>'.'Header'.'</strong></th>'
                . '<th><strong>'.'User'.'</strong></th>'
                . '</tr>'
                . '</thead>'
                . '<tbody>';
    }
}
