<?php
// security ?s and session monitor fuction
// and apartment list function
// updated and modified 12/29/2021
include("includes/tenantFunctions.php");
include("../utilities/utility.php");
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
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" 
		integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" 
		crossorigin="anonymous">
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
		<header></header>
		<!-- Top Nav Bar -->
		<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
			<a class="navbar-brand" href="index.html">Tenant Portal</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            	<span class="navbar-toggler-icon"></span>
        	</button>
			<div class="collapse navbar-collapse" id="navbarCollapse">
				<ul class="navbar-nav ml-auto">
					<li class="nav-item">
						<span class="nav-link active"><ion-icon name="person-add"></ion-icon>&nbsp; Register</span>
					</li>
				</ul>
			</div>
		</nav>
		<!-- Top Nav Bar -->
		<div class="top-spacing"></div>	
		<div class="container-fluid">
			<h1>Tenant Portal Application</h1>
			<p>Tenant Registration Form</p>
		</div>
		<main>
			<!-- Container for the Form-->
			<div class="container">
				<h2>Tenent Personal Information</h2>
				<!-- create the loggin form with an input text boxes -->
				<form id="reg-form" name="new-registration" method="post" action="insertNewTenant.php "> 
					<!--The Login form should consist of fields for username, email address and a password. -->
					<div class="form-group">
						<label for="First-Name">First Name:</label>
						<input id="First-Name" type="text" class="form-control" placeholder="Enter your first name" name="fName"  required>
					</div>
					<div class="form-group">
						<label for="Last-Name">Last Name:</label>
						<input id="Last-Name" type="text" class="form-control" placeholder="Enter your last name" name="lName"  required>
					</div>

					<div class="form-group">
						<label for="apartment">Apartment:</label>
						<select id="apartment" class="form-control" name="apt"  required>
						<!-- Questions-->
						<?php displayApartments(); ?>
						</select>
					</div>
					<div class="form-group">
						<label for="Home-Telephone">Home Telephone:</label>
						<input id="Home-Telephone" type="text" class="form-control" placeholder="123-456-7890" name="hPhone"
						pattern="^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]\d{3}[\s.-]\d{4}$" required>
					</div>
					<div class="form-group">
						<label for="Mobile-Telephone">Mobile Telephone:</label>
						<input id="Mobile-Telephone" type="text" class="form-control" placeholder="123-456-7890" name="mPhone" 
						pattern="^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]\d{3}[\s.-]\d{4}$">	
					</div>
					<div class="form-group">
						<label for="Work-Telephone">Work Telephone:</label>
						<input id="Work-Telephone" type="text" class="form-control" placeholder="123-456-7890" name="wPhone"
						pattern="^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]\d{3}[\s.-]\d{4}$">
					</div>
					<div class="form-group">
						<label for="E-mail">E-mail:</label>
						<input id="E-mail" type="email" class="form-control" placeholder="somename@mail.com" name="email"  
						 title="Unique email is required" required>
					</div>
					<hr>
					<h2>Tenent Log-in Information</h2>
					<p>Password must contain the following: <strong>1 lower case, 1 upper case letter, 1 number and 1 special character
					and at least 8 characters in length</strong></p>
					<div class="form-group">
						<label for="userPassWord">Password:</label>
						<input type="password" class="form-control" placeholder="Enter Password" name="userPassWord" id="userPassWord"
						pattern="(?=.*[0-9])(?=.*[A-Z])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,}" 
						title="1 lower case, 1 upper case letter, 1 number and 1 special character and at least 8 characters in length"  required>
					</div>
					<!--Needs to bee test 6/12/2019-->
					<div class="form-group">
						<label for="conFirmUserPassWord">Confirm Password:</label>
						<input type="password" class="form-control" placeholder="Re-type Password" name="conFirmUserPassWord" id="conFirmUserPassWord"
						pattern="(?=.*[0-9])(?=.*[A-Z])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,}" 
						title="1 lower case, 1 upper case letter, 1 number and 1 special character and at least 8 characters in length"  required>
						<span id='message'></span>
					</div>
					<hr>
					<div class="form-group">
						<label for="Security-Question-1">Security Question:</label>
						<select id="Security-Question-1" class="form-control" name="secquest1"  required>
						<!-- Questions-->
						<?php displayRegisterQuestions(); ?>
						</select>
					</div>
					<div class="form-group">
						<label for="Answer-1">Answer:</label>
						<input id="Answer-1" class="form-control" type="text" placeholder="Enter Answer" name="secanwser1" required>
					</div>
					<hr>
					<div class="form-group">
						<label for="Security-Question-2">Security Question:</label>
						<select id="Security-Question-2" class="form-control" name="secquest2" required>
						<!-- Questions-->
						<?php displayRegisterQuestions(); ?>
						</select>
					</div>
					<div class="form-group">
						<label for="Answer-2">Answer:</label>
						<input id="Answer-2" class="form-control" type="text" placeholder="Enter Answer" name="secanwser2" required>
					</div>
					<hr>
					<div class="form-group">
						<label for="Security-Question-3">Security Question:</label>
						<select id="Security-Question-3" class="form-control" name="secquest3" required>
						<!-- Questions-->
						<?php displayRegisterQuestions(); ?>
						</select>
					</div>
					<div class="form-group">
						<label for="Answer-3">Answer:</label>
						<input id="Answer-3" class="form-control" type="text" placeholder="Enter Answer" name="secanwser3" required>
					</div>
					<hr>
					<div class="form-group">
						<button class="btn btn-primary" id="registerBtn" name="registerBtn" type="submit">Register</button>
						<a href="../index.html" class="btn btn-secondary">&nbsp; Cancel &nbsp;</a>
					</div>
				</form>
			</div>
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
        <!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
		<script src="https://unpkg.com/ionicons@4.5.0/dist/ionicons.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>
		<!-- Optional JavaScript -->
		<script src="../assets/js/regis.js"></script>
	</body>
</html>
