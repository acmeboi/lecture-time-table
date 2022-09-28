<?php 
session_start();
if (isset($_SESSION['loger']) && !empty($_SESSION['loger'])) {
    $loger = $_SESSION['loger'];
    $department_id = $loger->department;
    $department_name = $loger->dpt_name;
    $logerType = $loger->type;
    $academic_session = "2017/2018";
} else {
    header('location:login.php');
}
?>