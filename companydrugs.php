<?php
require_once("connect.php");
if (isset($_COOKIE['companyID']) && isset($_COOKIE['tradename']) && isset($_COOKIE['formula']) && isset($_COOKIE['price'])) {
    $companyID = $_COOKIE['companyID'];
    $tradename = $_COOKIE['tradename'];
    $formula = $_COOKIE['formula'];
    $price = $_COOKIE['price'];

    // Store data in the 'drugs' table
    $sql = "INSERT INTO drugs (companyID, tradename, formula, price) VALUES ('$companyID', '$tradename', '$formula', '$price')";

    if ($conn->query($sql) === TRUE) {
        echo "Data stored successfully.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

// Retrieve data from the 'drugs' table
$sql = "SELECT * FROM drugs";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Pharmaceutical Company Drugs</title>
</head>

<body>
    <h1>Pharmaceutical Company Drugs</h1>

    <form method="post" action="pharmaceuticalcompany.php">
        <!-- Your HTML form for inputting companyID, tradename, formula, and price -->
        <label for="companyID">Company ID:</label>
        <input type="text" name="companyID" required><br>

        <label for="tradename">Trade Name:</label>
        <input type="text" name="tradename" required><br>

        <label for="formula">Formula:</label>
        <input type="text" name="formula" required><br>

        <label for="price">Price:</label>
        <input type="number" step="0.01" name="price" required><br>

        <input type="submit" value="Submit">
    </form>

    <br>
    <h2>Drug Data Table</h2>
    <table border="1">
        <tr>
            <th>Company ID</th>
            <th>Trade Name</th>
            <th>Formula</th>
            <th>Price</th>
        </tr>
        <?php
        // Display data from the 'drugs' table
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['companyID'] . "</td>";
                echo "<td>" . $row['tradename'] . "</td>";
                echo "<td>" . $row['formula'] . "</td>";
                echo "<td>" . $row['price'] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No data found</td></tr>";
        }
        ?>
    </table>

</body>

</html>