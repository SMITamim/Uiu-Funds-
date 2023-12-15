<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donation</title>
</head>
<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' rel='stylesheet'
      integrity='sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN' crossorigin='anonymous'>
<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js'
        integrity='sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL'
        crossorigin='anonymous'></script>
<link rel="stylesheet" href="style.css">
<body>
    <div class="container-fluid">
        <?php
        session_start();
        if (!isset($_SESSION['university_id'])) {
            header("location: ../view/login.php");
        }
        include('template/navbar.php');
        include_once('../model/authUser.php');
        $user = getAuthUser($_SESSION['university_id']);
        ?>
        <div class="row">
            <div class="card-round">
                <h2><b>Donate to the community</b></h2>
            </div>
        </div>
        <div class="container mb-5">
            
            <div class="row mt-5">
                <div class="card-round">
                    <div class="card-body">
                        <?php
                        if (isset($_SESSION['donation_errors'])) {
                            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        {$_SESSION['donation_errors']}
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
                            unset($_SESSION['donation_errors']);
                        } else {
                            if (isset($_SESSION['donation_success'])) {
                                echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                        {$_SESSION['donation_success']}
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
                                unset($_SESSION['donation_success']);
                            }
                        }
                        ?>
                        <h3><b>Account Information</b></h3><br>
                        <p><b>User Name:</b><?php echo $user['name']; ?></p>
                        <p><b>Banlance:</b> <?php echo $user['amount']; ?> BDT</p>
                        <button type="button" class="btn round-btn btn-success text-white" data-bs-toggle="modal" data-bs-target="#payModal">Pay From Account</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card-round">
                        <?php
                        if (isset($_SESSION['add_money_error'])) {
                            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        {$_SESSION['add_money_error']}
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
                            unset($_SESSION['add_money_error']);
                        } else {
                            if (isset($_SESSION['add_money_success'])) {
                                echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                        {$_SESSION['add_money_success']}
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
                                unset($_SESSION['add_money_success']);
                            }
                        }
                        ?>
                        <div class="card-image">
                            <img src="img/SSL.png">
                        </div>
                        <div class="card-body">
                            <button type="button" class="btn round-btn btn-success text-white" data-bs-toggle="modal" data-bs-target="#addMoney">Add Money</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Pay From Account Modal-->
    <div class="modal fade" id="payModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Donate Us</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="../controller/donationController.php" method="post">
                <div class="modal-body">
                        <div class="mb-3">
                            <label for="donationAmount" class="form-label">Donation Amount</label>
                            <input type="number" class="form-control" id="donationAmount" name="donationAmount">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Pay</button>
                </div>
                </form>
            </div>
        </div>
    </div>
    <!--Add money Modal-->
    <div class="modal fade" id="addMoney" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Money</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="../controller/addMoneyController.php" method="post">
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="addAmount" class="form-label">Add Amount</label>
                            <input type="number" class="form-control" id="addAmount" name="addAmount">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>