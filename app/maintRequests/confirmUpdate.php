<?php session_start(); ?>

<html>
    <body>

    <?php 
        
        /**
         * Eduardo Estrada
         * 12/30/2018
         * maintPendingIssues.php
         * Purpose:
         * To update the maint issue in the database
         * Modification - 3/8/2019
         * Trying to fix problem - with empty fields - only on the aws infastructure
         */
      
        include("../utilities/utility.php");
        // grab all the POST DATA
        $issueID = sanatizeData($_POST["id"]); 
        $reportDate = sanatizeData($_POST["IssueReportDate"]);  
        $priority = sanatizeData($_POST["IssuePriority"]); 
        $issueStatus = sanatizeData($_POST["IssueStatus"]); 
        $description = sanatizeData($_POST["IssueDescription"]); 
        $solution = sanatizeData($_POST["IssueSolution"]); 
        $repairDate = sanatizeData($_POST["IssueRepairDate"]); 
        $scheduleDate = sanatizeData($_POST["ScheduledDate"]);  
        $price = sanatizeData($_POST["IssueRepairPrice"]); 
        $name = sanatizeData($_POST["tenantName"]); 
        $aptNumber = sanatizeData($_POST["aptNumber"]); 
        // Required field names
        $requiredFields = array('id','IssueReportDate', 'IssuePriority', 'IssueStatus', 
        'IssueDescription', 'IssueSolution', 'IssueRepairDate','ScheduledDate',
        'IssueRepairPrice','tenantName','aptNumber');
        $error = false;
        // user session MUST be SET
        if(isset($_SESSION['app_userEmail'])){
            // connect to database
            $db = new SQLite3('../db/Tenants.sqlite');
            // from open to pending update
            if($issueStatus == "pending"){

                if (!empty($scheduleDate) && !empty($priority)) {
                    
                    $stmt = $db->prepare("UPDATE TenantMaintIssues SET IssuePriority = :priority, 
                    IssueStatus = :issueStatus, ScheduledDate = :scheduleDate
                    WHERE TenantMaintIssue_ID = :issueID ");
                    $stmt->bindValue(':priority', $priority, SQLITE3_TEXT);
                    $stmt->bindValue(':issueStatus', $issueStatus, SQLITE3_TEXT);
                    $stmt->bindValue(':scheduleDate', $scheduleDate, SQLITE3_TEXT);
                    $stmt->bindValue(':issueID', $issueID, SQLITE3_INTEGER);
                    $stmt->execute();
                    if($db->changes() > 0){
                        // echo "Record updated successfully";
                        echo"
                        <script type='text/javascript'>
                        window.history.go(-2);
                        </script>";
                    } else {
                        //echo "Error updating record: " . mysqli_error($conn);
                        echo "<h2>Record Not updated</h2>";
                    } // end (mysqli_query($conn, $sql))
                }else{
                    echo "<h2>Priority, and Scheduled Date Cannot be blank</h2>";
                    echo "<p>When updating an issue from open - pending<br/>";
                    echo "Priority, and Scheduled Date fields cannot be blank</p>";
                }// end if(empty($scheduleDate))
            // from pending to closed OR from open to closed
            } else if ($issueStatus == "closed"){
                // Loop over field names, make sure each one exists and is not empty
                foreach($requiredFields as $field) {
                    if (empty($_POST[$field])) {
                        $error = true;
                    }
                }
                if ($error) {
                    echo "<h2>Closed Issues - Must completely fill out form</h2>"; 
                    echo "<p>When updating an issue from open - closed OR pending - closed<br/>";
                    echo "Must completely fill out form</p>";
                    exit();
                } else {
                    // everything must be filled out
                    $stmt = $db->prepare("UPDATE TenantMaintIssues SET IssuePriority = :priority,
                    IssueStatus = :issueStatus, IssueSolution = :solution,
                    IssueRepairDate = :repairDate, ScheduledDate = :scheduleDate, IssueRepairPrice = :price
                    WHERE TenantMaintIssue_ID = :issueID ");
                    $stmt->bindValue(':priority', $priority, SQLITE3_TEXT);
                    $stmt->bindValue(':issueStatus', $issueStatus, SQLITE3_TEXT);
                    $stmt->bindValue(':solution', $solution, SQLITE3_TEXT);
                    $stmt->bindValue(':repairDate', $repairDate, SQLITE3_TEXT);
                    $stmt->bindValue(':scheduleDate', $scheduleDate, SQLITE3_TEXT);
                    $stmt->bindValue(':price', $price, SQLITE3_INTEGER);
                    $stmt->bindValue(':issueID', $issueID, SQLITE3_INTEGER);
                    $stmt->execute();
                    if($db->changes() > 0){
                        // echo "Record updated successfully";
                        echo"
                        <script type='text/javascript'>
                        window.history.go(-2);
                        </script>";
                    } else {
                        echo "<h2>Closed Issues - Must completely fill out form</h2>"; 
                        echo "<p>When updating an issue from open - closed OR pending - closed<br/>";
                        echo "Must completely fill out form</p>";
                        //echo "Error updating record: " . mysqli_error($conn);
                    } // end (mysqli_query($conn, $sql))
                }// end if ($error) 
            } else {
                echo "<h2>Status must be PENDING or CLOSED</h2>"; 
            }// end if ($status == "closed")
        } else { 
            echo "<h5>Session Expired</h5>"; 
        } // end if(isset($_SESSION['app_userEmail']) && isset($_SESSION['app_pass']))
        $db->close();
    ?>
    </body>
</html>
