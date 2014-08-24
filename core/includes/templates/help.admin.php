<div class="page-head">
    <h2><?php print t('Help'); ?></h2>
    <?php print get_breadcrumb(); ?>
</div>
<div class="cl-mcont">
<?php
print print_messages();
?>
<div class="col-md-12">
    <?php
        print '<div class="block">'
            . '<div class="content">'
            . '<p>'.t('<b>Disclaimer</b>:<br/>All help and documentation for core components will be in English.<br/>Help and documentation for 3rd party modules and themes might be supplied in other languages.').'</p>'
            . '</div></div>';
        $help = Help::index();
        print '<h2>Core components</h2>'
            . $help['core'];
        print '<h2>Modules</h2>'
            . $help['modules'];
    ?>
</div>