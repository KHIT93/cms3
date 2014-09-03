<body class="texture">
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
                                    if(is_admin($_SESSION['user_id']) === true) {
                                ?>
                                <div class="alert alert-success alert-box">
                                    <?php print t('You have been successfully logged in'); ?>. <?php print t('Please proceed to'); ?> <a href="<?php print $_SERVER['DOCUMENT_ROOT']; ?>/admin"><?php print t('the administrative interface'); ?></a>.
                                </div>
                                <?php
                                    }
                                    else {
                                        ?>
                                <div class="alert alert-success alert-box">
                                    <?php print t('You have been successfully logged in'); ?>. <?php print t('Please proceed to'); ?> <a href="<?php print $_SERVER['DOCUMENT_ROOT'];?>/"><?php print t('the frontpage'); ?></a>.
                                </div>

                                <?php    }
                                }
                                else {
                                    print print_messages_simple();
                                ?>
                                <h4 class="title">Enter usercredentials</h4>
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
                                            <input type="checkbox" value="remember-me"> <?php print t('Remember me'); ?>
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="foot">
                                <input type="hidden" name="form_id" value="user_register">
                                <input type="hidden" name="form-token" value="<?php print $csrf->get_token($token_id); ?>">
                                <button class="btn btn-rad btn-primary" type="submit" name="log_in"><?php print t('Sign in'); ?> <span class="glyphicon glyphicon-share"></span></button>
                            </div>
                        </form>
                    </div>
                </div>
                
        <?php } ?>
        