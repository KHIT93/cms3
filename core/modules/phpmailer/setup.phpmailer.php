<?php
function phpmailer_installModule() {
    $db = db_connect();
    $site = getSiteConfig();
    $name = $site['site_name'];
    $sql = "INSERT INTO `config` (`config_name`, `config_value`)"
            . "VALUES('mail_use', 0),"
            . "('mail_host', 'localhost'),"
            . "('mail_auth, 'auth_no')"
            . "('mail_user', 'not set'),"
            . "('mail_pass', 'not set'),"
            . "('mail_sendfrom', 'noreply@example.com'),"
            . "('mail_sendname', '$name'),"
            . "('mail_ssl', 'no')";
    $query = $db->prepare($sql);
    try {
        $query->execute();
    }
    catch (Exception $e) {
        addMessage('error', t('There was an error installing the module').':<br/>'.$e->getMessage(), $e);
    }
    $db = NULL;
}
function phpmailer_uninstallModule() {
    $db = db_connect();
    $sql = "DELETE FROM `config` WHERE `config_name` LIKE 'mail_%'";
    $query = $db->prepare($sql);
    try {
        $query->execute();
    }
    catch (Exception $e) {
        addMessage('error', t('There was an error uninstalling the module').':<br/>'.$e->getMessage(), $e);
    }
    $db = NULL;
}

