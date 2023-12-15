<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Document</title>
</head>
<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' rel='stylesheet'
      integrity='sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN' crossorigin='anonymous'>
<script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js'
        integrity='sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL'
        crossorigin='anonymous'></script>
<link rel='stylesheet' href='style.css'>
<body>
    <div class='container-fluid'>
    <?php
    session_start();
    if (!isset($_SESSION['university_id'])) {
        header('location: ../view/login.php');
    }
    include('template/navbar.php');
    include_once('../model/authUser.php');
    include ('../model/loanModel.php');
    ?>
    <div class='row'>
        <div class='col-md-4'>

        </div>
        <div class='col-md-4'>
        <?php
            $myPosts = myRequest();
            foreach ($myPosts as $myPost){
                echo " <div class='row mt-5'>
                <div class='card-round'>
                    <div class='card-body'>
                        <p>Amount: {$myPost['amount']}<br>
                        Interest: {$myPost['interest']}<br>
                        Time Period: {$myPost['timePeriod']}</p>
                    </div>
                    <div class='row'>
                            <div class='col-md-12'>
                                <button type='button' class='btn round-btn btn-danger text-white' id='delete' onclick='deleteModal({$myPost['id']})'>Delete</button>
                            </div>
                        </div>
                </div>
            </div>";
            }
            ?>
        </div>
        <div class="col-md-4">
            
        </div>

    </div>
    </div>
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete Post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="../controller/deletePostController.php" method="post">
                    <div class="modal-body">
                        <input type="hidden" class="form-control" id="postId" name="postId">
                        <h3 class="text-danger">Are you want to delete this post?</h3>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger" data-bs-dismiss="modal">Delete</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    function deleteModal(id) {
        // Display the Bootstrap modal
        $('#deleteModal').modal('show');
        $('#postId').val(id);
    }
</script>
</html>