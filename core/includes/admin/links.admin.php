<div class="page-head">
    <h2><?php print t('Menu items in <i>@menu</i>', array('@menu' => DB::getInstance()->getField('menus', 'name', 'mid', $get_url[3]))); ?></h2>
    <?php print get_breadcrumb(); ?>
</div>
<div class="cl-mcont">
    <?php print print_messages(); ?>
<?php
if(isset($get_url)) {
    if($get_url[2] == 'menus') {
        $menu = Menu::getInstance($get_url[3]);
?>
<table class="table table-striped table-hover">
    <tr>
        <td><?php print t('Name'); ?></td>
        <td style="text-align: center;"><?php print t('Actions'); ?></td>
    </tr>
    <?php
        foreach($menu->menuItems() as $item) {
            print '<tr>
                        <td>
                            '.$item['title'].'
                        </td>
                        <td style="text-align: right;">
                            <a href="/admin/layout/menus/items/'.$item['mlid'].'/edit" class="btn btn-rad btn-sm btn-primary"><span class="glyphicon glyphicon-edit"></span> '.t('Edit menu item').'</a>
                            <a href="/admin/layout/menus/items/'.$item['mlid'].'/delete" class="btn btn-rad btn-sm btn-danger"><span class="glyphicon glyphicon-floppy-remove"></span> '.t('Delete menu item').'</a>
                        </td>
                   </tr>';
        }
    ?>
    <tr>
        <td class="hidden-xs" ></td>
        <td class="hidden-xs" style="text-align: right;">
            <a href="/admin/layout/menus/items/add" class="btn btn-rad btn-sm btn-primary"><span class="glyphicon glyphicon-file"></span> <?php print t('Add menu item'); ?></a>
        </td>
    </tr>
</table>
<?php }
    else {
        print '<div class="cl-mcont"><div class="alert alert-info alert-box"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button><p>'.t('Invalid argument supplied by function').'</p></div></div>';
    }
}

?>