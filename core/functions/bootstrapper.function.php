<?php
/**
 * @file
 * Functions for bootstrapping. Includes functions for aliased/legacy bootstrapping
 */
function core_bootstrapper($init, $bootstrapper = EXEC_BOOTSTRAPPER_FULL) {
    Bootstrapper::core_bootstrapper($init, $bootstrap_mode);
}
function finalize_page($init) {
    Bootstrapper::finalize_page($init);
}