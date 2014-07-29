<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php print 'Administration'.' | '.$site_data['site_name']; ?></title>
        <meta name="description" content="<?php (isset($page['meta_description'])) ? print $page['meta_description'] : ''; ?>">
        <meta name="keywords" content="<?php (isset($page['meta_keywords'])) ? print $page['meta_keywords'] : ''; ?>">
        <meta name="robots" content="<?php (isset($page['meta_robots'])) ? print $page['meta_robots'] : ''; ?>">
        <meta name="generator" content="ModernCMS">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="<?php print site_root();?>/core/css/bootstrap.min.css" rel="stylesheet" media="screen">
        <link href="<?php print site_root();?>/core/css/font-awesome.min.css" rel="stylesheet" media="screen">
        <?php
        if($get_url[0] == 'login') {
            ?>
            <link href="<?php print site_root();?>/core/css/admin/framework.css" rel="stylesheet" media="screen">
            <link href="<?php print site_root();?>/core/css/login.css" rel="stylesheet" media="screen">
            <?php
        }
        else if($get_url[0] == 'admin') {
            ?>
            <link href="<?php print site_root();?>/core/css/core.css" rel="stylesheet" media="screen">
            <link href="<?php print site_root();?>/core/css/admin/framework.css" rel="stylesheet" media="screen">
            <link href="<?php print site_root();?>/core/css/admin.css" rel="stylesheet" media="screen">
            <link href="<?php print site_root();?>/core/css/bootstrap-switch.min.css" rel="stylesheet" media="screen">
            <link href="<?php print site_root();?>/core/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
            <?php
        }
        ?>
        
        <?php
        if($get_url[0] == 'admin') {
            ?>
        <link href="<?php print site_root();?>/core/css/dropdown-menu.css" rel="stylesheet" media="screen">
        <link href="<?php print site_root();?>/core/js/icheck/skins/flat/blue.css" rel="stylesheet" media="screen">
            <?php
        }
        ?>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="<?php print site_root();?>/core/js/bootstrap.min.js"></script>
        <script src="<?php print site_root();?>/core/js/modernizr-2.6.2-respond-1.1.0.min.js"></script>
        <script src="<?php print site_root();?>/core/js/bootstrap-switch.min.js" rel="stylesheet" media="screen"></script>
        <!-- <script src="<?php print site_root();?>/core/js/icheck/icheck.min.js"></script> -->
        <script src="<?php print site_root();?>/core/js/core.js"></script>
    </head>