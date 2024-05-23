<?php
// Handle database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ticketing_system";

// Establishing connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Getting JSON data and decoding it
$jsonData = $_POST['data'];
$formData = json_decode($jsonData, true);

// Extracting form data
$eventName = $formData['EventName'];
$eventType = $formData['EventType'];
$description = $formData['Description'];
$capacity = $formData['Capacity'];
$startDate = $formData['StartDate'];
$endDate = $formData['EndDate'];
$venueAddress = $formData['VenueAddress'];
$venueCascadedDropdown = $formData['VenueCascadedDropdown'];
$stateCityAddress = $formData['StateCityAddress'];

// Insert data into table 1 (assuming table name is "events")
$sql1 = "INSERT INTO events (EventName, EventType, Description, Capacity, StartDate, EndDate, VenueAddress, VenueCascadedDropdown, StateCityAddress)
VALUES ('$eventName', '$eventType', '$description', '$capacity', '$startDate', '$endDate', '$venueAddress', '$venueCascadedDropdown', '$stateCityAddress')";

if ($conn->query($sql1) === TRUE) {
    $eventId = $conn->insert_id; // Get the last inserted event ID

    // Insert data into table 2 (assuming table name is "time_slots")
    foreach ($formData['TimeSlots'] as $timeSlot) {
        $startTime = $timeSlot['StartTime'];
        $endTime = $timeSlot['EndTime'];

        $sql2 = "INSERT INTO time_slots (EventID, StartTime, EndTime)
        VALUES ('$eventId', '$startTime', '$endTime')";

        if ($conn->query($sql2) !== TRUE) {
            die(json_encode(["status" => "error", "message" => "Error inserting into time_slots table: " . $conn->error]));
        }
    }

    // Insert data into table 3 (assuming table name is "tickets")
    foreach ($formData['Tickets'] as $ticket) {
        $ticketType = $ticket['TicketType'];
        $quantity = $ticket['Quantity'];
        $returnable = $ticket['Returnable'];
        $limitQuantity = $ticket['LimitQuantity'];
        $discount = $ticket['Discount'];
        $price = $ticket['Price'];

        $sql3 = "INSERT INTO tickets (EventID, TicketType, Quantity, Returnable, LimitQuantity, Discount, Price)
        VALUES ('$eventId', '$ticketType', '$quantity', '$returnable', '$limitQuantity', '$discount', '$price')";

        if ($conn->query($sql3) !== TRUE) {
            die(json_encode(["status" => "error", "message" => "Error inserting into tickets table: " . $conn->error]));
        }
    }

    // Close connection
    $conn->close();

    // Return success status
    echo json_encode(["status" => "success"]);
} else {
    // If insertion into events table fails, return error status
    echo json_encode(["status" => "error", "message" => "Error inserting into events table: " . $conn->error]);
}
?>
