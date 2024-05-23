<?php

if (isset($_POST['orgID'])) {
    $link = mysqli_connect("localhost", "root", "", "ticketing_system");

    if($link === false){
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }

    // Prepare an INSERT statement
    $sql = "INSERT INTO events (OrgID, EventName, Description, StartDate, EndDate, Capacity, EventType, VenueAddress) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    if($stmt = mysqli_prepare($link, $sql)){
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "issssiis", $orgid, $eventName, $description, $startDate, $endDate, $capacity, $eventType, $venueAddress);
        
        // Set parameter values
        $orgid = $_POST['orgID'];
        $eventName = $_POST['eventName'];
        $description = $_POST['description'];
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
        $capacity = $_POST['capacity'];
        $eventType = $_POST['eventType'];
        $venueAddress = $_POST['venueAddress'];

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
