<?php
/**
 * @file
 * Contains renderable arrays for all system forms.
 */
$GLOBALS['forms'] = array(
    'addPage' => array(),
    'editPage' => array(),
    'addMenuItem' => array(),
    'editMenuItem' => array(),
    'addWidget' => array(),
    'editWidget' => array(),
    'addUser' => array(),
    'editUser' => array(),
    'editUserPassword' => array(),
    'addRole' => array(),
    'userLogin' => array(),
    'userRegister' => array(),
    'editSite' => array(),
    'globalUser' => array(),
    'enableWysiwyg' => array(),
    'setDevMode' => array(),
    'setMaintenance' => array(),
    'globalMetaData' => array(),
    'addMetaRedirect' => array(
        '#name' => 'addMetaRedirect',
        '#method' => 'POST',
        '#action' => '',
        '#attr' => array(
            'role' => 'form'
        ),
        'elements' => array(
            array(
                '#type' => 'text',
                '#name' => 'source',
                '#label' => t('From').' *',
                '#attr' => array(
                    'class' => 'form-control'
                ),
                '#size' => 60,
                '#value' => Input::get('source'),
                '#maxlength' => 255,
                '#required' => true,
                '#description' => t('Enter an internal path or path alias to redirect (fx. <i>pages/123</i>). Fragment anchors (fx. #anchor) are <strong>not</strong> allowed'),
            ),
            array(
                '#type' => 'text',
                '#name' => 'destination',
                '#label' => t('To').' *',
                '#attr' => array(
                    'class' => 'form-control'
                ),
                '#size' => 60,
                '#value' => Input::get('destination'),
                '#maxlength' => 255,
                '#required' => true,
                '#description' => t('Enter an internal path, path alias or external URL to redirect (fx. <i>pages/123</i> or <i>http://example.com</i>).'),
            ),
            array(
                '#type' => 'select',
                '#name' => 'language',
                '#attr' => array(
                    'class' => 'select2'
                ),
                '#empty_option' => t('All languages'),
                '#default_value' => Config::get('site/site_language'),
                '#description' => t('A redirect set for a specific language will always be used when requesting this page in that language, and takes precedence over redirects set for <i>All languages</i>.'),
                '#options' => output_languages_as_select(get_active_languages()),
                '#label' => t('Language')
            )
        ),
        'actions' => array(
            'submit' => array(
                '#type' => 'submit',
                '#attr' => array(
                    'class' => 'btn btn-rad btn-success btn-sm'
                ),
                '#name' => 'addMetaRedirect',
                '#value' => t('Save')
            ),
            'cancel' => array(
                '#type' => 'markup',
                '#value' => '<a href="/admin/settings/search/redirect" class="btn btn-rad btn-default btn-sm">'.t('Cancel').'</a>'
            )
        )
    ),
    'editMetaRedirect' => array(
        '#name' => 'editMetaRedirect',
        '#method' => 'POST',
        '#action' => '',
        '#attr' => array(
            'role' => 'form'
        ),
        'elements' => array(
            array(
                '#type' => 'text',
                '#name' => 'source',
                '#label' => t('From').' *',
                '#attr' => array(
                    'class' => 'form-control'
                ),
                '#size' => 60,
                '#value' => Input::get('source'),
                '#maxlength' => 255,
                '#required' => true,
                '#description' => t('Enter an internal path or path alias to redirect (fx. <i>pages/123</i>). Fragment anchors (fx. #anchor) are <strong>not</strong> allowed'),
            ),
            array(
                '#type' => 'text',
                '#name' => 'destination',
                '#label' => t('To').' *',
                '#attr' => array(
                    'class' => 'form-control'
                ),
                '#size' => 60,
                '#value' => Input::get('destination'),
                '#maxlength' => 255,
                '#required' => true,
                '#description' => t('Enter an internal path, path alias or external URL to redirect (fx. <i>pages/123</i> or <i>http://example.com</i>).'),
            ),
            array(
                '#type' => 'select',
                '#name' => 'language',
                '#attr' => array(
                    'class' => 'select2'
                ),
                '#empty_option' => t('All languages'),
                '#default_value' => Config::get('site/site_language'),
                '#description' => t('A redirect set for a specific language will always be used when requesting this page in that language, and takes precedence over redirects set for <i>All languages</i>.'),
                '#options' => output_languages_as_select(get_active_languages()),
                '#label' => t('Language')
            )
        ),
        'actions' => array(
            'submit' => array(
                '#type' => 'submit',
                '#attr' => array(
                    'class' => 'btn btn-rad btn-success btn-sm'
                ),
                '#name' => 'editMetaRedirect',
                '#value' => t('Save')
            ),
            'cancel' => array(
                '#type' => 'markup',
                '#value' => '<a href="/admin/settings/search/redirect" class="btn btn-rad btn-default btn-sm">'.t('Cancel').'</a>'
            )
        )
    ),
    'globalErrorPages' => array()
);
//Add default values for form attributes and fields
$GLOBALS['config']['forms'] = array(
    'text' => array(
        'maxlength' => 255,
        'size' => 60
    ),
    'select' => array(
        'empty_value' => 0,
        'empty_option' => '- '.t('Select').' -'
    )
);