<?php
require_once 'Connect.php';
?>

<!DOCTYPE html>
<html>

<head>
<title>Pharmacy Contracts</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
<<<<<<< HEAD
<div class="background-container" style="position: absolute; top: -10; right: 5; padding: 10px;">
        <div class="navbar">
            <img src="images/afyahealth.png" class="logo">
            <ul>
                <li><a href="pharmaceuticalCompany.html">Dashboard</a></li>
                <li><a href="companydrugs.php">Stock</a></li>
                <li><a href="CompanyContracts.php">Contracts</a></li>
            </ul>
        </div>
=======
    <div>
        <ul>
            <li><a href='./PharmaceuticalCompany.html'>Dashboard</a></li>
            <li><a href='./CompanyDrugs.php'>Drug</a></li>
            <li><a href='./CompanyContracts.php'>Contracts</a></li>
        </ul>
    </div>
>>>>>>> a801101ff32fee1d5f857c5e83c132e6aea01c8a

    <h1>ALL CONTRACTS</h1>

    <div class="contract-container">
        <?php
        // Check if the cookie is set
        if (isset($_COOKIE['userType']) && $_COOKIE['userType'] == "PharmaceuticalCompany") {
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
                    echo "<label>Start Date:</label><span>" . $row['StartDate'] . "</span>";
                    echo "<label>Ending Date:</label><span>" . $row['EndingDate'] . "</span>";
                    echo "<label>Pharmacy Name:</label><span>" . $row['PharmacyName'] . "</span>";
                    echo "<label>Company Name:</label><span>" . $row['CompanyName'] . "</span>";
                    echo "<label>Supervisor Name:</label><span>" . $row['SupervisorName'] . "</span>";
                    echo "<label>Contract Details:</label><span>" . $row['ContractDetails'] . "</span>";
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