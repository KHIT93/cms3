            <div class="cl-sidebar">
                <div class="cl-toggle"><i class="fa fa-bars"></i></div>
                <div class="cl-navblock">
                    <div class="menu-space">
                        <div class="content">
                            <div class="side-user">
                                <div class="avatar">
                                    <img src="<?php print CORE_IMG_PATH; ?>/avatar-noimage_50.png">
                                </div>
                                <div class="info">
                                    <a href="#">Kenneth Hansen</a>
                                    <span>Administrator</span>
                                </div>
                            </div>
                            <!--<ul class="cl-vnavigation">
                                <li><a href="#"><i class="fa fa-dashboard"></i><span>Dashboard</span></a></li>              
                                <li><a href="#"><i class="fa fa-file nav-icon"></i><span>Content</span></a></li>
                                <li><a href="#"><i class="fa fa-picture-o nav-icon"></i><span>Layout</span></a>
                                  <ul class="sub-menu">
                                    <li><a href="email-inbox.html">Menus</a></li>
                                    <li><a href="email-inbox.html">Themes</a></li>
                                    <li><a href="email-inbox.html">Widgets</a></li>
                                  </ul>
                                </li>
                                <li><a href="typography.html"><i class="fa fa-cubes"></i><span>Modules</span></a></li>
                                <li><a href="charts.html"><i class="fa fa-user"></i><span>Users</span></a></li>
                                <li><a href="#"><i class="fa fa-wrench"></i><span>Settings</span></a></li>
                            </ul>-->
                            <?php print System::getAdminSideBar(); ?>
                        </div>
                    </div>
                    <div style="padding:7px 9px;" class="text-right collapse-button">
                        <a href="/admin/settings" class="btn btn-default"><i class="fa fa-gear" style="color:#fff;"></i></a>
                        <a href="/logout" class="btn btn-default"><i class="fa fa-power-off" style="color:#fff;"></i></a>
                        <button style="" class="btn btn-default" id="sidebar-collapse"><i class="fa fa-angle-left" style="color:#fff;"></i></button>
                    </div>
                </div>
            </div>