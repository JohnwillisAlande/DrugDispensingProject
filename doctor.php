<?php
require_once 'Connect.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);

$inputJSON = file_get_contents('php://input');
$data = json_decode($inputJSON, true);

$email = isset($_GET['Email']) ? $_GET['Email'] : null;

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    
    $DoctorName = isset($data['DoctorName']) ? $data['DoctorName'] : null;
    $Specialty = isset($data['Specialty']) ? $data['Specialty'] : null;
    $DoctorSSN = isset($data['DoctorSSN']) ? $data['DoctorSSN'] : null;
    $Contact = isset($data['Contact']) ? $data['Contact'] : null;
    $emailChange = isset($data['Email']) ? $data['Email'] : null;
    $DoctorID = isset($data['DoctorID']) ? $data['DoctorID'] : null;

    updateData($conn);
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Assign the DELETE data to the corresponding variable
    $DoctorID = isset($data) ? $data : null;

    deleteData($conn);
}

$response = array();

function getResults($email, $conn) {
    $sql = "SELECT * FROM DOCTORS WHERE Email='$email'";

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $response = array("status" => "success", "data" => $row);
    } else {
        $response = array("status" => "failed");
    }
    echo json_encode($response);
}

function updateData($conn) {
    global $DoctorSSN, $DoctorName, $emailChange, $Specialty, $Contact, $DoctorID;
    $response = array(); // Define the $response array

    $sql1 = "UPDATE DOCTORS SET DoctorSSN='$DoctorSSN', DoctorName='$DoctorName', Email='$emailChange', Specialty='$Specialty', Contact='$Contact' WHERE DoctorID='$DoctorID'";

    if ($conn->query($sql1) === TRUE) {
        $response = array("status" => "success", "message" => "Record updated successfully: $emailChange");
    } else {
        $response = array("status" => "error", "message" => "Error updating record");
    }
    echo json_encode($response);
}

function deleteData($conn) {
    global $DoctorID;
    $response = array(); // Define the $response array

    $sql = "UPDATE DOCTORS SET IsDisabled=true WHERE DoctorID='$DoctorID'";

    if ($conn->query($sql) === TRUE) {
        $response = array("status" => "success", "message" => "Record deleted successfully");
    } else {
        $response = array("status" => "error", "message" => "Error deleting record");
    }
    echo json_encode($response);
}

if (isset($email)) {
    getResults($email, $conn);
}
?>