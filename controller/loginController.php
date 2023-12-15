<?php
session_start();
include '../model/loginModel.php';
$email = $pass = "";
$flag = false;
$errors = array();
function input_data($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
if ($_SERVER['REQUEST_METHOD']==="POST"){
    if (empty($_POST['email'])) {
        $errors['email'] = "Email is required";
        $flag = true;
    }
    if (empty($_POST['password'])) {
        $errors['password'] = "Password is required";
        $flag = true;
    }
}
if (!$flag){
    $email = input_data($_POST['email']);
    $pass = input_data($_POST['password']);
    $res = login($email,$pass);
    if($res){
        $_SESSION['id'] = $res['id'];
        $_SESSION['university_id'] = $res['university_id'];
        header("location:../view/dashboard.php");
    }
    else{
        $_SESSION['login_failed_message'] = "Invalid Email/Password";
        $_SESSION['submitted_data'] = array_map('input_data', $_POST);
        header("location:../view/login.php");
        exit();
    }
}else{
    $_SESSION['login_errors'] = $errors;
    $_SESSION['submitted_data'] = array_map('input_data', $_POST);
    header("location:../view/login.php");
    exit();
}
?>