<div class="page-head">
    <h2><?php print t('Help'); ?></h2>
    <?php print get_breadcrumb(); ?>
</div>
<div class="cl-mcont">
<?php
$dashboard = getDashboard();
print print_messages();
?>
<div class="col-md-12">
    <?php print get_help_index(); ?>
</div>