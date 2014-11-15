<?php
/**
 * @file Class used to generate objects of single fields
 */
class Field {
    private $_fid, $_name, $_type, $_values, $_placeholder;
    public function __construct($field) {
        $db = DB::getInstance();
        //Initialize fields from DB
        $data = $db->get('fields', array('fid', '=', $field))->first();
        $values = $db->get('field_values', array('fid', '=', $field))->first();
        $this->_fid = $field;
        $this->_name = $data['name'];
        $this->_type = $data['type'];
        $this->_tmp_values = json_decode($values['value'], true);
        $this->_placeholder = $values['placeholder'];
        //Check if the field values is function and execute it
        if(isset($this->_tmp_values['phpfunc'])) {
            if(function_exists($this->_values['phpfunc'])) {
                $this->_values = $this->_tmp_values['phpfunc']();
            }
            else {
                $this->_values = $this->_tmp_values;
            }
        }
        else {
            $this->_values = $this->_tmp_values;
        }
    }
    public function fid() {
        return $this->_fid;
    }
    public function name() {
        return $this->_name;
    }
    public function type() {
        return $this->_type;
    }
    public function values() {
        return $this->_values;
    }
    public function placeholder() {
        return $this->_placeholder;
    }
    public static function create($field_id, $field_name, $field_type, $field_values = array(), $field_placeholder = NULL) {
        $db = DB::getInstance();
        $fields = array(
            'fid' => $field_id,
            'name' => $field_name,
            'type' => $field_type,
        );
        $field_values = array(
            'fid' => $field_id,
            'value' => ((count($field_values)) ? json_encode($field_values) : NULL),
            'placeholder' => (($field_placeholder) ? $field_placeholder : NULL)
        );
        if($db->get('fields', array('fid', '=', $field_id))->count() == 0) {
            if($db->insert('fields', $fields)) {
                if($db->insert('field_values', $field_values)) {
                    System::addMessage('success', t('The new field <i>@field</i> has been created', array('@field' => $field_id)));
                }
                else {
                    System::addMessage('error', t('The properties for the field <i>@field</i> could not be created', array('@field' => $field_id)));
                }
            }
            else {
                System::addMessage('error', t('The data for the field <i>@field</i> could not be created', array('@field' => $field_id)));
            }
        }
        else {
            System::addMessage('error', t('The field <i>@field</i> does already exist', array('@fields' => $field_id)));
        }
    }
}
