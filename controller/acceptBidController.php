<?php
session_start();
include '../model/bidModal.php';

$id =  "";

$flag = false;

    $id = $_POST['bidId'];

    $result = updateBid($id,1);
    if ($result) {
        $_SESSION['bid_accept_request_success_message'] = "Bid Accepted Done";
        header("location:../view/dashboard.php");
        exit();
    } else {
        $_SESSION['bid_accept_request_failed_message'] = "Bid Accepted Failed";
        header("location:../view/dashboard.php");
        exit();
    }

?>


