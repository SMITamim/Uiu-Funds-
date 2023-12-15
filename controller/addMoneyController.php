<?php
session_start();
include '../model/authUser.php';
include '../model/updateProfile.php';

$addAmount = "";

$flag = false;

function input_data($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    //php validation
    if (empty($_POST['addAmount'])) {
        $flag = true;
    }
}

if (!$flag) {
    $addAmount = input_data($_POST['addAmount']);
    $user = getAuthUser($_SESSION['university_id']);
    $amount = $user['amount'] + $addAmount;
    updateAmount($_SESSION['university_id'],$amount);
     $_SESSION['add_money_success'] = 'Add Money Successfully';
    header("location:../view/donate.php");
} else {
    $_SESSION['add_money_error'] = 'Failed to add money';
    header("location:../view/donate.php");
    exit();
}
?>


