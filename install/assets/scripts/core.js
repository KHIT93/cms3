//Perform AJAX
$(document).ready(function(){
    var values = $(this).serialize();
    $.post('install/includes/ajax.install.php', {
        //JSON-object
        post_data : values
        }, function(data){
        $('.response').val(data);
    });
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