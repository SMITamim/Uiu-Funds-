<?php
session_start();
include '../model/bidModal.php';
include '../model/authUser.php';
include '../model/loanModel.php';
include '../model/updateProfile.php';

$id =  "";

$flag = false;

$id = $_POST['paybidId'];
$amount = $_POST['payAmount'];
$bid = searchBid($id);

$lender = getAuthUser($_SESSION['university_id']);
$borrower = getAuthUser($bid['borrower_id']);
if($lender['amount']>=$amount) {
    $result = updateBid($id, 2);
    if ($result) {
        updatePost(1, $bid['post_id']);
        $lenderAmount = $lender['amount'] - $amount;
        updateAmount($lender['university_id'],$lenderAmount);
        $borrowerAmmount = $borrower['amount'] + $amount;
        updateAmount($borrower['university_id'],$borrowerAmmount);
        $_SESSION['pay_loan_success_message'] = "Loan Payment Done";
        header("location:../view/dashboard.php");
        exit();
    } else {
        $_SESSION['pay_loan_failed_message'] = "Failed to pay loan";
        header("location:../view/dashboard.php");
        exit();
    }
}else{
    $_SESSION['pay_loan_failed_message'] = "Insufficient balance to post";
    header("location:../view/dashboard.php");
    exit();
}

?>


