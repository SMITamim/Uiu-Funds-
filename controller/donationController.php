<?php
session_start();
include '../model/registrationModel.php';
include '../model/authUser.php';
include '../model/updateProfile.php';
include '../model/donationModel.php';

$donationAmount = "";

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
    if (empty($_POST['donationAmount'])) {
        $errors['donationAmount'] = "Donation Amount required";
        $flag = true;
    }
}

if (!$flag) {
    $donationAmount = input_data($_POST['donationAmount']);
    $user = getAuthUser($_SESSION['university_id']);
    if($donationAmount>$user['amount']){
        $_SESSION['donation_errors'] = 'Insufficient Balance';
        header("location:../view/donate.php");
        exit();
    }else{
        $result = donation($_SESSION['university_id'],$donationAmount);
        if($result){
            $amount = $user['amount'] - $donationAmount;
            updateAmount($_SESSION['university_id'],$amount);
            $_SESSION['donation_success'] = 'Fund Transfer Successfully';
            header("location:../view/donate.php");
            exit();
        }
        else{
            $_SESSION['donation_errors'] = 'You have to filled donation amount field';
            header("location:../view/donate.php");
            exit();
        }

    }
} else {
    $_SESSION['donation_errors'] = 'You have to filled donation amount field';
    header("location:../view/donate.php");
    exit();
}
?>


