<body class="texture" id="login-register" style="opacity: 1;">
    <!--[if lt IE 7]>
        <p class="chromeframe"><?php print t('You are using an <strong>outdated</strong> browser');?>. <?php t('Please <a href="http://browsehappy.com/"> upgrade your browser</a> or'); ?> <a href="http://www.google.com/chromeframe/?redirect=true"><?php print t('activate Google Chrome Frame'); ?></a> <?php print t('to improve your experience'); ?>.</p>
    <![endif]-->

    <!-- <?php print t('This code is taken from'); ?> http://twitter.github.com/bootstrap/examples/hero.html -->
    <div class="container">
        <div class="login-container">
            <div class="middle-login">
                <div class="block-flat">
                    <div class="header">
                        <h3 class="text-center"><!-- <img class="logo-img" src="http://198.57.247.231/~condorth/cleanzone/images/logo.png" alt="logo"> --><?php print t('Please sign in'); ?></h3>
                    </div>
                    <div>
                        <form class="form-signin" method="POST" action="">
                            <div class="content">
                                <?php
                                if(logged_in() === true) { 
                                    if(is_admin($_SESSION['uid']) === true) {
                                ?>
                                <div class="alert alert-success alert-box">
                                    <?php print t('You have been successfully logged in'); ?>. <?php print t('Please proceed to'); ?> <a href="<?php print site_root(); ?>/admin"><?php print t('the administrative interface'); ?></a>.
                                </div>
                                <?php
                                    }
                                    else {
                                        ?>
                                <div class="alert alert-success alert-box">
                                    <?php print t('You have been successfully logged in'); ?>. <?php print t('Please proceed to'); ?> <a href="<?php print site_root();?>/"><?php print t('the frontpage'); ?></a>.
                                </div>

                                <?php    }
                                }
                                else {
                                    print print_messages_simple();
                                ?>
                                <h4 class="title">Enter user credentials</h4>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                                            <input type="text" name="username" class="form-control" placeholder="<?php print t('Email address'); ?>" autofocus>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                                            <input type="password" name="password" class="form-control" placeholder="<?php print t('Password'); ?>">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label class="checkbox">
                                            <input type="checkbox" class="icheck" value="remember-me"> <?php print t('Remember me'); ?>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="foot">
                                <button class="btn btn-rad btn-primary" type="submit" name="log_in"><?php print t('Sign in'); ?> <span class="glyphicon glyphicon-share"></span></button>
                            </div>
                        </form>
                    </div>
                </div>
                
        <?php } ?>
                <div class="text-center">
                    <footer style="color: #C9D4F6;">
                        <p><a href="<?php print site_root().'/'.page_front();?>"><span class="glyphicon glyphicon-circle-arrow-left"></span> <?php print t('Go Back'); ?></a>
                            &nbsp;&copy; <?php print date('Y').' '.$GLOBALS['site']->site_name;?></p>
                    </footer>
                </div>
            </div>
        </div>
        <script type="text/javascript" src="<?php print CORE_JS_PATH;?>/jquery.nanoscroller/jquery.nanoscroller.js"></script>
        <script type="text/javascript" src="<?php print CORE_JS_PATH;?>/jquery.sparkline/jquery.sparkline.min.js"></script>
        <script type="text/javascript" src="<?php print CORE_JS_PATH;?>/jquery.easypiechart/jquery.easy-pie-chart.js"></script>
        <script src="<?php print CORE_JS_PATH;?>/jquery.ui/jquery-ui.js" type="text/javascript"></script>
        <script type="text/javascript" src="<?php print CORE_JS_PATH;?>/jquery.nestable/jquery.nestable.js"></script>
        <script type="text/javascript" src="<?php print CORE_JS_PATH;?>/bootstrap.switch/bootstrap-switch.min.js"></script>
        <script type="text/javascript" src="<?php print CORE_JS_PATH;?>/bootstrap.datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
        <script src="<?php print CORE_JS_PATH;?>/jquery.select2/select2.min.js" type="text/javascript"></script>
        <script src="<?php print CORE_JS_PATH;?>/bootstrap.slider/js/bootstrap-slider.js" type="text/javascript"></script>
        <script type="text/javascript" src="<?php print CORE_JS_PATH;?>/jquery.gritter/js/jquery.gritter.js"></script>
        <script type="text/javascript" src="<?php print CORE_JS_PATH;?>/jquery.icheck/icheck.min.js"></script>
        <script type="text/javascript" src="<?php print CORE_JS_PATH;?>/behaviour/general.js"></script>
        <script type="text/javascript" src="<?php print CORE_JS_PATH;?>/core.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
              //initialize the javascript
              App.init();
            });
        </script>
        <script type="text/javascript" src="<?php print CORE_JS_PATH;?>/jquery.flot/jquery.flot.js"></script>
        <script type="text/javascript" src="<?php print CORE_JS_PATH;?>/jquery.flot/jquery.flot.pie.js"></script>
        <script type="text/javascript" src="<?php print CORE_JS_PATH;?>/jquery.flot/jquery.flot.resize.js"></script>
        <script type="text/javascript" src="<?php print CORE_JS_PATH;?>/jquery.flot/jquery.flot.labels.js"></script>
        <script>
            var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src='//www.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>
    </body>
</html>