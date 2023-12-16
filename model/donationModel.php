<?php
include_once '../model/dbConnect.php';
function donation($university_id,$amount){
    $conn = connect();
    $stmt = $conn->prepare("INSERT INTO donation(university_id,amount) VALUES (?,?)") ;
    $stmt->bind_param("ss",$university_id,$amount);
    $res = $stmt->execute();
    return $res;
}
function allDonation(){
    $conn = connect();
    $stmt = $conn->prepare("SELECT * FROM donation");
    $stmt->execute();
    $record = $stmt->get_result();
    return $record->fetch_all(MYSQLI_ASSOC);
}