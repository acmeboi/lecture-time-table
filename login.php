<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>THE POLYTECHNIC BALI COURSE TIMETABLE</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />

<script src="js/jquery-3.1.1.min.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/loginscript.js"></script>
<style>
	.sidebarwidth{
		width:250px;
		}
	.margin_top{
		margin-top:20%;
	}
</style>
</head>

<body class="">
<div class="w3-container w3-margin">
<div id="" class="w3-modal w3-animate-opacity">
    <div class="w3-modal-content w3-card-8 w3-col l3 w3-round" style="left:40%;">
      <div class=" w3-center" style="top:3%;">
      <h3>--- System Login ---</h3>
      <hr />
      		<div class="w3-container alert-danger w3-padding w3-margin w3-round w3-hide" id="error">
            	Wrong StaffID or Password
				<div class="w3-large w3-closebtn" onclick="$('#error').addClass('w3-hide')">X</div>
            </div>
        <form class="w3-form" id="login_form" action="javascript:void(0)">
        <div class="w3-container">
        	<div class="w3-col l2 w3-padding">
            	<i class="fa fa-user w3-xlarge"></i>
            </div>
			<div class="w3-col l9">
            	<input type="text" class="w3-input" id="userid" placeholder="User ID" required  />
            </div>
        </div>
        	<br />
        <div class=" w3-container">
        	<div class="w3-col l2 w3-padding">
            	<i class="fa fa-key w3-xlarge"></i>
            </div>
			<div class="w3-col l9">
            	<input type="password" class="w3-input" id="password" placeholder="Password" required  />
            </div>
		</div>
        
        <hr />
        
			<button type="submit" class="btn btn-success" value="Save" id="save"><i class="fa fa-sign-in"></i>&nbsp;Login</button>
			<button type="reset" class="btn btn-danger" value="Reset"><i class="fa fa-repeat"></i>&nbsp;Reset</button>
		</form>
      </div>
      
    </div>
  </div>
</div>
</body>
</html>