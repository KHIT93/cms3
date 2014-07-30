<?php
class Form {
    public function __construct($form = array()) {
        
    }
    public static function form_delete($title, $name, $value, $item, $return_url) {
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