//$(function() {
//     $("input#auth_mail").change(function() {
//         if($(this).is(":checked")) {
//             $("input#inputUsername, input#inputPassword").removeAttr("disabled");
//         }
//         else {
//             $("input#inputUsername, input#inputPassword").attr("disabled");
//         }
//     });
//});
//$(function() {
//    $("#auth_mail").change(function(){
//        var sm = $("#Username");
//        if($(this).is(":checked")){
//            sm.removeAttr('disabled');
//        }
//        else{
//            sm.attr('disabled','disabled');
//        }
//    });
//});
function mail_auth_check() {
     var auth_check = $("input#auth_mail:checkbox:checked").val();
     if(auth_check == "auth_yes") {
         $("input#inputUsername").removeAttr("disabled");
         $("input#inputPassword").removeAttr("disabled");
     }
     else {
         $("input#inputUsername").attr("disabled");
         $("input#inputPassword").attr("disabled");
     }
 }
$(function(){
    $("#inputUsername, #inputPassword").attr("disabled", 1);
     $("#auth_mail").change(function(){
         if($(this).is(':checked')) {
             $("#inputUsername, #inputPassword").removeAttr("disabled");
         } else {
             $("#inputUsername, #inputPassword").attr("disabled", 1);
         }
     });
 });