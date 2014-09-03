<?php if(http_response_code() == 200) {
    ?>
                </div>
                <hr>
            </div> <!-- /container -->
            <div class="container">
                <footer>
                    <p>&copy; <?php print date('Y').' ';?></p>
                </footer>
            </div>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
        <script src="/core/js/bootstrap.min.js"></script>
        <script src="/core/js/modernizr-2.6.2-respond-1.1.0.min.js"></script>
        <script src="/core/js/jquery.nanoscroller/jquery.nanoscroller.js" type="text/javascript"></script>
        <script src="/core/js/jquery.sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
        <script src="/core/js/jquery.easypiechart/jquery.easy-pie-chart.js" type="text/javascript"></script>
        <script src="/core/js/behaviour/general.js" type="text/javascript"></script>
        <script src="/core/js/jquery.ui/jquery-ui.js" type="text/javascript"></script>
        <script src="/core/js/jquery.nestable/jquery.nestable.js" type="text/javascript"></script>
        <script src="/core/js/bootstrap.switch/bootstrap-switch.min.js" type="text/javascript"></script>
        <script src="/core/js/bootstrap.datetimepicker/js/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
        <script src="/core/js/jquery.select2/select2.min.js" type="text/javascript"></script>
        <script src="/core/js/bootstrap.slider/js/bootstrap-slider.js" type="text/javascript"></script>
        <script src="/core/js/jquery.gritter/js/jquery.gritter.js" type="text/javascript"></script>
        <script type="text/javascript">
            $(document).ready(function(){
              //initialize the javascript
              App.init();
            });
        </script>
        <script type="text/javascript" src="/core/js/jquery.flot/jquery.flot.js"></script>
        <script type="text/javascript" src="/core/js/jquery.flot/jquery.flot.pie.js"></script>
        <script type="text/javascript" src="/core/js/jquery.flot/jquery.flot.resize.js"></script>
        <script type="text/javascript" src="/core/js/jquery.flot/jquery.flot.labels.js"></script>
        <script>
            var _gaq=[['_setAccount','UA-XXXXX-X'],['_trackPageview']];
            (function(d,t){var g=d.createElement(t),s=d.getElementsByTagName(t)[0];
            g.src='//www.google-analytics.com/ga.js';
            s.parentNode.insertBefore(g,s)}(document,'script'));
        </script>
    </body>
</html>
<?php } ?>