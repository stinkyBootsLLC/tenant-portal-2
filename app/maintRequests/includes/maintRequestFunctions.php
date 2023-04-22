<?php
    date_default_timezone_set('America/New_York');

    function displayIssues($status){
        $db = new SQLite3('../db/Tenants.sqlite');
        // select and display everything in the TenantMaintIssues Table
        $results = $db->query("SELECT TenantMaintIssue_ID AS ID,IssueReportDate, IssuePriority, IssueStatus, 
        IssueDescription, IssueSolution, IssueRepairDate, ScheduledDate,
        tenantFname.TenantFirstName || ' ' || tenantLname.TenantLastName AS Name,
        tenantApt.Apt_number AS aptNumber
        FROM TenantMaintIssues 
        JOIN Tenants tenantFname ON TenantMaintIssues.Tenant_FK = tenantFname.Tenant_ID
        JOIN Tenants tenantLname ON TenantMaintIssues.Tenant_FK = tenantLname.Tenant_ID
        JOIN Apartments tenantApt ON TenantMaintIssues.Tenant_Apt_FK = tenantApt.Apartment_ID
        WHERE IssueStatus='$status' ORDER BY IssueReportDate ASC");
        // make the table
        echo "<table class='table table-striped table-hover caption-top'>";
        echo "<caption>All ".ucfirst($status)." Maintenace Issues</caption>";
        echo "<thead>";
        echo "<tr>";
        echo "<th class='col-sm-2' scope='col'>Reported Date</th>";
        echo "<th class='col-sm-1' scope='col'>Status</th>";
        echo "<th scope='col'>Description</th>";
        echo "<th scope='col'>Tenant</th>"; 
        echo "<th scope='col'>APT NUM</th>";
        echo "<th>Update</th>";
        echo "</tr>";
        echo "</thead>";
        echo "<tbody>";
        // output data of each row
        while ($row = $results->fetchArray()) {
            echo "<tr>";
            echo "<td>".$row["IssueReportDate"]."</td>"; 
            echo "<td>".$row["IssueStatus"]."</td>"; 
            echo "<td>".$row["IssueDescription"]."</td>"; 
            echo "<td>".$row["Name"]."</td>"; 
            echo "<td>".$row["aptNumber"]."</td>"; 
            echo "<td><a class='btn btn-secondary' href='UpdateIssue.php?id=".$row['ID']."'>UPDATE</a></td>";        
            echo "</tr>";   
        } // end while
        echo "</tbody>";
        echo "</table>"; // close the table 
        $db->close(); 
    }// end displayOpenIssues()  


    

    function displayClosedIssues(){
        $db = new SQLite3('../db/Tenants.sqlite');
        // select and display everything in the TenantMaintIssues Table
        $results = $db->query("SELECT TenantMaintIssue_ID AS ID,IssueReportDate, IssuePriority, IssueStatus, 
        IssueDescription, IssueSolution, IssueRepairDate, ScheduledDate, IssueRepairPrice,
        tenantFname.TenantFirstName || ' ' || tenantLname.TenantLastName AS Name,
        tenantApt.Apt_number AS aptNumber
        FROM TenantMaintIssues 
        JOIN Tenants tenantFname ON TenantMaintIssues.Tenant_FK = tenantFname.Tenant_ID
        JOIN Tenants tenantLname ON TenantMaintIssues.Tenant_FK = tenantLname.Tenant_ID
        JOIN Apartments tenantApt ON TenantMaintIssues.Tenant_Apt_FK = tenantApt.Apartment_ID
        WHERE IssueStatus='closed' ORDER BY IssueReportDate ASC");
        // make the table

        echo "<table class='table table-striped table-hover caption-top'>";
        echo "<caption>All Closed Maintenace Issues</caption>";
        echo "<thead>";
        echo "<tr>";
        echo "<th scope='col'>Reported Date</th>";
        echo "<th scope='col'>Priority</th> ";
        echo "<th scope='col'>Status</th>";
        echo "<th scope='col'>Description</th>";
        echo "<th scope='col'>Solution</th>"; 
        echo "<th scope='col'>Repair Date</th>";
        echo "<th scope='col'>Scheduled Date</th>";
        echo "<th scope='col'>Repair Price</th>";
        echo "<th scope='col'>Tenant</th>"; 
        echo "<th scope='col'>APT NUM</th>";
        echo "</tr>";
        echo "</thead>";
        // output data of each row
        while ($row = $results->fetchArray()) {
            echo "<tr>";
            echo "<td class='text-center'>".$row["IssueReportDate"]."</td>"; 
            echo "<td>".$row["IssuePriority"]. "</td>"; 
            echo "<td>".$row["IssueStatus"].  "</td>"; 
            echo "<td>".$row["IssueDescription"]."</td>"; 
            echo "<td>".$row["IssueSolution"]."</td>"; 
            echo "<td class='text-center'>".$row["IssueRepairDate"]."</td>";  
            echo "<td>".$row["ScheduledDate"]."</td>"; 
            echo "<td class='text-center'>".$row["IssueRepairPrice"]."</td>"; 
            echo "<td>".$row["Name"]."</td>"; 
            echo "<td class='text-center'>".$row["aptNumber"]."</td>";       
        } // end while
        echo "</table>"; // close the table 
        $db->close(); 
    }// end displayClosedIssues()

    function displayTenants(){
        $db = new SQLite3('../db/Tenants.sqlite');
        $results = $db->query("SELECT TenantEmail AS email, TenantFirstName || ' ' || TenantLastName AS name, TenantHomeNumber, TenantMobileNumber, 
        TenantWorkNumber, tenantApt.Apt_number AS aptNumber, tenantCity.Apt_City AS aptCity FROM Tenants
        JOIN Apartments tenantApt ON Tenants.TenantAptNum_FK = tenantApt.Apartment_ID 
        JOIN Apartments tenantCity ON Tenants.TenantCity_FK = tenantCity.Apartment_ID");
        while ($row = $results->fetchArray()) { 
            // Tenanat Information card
            echo "<div class='shadow p-3 mb-5 bg-white rounded'>";
            echo "<div class='card w-100'>";
            echo "<div class='card-body'>";
            echo "<h5 class='card-title'>" . $row["name"] . "</h5>";
            echo "<p class='card-text'><a href= 'mailto:" . $row["email"] . "'>" . $row["email"] . "</a></p>";
            echo "<p class='card-text'><b>Apt Number = </b>" . $row["aptNumber"] . "</p>";
            echo "<p class='card-text'><b>City = </b>" . $row["aptCity"] . "</p>";
            echo "<p class='card-text'><b>Home Number = </b>" . $row["TenantHomeNumber"] . "</p>";
            echo "<p class='card-text'><b>Mobile Number = </b>" . $row["TenantMobileNumber"] . "</p>";
            echo "<p class='card-text'><b>Work Number = </b>" . $row["TenantWorkNumber"] . "</p>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        } // end while
        $db->close(); 
    }// end displayTenants()

    function updateMaintIssue($issueID){
        // connect to the database
        $db = new SQLite3('../db/Tenants.sqlite');
        // select and display everything in the TenantMaintIssues Table
        $stmt = $db->prepare("SELECT TenantMaintIssue_ID AS ID, IssueReportDate, IssuePriority, IssueStatus, IssueDescription, IssueSolution, IssueRepairDate,
        ScheduledDate, IssueRepairPrice, tenantFname.TenantFirstName || ' ' || tenantLname.TenantLastName AS Name,tenantApt.Apt_number AS aptNumber
        FROM TenantMaintIssues 
        JOIN Tenants tenantFname ON TenantMaintIssues.Tenant_FK = tenantFname.Tenant_ID
        JOIN Tenants tenantLname ON TenantMaintIssues.Tenant_FK = tenantLname.Tenant_ID
        JOIN Apartments tenantApt ON TenantMaintIssues.Tenant_Apt_FK = tenantApt.Apartment_ID
        WHERE TenantMaintIssue_ID = :issueID ");
        $stmt->bindValue(':issueID', $issueID, SQLITE3_INTEGER);
        $result = $stmt->execute();
        $row = $result->fetchArray();
        if ($row["ID"] > 0){
            // assign variables
            $id = $row['ID'];
            $issueReportDate = strtotime($row['IssueReportDate']);
            $IssuePriority = $row['IssuePriority'];
            $IssueStatus = $row['IssueStatus'];
            $IssueDescription = $row['IssueDescription'];
            $IssueSolution = $row['IssueSolution'];
            $issueRepairDate = strtotime($row['IssueRepairDate']);
            $issueScheduledDate = strtotime($row['ScheduledDate']);
            $IssueRepairPrice = $row['IssueRepairPrice'];
            $tenantName = $row['Name'];
            $aptNumber = $row['aptNumber'];
            $reportDate = date('Y-m-d',$issueReportDate);
            if (!empty($issueScheduledDate)) {
                $scheduledDate = date('Y-m-d',$issueScheduledDate);
            } else {
                $scheduledDate ="";
            }
            if (!empty($issueRepairDate)) {
                $repairDate = date('Y-m-d',$issueRepairDate);
            } else {
                $repairDate = "";
            }
            // create the form
            echo "<form id='update-form' action='confirmUpdate.php' method='POST'>";
            echo "<fieldset class='form-group'>";
            echo "<legend>Maint Issue:</legend>";
            echo "<label for='issueID'>Issue ID:</label>";
            echo "<input class='form-control' type='text' id='issueID' name='id' value='".$id."' readonly>";
            echo "<label for='IssueReportDate'>Reported:</label><input class='form-control' type='date' id='IssueReportDate' name='IssueReportDate' value='".$reportDate."' readonly>";
            echo "<label for='Priority'>Priority:</label><select id='Priority' class='form-control' name='IssuePriority'>";
            echo "<option value='".$IssuePriority."'>".$IssuePriority."</option>";
            echo "<option value='High'>High</option>";
            echo "<option value='Medium'>Medium</option>";
            echo "<option value='Low'>Low</option>";
            echo "</select>"; 
            echo "<label for='Status'>Status:</label><select id='Status' class='form-control' name='IssueStatus'>";
            echo "<option value='".$IssueStatus."'>".$IssueStatus."</option>";
            echo "<option value='pending'>pending</option>";
            echo "<option value='closed'>closed</option>";
            echo "</select><br>"; 
            echo "</fieldset>";
            // description field
            echo "<fieldset class='form-group'>";
            echo "<label for='Description'>Description:</label>";
            echo "<textarea class='form-control' name='IssueDescription' rows='2' cols='33' id='Description' readonly>".$IssueDescription."</textarea>";
            echo "</fieldset>";
            // solution field
            echo "<fieldset class='form-group'>";
            echo "<label for='Solution'>Solution:</label>";
            echo "<textarea  id='Solution' class='form-control' name='IssueSolution' rows='2' cols='33'>".$IssueSolution."</textarea><br>";
            echo "</fieldset> ";
            // update info fieldset
            echo "<fieldset class='form-group'>";
            echo "<legend>Repair Info:</legend>";
            echo "<label for='Scheduled'>Scheduled:</label> <input id='Scheduled' class='form-control' type='date' name='ScheduledDate' value='".$scheduledDate."'>";
            echo "<label for='Repaired'>Repaired:</label> <input id='Repaired' class='form-control' type='date' name='IssueRepairDate' value='".$repairDate."'>";
            echo "<label for='RepairPrice'> Repair Price:</label><input id='RepairPrice' class='form-control' type='text' name='IssueRepairPrice' value='".$IssueRepairPrice."'><br>";
            echo "</fieldset>";
            // tenant name field
            echo "<fieldset class='form-group'>";
            echo "<label for='TenantName'>Tenant Name:</label>";
            echo "<input class='form-control' type='text' name='tenantName' id='TenantName' value='".$tenantName."' readonly><br>";
            echo "</fieldset>";
            // tenant apt number field
            echo "<fieldset class='form-group'>";
            echo "<label for='TenantApt'>Tenant Apt Number:</label>";
            echo "<input class='form-control' type='text' name='aptNumber' id='TenantApt' value='".$aptNumber."' readonly><br>";
            echo "</fieldset>";
            // submit button
            echo "<input id='update-btn' class='btn btn-primary' type='submit' value='UPDATE'>";
            echo "</form>";
        }else {
            echo "Issue ID not found";
        } // end if 
        $db->close();
    }

?>