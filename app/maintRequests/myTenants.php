<?php session_start(); ?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Font-Awsome CSS -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <title>Tenant Portal 2019</title>
    <meta name="author" content="Eduardo Estrada">
    <meta name="description" content="description here">
    <meta name="keywords" content="keywords,here">
    <link rel="shortcut icon" href="favicon.ico" type="image/vnd.microsoft.icon">
    <!-- CSS home made sources-->
    <link rel="stylesheet" href="../assets/css/tenants.css">
    <link rel="stylesheet" href="../assets/css/Footer-Dark.css">
</head>

<body>
    <!-- Top Nav Bar -->
    <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
        <span class="navbar-brand">Tenant Portal</span>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../maintainers/maintDash.php">
                        <ion-icon name="home"></ion-icon>&nbsp; Maintenance Dashboard <span class="sr-only">(current)</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../maintRequests/maintOpenIssues.php">
                        <ion-icon name="grid"></ion-icon>&nbsp; Open Issues
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../maintRequests/maintPendingIssues.php">
                        <ion-icon name="grid"></ion-icon>&nbsp; Pending Issues
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../maintRequests/maintClosedIssues.php">
                        <ion-icon name="grid"></ion-icon>&nbsp; Closed Issues
                    </a>
                </li>
                <li class="nav-item">
                    <span class="nav-link active">
                        <ion-icon name="contacts" aria-current="page"></ion-icon>&nbsp; My Tenants
                    </span>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="../logout.php">
                        <ion-icon name="power"></ion-icon>&nbsp; Log-Out
                    </a>
                </li>
            </ul>
        </div>
    </nav>
    <!-- Top Nav Bar -->
    <div class="top-spacing"></div>
    <div class="container-fluid">
        <h1>Tenant Portal Application</h1>
        <p>My Registered Tenants (Card View)</p>
    </div>
    <div class="container">

        <?php
        /**
         * Eduardo Estrada
         * 12/28/2018
         * maintOpenIssues.php
         * Purpose:
         * To display the open issues to the Landlord and Maintenace
         */
        include("../utilities/utility.php");
        include("includes/maintRequestFunctions.php");

        // user session MUST be SET
        if (isset($_SESSION['app_userEmail'])) {
            // monitor the session
            monitorSession();
            displayTenants();
        } else {
            echo "<h5>SESSION EXPIRED</h5>";
        } // end if(isset($_SESSION['app_userEmail']) && isset($_SESSION['app_pass']))
        ?>

    </div>
    <div class="top-spacing"></div>
    <!--==== FOOTER  Bootstrap 4 Class  Footer-Dark.css =======-->
    <div id="wrapper">
        <div id="footer">
            <footer class="footer footer-dark">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6 col-md-3 item">
                            <h2>Payment</h2>
                            <ul>
                                <li><a href="https://www.paypal.com/us/home">PayPal</a></li>
                                <li><a href="https://venmo.com/">Venmo</a></li>
                                <li><a href="https://www.payyourrent.com/sys/login/">PayYourRent</a></li>
                            </ul>
                        </div>
                        <div class="col-sm-6 col-md-3 item">
                            <h2>About</h2>
                            <ul>
                                <li><a href="../about.html">Purpose</a></li>
                            </ul>
                        </div>
                        <div class="col-sm-6 item text">
                            <h2>Tenant Portal Web Application</h2>
                            <p>Prototype - tenant / landlord maintenance issue reporting system</p>
                        </div>
                        <!-- Bottom Footer Icons -->
                        <div class="col item social">
                            <a href="https://github.com/stinkybootsllc" aria-label="github repository"><i class="fab fa-github fa-2x"></i></a>
                            <a href="https://www.linkedin.com/in/eduardo-estrada-b8744017a/" aria-label="linkedin profile"><i class="fab fa-linkedin fa-2x"></i></a>
                        </div>
                    </div> <!-- end row -->
                    <p class="copyright">StinkyBoots Studio 2018</p>
                </div>
            </footer><!-- end <div class="footer-dark">-->
        </div><!-- end <div id="footer">-->
    </div><!-- end <div id="wrapper">-->
    <!--===== END FOOTER =============-->
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/ionicons@4.5.0/dist/ionicons.js"></script>
    <script src="../assets/js/tenantDash.js"></script>
</body>

</html>