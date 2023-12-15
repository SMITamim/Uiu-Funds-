<?php
include_once '../model/dbConnect.php';
function loanRequest($amount,$interest,$timePeriod,$university_id,$status){
    $conn = connect();
    $stmt = $conn->prepare("INSERT INTO post(user_id,amount,interest,timePeriod,status) VALUES (?,?,?,?,?)") ;
    $stmt->bind_param("sssss",$university_id,$amount,$interest,$timePeriod,$status);
    $res = $stmt->execute();
    return $res;
}
function getRequest(){
    $status = 0;
    $conn = connect();
    $stmt = $conn->prepare("SELECT * FROM post WHERE user_id != ? and status = ? ORDER BY id DESC");
    $stmt->bind_param("ss", $_SESSION['university_id'],$status);
    $stmt->execute();
    $record = $stmt->get_result();
    return $record->fetch_all(MYSQLI_ASSOC);
}
function searchPost($id){
    $conn = connect();
    $query = $conn->prepare("SELECT * FROM post WHERE id = ?");
    $query->bind_param("s",$id);
    $query->execute();
    $result = $query->get_result();
    return $result->fetch_assoc();
}
function updatePost($status,$id){
    $conn = connect();
    $stmt = $conn->prepare("UPDATE post SET status = ? WHERE id = ?");
    $stmt->bind_param("ss",$status,$id);
    $res = $stmt->execute();
    return $res;
}
function myRequest(){
    $status = 0;
    $conn = connect();
    $stmt = $conn->prepare("SELECT * FROM post WHERE user_id = ? and status = ?");
    $stmt->bind_param("ss", $_SESSION['university_id'],$status);
    $stmt->execute();
    $record = $stmt->get_result();
    return $record->fetch_all(MYSQLI_ASSOC);
}
function deleteRequest($id){
    $conn = connect();
    $stmt = $conn->prepare("DELETE FROM post WHERE id=?");
    $stmt->bind_param("s",$id);
    return $stmt->execute();
}
?>