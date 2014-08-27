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
        if(in_array($report, $default_reports)) {
            $has_report = true;
            $data = array();
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
    }
    public static function overview() {
        $default_reports = Config::get('default_reports', true);
        
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
        $output[] = '<a href="/admin/reports/not-found-erors" class="list-group-item">'
                    . '<h4 class="list-group-item-heading">'.t('Common \'Page not found\' 404 erors').'</h4>'
                    . '<p class="list-group-item-text">'.t('View a list of URL\'s that are returning 404 errors').'</p>'
                . '</a>';
        $output[] = '<a href="/admin/reports/access-denied-errors" class="list-group-item">'
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
}
