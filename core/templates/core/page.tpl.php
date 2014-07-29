<body>
    <!--[if lt IE 7]>
        <p class="chromeframe"><?php print t('You are using an <strong>outdated</strong> browser');?>. <?php t('Please <a href="http://browsehappy.com/"> upgrade your browser</a> or'); ?> <a href="http://www.google.com/chromeframe/?redirect=true"><?php print t('activate Google Chrome Frame'); ?></a> <?php print t('to improve your experience'); ?>.</p>
    <![endif]-->

    <!-- <?php print t('This code is taken from'); ?> http://twitter.github.com/bootstrap/examples/hero.html -->
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
                <div class="navbar-header">
                    <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="<?php print site_root().'/'.page_front(); ?>" class="navbar-brand">Menu</a>
                </div>
                <div class="collapse navbar-collapse">
                    <?php print generateMenu(1); ?>
                </div><!--/.nav-collapse -->
            </div>
    </div>
    <div class="container">
        <?php print render($page['header']); ?>
    </div>
    <div class="container" id="main-content">
        <div class="row">
            <div class="col-md-12">
                <?php
                      /*print print_messages();
                      print '<h1>'.$page['page_title'].'</h1>';
                      print $page['page_content'];*/
                      print render($page['content']);

                ?>
            </div>
        </div>
        <hr>
    </div> <!-- /container -->
    <div class="container">
        <?php print render($page['footer']); ?>
    </div>
    <?php print render($page['post_render']); ?>
    <script>
        var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
        (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
        g.src='//www.google-analytics.com/ga.js';
        s.parentNode.insertBefore(g,s)}(document,'script'));
    </script>
    </body>
</html>