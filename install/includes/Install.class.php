<?php
/**
 * @file Class for creating a new installation
 */
class Install {
    private $_mode, $_status, $_steps = array();
    public function __construct($mode = EXEC_BOOTSTRAPPER_INSTALL) {
        $this->_mode = $mode;
        if($mode == EXEC_BOOTSTRAPPER_INSTALL) {
            //Prepare for new installation
            $this->_install_construct();
        }
        else if($mode == EXEC_BOOTSTRAPPER_MAINTENANCE) {
            //Prepare for updating installation
            $this->_update_construct();
        }
    }
    private function _install_construct() {
        //Private constructor for running new installation
        $this->_steps = Definition::loadRegistry(CORE_INSTALLER_INCLUDES_PATH.'/registry/install.steps.registry')['steps'];
    }
    private function _update_construct() {
        //Private constructor for updating an existing installation
        $this->_steps = Definition::loadRegistry(CORE_INSTALLER_INCLUDES_PATH.'/registry/update.steps.registry')['steps'];
    }
    private function _base_wizard() {
        //Prepares the base wizard structure
    }
    public function step($step = 1) {
        
    }
    public function render() {
        
    }
}
