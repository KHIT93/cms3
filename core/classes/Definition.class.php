<?php

/**
 * @file Class to translate, add and remove definitions from the System Definitions table
 */
class Definition {
    public static function resolve($definition) {
        //Resolves a definition and returns an object of fields with options
        $core_def = self::core();
        $output = array();
        if(in_array($definition, $core_def)) {
            foreach($core_def as $def) {
                if($def['definition'] == $definition) {
                    $output = $def;
                    if(isset($output['options'])) {
                        $output['options'] = json_decode($output['options'], true);
                    }
                    break;
                }
            }
        }
        else {
            $db = DB::getInstance();
            $output = $db->get('system_definitions', array('definition', '=', $definition), PDO::FETCH_ASSOC)->first();
            if(isset($output['options'])) {
                $output['options'] = json_decode($output['options'], true);
            }
        }
        
        
        return $output;
    }
    private static function core() {
        $definitions = array(
            array(
                'definition' => 'site_name',
                'name' => t('Site name')
                ),
            array(
                'definition' => 'site_slogan',
                'name' => t('Site slogan')
                ),
            array(
                'definition' => 'site_theme',
                'name' => t('Site theme')
                ),
            array(
                'definition' => 'site_home',
                'name' => t('Site homepage')
                ),
            array(
                'definition' => 'site_language',
                'name' => t('Site language')
                ),
            array(
                'definition' => 'create_user',
                'name' => t('Create new useraccounts')
                )
        );
        return $definitions;
    }
}
