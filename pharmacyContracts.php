<?php
require_once 'Connect.php';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Contract List</title>
    <style>
    table {
        width: 100%;
        border-collapse: collapse;
    }

    th,
    td {
        border: 1px solid black;
        padding: 8px;
    }

    th {
        background-color: #f2f2f2;
    }

    .table-container {
        margin-bottom: 20px;
    }
    </style>
</head>

<body>
    <div>
        <ul>
            <li><a href='./Pharmacy.html'>Dashboard</a></li>
            <li><a href='./PharmacyStock.php'>Stock</a></li>
            <li><a href='./PharmacyPatient.php'>Patients</a></li>
            <li><a href='./PharmacyContracts.php'>Contracts</a></li>
        </ul>
    </div>

    <h1>ALL CONTRACTS</h1>

    <div class="table-container">
        <?php
        // Check if the cookie is set
        if (isset($_COOKIE['userType']) && $_COOKIE['userType'] == "PharmaceuticalCompany") {
            // Retrieve the value of the cookie
            $name = $_COOKIE['name'];
            $sqlGetContracts = "SELECT * FROM CONTRACTS WHERE PharmacyName='$name'";
            $result = mysqli_query($conn, $sqlGetContracts);

            // Check if any contracts exist
            if (mysqli_num_rows($result) > 0) {
                // Display the contracts in an HTML table
                echo "<table>";
                echo "<tr>
                        <th>Contract ID</th>
                        <th>Start Date</th>
                        <th>Ending Date</th>
                        <th>Pharmacy Name</th>
                        <th>Company Name</th>
                        <th>Supervisor Name</th>
                        <th>Contract Details</th>
                      </tr>";

                // Iterate over each row of the result set
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . $row['ContractID'] . "</td>";
                    echo "<td>" . $row['StartDate'] . "</td>";
                    echo "<td>" . $row['EndingDate'] . "</td>";
                    echo "<td>" . $row['PharmacyName'] . "</td>";
                    echo "<td>" . $row['CompanyName'] . "</td>";
                    echo "<td>" . $row['SupervisorName'] . "</td>";
                    echo "<td>" . $row['ContractDetails'] . "</td>";
                    echo "</tr>";
                }

                echo "</table>";
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