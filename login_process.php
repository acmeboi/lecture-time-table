<?php
header("Access-Control-Allow-Origin: *");
include('classes.php');
$db = new newclass();

$post = filter_input_array(INPUT_POST);
$get = filter_input_array(INPUT_GET);

if (isset($get['login_authentication'])) {
    $login = $db->login($post);
    die(json_encode($login));
//    echo json_encode($login);
//    if (!$login['status']) {
//        echo false;
//    } else {
//        session_start();
//        $_SESSION['loger'] = $login['record'];
//        echo true;
//    }
}

