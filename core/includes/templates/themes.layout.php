<div class="page-head">
    <h2><?php print t('Themes'); ?></h2>
    <?php print get_breadcrumb(); ?>
</div>
<div class="cl-mcont">
    <?php print print_messages(); ?>
<div class="col-md-12">
<?php
$themes = Theme::getThemeList();
$output = '';
foreach ($themes as $theme) {
    $output .= '<div class="block">'
                . '<div class="header no-border">'
                    . '<h2>'.$theme['name'].'</h2>'
                . '</div>'
                . '<div class="content">'
                    . '<div class="col-md-6">'
                        . '<img src="/templates/'.$theme['machine_name'].'/'.$theme['screenshot'].'" width="300">'
                    . '</div>'
                    . '<div class="col-md-6">'
                        . '<p>'.$theme['description'].'</p>'
                        . ((Config::get('site/site_theme') == $theme['machine_name']) ? '<a href="/admin/layout/themes/'.$theme['machine_name'].'/apply" class="btn btn-rad btn-default btn-sm disabled">'.t('This is your current theme').'</a>': '<a href="/admin/layout/themes/'.$theme['machine_name'].'/apply" class="btn btn-default btn-sm">'.t('Use this theme').'</a>')
                    . '</div>'
                    . '<div class="clearfix"></div>'
                . '</div>'
            . '</div>';
}
$output .= '<div class="block">'
            . '<div class="header no-border">'
                . '<h2>CMS Core theme '.VERSION.'</h2>'
            . '</div>'
            . '<div class="content">'
                . '<div class="col-md-6">'
                    . '<img src="/core/templates/core/screenshot.png" width="300">'
                . '</div>'
                . '<div class="col-md-6">'
                    . '<p>This is the default site theme which is built using Twitter Bootstrap 3.x</p>'
                    . ((Config::get('site/site_theme') == 'core') ? '<a href="/admin/layout/themes/core/apply" class="btn btn-rad btn-default btn-sm disabled">'.t('This is your current theme').'</a>': '<a href="/admin/layout/themes/core/apply" class="btn btn-default btn-sm">'.t('Use this theme').'</a>')
                . '</div>'
                . '<div class="clearfix"></div>'
            . '</div>'
        . '</div>';
print $output;
?>
</div>
</div>