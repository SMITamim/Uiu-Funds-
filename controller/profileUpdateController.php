<?php
session_start();
include '../model/updateProfile.php';

$name = $email = $university_id = $semester = "";

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
}

if (!$flag) {
    $name = input_data($_POST['name']);
    $email = input_data($_POST['email']);
    $university_id = input_data($_POST['university_id']);
    $semester = input_data($_POST['semester']);
    include ('../model/authUser.php');
    $user = getAuthUser($_SESSION['university_id']);
    if($user['email'] === $email && $user['university_id'] === $university_id) {
        $result = updateUser($name, $university_id, $semester, $email, $_SESSION['id']);
        if ($result) {
            $_SESSION['university_id'] = $university_id;
            $_SESSION['update_profile_success_message'] = "Profile Update Successfully";
            header("location:../view/updateProfile.php");
            exit();
        } else {
            $_SESSION['update_profile_failed_message'] = "Profile Update Failed";
            header("location:../view/updateProfile.php");
            exit();
        }
    }else{
        $checkDuplacy = checkDupliacy($email,$university_id);
        if(!$checkDuplacy){
            $result = updateUser($name, $university_id, $semester, $email, $_SESSION['id']);
            if ($result) {
                $_SESSION['university_id'] = $university_id;
                //$_SESSION['update_profile_success_message'] = "Profile Update Successfully";
                header("location:../view/updateProfile.php");
                exit();
            } else {
                $_SESSION['update_profile_failed_message'] = "Profile Update Failed";
                header("location:../view/updateProfile.php");
                exit();
            }
        }else{
            $_SESSION['update_profile_failed_message'] = "Email/University ID exist";
            header("location:../view/updateProfile.php");
            exit();
        }
    }
} else {
    $_SESSION['update_profile_errors'] = $errors;
    header("location:../view/updateProfile.php");
    exit();
}



