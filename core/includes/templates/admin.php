<div class="page-head">
    <h2><?php print t('Dashboard'); ?></h2>
</div>
<div class="cl-mcont">
<?php
$dashboard = System::getDashboard();
print System::print_messages();
?>
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="block">
                    <div class="header">
                        <h2><?php print t('Newest pages'); ?></h2>
                    </div>
                    <div class="content">
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
                                    $content->author = ($content->author == 0) ? 'System' : DB::getInstance()->getField('users', 'name', 'uid', $content->author);
                                    print '<tr>
                                            <td>'.$content->title.'</td>
                                            <td>'.$content->author.'</td>
                                            <td style="text-align: right;" class="hidden-xs">
                                                <a href="/admin/content/'.$content->pid.'/edit" class="btn btn-rad btn-default btn-sm">'.t('Edit').'</a>
                                                <a href="/admin/content/'.$content->pid.'/delete" class="btn btn-rad btn-danger btn-sm">'.t('Delete').'</a>
                                            </td>
                                           </tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="block">
                    <div class="header">
                        <h2><?php print t('New Users'); ?></h2>
                    </div>
                    <div class="content">
                        <table class="table table-striped table-hover table-bordered">
                            <?php
                            foreach($dashboard['users'] as $content) {
                                //$content['page_author'] = ($content['page_author'] == 0) ? 'System' : getFieldFromDB('users', 'name', 'user_id', $content['page_author']);
                                print '<p><a href="/admin/users/'.$content->uid.'/edit">'.$content->name.'</a></p>';
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>