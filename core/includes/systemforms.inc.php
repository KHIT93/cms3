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
    'addWidget' => array(
        '#name' => 'addWidget',
        '#method' => 'POST',
        '#action' => '',
        '#attr' => array(
            'role' => 'form'
        ),
        'elements' => array(
            array(
                '#type' => 'text',
                '#name' => 'title',
                '#label' => t('Title'),
                '#attr' => array(
                    'class' => 'form-control'
                ),
                '#size' => 60,
                '#value' => Input::get('title'),
                '#maxlength' => 255,
                '#required' => true,
                '#description' => t('Enter a title for your widget. This will be displayed as the widget name in the administration and will not be shown to visitors of the website'),
            ),
            array(
                '#type' => 'textarea',
                '#name' => 'content',
                '#cols' => 60,
                '#rows' => 5,
                '#attr' => array(
                    'class' => 'form-control'
                ),
                '#required' => false,
                '#description' => t('Enter the contents of your widget. This will be displayed to visitors of the website'),
                '#label' => t('Content')
            ),
            array(
                '#type' => 'select',
                '#name' => 'section',
                '#attr' => array(
                    'class' => 'select2'
                ),
                '#empty_option' => t('Inactive'),
                '#description' => t('Choose a section for where this widget should be displayed on the website'),
                '#options' => Widget::getSections(Theme::getTheme()),
                '#label' => t('Section')
            )
        ),
        'tabs' => array(
            array(
                '#type' => 'tab',
                '#name' => 'widgetPages',
                '#title' => t('Pages'),
                '#alignment' => 'top',
                '#auto_open' => true,
                '#children' => array(
                    array(
                        '#type' => 'markup',
                        '#value' => '<p><strong>'.t('Show widget on specific pages').'</strong></p>'
                    ),
                    array(
                        '#type' => 'radio',
                        '#name' => 'show',
                        '#default_value' => 0,
                        '#options' => array(
                            0 => t('All pages except the ones listed'),
                            1 => t('Only the listed pages')
                        ),
                        '#required' => false
                    ),
                    array(
                        '#type' => 'textarea',
                        '#name' => 'pages',
                        '#cols' => 60,
                        '#rows' => 5,
                        '#attr' => array(
                            'class' => 'form-control'
                        ),
                        '#required' => false
                    ),
                )
            ),
            array(
                '#type' => 'tab',
                '#name' => 'widgetRoles',
                '#title' => t('Roles'),
                '#alignment' => 'top',
                '#attr' => array(
                    'class' => 'form-wrapper'
                ),
                '#children' => array(
                    array(
                        '#type' => 'markup',
                        '#value' => '<p>'.t('This widget will only be shown to the following roles. If no roles are selected it will be shown to all roles').'</p>'
                    ),
                    array(
                        '#type' => 'checkbox',
                        '#name' => 'roles',
                        '#options' => output_as_select(Permission::get_roles(), 'rid', 'name')
                    )
                )
            )
        ),
        'actions' => array(
            'submit' => array(
                '#type' => 'submit',
                '#attr' => array(
                    'class' => 'btn btn-rad btn-primary btn-sm'
                ),
                '#name' => 'addWidget',
                '#value' => t('Save widget')
            ),
            'cancel' => array(
                '#type' => 'markup',
                '#value' => '<a href="/admin/layout/widgets" class="btn btn-rad btn-default btn-sm">'.t('Cancel').'</a>'
            )
        )
    ),
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
    'globalMetaData' => array(
        '#name' => 'globalMetaData',
        '#method' => 'POST',
        '#action' => '',
        '#attr' => array(
            'role' => 'form'
        ),
        'elements' => array(
            array(
                '#type' => 'text',
                '#name' => 'title',
                '#label' => t('Page title'),
                '#attr' => array(
                    'class' => 'form-control'
                ),
                '#size' => 60,
                '#value' => Input::get('title'),
                '#maxlength' => 255,
                '#required' => false,
                '#description' => t('Enter a pattern for the page title. Fx. %page_title | %site_name'),
            ),
            array(
                '#type' => 'text',
                '#name' => 'description',
                '#label' => t('SEO Description'),
                '#attr' => array(
                    'class' => 'form-control'
                ),
                '#size' => 60,
                '#value' => Input::get('description'),
                '#maxlength' => 255,
                '#required' => false,
                '#description' => t('Enter a default description, which will be used when there has not been entered a description on the page.'),
            ),
            array(
                '#type' => 'text',
                '#name' => 'keywords',
                '#label' => t('SEO keywords'),
                '#attr' => array(
                    'class' => 'form-control'
                ),
                '#size' => 60,
                '#value' => Input::get('keywords'),
                '#maxlength' => 255,
                '#required' => false,
                '#description' => t('Enter a set of keywords which will be used when there are no keywords for a page.'),
            ),
        ),
        'actions' => array(
            'submit' => array(
                '#type' => 'submit',
                '#attr' => array(
                    'class' => 'btn btn-rad btn-success btn-sm'
                ),
                '#name' => 'addMetaRedirect',
                '#value' => t('Save')
            )
        )
    ),
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
                '#prefix' => '<p>'.System::siteURL().'/ ',
                '#suffix' => '</p>',
                '#wrapper_class' => 'form-inline',
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
                '#prefix' => '<p>'.System::siteURL().'/ ',
                '#suffix' => '</p>',
                '#wrapper_class' => 'form-inline',
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
                '#prefix' => '<p>'.System::siteURL().'/ ',
                '#suffix' => '</p>',
                '#wrapper_class' => 'form-inline',
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
                '#prefix' => '<p>'.System::siteURL().'/ ',
                '#suffix' => '</p>',
                '#wrapper_class' => 'form-inline',
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
    'globalErrorPages' => array(
        '#name' => 'globalErrorPages',
        '#method' => 'POST',
        '#action' => '',
        '#attr' => array(
            'role' => 'form'
        ),
        'elements' => array(
            array(
                '#type' => 'markup',
                '#value' => '<p>'.t('Please provide paths for the error pages below.<br/>Note that there are more error pages than the ones listed below and these will be handled by core since these errors occurs before database access is established').'</p>'
            ),
            array(
                '#type' => 'text',
                '#name' => 'error404',
                '#label' => t('Error 404: Page not found'),
                '#attr' => array(
                    'class' => 'form-control'
                ),
                '#size' => 60,
                '#prefix' => '<p>'.System::siteURL().'/ ',
                '#suffix' => '</p>',
                '#wrapper_class' => 'form-inline',
                '#value' => Input::get('error404'),
                '#maxlength' => 255,
                '#required' => false,
                '#description' => t('Enter a path for a page which will be shown when a requested page does not exist'),
            ),
            array(
                '#type' => 'text',
                '#name' => 'error403',
                '#label' => t('Error 403: Access Denied'),
                '#attr' => array(
                    'class' => 'form-control'
                ),
                '#size' => 60,
                '#prefix' => '<p>'.System::siteURL().'/ ',
                '#suffix' => '</p>',
                '#wrapper_class' => 'form-inline',
                '#value' => Input::get('title'),
                '#maxlength' => 255,
                '#required' => false,
                '#description' => t('Enter a path for a page which will be shown when a user does not have access to a requested page'),
            ),
        ),
        'actions' => array(
            'submit' => array(
                '#type' => 'submit',
                '#attr' => array(
                    'class' => 'btn btn-rad btn-success btn-sm'
                ),
                '#name' => 'globalErrorPages',
                '#value' => t('Save')
            )
        )
    )
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