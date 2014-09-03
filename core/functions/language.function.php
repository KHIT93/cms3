<?php
/**
 * @file
 * Functions for language handling
 */
function t($string, array $args = array()) {
    return String::translate($string, $args);
}
function format_string($string, array $args = array()) {
    return String::format($string, $args);
}
function get_active_languages() {
    return DB::getInstance()->get('languages', array('active', '=', '1'), PDO::FETCH_ASSOC)->results();
}
function get_languages() {
    return DB::getInstance()->getAll('languages', PDO::FETCH_ASSOC)->results();
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