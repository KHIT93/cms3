<div id="head-nav" class="navbar navbar-default navbar-fixed-top">
<div class="container-fluid">
        <div class="navbar-header">
            <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
                <span class="fa fa-gear"></span>
            </button>
            <a href="<?php print '/'.page_front(); ?>" class="navbar-brand"><span><?php print Config::get('site/site_name'); ?></span></a>
        </div>
        <div class="collapse navbar-collapse">
            <?php print System::getAdminMenu(); ?>
            <ul class="nav navbar-nav navbar-right user-nav">
                <li class="dropdown profile_menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="<?php print CORE_IMG_PATH; ?>/avatar-noimage_24.png">
                        <span>Kenneth Hansen</span>
                        <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#">My Account</a></li>
                        <li><a href="#">Change password</a></li>
                        <li class="divider"></li>
                        <li><a href="/logout">Sign Out</a></li>
                    </ul>
                </li>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</div>