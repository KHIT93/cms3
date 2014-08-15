<?php
/**
 * @file
 * Handles the rendering of the elements passed by renderable arrays
 */
class Render {
    public static function prepareElement($element = array(), $wrapper = true, &$tab_menu = NULL) {
        $allowed = self::allowedElementTypes();
        $output = '';
        if(count($element)) {
            if(isset($element['#children'])) {
                $output .= '<div class="tab-content">';
                foreach($element['#children'] as $child) {
                    $output .= self::prepareTab($child, $tab_menu);
                }
                $output .= '</div>';
            }
            else if($element['#type'] == 'markup') {
                $output .= $element['#value'];
            }
            else {
                $output .= ($wrapper == true || $element['#type'] == 'markup') ? '<div id="form-'.(isset($element['#name']) ? $element['#name'] : 'element').'" class="form-group">': '';
                $output .= ($element['#type'] == 'textarea') ? self::prepareTextArea($element) : self::prepareInput($element);
                $output .= ($wrapper == true || $element['#type'] == 'markup') ? '</div>': '';
            }
        }
        return $output;
    }
    public static function prepareInput($element = array()) {
        $output = '';
        $withOptions = array('checkbox', 'radio', 'select');
        if(count($element)) {
            if(in_array($element['#type'], $withOptions)) {
                if($element['#type'] == 'select') {
                    $output .= ((isset($element['#label'])) ? self::prepareLabel($element['#label']) : '').'<select'
                            .((isset($element['#name'])) ? ' name="'.$element['#name'].'"': '')
                            .((isset($element['#size'])) ? ' size="'.$element['#size'].'"': '')
                            .((isset($element['#disabled']) && $element['#disabled'] == true) ? ' disabled': '')
                            .((isset($element['#required']) && $element['#required'] == true) ? ' required': '')
                            .((isset($element['#multiple']) && $element['#multiple'] == true) ? ' multiple': '')
                            .((isset($element['#attr'])) ? self::prepareAttributes($element['#attr']) : '')
                            .'>';
                    $output .= self::prepareOptions($element['#options']);
                    $output .= '</select>';
                }
                else {
                    $keys = array_keys($element['#options']);
                    for ($i = 0; $i < count($element['#options']); $i++) {
                        $output .= '<div class="'.$element['#type'].'">'
                            .'<label>'
                            . '<input type="'.$element['#type'].'" '
                            .((isset($element['#name'])) ? ' name="'.$element['#name'].'"': '')
                            .((isset($element['#attr'])) ? self::prepareAttributes($element['#attr']) : '')
                            .'value="'.$keys[$i].'"'
                            .((isset($element['#disabled']) && $element['#disabled'] == true) ? ' disabled': '')
                            .((isset($element['#required']) && $element['#required'] == true) ? ' required': '')
                            .'>'
                            .((isset($element['#label'])) ? self::prepareLabel($element['#label'], NULL, false, true) : '')
                            . '</div>';
                    }
                }
            }
            else {
                $element_value = (isset($element['#default_value'])) ? ' value="'.$element['#default_value'].'"': '';
                $element_value = (isset($element['#value'])) ? ' value="'.$element['#value'].'"': $element_value;
                $output .= ((isset($element['#label'])) ? self::prepareLabel($element['#label']) : '').'<input type="'.$element['#type'].'" '
                        .((isset($element['#name'])) ? ' name="'.$element['#name'].'"': '')
                        .((isset($element['#size'])) ? ' size="'.$element['#size'].'"': '')
                        .((isset($element['#maxlength'])) ? ' maxlength="'.$element['#maxlength'].'"': '')
                        .((isset($element['#placeholder'])) ? ' placeholder="'.$element['#placeholder'].'"': '')
                        .$element_value
                        .((isset($element['#attr'])) ? self::prepareAttributes($element['#attr']) : '')
                        .((isset($element['#autocomplete']) && $element['#autocomplete'] == false) ? ' autocomplete="off"': '')
                        .((isset($element['#disabled']) && $element['#disabled'] == true) ? ' disabled': '')
                        .((isset($element['#required']) && $element['#required'] == true) ? ' required': '')
                        .'>';
            }
        }
        return $output;
    }
    public static function prepareTextArea($element = array()) {
        $output = '';
        if(count($element)) {
            $element_value = (isset($element['#default_value'])) ? $element['#default_value'] : '';
            $element_value = (isset($element['#value'])) ? $element['#value'] : $element_value;
            $output .= ((isset($element['#label'])) ? self::prepareLabel($element['#label']) : '').'<textarea'
                    .((isset($element['#name'])) ? ' name="'.$element['#name'].'"': '')
                    .((isset($element['#cols'])) ? ' cols="'.$element['#cols'].'"': '')
                    .((isset($element['#rows'])) ? ' rows="'.$element['#rows'].'"': '')
                    .((isset($element['#placeholder'])) ? ' placeholder="'.$element['#placeholder'].'"': '')
                    .((isset($element['#attr'])) ? self::prepareAttributes($element['#attr']) : '')
                    .((isset($element['#resizeable']) && $element['#resizeable'] == true) ? ' resizeable': '')
                    .((isset($element['#disabled']) && $element['#disabled'] == true) ? ' disabled': '')
                    .((isset($element['#required']) && $element['#required'] == true) ? ' required': '')
                    .'>'
                    .$element_value
                    .'</textarea>';
        }
        return $output;
    }
    public static function prepareOptions($data = array()) {
        $output = '';
        if(count($data)) {
            foreach($data as $value => $label) {
                $output .= '<option value="'.$value.'">'.$label.'</option>';
            }
        }
        return $output;
    }
    public static function prepareButton($element = array()) {
        $output = '';
        if(count($element)) {
            $output .= '<button type="'.$element['#type'].'"'.((isset($element['#attr'])) ? ' '.self::prepareAttributes($element['#attr']) : '').'>'.$element['#value'].'</button>';
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
    public static function prepareLabel($label = NULL, $field_id = NULL, $open_tag = true, $close_tag = true) {
        $output = '';
        if($label) {
            if($open_tag == false) {
                $output .= $label.(($close_tag == true) ? '</label>': '');
            }
            else if ($close_tag == false && $open_tag == false) {
                $output .= $label;
            }
            else {
                $output .= '<label'.(($field_id) ? ' for="'.$field_id.'"': '').'>'.$label.(($close_tag == true) ? '</label>': '');
            }
        }
        return $output;
    }
    public static function prepareSystemElements($form_id) {
        $output = '';
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
        return $output;
    }
    public static function prepareActions($actions = array()) {
        $output = '';
        if(count($actions)) {
            foreach($actions as $action) {
                $output .= '<div class="form-actions">'.self::prepareSystemElements($action['#name']);
                $output .= self::prepareButton($action);
                $output .= '</div>';
            }
        }
        return $output;
    }
    public static function prepareTab($tab = array(), &$tab_control) {
        $output = '';
        if(count($tab)) {
            $tab['#attr']['id'] = (isset($tab['#attr']['id'])) ? $tab['#attr']['id'].' '.$tab['#name'] : $tab['#name'];
            $tab_control .= '<li><a href="#'.$tab['#name'].' data-toggle="tab">'.((isset($tab['#title'])) ? $tab['#title'] : $tab['#name']).'</a></li>';
            foreach($tab['#children'] as $child) {
                $output .= ''.self::prepareElement($child).'';
            }
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