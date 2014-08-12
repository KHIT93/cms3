<div class="page-head">
    <h2><?php print t('Users'); ?></h2>
    <?php print get_breadcrumb(); ?>
</div>
<div class="cl-mcont">
    <?php print print_messages(); ?>
<div class="col-md-12 table-responsive">
    <div class="tab-container">
        <ul id="advslider-tab" class="nav nav-tabs">
            <li class="nav-tabs-right"><a href="#permissions" data-toggle="tab"><?php print t('Permissions'); ?></a></li>
            <li class="nav-tabs-right"><a href="#roles" data-toggle="tab"><?php print t('Roles'); ?></a></li>
            <li class="active nav-tabs-right"><a href="#users" data-toggle="tab"><?php print t('Users'); ?></a></li>
        </ul>
        <div class="tab-content">
        <div class="tab-pane fade in active" id="users">
            <table class="table table-hover">
                <thead style="background-color: #CCC;">
                    <tr>
                        <th><strong><?php print t('Name'); ?></strong></th>
                        <th class="hidden-xs" ><strong><?php print t('Username'); ?></strong></th>
                        <th class="hidden-xs" ><strong><?php print t('Email'); ?></strong></th>
                        <th><strong><?php print t('User Group'); ?></strong></th>
                        <th class="hidden-xs" style="text-align: center;"><strong><?php print t('Actions'); ?></strong></th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $users = User::getUserList();
                    if(!empty($users)) {
                        foreach($users as $user) {
                            if($user->uid() == 1) {
                                print '<tr>
                                        <td>'.$user->name().'</td><td class="hidden-xs" >'.$user->username().'</td><td class="hidden-xs" >'.$user->email().'</td>'
                                        .'<td>'.ucfirst(t(DB::getInstance()->getField('roles', 'name', 'rid', $user->role()))).'</td>'
                                        .'<td class="hidden-xs" style="text-align: right;">
                                            <a href="/admin/users/'.$user->uid().'/edit" class="btn btn-rad btn-sm btn-default"><span class="glyphicon glyphicon-edit"></span> '.t('Edit User').'</a>
                                            <a href="/admin/users/'.$user->uid().'/delete" class="btn btn-rad btn-sm btn-danger disabled"><span class="glyphicon glyphicon-floppy-remove"></span> '.t('Delete User').'</a>
                                            <a href="/admin/users/'.$user->uid().'/disable" class="btn btn-rad btn-sm btn-warning disabled">'.t('Disable User').'</a>
                                        </td>
                                    </tr>';
                            }
                            else {
                                if($user->active() == 1) {
                                    print '<tr>
                                            <td>'.$user->name().'</td><td class="hidden-xs" >'.$user->username().'</td><td class="hidden-xs" >'.$user->email().'</td>'
                                            .'<td>'.ucfirst(t(DB::getInstance()->getField('roles', 'name', 'rid', $user->role()))).'</td>'
                                            .'<td class="hidden-xs" style="text-align: right;">
                                                <a href="/admin/users/'.$user->uid().'/edit" class="btn btn-rad btn-sm btn-default"><span class="glyphicon glyphicon-edit"></span> '.t('Edit User').'</a>
                                                <a href="/admin/users/'.$user->uid().'/delete" class="btn btn-rad btn-sm btn-danger"><span class="glyphicon glyphicon-floppy-remove"></span> '.t('Delete User').'</a>
                                                <a href="/admin/users/'.$user->uid().'/disable" class="btn btn-rad btn-sm btn-warning">'.t('Disable User').'</a>
                                            </td>
                                        </tr>';
                                }
                                else {
                                    print '<tr>
                                            <td>'.$user->name().'</td><td class="hidden-xs" >'.$user->username().'</td><td class="hidden-xs" >'.$user->email().'</td>'
                                            .'<td>'.ucfirst(t(DB::getInstance()->getField('roles', 'name', 'rid', $user->role()))).'</td>'
                                            .'<td class="hidden-xs" style="text-align: right;">
                                                <a href="/admin/users/'.$user->uid().'/enable" class="btn btn-rad btn-sm btn-info"><i class="fa fa-unlock"></i> '.t('Enable User').'</a>
                                            </td>
                                        </tr>';
                                }

                            }
                        }
                    }
                    else {
                        print '<tr><td>'.t('No users have been created').'</td><td></td><td></td><td></td><td></td></tr>';
                    }
                ?>


                    <tr>
                        <td></td>
                        <td class="hidden-xs" ></td>
                        <td class="hidden-xs" ></td>
                        <td></td>
                        <td class="hidden-xs" style="text-align: right;">
                            <a data-toggle="modal" href="#createUser" class="btn btn-rad btn-sm btn-primary"><span class="glyphicon glyphicon-user"></span> <?php print t('Create new user'); ?></a>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="modal fade" id="createUser">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title"><?php print t('Create new useraccount'); ?></h4>
                        </div>
                        <form method="POST" name="addUser" action="" role="form">
                            <div class="modal-body row">
                                <div class="form-group col-md-8">
                                    <label for="inputName"><?php print t('Name'); ?></label>
                                    <input type="text" class="form-control" name="name" placeholder="Name">
                                </div>
                                <div class="form-group col-md-8">
                                    <label for="inputUsername"><?php print t('Username'); ?></label>
                                    <input type="text" name="username" class="form-control" placeholder="Username">
                                </div>
                                <div class="form-group col-md-8">
                                    <label for="inputEmail"><?php print t('Email address'); ?></label>
                                    <input type="email" name="email" class="form-control" placeholder="Email Address">
                                </div>
                                <div class="form-group col-md-8">
                                    <label for="inputPassword"><?php print t('Password'); ?></label>
                                    <input type="password" name="password" class="form-control" placeholder="Password">
                                </div>
                                <div class="form-group col-md-8">
                                    <?php
                                    foreach (Permission::get_roles() as $role) {
                                        print '<div class="radio">'
                                                . '<label>'
                                                    . '<input type="radio" name="user_group" id="optionsUsergroup'.$role->rid.'" value="'.$role->rid.'">'
                                                    . ' '.ucfirst(t($role->name))
                                                . '</label>'
                                            . '</div>';
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" name="form-token" value="<?php print Token::generate(); ?>">
                                <input type="hidden" name="form_id" value="addUser">
                                <button type="button" class="btn btn-rad btn-default" data-dismiss="modal"><?php print t('Close'); ?></button>
                                <button type="submit" name="addUser" class="btn btn-rad btn-primary"><span class="glyphicon glyphicon-ok"></span><?php print t('Create new account'); ?></button>
                            </div>
                        </form>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
        </div>
        <div class="tab-pane fade" id="permissions">
            <?php
            print Permission::generatePermissionList();
            ?>
        </div>
        <div class="tab-pane fade" id="roles">
            <?php
            print Permission::generateRoleList();
            ?>
        </div>
    </div>
</div>