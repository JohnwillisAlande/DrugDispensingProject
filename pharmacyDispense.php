<?php
require_once("connect.php");

if (isset($_COOKIE["email"])) {
    $email = $_COOKIE["email"];

    // Get the pharmacy ID from the database
    $sql = "SELECT pharmacyID FROM pharmacy WHERE email='$email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $pharmacyID = $row["pharmacyID"];
    } else {
        die("Error: Pharmacy ID not found in the database.");
    }
} else {
    die("Error: Pharmacy ID not found in cookies.");
}

$dispensed = false; // Initialize the $dispensed variable


if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $tradename = $_POST["tradename"] ?? "";
    $quantity = filter_var($_POST["quantity"] ?? "", FILTER_SANITIZE_NUMBER_INT);

    if (empty($tradename) || empty($quantity)) {
        die("Error: Please fill in all the fields.");
    }

    
    $sql = "SELECT * FROM stock WHERE pharmacyID='$pharmacyID' AND tradename='$tradename'";
    $result = $conn->query($sql);
    if ($result->num_rows === 0) {
        die("Error: Drug not found in stock.");
    }
    $row = $result->fetch_assoc();
    $stockQuantity = $row["Quantity"];
    if ($quantity > $stockQuantity) {
        die("Error: Insufficient stock.");
    }

    
    $updatedQuantity = $stockQuantity - $quantity;
    $sql = "UPDATE stock SET quantity='$updatedQuantity' WHERE pharmacyID='$pharmacyID' AND tradename='$tradename'";
    if ($conn->query($sql) === TRUE) {
        
        $price = $row["Price"] * $quantity;
        $sql = "INSERT INTO dispensing (pharmacyID, tradename, quantity, price) VALUES ('$pharmacyID', '$tradename', '$quantity', '$price')";
        if ($conn->query($sql) === TRUE) {
            $dispensed = true; 
            echo "Data stored successfully.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


$sql = "SELECT * FROM stock WHERE pharmacyID='$pharmacyID'";
$result = $conn->query($sql);


$sql = "SELECT * FROM dispensing WHERE pharmacyID='$pharmacyID'";
$dispensingResult = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Pharmacy Dispense</title>
    <link rel="stylesheet" href="styles.css">
    <script>
        
        function updatePrice() {
            const priceInput = document.getElementById("price");
            const quantityInput = document.getElementById("quantity");
            const stockPrice = <?= $row["price"] ?? 0 ?>;
            const quantity = parseInt(quantityInput.value) || 0;
            priceInput.value = (stockPrice * quantity).toFixed(2);
        }
    </script>
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
    <h1>Pharmacy Dispense</h1>

    <form method="post" action="pharmacyDispense.php" class="form-container">
        
        <label for="tradename">Trade Name:</label>
        <input type="text" name="tradename" required><br>

        <label for="quantity">Quantity:</label>
        <input type="number" name="quantity" required oninput="updatePrice()"><br>

        <input type="submit" value="Dispense">
    </form>

    <br>
    <h1>Pharmacy Stock Table</h1>
    <table>
        <tr>
            <th>Trade Name</th>
            <th>Quantity</th>
            <th>Price</th>
        </tr>
        <?php
    
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["TradeName"] . "</td>";
                echo "<td>" . $row["Quantity"] . "</td>";
                echo "<td>" . $row["Price"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='3'>No data found</td></tr>";
        }
        ?>
    </table>

    <br>
    <h1>Pharmacy Dispensing Table</h1>
    <table>
        <tr>
            <th>Trade Name</th>
            <th>Quantity</th>
            <th>Price</th>
            <th>Action</th>
        </tr>
        <?php
        
        if ($dispensingResult->num_rows > 0) {
            while ($row = $dispensingResult->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["TradeName"] . "</td>";
                echo "<td>" . $row["Quantity"] . "</td>";
                echo "<td>" . $row["Price"] . "</td>";
                echo "<td><a href='editDispensing.php?id=" . $row["id"] . "'>Edit</a></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No data found</td></tr>";
        }
        ?>
    </table>

    <?php
    if ($dispensed) {
        
        $sql = "SELECT tradename, SUM(quantity) as total_quantity, SUM(price) as total_price FROM dispensing WHERE pharmacyID='$pharmacyID' GROUP BY tradename";
        $receiptResult = $conn->query($sql);
        if ($receiptResult->num_rows > 0) {
            echo "<br>";
            echo "<h3>Thank You</h3>";
            echo "<h4>Purchase Details</h4>";
            echo "<table>";
            echo "<tr>";
            echo "<th>Trade Name</th>";
            echo "<th>Quantity</th>";
            echo "<th>Price</th>";
            echo "</tr>";
            while ($row = $receiptResult->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["tradename"] . "</td>";
                echo "<td>" . $row["total_quantity"] . "</td>";
                echo "<td>" . $row["total_price"] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
            echo "<br>";
            echo "<button onclick='window.print()'>Print Receipt</button>";
        }
    }
    ?>
</body>
</html>
