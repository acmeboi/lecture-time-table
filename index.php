<?php include('session.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>THE POLYTECHNIC BALI COURSE TIMETABLE</title>
<link href="css/style.css" rel="stylesheet" type="text/css" />
<link href="css/font-awesome.css" rel="stylesheet" type="text/css" />
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />

<script src="js/jquery-3.1.1.min.js"></script>
<script src="js/script.js"></script>
<script src="js/bootstrap.min.js"></script>
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
<div id="main">
<nav class="w3-sidenav w3-collapse w3-white  w3-animate-left sidebarwidth w3-border-right" id="mySidenav">
	<a href="#" class=" w3-container w3-center w3-padding w3-green" id="banner">
    <p><small>THE POLYTECHNIC BALI</small><span class="w3-opennav w3-large w3-hide-large w3-right" onclick="w3_open()">X</span></p> 
	<img class="w3-white w3-round-jumbo" src="Image/logo.png" style=" margin-bottom:-15%;" />
	</a>
  <br /><br />
  <a href="index.php" class="w3-padding w3-border-bottom w3-border-green w3-text-green" >Dashboard</a>
  <a href="add_view_department.php" class="w3-padding w3-border-bottom w3-border-green w3-text-green">Add School</a>
  <a href="add_view_department.php" class="w3-padding w3-border-bottom w3-border-green w3-text-green">Add Department</a>
  <a href="reg_view_staff.php" class="w3-padding w3-border-bottom w3-border-green w3-text-green" >Register/View Staff</a>
  <a href="add_view_courses.php" class="w3-padding w3-border-bottom w3-border-green w3-text-green">Add/View Courses</a>
  <a href="courses_allocation.php" class="w3-padding w3-border-bottom w3-border-green w3-text-green">Courses Allocation</a>
  <a href="time_table_schedulling.php" class="w3-padding w3-border-bottom w3-border-green w3-text-green">Schedul Time Table</a>
  <a href="print_timetable.php" class="w3-padding w3-border-bottom w3-border-green w3-text-green">Print Time Table</a>
   <a href="logout.php" class="w3-padding w3-border-bottom w3-border-green w3-text-green">Logout</a>
</nav>

<div class="left_container">
<header class="w3-container w3-green">
<div class="w3-container w3-center w3-padding w3-green" >
    <p id="header">
    <span  class="w3-hide-large w3-large">THE POLYTECHNIC BALI</span>
    <span class="w3-opennav w3-xxlarge w3-hide-large w3-right" onclick="w3_open()">&#9776;</span>
    <h5><span id="header_text" style="text-transform:uppercase;">THE POLYTECHNIC BALI COURSE TIMETABLE</span></h5>
    </p> 
</div>
   
</header>

<div class="w3-container w3-margin w3-padding-12 w3-border w3-border-green w3-round alert-success">
	<div class="w3-container w3-col l7"><i class="fa fa-dashboard w3-xlarge"></i> &nbsp;Dashboard</div>
    <div class="w3-col l5" id="loger_name">Uthman Zunnurain Muhammad</div>
</div>

<div class="w3-margin">
<div class="w3-col l7">
	<div class=" w3-col l6 w3-padding w3-pink w3-center w3-hover-opacity">
		<i class="fa fa-folder-open w3-xxxlarge"></i>
			<br />
			Numbers of registered Staff<br />
            <span id="registered_staff"></span>
	</div>
	<div class="w3-col l6 w3-padding w3-indigo w3-center w3-hover-opacity">
    	<i class="fa fa-home w3-xxxlarge"></i>
        	<br />
			Number of Department added<br />
            <span id="department_added"></span>
    </div>
	<div class=" w3-col l6 w3-padding w3-indigo w3-center w3-hover-opacity">
		<i class="fa fa-book w3-xxxlarge"></i>
        	<br />
			Number of Courses added<br />
            <span id="courses_added"></span>
    </div>
	<div class="w3-col l6 w3-padding w3-purple w3-center w3-hover-opacity">
    	<i class="fa fa-user w3-xxxlarge"></i>
    		<br />
			Online Users<br />
            <span id="user_of_system">(2)</span>
    </div>
    
</div>

<div class="w3-col l4 w3-margin-left" >
	<div class="w3-green">
					 <div class="cal1 cal_2"><div class="clndr"><div class="clndr-controls"><div class="clndr-control-button"><p class="clndr-previous-button">previous</p></div><div class="month">July 2015</div><div class="clndr-control-button rightalign"><p class="clndr-next-button">next</p></div></div><table class="clndr-table" border="0" cellspacing="0" cellpadding="0"><thead><tr class="header-days"><td class="header-day">S</td><td class="header-day">M</td><td class="header-day">T</td><td class="header-day">W</td><td class="header-day">T</td><td class="header-day">F</td><td class="header-day">S</td></tr></thead><tbody><tr><td class="day adjacent-month last-month calendar-day-2015-06-28"><div class="day-contents">28</div></td><td class="day adjacent-month last-month calendar-day-2015-06-29"><div class="day-contents">29</div></td><td class="day adjacent-month last-month calendar-day-2015-06-30"><div class="day-contents">30</div></td><td class="day calendar-day-2015-07-01"><div class="day-contents">1</div></td><td class="day calendar-day-2015-07-02"><div class="day-contents">2</div></td><td class="day calendar-day-2015-07-03"><div class="day-contents">3</div></td><td class="day calendar-day-2015-07-04"><div class="day-contents">4</div></td></tr><tr><td class="day calendar-day-2015-07-05"><div class="day-contents">5</div></td><td class="day calendar-day-2015-07-06"><div class="day-contents">6</div></td><td class="day calendar-day-2015-07-07"><div class="day-contents">7</div></td><td class="day calendar-day-2015-07-08"><div class="day-contents">8</div></td><td class="day calendar-day-2015-07-09"><div class="day-contents">9</div></td><td class="day calendar-day-2015-07-10"><div class="day-contents">10</div></td><td class="day calendar-day-2015-07-11"><div class="day-contents">11</div></td></tr><tr><td class="day calendar-day-2015-07-12"><div class="day-contents">12</div></td><td class="day calendar-day-2015-07-13"><div class="day-contents">13</div></td><td class="day calendar-day-2015-07-14"><div class="day-contents">14</div></td><td class="day calendar-day-2015-07-15"><div class="day-contents">15</div></td><td class="day calendar-day-2015-07-16"><div class="day-contents">16</div></td><td class="day calendar-day-2015-07-17"><div class="day-contents">17</div></td><td class="day calendar-day-2015-07-18"><div class="day-contents">18</div></td></tr><tr><td class="day calendar-day-2015-07-19"><div class="day-contents">19</div></td><td class="day calendar-day-2015-07-20"><div class="day-contents">20</div></td><td class="day calendar-day-2015-07-21"><div class="day-contents">21</div></td><td class="day calendar-day-2015-07-22"><div class="day-contents">22</div></td><td class="day calendar-day-2015-07-23"><div class="day-contents">23</div></td><td class="day calendar-day-2015-07-24"><div class="day-contents">24</div></td><td class="day calendar-day-2015-07-25"><div class="day-contents">25</div></td></tr><tr><td class="day calendar-day-2015-07-26"><div class="day-contents">26</div></td><td class="day calendar-day-2015-07-27"><div class="day-contents">27</div></td><td class="day calendar-day-2015-07-28"><div class="day-contents">28</div></td><td class="day calendar-day-2015-07-29"><div class="day-contents">29</div></td><td class="day calendar-day-2015-07-30"><div class="day-contents">30</div></td><td class="day calendar-day-2015-07-31"><div class="day-contents">31</div></td><td class="day adjacent-month next-month calendar-day-2015-08-01"><div class="day-contents">1</div></td></tr></tbody></table></div></div>
			  <!----Calender -------->
			<link rel="stylesheet" href="css/clndr.css" type="text/css" />
			<script src="js/underscore-min.js" type="text/javascript"></script>
			<script src= "js/moment-2.2.1.js" type="text/javascript"></script>
			<script src="js/clndr.js" type="text/javascript"></script>
			<script src="js/site.js" type="text/javascript"></script>
			<!----End Calender -------->
			</div>
</div>
</div>

<footer class="w3-container w3-bottom alert-success w3-border-green w3-border-top">
  <h5 class="">By ST/CS/HND/20/002</h5>

</footer>
     
</div>

<script src="js/jquery.dataTables.min.js"></script>
<script src="js/dataTables.bootstrap.min.js"></script>
<script>
function w3_open() {
    $('#mySidenav').slideToggle();
	$('#header').slideToggle('w3-text-green');
	$('#header_text').slideToggle('w3-text-green')
}
</script>
</div>
</body>
</html>