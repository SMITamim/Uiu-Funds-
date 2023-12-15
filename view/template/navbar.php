<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
<div class='row'>
    <nav class='navbar navbar-expand-lg mb-5'>
        <div class='container-fluid'>
            <a class='navbar-brand' href='#'><span><h1>UIU Friends Fund &</h1></span><span><h2>CloudSourcing</h2></span>
            </a>
            <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarNavDropdown' aria-controls='navbarNavDropdown' aria-expanded='false' aria-label='Toggle navigation'>
                <span class='navbar-toggler-icon'></span>
            </button>
            <div class='collapse navbar-collapse' id='navbarNavDropdown'>
                <ul class='navbar-nav ms-auto mb-2 mb-lg-0'>
                    <?php
                    if (!isset($_SESSION['university_id'])) {
                        echo "  <li class='nav-item'>
                        <a class='nav-link active' aria-current='page' href='#'>Home</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='#'>Helping Tools</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='#'>How This Work</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='#'>About</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='#'>Contact Us</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='login.php'>Login</a>
                    </li>";
                    }else{
                        echo "<li class='nav-item'>
                        <a class='nav-link text-white' href='dashboard.php'>Home</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link text-white' href='updateProfile.php'>View Profile</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link text-white' href='viewPost.php'>My Post</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link text-white' href='../controller/logoutController.php'>Logout</a>
                    </li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>
</div>
