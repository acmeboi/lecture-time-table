<?php
header("Access-Control-Allow-Origin: *");
include('classes.php');
$db = new newclass();

$post = filter_input_array(INPUT_POST);
$get = filter_input_array(INPUT_GET);

if (isset($get['login_authentication'])) {
    $login = $db->login($post);
//    die(json_encode($login));
    if($login['status'] < 1) {
        die(json_encode($login));
        header('location: login.php');
    }else {
        session_start();
        $_SESSION['loger'] = $login['loger'];
        header('location: index.php');
    }
}

