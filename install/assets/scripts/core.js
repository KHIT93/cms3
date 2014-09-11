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
            form_id : $('input#form_id').val(),
            lang : $('input#lang').val()
            }, function(data){
            //$('.response').val(data);
            var returnJSON = JSON.parse(data);
            console.log('AJAX completed: '+data);
            $('p#ajax-label').html(returnJSON.label);
            $('p#ajax-msg').html(returnJSON.message);
            if($('.progress.progress-striped.active').length && returnJSON.status === true) {
                $('div.progress.progress-striped.active').removeClass('progress-striped active');
                $('div.progress div.progress-bar.progress-bar-info').removeClass('progess-bar-info').addClass('progress-bar-success');
            }
            if(returnJSON.next_url) {
                window.setTimeout(function () {
                    location.href = returnJSON.next_url;
                }, 1000)
            }
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