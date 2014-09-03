<body class="admin" style="opacity: 1;">
    <!--[if lt IE 7]>
        <p class="chromeframe"><?php print t('You are using an <strong>outdated</strong> browser Please <a href="@browserhappy"> upgrade your browser</a> or <a href="@chrome_frame_link">activate Google Chrome Frame</a> to improve your experience', array('@browserhappy' => 'http://browsehappy.com/', '@chrome_frame_link' => 'http://www.google.com/chromeframe/?redirect=true')); ?>.</p>
    <![endif]-->

    <!-- <?php print t('This code is taken from @bootstrap_link', array('@bootstrap_link' => 'http://twitter.github.com/bootstrap/examples/hero.html')); ?>  -->
    <?php
        include 'admin-menu.inc.php';
    ?>
    <div id="cl-wrapper">
        <?php
            include 'admin-sidebar.inc.php';
        ?>
        <div id="pcont" class="container-fluid">