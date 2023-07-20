<?php
require_once 'Connect.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);
$inputJSON = file_get_contents('php://input');
$data = json_decode($inputJSON, true);

$email = $data['Email'];
$password = $data['Password']; // Fixed typo in variable name

$sql1 = "SELECT * FROM Patients WHERE Email = '$email'"; // Fixed missing "=" sign
$sql2 = "SELECT * FROM Doctors WHERE Email = '$email'"; // Fixed missing "=" sign
$sql3 = "SELECT * FROM Supervisor WHERE Email = '$email'"; // Fixed missing "=" sign
$sql4 = "SELECT * FROM Pharmacy WHERE Email = '$email'"; // Fixed missing "=" sign
$sql5 = "SELECT * FROM PharmaceuticalCompany WHERE Email = '$email'"; // Fixed missing "=" sign




$response = '';

$result1 = $conn->query($sql1);
$result2 = $conn->query($sql2);
$result3 = $conn->query($sql3);
$result4 = $conn->query($sql4);
$result5 = $conn->query($sql5);

if ($result1->num_rows > 0) {
    // Patient found
    $row = $result1->fetch_assoc();
    if(password_verify($password,$row["Password"])){
        $response = array(
        "status" => "success",
        "message" => "Record inserted successfully",
        "UserType" => "Patient",
        "Name" => $row['PatientName'],
        "Email" => $row['Email']
    );    
    }
    else{
        $response=array("status"=>"failed");
    }

} else if ($result2->num_rows > 0) {
    // Doctor found
    $row = $result2->fetch_assoc();
    if(password_verify($password,$row["Password"])){
        $response = array(
        "status" => "success",
        "message" => "Record inserted successfully",
        "UserType" => "Doctor",
        "Name" => $row['DoctorName'],
        "Email" => $row['Email']
    );    
    }
    else{
        $response=array("status"=>"failed");
    }
} else if ($result3->num_rows > 0) {
    // Supervisor found
    $row = $result3->fetch_assoc();
    if(password_verify($password,$row["Password"])){
        $response = array(
        "status" => "success",
        "message" => "Record inserted successfully",
        "UserType" => "Supervisor",
        "Name" => $row['SupervisorName'],
        "Email" => $row['Email']
    );    
    }
    else{
        $response=array("status"=>"failed");
    }
} else if ($result4->num_rows > 0) {
    // Pharmacy found
    $row = $result4->fetch_assoc();
    if(password_verify($password,$row["Password"])){
        $response = array(
        "status" => "success",
        "message" => "Record inserted successfully",
        "UserType" => "Pharmacy",
        "Name" => $row['PharmacyName'],
        "Email" => $row['Email']
    );    
    }
    else{
        $response=array("status"=>"failed");
    }
} else if ($result5->num_rows > 0) {
    // Pharmaceutical Company found
    $row = $result5->fetch_assoc();
    if(password_verify($password,$row["Password"])){
        $response = array(
        "status" => "success",
        "message" => "Record inserted successfully",
        "UserType" => "PharmaceuticalCompany",
        "Name" => $row['CompanyName'],
        "Email" => $row['Email']
    );    
    }
    else{
        $response=array("status"=>"failed");
    }
} else {
    // No matching records found
    $response = 'NoUser';
}

echo json_encode($response);
?>