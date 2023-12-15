<?php
session_start();

include '../model/loanModel.php';

$id =  "";

$flag = false;

$id = $_POST['postId'];

$result = deleteRequest($id);
if ($result) {
    header("location:../view/viewPost.php");
    exit();
} else {
    header("location:../view/viewPost.php");
    exit();
}

?>


