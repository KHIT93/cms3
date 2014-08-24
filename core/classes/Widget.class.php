<?php
class Widget {
    static function getAllWidgets() {
        $db = DB::getInstance();
        if(!$db->query("SELECT * FROM `widgets` ORDER BY `position` ASC")->error()) {
            return $db->results();
        }
        else {
            //Add error message
            
        }
        return false;
    }
    static function getWidgets($section) {
        $db = DB::getInstance();
        
        if(!$db->get('widgets', array('section', '=', $section))->error()) {
            return $db->results();
        }
        else {
            //Add error message
            
        }
        return false;
    }
    static function getWidget($wid) {
        $db = DB::getInstance();
        if(!$db->get('widgets', array('wid', '=', $wid))->error()) {
            return $db->first();
        }
        else {
            //Add error message
            
        }
        return false;
    }
    static function getSections($theme) {
        $output = array();
        if($theme == 'core') {
            $output = Theme::themeDetails($theme, true)['sections'];
        }
        else {
            //get sections from custom theme
            $themedetails = Theme::themeDetails($theme);
            if(!isset($themedetails['sections']) || empty($themedetails['sections']) || $themedetails['sections'] == '') {
                //Use default sections
                $output = Theme::themeDetails('core', true)['sections'];
            }
            else {
                //Use sections from custom theme
                $output = $themedetails['sections'];
            }
        }
        return $output;
    }
    static function renderWidgetList($section, $theme, &$all_widgets) {
        $output = '';
        $items = self::getAllWidgets();
        
        $count = DB::getInstance()->countItems('widgets', '*', 'section', $section);
        if($count > 0) {
            for ($i = 0; $i < count($items) + 1; $i++) {
                if($items[$i]->section == $section) {
                    $output .= '<tr>'
                                . '<td style="padding-left: 2em;">'.$items[$i]->title.'</td>'
                                . '<td class="hidden-xs">'/*.Form::renderAsFormElement(self::getSections($theme), 'select', 'widget_'.$items[$i]['widget_id'], $items[$i]['widget_section'])*/.'</td>';
                    $output .= ($items[$i]->type == 'dynamic') ? '<td class="hidden-xs">'.((has_permission('access_admin_layout_widgets_edit', Session::exists(Config::get('session/session_name'))) === true) ? '<a href="/admin/layout/widgets/'.$items[$i]->wid.'/edit" class="btn btn-rad btn-sm btn-default">'.t('Edit').'</a>' : '').'</td>'
                            : '<td class="hidden-xs">'
                            . ((has_permission('access_admin_layout_widgets_edit', Session::exists(Config::get('session/session_name'))) === true) ? '<a href="/admin/layout/widgets/'.$items[$i]->wid.'/edit" class="btn btn-rad btn-sm btn-default">'.t('Edit').'</a>' : '')
                            . ((has_permission('access_admin_layout_widgets_delete', Session::exists(Config::get('session/session_name'))) === true) ? '<a href="/admin/layout/widgets/'.$items[$i]->wid.'/delete" class="btn btn-rad btn-sm btn-danger">'.t('Delete').'</a>' : '')
                            . '</td>';
                    $output .= '</tr>';
                    
                    unset($all_widgets[$i]);
                }
            }
        }
        else {
            $output .= '<tr>'
                    . '<td style="padding-left: 2em;"><i>'.t('There are no widgets in this section').'</i></td>'
                    . '<td class="hidden-xs"></td><td class="hidden-xs"></td></tr>';
        }
        return $output;
    }
    static function renderSection($section) {
        //Returns HTML-output for all widgets in a specific section
        $modules = Modules::activeModules();
        $widgets = self::getWidgets($section);
        $output = '';
        
        foreach ($widgets as $widget) {
            $output .= '';
        }
        
        $db = NULL;
        return $output;
    }
    static function createWidgetForm() {
        $output = '<div class="page-head">'
                    .'<h2>'.t('Widgets').'</h2>'
                    .get_breadcrumb()
                .'</div>'
                . '<div class="cl-mcont">'
                    . print_messages()
                .'<div class="col-md-12">
            <form method="POST" name="addWidget" action="" role="form">
            <script src="'.site_root().'/core/js/ckeditor/ckeditor.js"></script>
            <div id="widgetTitle" class="form-group form300">
                <label for="inputTitle">'.t('Title').'</label>
                <input type="text" class="form-control" name="inputTitle">
            </div>
            <div id="widgetContent" class="form-group">
                <label for="inputContent">'.t('Content').'</label>
                <textarea name="inputContent"></textarea>
            </div>
            <div id="widgetSection" class="form-group form300">
                <p>'.t('Choose a section for this widget').'</p>'
                .Form::renderAsFormElement(self::getSections(Theme::getTheme()), 'select', 'inputSection').
            '</div>
            <ul id="content-tab" class="nav nav-tabs">
                <li class="active"><a href="#widgetPages" data-toggle="tab">'.t('Pages').'</a></li>
                <li><a href="#widgetRoles" data-toggle="tab">'.t('Roles').'</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane fade in active" id="widgetPages">
                    <p><strong>'.t('Show widget on specific pages').'</strong></p>
                    <div class="form-group">
                        <div class="radio">
                            <label>
                                <input type="radio" name="inputShow" value="0" checked>'
                                .t('All pages except the ones listed')
                            .'</label>
                        </div>
                        <div class="radio">
                            <label>
                                <input type="radio" name="inputShow" value="1">'
                                .t('Only the listed pages')
                           .'</label>
                        </div>
                        <div id="widgetContent" class="form-group">
                            <textarea name="inputPages" class="form-control" cols="60" rows="5"></textarea>
                        </div>
                    </div>
                </div>';
        $output .= '<div class="tab-pane fade" id="widgetRoles">';
        $output .= '<p>'.t('This widget will only be shown to the following roles. If no roles are selected it will be shown to all roles').'</p>';
        $roles = Permission::get_roles();
        foreach ($roles as $role) {
            $output .= '<label for="inputRoles"><input type="checkbox" name="roles[]" value="'.$role->rid.'"> '.ucfirst($role->name).'</label><br/>'."\n";
        }
        $output .= '</div>'
            .'</div>'
            ."<script>"
            ."CKEDITOR.replace( 'inputContent', {"
                    ."language: 'da'"
                ."});"
            ."</script>"
        .'<div class="form-actions">'
            .'<input type="hidden" name="form-token" value="'.Token::generate().'">'
            .'<button type="submit" name="addWidget" class="btn btn-rad btn-sm btn-primary"><span class="glyphicon glyphicon-floppy-saved"></span> '.t('Save widget').'</button>'
            .'<a class="btn btn-rad btn-sm btn-default" href="/admin/layout/widgets">'.t('Cancel').'</a>'
        .'</div>'
        .'</form>'
        .'</div>';
        return $output;
    }
    static function createWidget($formdata, $type = 'static') {
        //Function for creating a new widget
        $db = DB::getInstance();
        $data = array(
            'type' => $type,
            'title' => $formdata['inputTitle'],
            'content', $formdata['inputContent'],
            'section' => $formdata['inputSection'],
            'show' => $formdata['inputShow'],
            'pages' => $formdata['inputPages'],
            'rid' => implode(',', $formdata['roles'])
        );
        if(!$db->insert('widgets', $data)->error()) {
            return true;
        }
        else {
            //Add error message
        }
        return false;
    }
    static function updateWidgetForm($wid) {
        $widget = self::getWidget($wid);
        if($widget->type == 'static') {
            $output = '<div class="page-head">'
                        .'<h2>'.t('Edit').' <i>'.$widget->title.'</i></h2>'
                        .get_breadcrumb()
                    .'</div>'
                    . '<div class="cl-mcont">'
                    . print_messages()
                    .'<div class="col-md-12">
                <form method="POST" name="editWidget" action="" role="form">
                <script src="/core/js/ckeditor/ckeditor.js"></script>
                <div id="widgetTitle" class="form-group form300">
                    <label for="inputTitle">'.t('Title').'</label>
                    <input type="text" class="form-control" name="inputTitle" value="'.$widget->title.'">
                </div>
                <div id="widgetContent" class="form-group">
                    <label for="inputContent">'.t('Content').'</label>
                    <textarea name="inputContent">'.$widget->content.'</textarea>
                </div>
                <div id="widgetSection" class="form-group form300">
                    <p>'.t('Choose a section for this widget').'</p>'
                    .Form::renderAsFormElement(self::getSections(getTheme()), 'select', 'inputSection', DB::getInstance()->getField('widgets', 'widget_section', 'widget_id', $wid))
                    .'<p>'.t('Leave this field unchanged in order to keep current settings').'</p>'
                .'</div>
                <ul id="content-tab" class="nav nav-tabs">
                    <li class="active"><a href="#widgetPages" data-toggle="tab">'.t('Pages').'</a></li>
                    <li><a href="#widgetRoles" data-toggle="tab">'.t('Roles').'</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade in active" id="widgetPages">
                        <p><strong>'.t('Show widget on specific pages').'</strong></p>
                        <div class="form-group">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="inputShow" value="0" '.(($widget->show == 0) ? 'checked' :'' ).'>'
                                    .t('All pages except the ones listed')
                                .'</label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="inputShow" value="1" '.(($widget->show == 1) ? 'checked' :'' ).'>'
                                    .t('Only the listed pages')
                               .'</label>
                            </div>
                            <div id="widgetPages" class="form-group">
                                <textarea name="inputPages" class="form-control" cols="60" rows="5">'.((!is_null($widget->pages)) ?str_replace(';', "\n", $widget->pages) : '').'</textarea>
                            </div>
                        </div>
                    </div>';
            $output .= '<div class="tab-pane fade" id="widgetRoles">';
            $output .= '<p>'.t('This widget will only be shown to the following roles. If no roles are selected it will be shown to all roles').'</p>';
            $roles = Permissions::get_roles();
            foreach ($roles as $role) {
                $output .= '<label for="inputRoles"><input type="checkbox" name="roles[]" value="'.$role->rid.'" '.((in_array($role->rid, explode(';', $widget->roles))) ? 'checked' :'' ).'> '.ucfirst($role->name).'</label><br/>'."\n";
            }
            $output .= '</div>'
                .'</div>'
                ."<script>"
                ."CKEDITOR.replace( 'inputContent', {"
                        ."language: 'da'"
                    ."});"
                ."</script>"
            .'<div class="form-actions">'
                .'<input type="hidden" name="form-token" value="'.Token::generate().'">'
                .'<input type="hidden" name="form_id" value="editWidget">'
                .'<input type="hidden" name="inputWid" value="'.$widget->wid.'">'
                .'<input type="hidden" name="inputType" value="'.$widget->type.'">'
                .'<button type="submit" name="editWidget" class="btn btn-rad btn-sm btn-primary"><span class="glyphicon glyphicon-floppy-saved"></span> '.t('Save widget').'</button>'
                .'<a class="btn btn-rad btn-sm btn-default" href="/admin/layout/widgets">'.t('Cancel').'</a>'
            .'</div>'
            .'</form>'
            .'</div>';
        }
        else if($widget->type == 'dynamic') {
            $output = '<div class="page-head">'
                        .'<h2>'.t('Edit').' <i>'.$widget->title.'</i></h2>'
                        .get_breadcrumb()
                    .'</div>'
                    . '<div class="cl-mcont">'
                    . print_messages()
                    .'<div class="col-md-12">
                <form method="POST" name="editWidget" action="" role="form">
                <script src="/core/js/ckeditor/ckeditor.js"></script>
                <div id="widgetTitle" class="form-group form300">
                    <label for="inputTitle">'.t('Title').'</label>
                    <input type="text" class="form-control" name="inputTitle" value="'.$widget->title.'">
                </div>
                <div id="widgetSection" class="form-group form300">
                    <p>'.t('Choose a section for this widget').'</p>'
                    .Form::renderAsFormElement(self::getSections(getTheme()), 'select', 'inputSection', DB::getInstance()->getField('widgets', 'widget_section', 'widget_id', $wid))
                    .'<p>'.t('Leave this field unchanged in order to keep current settings').'</p>'
                .'</div>
                <ul id="content-tab" class="nav nav-tabs">
                    <li class="active"><a href="#widgetPages" data-toggle="tab">'.t('Pages').'</a></li>
                    <li><a href="#widgetRoles" data-toggle="tab">'.t('Roles').'</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade in active" id="widgetPages">
                        <p><strong>'.t('Show widget on specific pages').'</strong></p>
                        <div class="form-group">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="inputShow" value="0" '.(($widget->show == 0) ? 'checked' :'' ).'>'
                                    .t('All pages except the ones listed')
                                .'</label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="inputShow" value="1" '.(($widget->show == 1) ? 'checked' :'' ).'>'
                                    .t('Only the listed pages')
                               .'</label>
                            </div>
                            <div id="widgetPages" class="form-group">
                                <textarea name="inputPages" class="form-control" cols="60" rows="5">'.((!is_null($widget->pages)) ?str_replace(';', "\n", $widget->pages) : '').'</textarea>
                            </div>
                        </div>
                    </div>';
            $output .= '<div class="tab-pane fade" id="widgetRoles">';
            $output .= '<p>'.t('This widget will only be shown to the following roles. If no roles are selected it will be shown to all roles').'</p>';
            $roles = Permissions::get_roles();
            foreach ($roles as $role) {
                $output .= '<label for="inputRoles"><input type="checkbox" name="roles[]" value="'.$role->rid.'" '.((in_array($role->rid, explode(';', $widget->roles))) ? 'checked' :'' ).'> '.ucfirst($role['name']).'</label><br/>'."\n";
            }
            $output .= '</div>'
                .'</div>'
            .'<div class="form-actions">'
                .'<input type="hidden" name="form-token" value="'.Token::generate().'">'
                .'<input type="hidden" name="form_id" value="editWidget">'
                .'<input type="hidden" name="inputWid" value="'.$widget->wid.'">'
                .'<input type="hidden" name="inputType" value="'.$widget->type.'">'
                .'<input type="hidden" name="inputContent" value="'.$widget->content.'">'
                .'<button type="submit" name="editWidget" class="btn btn-rad btn-sm btn-primary"><span class="glyphicon glyphicon-floppy-saved"></span> '.t('Save widget').'</button>'
                .'<a class="btn btn-rad btn-sm btn-default" href="/admin/layout/widgets">'.t('Cancel').'</a>'
            .'</div>'
            .'</form>'
            .'</div>';
        }
        else {
            $output = t('Invalid widget type');
        }
        return $output;
    }
    static function updateWidget($formdata) {
        //Function for updating a widget
        $db = DB::getInstance();
        $data = array(
            'title' => $formdata['inputTitle'],
            'content', $formdata['inputContent'],
            'section' => $formdata['inputSection'],
            'show' => $formdata['inputShow'],
            'pages' => $formdata['inputPages'],
            'rid' => implode(',', $formdata['roles'])
        );
        if(!$db->update('widgets', array('wid', $formdata['inputWid']), $data)->error()) {
            return true;
        }
        else {
            //Add error message
        }
        return false;
    }
    static function deleteWidget($wid) {
        //Function to delete a widget
        $db = DB::getInstance();
        if(!$db->delete('widgets', array('wid', '=', $wid))->error()) {
            return true;
        }
        else {
            //Add error message
        }
        return false;
    }
    static function moveWidget($wid, $section) {
        //Function for changing the placement of a widget
        $db = DB::getInstance();
        if(!$db->update('widgets', $wid, array('position' => $section))) {
            return true;
        }
        else {
            //Add error message
        }
        return false;
    }
}