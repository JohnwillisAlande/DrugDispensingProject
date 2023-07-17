<?php
require_once 'Connect.php';

$searchValue = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $searchValue = $_POST["searchValue"] ?? "";
    if (empty($searchValue)) {
        echo "Error: Please fill in all the fields.";
    } else {
        $sqlGetPatient = "SELECT * FROM PRESCRIPTION WHERE PatientSSN='$searchValue'";
        $result = $conn->query($sqlGetPatient);
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Patient Records</title>
    <style>
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    th,
    td {
        border: 1px solid black;
        padding: 8px;
    }

    th {
        background-color: #f2f2f2;
    }

    .container {
        padding: 20px;
    }

    .search-form {
        margin-bottom: 20px;
    }

    .search-form input[type="text"] {
        padding: 8px;
        width: 200px;
    }

    .search-form input[type="submit"] {
        padding: 8px 16px;
        background-color: #4CAF50;
        color: white;
        border: none;
        cursor: pointer;
    }

    .search-results {
        margin-top: 20px;
    }

    .search-results table {
        width: 100%;
        border-collapse: collapse;
    }

    .search-results th,
    .search-results td {
        border: 1px solid black;
        padding: 8px;
    }

    .search-results th {
        background-color: #f2f2f2;
    }

    .no-results {
        margin-top: 10px;
        color: #f00;
    }
    </style>
</head>

<body>
    <div class="container">
        <h1>PATIENT RECORDS</h1>
        <ul>
            <li><a href="./Pharmacy.html">Dashboard</a></li>
            <li><a href="./PharmacyStock.php">Stock</a></li>
            <li><a href="./PharmacyPatient.php">Patients</a></li>
            <li><a href="./PharmacyContracts.php">Contracts</a></li>
        </ul>
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
                echo "<h2>Search Results</h2>";
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
                        echo "<td>" . $row['tradeName'] . "</td>";
                        echo "<td>" . $row['quantity'] . "</td>";
                        echo "<td>" . $row['doctorID'] . "</td>";
                        echo "<td>" . $row['patientSSN'] . "</td>";
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