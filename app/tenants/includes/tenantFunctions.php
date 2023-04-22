<?php

    /**
     * Selects and displays the Tenant Record from the Tenants Table. 
     * @param - string
     * @param - string
     * @return NOTHING 
     */
    function selectTenantInfo($userEmail, $userPassWord){
       // username MUST be an email
        if (filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
            
            $hashPassword = hash('sha256', $userPassWord);

            $db = new SQLite3('../db/Tenants.sqlite');
            $stmt = $db->prepare("SELECT Tenant_ID,TenantEmail, TenantFirstName || ' ' || TenantLastName AS Name,TenantAddress_FK FROM Tenants 
            WHERE TenantEmail = :userEmail and TenantPassword = :userPassword" );
            $stmt->bindValue(':userEmail', $userEmail, SQLITE3_TEXT);
            $stmt->bindValue(':userPassword', $hashPassword, SQLITE3_TEXT);
            $result = $stmt->execute();
            $row = $result->fetchArray();
            // the very first ID is 1 so 0 does not exist
            if ($row["Tenant_ID"] > 0) {  

                $tenantID = $row["Tenant_ID"];
                // assign these variables to the GLOBAL Session
                // do not display in this function
                $_SESSION['TenantID'] = $row["Tenant_ID"]; 
                $_SESSION['TenantEmail'] = $row["TenantEmail"]; 
                $_SESSION['TenantName'] = $row["Name"]; 
                $_SESSION['TenantAddress_FK'] = $row["TenantAddress_FK"];
                /**
                 * Retrieve the users 3 security questions
                 * and display one random question for validation
                 */
                $stmt2 = $db->prepare( "SELECT TenantProfile_ID, Sec1.secquest AS secQuest1, Sec2.secquest AS secQuest2, Sec3.secquest AS secQuest3  
                FROM TenantProfiles
                JOIN TenantSecQuestions Sec1 ON TenantProfiles.TenantSecQues1_FK = Sec1.secQues_ID
                JOIN TenantSecQuestions Sec2 ON TenantProfiles.TenantSecQues2_FK = Sec2.secQues_ID
                JOIN TenantSecQuestions Sec3 ON TenantProfiles.TenantSecQues3_FK = Sec3.secQues_ID
                WHERE  Tenant_FK = :tenantID ");
                $stmt2->bindValue(':tenantID', $tenantID, SQLITE3_INTEGER);
                $result2 = $stmt2->execute();
                $row2 = $result2->fetchArray();  
                // if id is found 
                if ($row2["TenantProfile_ID"] > 0) { 
                    $secQuest1 = $row2["secQuest1"]."<br>";
                    $secQuest2 = $row2["secQuest2"]."<br>";
                    $secQuest3 = $row2["secQuest3"]."<br>";
                    // create a random number
                    $randomQuest = rand(0,2);
                    // create the question array
                    $questionArray = array ($secQuest1,$secQuest2,$secQuest3);
                    //display one random question from the users record
                    echo "<div class='shadow p-3 mb-5 bg-white rounded'>";
                    echo "<p><strong>".$questionArray[$randomQuest]."</strong></p>";
                    echo "<form name='valSecAnswer' method='post' action='tenantValidateAnswer.php'>";
                    echo "<div class='form-group'>";
                    echo "<input type='text' class='form-control' placeholder='Secret Answer ?' name='answer' aria-label='secret answer input field' required>";
                    echo "</div>";
                    echo "<div class='button-panel'>";
                    echo "<input class='btn btn-primary' type='submit' value='Submit' style='margin-right: 10px;'>";
                    echo "<a id='formButton' class='btn btn-secondary' href='index.html'>Cancel</a>";
                    echo "</div>";
                    echo "</form>";
                    echo "</div>";   
                } else {
                    // display error
                    echo "0 find The Users Profile Questions";
                }// end if ($row2["Tenant_ID"] > 0)
            } else {
                // user is NOT in the database table
                $error = "Your Login e-mail or Password is invalid";
                /////////////////////////////////////////////////////////////////////////////
                echo "<h1>".$error."</h1>";
                // exit out of the functions or everything else witll continue to run
                exit();
            }

        }// end if (filter_var($userEmail, FILTER_VALIDATE_EMAIL))
        // close the DB connection
        $db->close();
    }// end SelectTenantInfo

    /**
     * Matches input answer to the 3 answers in the 
     * Tenant profiles Table 
     * @param - string
     * @return NOTHING 
     */
    function validateTenantAnswer($secretAnswer){
        // get the logged in user ID from DB
        // Stored in the GLOBAL SESSION
       //  session_start();
        $tenantID = $_SESSION['TenantID'];
        // connect to database
        $db = new SQLite3('../db/Tenants.sqlite');
        //SQL SELECT STATEMENT -- Check the 3 answers
        $stmt = $db->prepare(" SELECT TenantProfile_ID,TenantSecAns1,TenantSecAns2,TenantSecAns3 
        FROM TenantProfiles WHERE TenantProfile_ID = '$tenantID' 
        AND TenantSecAns1 = :secretAnswer OR TenantSecAns2 = :secretAnswer OR TenantSecAns3 = :secretAnswer" );
        $stmt->bindValue(':secretAnswer', $secretAnswer, SQLITE3_TEXT);
        $result = $stmt->execute();
        $row = $result->fetchArray();
        // if a record is returned
        if ($row["TenantProfile_ID"] > 0){
            // echo "MATCh";
            // redirect to welcome page
            echo "<script>window.location.href = 'tenantDash.php';</script>";
        } else {
            // echo "answer does not Match";
            echo "<script>window.location.href = '../logout.php';</script>";
        }// if (mysqli_num_rows($result) > 0)	
        $db->close();

    }// end validateTenantAnswer()



    function displayUserProfile(){
        // get the logged in user ID from DB
        // Stored in the GLOBAL SESSION
        // session_start();
        $tenantID = $_SESSION['TenantID'];
         // connect to database
         $db = new SQLite3('../db/Tenants.sqlite');
         //SQL SELECT STATEMENT -- Check the 3 answers
         $stmt = $db->prepare("SELECT Tenant_ID,TenantEmail, TenantFirstName || ' ' || TenantLastName AS Name,TenantHomeNumber,TenantMobileNumber,
         TenantWorkNumber,addr.Apt_street AS addr,city.Apt_City AS city,t_state.Apt_State AS t_state,zip.Apt_Zip AS zip,aptNum.Apt_number AS aptnum
         FROM Tenants 
         JOIN Apartments addr ON Tenants.TenantAddress_FK = addr.Apartment_ID
         JOIN Apartments city ON Tenants.TenantCity_FK = city.Apartment_ID
         JOIN Apartments t_state ON Tenants.TenantState_FK = t_state.Apartment_ID
         JOIN Apartments zip ON Tenants.TenantZip_FK = zip.Apartment_ID
         JOIN Apartments aptNum ON Tenants.TenantAptNum_FK = aptNum.Apartment_ID
         WHERE Tenant_ID = :tenantID");
         $stmt->bindValue(':tenantID', $tenantID, SQLITE3_INTEGER);
         $result = $stmt->execute();
         $row = $result->fetchArray();
         // if a record is returned
         if ($row["Tenant_ID"] > 0){
            echo"<div class='shadow p-3 mb-5 bg-white rounded'>";
            echo"<div class='card w-100'>";
            echo"<div class='card-body'>";
            echo "<h2>My Profile</h2>";
            echo "<p><strong>Name:</strong> ".$row["Name"]."</p>"; 
            echo "<p><strong>Email:</strong> ".$row["TenantEmail"]."</p>"; 
            echo "<p><strong>Home Telephone #:</strong> ".$row["TenantHomeNumber"]."</p>"; 
            echo "<p><strong>Mobile Telephone #:</strong> ".$row["TenantMobileNumber"]."</p>"; 
            echo "<p><strong>Work Telephone #:</strong> ".$row["TenantWorkNumber"]."</p>"; 
            echo "<p><strong>Address:</strong> ".$row["addr"]."</p>"; 
            echo "<p><strong>City:</strong> ".$row["city"]."</p>"; 
            echo "<p><strong>State:</strong> ".$row["t_state"]."</p>";
            echo "<p><strong>Zip:</strong> ".$row["zip"]."</p>"; 
            echo "<p><strong>Apt #:</strong> ".$row["aptnum"]."</p>";
            echo "</div>"; 
            echo "</div>";
            echo "</div>";
         } else {
            // user is NOT in the database table
            $error = "cant find infor check your sql";
            /////////////////////////////////////////////////////////////////////////////
            echo "<h1>".$error."</h1>";
            // exit out of the functions or everything else witll continue to run
            exit();
         }
         $db->close();

    }// end displayUserProfile
    /**
     * Returns true if maint issue successfully created to TenantMaintIssues.
     * 12/29/2021 EER
     * @param - reportDate {string}
     * @param - issueDescription {string}
     * @param - tenantID {string}
     * @return - Bool
     */
    function createTenantIssue($reportDate, $issueDescription, $tenantID){
       
        $db = new SQLite3('../db/Tenants.sqlite');
        $stmt = $db->prepare(" INSERT INTO TenantMaintIssues (IssueReportDate, IssueStatus, IssueDescription, Tenant_FK, Tenant_Apt_FK)
        VALUES (:reportDate, 'open', :issueDescription , :tenantName, :aptNumber)" );
        $stmt->bindValue(':reportDate', $reportDate, SQLITE3_TEXT);
        $stmt->bindValue(':issueDescription', $issueDescription, SQLITE3_TEXT);
        $stmt->bindValue(':tenantName', $tenantID, SQLITE3_INTEGER);
        $stmt->bindValue(':aptNumber', $tenantID, SQLITE3_INTEGER);
        $stmt->execute(); 

       if($db->lastInsertRowID() > 0){
            $db->close();
           return true;
       }
       $db->close();
       return false;

    }// end createTenantIssue()
    /**
     * Displays Apartments Table.
     */
    function displayApartments(){
        $db = new SQLite3('../db/Tenants.sqlite');
        $results = $db->query('SELECT * FROM Apartments');
		echo "<option value=''>Select Apartment:</option>";
			// output data of each row
			// the ID will be the value to store as a foreign Key
        while ($row = $results->fetchArray()) {
            echo "<option value=".$row["Apartment_ID"]. "> ". $row["Apt_number"]."</option>";
        }
        $db->close();
		 
	}// end registerQuestions()
    /**
     * Displays TenantSecQuestions Table.
     */
    function displayRegisterQuestions(){
		// echo "register questions";
		// connect to database
		$db = new SQLite3('../db/Tenants.sqlite');
		$results = $db->query("SELECT * FROM TenantSecQuestions");
        echo "<option value=''>Select Question:</option>";
        while ($row = $results->fetchArray()) {
            echo "<option value=".$row["secQues_ID"]. "> ". $row["secquest"]."</option>";
        }
		// close connection
        $db->close();
	}// end registerQuestions()

    /**
     * Returns true if the user email excists in DB.
     * @param - userEmail {string}
     * @return - Bool
     */
    function findTenantEmail($userEmail){
        // connect to database
        $db = new SQLite3('../db/Tenants.sqlite');
        $stmt = $db->prepare("SELECT Tenant_ID FROM Tenants WHERE tenantEmail = :userEmail");
        $stmt->bindValue(':userEmail', $userEmail, SQLITE3_TEXT);
        $result = $stmt->execute();
        $row = $result->fetchArray();  
        // the very first ID is 1 so 0 does not exist
        if ($row["Tenant_ID"] > 0) { 
            $db->close();
            return true;
        }
        $db->close();
        return false;
    }// end findTenantEmail()

    /**
     * Creates a new tenant and returns the last Inserted ID
     * @param - email {string}
     * @param - userPassWord {string}
     * @param - fName {string}
     * @param - lName {string}
     * @param - hPhone {string}
     * @param - mPhone {string}
     * @param - wPhone {string}
     * @param - apt {int}
     * @return {int} lastInsertedID 
     */
    function createNewTenant($email,$userPassWord,$fName,$lName,$hPhone,$mPhone,$wPhone,$apt){
        $hashPassword = hash('sha256', $userPassWord);
        $db = new SQLite3('../db/Tenants.sqlite');
        $stmt = $db->prepare(" INSERT INTO Tenants (TenantEmail,TenantPassword, TenantFirstName, TenantLastName,TenantHomeNumber,
        TenantMobileNumber, TenantWorkNumber, TenantAddress_FK, TenantCity_FK, TenantState_FK, TenantZip_FK,TenantAptNum_FK) 
        VALUES (:email, :hashPassword, :fName, :lName, :hPhone, :mPhone, :wPhone, :apt, :apt, :apt, :apt, :apt)" );
        $stmt->bindValue(':email', $email, SQLITE3_TEXT);
        $stmt->bindValue(':hashPassword', $hashPassword, SQLITE3_TEXT);
        $stmt->bindValue(':fName', $fName, SQLITE3_TEXT);
        $stmt->bindValue(':lName', $lName, SQLITE3_TEXT);
        $stmt->bindValue(':hPhone', $hPhone, SQLITE3_TEXT);
        $stmt->bindValue(':mPhone', $mPhone, SQLITE3_TEXT);
        $stmt->bindValue(':wPhone', $wPhone, SQLITE3_INTEGER);
        $stmt->bindValue(':apt', $apt, SQLITE3_INTEGER);
        $stmt->execute();
        $lastInsertedID = $db->lastInsertRowID();
       if($db->lastInsertRowID() > 0){
            $db->close();
           return $lastInsertedID;
       }
       $db->close();
       return 0;
    }// end createNewTenant()

    /**
     * Creates a new tenant profile.
     * Returns true if success.
     * @param - last_id {int}
     * @param - secquest1 {string}
     * @param - secAnswer1 {string}
     * @param - secquest2 {string}
     * @param - secAnswer2 {string}
     * @param - secquest3 {string}
     * @param - secAnswer3 {string}
     * @return Bool 
     */
    function createNewTenantProfile($last_id, $secquest1, $secAnswer1, $secquest2, $secAnswer2, 
    $secquest3, $secAnswer3 ){
        $hashSecAnswer1 = hash('sha256', $secAnswer1);
        $hashSecAnswer2 = hash('sha256', $secAnswer2);
        $hashSecAnswer3 = hash('sha256', $secAnswer3);
        $db = new SQLite3('../db/Tenants.sqlite');
        $stmt = $db->prepare(" INSERT INTO TenantProfiles (Tenant_FK,TenantSecQues1_FK,TenantSecAns1,TenantSecQues2_FK, TenantSecAns2,
        TenantSecQues3_FK, TenantSecAns3) VALUES 
        (:last_id, :secquest1, :hashSecAnswer1, :secquest2, :hashSecAnswer2, :secquest3, :hashSecAnswer3)" );
        $stmt->bindValue(':last_id', $last_id, SQLITE3_INTEGER);
        $stmt->bindValue(':secquest1', $secquest1, SQLITE3_TEXT);
        $stmt->bindValue(':hashSecAnswer1', $hashSecAnswer1, SQLITE3_TEXT);
        $stmt->bindValue(':secquest2', $secquest2, SQLITE3_TEXT);
        $stmt->bindValue(':hashSecAnswer2', $hashSecAnswer2, SQLITE3_TEXT);
        $stmt->bindValue(':secquest3', $secquest3, SQLITE3_TEXT);
        $stmt->bindValue(':hashSecAnswer3', $hashSecAnswer3, SQLITE3_TEXT);
        $stmt->execute();
       if($db->lastInsertRowID() > 0){
            $db->close();
           return true;
       }
       $db->close();
       return false;
    }// end createNewTenant()

    /**
     * Displays OPEN and PENDING Issues for tenant ID.
     * @param - tenantID {int}
     */
    function displayPendingIssues($tenantID){
        $db = new SQLite3('../db/Tenants.sqlite');
        $stmt = $db->prepare("SELECT TenantMaintIssue_ID AS ID,IssueReportDate, IssuePriority, IssueStatus, 
        IssueDescription, IssueSolution, IssueRepairDate, ScheduledDate,
        tenantFname.TenantFirstName || ' ' || tenantLname.TenantLastName AS Name,
        tenantApt.Apt_number AS aptNumber
        FROM TenantMaintIssues 
        JOIN Tenants tenantFname ON TenantMaintIssues.Tenant_FK = tenantFname.Tenant_ID
        JOIN Tenants tenantLname ON TenantMaintIssues.Tenant_FK = tenantLname.Tenant_ID
        JOIN Apartments tenantApt ON TenantMaintIssues.Tenant_Apt_FK = tenantApt.Apartment_ID
        WHERE  Tenant_FK = :tenantID 
        AND IssueStatus = 'open' OR Tenant_FK = :tenantID AND IssueStatus ='pending' ORDER BY IssueReportDate DESC ");
        $stmt->bindValue(':tenantID', $tenantID, SQLITE3_INTEGER);
        $results = $stmt->execute();
        // make the table
        echo "<table class='table table-striped table-hover caption-top'>";
        echo "<caption>Pending and Open Maintenace Issues</caption>";
        echo "<thead>";
        echo "<tr>";
        echo "<th class='col-sm-2' scope='col'>Reported Date</th>";
        echo "<th class='col-sm-1' scope='col'>Status</th>";
        echo "<th class='col-sm-2' scope='col'>Scheduled Date</th>";
        echo "<th scope='col'>Description</th>";
        echo "<th scope='col'>Tenant</th>"; 
        echo "<th scope='col'>APT NUM</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        // output data of each row
        while ($row = $results->fetchArray()) {
            echo "<tr>";
            echo "<td>".$row["IssueReportDate"]."</td>"; 
            echo "<td>".$row["IssueStatus"]."</td>"; 
            echo "<td>".$row["ScheduledDate"]."</td>"; 
            echo "<td>".$row["IssueDescription"]."</td>"; 
            echo "<td>".$row["Name"]."</td>"; 
            echo "<td>".$row["aptNumber"]."</td>";  
            echo "</tr>";   
        } // end while
        echo "</tbody>";
        echo "</table>"; // close the table 
        $db->close(); 
    }// end displayPendingIssues($tenantID)
    /**
     * Displays CLOSED Issues for tenant ID.
     * @param - tenantID {int}
     */
    function displayClosedIssues($tenantID){
        $db = new SQLite3('../db/Tenants.sqlite');
        $stmt = $db->prepare("SELECT TenantMaintIssue_ID AS ID,IssueReportDate, IssuePriority, IssueStatus, 
        IssueDescription, IssueSolution, IssueRepairDate, ScheduledDate,
        tenantFname.TenantFirstName || ' ' || tenantLname.TenantLastName AS Name,
        tenantApt.Apt_number AS aptNumber
        FROM TenantMaintIssues 
        JOIN Tenants tenantFname ON TenantMaintIssues.Tenant_FK = tenantFname.Tenant_ID
        JOIN Tenants tenantLname ON TenantMaintIssues.Tenant_FK = tenantLname.Tenant_ID
        JOIN Apartments tenantApt ON TenantMaintIssues.Tenant_Apt_FK = tenantApt.Apartment_ID
        WHERE  Tenant_FK = :tenantID 
        AND IssueStatus = 'closed' ORDER BY IssueReportDate ASC ");
        $stmt->bindValue(':tenantID', $tenantID, SQLITE3_INTEGER);
        $results = $stmt->execute();
        // make the table
        echo "<table class='table table-striped table-hover caption-top'>";
        echo "<caption>Closed Maintenace Issues</caption>";
        echo "<thead>";
        echo "<tr>";
        echo "<th class='col-sm-2' scope='col'>Reported Date</th>";
        echo "<th class='col-sm-1' scope='col'>Status</th>";
        echo "<th class='col-sm-2' scope='col'>Scheduled Date</th>";
        echo "<th class='col-sm-2' scope='col'>Repaired Date</th>";
        echo "<th scope='col'>Description</th>";
        echo "<th scope='col'>Tenant</th>"; 
        echo "<th scope='col'>APT NUM</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        // output data of each row
        while ($row = $results->fetchArray()) {
            echo "<tr>";
            echo "<td>".$row["IssueReportDate"]."</td>"; 
            echo "<td>".$row["IssueStatus"]."</td>";
            echo "<td>".$row["ScheduledDate"]."</td>"; 
            echo "<td>".$row["IssueRepairDate"]."</td>"; 
            echo "<td>".$row["IssueDescription"]."</td>"; 
            echo "<td>".$row["Name"]."</td>"; 
            echo "<td>".$row["aptNumber"]."</td>";  
            echo "</tr>";   
        } // end while
        echo "</tbody>";
        echo "</table>"; // close the table 
        $db->close(); 
    }// end displayClosedIssues($tenantID)
?>