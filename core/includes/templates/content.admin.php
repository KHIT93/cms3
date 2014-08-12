<div class="page-head">
    <h2><?php print t('Content'); ?></h2>
    <?php print get_breadcrumb(); ?>
</div>

<div class="cl-mcont">
    <?php print System::print_messages(); ?>
<div class="col-md-12 table-responsive">
    <table class="table table-hover">
        <thead style="background-color: #CCC;">
            <tr>
                <th><strong><?php print t('Title'); ?></strong></th>
                <th class="hidden-xs" ><strong><?php print t('Author'); ?></strong></th>
                <th class="hidden-xs" ><strong><?php print t('Status'); ?></strong></th>
                <th><strong><?php print t('Last updated'); ?></strong></th>
                <th class="hidden-xs" style="text-align: center;"><strong><?php print t('Actions'); ?></strong></th>
            </tr>
        </thead>
        <tbody class="no-border-y">
            <?php
                $pages = Page::getPageList();
                foreach($pages as $content) {
                    $content->data->author = ($content->data->author == 0) ? 'System' : DB::getInstance()->getField('users', 'name', 'uid', $content->data->author);
                    print '<tr>
                            <td>'.$content->data->title.'</td>
                            <td class="hidden-xs" >'.$content->data->author.'</td>
                            <td class="hidden-xs" >'.$content->data->access.'</td>
                            <td>'.$content->data->last_updated.'</td>
                            <td class="hidden-xs" style="text-align: right;">
                                <a href="/admin/content/'.$content->data->pid.'/edit" class="btn btn-rad btn-sm btn-default"><span class="glyphicon glyphicon-edit"></span> '.t('Edit').'</a>
                                <a href="/admin/content/'.$content->data->pid.'/delete" class="btn btn-rad btn-sm btn-danger"><span class="glyphicon glyphicon-floppy-remove"></span> '.t('Delete').'</a>
                            </td>
                           </tr>';
                }
            ?>
            <tr>
                <td></td>
                <td class="hidden-xs" ></td>
                <td class="hidden-xs" ></td>
                <td></td>
                <td class="hidden-xs" style="text-align: right;">
                    <a data-toggle="modal" href="#createPage" class="btn btn-rad btn-sm btn-primary"><span class="glyphicon glyphicon-file"></span> <?php print t('Add page'); ?></a>
                </td>
            </tr>
        </tbody>
    </table>
    <div class="modal fade" id="createPage">
        <div class="modal-dialog" style="width: 960px;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><?php print t('Create new page'); ?></h4>
                </div>
                <form method="POST" name="addPage" action="" role="form">
                    <div class="modal-body">
                        <div id="pageTitle" class="form-group form300">
                            <label for="inputTitle"><?php print t('Title'); ?></label>
                            <input type="text" class="form-control" name="title" placeholder="Name">
                        </div>
                        <div id="pageBody" class="form-group">
                            <label for="inputBody"><?php print t('Body'); ?></label>
                            <textarea name="body" class="form-control" id="bodyText"></textarea>
                        </div>
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#metaData" data-toggle="tab"><?php print t('Metadata'); ?></a></li>
                            <li><a href="#urlAlias" data-toggle="tab"><?php print t('URL Alias'); ?></a></li>
                            <li><a href="#menuItem" data-toggle="tab"><?php print t('Menu'); ?></a></li>
                            <li><a href="#published" data-toggle="tab"><?php print t('Publish'); ?></a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade in active" id="metaData">
                                <div class="form-group form600">
                                    <label for="inputMetaKeywords"><?php print t('Meta Keywords'); ?></label>
                                    <input type="text" name="meta_keywords" class="form-control" placeholder="Keywords">
                                    <label for="inputMetaDesc"><?php print t('Meta Description'); ?></label>
                                    <textarea name="meta_description" class="form-control"></textarea>
                                    <label for="inputMeta">
                                        <input type="checkbox" name="metaRobots[]" class="icheck" value="index" checked>
                                        <?php print t('Index'); ?>
                                    </label>
                                    <label for="inputMeta">
                                        <input type="checkbox" name="metaRobots[]" class="icheck" value="follow" checked>
                                        <?php print t('Follow'); ?>
                                    </label>
                                    <label for="inputMeta">
                                        <input type="checkbox" name="metaRobots[]" class="icheck" value="noindex">
                                        <?php print t('No Index'); ?>
                                    </label>
                                    <label for="inputMeta">
                                        <input type="checkbox" name="metaRobots[]" class="icheck" value="nofollow">
                                        <?php print t('No Follow'); ?>
                                    </label>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="urlAlias">
                                <div class="form-group form300">
                                    <label for="inputAlias"><?php print t('URL Alias'); ?></label>
                                    <input type="text" name="url_alias" class="form-control" placeholder="URL Path Alias">
                                </div>
                            </div>
                            <div class="tab-pane fade" id="menuItem">
                                <div class="form-group form300">
                                    <label for="inputMenuItem">
                                        <input type="checkbox" name="enable_item"  class="icheck" value="enabled">
                                        <?php print t('Add Menu Item'); ?>
                                    </label>
                                    <select class="select2" name="inputMenu">
                                        <option value="disabled">-- <?php print t('Select Menu'); ?> --</option>
                                        <option value="1">Main Menu</option>
                                        <option value="2">Footer Menu</option>
                                    </select>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="published">
                                <div class="form-group">
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="published" id="optionsPublished1" class="icheck" value="0">
                                            <?php print t('Unpublished'); ?>
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="published" id="optionsPublished2" class="icheck" value="1" checked>
                                            <?php print t('Published'); ?>
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="published" id="optionsPublished3" class="icheck" value="2">
                                            <?php print t('Login required'); ?>
                                        </label>
                                    </div>
                                    <div class="radio">
                                        <label>
                                            <input type="radio" name="published" id="optionsPublished4" class="icheck" value="3">
                                            <?php print t('Admin only'); ?>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="form-token" value="<?php print $csrf->get_token($token_id); ?>">
                        <button type="submit" name="addPage" class="btn btn-rad btn-primary"><?php print t('Create new page'); ?></button>
                        <button type="button" class="btn btn-rad btn-default" data-dismiss="modal"><?php print t('Close'); ?></button>                        
                    </div>
                </form>
                <script src="<?php print site_root();?>/core/js/ckeditor/ckeditor.js"></script>
                <script>
                    CKEDITOR.replace( 'body', {
                        language: 'da'
                    });

                </script>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>