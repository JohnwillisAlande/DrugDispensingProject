<?php
require_once("connect.php");

$prescriptionID = "";
$doctorID = "";
$patientID = "";
$patientSSN = "";
$tradename = "";
$quantity = "";
$datePrescribed = "";

// Function to generate a random ID
function generateRandomID() {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $length = 10;
    $randomID = '';
    for ($i = 0; $i < $length; $i++) {
        $randomID .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomID;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validate and sanitize user inputs
    $patientSSN = $_POST["patientSSN"] ?? null;
    $tradename = $_POST["tradename"] ?? null;
    $quantity = $_POST["quantity"] ?? null;
    $datePrescribed = $_POST["datePrescribed"] ?? null;

    // Check if the inputs are not empty
    if (empty($patientSSN) || empty($tradename) || empty($quantity) || empty($datePrescribed)) {
        echo "Error: Please fill in all the fields.";
    } else {
        // Check if cookies are set and get values from cookies
        if (isset($_COOKIE["email"])) {
            $email = $_COOKIE["email"];

            
            $sql = "SELECT doctorID FROM doctors WHERE email='$email'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $doctorID = $row["doctorID"];

               
            $sql = "SELECT patientID FROM patients WHERE patientSSN='$patientSSN'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $patientID = $row["patientID"];

                $prescriptionID = generateRandomID();

        
                $sql = "INSERT INTO prescriptions (prescriptionID, doctorID, patientID, patientSSN, tradename, quantity, datePrescribed) VALUES ('$prescriptionID', '$doctorID', '$patientID', '$patientSSN', '$tradename', '$quantity', '$datePrescribed')";

                if ($conn->query($sql) === TRUE) {
                    echo "Data stored successfully.";
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
            } else {
                echo "Error: Patient ID not found in database.";
                }
            } else {
                echo "Error: Doctor ID not found in database.";
            }
        } else {
            echo "Error: Doctor ID not found in cookies.";
        }
    }
}

$sql1 = "SELECT * FROM prescriptions";
$result = mysqli_query($conn,$sql1);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Prescriptions History</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="background-container" style="position: absolute; top: -10; right: 5; padding: 10px;">
        <div class="navbar">
            <img src="images/afyahealth.png" class="logo">
            <ul>
                <li><a href="doctor.html">Dashboard</a></li>
                <li><a href="doctorPrescriptions.php">Prescriptions</a></li>
            </ul>
        </div>
        <h1>Prescriptions History</h1>

        <form method="post" action="doctorPrescriptions.php" class="form-container">

            <label for="patientSSN">Patient SSN:</label>
            <input type="text" name="patientSSN" required><br>

            <label for="tradename">Trade Name:</label>
            <input type="text" name="tradename" required><br>

            <label for="quantity">Quantity:</label>
            <input type="text" name="quantity" required><br>

            <label for="datePrescribed">Date Prescribed:</label>
            <input type="date" name="datePrescribed" required><br>

            <input type="submit" value="Submit">
        </form>

        <br>
        <h1>Prescriptions History</h1>
        <table>
            <tr>
                <th>Prescription ID</th>
                <th>Doctor ID</th>
                <th>Patient ID</th>
                <th>Patient SSN</th>
                <th>Trade Name</th>
                <th>Quantity</th>
                <th>Date Prescribed</th>
            </tr>
            <?php
        // Display data from the 'drugs' table
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["PrescriptionID"] . "</td>";
                echo "<td>" . $row["DoctorID"] . "</td>";
                echo "<td>" . $row["PatientID"] . "</td>";
                echo "<td>" . $row["PatientSSN"] . "</td>";
                echo "<td>" . $row["TradeName"] . "</td>";
                echo "<td>" . $row["Quantity"] . "</td>";
                echo "<td>" . $row["DatePrescribed"] . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No data found</td></tr>";
        }
        ?>
        </table>
    </div>
</body>

</html>