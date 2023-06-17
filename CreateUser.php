<?php
require_once 'Connect.php';
$inputJSON = file_get_contents('php://input');
ini_set('display_errors', 1);
error_reporting(E_ALL);
function generateRandomID() {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $length = 10;
    $randomID = '';
    for ($i = 0; $i < $length; $i++) {
        $randomID .= $characters[rand(0, strlen($characters) - 1)];
    }
    return $randomID;
}
$data = json_decode($inputJSON, true);
$name = $data['Name'];
$age = $data['Age'];
$email = $data['Email'];
$password = $data['Password'];
$contact = $data['Contact'];
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);
$userType = $data["UserType"];
$doctorName = $data["DoctorName"];
$address = $data["Address"];
$specialty = $data["Specialty"];
$SSN = $data["SSN"];
$storeID = generateRandomID();
$patientPin = generateRandomID();

// ID GENERATED BY RANDOM FUNCTION
$ID = generateRandomID();
$response = '';

if ($userType === "Patient") {
    $sql = "INSERT INTO Patients (PatientID, PatientSSN, PatientName, Age, Email, Password, Contact, DoctorName, Address, Pin) VALUES ('$ID', '$SSN', '$name', '$age', '$email', '$hashedPassword', '$contact', '$doctorName', '$address', '$patientPin')";
} elseif ($userType === "Doctor") {
    $sql = "INSERT INTO Doctors (DoctorID, DoctorSSN, DoctorName, Email, Password, Specialty, Contact) VALUES ('$ID', '$SSN', '$name', '$email', '$hashedPassword', '$specialty', '$contact')";
} elseif ($userType === "Supervisor") {
    $sql = "INSERT INTO Supervisor (SupervisorID, SupervisorName, Email, Password, Contact) VALUES ('$ID', '$name', '$email', '$hashedPassword', '$contact')";
} elseif ($userType === "Pharmacy") {
    $sql = "INSERT INTO Pharmacy (PharmacyID, PharmacyName, Email, Password, Contact, PharmacyAddress, StoreID) VALUES ('$ID', '$name', '$email', '$hashedPassword', '$contact', '$address', '$storeID')";
} elseif ($userType === "Pharmaceutical Company") {
    $sql = "INSERT INTO PharmaceuticalCompany (CompanyID, CompanyName, Email, Password, Contact) VALUES ('$ID', '$name', '$email', '$hashedPassword', '$contact')";
}

if ($conn->query($sql) === TRUE) {
    $response = array("status" => "success", "message" => "Record inserted successfully");
} else {
    $response = array("status" => "error", "message" => "Error inserting record: " . $conn->error);
}

$conn->close();

// Return the response as JSON
header('Content-Type: application/json');
echo json_encode($response);

?>