<?php
if(isset($get_url[2])) {
    if($get_url[2] == 'menus') {
        include 'menus.layout.php';
    }
    else if($get_url[2] == 'themes') {
        include 'themes.layout.php';
    }
    else if($get_url[2] == 'widgets') {
        include 'widgets.layout.php';
    }
    else {
?>
<div class="page-head">
    <h2>Layout</h2>
    <?php print get_breadcrumb(); ?>
</div>
<div class="cl-mcont">
    <?php print print_messages(); ?>
<div class="col-md-12">
<p><?php print t('Please select the item you want to manage below.'); ?></p>
<a href="/admin/layout/menus" class="list-group-item">
    <h4 class="list-group-item-heading"><?php print t('Menus'); ?></h4>
    <p class="list-group-item-text"><?php print t('Manage menus and menu items'); ?></p>
</a>
<a href="/admin/layout/themes" class="list-group-item">
    <h4 class="list-group-item-heading"><?php print t('Themes'); ?></h4>
    <p class="list-group-item-text"><?php print t('Install new themes and change your active theme'); ?></p>
</a>
<a href="/admin/layout/widgets" class="list-group-item">
    <h4 class="list-group-item-heading"><?php print t('Widgets'); ?></h4>
    <p class="list-group-item-text"><?php print t('Manage your widgets'); ?></p>
</a>
</div>
<?php
    }
}
else {
?>
<div class="page-head">
    <h2>Layout</h2>
    <?php print get_breadcrumb(); ?>
</div>
<div class="cl-mcont">
    <?php print print_messages(); ?>
<div class="col-md-12">
<p><?php print t('Please select the item you want to manage below.'); ?></p>
<a href="/admin/layout/menus" class="list-group-item">
    <h4 class="list-group-item-heading"><?php print t('Menus'); ?></h4>
    <p class="list-group-item-text"><?php print t('Manage menus and menu items'); ?></p>
</a>
<a href="/admin/layout/themes" class="list-group-item">
    <h4 class="list-group-item-heading"><?php print t('Themes'); ?></h4>
    <p class="list-group-item-text"><?php print t('Install new themes and change your active theme'); ?></p>
</a>
<a href="/admin/layout/widgets" class="list-group-item">
    <h4 class="list-group-item-heading"><?php print t('Widgets'); ?></h4>
    <p class="list-group-item-text"><?php print t('Manage your widgets'); ?></p>
</a>
</div>
<?php } ?>