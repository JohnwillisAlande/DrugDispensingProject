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

    <div class="background-container" style="position: absolute; top: -10; right: 5; padding: 10px;">
        <div class="navbar">
            <img src="images/afyahealth.png" class="logo">
            <ul>
                <li><a href='./PharmaceuticalCompany.html'>Dashboard</a></li>
                <li><a href='./CompanyDrugs.php'>Drug</a></li>
                <li><a href='./CompanyContracts.php'>Contracts</a></li>
            </ul>
        </div>


        <div class="contract-container">
            <h1>ALL CONTRACTS</h1>

            <div class="contract-container">
                <?php
        // Check if the cookie is set
        if (isset($_COOKIE['userType']) && $_COOKIE['userType'] == "PharmaceuticalCompany") {
           
            $name = $_COOKIE['name'];
            $sqlGetContracts = "SELECT * FROM CONTRACTS WHERE CompanyName='$name'";
            $result = mysqli_query($conn, $sqlGetContracts);

            
            if (mysqli_num_rows($result) > 0) {
                
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

            <<<<<<< HEAD <?php
   
=======
        <?php
    // Close the database connection
>>>>>>> 51e754bdd2bc37f9e662c58f73f3741f0a9e2849
    mysqli_close($conn);
    ?> </body>

</html>