                </div>
            </div>
        </div>
        <script type="text/javascript" src="<?php print CORE_JS_PATH; ?>/jquery.nanoscroller/jquery.nanoscroller.min.js"></script>
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
        <script type="text/javascript" src="<?php print CORE_JS_PATH; ?>/jquery.codemirror/lib/codemirror.js"></script>
        <script type="text/javascript" src="<?php print CORE_JS_PATH; ?>/jquery.codemirror/addon/edit/matchbrackets.js"></script>
        <script type="text/javascript" src="<?php print CORE_JS_PATH; ?>/jquery.codemirror/addon/edit/matchtags.js"></script>
        <script type="text/javascript" src="<?php print CORE_JS_PATH; ?>/jquery.codemirror/mode/xml/xml.js"></script>
        <script type="text/javascript" src="<?php print CORE_JS_PATH; ?>/jquery.codemirror/addon/fold/xml-fold.js"></script>
        <script type="text/javascript" src="<?php print CORE_JS_PATH; ?>/jquery.codemirror/mode/css/css.js"></script>
        <script type="text/javascript" src="<?php print CORE_JS_PATH; ?>/jquery.codemirror/mode/htmlmixed/htmlmixed.js"></script>
        <script type="text/javascript" src="<?php print CORE_JS_PATH; ?>/jquery.codemirror/mode/javascript/javascript.js"></script>
        <script type="text/javascript" src="<?php print CORE_JS_PATH; ?>/jquery.codemirror/mode/sql/sql.js"></script>
        <script type="text/javascript" src="<?php print CORE_JS_PATH; ?>/jquery.codemirror/mode/php/php.js"></script>
        <script type="text/javascript" src="<?php print CORE_JS_PATH; ?>/jquery.codemirror/mode/shell/shell.js"></script>
        <script type="text/javascript">
            $(document).ready(function(){
                //initialize the javascript
                App.init();
            });
            <?php if(isset($editor) && $editor instanceof Editor) : ?>
            /*Codemirror*/
            var myCodeMirror = CodeMirror.fromTextArea(document.getElementById("code"), {
                lineNumbers: true,
                theme: 'ambiance',
                viewportMargin: 0,
                //mode:  "text/html",
                mode : "<?php print $editor->mode(); ?>",
                matchTags: {bothTags: true},
                lineWrapping: true
            });
            <?php endif; ?>
        </script>
        <script type="text/javascript" src="<?php print CORE_JS_PATH; ?>/jquery.flot/jquery.flot.js"></script>
        <script type="text/javascript" src="<?php print CORE_JS_PATH; ?>/jquery.flot/jquery.flot.pie.js"></script>
        <script type="text/javascript" src="<?php print CORE_JS_PATH; ?>/jquery.flot/jquery.flot.resize.js"></script>
        <script type="text/javascript" src="<?php print CORE_JS_PATH; ?>/jquery.flot/jquery.flot.labels.js"></script>
    </body>
</html>