<?php

    /**
     * Selects and displays the Tenant Record from the
     * Tenants Table 
     * @param - string
     * @param - string
     * @return NOTHING 
     */
    function selectMaintInfo($userEmail, $userPassWord){
        // username MUST be an email
        if (filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
            $hashPassword = hash('sha256', $userPassWord);
            $db = new SQLite3('../db/Tenants.sqlite');
            $stmt = $db->prepare( "SELECT Maintainer_ID,MaintainerEmail,MaintainerFirstName || ' ' || MaintainerLastName AS Name FROM Maintainers 
            WHERE MaintainerEmail = :userEmail and MaintainertPassword = :userPassword");
            $stmt->bindValue(':userEmail', $userEmail, SQLITE3_TEXT);
            $stmt->bindValue(':userPassword', $hashPassword, SQLITE3_TEXT);
            $result = $stmt->execute();
            $row = $result->fetchArray();

            if ($row["Maintainer_ID"] > 0) { 

                $maint_ID = $row["Maintainer_ID"];
                // assign these variables to the GLOBAL Session
                // do not display in this function
                $_SESSION['Maintainer_ID'] = $row["Maintainer_ID"]; 
                $_SESSION['MaintainerEmail'] = $row["MaintainerEmail"]; 
                $_SESSION['MaintName'] = $row["Name"];  

                /**
                 * Retrieve the users 3 security questions
                 * and display one random question for validation
                 */
                $stmt2 = $db->prepare( "SELECT MaintainerProfile_ID, Sec1.secquest AS secQuest1, Sec2.secquest AS secQuest2, Sec3.secquest AS secQuest3  
                FROM MaintainerProfiles
                JOIN TenantSecQuestions Sec1 ON MaintainerProfiles.MaintainerSecQues1_FK = Sec1.secQues_ID
                JOIN TenantSecQuestions Sec2 ON MaintainerProfiles.MaintainerSecQues2_FK = Sec2.secQues_ID
                JOIN TenantSecQuestions Sec3 ON MaintainerProfiles.MaintainerSecQues3_FK = Sec3.secQues_ID
                WHERE  Maintainer_FK  = :maintID ");
                $stmt2->bindValue(':maintID', $maint_ID, SQLITE3_INTEGER);
                $result2 = $stmt2->execute();
                $row2 = $result2->fetchArray();
                // if id is found 
                if ($row2["MaintainerProfile_ID"] > 0) { 
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
                    echo "<form name='valSecAnswer' method='post' action='maintainerValidateAnswer.php'>";
                    echo "<div class='form-group'>";
                    echo "<input type='text' class='form-control' placeholder='Secret Answer ?'  aria-label='Answer input field' name='answer' required>";
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
            } // end if (mysqli_num_rows($result) > 0)
        // close the DB connection
        // mysqli_close($conn);
        // // call function
        // getTenantRandomQuestion();

          }// end if (filter_var($userEmail, FILTER_VALIDATE_EMAIL))
        // close the DB connection
        $db->close();
    }// end SelectTenantInfo


    /**
     * Matches input answer to the 3 answers in the 
     * Tenant profiles Table 
     * @param - {string} secretAnswer
     * @return NOTHING 
     */
    function validateTenantAnswer($secretAnswer){
        $maint_ID = $_SESSION['Maintainer_ID'];
        $db = new SQLite3('../db/Tenants.sqlite');
        //SQL SELECT STATEMENT -- Check the 3 answers
        $stmt = $db->prepare(" SELECT MaintainerProfile_ID, MaintainerSecAns1, MaintainerSecAns2, MaintainerSecAns3 
        FROM MaintainerProfiles WHERE MaintainerProfile_ID = '$maint_ID' 
        AND MaintainerSecAns1 = :secretAnswer OR MaintainerSecAns2 = :secretAnswer OR MaintainerSecAns3 = :secretAnswer" );
        $stmt->bindValue(':secretAnswer', $secretAnswer, SQLITE3_TEXT);
        $result = $stmt->execute();
        $row = $result->fetchArray();
        if ($row["MaintainerProfile_ID"] > 0){
            echo "MATCh";
            $db->close();
            // redirect to welcome page
            echo "<script>window.location.href = 'maintDash.php';</script>";
        } else {
            $db->close();
            echo "answer does not Match";
            echo "<script>window.location.href = '../logout.php';</script>";
        }// if (mysqli_num_rows($result) > 0)	

    }// end validateTenantAnswer()

    /**
     * Count the number of "open" maint issue 
     * @return Integer 
     */
    function numberOfOpenIssues(){
        $openIssues = 0;
        // connect to the database
        $db = new SQLite3('../db/Tenants.sqlite');
        $result = $db->query("SELECT IssueStatus, count(*) as count FROM TenantMaintIssues WHERE IssueStatus = 'open'");
        $row = $result->fetchArray();
        if($row['count']>0){
            $openIssues = $row['count'];
        }
        $db->close();
        return $openIssues;
    }// end numberOfOpenIssues
    /**
     * Count the number of "pending" maint issue 
     * @return Integer 
     */
    function numberOfPendingIssues(){
        $pendingIssues = 0;
        // connect to the database
        $db = new SQLite3('../db/Tenants.sqlite');
        $result = $db->query("SELECT IssueStatus, count(*) as count FROM TenantMaintIssues WHERE IssueStatus = 'pending'");
        $row = $result->fetchArray();
        if($row['count']>0){
            $pendingIssues = $row['count'];
        }
        $db->close();
        return $pendingIssues;
    }// end numberOfPendingIssues()
    /**
     * Count the number of "closed" maint issue 
     * @return Integer 
     */
    function numberOfClosedIssues(){
        $closedIssues = 0;
        // connect to the database
        $db = new SQLite3('../db/Tenants.sqlite');
        $result = $db->query("SELECT IssueStatus, count(*) as count FROM TenantMaintIssues WHERE IssueStatus = 'closed'");
        $row = $result->fetchArray();
        if($row['count']>0){
            $closedIssues = $row['count'];
        }
        $db->close();
        return $closedIssues; 
    }// end numberOfClosedIssues(){

     
       



?>