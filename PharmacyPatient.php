<?php
require_once 'Connect.php';

$searchValue = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $searchValue = $_POST["searchValue"] ?? "";
    if (empty($searchValue)) {
        echo "Error: Please fill in all the fields.";
    } else {
        $sqlGetPatient = "SELECT * FROM Prescriptions WHERE PatientSSN='$searchValue'";
        $result = $conn->query($sqlGetPatient);
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Patient Records</title>
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
        <div class="search-form">
            <form method="post" action="PharmacyPatient.php">
                <input type="text" name="searchValue" placeholder="Search for patient...">
                <input type="submit" value="Submit">
            </form>
        </div>

        <div class="search-results">
            <?php
            // Display the search results below the search button
            if ($_SERVER["REQUEST_METHOD"] === "POST" && !empty($searchValue)) {
                echo "<h1>Search Results</h1>";
                // Display the table only if there are results
                if ($result->num_rows > 0) {
                    echo "<table>";
                    echo "<tr>
                            <th>Trade Name</th>
                            <th>Quantity</th>
                            <th>Doctor ID</th>
                            <th>Patient SSN</th>
                          </tr>";

                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['TradeName'] . "</td>";
                        echo "<td>" . $row['Quantity'] . "</td>";
                        echo "<td>" . $row['DoctorID'] . "</td>";
                        echo "<td>" . $row['PatientSSN'] . "</td>";
                        echo "</tr>";
                    }

                    echo "</table>";
                } else {
                    echo "<p class='no-results'>No results found.</p>";
                }
            }
            ?>
        </div>
    </div>

    <?php
    // Close the database connection
    mysqli_close($conn);
    ?>
</body>

</html>