<?php
/*SDEV 300 7980 (Lab 7)  
	Date: 17 Nov 2018
	Author: Eduardo Estrada
	Title: logout.php
	description: logs out the user session 
	and will redirect back to index.html "login form"
*/
   session_start();
   // clear the session individual variables
   unset($_SESSION['TenantID']); 
   unset($_SESSION['TenantEmail']); 
   unset($_SESSION['TenantName']); 
   unset($_SESSION['TenantAddress_FK']);
   unset($_SESSION['app_pass']);
   unset($_SESSION['app_userEmail']);
   unset($_SESSION['start_activity']);
   unset($_SESSION['Maintainer_ID']); 
   unset($_SESSION['MaintainerEmail']);
   unset($_SESSION['MaintName']);

   // display message
  // echo 'You have cleaned your session and Logged out';
   session_unset();
   session_destroy(); //destroy entire session 
      echo "<script> setTimeout(function () {
         
         window.location.href = 'index.html';
      }, 4000); </script>";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <!-- Font-Awsome CSS -->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" 
        integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" 
        crossorigin="anonymous">
        <title>Tenant Portal 2019</title>
        <meta name="author" content="Eduardo Estrada">
        <meta name="description" content="description here">
        <meta name="keywords" content="keywords,here">
        <!-- CSS home made sources-->
        <link rel="stylesheet" href="assets/css/tenants.css">
        <link rel="stylesheet" href="assets/css/Footer-Dark.css">
    </head>
    <body>
        <header></header>
                <!-- Top Nav Bar -->
                <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <span class="navbar-brand">Tenant Portal</span>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarCollapse">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                    <span class="nav-link active"><ion-icon name="power"></ion-icon>&nbsp; Log-Out</span>
                    </li>
                    
                </ul>
             
            </div>
        </nav>
        <div class="top-spacing"></div>

        <main class="container">

        <h1 class="font-semibold text-center" style="font-size:52px">You Have Been Logged Out</h1>
        <p class="text-center mgbt-xs-20">Thank you for using Tenant Portal 2018</p>

        </main>
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
                                    <li><a href="about.html">Purpose</a></li>
                                </ul>
                            </div>
                            <div class="col-sm-6 item text">
                                <h1>Tenant Portal Web Application</h1>
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
                <!-- jQuery first, then Popper.js, then Bootstrap JS -->
                <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
        <script src="https://unpkg.com/ionicons@4.5.0/dist/ionicons.js"></script>
   </body>
</html>  