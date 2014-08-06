<?php
/**
 * @file
 * Functions for bootstrapping. Includes functions for aliased/legacy bootstrapping
 */
function core_bootstrapper(&$init, $bootstrapper_mode = EXEC_BOOTSTRAPPER_FULL) {
    Bootstrapper::core_bootstrapper($init, $bootstrapper_mode);
}
function finalize_page($init) {
    Bootstrapper::finalize_page($init);
}