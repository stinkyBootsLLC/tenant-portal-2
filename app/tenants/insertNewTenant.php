<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Tenant Portal</title>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
</head>
<body>

<?php
/**
 * Date: 11 Jan 2019
 * Author: Eduardo Estrada
 * Title: insertNewTenant.php 
 * Description: Allows a user to register
 */
	include("includes/tenantFunctions.php");
	include("../utilities/utility.php");
    // Retrieve Post Data from the registrant
    $fName = sanatizeData($_POST["fName"]);
    $lName = sanatizeData($_POST["lName"]);
	$apt = sanatizeData($_POST["apt"]);  
	$hPhone = sanatizeData($_POST["hPhone"]);
	$mPhone = sanatizeData($_POST["mPhone"]);
    $wPhone = sanatizeData($_POST["wPhone"]);	
	$email = sanatizeData($_POST["email"]);
	$userPassWord = $_POST["userPassWord"]; // all chars allowed
	$conFirmUserPassWord = $_POST["conFirmUserPassWord"];// all chars allowed	
	$secquest1 = sanatizeData($_POST["secquest1"]);
	$secquest2 = sanatizeData($_POST["secquest2"]);
	$secquest3 = sanatizeData($_POST["secquest3"]);
    $secAnswer1 = sanatizeData($_POST["secanwser1"]);	
	$secAnswer2 = sanatizeData($_POST["secanwser2"]);
	$secAnswer3 = sanatizeData($_POST["secanwser3"]);
	
	// validate password requirements
	$uppercase = preg_match('@[A-Z]@', $userPassWord);
	$lowercase = preg_match('@[a-z]@', $userPassWord);
	$number    = preg_match('@[0-9]@', $userPassWord);
	$specialChars = preg_match('@[^\w]@', $userPassWord);
	if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($userPassWord) < 8) {
		echo "
		<script>
		$( function() {
		  $( '#dialog-confirm' ).dialog({
			resizable: false,
			height: 'auto',
			width: 400,
			modal: true,
			buttons: {
			  'Ok': function() {
				$( this ).dialog( 'close' );
				window.history.go(-1);
			  }
			}
		  });
		} );
		</script>";
		echo "
		<div id='dialog-confirm' title='Tenant Portal'>
		<p>Password should be at least 8 characters in length and should include at least one upper case letter, one number, and one special character.</p>
		</div>";
		 exit();
	}
	// password match validation
	if($userPassWord === $conFirmUserPassWord){
		// the passwords are a match
		// if these 3 fields are not empty
		if (!empty($email) && !empty($userPassWord) && !empty($apt) && !empty($fName) && !empty($lName) && !empty($secAnswer1)  
			&& !empty($secAnswer2) && !empty($secAnswer1) ){
			// check if the email already exists
			$doesEmailExcist = findTenantEmail($email);
			if ($doesEmailExcist){
				echo "
				<script>
				$( function() {
				  $( '#dialog-confirm' ).dialog({
					resizable: false,
					height: 'auto',
					width: 400,
					modal: true,
					buttons: {
					  'Ok': function() {
						$( this ).dialog( 'close' );
						window.history.go(-1);
					  }
					}
				  });
				} );
				</script>";
				echo "
				<div id='dialog-confirm' title='Tenant Portal'>
				<p>Sorry this email ".$email." already exists</p>
				</div>";
				// redirect back to login form
				//header('Refresh: 2; URL = tenantRegister.php');
			
			} else {
				// add new user
				$last_id = createNewTenant($email, $userPassWord, $fName, $lName, $hPhone, $mPhone, $wPhone, $apt);
				// if the insert was success	
				if ($last_id > 0) {
					echo "<hi>New tenant record created successfully</h1>";
					// $last_id = $conn->insert_id;
				} else {
					echo "Error: adding the new tenant contact admin";
					// future  redirect out of this page or add some sort 
					// of contact info for user to solve the problem
				}
				// insert new info to the Tenants Profile table
				$profileCreated = createNewTenantProfile($last_id, $secquest1, $secAnswer1, $secquest2, $secAnswer2, $secquest3, $secAnswer3 );
				if ($profileCreated === TRUE) {
					//echo "New tenant profile record created successfully";
					echo "
					<script>
					$( function() {
					  $( '#dialog-confirm' ).dialog({
						resizable: false,
						height: 'auto',
						width: 400,
						modal: true,
						buttons: {
						  'Ok': function() {
							$( this ).dialog( 'close' );
							window.history.go(-2);
						  }
						}
					  });
					} );
					</script>";
					echo "
					<div id='dialog-confirm' title='Tenant Portal'>
					<p>You have successfully registered <br>You are being re-directed to log-in page</p>
					</div>";
				} else {
					echo "Error: adding the new tenants profile table";
					// future  redirect out of this page or add some sort 
					// of contact info for user to solve the problem
				}// end  
			 
			}// end if ($conn->query($sql2) === TRUE)
		
		} else {
			// not a mactch
			echo "<script>
			alert('Required Fields are Missing!'); 
			window.location.href = 'https://www.fbi.gov/investigate/cyber';  
			</script>";
		}// end if(empty field)

	} else {
		// not a mactch
		echo "
		<script>
		$( function() {
		  $( '#dialog-confirm' ).dialog({
			resizable: false,
			height: 'auto',
			width: 400,
			modal: true,
			buttons: {
			  'Ok': function() {
				$( this ).dialog( 'close' );
				window.history.go(-1);
			  }
			}
		  });
		} );
		</script>";
		echo "
		<div id='dialog-confirm' title='Tenant Portal'>
		<p>Sorry, passwords do not match, please try again</p>
		</div>";
	} // end if (password mismatch)
?>



 

 
 

</body>
</html>