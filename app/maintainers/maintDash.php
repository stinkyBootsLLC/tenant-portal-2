<?php

session_start(); // start the session
date_default_timezone_set('America/New_York');
$mySession = date("H:i:s"); // current time        
?>
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
                    <span class="nav-link active" aria-current="page">
                        <ion-icon name="home"></ion-icon>&nbsp; Maintenance Dashboard
                    </span>
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
                    <a class="nav-link" href="../maintRequests/myTenants.php">
                        <ion-icon name="contacts"></ion-icon>&nbsp; My Tenants
                    </a>
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
        <p>Maintenace Dashboard</p>
    </div>

    <main>
        <div class="container">
            <?php
            include("../utilities/utility.php");
            include("includes/maintainerFunctions.php");
            if (isset($_SESSION['app_userEmail'])) {
                $startTime = $_SESSION['start_activity']; // capture the session start time
                // Display the GLOBAL Session information
                echo "<div class='shadow p-3 mb-5 bg-white rounded'>";
                echo "<div class='card w-100'>";
                echo "<div class='card-body'>";
                echo "<h2>Session Data</h2>";
                // After login, a personal welcome message should appear
                echo "<p>Welcome back: " . $_SESSION['app_userEmail']."</p>";
                echo "<p>Current Time = " . $mySession . " Session Start time = " . date('H:i:s', $startTime) . "</p>";
                echo "<p>User will be logged out after 30 minutes</p>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                monitorSession();
            ?>
        </div>
        <div class="container">

            <div class="shadow" id="chartContainer" style="height: 370px; width: 100%;">
            <?php 
                $open = numberOfOpenIssues();
                $pending = numberOfPendingIssues();
                $closed = numberOfClosedIssues(); 
            ?>
            </div>
            <br>
            <div class="row">
                <div class="col-lg-4 col-md-8 col-sm-10">
                    <div class="shadow p-3 mb-5 bg-white rounded">
                        <div class="card w-100">
                            <div class="card-body">
                                <h5 class="card-title">Open Maint Issues [<?php echo $open; ?>]</h5>
                                <p class="card-text">Recently added tenant maintenance issues.</p>
                                <a href="../maintRequests/maintOpenIssues.php" class="btn btn-primary">View Issues</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-8 col-sm-10">
                    <div class="shadow p-3 mb-5 bg-white rounded">
                        <div class="card w-100">
                            <div class="card-body">
                                <h5 class="card-title">Pending Maint Issues [<?php echo $pending; ?>]</h5>
                                <p class="card-text">Pending issues with scheduled repair dates.</p>
                                <a href="../maintRequests/maintPendingIssues.php" class="btn btn-primary">View Issues</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-8 col-sm-10">
                    <div class="shadow p-3 mb-5 bg-white rounded">
                        <div class="card w-100">
                            <div class="card-body">
                                <h5 class="card-title">Closed Maint Issues [<?php echo $closed; ?>]</h5>
                                <p class="card-text">Closed issues with completed repaired dates.</p>
                                <a href="../maintRequests/maintClosedIssues.php" class="btn btn-primary">View Issues</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end class="row"-->
            <!-- New Row-->
            <div class="row">
                <div class="col-lg-4 col-md-8 col-sm-10">
                    <div class="shadow p-3 mb-5 bg-white rounded">
                        <div class="card w-100">
                            <div class="card-body">
                                <h5 class="card-title">My Tenants</h5>
                                <p class="card-text">Registered Tenants.</p>
                                <a href="../maintRequests/myTenants.php" class="btn btn-primary">View Tenants</a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end my tenants card-->
                <div class="col-lg-4 col-md-8 col-sm-10">
                    <div class="shadow p-3 mb-5 bg-white rounded">
                        <div class="card w-100">
                            <div class="card-body">
                                <h5 class="card-title">Empty Card</h5>
                                <p class="card-text">Empty Card.</p>
                                <a href="#" class="btn btn-primary">Button</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-8 col-sm-10">
                    <div class="shadow p-3 mb-5 bg-white rounded">
                        <div class="card w-100">
                            <div class="card-body">
                                <h5 class="card-title">Empty Card</h5>
                                <p class="card-text">Empty Card</p>
                                <a href="#" class="btn btn-primary">Button</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--end class="row"-->
        </div>
        <!--end class="container"-->
        <?php 
            } else {
                echo "SESSION EXPIRED";
            }// endIf
        ?>
    </main>
    <div class="top-spacing"></div>
    <div class="top-spacing"></div>
    <div class="top-spacing"></div>
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
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <script src="../assets/js/tenantDash.js"></script>

    <script>
        // CanvasJs Chart
        window.onload = function() {
            let open = <?php echo $open ?>;
            let pending = <?php echo $pending ?>;
            let closed = <?php echo $closed ?>;

            let chart = new CanvasJS.Chart("chartContainer", {
                animationEnabled: true,
                theme: "light2", // "light1", "light2", "dark1", "dark2"
                title: {
                    text: "Tenant's Issue Status"
                },
                axisY: {
                    title: "Issues(ea)"
                },
                data: [{
                    type: "column",
                    showInLegend: true,
                    legendMarkerColor: "grey",
                    legendText: "ea = each",
                    dataPoints: [{
                            y: open,
                            label: "Open"
                        },
                        {
                            y: pending,
                            label: "Pending"
                        },

                        {
                            y: closed,
                            label: "Closed"
                        }
                    ]
                }]
            });
            chart.render();

        }
    </script>
</body>
</html>