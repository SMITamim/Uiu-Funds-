<?php
include_once '../model/dbConnect.php';
  function register($name,$email,$university_id,$semester,$amount,$password){
     $conn = connect();
     $stmt = $conn->prepare("INSERT INTO user(name,university_id,semester,email,amount,password) VALUES (?,?,?,?,?,?)") ;
     $stmt->bind_param("ssssss",$name,$university_id,$semester,$email,$amount,$password);
     $res = $stmt->execute();
     return $res;
}
function get($email,$university_id){
    $conn = connect();
    $query = $conn->prepare("SELECT * FROM user WHERE email = ? or university_id = ?");
    $query->bind_param("ss",$email,$university_id);
    $query->execute();
    $result = $query->get_result();
    return $result->fetch_assoc();
}

?>