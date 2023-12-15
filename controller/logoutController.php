<?php
session_start();
if (isset($_SESSION['university_id'])) {
    session_unset();
    session_destroy();
    header("location: ../view/login.php");
}
?>
