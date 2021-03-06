<?php
define('SITE_ROOT', getcwd());
include_once 'core/init.php';
include_once 'core/modules/krumo/class.krumo.php';
if(isset($_POST)) {
    krumo($_POST);
}
$form = array(
    '#name' => 'myForm',
    '#method' => 'POST',
    '#action' => '',
    '#attr' => array(
        'role' => 'form'
    ),
    'elements' =>array(
        /*'myHeaderMarkup' => */array(
            '#type' => 'markup',
            '#value' => '<h1>My Form</h1>'
        ),
        /*'myIntroMarkup' => */array(
            '#type' => 'markup',
            '#value' => '<p>Please fill in all the required <strong>fields</strong></p>'
        ),
        /*'textfield' => */array(
            '#type' => 'text',
            '#name' => 'myText',
            '#label' => 'This is a textfield label',
            '#default_value' => 'This is an optional default value',
            '#placeholder' => '',
            '#attr' => array(
                'class' => 'form-control',
                'id' => 'myTextField',
                'onfocus' => 'doSomething()'
            ),
            '#size' => 60,
            '#maxlength' => 255,
            '#required' => true,
            '#description' => 'This is a small helper text which will be displayed below the field',
            '#autocomplete' => false,
            '#disabled' => false,
        ),
        /*'textarea' => */array(
            '#type' => 'textarea',
            '#name' => 'myBody',
            '#default_value' => 'This is an optional default value',
            '#placeholder' => '',
            '#cols' => 60,
            '#rows' => 5,
            '#attr' => array(
                'class' => 'form-control'
            ),
            '#required' => true,
            '#description' => 'This is a small helper text which will be displayed below the field',
            '#disabled' => false,
            '#resizeable' => true,
            '#label' => 'This is a textarea label'
        ),
        /*'checkboxes' => */array(
            '#type' => 'checkbox',
            '#name' => 'myCheck',
            /*'#attr' => array(
                'class' => 'form-control'
            ),*/
            '#default_value' => 'value2',
            '#disabled' => false,
            '#description' => 'This is a small helper text which will be displayed below the field',
            '#options' => array(
                'value1' => 'Label for value1',
                'value2' => 'Label for value2',
                'value3' => 'Label for value3'
            ),
            '#required' => false,
            '#label' => 'This is a label/header for the checkbox group'
        ),
        /*'date' => */array(
            '#type' => 'date',
            '#name' => 'myDate',
            '#attr' => array(
                'class' => 'form-control'
            ),
            '#default_value' => date("Y-m-d"),
            '#description' => 'This is a small helper text which will be displayed below the field',
            '#disabled' => false,
            '#required' => false,
            '#label' => 'This is a date label'
        ),
        /*'file' => */array(
            '#type' => 'file',
            '#name' => 'myFile',
            '#attr' => array(
                'class' => 'form-control'
            ),
            '#description' => 'This is a small helper text which will be displayed below the field',
            '#disabled' => false,
            '#required' => false,
            '#size' => 60,
            '#label' => 'This is a file label'
        ),
        /*'password' => */array(
            '#type' => 'password',
            '#name' => 'myPassword',
            '#attr' => array(
                'class' => 'form-control'
            ),
            '#description' => 'This is a small helper text which will be displayed below the field',
            '#disabled' => false,
            '#maxlength' => 255,
            '#placeholder' => '',
            '#required' => true,
            '#size' => 60,
            '#label' => 'This is a password label'
        ),
        /*'radio' => */array(
            '#type' => 'radio',
            '#name' => 'myRadio',
            /*'#attr' => array(
                'class' => 'form-control'
            ),*/
            '#default_value' => 'value2',
            '#description' => 'This is a small helper text which will be displayed below the field',
            '#disabled' => false,
            '#options' => array(
                'value1' => 'label for value1',
                'value2' => 'label for value2',
                'value3' => 'label for value3'
            ),
            '#required' => false,
            '#label' => 'This is a label/header for the radio group'
        ),
        /*'select' => */array(
            '#type' => 'select',
            '#name' => 'mySelect',
            '#attr' => array(
                'class' => 'form-control'
            ),
            '#default_value' => 'value2',
            '#description' => 'This is a small helper text which will be displayed below the field',
            '#disabled' => false,
            '#empty_option' => '- Select -',
            '#empty_value' => 0,
            '#multiple' => false,
            '#options' => array(
                'value1' => 'label for value1',
                'value2' => 'label for value2',
                'value3' => 'label for value3'
            ),
            '#required' => false,
            /*'#size' => 5,*/
            '#label' => 'This is a label/header for the select group'
        ),
        /*'myMarkup' => */array(
            '#type' => 'markup',
            '#value' => '<p>This is some <strong>HTML</strong> <i>markup</i> in the form</p>'
        ),
        /*'pid' => */array(
            '#type' => 'hidden',
            '#attr' => array(
                'class' => 'form-hidden'
            ),
            '#name' => 'myToken',
            '#value' => 10,
            
        )
    ),
    'tabs' => array(
        /*'tab1' => */array(
            '#type' => 'tab',
            '#name' => 'myTab1',
            '#title' => 'My Tab 1',
            '#alignment' => 'top',
            '#attr' => array(
                'class' => 'form-wrapper'
            ),
            '#auto_open' => true,
            '#children' => array(
                /*'textfield' => */array(
                    '#type' => 'text',
                    '#name' => 'myTextField1',
                    '#label' => 'This is a textfield label',
                    '#default_value' => 'This is an optional default value',
                    '#placeholder' => '',
                    '#attr' => array(
                        'class' => 'form-control',
                        'id' => 'myTextField1',
                        'onfocus' => 'doSomething()'
                    ),
                    '#size' => 60,
                    '#maxlength' => 255,
                    '#required' => true,
                    '#description' => 'This is a small helper text which will be displayed below the field',
                    '#autocomplete' => false,
                    '#disabled' => false,
                ),
                /*'textfield' => */array(
                    '#type' => 'text',
                    '#name' => 'myTextField2',
                    '#label' => 'This is a textfield label',
                    '#default_value' => 'This is an optional default value',
                    '#placeholder' => '',
                    '#attr' => array(
                        'class' => 'form-control',
                        'id' => 'myTextField2',
                        'onfocus' => 'doSomething()'
                    ),
                    '#size' => 60,
                    '#maxlength' => 255,
                    '#required' => true,
                    '#description' => 'This is a small helper text which will be displayed below the field',
                    '#autocomplete' => false,
                    '#disabled' => false,
                ),
                /*'textfield' => */array(
                    '#type' => 'text',
                    '#name' => 'myTextField3',
                    '#label' => 'This is a textfield label',
                    '#default_value' => 'This is an optional default value',
                    '#placeholder' => '',
                    '#attr' => array(
                        'class' => 'form-control',
                        'id' => 'myTextField3',
                        'onfocus' => 'doSomething()'
                    ),
                    '#size' => 60,
                    '#maxlength' => 255,
                    '#required' => true,
                    '#description' => 'This is a small helper text which will be displayed below the field',
                    '#autocomplete' => false,
                    '#disabled' => false,
                ),
            ),
            '#label' => 'This is a label for the container'
        ),
        /*'tab2' => */array(
            '#type' => 'tab',
            '#name' => 'myTab2',
            '#title' => 'My Tab 2',
            /*'#alignment' => 'top, left, right, bottom',*/
            '#alignment' => 'top',
            '#attr' => array(
                'class' => 'form-wrapper'
            ),
            '#children' => array(
                /*'textfield' => */array(
                    '#type' => 'text',
                    '#name' => 'myTextField4',
                    '#label' => 'This is a textfield label',
                    '#default_value' => 'This is an optional default value',
                    '#placeholder' => '',
                    '#attr' => array(
                        'class' => 'form-control',
                        'id' => 'myTextField4',
                        'onfocus' => 'doSomething()'
                    ),
                    '#size' => 60,
                    '#maxlength' => 255,
                    '#required' => true,
                    '#description' => 'This is a small helper text which will be displayed below the field',
                    '#autocomplete' => false,
                    '#disabled' => false,
                ),
                /*'textfield' => */array(
                    '#type' => 'text',
                    '#name' => 'myTextField5',
                    '#label' => 'This is a textfield label',
                    '#default_value' => 'This is an optional default value',
                    '#placeholder' => '',
                    '#attr' => array(
                        'class' => 'form-control',
                        'id' => 'myTextField5',
                        'onfocus' => 'doSomething()'
                    ),
                    '#size' => 60,
                    '#maxlength' => 255,
                    '#required' => true,
                    '#description' => 'This is a small helper text which will be displayed below the field',
                    '#autocomplete' => false,
                    '#disabled' => false,
                ),
                /*'textfield' => */array(
                    '#type' => 'text',
                    '#name' => 'myTextField6',
                    '#label' => 'This is a textfield label',
                    '#default_value' => 'This is an optional default value',
                    '#placeholder' => '',
                    '#attr' => array(
                        'class' => 'form-control',
                        'id' => 'myTextField6',
                        'onfocus' => 'doSomething()'
                    ),
                    '#size' => 60,
                    '#maxlength' => 255,
                    '#required' => true,
                    '#description' => 'This is a small helper text which will be displayed below the field',
                    '#autocomplete' => false,
                    '#disabled' => false,
                ),
            ),
            '#label' => 'This is a label for the 2nd container'
        )
    ),
    'actions' => array(
        'submit' => array(
            '#type' => 'submit',
            '#attr' => array(
                'class' => 'btn btn-default btn-sm btn-success'
            ),
            '#name' => 'mySubmit',
            '#value' => 'Submit'
        )
    )
);
$screen = new Form($form);
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="generator" content="ModernCMS">
        <title>Form Testing - KHansen IT</title>
        <meta name="description" content="This is the homepage">
        <meta name="description" content="home">
        <meta name="robots" content="index,follow">
        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,400italic,700,800' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Raleway:300,200,100' rel='stylesheet' type='text/css'>
        <link href="<?php print CORE_CSS_PATH;?>/bootstrap.min.css" rel="stylesheet" type="text/css" media="screen">
        <link href="<?php print CORE_JS_PATH;?>/jquery.gritter/css/jquery.gritter.css" rel="stylesheet" type="text/css">
        <link href="<?php print CORE_CSS_PATH;?>/font-awesome.min.css" rel="stylesheet" type="text/css" media="screen">
        <link href="<?php print CORE_JS_PATH;?>/jquery.nanoscroller/nanoscroller.css" rel="stylesheet" type="text/css" >
        <link href="<?php print CORE_JS_PATH;?>/jquery.easypiechart/jquery.easy-pie-chart.css" rel="stylesheet" type="text/css" >
        <link href="<?php print CORE_JS_PATH;?>/bootstrap.switch/bootstrap-switch.css" rel="stylesheet" type="text/css" >
        <link href="<?php print CORE_JS_PATH;?>/bootstrap.datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" type="text/css" >
	<link href="<?php print CORE_JS_PATH;?>/jquery.select2/select2.css" rel="stylesheet" type="text/css" >
        <link href="<?php print CORE_JS_PATH;?>/bootstrap.slider/css/slider.css" rel="stylesheet" type="text/css" >
        <link href="<?php print CORE_CSS_PATH;?>/core.css" rel="stylesheet" type="text/css" media="screen">
        <link href="<?php print CORE_JS_PATH;?>/jquery.icheck/skins/square/blue.css" rel="stylesheet">
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
        <script src="<?php print CORE_JS_PATH;?>/bootstrap/bootstrap.min.js"></script>
        <script src="<?php print CORE_JS_PATH;?>/modernizr/modernizr.min.js"></script>
        <link rel="shortcut icon" href="<?php print CORE_IMG_PATH;?>/favicon.png">
    </head>
    <body>
    <!--[if lt IE 7]>
        <p class="chromeframe">You are using an <strong>outdated</strong> browser Please <a href="http://browsehappy.com/"> upgrade your browser</a> or <a href="http://www.google.com/chromeframe/?redirect=true">activate Google Chrome Frame</a> to improve your experience.</p>
    <![endif]-->

    <!-- This code is taken from http://twitter.github.com/bootstrap/examples/hero.html  -->
    <div class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
                <div class="navbar-header">
                    <button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a href="/pages/1" class="navbar-brand">KHansen IT</a>
                </div>
                <div class="collapse navbar-collapse">
                    <div id="section-header">
