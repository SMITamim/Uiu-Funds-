<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
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
    include ('template/navbar.php');
    ?>

    <div class="container">
        <div class="row">
            <div class="row mt-3">
                <div class="card-round">
                    <?php
                    if (isset($_SESSION['login_failed_message'])) {
                        echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        {$_SESSION['login_failed_message']}
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
                        unset($_SESSION['login_failed_message']);
                    }
                    ?>
                    <form action="../controller/loginController.php" method="post">
                        <div class="mb-3">
                            <label for="email" class="form-label"><h4>Email</h4></label>
                            <input type="email" class="form-control" name="email" id="email" type="email" value="<?php echo isset($_SESSION['submitted_data']['email']) ? htmlspecialchars($_SESSION['submitted_data']['email']) : '';unset($_SESSION['submitted_data']['email']); ?>">
                            <?php
                            if (isset($_SESSION['login_errors']['email'])) {
                                echo "<p class='text-danger'>{$_SESSION['login_errors']['email']}</p>";
                                unset($_SESSION['login_errors']['email']); // Unset this specific error after displaying it
                            }
                            ?>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label"><h4>Password</h4></label>
                            <input type="password" class="form-control" name="password" id="password" type="password"
                                   value="">
                            <?php
                            if (isset($_SESSION['login_errors']['password'])) {
                                echo "<p class='text-danger'>{$_SESSION['login_errors']['password']}</p>";
                                unset($_SESSION['login_errors']['password']); // Unset this specific error after displaying it
                            }
                            ?>
                        </div>
                        <button type="submit" class="btn round-btn btn-success text-white" value="Register">Log In
                        </button>
                    </form>
                    <p>Don't have any account? <strong><a href="../view/registration.php"> Sign up here</a></strong></p>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>