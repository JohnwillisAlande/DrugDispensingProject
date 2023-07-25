<?php
require_once 'Connect.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the updated contract data from the form
    $contractID = $_POST["contractID"];
    $startDate = $_POST["startDate"] ?? '';
    $endingDate = $_POST["endDate"] ?? '';
    $pharmacyName = $_POST["pharmacyName"] ?? '';
    $companyName = $_POST["companyName"] ?? '';
    $supervisorName = $_POST["supervisorName"] ?? '';
    $contractDetails = $_POST["contractDetails"] ?? '';

    // Update the contract data in the database
    $sqlUpdateContract = "UPDATE CONTRACTS SET
        StartDate='$startDate',
        EndDate='$endingDate',
        PharmacyName='$pharmacyName',
        CompanyName='$companyName',
        SupervisorName='$supervisorName',
        ContractDetails='$contractDetails'
        WHERE ContractID='$contractID'";

    if (mysqli_query($conn, $sqlUpdateContract)) {
        echo "Contract updated successfully.";
    } else {
        echo "Error updating contract: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Contracts</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="background-container" style="position: absolute; top: -10; right: 5; padding: 10px;">
        <div class="navbar">
            <img src="images/afyahealth.png" class="logo">
            <ul>
                <li><a href="supervisor.html">Dashboard</a></li>
                <li><a href="SupervisorAdd.php">New Contract</a></li>
                <li><a href="SupervisorContracts.php">Contracts</a></li>
            </ul>
        </div>
        <h1>ALL CONTRACTS</h1>

        <?php
        // Check if the cookie is set
        if (isset($_COOKIE['userType']) && $_COOKIE['userType'] == "Supervisor") {
            // Retrieve the value of the cookie
            $name = $_COOKIE['name'];
            $sqlGetContracts = "SELECT * FROM CONTRACTS WHERE SupervisorName='$name'";
            $result = mysqli_query($conn, $sqlGetContracts);

            // Check if any contracts exist
            if (mysqli_num_rows($result) > 0) {
                // Display the contracts as input fields
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<form method='POST'>";
                    echo "<div class='contract'>";
                    echo "<label>Starting Date:     </label><input type='text' name='startDate' class='login-input' value='" . $row['StartDate'] . "'><br>";
                    echo "<label>Ending Date:      </label><input type='text' name='endDate' class='login-input' value='" . $row['EndDate'] . "'><br>";
                    echo "<label>Pharmacy Name:</label><input type='text' name='pharmacyName' class='login-input' value='" . $row['PharmacyName'] . "'><br>";
                    echo "<label>Company Name:</label><input type='text' name='companyName' class='login-input' value='" . $row['CompanyName'] . "'><br>";
                    echo "<label>Supervisor Name:</label><input type='text' name='supervisorName' class='login-input' value='" . $row['SupervisorName'] . "'><br>";
                    echo "<label>Contract Details:</label><input type='text' name='contractDetails' class='login-input' value='" . $row['ContractDetails'] . "'><br>";
                    echo "<button type='submit' name='contractID' value='" . $row['ContractID'] . "'><span></span>Save Changes</button>";
                    echo "</div>";
                    echo "</form>";
                }
            } else {
                echo "<p>No contracts found.</p>";
            }
        } else {
            echo "<p>Cookie 'userType' not set or invalid.</p>";
        }
        ?>
    </div>

    <?php
    // Close the database connection
    mysqli_close($conn);
    ?>
</body>

</html>