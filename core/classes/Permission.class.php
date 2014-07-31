<?php
class Permission {
    //Class containg functions for managing permissions
    static function get_permission($permission) {
        //Function for getting an array of roles.rid that have the supplied permission
        $db = db_connect();
        $query = $db->prepare("SELECT `p_rid` FROM `permissions` WHERE `permission`=:permission");
        $query->bindValue(':permission', $permission, PDO::PARAM_STR);
        try {
            $query->execute();
            $rid = explode(';', $query->fetchColumn());
        }
        catch (Exception $e) {
            addMessage('error', t('There was an error while processing your request'), $e);
        }
        $db = NULL;
        return $rid;
    }
    static function set_permission($info, $module) {
        //Function for setting a new permission on the permissions table. Administrator will have this permission as default
        if(is_array($info)) {
            $db = db_connect();
        
            $db = NULL;
        }
        else {
            addMessage('warning', t('Invalid argument supplied when trying to set permission from the').$module.' '.t('module'));
        }
    }
    static function update_permission($permission, $roles) {
        //Function that updates the roles.rid of a permission
        if(has_permission('access_admin_users_permissions_change', $_SESSION['uid']) === true) {
            $db = db_connect();
            $query = $db->prepare("UPDATE `permissions` SET `p_rid` = :rid WHERE `permission` = :permission");
            $query->bindValue(':rid', $roles, PDO::PARAM_STR);
            $query->bindValue(':permission', $permission, PDO::PARAM_STR);
            try {
                $query->execute();
                return true;
            }
            catch (Exception $e) {
                addMessage('error', '<strong><i>'.$permission.'</i></strong> '.t('permission could not be updated'), $e);
                return false;
            }
            $db = NULL;
        }
        else {
            action_denied();
            return false;
        }
    }
    static function revoke_permission($permission) {
        //Function for revoking a permission and removing it from the permissions table
        $db = db_connect();
        
        $db = NULL;
    }
    static function get_roles() {
        //Function that returns an array of all roles
        $db = db_connect();
        $query = $db->prepare("SELECT * FROM `roles` ORDER BY `position` ASC");
        try {
            $query->execute();
            $roles = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (Exception $e) {
            addMessage('error', t('There was an error while processing your request'), $e);
        }
        $db = NULL;
        return $roles;
    }
    static function get_permissions() {
        //Function that returns an array of all permissions
        $db = db_connect();
        $query = $db->prepare("SELECT * FROM `permissions` ORDER BY `p_mod` ASC");
        try {
            $query->execute();
            $permissions = $query->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (Exception $e) {
            addMessage('error', t('There was an error while processing your request'), $e);
        }
        $db = NULL;
        return $permissions;
    }
    static function generatePermissionList() {
        $csrf = Csrf::addCsrf();
        $roles = self::get_roles();
        $permissions = self::get_permissions();
        $num_roles = count($roles);
        $output = '<form name="editPermissions" method="POST" action="" role="form">';
        $output .= '<input type="hidden" name="form-token" value="'.$csrf->get_token($csrf->get_token_id()).'">'."\n";
        
        $output .= '<table class="table">'
                . '<thead style="background-color: #CCC;">'
                . '<tr>'
                . '<th width="75%"><strong>'.t('Permission').'</strong></th>';
        foreach ($roles as $role) {
            $output .= '<th><strong>'.ucfirst(t($role['name'])).'</strong></th>';
        }
        $output .= '</tr>'
                . '</thead>'
                . '<tbody>';

        foreach ($permissions as $permission) {
            $output .= '<tr>'
                    . '<td>'.$permission['p_name'].'<br/><small style="padding-left: 2em;">'.$permission['p_desc'].'</small></td>'
                    . '<input type="hidden" name="permission[]" value="'.$permission['permission'].'">';
            foreach ($roles as $role) {
                $element = array(
                    '#type' => 'checkbox',
                    '#name' => $permission['permission'].'[]',
                    '#value' => $role['rid'],
                    '#checked' => (in_array($role['rid'], explode(';', $permission['p_rid']))) ? true : false
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
    static function generateRoleList() {
        $csrf = Csrf::addCsrf();
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
                    . '<td>'.ucfirst(t($role['name'])).'</td>'
                    . '<td>'
                        . '<a href="'.site_root().'/admin/users/roles/'.$role['rid'].'/edit" class="btn btn-rad btn-default btn-sm">'.t('Edit role').'</a>'
                        . '<a href="'.site_root().'/admin/users/roles/'.$role['rid'].'/delete" class="btn btn-rad btn-danger btn-sm">'.t('Delete role').'</a>'
                    . '</td>';
        }
        $output .= '<tr><form name"addRole" method="POST" action="" role="form">'."\n";
        $token_id = $csrf->get_token_id();
        $output .= '<input type="hidden" name="form-token" value="'.$csrf->get_token($token_id).'">'."\n"
                . '<td><input type="text" name="inputName" class="form-control form300"></td>'."\n".'<td><button type="submit" class="btn btn-rad btn-default btn-sm">'.t('Add role').'</button></td>'."\n"
                . '</form></tr>'
                . '</tbody>'
                . '</table>';
        return $output;
    }
    static function updatePermissions($formdata) {
        if(has_permission('access_admin_users_permissions_change', $_SESSION['uid']) === true) {
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
            addMessage('success', $count.' '.t('permissions have been updated'));
            if(($items - $count) != 0) {
                addMessage('warning', ($items - $count).' '.t('permissions have not been updated'));
            }
        }
        else {
            action_denied();
        }
    }
    public static function has_permission($permission, $uid) {
        //Verifies if a user has permission to perform an action
        $access = Permissions::get_permission($permission);
        $rid = getFieldFromDB('users', 'user_role', 'uid', $uid);
        return (in_array($rid, $access)) ? true : false;
    }
    public static function action_denied($print = false) {
        if($print === true) {
            return t('You do not have permission to perform this action');
        }
        else {
            addMessage('warning', t('You do not have permission to perform this action'));
        }
    }
}