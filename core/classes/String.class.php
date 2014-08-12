<?php
class String {
    public static function translate($string, array $args = array()) {
        $db = DB::getInstance();
        $output = '';
        $lang = Config::get('site/site_language');
        if($lang != 'en') {
            $query = $db->query("SELECT `string`, `translation` FROM `translation` WHERE `language` = ? AND `string` = ?", array($lang, $string));
            if(!$query->error()) {
                $translate = $query->results();
                $translation = (isset($translate[0])) ? $translate[0] : NULL;
                if(isset($translation->string)) {
                    if(!isset($translation->translation) || empty($translation->translation) || $translation->translation == '' || $lang == 'en') {
                        $output = $string;
                    }
                    else {
                        $output = $translation->translation;
                    }
                }
                else {
                    $db->insert('translation', array('string' => $string, 'language' => $lang));
                }
            }
        }
        else {
            $output = $string;
        }
        return String::format($output, $args);
    }
    public static function format($string, $args = array()) {
        // Transform arguments before inserting them.
        foreach ($args as $key => $value) {
            switch ($key[0]) {
                case '@':
                    // Escaped only.
                    $args[$key] = Sanitize::checkPlain($value);
                    //$args[$key] = $value;
                break;

                case '%':
                default:
                // Escaped and placeholder.
                    //$args[$key] = Sanitize::stringPlaceholder($value);
                    $args[$key] = $value;
                break;

                case '!':
                    // Pass-through.
            }
        }
        return strtr($string, $args);
    }
}