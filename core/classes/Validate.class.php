<?php
/**
 * @file
 * Handles validation
 */
class Validate {
    private $_passed = false, $_errors = array(), $_db = null;
    
    public function __construct() {
        $this->_db = DB::getInstance();
    }
    public function check($source, $items = array()) {
        foreach($items as $item => $rules) {
            foreach($rules as $rule => $rule_value) {
                $value = trim($source[$item]);
                if($rule === 'required' && !$value) {
                    $this->addError(t("@item is required", array('@item' => $item)));
                }
                else if($value){
                    switch ($rule) {
                        case 'min':
                            if(strlen($value) < $rule_value) {
                                $this->addError(t('@item must be at least @rule characters long', array('@item' => $item, '@rule' => $rule_value)));
                            }
                        break;
                        case 'max':
                            if(strlen($value) > $rule_value) {
                                $this->addError(t('@item is too long. the maximum allowed is @rule characters', array('@item' => $item, '@rule' => $rule_value)));
                                
                            }
                        break;
                        case 'matches':
                            if($value != $source[$rule_value]) {
                                $this->addError(t('@item does not match @rule', array('@item' => $item, '@rule' => $rule_value)));
                            }
                        break;
                        case 'unique':
                            $check = $this->_db->get($rule_value, array($item, '=', $value));
                            if($check->count()) {
                                $this->addError(t('@item already exists', array('@item' => $item)));
                            }
                        break;
                        default:
                            
                        break;
                    }
                }
            }
        }
        if(!$this->_errors) {
            $this->_passed = true;
        }
        return $this;
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