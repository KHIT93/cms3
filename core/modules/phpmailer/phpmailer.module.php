<?php
include 'class.phpmailer.php';
function phpmailer_enable() {
    $db = db_connect();
    $query = $db->prepare("UPDATE `modules` SET `module_active`=1 WHERE `module_name`='phpmailer'");
    try {
        $query->execute();
        addMessage('success', t('The module').' <i>Example module</i> '.t('has been enabled'));
    }
    catch (Exception $e) {
        addMessage('error', t('There was an error while processing the request'), $e);
    }
    $db = NULL;
}
function phpmailer_disable() {
    $db = db_connect();
    $query = $db->prepare("UPDATE `modules` SET `module_active`=0 WHERE `module_name`='phpmailer'");
    try {
        $query->execute();
        addMessage('success', t('The module').' <i>Example module</i> '.t('has been disabled'));
    }
    catch (Exception $e) {
        addMessage('error', t('There was an error while processing the request'), $e);
    }
    $db = NULL;
}
/*function phpmailer_init() {
    
}*/
function phpmailer_settings_alter(&$settings) {
    //Alter the settings-list for adding custom items to the list
    if(has_permission('access_admin_settings_system_email', $_SESSION['uid']) === true) {
        $settings['system'][] = array(
            'title' => t('Email settings'),
            'description' => t('Configure settings for the system to use when sending email.'),
            'link' => site_root().'/admin/settings/system/email'
        );
    }
    return $settings;
}
function phpmailer_route($path) {
    if(substr($path, 0, strlen(phpmailer_config_url())) == phpmailer_config_url()) {
        return phpmailer_config();
    }
    else {
        return false;
    }
}
function phpmailer_config() {
    $output = '<div class="page-head"><h2>'.t('Email settings').'</h2>'
            . get_breadcrumb()
            . '</div>';
    $output .= '<div class="cl-mcont">'
            . print_messages()
            . '<div class="tab-container">'
            . '<ul id="advslider-tab" class="nav nav-tabs">'
            . '<li class="nav-tabs-right"><a href="#settings" data-toggle="tab">'.  t('Settings').'</a></li>'
            . ((has_permission('access_admin_settings_system_email_smtp', $_SESSION['uid'])) ?'<li class="active nav-tabs-right"><a href="#sliders" data-toggle="tab">'.  t('General').'</a></li>': '')
            . '</ul>'
            . '<div class="tab-content">';
    $output .= '<div class="tab-pane fade in active" id="sliders">'.phpmailer_settings().'</div>';
    $output .= ((has_permission('access_admin_settings_system_email_smtp', $_SESSION['uid'])) ? '<div class="tab-pane fade" id="settings">'.phpmailer_server_settings().'</div>' : '');
    $output .= '</div>'
            . '</div>'
            . '</div>';
    return $output;
}
function phpmailer_config_submit($formdata) {
    if(isset($formdata['phpmailerSettings'])) {
        phpmailer_settings_submit($formdata);
        header('Location: '.site_root().'/'.phpmailer_config_url());
        exit();
    }
    if(isset($formdata['phpmailerServerSettings'])) {
        phpmailer_server_settings_submit($formdata);
        header('Location: '.site_root().'/'.phpmailer_config_url());
        exit();
    }
}
function phpmailer_config_url() {
    $phpmailer_info = parse_info_file(CORE_MODULE_PATH.'/phpmailer/phpmailer.info');
    return (isset($phpmailer_info['config'])) ? $phpmailer_info['config'] : MODULE_DEFAULT_CONFIG_PATH.'/advslider/config';
}
//END OF CORE FUNCTIONS
function phpmailer_settings() {
    return 'Global mail settings';
}
function phpmailer_settings_submit() {
    
}
function phpmailer_server_settings() {
    $mailer = phpmailer_get_config();
    $output = '<p>'.t('Configure the settings for using a mailserver to send mail from this website').'</p>';
    $form = array(
        '#name' => 'phpmailerServerSettings',
        '#method' => 'POST',
        '#captcha' => false,
        '#action' => '',
        'elements' => array(
            array(
                '#type' => 'text',
                '#name' => 'inputServer',
                '#placeholder' => 'smtp.example.com',
                '#value' => ((isset($mailer['mail_host'])) ? $mailer['mail_host'] : ''),
                '#label' => t('Mailhost'),
                '#help' => t('Insert the address for your SMTP-server. Fx. smtp.example.com. Multiple servers are seperated by semicolon'),
                '#wrapper' => true
            ),
            array(
                '#type' => 'custom',
                '#value' => '<script>'.file_get_contents(CORE_MODULE_PATH.'/phpmailer/phpmailer.js').'</script>'
            ),
            array(
                '#type' => 'checkbox',
                '#value' => 'auth_yes',
                '#name' => 'mail_auth',
                '#id' => array(
                    'auth_mail'
                ),
//                'events' => array(
//                    'onchange' => 'mail_auth_check()'
//                ),
                '#label' => t('My server requires authentication'),
                '#checked' => ((isset($mailer['mail_auth']) && $mailer['mail_auth'] == 'auth_yes') ? true : false)
            ),
            array(
                '#type' => 'text',
                '#name' => 'inputUsername',
                '#placeholder' => 'user@example.com',
                '#value' => ((isset($mailer['mail_user'])) ? $mailer['mail_user'] : ''),
                '#label' => t('Username'),
                '#id' => array(
                    'inputUsername'
                ),
                '#help' => t('Input your username for the SMTP-server. This is often your email address'),
                '#wrapper' => true,
                '#disabled' => ((isset($mailer['mail_auth']) && $mailer['mail_auth'] == 'auth_yes') ? false : true)
            ),
            array(
                '#type' => 'password',
                '#name' => 'inputPassword',
                '#value' => ((isset($mailer['mail_pass'])) ? $mailer['mail_pass'] : ''),
                '#label' => t('Password'),
                '#id' => array(
                    'inputPassword'
                ),
                '#help' => t('Input the password that matches the username above'),
                '#wrapper' => true,
                '#disabled' => ((isset($mailer['mail_auth']) && $mailer['mail_auth'] == 'auth_yes') ? false : true)
            ),
            array(
                '#type' => 'text',
                '#name' => 'inputSendFromName',
                '#value' => ((isset($mailer['mail_sendname'])) ? $mailer['mail_sendname'] : getFieldFromDB('config', 'config_value', 'config_name', 'site_name')),
                '#label' => t('Name'),
                '#help' => t('Input the name that will be displayed in the reciepients mailbox. The default value is the site name'),
                '#wrapper' => true
            ),
            array(
                '#type' => 'text',
                '#name' => 'inputSendFromAddress',
                '#value' => ((isset($mailer['mail_sendfrom'])) ? $mailer['mail_sendfrom'] : ''),
                '#placeholder' => 'user@example.com',
                '#label' => t('Send from address'),
                '#help' => t('Input the address which you want to send emails from'),
                '#wrapper' => true
            ),
            array(
                '#type' => 'select',
                '#name' => 'inputSSL',
                '#multiple' => false,
                '#required' => false,
                '#label' => t('My server requires SSL encryption'),
                'items' => array(
                    'ssl' => array(
                        '#text' => t('Yes').' (SSL)',
                        '#selected' => ((isset($mailer['mail_ssl']) && $mailer['mail_ssl'] == 'ssl') ? true : false)
                    ),
                    'tls' => array(
                        '#text' => t('Yes').' (TLS)',
                        '#selected' => ((isset($mailer['mail_ssl']) && $mailer['mail_ssl'] == 'tls') ? true : false)
                    ),
                    'no' => array(
                        '#text' => t('No'),
                        '#selected' => ((isset($mailer['mail_ssl']) && $mailer['mail_ssl'] == 'no') ? true : false)
                    )
                ),
                '#wrapper' => true
            ),
            
            array(
                '#type' => 'submit',
                //'#id' => 'nameInput',
                '#class' => array(
                    'btn-rad',
                    'btn-primary'
                ),
                '#value' => t('Save settings'),
                '#wrapper' => true
            )
        )
    );
    $output .= Forms::renderForm($form);
    return $output;
}
function phpmailer_server_settings_submit() {
    
}
function phpmailer_get_config() {
    $db = db_connect();
    $data = array();
    $output = array();
    $query = $db->prepare("SELECT `config_name`, `config_value` FROM `config` WHERE `config_name` LIKE 'mail_%'");
    try {
        $query->execute();
        $data = $query->fetchAll(PDO::FETCH_ASSOC);
    }
    catch (Exception $e) {
        addMessage('error', t('Something went wrong. We could not collect the email configuration'), $e);
    }
    for ($index = 0; $index < count($data); $index++) {
        $output[$data[$index]['config_name']] = $data[$index]['config_value'];
    }
    return (is_array($output) && !empty($output)) ? $output : FALSE;
}