<?php
if (isset($_COOKIE["userType"]) && $_COOKIE["userType"] !== "Admin") {
    header("Location: login.html");
    exit; // Make sure to include exit or die to prevent further script execution
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Admin</title>
    <link rel="stylesheet" href="styles.css">
    <script>
    function updateEditSQL(row) {
        var cells = row.getElementsByTagName("td");
        var editSQL = "";

        for (var i = 0; i < cells.length - 1; i++) {
            var cell = cells[i];
            var columnName = cell.getAttribute("data-column");
            var cellValue = cell.textContent;

            editSQL += columnName + "='" + cellValue + "', ";
        }

        editSQL = editSQL.slice(0, -2);

        var editLink = row.querySelector("a.edit-link");
        var editURL = editLink.getAttribute("href");

        var updatedURL = editURL.replace(/&editSQL=([^&]*)/, "&editSQL=" + encodeURIComponent(editSQL));
        editLink.setAttribute("href", updatedURL);
    }
    </script>
</head>

<body>
    <div class="background-container" style="position: absolute; top: -10; right: 5; padding: 10px;">
        <div class="navbar">
            <img src="images/afyahealth.png" class="logo">
            <ul>
                <li><a href="login.html">LogOut</a></li>
            </ul>
        </div>
    </div>

    <div class="form-container">
        <div style="flex-direction: row; display: flex; width: 1000px; justify-content: space-between;">
            <div><a href="?table=Patients">Patients</a></div>
            <div><a href="?table=Doctors">Doctor</a></div>
            <div><a href="?table=Supervisor">Supervisor</a></div>
            <div><a href="?table=Pharmacy">Pharmacy</a></div>
            <div><a href="?table=PharmaceuticalCompany">Pharmaceutical Company</a></div>
        </div>
    </div>

    <?php
    require_once 'Connect.php';

    $tableName = "Patients"; 

    if (isset($_GET['table'])) {
        $table = $_GET['table'];
        if ($table === "Patients" || $table === "Doctors" || $table === "Supervisor" || $table === "Pharmacy" || $table === "PharmaceuticalCompany") {
            $tableName = $table;
          
            if ($tableName === "Doctors") {
                $query = "SELECT DoctorID, DoctorSSN, DoctorName, Email, Specialty, Contact FROM $tableName";
            } elseif ($tableName === "Supervisor") {
                $query = "SELECT SupervisorID, SupervisorName, Email, Contact FROM $tableName";
            } elseif ($tableName === "Pharmacy") {
                $query = "SELECT PharmacyID, PharmacyName, Email, Contact, PharmacyAddress, StoreID FROM $tableName";
            } elseif ($tableName === "PharmaceuticalCompany") {
                $query = "SELECT CompanyID, CompanyName, Email, Contact FROM $tableName";
            } else {
                $query = "SELECT * FROM $tableName";
            }

            $result = mysqli_query($conn, $query);
        }
    }

        
    function deleteAccount($conn, $tableName, $id) {
        $NameID;
        if($tableName=="Doctors"){
            $NameID="DoctorID";

        }if($tableName=="Patients"){
            $NameID="PatientID";

        }if($tableName=="Pharmacy"){
            $NameID="PharmacyID";

        }if($tableName=="PharmaceuticalCompany"){
             $NameID="CompanyID";

        }if($tableName==="Supervisor"){
             $NameID="SupervisorID";
        }
        $query = "UPDATE  $tableName SET isDisabled=true WHERE '$NameID'  = '$id'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo "Account deleted successfully.";
        } else {
            echo "Error deleting account: " . mysqli_error($conn);
        }
    }

    function editAccount($conn, $table, $id, $editSQL) {
        $NameID;
        if($table=="Doctors"){
            $NameID="DoctorID";
            
        }if($table=="Patients"){
            $NameID="PatientID";

        }if($table=="Pharmacy"){
            $NameID="PharmacyID";

        }if($table=="PharmaceuticalCompany"){
             $NameID="CompanyID";

        }if($table==="Supervisor"){
             $NameID="SupervisorID";
        }
        $tableName = mysqli_real_escape_string($conn, $table);
        $query = "UPDATE $tableName SET $editSQL WHERE '$NameID' = '$id'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            echo $tableName, "   ", $editSQL;
        } else {
            echo "Error updating account: " . mysqli_error($conn);
        }
    }

    if (isset($_GET['action'])) {
        $action = $_GET['action'];

        if ($action === "delete" && isset($_GET['id'])) {
            $id = $_GET['id'];
            deleteAccount($conn, $tableName, $id);
        } elseif ($action === "edit" && isset($_GET['id']) && isset($_GET['editSQL']) && isset($_GET['table'])) {
            $id = $_GET['id'];
            $editSQL = $_GET['editSQL'];
            $table = $_GET['table'];
            editAccount($conn, $table, $id, $editSQL);
        }
    }

    function getTableData($conn, $tableName)
    {
        
        $query = "SELECT * FROM $tableName";
        $result = mysqli_query($conn, $query);

        
        if ($result) {
           
            echo '<table>';
            echo '<tr>';

            
            $fieldNames = mysqli_fetch_fields($result);
            foreach ($fieldNames as $field) {
                if ($field->name !== 'Password') {
                    echo '<th>' . $field->name . '</th>';
                }
            }

            echo '</tr>';

            
            while ($row = mysqli_fetch_assoc($result)) {
                echo '<tr>';
                $id = $row[array_keys($row)[0]]; 

                $editSQL = ""; 

                foreach ($row as $key => $value) {
                    
                    if ($key !== 'Password') {
                        echo '<td contenteditable="true" data-column="' . $key . '">' . $value . '</td>';
                        $editSQL .= "$key='$value', "; 
                    }
                }

                $editSQL = rtrim($editSQL, ', '); 

                echo '<td><a class="edit-link" href="?action=edit&table=' . $tableName . '&id=' . $id . '&editSQL=' . urlencode($editSQL) . '">Edit</a> <a href="?action=delete&table=' . $tableName . '&id=' . $id . '">Delete Account</a></td>';
                echo '</tr>';
            }

            echo '</table>';
        } else {
           
            echo "Error: " . mysqli_error($conn);
        }
    }

    getTableData($conn, $tableName);
    ?>

    <script>
    function updateEditSQL(row) {
        var cells = row.getElementsByTagName("td");
        var editSQL = "";

        for (var i = 0; i < cells.length - 1; i++) {
            var cell = cells[i];
            var columnName = cell.getAttribute("data-column");
            var cellValue = cell.textContent;

            editSQL += columnName + "='" + cellValue + "', ";
        }

        editSQL = editSQL.slice(0, -2);

        var editLink = row.querySelector("a.edit-link");
        var editURL = editLink.getAttribute("href");
        var updatedURL = editURL.split("editSQL=")[0] + "editSQL=" + encodeURIComponent(editSQL);
        editLink.setAttribute("href", updatedURL);
    }
    </script>


</body>

</html>