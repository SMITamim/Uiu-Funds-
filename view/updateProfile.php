<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Profile</title>
</head>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
<link rel="stylesheet" href="style.css">
<body>
<div class="container-fluid">
    <?php
    session_start();
    if(!isset($_SESSION['university_id'])){
        header("location: ../view/login.php");
    }
    include ('template/navbar.php');
    include ('../model/authUser.php');
    $user = getAuthUser($_SESSION['university_id']);
    ?>
    <div class="container">
        <div class="row">
            <div class="row mt-3">
                <div class="card-round">
                    <?php
                    if (isset($_SESSION['update_profile_failed_message'])) {
                        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        {$_SESSION['update_profile_failed_message']}
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
                        unset($_SESSION['update_profile_failed_message']);
                    }else {
                        if (isset($_SESSION['update_profile_success_message'])) {
                            echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                        {$_SESSION['update_profile_success_message']}
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
                            unset($_SESSION['update_profile_success_message']);
                        }
                    }
                    ?>

                    <form action="../controller/profileUpdateController.php" method="post">
                        <div class="mb-3">
                            <label for="name" class="form-label text-black"><h4>Name</h4></label>
                            <input type="name" class="form-control" name="name" id="name" type="text"
                                   value="<?php echo $user['name']?>"
                            >
                            <?php
                            if (isset($_SESSION['update_profile_errors']['name'])) {
                                echo "<p class='text-danger'>{$_SESSION['update_profile_errors']['name']}</p>";
                                unset($_SESSION['update_profile_errors']['name']); // Unset this specific error after displaying it
                            }
                            ?>
                        </div>
                        <div class="mb-3">
                            <label for="university_id" class="form-label"><h4>University Id</h4></label>
                            <input type="university_id" class="form-control" name="university_id" id="university_id"
                                   type="text" value="<?php echo $user['university_id']?>">
                            <?php
                            if (isset($_SESSION['update_profile_errors']['university_id'])) {
                                echo "<p class='text-danger'>{$_SESSION['update_profile_errors']['university_id']}</p>";
                                unset($_SESSION['update_profile_errors']['university_id']); // Unset this specific error after displaying it
                            }
                            ?>
                        </div>

                        <div class="mb-3">
                            <label for="semester" class="form-label"><h4>Semester</h4></label>
                            <input type="semester" class="form-control" name="semester" id="semester" type="text"
                                   value="<?php echo $user['semester']?>">
                            <?php
                            if (isset($_SESSION['update_profile_errors']['semester'])) {
                                echo "<p class='text-danger'>{$_SESSION['update_profile_errors']['semester']}</p>";
                                unset($_SESSION['update_profile_errors']['semester']); // Unset this specific error after displaying it
                            }
                            ?>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label"><h4>Email</h4></label>
                            <input type="email" class="form-control" name="email" id="email" type="email" value="<?php echo $user['email']?>">
                            <?php
                            if (isset($_SESSION['update_profile_errors']['email'])) {
                                echo "<p class='text-danger'>{$_SESSION['update_profile_errors']['email']}</p>";
                                unset($_SESSION['update_profile_errors']['email']); // Unset this specific error after displaying it
                            }
                            ?>
                        </div>

                        <button type="submit" class="btn round-btn btn-success text-white">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>