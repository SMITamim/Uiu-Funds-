<?php
session_start();
include '../model/registrationModel.php';

$name = $email = $university_id = $semester = $password = "";

$flag = false;
$errors = array();

function input_data($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //php validation
    if (empty($_POST['name'])) {
        $errors['name'] = "Name is required";
        $flag = true;
    }
    if (empty($_POST['email'])) {
        $errors['email'] = "Email is required";
        $flag = true;
    }
    if (empty($_POST['university_id'])) {
        $errors['university_id'] = "University ID is required";
        $flag = true;
    }
    if (empty($_POST['semester'])) {
        $errors['semester'] = "Semester is required";
        $flag = true;
    }
    if (empty($_POST['password'])) {
        $errors['password'] = "Password is required";
        $flag = true;
    }
}

if (!$flag) {
    $name = input_data($_POST['name']);
    $email = input_data($_POST['email']);
    $university_id = input_data($_POST['university_id']);
    $semester = input_data($_POST['semester']);
    $amount = 0;
    $password = input_data($_POST['password']);
//sleep(40);
    $check = get($email, $university_id);
    if (!$check) {
        $result = register($name,$email,$university_id,$semester,$amount,$password);
        if ($result) {
            header("location:../view/login.php");
        } else {
            $_SESSION['registration_failed_message'] = "Registration Failed";
            header("location:../view/registration.php");
            exit();
        }
    } else {
        $_SESSION['registration_failed_message'] = "Email/University ID Already Exist";
        $_SESSION['submitted_data'] = array_map('input_data', $_POST);
        header("location:../view/registration.php");
        exit();
    }

} else {
    $_SESSION['registration_errors'] = $errors;
    $_SESSION['submitted_data'] = array_map('input_data', $_POST);
    header("location:../view/registration.php");
    exit();
}
?>


