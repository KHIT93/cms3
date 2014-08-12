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
foreach($themes as $theme) {
    $output .= '<div class="col-md-9 themelist">'
             . '<div class="col-md-12">'
             . '<div class="col-md-6"><img src="/templates/'.$theme['machine_name'].'/'.$theme['screenshot'].'" width="300"></div>'
             . '<div class="col-md-6">'
             . '<h2>'.$theme['name'].$theme['version'].'</h2>'
             . '<p>'.$theme['description'].'</p>';
    $output .= ($site_data['site_theme'] == $theme['machine_name']) ? '<a href="/admin/layout/themes/'.$theme['machine_name'].'/apply" class="btn btn-rad btn-default btn-sm disabled">This is your current theme</a>' : '<a href="/admin/layout/themes/'.$theme['machine_name'].'/apply" class="btn btn-default btn-sm">'.t('Use this theme').'</a>';
    $output .= '</div></div></div>';
}
$output .= '<div class="col-md-9 themelist">'
        . '<div class="col-md-12">'
        . '<div class="col-md-6"><img src="/core/templates/core/screenshot.png" width="300"></div>'
        . '<div class="col-md-6">'
        . '<h2>CMS Core theme 2.x</h2>'
        . '<p>This is the default site theme which is built using Twitter Bootstrap 3.x</p>';
$output .= (Config::get('site/site_theme') == 'core') ? '<a href="/admin/layout/themes/core/apply" class="btn btn-rad btn-default btn-sm disabled">'.t('This is your current theme').'</a>' : '<a href="/admin/layout/themes/core/apply" class="btn btn-default btn-sm">'.t('Use this theme').'</a>';
$output .= '</div></div></div>';
print $output;
?>
</div>