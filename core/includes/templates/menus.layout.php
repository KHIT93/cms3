<div class="page-head">
    <h2><?php print t('Menus'); ?></h2>
    <?php print get_breadcrumb(); ?>
</div>
<div class="cl-mcont">
    <?php print print_messages(); ?>
<div class="col-md-12">
<?php $menus = getMenus(); ?>
<table class="table table-hover">
    <thead style="background-color: #CCC;">
        <tr>
            <th><strong><?php print t('Name'); ?></strong></th>
            <th style="text-align: right;"><strong><?php print t('Actions'); ?></strong></th>
        </tr>
    </thead>
    <tbody class="no-border-y">
        
        <?php
            foreach($menus as $menu) {
                print '<tr>
                            <td>
                                '.$menu['menu_name'].'
                            </td>
                            <td style="text-align: right;">
                                <a href="'.site_root().'/admin/layout/menus/'.$menu['menu_id'].'/links" class="btn btn-rad btn-sm btn-default"><span class="glyphicon glyphicon-th-list"></span> '.t('View links').'</a>
                                <a href="'.site_root().'/admin/layout/menus/'.$menu['menu_id'].'/delete" class="btn btn-rad btn-sm btn-danger"><span class="glyphicon glyphicon-floppy-remove"></span> '.t('Delete menu').'</a>
                            </td>
                       </tr>';
            }
        ?>
    </tbody>
</table>
</div>