$(document).ready(function(){
    $('#userid').keyup(function () {
        var txt = $('#userid').val();
        $('#userid').val(txt.toUpperCase());
    });
    
//    $('form').submit(function(e) {
//        var userid = $('#userid').val();
//        var password = $('#password').val();
//        $.ajax({
//            type: "POST",
//            url: "processor.php?login_authentication",
//            data: {userid: userid, password: password},
//            contentType: "application/json; charset=utf-8",
//            success: function (login_result) {
//                alert(login_result);
//                console.log(login_result);
////                var json = JSON.stringify(login_result);
////                alert(json); 
////                if (!login_result) {
////                    $('#error').removeClass('w3-hide');
////                } else {
////                    window.location = "./";
////                }
//
//            }
//        });
//    });
	
    $('#login_form').on('submit', function () {
//        e.preventDefault();
        var userid = $('#userid').val();
        var password = $('#password').val();
        alert(userid);
        $.ajax({
            type: "POST",
            url: "processor.php?login_authentication",
            data: {userid: userid, password: password},
            contentType: "application/json; charset=utf-8",
            success: function (login_result) {
                console.log(login_result);
//                var json = JSON.stringify(login_result);
//                alert(json); 
//                if (!login_result) {
//                    $('#error').removeClass('w3-hide');
//                } else {
//                    window.location = "./";
//                }

            }
        });
    });
});