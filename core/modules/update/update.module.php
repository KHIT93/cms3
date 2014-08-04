<?php
function update_enable() {
    $db = db_connect();
    $query = $db->prepare("UPDATE `modules` SET `module_active`=1 WHERE `module_name`='update'");
    try {
        $query->execute();
        addMessage('success', t('The module').' <i>Example module</i> '.t('has been enabled'));
    }
    catch (Exception $e) {
        addMessage('error', t('There was an error while processing the request'), $e);
    }
    $db = NULL;
}
function update_disable() {
    $db = db_connect();
    $query = $db->prepare("UPDATE `modules` SET `module_active`=0 WHERE `module_name`='update'");
    try {
        $query->execute();
        addMessage('success', t('The module').' <i>Example module</i> '.t('has been disabled'));
    }
    catch (Exception $e) {
        addMessage('error', t('There was an error while processing the request'), $e);
    }
    $db = NULL;
}
function update_cron() {
    //Executes Webservice call for module and core updates
}
function update_config() {
    
}
function update_config_submit($formdata) {
    
}