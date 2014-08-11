<?php
class Form {
    public function __construct($form = array()) {
        
    }
    public function render() {
        //Prepares the form for rendering as HTML on a page
    }
    public static function submit() {
        //Handles form submission
        if(Input::exists('post')) {
            if(Token::check(Input::get(Config::get('session/token_name')))) {
                //Validate form
                $form_validate = Input::get('form_id').'_validate';
                $form_submit = Input::get('form_id').'_submit';
                if(function_exists($form_validate)) {
                    if($form_validate()) {
                        if(function_exists($form_submit)) {
                            $form_submit($_POST);
                        }
                    }
                }
            }
            else {
                System::addMessage('error', t('Sorry, the form you have submitted is invalid'));
            }
        }
    }
    public static function formDelete($title, $name, $value, $item, $return_url, $form_id = NULL) {
        $form = array(
            '#name' => $name,
            '#method' => 'POST',
            '#captcha' => true,
            '#action' => '',
            'elements' => array(
                array(
                    '#type' => 'hidden',
                    '#name' => 'inputId',
                    '#value' => $value
                ),
                array(
                    '#type' => 'link',
                    '#href' => $return_url,
                    '#value' => t('Cancel'),
                    '#class' => array(
                        'btn',
                        'btn-rad',
                        'btn-sm',
                        'btn-default'
                    ),
                    '#wrapper' => false
                ),
                array(
                    '#type' => 'submit',
                    '#value' => '<span class="glyphicon glyphicon-floppy-remove"></span> '.$title,
                    '#class' => array(
                        'btn-rad',
                        'btn-sm',
                        'btn-danger'
                    ),
                    '#wrapper' => false
                )
            )
        );
        $output = '<div class="cl-mcont">'
                . print_messages()
                . '<div class="modal-header">'
                   .'<h3 class="modal-title">'.$title.'</h3>'
                .'</div>'
                .'<div class="modal-body">'
                    .'<p>'.t('Are you sure that you want to delete').' "<i>'.$item.'"</i>?</p>'
                .'</div>'
                .'<div class="modal-footer">'
                    .self::renderForm($form)
                .'</div>';
        return $output;
    }
}