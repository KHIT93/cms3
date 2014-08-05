<?php
/**
 * @file
 * Functions for language handling
 */
function t($string, array $args = array()) {
    $db = db_connect();
    $lang = get_lang();
    if($lang != 'en') {
        $query = $db->prepare("SELECT `t_string` AS `string`, `t_translation` AS `translation` FROM `translation` WHERE `t_locale`=:lang AND `t_string`=:field");
        $query->bindValue(':lang', $lang, PDO::PARAM_STR);
        $query->bindValue(':field', $string, PDO::PARAM_STR);
        try {
        $query->execute(); //Executes query

        $translate = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (Exception $e) {
            addMessage('error', t('There was an error while processing the string'), $e);
        }
        $translation = (isset($translate[0])) ? $translate[0] : NULL;
        if(isset($translation['string'])) {
            if(!isset($translation['translation']) OR empty($translation['translation']) OR $translation['translation'] == '' OR $lang == 'en') {
                $output = $string;
            }
            else {
                $output = $translation['translation'];
            }
        }
        else {
            $query = $db->prepare("INSERT INTO `translation` (`t_string`, `t_locale`) VALUES(:string, :lang)");
            $query->bindValue(':lang', $lang, PDO::PARAM_STR);
            $query->bindValue(':string', $string, PDO::PARAM_STR);
            try {
            $query->execute(); //Executes query
            }
            catch (Exception $e) {
                addMessage('error', t('There was an error while processing the translation'), $e);
            }
            $output = $string; 
        }
    }
    else {
        $output = $string;
    }
    $db = NULL;
    return format_string($output, $args);
}
function format_string($string, array $args = array()) {
    // Transform arguments before inserting them.
    foreach ($args as $key => $value) {
        switch ($key[0]) {
            case '@':
                // Escaped only.
                $args[$key] = check_plain($value);
            break;

            case '%':
            default:
            // Escaped and placeholder.
                $args[$key] = string_placeholder($value);
            break;

            case '!':
                // Pass-through.
        }
    }
    return strtr($string, $args);
}
function getTranslations($language) {
    $db = db_connect();
    $query = $db->prepare("SELECT * FROM `translation` WHERE `t_locale`=:field");
    //$input = check_plain($input);
    $query->bindValue(':field', check_plain($language), PDO::PARAM_STR);
    try {
    $query->execute(); //Executes query

    $output = $query->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (Exception $e) {
        addMessage('error', t('There was an error while querying the translations'), $e);
    }
    $db = NULL;
    return $output;
}
function saveTranslation($formdata) {
    $db = db_connect();
    $query = $db->prepare("UPDATE `translation` SET `t_translation`=:translation WHERE `t_id`=:t_id");
    $query->bindValue(':translation', $formdata['translation'], PDO::PARAM_STR);
    $query->bindValue(':t_id', $formdata['t_id'], PDO::PARAM_INT);
    try {
        $query->execute();
        addMessage('success', t('Translation has been successfully updated'));
    }
    catch(Exception $e) {
        addMessage('error', t('There was an error updating the string'), $e);
        //die($e->getMessage());        
    }
    $db = NULL;
}