<?php
header('Content-Type: application/json');

// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ticketing_system";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$offset = isset($_GET['offset']) ? (int)$_GET['offset'] : 0;
$limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10; // Default limit to 10
$id = $_GET['id'];
$sql = "SELECT * FROM eventposter ep JOIN events e ON e.EventID = ep.EventID WHERE e.EventType='$id' LIMIT $offset, $limit";

$result = $conn->query($sql);

$events = array();

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        // Add each row to the events array
        $events[] = $row;
    }
} else {
    // If no results found, return an empty array
    echo json_encode(array());
    exit();
}

// Close the database connection
$conn->close();

// Output the events array as JSON
echo json_encode($events);
?>
