<?php
require_once 'Connect.php';
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
                <li><a href="pharmacy.html">Dashboard</a></li>
                <li><a href="pharmacyStock.php">Stock</a></li>
                <li><a href="PharmacyPatient.php">Patient</a></li>
                <li><a href="pharmacyDispense.php">Dispense</a></li>
                <li><a href="pharmacyContracts.php">Contracts</a></li>
            </ul>
        </div>

    <h1>ALL CONTRACTS</h1>

    <div class="contract-container">
        <?php
        // Check if the cookie is set
        if (isset($_COOKIE['userType']) && $_COOKIE['userType'] == "Pharmacy") {
            // Retrieve the value of the cookie
            $name = $_COOKIE['name'];
            $sqlGetContracts = "SELECT * FROM CONTRACTS WHERE CompanyName='$name'";
            $result = mysqli_query($conn, $sqlGetContracts);

            // Check if any contracts exist
            if (mysqli_num_rows($result) > 0) {
                // Display the contracts
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='contract'>";
                    echo "<label>Contract ID:</label><span>" . $row['ContractID'] . "</span>";
                    echo "<label>Start Date:</label><span><input type='text' value='" . $row['StartDate'] . "' readonly></span>";
                    echo "<label>Ending Date:</label><span><input type='text' value='" . $row['EndingDate'] . "' readonly></span>";
                    echo "<label>Pharmacy Name:</label><span><input type='text' value='" . $row['PharmacyName'] . "' readonly></span>";
                    echo "<label>Company Name:</label><span><input type='text' value='" . $row['CompanyName'] . "' readonly></span>";
                    echo "<label>Supervisor Name:</label><span><input type='text' value='" . $row['SupervisorName'] . "' readonly></span>";
                    echo "<label>Contract Details:</label><span><input type='text' value='" . $row['ContractDetails'] . "' readonly></span>";
                    echo "<button type='button'>Edit</button>";
                    echo "</div>";
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