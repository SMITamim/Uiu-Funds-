<?php
session_start();
include '../model/bidModal.php';
include '../model/authUser.php';
include '../model/loanModel.php';
$lender_id = $borrower_id = $post_id = "";

function input_data($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

    $post_id = input_data($_POST['upostId']);
    $borrower_id = input_data($_POST['uborrower_id']);
    $lender_id = $_SESSION['university_id'];
    $status = 0;
    $prevBidInThisPost = multipleBidInAPost($lender_id,$post_id);
    if(!$prevBidInThisPost) {
        $searchPost = searchPost($post_id);
        $user = getAuthUser($lender_id);
        if($user['amount']>=$searchPost['amount']) {
            $result = bid($lender_id, $borrower_id, $post_id, $status);
            if ($result) {
                header("location:../view/dashboard.php");
                $_SESSION['bid_success_message'] = "Bid Done Successfully";
                exit();
            } else {
                $_SESSION['bid_failed_message'] = "Bid Failed";
                header("location:../view/dashboard.php");
                exit();
            }
        }
        else{
            $_SESSION['bid_failed_message'] = "Insufficient balance to bid";
            header("location:../view/dashboard.php");
            exit();
        }
    }else{
        $_SESSION['bid_failed_message'] = "You already bid on this post";
        header("location:../view/dashboard.php");
        exit();
    }

?>


