<?php 
session_start();
if(isset($_SESSION['user_id'])){
		$department_id = "1";
		$academic_session = "2017/2018";
	}else{
		header('location:login.php');
		}
?>