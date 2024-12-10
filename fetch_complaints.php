<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

$host = "localhost";
$user = "root";
$password = "root";
$dbname = "bus_tracker";

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(array("status" => "error", "message" => "Database connection failed: " . $conn->connect_error)));
}

// If the request method is GET, fetch the data
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $tables = ["complaints"];
    $response = array();

    foreach ($tables as $table) {
        $query = "SELECT * FROM $table"; 
        $result = $conn->query($query);

        if ($result) {
            $data = array();
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            $response[$table] = $data;
        } else {
            $response[$table] = [];
        }
    }

    echo json_encode(array("status" => "success", "data" => $response));
}

// If the request method is POST, update the data
else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the posted data
    $id = $_POST['id'];
    $status = $_POST['status'];

    if (empty($id) || empty($status)) {
        die(json_encode(array("status" => "error", "message" => "Invalid input")));
    }

    // Prepare the update query with parameterized statement to avoid SQL injection
    $query = "UPDATE complaints SET Status = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    
    // Bind parameters: 's' for string, 'i' for integer
    $stmt->bind_param("si", $status, $id);

    // Execute the query
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update status']);
    }

    $stmt->close();
}

$conn->close();
?>
