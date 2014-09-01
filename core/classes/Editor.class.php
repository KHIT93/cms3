<?php
/**
 * @file Handles the code editor UI and functions
 */
class Editor {
    private $_type, $_item, $_file, $_render;
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
        
        $html_data = file_get_contents('core/templates/core/page.tpl.php');
        //Page-head
        $output = '<div class="page-aside app codeditor">'
                . '<div class="content">'
                . '<button class="navbar-toggle" data-target=".app-nav" data-toggle="collapse" type="button">'
                . '<span class="fa fa-chevron-down"></span>'
                . '</button>'
                . '<h2 class="page-title">'.$this->_render['sidebar']['title'].'</h2>'
                . '<p class="description">'.$this->_render['sidebar']['description'].'</p>'
                . '</div>';
        
        //Navigation
        $output .= '<div class="app-nav collapse">'
                . '<p class="title">Files</p>'
                . '<ul class="nav nav-pills nav-stacked">'
                . '<li class="active"><a href="#"><i class="fa fa-file"></i> myfile.html</a></li>'
                . '<li><a href="#"><i class="fa fa-file"></i> mystyle.css</a></li>'
                . '<li><a href="#"><i class="fa fa-file"></i> myscript.js</a></li>'
                . '<li><a href="#"><i class="fa fa-file"></i> myifno.info</a></li>'
                . '</ul>'
                . '<p class="title">Actions</p>'
                . '<ul class="nav nav-pills nav-stacked ">'
                . '<li><a href="#">Open File</a></li>'
                . '<li><a href="#">Save File</a></li>'
                . '<li><a href="#">Save As...</a></li>'
                . '</ul>'
                . '</div>'
                . '<div class="compose">'
                . '<a class="btn btn-flat btn-primary">New File</a>'
                . '</div>'
                . '</div>';
        
        //Code-editor
        $output .= '<div class="container-fluid code-cont" id="pcont">'
                . '<form name="file-editor" action="" method="POST" role="form">'
                
                . '<div class="main-app">'
                . '<div class="code-editor">'
                . '<div class="console">'
                . '<textarea name="code-editor" id="code" class="code">'.htmlentities($html_data).'</textarea>'
                . '</div>'
                . '</div>'
                . '</div>'
                . '</form>'
                . '</div>';
        
        return $output;
    }
    private function templateEditor() {
        //Prepare editor renderable array for editing files for a template
        $this->_render['sidebar'] = array(
            'title' => t('Code Editor'),
            'description' => ucfirst($this->_item),
            'actions' => array(),
            'items' => File::getFilesInDir('templates/'.$this->_item, true)
        );
        $this->_render['editor'] = array();
        
        
    }
    private function loadFile() {
        //Loads the specified file into the code editor
    }
}
