<?php

require_once '../config.php';
require_once '../db_connection.php';

$response = array(); // Initialize an array to hold the response data

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Assuming the input is sent as form-data
    $eventName = $_POST['EventName'];
    $eventType = $_POST['EventType'];
    $description = $_POST['Description'];
    $capacity = $_POST['Capacity'];
    $startDate = $_POST['StartDate'];
    $endDate = $_POST['EndDate'];
    $venueAddress = $_POST['VenueAddress'];
 
    $orgid = $_POST['orgid'];
 
    $dataTable1 = [
        'OrgID' => $orgid,
        'EventName' => $eventName,
        'Description' => $description,
        'StartDate' => $startDate,
        'EndDate' => $endDate,
        'Capacity' => $capacity,
        'EventType' => $eventType,
        'VenueAddress' => $venueAddress
    ];

    //Insert into Table1 (events)
    $insertResult = DB::insertGetId(DB_NAME, 'events', $dataTable1);
    if ($insertResult) {
        $lastEventID = $insertResult;
    } else {
        $response['success'] = false;
        $response['message'] = "Failed to insert into Table1";
        exit();
    }

    //Insert time slots if present
    if (isset($_POST['StartTimeSlot']) && isset($_POST['EndTimeSlot'])) {
        $timeSlots = [];
        // Loop through the start time slots array
        foreach ($_POST['StartTimeSlot'] as $index => $startTime) {
            // Check if corresponding end time exists
            if (isset($_POST['EndTimeSlot'][$index])) {
                // Create time slot data array
                $timeSlotData = [
                    'EventID' => $lastEventID,
                    'StartTime' => $startTime,
                    'EndTime' => $_POST['EndTimeSlot'][$index]
                ];
                // Insert time slot into the database
                DB::insert(DB_NAME, 'timeslots', $timeSlotData);
                // Add time slot data to the array
                $timeSlots[] = $timeSlotData;
            }
        }
        // Check if time slots were successfully inserted
        if (!empty($timeSlots)) {
            $response['success'] = true;
            $response['eventID'] = $lastEventID;
        } else {
            $response['success'] = false;
            $response['message'] = "Failed to insert time slots";
        }
    } else {
        $response['success'] = false;
        $response['message'] = "No time slots provided to insert";
    }

    // Handle ticket insertion if present
    if (isset($_POST['TicketType'])) {
        $tickets = [];
        foreach ($_POST['TicketType'] as $index => $ticketType) {
            $tickets[] = [
                'EventID' => $lastEventID, // Use the last retrieved EventID
                'Quantity' => $_POST['Quantity'][$index],
                'LimitQuantity' => $_POST['LimitQuantity'][$index],
                'Discount' => $_POST['Discount'][$index],
                'Price' => $_POST['Price'][$index]
            ];
        }
        // Insert tickets into Table2 (tickets)
        foreach ($tickets as $ticket) {
            DB::insert(DB_NAME, 'tickets', $ticket);
        }

        $response['success'] = true;
        $response['eventID'] = $lastEventID; // Include the last retrieved EventID in the response
    } else {
        $response['success'] = false;
        $response['message'] = "No tickets provided to insert";
    }
} else {
    $response['success'] = false;
    $response['message'] = "Invalid request method, expecting POST";
}

// Send the JSON response
header('Content-Type: application/json');
echo json_encode($response);

?>