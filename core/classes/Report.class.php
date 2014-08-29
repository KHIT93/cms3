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
    public static function overviewMenu() {
        $output[] = array(
            'title' => t('System configuration'),
            'link' => 'admin/reports/config'
        );
        $output[] = array(
            'title' => t('Status report'),
            'link' => 'admin/reports/status'
        );
        $output[] = array(
            'title' => t('Recent log messages'),
            'link' => 'admin/reports/sysguard'
        );
        $output[] = array(
            'title' => t('Translation overview'),
            'link' => 'admin/reports/translation'
        );
        $output[] = array(
            'title' => t('\'Page not found\' 404 erors'),
            'link' => 'admin/reports/not_found_errors'
        );
        $output[] = array(
            'title' => t('\'Access denid\' 403 erors'),
            'link' => 'admin/reports/access_denied_errors'
        );
        foreach(Module::activeModules() as $module) {
            if(Module::moduleImplements($module, 'report_overview_alter')) {
                $function = $module->module.'_report_overview_alter';
                $data = $function();
                foreach($data as $item) {
                    $output[] = array(
                        'title' => $item['title'],
                        'link' => $item['link']
                    );
                }
            }
        }
        return $output;
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
                    . '<h4 class="list-group-item-heading">'.t('Recent log messages').'</h4>'
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
                . '<h2>'.t('Configuration report').'</h2>'
                . get_breadcrumb()
                . '</div>'
                . '<div class="cl-mcont">'
                . '<div class="col-md-12">'
                . '<div class="block">'
                . '<div class="content">'
                . '<p>'.t('The site configuration report is listed below containing both site specific configuration and information about the configuration of the server hosting your website.').'</p>'
                . '<table class="table table-hover">'
                . '<thead style="background-color: #CCC;">'
                . '<tr>'
                . '<th><strong>'.t('Name').'</strong></th>'
                . '<th><strong>'.t('Value').'</strong></th>'
                . '</tr>'
                . '</thead>'
                . '<tbody>'
                . '<tr>'
                . '<td>CMS</td>'
                . '<td>'.VERSION.'</td>'
                . '</tr>';
        foreach($config as $option => $value) {
            $def = Definition::resolve($option);
            $output .= '<tr>'
                    . '<td>'.t($def['name']).'</td>'
                    . '<td>'.((hasValue($def['options'])) ? Definition::value($value, $def['options']) : $value).'</td>'
                    . '</tr>';
        }
        $output .= '<tr>'
                . '<td>'.t('Cron tasks').'</td>'
                . '<td>'.t('Cron tasks were last executed @date', array('@date' => date("Y-m-d - H:i:s", Sysguard::get(array('module', '=', 'cron'), true)->timestamp))).'</td>'
                . '<tr>'
                . '<td>'.t('Webserver').'</td>'
                . '<td>'.$_SERVER['SERVER_SOFTWARE'].'</td>'
                . '</tr>';
        $output .= '<tr>'
                . '<td>'.t('PHP Version').'</td>'
                . '<td>'.PHP_VERSION.'</td>'
                . '</tr>'
                . '<tr>'
                . '<td>'.t('PHP memory limit').'</td>'
                . '<td>'.ini_get('memory_limit').'</td>'
                . '</tr>'
                . '<tr>'
                . '<td>'.t('Databaseserver').'</td>'
                . '<td>'.Definition::resolve(Config::get('db/driver'))['name'].' '.DB::getInstance()->version().'</td>'
                . '</tr>'
                . '<tr>';
        $output .= '</tbody>'
                . '</table>'
                . '</div>'
                . '</div>'
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
            $output = self::sysguardList();
        }
        return $output;
    }
    private static function sysguardList() {
        $events = Sysguard::get();
        $output = '<div class="page-head">'
                . '<h2>'.t('Recent log messages').'</h2>'
                . get_breadcrumb()
                . '</div>'
                . '<div class="cl-mcont">'
                . '<div class="col-md-12">'
                . '<p>'.''.'</p>'
                . '<table class="table table-hover">'
                . '<thead style="background-color: #CCC;">'
                . '<tr>'
                . '<th><strong>'.'Type'.'</strong></th>'
                . '<th><strong>'.'Date'.'</strong></th>'
                . '<th><strong>'.'Message'.'</strong></th>'
                . '<th><strong>'.'User'.'</strong></th>'
                . '</tr>'
                . '</thead>'
                . '<tbody>';
            if(count($events)) {
                foreach($events as $event) {
                    $output .= '<tr>'
                            . '<td>'.$event->module.'</td>'
                            . '<td>'.date("Y-m-d H:i:s", $event->timestamp).'</td>'
                            . '<td><a href="/admin/reports/sysguard/'.$event->sid.'">'.$event->header.'</a></td>'
                            . '<td>'.User::translateUID($event->uid).'</td>'
                            . '</tr>';
                }
            }
            else {
                $output .= '<tr><td colspan="4">'.t('The log is empty').'</td></tr>';
            }
            $output .= '</tbody>'
                    . '</table>'
                    . '</div>';
            return $output;
    }
    private static function sysguardDetails($event_id) {
        $event = Sysguard::get(array('sid', '=', $event_id))[0];
        $output = '<div class="page-head">'
        . '<h2>'.t('Event details').'</h2>'
        . get_breadcrumb()
        . '</div>'
        . '<div class="cl-mcont">'
        . '<div class="col-md-12">'
        . '<div class="block">'
        . '<div class="content">'
        . '<table class="table table-hover">'
        . '<tbody>'
        . '<tr>'
            . '<td class="table-heading">'.t('Type').'</td>'
            . '<td>'.$event->module.'</td>'
        . '</tr>'
        . '<tr>'
            . '<td class="table-heading">'.t('Date').'</td>'
            . '<td>'.date("Y-m-d - H:i:s", $event->timestamp).'</td>'
        . '</tr>'
        . '<tr>'
            . '<td class="table-heading">'.t('User').'</td>'
            . '<td>'.User::translateUID($event->uid).'</td>'
        . '</tr>'
        . '<tr>'
            . '<td class="table-heading">'.t('Referrer').'</td>'
            . '<td>'.$event->ref.'</td>'
        . '</tr>'
        . '<tr>'
            . '<td class="table-heading">'.t('Message').'</td>'
            . '<td>'.$event->details.'</td>'
        . '</tr>'
        . '<tr>'
            . '<td class="table-heading">'.t('Actions').'</td>'
            . '<td>'.self::sysguardEventActions($event_id).'</td>'
        . '</tr>';
        
        
        
        $output .= '</tbody>'
            . '</table>'
            . '</div>'
            . '</div>'
            . '</div>';
        return $output;
    }
    private static function sysguardEventActions($event_id) {
        if(DB::getInstance()->getField('sysguard', 'module', 'sid', $event_id) == 'page-not-found') {
            return '<a href="/admin/settings/search/redirect/add" class="btn btn-rad btn-sm btn-primary">'.t('Add Redirection').'</a>';
        }
    }
    public static function status() {
        //Show status report
    }
    public static function translation() {
        $db = DB::getInstance();
        $total = $db->getAll('translation')->count();
        $missing = $db->get('translation', array('translation', '=', ''))->count();
        $output = '<div class="page-head">'
                . '<h2>'.t('Translation overview').'</h2>'
                . get_breadcrumb()
                . '</div>'
                . '<div class="cl-mcont">'
                . '<div class="col-md-12">'
                . '<div class="block">'
                . '<div class="content">'
                . '<table class="table table-hover">'
                . '<thead class="table-heading">'
                . '<tr>'
                . '<th><strong>'.'Language'.'</strong></th>'
                . '<th><strong>'.'Translations'.'</strong></th>'
                . '<th><strong>'.'Actions'.'</strong></th>'
                . '</tr>'
                . '</thead>'
                . '<tbody>'
                . '<tr>'
                . '<td>Danish</td>'
                . '<td>'.$missing.' / '.$total.'('.number_format((100-(($missing/$total)*100)), 2, ',', '.').'%)'.'</td>'
                . '<td><a href="/admin/settings/language/translate">Translate</a></td>'
                . '</tr>';
        
        $output .= '</tbody>'
            . '</table>'
            . '</div>'
            . '</div>'
            . '</div>';
        //$output = $missing.' / '.$total;
        return $output;
    }
    public static function not_found_errors() {
        $events = Sysguard::get(array('module', '=', 'page-not-found'));
        $output = '<div class="page-head">'
                . '<h2>'.t('\'Page not found\' errors').'</h2>'
                . get_breadcrumb()
                . '</div>'
                . '<div class="cl-mcont">'
                . '<div class="col-md-12">'
                . '<div class="block">'
                . '<div class="content">'
                . '<table class="table table-hover">'
                . '<thead class="table-heading">'
                . '<tr>'
                . '<th><strong>'.t('Date').'</strong></th>'
                . '<th><strong>'.t('URL').'</strong></th>'
                . '<th><strong>'.t('Actions').'</strong></th>'
                . '</tr>'
                . '</thead>'
                . '<tbody>';
        foreach($events as $event) {
            $output .= '<tr>'
                    . '<td>'.date("Y-m-d - H:i:s", $event->timestamp).'</td>'
                    . '<td>'.$event->ref.'</td>'
                    . '<td>'.self::sysguardEventActions($event->sid).'</td>'
                    . '</tr>';
        }
        $output .= '</tbody>'
            . '</table>'
            . '</div>'
            . '</div>'
            . '</div>';
        return $output;
    }
    public static function access_denied_errors() {
        $events = Sysguard::get(array('module', '=', 'access-denied'));
        $output = '<div class="page-head">'
                . '<h2>'.t('\'Access Denied\' errors').'</h2>'
                . get_breadcrumb()
                . '</div>'
                . '<div class="cl-mcont">'
                . '<div class="col-md-12">'
                . '<div class="block">'
                . '<div class="content">'
                . '<table class="table table-hover">'
                . '<thead class="table-heading">'
                . '<tr>'
                . '<th><strong>'.t('Date').'</strong></th>'
                . '<th><strong>'.t('URL').'</strong></th>'
                . '<th><strong>'.t('Actions').'</strong></th>'
                . '</tr>'
                . '</thead>'
                . '<tbody>';
        foreach($events as $event) {
            $output .= '<tr>'
                    . '<td>'.date("Y-m-d - H:i:s", $event->timestamp).'</td>'
                    . '<td>'.$event->ref.'</td>'
                    . '<td>'.self::sysguardEventActions($event->sid).'</td>'
                    . '</tr>';
        }
        $output .= '</tbody>'
            . '</table>'
            . '</div>'
            . '</div>'
            . '</div>';
        return $output;
    }
}
