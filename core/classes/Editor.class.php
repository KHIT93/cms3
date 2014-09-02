<?php
/**
 * @file Handles the code editor UI and functions
 */
class Editor {
    private $_type, $_item, $_file, $_render = array(), $_mode;
    public function __construct($type, $item, $file = NULL) {
        $this->_type = $type;
        $this->_item = $item;
        $this->_file = ($file) ? $file : NULL;
        switch ($type) {
            case 'template':
                $this->_templateEditor();
            break;
            default :
                //Do nothing
            break;
        }
    }
    public function render() {
        //Renders the editor into HTML
        
        //Add form start tag
        $output = '<form name="file-editor" action="" method="POST" role="form">';
        
        //Page-head
        $output .= '<div class="page-aside app codeditor">'
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
                /*. '<ul class="nav nav-pills nav-stacked">'
                . '<li class="active"><a href="#"><i class="fa fa-file"></i> myfile.html</a></li>'
                . '<li><a href="#"><i class="fa fa-file"></i> mystyle.css</a></li>'
                . '<li><a href="#"><i class="fa fa-folder"></i> myfolder</a>'
                . '<ul class="stacked-dropdown dropdown">'
                . '<li><a href="#"><i class="fa fa-file"></i> mySubfile.html</a></li>'
                . '<li><a href="#"><i class="fa fa-file"></i> mySubStyle.css</a></li>'
                . '</ul>'
                . '</li>'
                . '<li><a href="#"><i class="fa fa-file"></i> myscript.js</a></li>'
                . '<li><a href="#"><i class="fa fa-file"></i> myifno.info</a></li>'
                . '</ul>'*/;
        $output .= $this->_menu();
        $output .= '<p class="title">Actions</p>'
                . '<ul class="nav nav-pills nav-stacked ">'
                . '<li><button type="submit" class="btn btn-flat btn-default btn-sidebar">Save File</button></li>'
                . '<li><a href="#">Delete File</a></li>'
                . '</ul>'
                . '</div>'
                . '</div>';
        
        //Code-editor
        $output .= '<div class="container-fluid code-cont" id="pcont">'
                . '<div class="main-app">'
                . '<div class="code-editor">'
                . '<div class="console">'
                . '<textarea name="code-editor" id="code" class="code">'.htmlentities($this->_loadFile()).'</textarea>'
//                . '<textarea name="code-editor" id="code" class="code">'.htmlentities(file_get_contents('core/templates/core/page.tpl.php')).'</textarea>'
                . '</div>'
                . '</div>'
                . '</div>'
                . '</div>';
        
        //End form-tag
        $output .= Render::prepareInput(array(
                '#type' => 'hidden',
                '#name' => 'item',
                '#value' => $this->_item
            ));
        $output .= Render::prepareInput(array(
                '#type' => 'hidden',
                '#name' => 'file',
                '#value' => $this->_file
            ));
        $output .= Render::prepareSystemElements($this->_render['editor']['form_id'])
                . '</form>';
        return $output;
    }
    private function _templateEditor() {
        //Prepare editor renderable array for editing files for a template
        $this->_render['sidebar'] = array(
            'title' => t('Code Editor'),
            'description' => ucfirst($this->_item),
            'actions' => array(),
            'items' => File::getFilesInDir('templates/'.$this->_item, true, Definition::loadRegistry(INCLUDES_PATH.'/registry/excludededitorfiles.registry'))
        );
        $this->_render['editor'] = array(
            'file' => (($this->_file) ? $this->_file : ''),
            'type' => 'unknown',
            'form_id' => 'templateEditor'
        );
        
        
    }
    private function _loadFile() {
        //Loads the specified file into the code editor
        $splitFile = explode('/', $this->_file);
        
        $splitExt = explode('.', $splitFile[(count($splitFile)-1)]);
        $fileExt = (count($splitExt) > 2) ? $splitExt[1].'.'.$splitExt[2] : $splitExt[1];
        $this->_mode = Definition::resolveFileType($fileExt);
        return file_get_contents(constant(strtoupper($this->_type).'_DIR').'/'.$this->_item.'/'.$this->_render['editor']['file']);
    }
    private function _menu() {
        $menu = $this->_prepareMenu($this->_render['sidebar']['items']);
        return stacked_traverse($menu, $this->_file, 'nav nav-pills nav-stacked');
    }
    private function _prepareMenu($items, $parent = NULL, $count = 1) {
        $structure = array();
        $x = 0;
        $y = $count;
        foreach($items as $item) {
            if(isset($item['children'])) {
                $structure[$x]['title'] = '<i class="fa fa-folder"></i>'.$item['name'];
                $structure[$x]['link'] = '#';
                if($y <= 3) {
                    $structure[$x]['children'] = $this->_prepareMenu($item['children'], $item['name'], $y+1);
                }
            }
            else {
                $structure[$x]['title'] = '<i class="fa fa-file"></i>'.$item['name'];
                $structure[$x]['link'] = 'admin/editor&type='.$this->_type.'&item='.$this->_item.'&file='.(($parent) ? $parent.'/' : '').$item['name'];
            }
            $x++;
        }
        return $structure;
    }
    public function mode() {
        return $this->_mode;
    }
}
