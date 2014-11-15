<?php
if(isset($get_url)) {
    if($get_url[1] == 'content') {
        $editPage = Page::getPageData($get_url[2]);
        $robots = $editPage->getMetaRobots();
        $alias = DB::getInstance()->getField('url_alias', 'alias', 'source', 'pages/'.$editPage->data['pid']);
?>
    <div class="page-head">
        <h2><?php print t('Edit <i>@content</i>', array('@content' => $editPage->data['title'])); ?></h2>
    </div>
    <div class="cl-mcont">
    <?php print System::print_messages(); ?>
    <form method="POST" name="editPage" action="" role="form">
        <div id="pageTitle" class="form-group form300">
            <label for="inputTitle"><?php print t('Title'); ?></label>
            <input type="text" class="form-control" name="title" value="<?php print $editPage->data['title']; ?>">
        </div>
        <div id="pageBody" class="form-group">
            <label for="inputBody"><?php print t('Body'); ?></label>
            <textarea name="body" class="form-control" id="bodyText"><?php print $editPage->data['content']; ?></textarea>
        </div>
        <ul id="content-tab" class="nav nav-tabs">
            <li class="active"><a href="#metaData" data-toggle="tab"><?php print t('Metadata'); ?></a></li>
            <li><a href="#urlAlias" data-toggle="tab"><?php print t('URL Alias'); ?></a></li>
            <li><a href="#menuItem" data-toggle="tab"><?php print t('Menu'); ?></a></li>
            <li><a href="#published" data-toggle="tab"><?php print t('Publish'); ?></a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade in active" id="metaData">
                <div class="form-group form600">
                    <label for="inputMetaKeywords"><?php print t('Meta Keywords'); ?></label>
                    <input type="text" name="keywords" class="form-control" value="<?php print $editPage->data['keywords']; ?>">
                    <label for="inputMetaDesc"><?php print t('Meta Description'); ?></label>
                    <textarea name="description" class="form-control"><?php print $editPage->data['description']; ?></textarea>
                    <label for="inputMeta">
                        <input type="checkbox" name="robots[]" class="" value="index" <?php print (in_array('index', $robots) ? 'checked' : '') ?>>
                        <?php print t('Index'); ?>
                    </label>
                    <label for="inputMeta">
                        <input type="checkbox" name="robots[]" class="" value="follow" <?php print (in_array('follow', $robots) ? 'checked' : '') ?>>
                        <?php print t('Follow'); ?>
                    </label>
                    <label for="inputMeta">
                        <input type="checkbox" name="robots[]" class="" value="noindex" <?php print (in_array('noindex', $robots) ? 'checked' : '') ?>>
                        <?php print t('No Index'); ?>
                    </label>
                    <label for="inputMeta">
                        <input type="checkbox" name="robots[]" class="" value="nofollow" <?php print (in_array('nofollow', $robots) ? 'checked' : '') ?>>
                        <?php print t('No Follow'); ?>
                    </label>
                    
                </div>
            </div>
            <div class="tab-pane fade" id="urlAlias">
                <div class="form-group form300">
                    <label for="inputAlias"><?php print t('URL Alias'); ?></label>
                    <input type="text" name="alias" class="form-control" value="<?php print $alias; ?>">
                </div>
            </div>
            <div class="tab-pane fade" id="menuItem">
                <div class="form-group form300">
                    <label for="inputMenuItem">
                        <input type="checkbox" class="" name="enable_item" value="enabled">
                        <?php print t('Add Menu Item'); ?>
                    </label>
                    <select class="select2" name="menu">
                        <option value="disabled">-- <?php print t('Select Menu'); ?> --</option>
                        <option value="1">Main Menu</option>
                        <option value="2">Footer Menu</option>
                    </select>
                </div>
            </div>
            <div class="tab-pane fade" id="published">
                <div class="form-group">
                    <div class="radio">
                        <label>
                            <input type="radio" name="published" class=icheck" id="optionsPublished1" value="0" <?php print ($editPage->data['status'] ==0) ? 'checked' : ''; ?>>
                            <?php print t('Unpublished'); ?>
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            <input type="radio" name="published" class=icheck" id="optionsPublished2" value="1" <?php print ($editPage->data['status'] == 1) ? 'checked' : ''; ?>>
                            <?php print t('Published'); ?>
                        </label>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-actions">
            <input type="hidden" name="pid" value="<?php print $editPage->data['pid']; ?>">
            <input type="hidden" name="<?php print Config::get('session/token_name'); ?>" value="<?php print Token::generate(); ?>">
            <input type="hidden" name="form_id" value="editPage">
            <button type="submit" name="editPage" class="btn btn-rad btn-sm btn-primary"><span class="glyphicon glyphicon-floppy-saved"></span> <?php print t('Save changes'); ?></button>
            <a class="btn btn-rad btn-sm btn-default" href="/admin/content"><?php print t('Cancel'); ?></a>            
        </div>
    </form>
    <script>jQuery('#content-tab a:first').tab('show')</script>
    <script src="<?php print CORE_JS_PATH;?>/ckeditor/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'body', {
            language: 'da'
        });

    </script>
