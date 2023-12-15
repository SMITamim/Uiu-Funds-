<?php
session_start();
include '../model/bidModal.php';
include '../model/authUser.php';
$lender_id = $borrower_id = $post_id = $proposed_amount = $proposed_interest = $proposed_time_period ="";

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
        $errors['amount'] = "Proposed Amount required";
        $flag = true;
    }
    if (empty($_POST['interest'])) {
        $errors['interest'] = "Proposed Interest required";
        $flag = true;
    }
    if (empty($_POST['timePeriod'])) {
        $errors['timePeriod'] = "Proposed time period required";
        $flag = true;
    }
}

if (!$flag) {
    $post_id = input_data($_POST['postId']);
    $borrower_id = input_data($_POST['borrower_id']);
    $proposed_amount = input_data($_POST['amount']);
    $proposed_interest = input_data($_POST['interest']);
    $proposed_time_period = input_data($_POST['timePeriod']).' weeks';
    $lender_id = $_SESSION['university_id'];
    $prevBidInThisPost = multipleBidInAPost($lender_id,$post_id);
    $status = 0;
    if(!$prevBidInThisPost){
        $user = getAuthUser($lender_id);
        if($user['amount']>=$proposed_amount) {
            $result = proposalBid($lender_id, $borrower_id, $post_id, $proposed_amount, $proposed_interest, $proposed_time_period, $status);
            if ($result) {
                header("location:../view/dashboard.php");
                $_SESSION['bid_success_message'] = "Bid Done Successfully";
                exit();
            } else {
                $_SESSION['bid_failed_message'] = "Bid Failed";
                header("location:../view/dashboard.php");
                exit();
            }
        }else{
            $_SESSION['bid_failed_message'] = "Insufficient balance to bid";
            header("location:../view/dashboard.php");
            exit();
        }
    }else{
        $_SESSION['bid_failed_message'] = "You already bid on this post";
        header("location:../view/dashboard.php");
        exit();
    }


} else {
    $_SESSION['bid_failed_message'] = "You have to fill all data";
    header("location:../view/dashboard.php");
    exit();
}
?>


