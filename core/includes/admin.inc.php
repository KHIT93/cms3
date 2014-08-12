<body class="admin">
    <!--[if lt IE 7]>
        <p class="chromeframe"><?php print t('You are using an <strong>outdated</strong> browser');?>. <?php t('Please <a href="http://browsehappy.com/"> upgrade your browser</a> or'); ?> <a href="http://www.google.com/chromeframe/?redirect=true"><?php print t('activate Google Chrome Frame'); ?></a> <?php print t('to improve your experience'); ?>.</p>
    <![endif]-->

    <!-- <?php print t('This code is taken from'); ?> http://twitter.github.com/bootstrap/examples/hero.html -->
    <?php
        include 'admin-menu.inc.php';
    ?>
    <div id="cl-wrapper">
        <?php
            include 'admin-sidebar.inc.php';
        ?>
        <div id="pcont" class="container-fluid">