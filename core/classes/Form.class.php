<?php
class Form {
    private $_prepared, $_raw, $_tabControl = '', $_tabs = '', $_elements = '';
    public function __construct($form = array()) {
        $this->_raw = $form;
        $this->prepare();
    }
    public function render() {
        //Prepares the final HTML for the form and returns it to the caller
        
        //After processing the form
        //$_rendered = output;
        //return $_rendered;
        return $this->_prepared;
    }
    public function prepare() {
        //Prepare the form for rendering
        $prepared = '<form'.((isset($this->_raw['#name'])) ? ' name="'.$this->_raw['#name'].'"': '')
            .((isset($this->_raw['#method'])) ? ' method="'.$this->_raw['#method'].'"': '')
            .((isset($this->_raw['#action'])) ? ' action="'.$this->_raw['#action'].'"': '')
            .((is_array($this->_raw['#attr'])) ? ' '.Render::prepareAttributes($this->_raw['#attr']): '').'>';
        //Render elements, actions and other fields
        
        if(isset($this->_raw['elements'])) {
            foreach($this->_raw['elements'] as $element) {
                $this->_elements .= Render::prepareElement($element);
            }
        }
        if(isset($this->_raw['tabs'])) {
            $this->_tabControl .= '<ul id="content-tab" class="nav nav-tabs">';
            $this->_tabs .= '<div class="tab-content">';
            foreach ($this->_raw['tabs'] as $tab) {
                $content = Render::prepareTab($tab);
                $this->_tabControl .= $content['nav'];
                $this->_tabs .= $content['content'];
            }
            $this->_tabs .= '</div>';
            $this->_tabControl .= '</ul>';
        }
        
        $prepared .= $this->_elements;
        $prepared .= $this->_tabControl;
        $prepared .= $this->_tabs;
        $prepared .= Render::prepareActions($this->_raw['actions'], $this->_raw['#name']);
        
        $prepared .= '</form>';
        //After rendering set $_prepared to the returned data
        $this->_prepared = $prepared;
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
                else {
                    if(function_exists($form_submit)) {
                        $form_submit($_POST);
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