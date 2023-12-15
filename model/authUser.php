<?php
// authUser.php and updateController.php
include_once '../model/dbConnect.php';

function getAuthUser($university_id){
    $conn = connect();
    $query = $conn->prepare("SELECT * FROM user WHERE university_id = ?");
    $query->bind_param("s",$university_id);
    $query->execute();
    $result = $query->get_result();
    return $result->fetch_assoc();
}
?>
