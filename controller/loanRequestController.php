<?php
session_start();
include '../model/loanModel.php';

$amount = $interest = $time_period = "";

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
    if (empty($_POST['amount'])) {
        $errors['amount'] = "Amount is required";
        $flag = true;
    }
    if (empty($_POST['interest'])) {
        $errors['interest'] = "Interest Percentage required";
        $flag = true;
    }
    if (empty($_POST['timePeriod'])) {
        $errors['timePeriod'] = "Time Period required";
        $flag = true;
    }
}

if (!$flag) {
    $amount = input_data($_POST['amount']);
    $interest = input_data($_POST['interest']);
    $time_period = input_data($_POST['timePeriod']).' weeks';
    $status = 0;

        $result = loanRequest($amount,$interest,$time_period,$_SESSION['university_id'],$status);
        if ($result) {
            $_SESSION['loan_request_success_message'] = "Loan Request Done";
            header("location:../view/dashboard.php");
            exit();
        } else {
            $_SESSION['loan_request_failed_message'] = "Loan Request Failed";
            header("location:../view/dashboard.php");
            exit();
        }

} else {
    $_SESSION['loan_request_errors'] = $errors;
    $_SESSION['submitted_data'] = array_map('input_data', $_POST);
    header("location:../view/dashboard.php");
    exit();
}
?>


