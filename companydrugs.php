<?php
require_once("connect.php");

$companyID = "";
$tradename = "";
$formula = "";
$price = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validate and sanitize user inputs
    $tradename = $_POST["tradename"] ?? "";
    $formula = $_POST["formula"] ?? "";
    $price = $_POST["price"] ?? "";

    // Check if the inputs are not empty
    if (empty($tradename) || empty($formula) || empty($price)) {
        echo "Error: Please fill in all the fields.";
    } else {
        // Check if cookies are set and get values from cookies
        if (isset($_COOKIE["email"])) {
            $email = $_COOKIE["email"];

            // Get the company ID from the database
            $sql = "SELECT companyID FROM pharmaceuticalcompany WHERE email='$email'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $companyID = $row["companyID"];

                // Store data in the 'drugs' table
                $sql = "INSERT INTO drugs (companyID, tradename, formula, price) VALUES ('$companyID', '$tradename', '$formula', '$price')";

                if ($conn->query($sql) === TRUE) {
                    echo "Data stored successfully.";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                echo "Error: Company ID not found in database.";
            }
        } else {
            echo "Error: Company ID not found in cookies.";
        }
    }
}

// Retrieve data from the 'drugs' table
$sql1 = "SELECT * FROM drugs";
$result = mysqli_query($conn,$sql1);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Pharmaceutical Company Drugs</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
<div class="background-container" style="position: absolute; top: -10; right: 5; padding: 10px;">
        <div class="navbar">
            <img src="images/afyahealth.png" class="logo">
            <ul>
                <li><a href="pharmaceuticalCompany.html">Dashboard</a></li>
                <li><a href="companydrugs.php">Drugs</a></li>
                <li><a href="CompanyContracts.php">Contracts</a></li>
            </ul>
        </div>
    <h1>Pharmaceutical Company Drugs</h1>

    <form method="post" action="companydrugs.php" class="form-container">
      
        <label for="tradename">Trade Name:</label>
        <input type="text" name="tradename" required><br>

        <label for="formula">Formula:</label>
        <input type="text" name="formula" required><br>

        <label for="price">Price:</label>
        <input type="number" step="0.01" name="price" required><br>

        <input type="submit" value="Submit">
    </form>

    <br>
    <h1>Drug Data Table</h1>
    <table>
        <tr>
            <th>Company ID</th>
            <th>Trade Name</th>
            <th>Formula</th>
            <th>Price</th>
        </tr>
        <?php
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["CompanyID"] . "</td>";
                echo "<td>" . $row["TradeName"] . "</td>";
                echo "<td>" . $row["Formula"] . "</td>";
                echo "<td>" . $row["Price"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No data found</td></tr>";
        }
        ?>
    </table>

</body>

</html>
