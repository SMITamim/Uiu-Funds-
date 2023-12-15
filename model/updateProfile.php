<?php
// authUser.php and updateController.php
include_once '../model/dbConnect.php';

function updateUser($name,$university_id,$semester,$email,$id){
    $conn = connect();
    $stmt = $conn->prepare("UPDATE user SET name = ? , university_id = ? , semester = ?, email = ? WHERE id = ?");
    $stmt->bind_param("sssss",$name,$university_id,$semester,$email,$id);
    $res = $stmt->execute();
    return $res;
}
function checkDupliacy($email,$university_id){
    $conn = connect();
    $query = $conn->prepare("SELECT * FROM user WHERE email = ? or university_id = ?");
    $query->bind_param("ss",$email,$university_id);
    $query->execute();
    $result = $query->get_result();
    return $result->fetch_assoc();
}
function updateAmount($university_id,$amount){
    $conn = connect();
    $stmt = $conn->prepare("UPDATE user SET amount = ? WHERE university_id = ?");
    $stmt->bind_param("ss",$amount,$university_id);
    $res = $stmt->execute();
    return $res;
}
?>