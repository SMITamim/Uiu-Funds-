<?php
include_once '../model/dbConnect.php';
function proposalBid($lender_id,$borrower_id,$post_id,$proposed_amount,$proposed_interest,$proposed_time_period,$status){
    $conn = connect();
    $stmt = $conn->prepare("INSERT INTO bid(lender_id,borrower_id,post_id,proposed_amount,proposed_interest,proposed_time_period,status) VALUES (?,?,?,?,?,?,?)") ;
    $stmt->bind_param("sssssss",$lender_id,$borrower_id,$post_id,$proposed_amount,$proposed_interest,$proposed_time_period,$status);
    $res = $stmt->execute();
    return $res;
}
function bid($lender_id,$borrower_id,$post_id,$status){
    $conn = connect();
    $stmt = $conn->prepare("INSERT INTO bid(lender_id,borrower_id,post_id,status) VALUES (?,?,?,?)") ;
    $stmt->bind_param("ssss",$lender_id,$borrower_id,$post_id,$status);
    $res = $stmt->execute();
    return $res;
}
function multipleBidInAPost($lender_id,$post_id){
    $conn = connect();
    $query = $conn->prepare("SELECT * FROM bid WHERE lender_id = ? and post_id = ?");
    $query->bind_param("ss",$lender_id,$post_id);
    $query->execute();
    $result = $query->get_result();
    return $result->fetch_assoc();
}
function proposedBidOffer(){
    $status = 0;
    $conn = connect();
    $stmt = $conn->prepare("SELECT * FROM bid WHERE status = ? and borrower_id = ?");
    $stmt->bind_param("ss", $status,$_SESSION['university_id']);
    $stmt->execute();
    $record = $stmt->get_result();
    return $record->fetch_all(MYSQLI_ASSOC);
}
function updateBid($id,$status){
    $conn = connect();
    $stmt = $conn->prepare("UPDATE bid SET status = ? WHERE id = ?");
    $stmt->bind_param("ss",$status,$id);
    $res = $stmt->execute();
    return $res;
}
function showAcceptedBid(){
    $status = 1;
    $conn = connect();
    $stmt = $conn->prepare("SELECT * FROM bid WHERE status = ? and lender_id = ?");
    $stmt->bind_param("ss", $status,$_SESSION['university_id']);
    $stmt->execute();
    $record = $stmt->get_result();
    return $record->fetch_all(MYSQLI_ASSOC);
}
function searchBid($id){
    $conn = connect();
    $query = $conn->prepare("SELECT * FROM bid WHERE id = ?");
    $query->bind_param("s",$id);
    $query->execute();
    $result = $query->get_result();
    return $result->fetch_assoc();

}