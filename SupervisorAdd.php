<?php
require_once 'Connect.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Get the updated contract data from the form
    $startDate = $_POST["startDate"] ?? '';
    $endingDate = $_POST["endingDate"] ?? '';
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
    $sqlAddContract = "INSERT INTO CONTRACTS (ContractID, StartDate, EndingDate, PharmacyName, CompanyName, SupervisorName, ContractDetails) VALUES ('$ContractID', '$startDate', '$endingDate', '$pharmacyName', '$companyName', '$supervisorName', '$contractDetails')";

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

            echo "<form method='POST'>";
            echo "<div class='contract'>";
            echo "<label>Start Date:</label><input type='text' name='startDate'><br>";
            echo "<label>Ending Date:</label><input type='text' name='endingDate'><br>";
            
            // Dropdown for pharmacy names
            echo "<label>Pharmacy Name:</label>";
            echo "<select name='pharmacyName'>";
            foreach ($pharmacyNames as $pharmacy) {
                echo "<option value='" . $pharmacy['PharmacyName'] . "'>" . $pharmacy['PharmacyName'] . "</option>";
            }
            echo "</select><br>";
            
            // Dropdown for company names
            echo "<label>Company Name:</label>";
            echo "<select name='companyName'>";
            foreach ($companyNames as $company) {
                echo "<option value='" . $company['CompanyName'] . "'>" . $company['CompanyName'] . "</option>";
            }
            echo "</select><br>";
            
            echo "<label>Contract Details:</label><input type='text' name='contractDetails'><br>";
            echo "<button type='submit' name='contractID'>Save Changes</button>";
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