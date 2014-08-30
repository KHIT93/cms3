<?php
/**
 * @file Handles the code editor UI and functions
 */
class Editor {
    private $_type, $_item, $_file;
    public function __construct($type, $item, $file = NULL) {
        $this->_type = $type;
        $this->_item = $item;
        $this->_file = $file;
        switch ($type) {
            case 'template':
                $this->templateEditor();
            break;
            default :
                //Do nothing
            break;
        }
    }
    public function render() {
        //Renders the editor into HTML
    }
    private function templateEditor() {
        //Prepare editor renderable array for editing files for a template
        $sidebar = array(
            'title' => t('Code Editor'),
            'file' => ((hasValue($this->_file)) ? $this->_file : ''),
            'actions' => array(),
            'items' => File::getFilesInDir('templates/'.$this->_item, true)
        );
        $code_editor = array();
        
        
    }
    private function loadFile() {
        //Loads the specified file into the code editor
    }
}
