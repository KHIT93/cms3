<div class="cl-mcont">
    <?php print print_messages(); ?>
<?php

if(isset($get_url)) {
    if($get_url[1] == 'content') {
?>
<div class="modal-header">
    <h3 class="modal-title"><?php print t('Delete content'); ?></h3>
</div>
<div class="modal-body">
    <p><?php print t('Are you sure that you want to delete "<i>@content</i>"', array('@content' => DB::getInstance()->getField('pages', 'title', 'pid', $get_url[2])));?></p>
</div>
<div class="modal-footer">
    <form name="deleteContent" method="POST" action="">
        <input type="hidden" name="page_id" value="<?php print $get_url[2]; ?>">
        <input type="hidden" name="form-token" value="<?php print Token::generate(); ?>">
        <input type="hidden" name="form_id" value="deletePage">
        <a href="/admin/content" class="btn btn-rad btn-sm btn-default"><?php print t('Cancel'); ?></a>
        <button type="submit" name="deletePage" class="btn btn-rad btn-sm btn-danger"><span class="glyphicon glyphicon-floppy-remove"></span> <?php print t('Delete page'); ?></button>
    </form>
</div>
    <?php }
    else if($get_url[1] == 'users') {
?>
<div class="modal-header">
    <h4 class="modal-title"><?php print t('Delete user'); ?></h4>
</div>
<div class="modal-body">
    <p><?php print t('Are you sure that you want to delete "<i>@user</i>"', array('@user' => DB::getInstance()->getField('users', 'name', 'user_id', $get_url[2])));?></p>
</div>
<div class="modal-footer">
    <form name="deleteUser" method="POST" action="">
        <input type="hidden" name="user_id" value="<?php print $get_url[2]; ?>">
        <input type="hidden" name="form-token" value="<?php print Token::generate(); ?>">
        <input type="hidden" name="form_id" value="deleteUser">
        <a href="/admin/users" class="btn btn-rad btn-sm btn-default"><?php print t('Cancel'); ?></a>
        <button type="submit" name="deleteUser" class="btn btn-rad btn-sm btn-danger"><span class="glyphicon glyphicon-floppy-remove"></span> <?php print t('Delete user'); ?></button>
    </form>
</div>
<?php }
    else if($get_url[1] == 'layout' && $get_url[2] == 'menus' && $get_url[3] == 'items') {
?>
<div class="modal-header">
    <h4 class="modal-title"><?php print t('Delete menu item'); ?></h4>
</div>
<div class="modal-body">
    <p><?php print t('Are you sure that you want to delete "<i>@menu_item</i>"', array('@menu_item' => DB::getInstance()->getField('menu_items', 'title', 'mlid', $get_url[4])));?></p>
</div>
<div class="modal-footer">
    <form name="deleteMenuItem" method="POST" action="">
        <input type="hidden" name="item_id" value="<?php print $get_url[4]; ?>">
        <input type="hidden" name="form-token" value="<?php print Token::generate(); ?>">
        <input type="hidden" name="form_id" value="deleteMenuItem">
        <a href="/admin/layout/menus" class="btn btn-rad btn-sm btn-default"><?php print t('Cancel'); ?></a>
        <button type="submit" name="deleteMenuItem" class="btn btn-rad btn-sm btn-danger"><span class="glyphicon glyphicon-floppy-remove"></span> <?php print t('Delete menu item'); ?></button>
    </form>
</div>
<?php }
    else if($get_url[1] == 'layout' && $get_url[2] == 'menus') {
    ?>
<div class="modal-header">
    <h4 class="modal-title"><?php print t('Delete menu'); ?></h4>
</div>
<div class="modal-body">
    <p><?php print t('Are you sure that you want to delete "<i>@menu</i>"', array('@menu' => DB::getInstance()->getField('menus', 'title', 'mid', $get_url[4])));?></p>
</div>
<div class="modal-footer">
    <form name="deleteMenu" method="POST" action="">
        <input type="hidden" name="item_id" value="<?php print $get_url[2]; ?>">
        <input type="hidden" name="form-token" value="<?php print Token::generate(); ?>">
        <input type="hidden" name="form_id" value="deleteMenu">
        <a href="/admin/layout/menus" class="btn btn-rad btn-sm btn-default"><?php print t('Cancel'); ?></a>
        <button type="submit" name="deleteMenu" class="btn btn-rad btn-sm btn-danger"><span class="glyphicon glyphicon-floppy-remove"></span> <?php print t('Delete menu'); ?></button>
    </form>
</div>
<?php }
    else {
        print '<div class="alert alert-info alert-box alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><p>'.t('Invalid argument supplied by function').'</p></div>';
    }
}

?>