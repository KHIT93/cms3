<?php

/**
 * @file Class to translate, add and remove definitions from the System Definitions table
 */
class Definition {
    public static function resolve($definition) {
        //Resolves a definition and returns an object of fields with options
        $db = DB::getInstance();
        $def = $db->get('system_definitions', array('definition', '=', $definition))->first();
        $output['definition'] = $def->definition;
        $output['name'] = $def->name;
        if(hasValue($def->options)) {
            $output['options'] = json_decode($def->options, true);
        }
        
        return $output;
    }
    public static function value($value, $options) {
        foreach ($options as $key => $option) {
            if($key == $value) {
                return $option;
            }
        }
        return false;
    }
    public static function resolveErrorCode($error_code) {
        $codes = File::parse_info_file(INCLUDES_PATH.'/registry/httperrors.registry');
        if(isset($codes[$error_code])) {
            return $codes[$error_code];
        }
        return 'Unknown Error '.$error_code;
        
    }
}
