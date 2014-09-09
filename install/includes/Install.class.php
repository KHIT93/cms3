<?php
/**
 * @file Class for creating a new installation
 */
class Install {
    private static $_instance;
    private $_mode, $_status, $_steps = array(), $_wizard, $_current;
    public function __construct($mode = EXEC_BOOTSTRAPPER_INSTALL, $step = 1) {
        $this->_mode = $mode;
        $this->_current = $step;
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
        $this->_steps = Definition::loadRegistry(CORE_INSTALLER_INCLUDES_PATH.'/registry/install.steps.registry');
    }
    private function _update_construct() {
        //Private constructor for updating an existing installation
        $this->_steps = Definition::loadRegistry(CORE_INSTALLER_INCLUDES_PATH.'/registry/update.steps.registry');
    }
    private function _base_wizard() {
        //Prepares the base wizard structure
        $this->_wizard = array(
            '#attr' => array(
                'class' => 'wizard wizard-ux',
                'id' => 'myWizard'
            ),
            'steps' => $this->_steps
        );
    }
    private function _installWizard() {
        $this->_wizard['text'] = array(
            1 => array(
                'header' => array(
                    '#type' => 'markup',
                    '#value' => '<h3 class="hthin">'.rt('Welcome').'</h3>'
                ),
                'prefix' => array(
                    '#type' => 'markup',
                    '#value' => '<p>'.rt('Thank your for choosing our application for your website.<br/>Please choose your language below to proceed').'</p>'
                )
            ),
            2 => array(
                'header' => array(
                    '#type' => 'markup',
                    '#value' => '<h3 class="hthin">'.rt('License Aggreement').'</h3>'
                ),
                'prefix' => array(
                    '#type' => 'markup',
                    '#value' => '<p>'.rt('Please read and accept the license terms below in order to proceed.').'</p>'
                )
            ),
            3 => array(
                'header' => array(
                    '#type' => 'markup',
                    '#value' => '<h3 class="hthin">'.rt('Verify requirements').'</h3>'
                ),
                'prefix' => array(
                    '#type' => 'markup',
                    '#value' => '<p>'.rt('Please make sure that all requirements below are fullflled before you can continue').'</p>'
                ),
                'suffix' => array(
                    '#type' => 'markup',
                    '#value' => '<p>'.rt('Please <a href="'.$_SERVER['REQUEST_URI'].'">verify again</a> after fixing any issues above').'</p>'
                )
            ),
            4 => array(
                'header' => array(
                    '#type' => 'markup',
                    '#value' => '<h3 class="hthin">'.rt('Connect to the database').'</h3>'
                ),
                'prefix' => array(
                    '#type' => 'markup',
                    '#value' => '<p>'.rt('Please fill in the credentials for your database server below').'</p>'
                )
            ),
            5 => array(
                'header' => array(
                    '#type' => 'markup',
                    '#value' => '<h3 class="hthin">'.rt('Configuring the database').'</h3>'
                )
            ),
            6 => array(
                'header' => array(
                    '#type' => 'markup',
                    '#value' => '<h3 class="hthin">'.rt('Configure site').'</h3>'
                )
            ),
            7 => array(
                'header' => array(
                    '#type' => 'markup',
                    '#value' => '<h3 class="hthin">'.rt('Installing').'</h3>'
                )
            )
        );
        $this->_wizard['forms'] = array(
            1 => array(
                '#name' => 'welcomeForm',
                '#method' => 'POST',
                '#action' => '',
                '#attr' => array(
                    'role' => 'form'
                ),
                'elements' => array(
                    array(
                        '#type' => 'select',
                        '#name' => 'lang',
                        '#attr' => array(
                            'class' => 'select2'
                        ),
                        '#empty_option' => rt('-- Select language --'),
                        '#options' => get_installer_languages()
                    )
                ),
                'actions' => array(
                    'previous' => array(
                        '#type' => 'markup',
                        '#value' => '<a href="/install.php?step='.($this->_current-1).'" class="btn btn-rad btn-prev btn-default"'.(($this->_current == 1) ? ' disabled': '').'> <span class="glyphicon glyphicon-arrow-left"></span> '.rt('Previous').'</a>'
                    ),
                    'submit' => array(
                        '#type' => 'submit',
                        '#attr' => array(
                            'class' => 'btn btn-rad btn-next btn-primary'
                        ),
                        '#name' => 'welcomeSubmit',
                        '#value' => rt('Next').' <span class="glyphicon glyphicon-arrow-right"></span>'
                    )
                )
            ),
            2 => array(
                '#name' => 'licenseForm',
                '#method' => 'POST',
                '#action' => '',
                '#attr' => array(
                    'role' => 'form'
                ),
                'elements' => array(
                    array(
                        '#type' => 'markup',
                        '#value' => '<h4>'.rt('Application license').'</h4>'
                    ),
                    array(
                        '#type' => 'markup',
                        '#value' => '<p>'.rt('The core application and underlying code is licensed under GPLv2').'</p>'
                    ),
                    array(
                        '#type' => 'markup',
                        '#value' => '<div class="checkbox">'
                        . '<label class="checkbox-custom" data-initialize="checkbox">'
                        . '<input type="checkbox" name="app_license" value="accepted" class="sr-only">'
                        . '<span class="checkbox-label">'.rt('I accept the application license').'</span>'
                        . '</label>'
                        . '</div>',
                    ),
                    array(
                        '#type' => 'markup',
                        '#value' => '<h4>'.rt('Twitter Bootstrap License').'</h4>'
                    ),
                    array(
                        '#type' => 'markup',
                        '#value' => '<p>'.rt('The Twitter Bootstrap Design Framework and addon components used in this application is licensed under <a href="https://github.com/twbs/bootstrap/blob/master/LICENSE" target="_blank">MIT</a>').'</p>'
                    ),
                    array(
                        '#type' => 'markup',
                        '#value' => '<div class="checkbox">'
                        . '<label class="checkbox-custom" data-initialize="checkbox">'
                        . '<input type="checkbox" name="bootstrap_license" value="accepted" class="sr-only">'
                        . '<span class="checkbox-label">'.rt('I accept the Bootstrap license').'</span>'
                        . '</label>'
                        . '</div>',
                    ),
                ),
                'actions' => array(
                    'previous' => array(
                        '#type' => 'markup',
                        '#value' => '<a href="/install.php?step='.($this->_current-1).'" class="btn btn-rad btn-prev btn-default"'.(($this->_current == 1) ? ' disabled': '').'> <span class="glyphicon glyphicon-arrow-left"></span> '.rt('Previous').'</a>'
                    ),
                    'submit' => array(
                        '#type' => 'submit',
                        '#attr' => array(
                            'class' => 'btn btn-rad btn-next btn-primary'
                        ),
                        '#name' => 'licenseSubmit',
                        '#value' => rt('Next').' <span class="glyphicon glyphicon-arrow-right"></span>'
                    )
                )
            ),
            3 => array(
                '#name' => 'requirements',
                '#method' => 'POST',
                '#action' => '',
                '#attr' => array(
                    'role' => 'form'
                ),
                'elements' => array(
                    array(
                        '#type' => 'markup',
                        '#value' => $this->_verify()
                    )
                ),
                'actions' => array(
                    'previous' => array(
                        '#type' => 'markup',
                        '#value' => '<a href="/install.php?step='.($this->_current-1).'" class="btn btn-rad btn-prev btn-default"'.(($this->_current == 1) ? ' disabled': '').'> <span class="glyphicon glyphicon-arrow-left"></span> '.rt('Previous').'</a>'
                    ),
                    'submit' => array(
                        '#type' => 'submit',
                        '#attr' => array(
                            'class' => 'btn btn-rad btn-next btn-primary'
                        ),
                        '#name' => 'requirements',
                        '#value' => rt('Next').' <span class="glyphicon glyphicon-arrow-right"></span>'
                    )
                )
            ),
            4 => array(
                '#name' => 'dbCredentials',
                '#method' => 'POST',
                '#action' => '',
                '#attr' => array(
                    'role' => 'form'
                ),
                'elements' => array(
                    array(
                        '#type' => 'select',
                        '#name' => 'driver',
                        '#wrapper_class' => 'col-sm-8',
                        '#attr' => array(
                            'class' => 'select2'
                        ),
                        '#empty_option' => rt('-- Select Database Engine --'),
                        '#options' => get_db_drivers(),
                        '#label' => rt('Database engine').':'
                    ),
                    array(
                        '#type' => 'text',
                        '#name' => 'host',
                        '#label' => rt('Database host').':',
                        '#default_value' => 'localhost',
                        '#attr' => array(
                            'class' => 'form-control',
                            'id' => 'host'
                        ),
                        '#wrapper_class' => 'col-sm-8',
                        '#size' => 60,
                        '#required' => false,
                        '#autocomplete' => false,
                    ),
                    array(
                        '#type' => 'text',
                        '#name' => 'username',
                        '#label' => rt('Database username').':',
                        '#attr' => array(
                            'class' => 'form-control',
                            'id' => 'username'
                        ),
                        '#wrapper_class' => 'col-sm-8',
                        '#size' => 60,
                        '#required' => true,
                        '#autocomplete' => false,
                    ),
                    array(
                        '#type' => 'password',
                        '#name' => 'password',
                        '#label' => rt('Database password').':',
                        '#attr' => array(
                            'class' => 'form-control',
                            'id' => 'password'
                        ),
                        '#wrapper_class' => 'col-sm-8',
                        '#size' => 60,
                        '#required' => true,
                    ),
                    array(
                        '#type' => 'text',
                        '#name' => 'db',
                        '#label' => rt('Database').':',
                        '#attr' => array(
                            'class' => 'form-control',
                            'id' => 'db'
                        ),
                        '#wrapper_class' => 'col-sm-8',
                        '#size' => 60,
                        '#required' => true,
                        '#autocomplete' => false,
                    ),
                    array(
                        '#type' => 'text',
                        '#name' => 'port',
                        '#label' => rt('Database port').':',
                        '#default_value' => '3306',
                        '#attr' => array(
                            'class' => 'form-control',
                            'id' => 'port'
                        ),
                        '#wrapper_class' => 'col-sm-8',
                        '#size' => 60,
                        '#required' => false,
                        '#autocomplete' => false,
                    ),
                ),
                'actions' => array(
                    'previous' => array(
                        '#type' => 'markup',
                        '#value' => '<a href="/install.php?step='.($this->_current-1).'" class="btn btn-rad btn-prev btn-default"'.(($this->_current == 1) ? ' disabled': '').'> <span class="glyphicon glyphicon-arrow-left"></span> '.rt('Previous').'</a>'
                    ),
                    'submit' => array(
                        '#type' => 'submit',
                        '#attr' => array(
                            'class' => 'btn btn-rad btn-next btn-primary'
                        ),
                        '#name' => 'dbCredentials',
                        '#value' => rt('Next').' <span class="glyphicon glyphicon-arrow-right"></span>'
                    )
                )
            ),
            5 => array(
                '#name' => 'configure_db',
                '#method' => 'POST',
                '#action' => '',
                '#attr' => array(
                    'role' => 'form',
                    'id' => 'ajax-autoloader'
                ),
                'elements' => array(
                    array(
                        '#type' => 'markup',
                        '#value' => '<div class="progress progress-striped active">'
                        . '<div class="progress-bar progress-bar-info" style="width: 100%"></div>'
                        . '</div>'
                        . '<p>'.rt('Installing <i>Database</i>').'...</p>'
                    )
                ),
                'actions' => array(
                    'previous' => array(
                        '#type' => 'markup',
                        '#value' => '<a href="/install.php?step='.($this->_current-1).'" class="btn btn-rad btn-prev btn-default" disabled> <span class="glyphicon glyphicon-arrow-left"></span> '.rt('Previous').'</a>'
                    ),
                    'submit' => array(
                        '#type' => 'submit',
                        '#attr' => array(
                            'class' => 'btn btn-rad btn-next btn-primary',
                            'disabled' => ''
                        ),
                        '#name' => 'configure_db',
                        '#value' => rt('Next').' <span class="glyphicon glyphicon-arrow-right"></span>'
                    )
                )
            ),
            6 => array(
                '#name' => 'siteInformation',
                '#method' => 'POST',
                '#action' => '',
                '#attr' => array(
                    'role' => 'form'
                ),
                'elements' => array(
                    array(
                        '#type' => 'text',
                        '#name' => 'name',
                        '#label' => rt('Site name').':',
                        '#default_value' => $_SERVER['HTTP_HOST'],
                        '#attr' => array(
                            'class' => 'form-control',
                            'id' => 'name'
                        ),
                        '#wrapper_class' => 'col-sm-8',
                        '#size' => 60,
                        '#required' => false,
                        '#autocomplete' => false,
                    ),
                    array(
                        '#type' => 'text',
                        '#name' => 'slogan',
                        '#label' => rt('Site slogan').':',
                        '#attr' => array(
                            'class' => 'form-control',
                            'id' => 'slogan'
                        ),
                        '#wrapper_class' => 'col-sm-8',
                        '#size' => 60,
                        '#required' => true,
                        '#autocomplete' => false,
                    ),
                    array(
                        '#type' => 'text',
                        '#name' => 'adminUser',
                        '#label' => rt('Administrator username').':',
                        '#default_value' => 'admin',
                        '#attr' => array(
                            'class' => 'form-control',
                            'id' => 'adminUser'
                        ),
                        '#wrapper_class' => 'col-sm-8',
                        '#size' => 60,
                        '#required' => false,
                        '#autocomplete' => false,
                    ),
                    array(
                        '#type' => 'text',
                        '#name' => 'adminName',
                        '#label' => rt('Administrator name').':',
                        '#default_value' => 'Administrator',
                        '#attr' => array(
                            'class' => 'form-control',
                            'id' => 'adminName'
                        ),
                        '#wrapper_class' => 'col-sm-8',
                        '#size' => 60,
                        '#required' => false,
                        '#autocomplete' => false,
                    ),
                    array(
                        '#type' => 'email',
                        '#name' => 'adminEmail',
                        '#label' => rt('Administrator Email').':',
                        '#placeholder' => 'example@example.com',
                        '#attr' => array(
                            'class' => 'form-control',
                            'id' => 'adminEmail'
                        ),
                        '#wrapper_class' => 'col-sm-8',
                        '#size' => 60,
                        '#required' => true,
                        '#autocomplete' => false,
                    ),
                    array(
                        '#type' => 'password',
                        '#name' => 'adminPassword',
                        '#label' => rt('Administrator password').':',
                        '#attr' => array(
                            'class' => 'form-control',
                            'id' => 'adminPassword'
                        ),
                        '#wrapper_class' => 'col-sm-8',
                        '#size' => 60,
                        '#required' => true,
                        '#autocomplete' => false,
                    )
                ),
                'actions' => array(
                    'previous' => array(
                        '#type' => 'markup',
                        '#value' => '<a href="/install.php?step='.($this->_current-1).'" class="btn btn-rad btn-prev btn-default"'.(($this->_current == 1) ? ' disabled': '').'> <span class="glyphicon glyphicon-arrow-left"></span> '.rt('Previous').'</a>'
                    ),
                    'submit' => array(
                        '#type' => 'submit',
                        '#attr' => array(
                            'class' => 'btn btn-rad btn-next btn-primary'
                        ),
                        '#name' => 'siteInformation',
                        '#value' => rt('Next').' <span class="glyphicon glyphicon-arrow-right"></span>'
                    )
                )
            ),
            7 => array(
                '#name' => 'install_site',
                '#method' => 'POST',
                '#action' => '',
                '#attr' => array(
                    'role' => 'form'
                ),
                'elements' => array(
                    array(
                        '#type' => 'markup',
                        '#value' => '<div class="progress progress-striped active">'
                        . '<div class="progress-bar progress-bar-info" style="width: 100%"></div>'
                        . '</div>'
                        . '<p>'.rt('Installing <i>@COMPONENT</i>').'...</p>'
                    )
                ),
                'actions' => array(
                    'previous' => array(
                        '#type' => 'markup',
                        '#value' => '<a href="/install.php?step='.($this->_current-1).'" class="btn btn-rad btn-prev btn-default" disabled> <span class="glyphicon glyphicon-arrow-left"></span> '.rt('Previous').'</a>'
                    ),
                    'submit' => array(
                        '#type' => 'submit',
                        '#attr' => array(
                            'class' => 'btn btn-rad btn-next btn-primary',
                            'disabled' => ''
                        ),
                        '#name' => 'install_site',
                        '#value' => rt('Next').' <span class="glyphicon glyphicon-arrow-right"></span>'
                    )
                )
            ),
        );
    }
    private function _updateWizard() {
        $this->_wizard['text'] = array(
            1 => array(
                'header' => array(

                ),
                'prefix' => array(

                ),
                'suffix' => array(

                )
            )
        );
        $this->_wizard['forms'] = array(
            1 => array(
                //Renderable form array
            )
        );
    }
    private function _verify() {
        //Generate a list of requirements for the application core to work
        $output = '<table class="table table-hover">'
                . '<tbody>'
                . '<tr>'
                . '<td>'.rt('Webserver').'</td>'
                . '<td>'.$_SERVER['SERVER_SOFTWARE'].'</td>'
                . '</tr>'
                . '<tr>'
                . '<td>'.rt('PHP Version').'</td>'
                . '<td class="'.((version_compare(phpversion(), '5.4.0', '>=')) ? 'bg-success': 'bg-danger').'">'.PHP_VERSION.'</td>'
                . '</tr>'
                . '<tr>'
                . '<td>'.rt('PHP memory limit').'</td>'
                . '<td>'.ini_get('memory_limit').' ('.rt('128M required').')'.'</td>'
                . '</tr>'
                . '<tr>'
                . '<td>'.rt('PHP Database Extension').'</td>'
                . '<td class="'.((extension_loaded('mysql')) ? 'bg-success': 'bg-danger').'">'.((extension_loaded('mysql')) ? 'Enabled': 'Disabled').'</td>'
                . '</tr>'
                . '<tr>'
                . '<td>'.rt('Filesystem').'</td>'
                . '<td class="'.((is_writable('uploads')) ? 'bg-success': 'bg-danger').'">'.((is_writable('uploads')) ? rt('Usable filesystem is writable'): rt('Usable filesystem is not writable')).'</td>'
                . '</tr>'
                . '<tr>'
                . '<td>'.rt('Configuration file').'</td>'
                . '<td class="'.((is_writable('core/config')) ? 'bg-success': 'bg-danger').'">'.((is_writable('core/config')) ? rt('Configuration file can be written'): rt('Configuration file cannot be written')).'</td>'
                . '</tr>'
                . '</tbody>'
                . '</table>';
        return $output;
    }
    private function _step() {
        $form = (isset($this->_wizard['forms'][$this->_current])) ? $this->_wizard['forms'][$this->_current]: array();
        $fields = '';
        $output = '';
        //Prepare the form for rendering
        $output .= ((count($form)) ? '<form'.((isset($form['#name'])) ? ' name="'.$form['#name'].'"': '')
            .((isset($form['#method'])) ? ' method="'.$form['#method'].'"': '')
            .((isset($form['#action'])) ? ' action="'.$form['#action'].'"': '')
            .((isset($form['#attr']) && is_array($form['#attr'])) ? ' '.Render::prepareAttributes($form['#attr']): '').'>': '');
        //Render elements, actions and other fields
        $output .= '<div class="step-content">'
                . '<div class="step pane active" data-step="'.$this->_current.'">'
                . '<div class="form-group no-padding">'
                . '<div class="col-sm-12">'
                . ((Session::exists('messages')) ? System::print_messages_simple(): '')
                . Render::prepareElement($this->_wizard['text'][$this->_current]['header'])
                . ((isset($this->_wizard['text'][$this->_current]['prefix'])) ? Render::prepareElement($this->_wizard['text'][$this->_current]['prefix']): '');
        if(isset($form['elements'])) {
            foreach($form['elements'] as $element) {
                $fields .= Render::prepareElement($element);
            }
        }
        $output .= $fields;
        $output .= ((isset($this->_wizard['text'][$this->_current]['suffix'])) ? Render::prepareElement($this->_wizard['text'][$this->_current]['suffix']): '');
        $output .= '</div>'
                . '</div>'
                . '</div>'
                . '</div>';
        $output .= '<div class="actions">'.Render::prepareActions($form['actions'], $form['#name']).'</div>';
        $output .= (count($form)) ? '</form>': '';
        return $output;
    }
    public function render() {
        $step = $this->_current;
        $this->_base_wizard();
        if($this->_mode == EXEC_BOOTSTRAPPER_INSTALL) {
            $this->_installWizard();
        }
        else if($this->_mode == EXEC_BOOTSTRAPPER_MAINTENANCE) {
            $this->_updateWizard();
        }
        $output = '<div '.((isset($this->_wizard['#attr'])) ? Render::prepareAttributes($this->_wizard['#attr']) : '').'>';
        if($step == (count($this->_wizard['steps'])+1)) {
            //Render the final step
            $this->_wizard['steps'][] = 'Finished';
            $output .= '<div class="navigation">'
                    . Render::prepareWizardMenu($this->_wizard['steps'], count($this->_wizard['steps']))
                    . '</div>';
            $output .= '<div class="step-content">'
                    . '<div class="step-pane active" data-step="'.$step.'">'
                    . '<div class="form-group no-padding">'
                    . '<div class="col-sm-12">'
                    . '<div class="text-center">'
                    . '<div class="i-circle success"><i class="fa fa-check"></i></div>'
                    . '<h3 class="hthin">'.rt('Congratulations').'!</h3>'
                    . '<p>'.rt('Your new site is now configured and ready for use').'.</p>'
                    . '<p>'.rt('If you need help to customize your site, you can check the <a href="/admin/help/getting-started">Help</a> section').'</p>'
                    . '</div>'
                    . '</div>'
                    . '</div>'
                    . '</div>'
                    . '</div>';
            
        }
        else if($step == 'error') {
            $this->_wizard['steps'][] = 'Failed';
            //Render an error page
            $output .= '<div class="navigation">'
                    . Render::prepareWizardMenu($this->_wizard['steps'], count($this->_wizard['steps']))
                    . '</div>';
            
            $output .= '<div class="step-content">'
                    . '<div class="step-pane active" data-step="'.$step.'">'
                    . '<div class="form-group no-padding">'
                    . '<div class="col-sm-12">'
                    . '<div class="text-center">'
                    . '<div class="i-circle danger"><i class="fa fa-times"></i></div>'
                    . '<h3 class="hthin">'.rt('Installation failed').'!</h3>'
                    . '<p>'.rt('Something went wrong during the installation').'.</p>'
                    . System::print_messages_simple()
                    . '</div>'
                    . '</div>'
                    . '</div>'
                    . '</div>'
                    . '</div>';
            
        }
        else {
            //Render the next step in the form
            $this->_wizard['steps'][] = 'Finished';
            $output .= '<div class="navigation">'
                    . Render::prepareWizardMenu($this->_wizard['steps'], $step)
                    . '</div>'
                    . $this->_step();
        }
        $output .= '</div>';
        return $output;
    }
    public static function getInstance($mode = EXEC_BOOTSTRAPPER_INSTALL) {
        if(!isset(self::$_instance)) {
            self::$_instance = new Install($mode);
        }
        return self::$_instance;
    }
}
