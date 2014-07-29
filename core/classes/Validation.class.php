<?php
class Validation {
    private $_passed = false, $_errors = array(), $_db = null;
    
    public function __construct() {
        $this->_db = DB::getInstance();
    }
    public function check($source, $items = array()) {
        foreach($items as $item => $rules) {
            foreach($rules as $rule => $rule_value) {
                $value = trim($source[$item]);
                if($rule === 'required' && empty($value)) {
                    $this->addError(t("{$item} is required"));
                }
                else if(!empty($value)){
                    switch ($rule) {
                        case 'min':
                            if(strlen($value) < $rule_value) {
                                $this->addError($item.' '.t('must be at least').' '.$rule_value.' '.t('characters long'));
                            }
                        break;
                        case 'max':
                            if(strlen($value) > $rule_value) {
                                $this->addError($item.' '.t('is too long. the maximum allowed is').' '.$rule_value.' '.t('characters'));
                            }
                        break;
                        case 'matches':
                            if($value != $source[$rule_value]) {
                                $this->addError($item.' '.t('does not match').' '.$rule_value);
                            }
                        break;
                        case 'unique':
                            $check = $this->_db->get($rule_value, array($item, '=', $value));
                            if($check->count()) {
                                $this->addError($item.' '.t('already exists.'));
                            }
                        break;
                        default:
                            
                        break;
                    }
                }
            }
        }
        if(empty($this->_errors)) {
            $this->_passed = true;
        }
    }
    private function addError($error) {
        $this->_errors[] = $error;
    }
    public function errors() {
        return $this->_errors;
    }
    public function passed() {
        return $this->_passed;
    }
}