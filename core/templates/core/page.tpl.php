<body>
    <!--[if lt IE 7]>
        <p class="chromeframe"><?php print t('You are using an <strong>outdated</strong> browser Please <a href="@browserhappy"> upgrade your browser</a> or <a href="@chrome_frame_link">activate Google Chrome Frame</a> to improve your experience', array('@browserhappy' => 'http://browsehappy.com/', '@chrome_frame_link' => 'http://www.google.com/chromeframe/?redirect=true')); ?>.</p>
    <![endif]-->

    <!-- <?php print t('This code is taken from @bootstrap_link', array('@bootstrap_link' => 'http://twitter.github.com/bootstrap/examples/hero.html')); ?>  -->
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
                <div class="navbar-header">
                    <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="<?php print '/'.page_front(); ?>" class="navbar-brand"><?php print Config::get('site/site_name'); ?></a>
                </div>
                <div class="collapse navbar-collapse">
                    <?php
                        print render($page['header']);
                    ?>
                </div><!--/.nav-collapse -->
            </div>
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