<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
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
    if (!isset($_SESSION['university_id'])) {
        header("location: ../view/login.php");
    }
    include('template/navbar.php');
    include_once('../model/loanModel.php');
    include_once('../model/authUser.php');
    include_once ('../model/bidModal.php');
    ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4">
                <div class="container">
                    <div class="row">
                        <div class="card-round">
                            <div class="row mt-2">
                                <a href="donate.php" class="btn round-btn btn-success text-white">Donate Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="card-round">
                            <h4><b>Accepted Bid</b></h4>
                        </div>
                    </div>
                    <?php
                    $acceptedBids = showAcceptedBid();
                    if($acceptedBids){
                        foreach ($acceptedBids as $acceptedBid){
                            $user = getAuthUser($acceptedBid['borrower_id']);
                            if(!isset($acceptedBid['proposed_amount'])) {
                                $post = searchPost($acceptedBid['post_id']);
                                if (isset($_SESSION['pay_loan_failed_message'])) {
                                    echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        {$_SESSION['pay_loan_failed_message']}
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
                                    unset($_SESSION['pay_loan_failed_message']);
                                } else {
                                    if (isset($_SESSION['pay_loan_success_message'])) {
                                        echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                        {$_SESSION['pay_loan_success_message']}
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
                                        unset($_SESSION['pay_loan_success_message']);
                                    }
                                }
                                echo "<div class='row mt-3'>
                        <div class='card-round'>
                            <div class='card-title'>
                                <h4><b>{$user['name']}</b></h4>
                            </div>
                            <div class='card-body'>
                            <b class='text-success'>Agree with your condition</b> <br>
                                <b>Amount: {$post['amount']}<br>
                                    Interest Rate: {$post['interest']}% <br>
                                    Time Period: {$post['timePeriod']}</b>
                            </div>
                            <div class='row'>
                                <div class='col-md-12'>
                                            <button type='button' class='btn round-btn btn-success text-white' id='proposal' onclick='payLoan({$acceptedBid['id']},{$post['amount']})'>Pay Loan</button>
                                </div>
                            </div>
                        </div>
                    </div>";
                            }
                            else{
                                echo "<div class='row mt-3'>
                        <div class='card-round'>
                            <div class='card-title'>
                                <h4><b>{$user['name']}</b></h4>
                            </div>
                            <div class='card-body'>
                          
                                <b> Proposed Amount: {$acceptedBid['proposed_amount']}<br>
                                    Proposed Interest Rate: {$acceptedBid['proposed_interest']}% <br>
                                    Proposed Time Period: {$acceptedBid['proposed_time_period']}</b>
                            </div>
                            <div class='row'>
                                <div class='col-md-12'>
                                   <button type='button' class='btn round-btn btn-success text-white' id='proposal' onclick='payLoan({$acceptedBid['id']},{$acceptedBid['proposed_amount']})'>Pay Loan</button>
                                </div>
                            </div>
                        </div>
                    </div>";
                            }
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row">
                    <div class="card-round">
                        <div class="card-title">
                            <h3><b>Request Loan</b></h3>
                        </div>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="card-round">

                        <form action="../controller/loanRequestController.php" method="post">
                            <?php
                            if (isset($_SESSION['loan_request_failed_message'])) {
                                echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        {$_SESSION['loan_request_failed_message']}
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
                                unset($_SESSION['loan_request_failed_message']);
                            } else {
                                if (isset($_SESSION['loan_request_success_message'])) {
                                    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                        {$_SESSION['loan_request_success_message']}
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
                                    unset($_SESSION['loan_request_success_message']);
                                }
                            }
                            ?>
                            <div class="mb-3">
                                <label for="amount" class="form-label text-black"><h4>Input amount</h4>
                                </label>
                                <input type="number" class="form-control" id="amount" name="amount"
                                       aria-describedby="emailHelp" placeholder="20000">
                                <?php
                                if (isset($_SESSION['loan_request_errors']['amount'])) {
                                    echo "<p class='text-danger'>{$_SESSION['loan_request_errors']['amount']}</p>";
                                    unset($_SESSION['loan_request_errors']['amount']); // Unset this specific error after displaying it
                                }
                                ?>
                            </div>
                            <div class="mb-3">
                                <label for="interest" class="form-label"><h4>Expected Interest</h4></label>
                                <input type="number" class="form-control" id="interest" name="interest"
                                       placeholder="5%">
                                <?php
                                if (isset($_SESSION['loan_request_errors']['interest'])) {
                                    echo "<p class='text-danger'>{$_SESSION['loan_request_errors']['interest']}</p>";
                                    unset($_SESSION['loan_request_errors']['interest']); // Unset this specific error after displaying it
                                }
                                ?>
                            </div>

                            <div class="mb-3">
                                <div class="row">
                                    <div class="col">
                                        <label for="timePeriod" class="form-label"><h4>Time Period</h4></label>
                                        <select class="form-select form-select-sm" aria-label=".form-select-sm example"
                                                name="timePeriod">
                                            <option selected value="">Select a week</option>
                                            <option value="1">1 week</option>
                                            <option value="2">2 weeks</option>
                                            <option value="3">3 weeks</option>
                                            <option value="4">4 weeks</option>
                                            <option value="5">5 weeks</option>
                                            <option value="6">6 weeks</option>
                                        </select>
                                        <?php
                                        if (isset($_SESSION['loan_request_errors']['timePeriod'])) {
                                            echo "<p class='text-danger'>{$_SESSION['loan_request_errors']['timePeriod']}</p>";
                                            unset($_SESSION['loan_request_errors']['timePeriod']); // Unset this specific error after displaying it
                                        }
                                        ?>
                                    </div>
                                </div>

                            </div>

                            <button type="submit" class="btn round-btn btn-success text-white">Post Request</button>
                        </form>
                    </div>
                </div>
                <?php

                $requests = getRequest();
                if ($requests) {
                    foreach ($requests as $request) {
                        $user = getAuthUser($request['user_id']);
                        if (isset($_SESSION['bid_failed_message'])) {
                            echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        {$_SESSION['bid_failed_message']}
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
                            unset($_SESSION['bid_failed_message']);
                        } else {
                            if (isset($_SESSION['bid_success_message'])) {
                                echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                        {$_SESSION['bid_success_message']}
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
                                unset($_SESSION['bid_success_message']);
                            }
                        }
                        echo "<div class='row mt-5'>
                    <div class='card-round'>
                        <div class='card-title'>
                            <h3>{$user['name']}</h3>
                            <p>{$request['user_id']}</p>
                            <p>{$user['email']}</p>
                        </div>
                        <div class='card-body'>
                            <b>Input Amount: {$request['amount']} Bdt <br>
                                Expected Interest: {$request['interest']}% <br>
                                Time Period: {$request['timePeriod']} <br></b>
                        </div>
                        <div class='row'>
                            <div class='col-md-6'>
                                <button type='button' class='btn round-btn btn-success text-white' id='unconditional' onclick='unConditionalBidModal({$request['id']},\"{$request['user_id']}\")'>Bid</button>
                            </div>
                            <div class='col-md-6'>
                                <button type='button' class='btn round-btn btn-warning text-white' id='proposal' onclick='proposalBidModal({$request['id']},\"{$request['user_id']}\")'>Make a Proposal</button>
                            </div>
                        </div>
                    </div>
                </div>";
                    }
                }
                ?>

            </div>
            <div class="col-md-4">
                <div class="container">
                    <div class="row">
                        <div class="card-round">
                            <h4><b>Proposed Bid Offers</b></h4>
                        </div>
                    </div>
                    <?php

                    $bidOffers = proposedBidOffer();
                    if ($bidOffers) {
                        foreach ($bidOffers as $bidOffer) {
                            if (isset($_SESSION['bid_accept_request_failed_message'])) {
                                echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'>
                        {$_SESSION['bid_accept_request_failed_message']}
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
                                unset($_SESSION['bid_accept_request_failed_message']);
                            } else {
                                if (isset($_SESSION['bid_accept_request_success_message'])) {
                                    echo "<div class='alert alert-success alert-dismissible fade show' role='alert'>
                        {$_SESSION['bid_accept_request_success_message']}
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>";
                                    unset($_SESSION['bid_accept_request_success_message']);
                                }
                            }
                            $user = getAuthUser($bidOffer['lender_id']);
                            if(!isset($bidOffer['proposed_amount'])) {
                                $post = searchPost($bidOffer['post_id']);
                                echo "<div class='row mt-3'>
                        <div class='card-round'>
                            <div class='card-title'>
                                <h4><b>{$user['name']}</b></h4>
                            </div>
                            <div class='card-body'>
                            <b class='text-success'>Agree with your condition</b> <br>
                                <b>Amount: {$post['amount']}<br>
                                    Interest Rate: {$post['interest']}% <br>
                                    Time Period: {$post['timePeriod']}</b>
                            </div>
                            <div class='row'>
                                <div class='col-md-12'>
                                            <button type='button' class='btn round-btn btn-warning text-white' id='proposal' onclick='acceptedBid({$bidOffer['id']})'>Accept</button>
                                </div>
                            </div>
                        </div>
                    </div>";
                            }
                            else{
                                echo "<div class='row mt-3'>
                        <div class='card-round'>
                            <div class='card-title'>
                                <h4><b>{$user['name']}</b></h4>
                            </div>
                            <div class='card-body'>
                          
                                <b> Proposed Amount: {$bidOffer['proposed_amount']}<br>
                                    Proposed Interest Rate: {$bidOffer['proposed_interest']}% <br>
                                    Proposed Time Period: {$bidOffer['proposed_time_period']}</b>
                            </div>
                            <div class='row'>
                                <div class='col-md-12'>
                                   <button type='button' class='btn round-btn btn-warning text-white' id='proposal' onclick='acceptedBid({$bidOffer['id']})'>Accept</button>
                                </div>
                            </div>
                        </div>
                    </div>";
                            }
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Proposal Modal -->
<div class="modal fade" id="proposalModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Give a proposal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="row mt-3">
                    <div class="card-round">
                        <form action="../controller/proposedBidController.php" method="post">
                            <input type="hidden" class="form-control" id="postId" name="postId">
                            <input type="hidden" class="form-control" id="borrower_id" name="borrower_id">
                            <div class="mb-3">
                                <label for="amount" class="form-label text-black"><h4>Proposal Input amount</h4>
                                </label>
                                <input type="number" class="form-control" id="amount" name="amount"
                                       aria-describedby="emailHelp" placeholder="20000">

                            </div>
                            <div class="mb-3">
                                <label for="interest" class="form-label"><h4>Proposal Expected Interest</h4></label>
                                <input type="number" class="form-control" id="interest" name="interest"
                                       placeholder="5%">

                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col">
                                        <label for="timePeriod" class="form-label"><h4>Proposal Time Period</h4></label>
                                        <select class="form-select form-select-sm" aria-label=".form-select-sm example"
                                                name="timePeriod">
                                            <option selected value="">Select Week</option>
                                            <option value="1">1 Week</option>
                                            <option value="2">2 Weeks</option>
                                            <option value="3">3 Weeks</option>
                                            <option value="4">4 Weeks</option>
                                            <option value="5">5 Weeks</option>
                                            <option value="6">6 Weeks</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn round-btn btn-success text-white">Bid</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!--bid Modal-->
<div class="modal fade" id="unconditionalModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Unconditional Bid</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../controller/unconditionalBid.php" method="post">
            <div class="modal-body">
                <input type="hidden" class="form-control" id="upostId" name="upostId">
                <input type="hidden" class="form-control" id="uborrower_id" name="uborrower_id">
                <h3 class="text-danger">Are you want to bid without any proposal?</h3>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" data-bs-dismiss="modal">Bid</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!--Accepted Bid Modal -->
<div class="modal fade" id="acceptedBidModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Unconditional Bid</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../controller/acceptBidController.php" method="post">
            <div class="modal-body">
                <input type="hidden" class="form-control" id="bidId" name="bidId">
                <h3 class="text-danger">Are you want to accept this bid??</h3>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" data-bs-dismiss="modal">Accept</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!--Pay Loan Modal -->
<div class="modal fade" id="payLoanModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Pay Loan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="../controller/payLoan.php" method="post">
                <div class="modal-body">
                    <input type="hidden" class="form-control" id="paybidId" name="paybidId">
                    <input type="hidden" class="form-control" id="payAmount" name="payAmount">
                    <h3 class="text-danger">Are you sure?</h3>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-success" data-bs-dismiss="modal">Pay Loan</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>
</body>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    function proposalBidModal(id,borrower_id) {
        // Display the Bootstrap modal
        $('#proposalModal').modal('show');
        $('#postId').val(id);
        $('#borrower_id').val(borrower_id);
    }
    function unConditionalBidModal(id,borrower_id) {
        // Display the Bootstrap modal
        $('#unconditionalModal').modal('show');
        $('#upostId').val(id);
        $('#uborrower_id').val(borrower_id);
    }
    function acceptedBid(id) {
        // Display the Bootstrap modal
        $('#acceptedBidModal').modal('show');
        $('#bidId').val(id);
    }
    function payLoan(id,amount) {
        // Display the Bootstrap modal
        $('#payLoanModal').modal('show');
        $('#paybidId').val(id);
        $('#payAmount').val(amount);
    }
</script>
</html>
