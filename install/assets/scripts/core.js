//Perform AJAX
$(document).ready(function(){
    /*var values = $(this).serialize();
    $.post('install/includes/ajax.install.php', {
        //JSON-object
        post_data : values
        }, function(data){
        $('.response').val(data);
    });*/
    if($('form#ajax-autoloader').length) {
        console.log('AJAX Autoloader is in effect');
        //$.post('install/includes/ajax.install.php', {
        $.post('submit.php', {
            //JSON-object
            form_id : $('input#form_id').val()
            }, function(data){
            //$('.response').val(data);
            console.log('AJAX completed'+data);
        });
    }
    else {
        console.log('AJAX Autoloader is not in effect');
    }
});
//status, percentage, message, label
//
//    $('.ajax_submit').click(function(){
//        $.post('install/includes/ajax.install.php', {
//            //JSON-object
//            person_name : $('.input').val()
//        }, function(data){
//            $('.response').val(data);
//        });
//    });