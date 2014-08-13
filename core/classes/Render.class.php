<?php
/**
 * @file
 * Handles the rendering of the elements passed by renderable arrays
 */
class Render {
    public static function prepareElement($element = array(), $wrapper = true) {
        $allowed = self::allowedElementTypes();
        $output = '';
        if(count($element) && in_array($element['#type'], $allowed)) {
            $output .= ($wrapper == true) ? '<div id="form-'.(isset($element['#name']) ? $element['#name'] : 'element').'" class="form-group">': '';
            if(isset($element['#children'])) {
                foreach($element['#children'] as $child) {
                    $output .= self::prepareElement($child);
                }
            }
            else {
                $output .= ($element['#type'] == 'textarea') ? self::prepareTextArea($element) : self::prepareInput($element);
            }
            $output .= ($wrapper == true) ? '</div>': '';
        }
        return $output;
    }
    public static function prepareInput($element = array()) {
        $output = '';
        $withOptions = array('checkbox', 'radio', 'select');
        if(count($element)) {
            if(in_array($element['#type'], $withOptions)) {
                if($element['#type'] == 'select') {
                    $output .= self::prepareLabel($element['#label']).'<select'
                            .((isset($element['#name'])) ? ' name="'.$element['#name'].'"': '')
                            .((isset($element['#size'])) ? ' size="'.$element['#size'].'"': '')
                            .((isset($element['#disabled'])) ? ' disabled': '')
                            .((isset($element['#multiple'])) ? ' multiple': '')
                            .((isset($element['#required'])) ? ' required': '')
                            .self::prepareAttributes($element['#attr'])
                            .'>';
                    $output .= self::prepareOptions($element['#options']);
                    $output .= '</select>';
                }
                else {
                    $keys = array_keys($element['#options']);
                    for ($i = 0; $i < count($element['#options']); $i++) {
                        $output .= '<div class="'.$element['#type'].'">'
                            .self::prepareLabel($element['#label'], false).'<input type="'.$element['#type'].'" '
                            .((isset($element['#name'])) ? ' name="'.$element['#name'].'"': '')
                            .self::prepareAttributes($element['#attr'])
                            .'value="'.$keys[$i].'"'
                            .((isset($element['#disabled'])) ? ' disabled': '')
                            .((isset($element['#required'])) ? ' required': '')
                            .'>'
                            . '</div>';
                    }
                }
            }
            else {
                $element_value = (isset($element['#default_value'])) ? ' value="'.$element['#default_value'].'"': '';
                $element_value = (isset($element['#value'])) ? ' value="'.$element['#value'].'"': $element_value;
                $output .= self::prepareLabel($element['#label']).'<input type="'.$element['#type'].'" '
                        .((isset($element['#name'])) ? ' name="'.$element['#name'].'"': '')
                        .((isset($element['#size'])) ? ' size="'.$element['#size'].'"': '')
                        .((isset($element['#maxlength'])) ? ' maxlength="'.$element['#maxlength'].'"': '')
                        .((isset($element['#placeholder'])) ? ' placeholder="'.$element['#placeholder'].'"': '')
                        .$element_value
                        .self::prepareAttributes($element['#attr'])
                        .((isset($element['#autocomplete']) && $element['#autcomplete'] == false) ? ' autocomplete="off"': '')
                        .((isset($element['#disabled'])) ? ' disabled': '')
                        .((isset($element['#required'])) ? ' required': '')
                        .'>';
            }
        }
        return $output;
    }
    public static function prepareTextArea($element = array()) {
        $output = '';
        if(count($element)) {
            $element_value = (isset($element['#default_value'])) ? ' value="'.$element['#default_value'].'"': '';
            $element_value = (isset($element['#value'])) ? ' value="'.$element['#value'].'"': $element_value;
            $output .= self::prepareLabel($element['#label']).'<textarea'
                    .((isset($element['#name'])) ? ' name="'.$element['#name'].'"': '')
                    .((isset($element['#cols'])) ? ' cols="'.$element['#cols'].'"': '')
                    .((isset($element['#rows'])) ? ' rows="'.$element['#rows'].'"': '')
                    .((isset($element['#placeholder'])) ? ' placeholder="'.$element['#placeholder'].'"': '')
                    .self::prepareAttributes($element['#attr'])
                    .((isset($element['#resizeable']) && $element['#resizeable'] == true) ? ' resizeable': '')
                    .((isset($element['#disabled'])) ? ' disabled': '')
                    .((isset($element['#required'])) ? ' required': '')
                    .'>'
                    .$element_value
                    .'</textarea>';
        }
        return $output;
    }
    public static function prepareOptions($data = array(), $type) {
        $output = '';
        if(count($element)) {
            foreach($data as $value => $label) {
                $output .= '<option value="'.$value.'">'.$label.'</option>';
            }
        }
        return $output;
    }
    public static function prepareButton($element = array()) {
        $output = '';
        if(count($element)) {
            $output .= '';
        }
        return $output;
    }
    public static function prepareAttributes($attributes = array()) {
        if(count($attributes)) {
            $attr = '';
            foreach($attributes as $attribute => $value) {
                $attr .= $attribute.'="'.$value.'" ';
            }
            return $attr;
        }
    }
    public static function prepareLabel($label = NULL, $field_id = NULL, $close_tag = true) {
        $output = '';
        if($label) {
            $output .= '<label'.(($field) ? 'for="'.$field_id.'"': '').'>'.$label.(($close_tag == true) ? '</label>': '');
        }
        return $output;
    }
    public static function prepareSystemElements($form_id) {
        $output = '';
        if(count($element)) {
            $output .= self::prepareInput(array(
                '#type' => 'hidden',
                '#name' => 'form-token',
                '#value' => Token::generate()
            ));
            $output .= self::prepareInput(array(
                '#type' => 'hidden',
                '#name' => 'form_id',
                '#value' => $form_id
            ));
        }
        return $output;
    }
    public static function prepareActions($actions = array()) {
        $output = '';
        if(count($actions)) {
            $output .= '<div class="form-actions">'.self::prepareSystemElements($actions['submit']['#name']);
            
            $output .= '</div>';
        }
        return $output;
    }
    static function allowedElementTypes() {
        return $types = array(
                            'input' => array(
                                'button',
                                'checkbox',
                                'color',
                                'date',
                                'datetime',
                                'datetime-local',
                                'email',
                                'file',
                                'hidden',
                                'image',
                                'month',
                                'number',
                                'password',
                                'radio',
                                'range',
                                'reset',
                                'search',
                                'tel',
                                'text',
                                'time',
                                'url',
                                'week'
                            ),
                            'textarea' => 'textarea',
                            'button' => array(
                                'submit',
                                'reset',
                                'button'
                            )
                        );
    }
}