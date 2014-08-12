<div class="page-head">
    <h2><?php print t('Dashboard'); ?></h2>
</div>
<div class="cl-mcont">
<?php
$dashboard = getDashboard();
print print_messages();
?>
<div class="col-md-12">
    <div class="row">
        <div class="col-md-8">
            <ul class="nav nav-tabs nav-justified">
                <li class="active"><a><?php print t('Newest pages'); ?></a></li>
            </ul>
            <table class="table table-hover">
                <thead style="background-color: #CCC;">
                    <tr>
                        <th><strong><?php print t('Page Title'); ?></strong></th>
                        <th><strong><?php print t('Author'); ?></strong></th>
                        <th class="hidden-xs" style="text-align: right;"><strong><?php print t('Actions'); ?></strong></th>
                    </tr>
                </thead>
                <tbody class="no-border-y">
                    
                    <?php
                    foreach($dashboard['pages'] as $content) {
                        $content['page_author'] = ($content['page_author'] == 0) ? 'System' : getFieldFromDB('users', 'user_name', 'uid', $content['page_author']);
                        print '<tr>
                                <td>'.$content['page_title'].'</td>
                                <td>'.$content['page_author'].'</td>
                                <td style="text-align: right;" class="hidden-xs">
                                    <a href="'.site_root().'/admin/content/'.$content['page_id'].'/edit" class="btn btn-rad btn-default btn-sm">'.t('Edit').'</a>
                                    <a href="'.site_root().'/admin/content/'.$content['page_id'].'/delete" class="btn btn-rad btn-danger btn-sm">'.t('Delete').'</a>
                                </td>
                               </tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
        <div class="col-md-4">
            <ul class="nav nav-tabs nav-justified">
                <li class="active"><a><?php print t('New Users'); ?></a></li>
            </ul>
            <table class="table table-striped table-hover table-bordered">
                <?php
                foreach($dashboard['users'] as $content) {
                    //$content['page_author'] = ($content['page_author'] == 0) ? 'System' : getFieldFromDB('users', 'name', 'user_id', $content['page_author']);
                    print '<tr>
                            <td><a href="'.site_root().'/admin/users/'.$content['uid'].'/edit">'.$content['user_name'].'</a></td>
                           </tr>';
                }
                ?>
            </table>
        </div>
    </div>
</div>