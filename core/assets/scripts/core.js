//
//$(function() {
//    $(".bs-switch").bootstrapSwitch();
//    /*$('.bs-datetime').datetimepicker({
//      language: 'en',
//      pick12HourFormat: false
//    });*/
//  });
//$(document).ready(function(){
//  $('input').iCheck({
//    checkboxClass: 'icheckbox_flat',
//    radioClass: 'iradio_flat'
//  });
//});
$(document).ready(function(){
    $('form.ajax').on('submit', function() {
        var values = $(this).serialize();
        $.post('submit.php', {
            //JSON-object
            post_data : values
            }, function(data){
            $('.response').val(data);
        });
    });
});

$('.icheck').iCheck();
$(".bs-switch").bootstrapSwitch();