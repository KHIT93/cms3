<div class="page-head">
    <h2><?php print t('Widgets'); ?></h2>
    <?php print get_breadcrumb(); ?>
</div>
<div class="cl-mcont">
    <?php print print_messages(); ?>
<div class="col-md-12">
<?php
if(has_permission('access_admin_layout_widgets', $_SESSION['uid']) === true) {
$items = widgets::getAllWidgets();
$sections = widgets::getSections($site_data['site_theme']);
?>

<hr/>
<p>
    <?php if(has_permission('access_admin_layout_widgets_add', $_SESSION['uid']) === true) : ?>
    <a href="<?php print site_root(); ?>/admin/layout/widgets/add">
        <span class="glyphicon glyphicon-plus"></span> <?php print t('Create new widget'); ?>
    </a>
    <?php endif; ?>
</p>
<form name="editSections" method="POST" action="" role="form">
    <table class="table table-hover">
        <thead style="background-color: #CCC;">
            <tr>
                <th><strong><?php print t('Widget'); ?></strong></th>
                <th class="hidden-xs"><strong><?php print t('Section'); ?></strong></th>
                <th class="hidden-xs"><strong><?php print t('Actions'); ?></strong></th>
            </tr>
        </thead>
        <tbody class="no-border-y">
            <?php
                foreach ($sections as $section => $value) {
                    print '<tr style="background-color: #f9f9f9;">'
                            . '<td><b>'.$value.'</b></td>'
                            . '<td class="hidden-xs"></td><td class="hidden-xs"></td>'
                        . '</tr>';
                    print widgets::renderWidgetList($section, $site_data['site_theme'], $items);
                }
                print '<tr style="background-color: #f9f9f9;">'
                        . '<td><b>'.t('Inactive').'</b></td>'
                        . '<td class="hidden-xs"></td><td class="hidden-xs"></td>'
                    . '</tr>';
                if(count($items) != 0) {
                    foreach ($items as $item) {
                        print '<tr>'
                                . '<td style="padding-left: 2em;">'.$item['widget_title'].'</td>'
                                . '<td class="hidden-xs">'.t('Inactive').' - '.Forms::renderAsFormElement(widgets::getSections($site_data['site_theme']), 'select', 'widget_'.$item['widget_id']).'</td>'
                                . '<td class="hidden-xs"></td>'
                            . '</tr>';
                    }
                }
                else {
                    print '<tr>'
                            . '<td colspan="3"style="padding-left: 2em;"><i>'.t('There are no inactive widgets').'</i></td>'
                        . '</tr>';
                }
            ?>
            <input type="hidden" name="form-token" value="<?php print $csrf->get_token($token_id); ?>">
            <?php if(has_permission('access_admin_layout_widgets_move', $_SESSION['uid']) === true) : ?>
            <tr>
                <td class="hidden-xs" colspan="3"><button type="submit" class="btn btn-rad btn-primary" name="editSections"><?php print t('Save changes'); ?></button></td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</form>
</div>
<?php
}
else {
    print action_denied(true);
}
?>