            <div class="cl-sidebar nscroller">
                <div class="cl-toggle"><i class="fa fa-bars"></i></div>
                <div class="cl-navblock">
                    <div class="menu-space">
                        <div class="content">
                            <div class="side-user">
                                <div class="avatar">
                                    <img src="<?php print CORE_IMG_PATH; ?>/avatar-noimage_50.png" alt="">
                                </div>
                                <div class="info">
                                    <a href="#"><?php print User::getInstance()->name(); ?></a>
                                    <span>Administrator</span>
                                </div>
                            </div>
                            <?php print System::getAdminSideBar(); ?>
                        </div>
                    </div>
                    <div style="padding:7px 9px;" class="text-right collapse-button">
                        <a href="/admin/help" class="btn btn-default"><i class="fa fa-question" style="color:#fff;"></i></a>
                        <a href="/admin/settings" class="btn btn-default"><i class="fa fa-gear" style="color:#fff;"></i></a>
                        <a href="/logout" class="btn btn-default"><i class="fa fa-power-off" style="color:#fff;"></i></a>
                        <button style="" class="btn btn-default" id="sidebar-collapse"><i class="fa fa-angle-left" style="color:#fff;"></i></button>
                    </div>
                </div>
            </div>