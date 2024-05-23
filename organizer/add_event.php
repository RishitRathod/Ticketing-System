<?php

$host = 'localhost';
$db   = 'ticketing_system';
$user = 'root';
$pass = '';


// Create connection
$link = new mysqli($host, $user, $pass, $db);

// Check connection
if ($link->connect_error) {
    die("Connection failed: " . $link->connect_error);
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = $_POST;
    print_r $data;
    
    // Check if $data is an array
    if (!is_array($data)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid data format']);
        exit;
    }

    // Prepare an INSERT statement
    $sql = "INSERT INTO events (OrgID, EventName, Description, StartDate, EndDate, Capacity, EventType) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "issssii", $orgid, $eventName, $description, $startDate, $endDate, $capacity, $eventType);
        
        // Set parameter values
        $orgid = $_POST['orgID'];
        $eventName = $_POST['eventName'];
        $description = $_POST['description'];
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
        $capacity = $_POST['capacity'];
        $eventType = $_POST['eventType'];
        

        // Attempt to execute the prepared statement
        if(mysqli_stmt_execute($stmt)){
            echo json_encode(array("status" => "success"));
        } else{
            echo json_encode(array("status" => "error", "message" => mysqli_error($link)));
        }
    }
     
    // Close statement
    mysqli_stmt_close($stmt);
    
    // Close connection
    mysqli_close($link);
} else {
    echo json_encode(array("status" => "error", "message" => "No data received"));
}

?>
