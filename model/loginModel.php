<?php
include_once '../model/dbConnect.php';
function login($email,$password){
    $conn = connect();
    $query = $conn->prepare("SELECT * FROM user WHERE email = ? and password = ?");
    $query->bind_param("ss",$email,$password);
    $query->execute();
    $result = $query->get_result();
    return $result->fetch_assoc();

}

?>