<div class="widget" id="widget-1">
<ul class="nav navbar-nav"><li class="active"><a href="/home">Home</a></li><li><a href="/contact-us">Contact</a><ul class="dropdown-menu"><li><a href="/social-media">Social media</a></li></ul></li></ul>
</div>
</div>
                </div><!--/.nav-collapse -->
            </div>
    </div>
    <div class="container" id="main-content">
        <div class="row">
            <div class="col-md-12">
                <div id="section-content">
<div class="widget" id="widget-primary-content">
<p>This is the form test page</p>
<?php
krumo($form);
print $screen->render();
?>
</div>
</div>
            </div>
        </div>
        <hr>
    </div> <!-- /container -->
    <div id="admin-toolbox-wrapper">
	<div class="admin-toolbox-item-wrapper" role="alert">
            <div class="admin-toolbox-top"></div>
            <div class="admin-toolbox-item">
                <div class="admin-toolbox-without-image">
                    <span class="admin-toolbox-title">Kenneth Hansen</span>
                    <ul class="nav navbar-nav">
                        <li><a href="/admin/content"><i class="fa fa-file fa-lg"></i></a></li>
                        <li><a href="/admin/layout"><i class="fa fa-picture-o fa-lg"></i></a></li>
                        <li><a href="/admin/users"><i class="fa fa-user fa-lg"></i></a></li>
                        <li><a href="/admin/help"><i class="fa fa-question fa-lg"></i></a></li>
                        <li><a href="/logout"><i class="fa fa-power-off fa-lg"></i></a></li>
                    </ul>
                </div>
                <div style="clear:both"></div>
            </div>
            <div class="admin-toolbox-bottom"></div>
        </div>
    </div>
    <script type="text/javascript" src="<?php print CORE_JS_PATH; ?>/jquery.nanoscroller/jquery.nanoscroller.js"></script>
        <script type="text/javascript" src="<?php print CORE_JS_PATH; ?>/jquery.sparkline/jquery.sparkline.min.js"></script>
        <script type="text/javascript" src="<?php print CORE_JS_PATH; ?>/jquery.easypiechart/jquery.easy-pie-chart.js"></script>
        <script src="<?php print CORE_JS_PATH; ?>/jquery.ui/jquery-ui.js" type="text/javascript"></script>
        <script type="text/javascript" src="<?php print CORE_JS_PATH; ?>/jquery.nestable/jquery.nestable.js"></script>
        <script type="text/javascript" src="<?php print CORE_JS_PATH; ?>/bootstrap.switch/bootstrap-switch.min.js"></script>
        <script type="text/javascript" src="<?php print CORE_JS_PATH; ?>/bootstrap.datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
        <script src="<?php print CORE_JS_PATH; ?>/jquery.select2/select2.min.js" type="text/javascript"></script>
        <script src="<?php print CORE_JS_PATH; ?>/bootstrap.slider/js/bootstrap-slider.js" type="text/javascript"></script>
        <script type="text/javascript" src="<?php print CORE_JS_PATH; ?>/jquery.gritter/js/jquery.gritter.js"></script>
        <script type="text/javascript" src="<?php print CORE_JS_PATH; ?>/jquery.icheck/icheck.min.js"></script>
        <script type="text/javascript" src="<?php print CORE_JS_PATH; ?>/behaviour/general.js"></script>
        <script type="text/javascript" src="<?php print CORE_JS_PATH; ?>/core.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
              //initialize the javascript
              App.init();
            });
        </script>
        <script type="text/javascript" src="<?php print CORE_JS_PATH; ?>/jquery.flot/jquery.flot.js"></script>
        <script type="text/javascript" src="<?php print CORE_JS_PATH; ?>/jquery.flot/jquery.flot.pie.js"></script>
        <script type="text/javascript" src="<?php print CORE_JS_PATH; ?>/jquery.flot/jquery.flot.resize.js"></script>
        <script type="text/javascript" src="<?php print CORE_JS_PATH; ?>/jquery.flot/jquery.flot.labels.js"></script>
    <div class="container">
        <div id="section-footer">
<div class="widget" id="widget-3">
<p>&copy; 2014 SITE NAME</p>
</div>
</div>
    </div>
        <script>
        var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
        (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
        g.src='//www.google-analytics.com/ga.js';
        s.parentNode.insertBefore(g,s)}(document,'script'));
    </script>
    </body>
</html>