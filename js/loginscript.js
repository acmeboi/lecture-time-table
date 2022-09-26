$(document).ready(function(){
	$('#userid').keyup(function(){
       var txt = $('#userid').val();
       $('#userid').val(txt.toUpperCase()); 
    });
	
	$('#login_form').on('submit', function(e){
            e.preventDefault();
			var userid = $('#userid').val();
			var password = $('#password').val();
			$.ajax({
				type: "POST",
				url: "processor.php?login_authentication",
				data: {userid:userid,password:password},
				success: function(login_result){
					if(login_result == "error"){
						$('#error').removeClass('w3-hide');
						}else{
							window.location="../Time_Table_scheduling System";
							}
					
					}
				}); 
      });
});