<?php
require_once 'Connect.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the updated contract data from the form
    $startDate = $_POST["startDate"] ?? '';
    $endingDate = $_POST["endDate"] ?? '';
    $pharmacyName = $_POST["pharmacyName"] ?? '';
    $companyName = $_POST["companyName"] ?? '';
    $contractDetails = $_POST["contractDetails"] ?? '';

    function generateRandomID()
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $length = 10;
        $randomID = '';
        for ($i = 0; $i < $length; $i++) {
            $randomID .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomID;
    }

    $ContractID = generateRandomID();
    $supervisorName = $_COOKIE["name"];

    // Update the contract data in the database
    $sqlAddContract = "INSERT INTO CONTRACTS (ContractID, StartDate, EndDate, PharmacyName, CompanyName, SupervisorName, ContractDetails) VALUES ('$ContractID', '$startDate', '$endingDate', '$pharmacyName', '$companyName', '$supervisorName', '$contractDetails')";

    if (mysqli_query($conn, $sqlAddContract)) {
        echo "Contract updated successfully.";
    } else {
        echo "Error updating contract: " . mysqli_error($conn);
    }
}

// Retrieve pharmacy names from the database
$sqlPharmacyNames = "SELECT PharmacyName FROM Pharmacy";
$resultPharmacyNames = mysqli_query($conn, $sqlPharmacyNames);
$pharmacyNames = mysqli_fetch_all($resultPharmacyNames, MYSQLI_ASSOC);

// Retrieve company names from the database
$sqlCompanyNames = "SELECT CompanyName FROM PharmaceuticalCompany";
$resultCompanyNames = mysqli_query($conn, $sqlCompanyNames);
$companyNames = mysqli_fetch_all($resultCompanyNames, MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html>

<head>
    <title>Contract List</title>
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
        <h1>NEW CONTRACT</h1>

        <?php
        // Check if the cookie is set
        if (isset($_COOKIE['userType']) && $_COOKIE['userType'] == "Supervisor") {
            // Retrieve the value of the cookie
            $name = $_COOKIE['name'];

            echo "<form method='POST'>";
            echo "<div class='contract'>";
            echo "<label>Start Date:</label><input type='text' class='login-input' name='startDate'><br>";
            echo "<label>End Date:</label><input type='text' class='login-input' name='endDate'><br>";
            
            // Dropdown for pharmacy names
            echo "<label>Pharmacy Name:</label>";
            echo "<select name='pharmacyName' class='login-input'>";
            foreach ($pharmacyNames as $pharmacy) {
                echo "<option value='" . $pharmacy['PharmacyName'] . "'>" . $pharmacy['PharmacyName'] . "</option>";
            }
            echo "</select><br>";
            
            // Dropdown for company names
            echo "<label>Company Name:</label>";
            echo "<select name='companyName' class='login-input'>";
            foreach ($companyNames as $company) {
                echo "<option value='" . $company['CompanyName'] . "'>" . $company['CompanyName'] . "</option>";
            }
            echo "</select><br>";
            
            echo "<label>Contract Details:</label><input type='text' class='login-input' name='contractDetails'><br>";
            echo "<button type='submit' name='contractID'><span></span>Save Changes</button>";
            echo "</div>";
            echo "</form>";
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