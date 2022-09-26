$(document).ready(function(){
	$.ajax({
		url: "session.php?section_start",
		success: function(result){
			if(result == "error"){
				window.location = "login.php";
				}else{
					alert(result);
					}
			}
	});
});