<?php    }
    else if($get_url[1] == 'users') {
        if(isset($get_url[4]) && $get_url[4] == 'password') {
?>
    <div class="page-head">
        <h2><?php print t('Change password'); ?></h2>
    </div>
    <div class="cl-mcont">
    <?php print print_messages(); ?>
    <form method="POST" name="editUserPassword" action="" role="form">
        <div class="modal-body row">
            <div class="form-group form300">
                <label for="inputCurrentPassword"><?php print t('Current password'); ?></label>
                <input type="text" class="form-control" name="inputCurrentPassword" value="">
            </div>
            <div class="form-group form300">
                <label for="inputPassword"><?php print t('New password'); ?></label>
                <input type="text" class="form-control" name="inputPassword" value="">
            </div>
            <div class="form-group form300">
                <label for="inputConfirmPassword"><?php print t('Confirm new password'); ?></label>
                <input type="text" class="form-control" name="inputConfirmPassword" value="">
            </div>
        </div>
        <div class="form-actions">
            <input type="hidden" name="inputId" value="<?php print $item['uid']; ?>">
            <input type="hidden" name="form-token" value="<?php print Token::generate(); ?>">
            <input type="hidden" name="form_id" value="editUserPassword">
            <button type="submit" name="editUserPassword" class="btn btn-rad btn-sm btn-primary"><span class="glyphicon glyphicon-floppy-saved"></span> <?php print t('Change password'); ?></button>
            <a class="btn btn-rad btn-sm btn-default" href="/admin/users"><?php print t('Cancel'); ?></a>
        </div>
    </form>
<?php
        }
        else {
            $editUser = new User($get_url[2]);
?>
    <div class="page-head">
        <h2><?php print t('Edit user <i>@user</i>', array('@user' => $editUser->name())); ?></h2>
    </div>
    <?php print '<div class="container">'.print_messages().'</div>'; ?>
    <div class="cl-mcont">
    <form method="POST" name="editUser" action="" role="form">
        <div class="modal-body row">
            <div class="form-group form300">
                <label for="inputName"><?php print t('Name'); ?></label>
                <input type="text" class="form-control" name="name" value="<?php print $editUser->name(); ?>">
            </div>
            <div class="form-group form300">
                <label for="inputUsername"><?php print t('Username'); ?></label>
                <input type="text" name="username" class="form-control" value="<?php print $editUser->username(); ?>">
            </div>
            <div class="form-group form300">
                <label for="inputEmail"><?php print t('Email address'); ?></label>
                <input type="email" name="email" class="form-control" value="<?php print $editUser->email(); ?>">
            </div>
            <div class="form-group">
                <?php
                foreach (Permission::get_roles() as $role) {
                    print '<div class"radio">'
                            . '<label>'
                                . '<input type="radio" name="user_group" id="optionsUsergroup'.$role->rid.'" value="'.$role->rid.'"'.(($role->rid == $editUser->role()) ? 'checked' : '').' >'
                                . ' '.ucfirst(t($role->name))
                            . '</label>'
                        . '</div>';
                }
                ?>
            </div>
            <div class="form-group form300">
                <a href="/admin/users/<?php print $editUser->uid(); ?>/edit/password" class="btn btn-sm btn-info"><span class="glyphicon glyphicon-lock"></span> <?php print t('Change password'); ?></a>
            </div>
        </div>
        <div class="form-actions">
            <input type="hidden" name="user_active" value="<?php print $editUser->active(); ?>">
            <input type="hidden" name="user_id" value="<?php print $editUser->uid(); ?>">
            <input type="hidden" name="form-token" value="<?php print Token::generate(); ?>">
            <input type="hidden" name="form_id" value="editUser">
            <button type="submit" name="editUser" class="btn btn-rad btn-sm btn-primary"><span class="glyphicon glyphicon-floppy-saved"></span> <?php print t('Save changes'); ?></button>
            <a class="btn btn-rad btn-sm btn-default" href="/admin/users"><?php print t('Cancel'); ?></a>
        </div>
    </form>
<?php
        }
    }
    else if($get_url[1] == 'layout' && $get_url[2] == 'menus' && $get_url[3] == 'items') {
        $item = Menu::getMenuLinkData($get_url[4]);
        
?>
    <div class="page-head">
        <h2><?php print t('Edit menu item'); ?></h2>
    </div>
    <div class="cl-mcont">
    <?php print print_messages(); ?>
    <form method="POST" name="editMenuItem" action="" role="form">
        <div class="modal-body row">
            <div class="form-group form300">
                <label for="inputTitle"><?php print t('Title'); ?></label>
                <input type="text" class="form-control" name="title" value="<?php print $item->title; ?>">
            </div>
            <div class="form-group form300">
                <label for="inputLink"><?php print t('Link'); ?></label>
                <input type="text" class="form-control" name="link" value="<?php print $item->link; ?>">
            </div>
        </div>
        <div class="form-actions">
            <input type="hidden" name="inputId" value="<?php print $item->mlid; ?>">
            <input type="hidden" name="form-token" value="<?php print Token::generate(); ?>">
            <input type="hidden" name="form_id" value="editMenuItem">
            <button type="submit" name="editMenuItem" class="btn btn-rad btn-sm btn-primary"><span class="glyphicon glyphicon-floppy-saved"></span> <?php print t('Save changes'); ?></button>
            <a class="btn btn-rad btn-sm btn-default" href="/admin/layout/menus"><?php print t('Cancel'); ?></a>
        </div>
    </form>
<?php
    }
    else {
        print '<div class="cl-mcont"><div class="alert alert-info alert-box"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><p>'.t('Invalid argument supplied by function').'</p></div></div>';
    }
}

?>