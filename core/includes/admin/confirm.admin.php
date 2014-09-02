<div class="cl-mcont">
    <?php print print_messages(); ?>
<?php
if($get_url[1] == 'layout' && $get_url[2] = 'themes') {
?>
<div class="modal-header">
    <h3 class="modal-title"><?php print t('Apply theme'); ?></h3>
</div>
<div class="modal-body">
    <p><?php print t('Are you sure that you want to change the active theme to "<i>@theme</i>"', array('@theme' => $get_url[3]));?></p>
</div>
<div class="modal-footer">
    <form name="applyTheme" method="POST" action="">
        <input type="hidden" name="inputTheme" value="<?php print $get_url[3]; ?>">
        <input type="hidden" name="form-token" value="<?php print Token::generate(); ?>">
        <input type="hidden" name="form_id" value="applyTheme">
        <a href="/admin/layout/themes" class="btn btn-rad btn-sm btn-default"><?php print t('Cancel'); ?></a>
        <button type="submit" name="applyTheme" class="btn btn-rad btn-sm btn-primary"><span class="glyphicon glyphicon-picture"></span> <?php print t('Apply theme'); ?></button>
    </form>
</div>
<?php }
else if($get_url[1] == 'modules') {
    if($get_url[3] == 'install') {
?>
<div class="modal-header">
    <h3 class="modal-title"><?php print t('Install module'); ?></h3>
</div>
<div class="modal-body">
    <p><?php print t('Are you sure that you want to install "<i>@module</i>"', array('@module' => $get_url[2]));?></p>
</div>
<div class="modal-footer">
    <form name="installModule" method="POST" action="">
        <input type="hidden" name="inputModule" value="<?php print $get_url[2]; ?>">
        <input type="hidden" name="inputModuleCore" value="<?php (isset($get_url[4])) ? print $get_url[4] : ''; ?>">
        <input type="hidden" name="form-token" value="<?php print Token::generate(); ?>">
        <input type="hidden" name="form_id" value="installModule">
        <a href="/admin/modules" class="btn btn-rad btn-sm btn-default"><?php print t('Cancel'); ?></a>
        <button type="submit" name="installModule" class="btn btn-rad btn-sm btn-primary"><i class="fa fa-cogs"></i> <?php print t('Install module'); ?></button>
    </form>
</div>
    <?php }
    else if($get_url[3] == 'enable') {
    ?>
<div class="modal-header">
    <h3 class="modal-title"><?php print t('Enable module'); ?></h3>
</div>
<div class="modal-body">
    <p><?php print t('Are you sure that you want to enable "<i>@module</i>"', array('@module'), $get_url[2]);?> "<?php print '<i>'.$get_url[2].'</i>'; ?>"</p>
</div>
<div class="modal-footer">
    <form name="enableModule" method="POST" action="">
        <input type="hidden" name="inputModule" value="<?php print $get_url[2]; ?>">
        <input type="hidden" name="inputModuleCore" value="<?php (isset($get_url[4])) ? print $get_url[4] : ''; ?>">
        <input type="hidden" name="form-token" value="<?php print Token::generate(); ?>">
        <input type="hidden" name="form_id" value="enableModule">
        <a href="/admin/modules" class="btn btn-rad btn-sm btn-default"><?php print t('Cancel'); ?></a>
        <button type="submit" name="enableModule" class="btn btn-rad btn-sm btn-primary"><i class="fa fa-cogs"></i> <?php print t('Install module'); ?></button>
    </form>
</div>
    <?php }
}
else if($get_url[1] == 'users') {
    if($get_url[3] == 'enable') {
?>
<div class="modal-header">
    <h3 class="modal-title"><?php print t('Enable User'); ?></h3>
</div>
<div class="modal-body">
    <p><?php print t('Are you sure that you want to enable the user "<i>@user</i>"', array('@user' => DB::getInstance()->getField('users', 'name', 'uid', $get_url[2])));?></p>
</div>
<div class="modal-footer">
    <form name="enableUser" method="POST" action="">
        <input type="hidden" name="inputUserId" value="<?php print $get_url[2]; ?>">
        <input type="hidden" name="form-token" value="<?php print Token::generate(); ?>">
        <input type="hidden" name="form_id" value="enableUser"
        <a href="/admin/users" class="btn btn-rad btn-sm btn-default"><?php print t('Cancel'); ?></a>
        <button type="submit" name="enableUser" class="btn btn-rad btn-sm btn-primary"><i class="fa fa-unlock"></i> <?php print t('Enable User'); ?></button>
    </form>
</div>
    <?php }
    else if($get_url[3] == 'disable') {
    ?>
<div class="modal-header">
    <h3 class="modal-title"><?php print t('Disable User'); ?></h3>
</div>
<div class="modal-body">
    <p><?php print t('Are you sure that you want to disable the user "<i>@user</i>"', array('@user' => DB::getInstance()->getField('users', 'name', 'uid', $get_url[2])));?></p>
</div>
<div class="modal-footer">
    <form name="disableUser" method="POST" action="">
        <input type="hidden" name="inputUserId" value="<?php print $get_url[2]; ?>">
        <input type="hidden" name="form-token" value="<?php print $csrf->get_token($token_id); ?>">
        <a href="/admin/modules" class="btn btn-rad btn-sm btn-default"><?php print t('Cancel'); ?></a>
        <button type="submit" name="disableUser" class="btn btn-rad btn-sm btn-primary"><i class="fa fa-lock"></i> <?php print t('Disable User'); ?></button>
    </form>
</div>
    <?php }
}
else {
    print '<div class="alert alert-info alert-box alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><p>'.t('Invalid argument supplied by function').'</p></div>';
}
?>
