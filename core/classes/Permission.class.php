<?php
class Permission {
    //Class containg functions for managing permissions
    public static function get_permission($permission) {
        $rid = DB::getInstance()->getField('permissions', 'rid', 'permission', $permission);
        return explode(';', $rid);
    }
    public static function set_permission($info, $module) {
        //Function for setting a new permission in the permissions table. Administrator will have this permission as default
        if(is_array($info)) {
            $db = DB::getInstance();
        
            $db = NULL;
        }
        else {
            addMessage('warning', t('Invalid argument supplied when trying to set permission from the').$module.' '.t('module'));
        }
    }
    public static function update_permission($permission, $roles) {
        //Function that updates the roles.rid of a permission
        if(has_permission('access_admin_users_permissions_change', Session::exists(Config::get('session/session_name'))) === true) {
            $db = DB::getInstance();
            if($db->update('permissions', $permission, array('rid' => $roles))) {
                System::addMessage('error', t('Permission could not be updated'));
                return true;
            }
        }
        else {
            action_denied();
            return false;
        }
    }
    public static function revoke_permission($permission) {
        //Function for revoking a permission and removing it from the permissions table
        $db = DB::getInstance();
        
        $db = NULL;
    }
    public static function get_roles() {
        $db = DB::getInstance();
        if(!$db->query("SELECT * FROM `roles` ORDER BY `position` ASC")->error()) {
            return $db->results();
        }
        return false;
    }
    public static function add_role($formdata) {
        $db = DB::getInstance();
        $fields = array(
            'name' => $formdata['name'],
            'position' => $db->query("SHOW TABLE STATUS LIKE 'roles'")->first()
        );
        if($db->insert('roles', $fields)) {
            addMessage('success', t('The new role <i>@role</i> has been created', array('@role' => $formdata['name'])));
        }
        else {
            addMessage('success', t('The new role <i>@role</i> could not be created', array('@role' => $formdata['name'])));
        }
    }
    public static function get_permissions() {
        $db = DB::getInstance();
        if(!$db->query("SELECT * FROM `permissions` ORDER BY `module` ASC")->error()) {
            return $db->results();
        }
        return false;
    }
    public static function generatePermissionList() {
        $roles = self::get_roles();
        $permissions = self::get_permissions();
        $num_roles = count($roles);
        $output = '<form name="editPermissions" method="POST" action="" role="form">';
        $output .= '<input type="hidden" name="form-token" value="'.Token::generate().'">'."\n";
        $output .= '<input type="hidden" name="form_id" value="editPermissions">'."\n";
        
        $output .= '<table class="table">'
                . '<thead style="background-color: #CCC;">'
                . '<tr>'
                . '<th width="75%"><strong>'.t('Permission').'</strong></th>';
        foreach ($roles as $role) {
            $output .= '<th><strong>'.ucfirst(t($role->name)).'</strong></th>';
        }
        $output .= '</tr>'
                . '</thead>'
                . '<tbody>';

        foreach ($permissions as $permission) {
            $output .= '<tr>'
                    . '<td>'.$permission->name.'<br/><small style="padding-left: 2em;">'.$permission->description.'</small></td>'
                    . '<input type="hidden" name="permission[]" value="'.$permission->permission.'">';
            foreach ($roles as $role) {
                $element = array(
                    '#type' => 'checkbox',
                    '#name' => $permission->permission.'[]',
                    '#value' => $role->rid,
                    '#checked' => (in_array($role->rid, explode(';', $permission->rid))) ? true : false
                );
                $output .= '<td style="text-align: center;"><input type="'.$element['#type'].'" class="icheck" name="'.$element['#name'].'" value="'.$element['#value'].'"'.(($element['#checked'] === true) ? ' checked' : '').'/></td>';
            }
            $output .= '</tr>';
        }

        $output .= '</tbody>'
                . '</table><br/>';
        $output .= '<button type="submit" name="editPermissions" class="btn btn-rad btn-primary">'.t('Save changes').'</button>';
        $output .= '</form>';
        return $output;
    }
    public static function generateRoleList() {
        $roles = self::get_roles();
        $output = '<table class="table">'
                . '<thead style="background-color: #CCC;">'
                . '<tr>'
                . '<th><strong>'.t('Name').'</strong></th>'
                . '<th><strong>'.t('Actions').'</strong></th>'
                . '</tr>'
                . '</thead>'
                . '<tbody class="no-border-y">';
        foreach ($roles as $role) {
            $output .= '<tr>'
                    . '<td>'.ucfirst(t($role->name)).'</td>'
                    . '<td>'
                        . '<a href="/admin/users/roles/'.$role->rid.'/edit" class="btn btn-rad btn-default btn-sm">'.t('Edit role').'</a>'
                        . '<a href="/admin/users/roles/'.$role->rid.'/delete" class="btn btn-rad btn-danger btn-sm">'.t('Delete role').'</a>'
                    . '</td>';
        }
        $output .= '<tr><form name"addRole" method="POST" action="" role="form">'."\n";
        $output .= '<input type="hidden" name="form-token" value="'.Token::generate().'">'."\n"
                . '<input type="hidden" name="form_id" value="addRole">'."\n"
                . '<td><input type="text" name="inputName" class="form-control form300"></td>'."\n".'<td><button type="submit" class="btn btn-rad btn-default btn-sm">'.t('Add role').'</button></td>'."\n"
                . '</form></tr>'
                . '</tbody>'
                . '</table>';
        return $output;
    }
    public static function updatePermissions($formdata) {
        if(has_permission('access_admin_users_permissions_change', Session::exists(Config::get('session/session_name'))) === true) {
            unset($formdata['editPermissions']);
            unset($formdata['permission']);
            unset($formdata['form-token']);
            $items = count($formdata);
            $count = 0;
            foreach ($formdata as $permission => $rid) {
                if(self::update_permission($permission, implode(';', $rid)) === true) {
                    $count++;
                }
            }
            addMessage('success', t('@count permissions have been updated', array('@count' => $count)));
            if(($items - $count) != 0) {
                addMessage('warning', t('@count permissions have not been updated', array('@count' >= ($items - $count))));
            }
        }
        else {
            action_denied();
        }
    }
    public static function has_permission($permission, $uid) {
        //Verifies if a user has permission to perform an action
        $access = self::get_permission($permission);
        $rid = DB::getInstance()->getField('users', 'role', 'uid', $uid);
        return (in_array($rid, $access)) ? true : false;
    }
    public static function denied($print = false) {
        if($print === true) {
            return t('You do not have permission to perform this action');
        }
        else {
            addMessage('warning', t('You do not have permission to perform this action'));
        }
    }
}