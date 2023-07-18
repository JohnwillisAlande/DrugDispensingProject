<?php
require_once("connect.php");

$pharmacyID = "";
$tradename = "";
$quantity = "";
$price = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validate and sanitize user inputs
    $tradename = $_POST["tradename"] ?? null;
    $quantity = $_POST["quantity"] ?? null;
    $price = $_POST["price"] ?? null;

    // Check if the inputs are not empty
    if (empty($tradename) || empty($quantity) || empty($price)) {
        echo "Error: Please fill in all the fields.";
    } else {
        // Check if cookies are set and get values from cookies
        if (isset($_COOKIE["email"])) {
            $email = $_COOKIE["email"];

            // Get the pharmacy ID from the database
            $sql = "SELECT pharmacyID FROM pharmacy WHERE email='$email'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $pharmacyID = $row["pharmacyID"];

                // Store data in the 'drugs' table
                $sql = "INSERT INTO stock (pharmacyID, tradename, quantity, price) VALUES ('$pharmacyID', '$tradename', '$quantity', '$price')";

                if ($conn->query($sql) === TRUE) {
                    echo "Data stored successfully.";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                echo "Error: Pharmacy ID not found in database.";
            }
        } else {
            echo "Error: Pharmacy ID not found in cookies.";
        }
    }
}

// Retrieve data from the 'stock' table
$sql1 = "SELECT * FROM stock";
$result = mysqli_query($conn,$sql1);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Pharmacy Stock</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
<div class="banner" style="position: absolute; top: -10; right: 5; padding: 10px;">
        <div class="navbar">
            <img src="images/afyahealth.png" class="logo">
            <ul>
                <li><a href="pharmacy.html">Dashboard</a></li>
                <li><a href="pharmacyStock.php">Stock</a></li>
                <li><a href="#">Patient</a></li>
                <li><a href="pharmacyDispense.php">Dispense</a></li>
                <li><a href="#">Contracts</a></li>
            </ul>
        </div>
    <h1>Pharmacy Stock</h1>

    <form method="post" action="pharmacyStock.php">
        <!-- Your HTML form for inputting tradename, quantity, and price -->
        <label for="tradename">Trade Name:</label>
        <input type="text" name="tradename" required><br>

        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" required><br>

        <label for="price">Price:</label>
        <input type="number" step="0.01" name="price" required><br>

        <input type="submit" value="Submit">
    </form>

    <br>
    <h2>Pharmacy Stock Table</h2>
    <table>
        <tr>
            <th>Pharmacy ID</th>
            <th>Trade Name</th>
            <th>Quantity</th>
            <th>Price</th>
        </tr>
        <?php
        // Display data from the 'drugs' table
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["PharmacyID"] . "</td>";
                echo "<td>" . $row["TradeName"] . "</td>";
                echo "<td>" . $row["Quantity"] . "</td>";
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
