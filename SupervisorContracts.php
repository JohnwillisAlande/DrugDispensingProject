<?php
require_once 'Connect.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the updated contract data from the form
    $contractID = $_POST["contractID"];
    $startDate = $_POST["startDate"] ?? '';
    $endingDate = $_POST["endingDate"] ?? '';
    $pharmacyName = $_POST["pharmacyName"] ?? '';
    $companyName = $_POST["companyName"] ?? '';
    $supervisorName = $_POST["supervisorName"] ?? '';
    $contractDetails = $_POST["contractDetails"] ?? '';

    // Update the contract data in the database
    $sqlUpdateContract = "UPDATE CONTRACTS SET
        StartDate='$startDate',
        EndingDate='$endingDate',
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
    <title>Contract List</title>
    <style>
    .container {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 20px;
    }

    .contract {
        margin-bottom: 20px;
    }

    .contract label {
        font-weight: bold;
        margin-right: 10px;
    }

    .contract input[type="text"] {
        width: 300px;
        padding: 5px;
        margin-right: 10px;
    }

    .contract button {
        padding: 5px 10px;
    }
    </style>
</head>

<body>
    <div class="container">
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
                    echo "<label>Contract ID:</label><span>" . $row['ContractID'] . "</span><br>";
                    echo "<label>Start Date:</label><input type='text' name='startDate' value='" . $row['StartDate'] . "'><br>";
                    echo "<label>Ending Date:</label><input type='text' name='endingDate' value='" . $row['EndingDate'] . "'><br>";
                    echo "<label>Pharmacy Name:</label><input type='text' name='pharmacyName' value='" . $row['PharmacyName'] . "'><br>";
                    echo "<label>Company Name:</label><input type='text' name='companyName' value='" . $row['CompanyName'] . "'><br>";
                    echo "<label>Supervisor Name:</label><input type='text' name='supervisorName' value='" . $row['SupervisorName'] . "'><br>";
                    echo "<label>Contract Details:</label><input type='text' name='contractDetails' value='" . $row['ContractDetails'] . "'><br>";
                    echo "<button type='submit' name='contractID' value='" . $row['ContractID'] . "'>Save Changes</button>";
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