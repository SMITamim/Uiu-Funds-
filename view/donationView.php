<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Document</title>
</head>
<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC' crossorigin='anonymous'>
<link rel='stylesheet' href='style.css'>
<body>
<div class='container-fluid'>
    <?php
    session_start();
    if (!isset($_SESSION['university_id'])) {
        header('location: ../view/login.php');
    }
    include ('template/navbar.php');
    include_once('../model/donationModel.php');
    include_once('../model/authUser.php');
    ?>
    <?php
    $donations = allDonation();
    foreach ($donations as $donation){
        echo "  <div class='row mt-4'>
        <div class='col-md-4'>

        </div>
        <div class='col-md-4'>
            <div class='card-round'>
                <div class='card-body'>
                   <h3 class='text-white'><b>Winter Clothing Collection</b></h3>
                    <div class='row'>
                        <div class='col-md-6'><p class='text-white'>University ID: {$donation['university_id']}</p></div>
                        <div class='col-md-6'><p class='text-white'>Amount: {$donation['amount']}</p></div>
                    </div>
                </div>
            </div>
        </div>
        <div class='col-md-4'>

        </div>

    </div>";
    }
    ?>

</div>
</body>
</html>