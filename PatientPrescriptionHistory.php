<?php
    require_once("connect.php");

if (isset($_COOKIE["email"])) {
    $email = $_COOKIE["email"];

    
    $sql = "SELECT PatientSSN FROM patients WHERE email='$email'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $patientSSN = $row["PatientSSN"];
    } else {
        die("Error: Patient SSN not found in the database.");
    }
} else {
    die("Error: Patient SSN not found in cookies.");
}

$sql = "SELECT * FROM prescriptions WHERE PatientSSN='$patientSSN'";
$result = $conn->query($sql);
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
                <li><a href="patient.html">Dashboard</a></li>
                <li class="active"><a href="PatientPrescriptionHistory.php">Prescriptions</a></li>
                <li><a href="login.html">Logout</a></li>
            </ul>
        </div>

    <h1>Patient Prescription Table</h1>
    <table>
        <tr>
            <th>Patient SSN</th>
            <th>Doctor ID</th>
            <th>Trade Name</th>
            <th>Quantity</th>
        </tr>
        <?php
        
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["PatientSSN"] . "</td>";
                echo "<td>" . $row["DoctorID"] . "</td>";
                echo "<td>" . $row["TradeName"] . "</td>";
                echo "<td>" . $row["Quantity"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='4'>No data found</td></tr>";
        }
        ?>
    </table>
    </div>

    <?php
    mysqli_close($conn);
    ?>
</body>

</html>
