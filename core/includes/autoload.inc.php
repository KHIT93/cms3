<?php
//Include system classes using autoload
spl_autoload_register(function($class){
    if(strpos($class, 'Exception')) {
        if(file_exists(CORE_CLASSES_PATH.'/'.$class.'.class.php')) {
            require_once CORE_CLASSES_PATH.'/exceptions/'.$class.'.class.php';
        }
    }
    else if(file_exists(CORE_CLASSES_PATH.'/'.$class.'.class.php')) {
        require_once CORE_CLASSES_PATH.'/'.$class.'.class.php';
    }
});
if(!file_exists('core/config/config.info')) {
    require_once CORE_INSTALLER_INCLUDES_PATH.'/Install.class.php';
}
//Include procedural functionality
require_once CORE_FUNCTIONS_PATH.'/bootstrapper.function.php';
require_once CORE_FUNCTIONS_PATH.'/db.function.php';
require_once CORE_FUNCTIONS_PATH.'/form.function.php';
require_once CORE_FUNCTIONS_PATH.'/language.function.php';
require_once CORE_FUNCTIONS_PATH.'/legacy.function.php';
require_once CORE_FUNCTIONS_PATH.'/menu.function.php';
require_once CORE_FUNCTIONS_PATH.'/page.function.php';
require_once CORE_FUNCTIONS_PATH.'/sanitize.function.php';
require_once CORE_FUNCTIONS_PATH.'/string.function.php';
require_once CORE_FUNCTIONS_PATH.'/system.function.php';
require_once CORE_FUNCTIONS_PATH.'/theme.function.php';
require_once CORE_FUNCTIONS_PATH.'/user.function.php';
require_once CORE_FUNCTIONS_PATH.'/validate.function.php';
require_once CORE_INSTALLER_INCLUDES_PATH.'/install.function.php';