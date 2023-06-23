<?php
require_once 'Connect.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);

$inputJSON = file_get_contents('php://input');
$data = json_decode($inputJSON, true);

$email = isset($_GET['Email']) ? $_GET['Email'] : null;

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    // Assign the PUT data to the corresponding variables
    $SupervisorName = isset($data['SupervisorName']) ? $data['SupervisorName'] : null;
    $Contact = isset($data['Contact']) ? $data['Contact'] : null;
    $emailChange = isset($data['Email']) ? $data['Email'] : null;
    $SupervisorID = isset($data['SupervisorID']) ? $data['SupervisorID'] : null;
    updateData($conn);
} elseif ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    // Assign the DELETE data to the corresponding variable
    $SupervisorID = isset($data) ? $data : null;

    deleteData($conn);
}

$response = array();

function getResults($email, $conn) {
    $sql = "SELECT * FROM Supervisor WHERE Email='$email'";

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
    global $SupervisorName, $emailChange, $Contact, $SupervisorID;
    $response = array(); // Define the $response array

    $sql1 = "UPDATE Supervisor SET  SupervisorName='$SupervisorName', Email='$emailChange', Contact='$Contact' WHERE SupervisorID='$SupervisorID'";

    if ($conn->query($sql1) === TRUE) {
        $response = array("status" => "success", "message" => "Record updated successfully: $SupervisorID");
    } else {
        $response = array("status" => "error", "message" => "Error updating record");
    }
    echo json_encode($response);
}

function deleteData($conn) {
    global $SupervisorID;
    $response = array(); // Define the $response array

    $sql = "DELETE FROM Supervisor WHERE SupervisorID='$SupervisorID'";

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