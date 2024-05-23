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
    $venueCascadedDropdown = $_POST['VenueCascadedDropdown'];
    $stateCityAddress = $_POST['StateCityAddress'];
    $orgid = $_POST['orgid'];

    $dataTable1 = [
        'OrgID' => $orgid,
        'EventName' => $eventName,
        'Description' => $description,
        'StartDate' => $startDate,
        'EndDate' => $endDate,
        'Capacity' => $capacity,
        'EventType' => $eventType,
    ];

    // Insert into Table1 (events)
    $eventID = DB::insert(DB_NAME, 'events', $dataTable1);

    if ($eventID) {
        // Fetch the last inserted EventID using LAST_INSERT_ID()
        $query = "SELECT LAST_INSERT_ID() AS EventID";
        $result = DB::run($query);
        if ($result) {
            $row = $result->fetch_assoc();
            $lastEventID = $row['EventID'] ?? null;

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
            $response['message'] = "Failed to retrieve last inserted ID";
        }
    } else {
        $response['success'] = false;
        $response['message'] = "Failed to insert into Table1";
    }
} else {
    $response['success'] = false;
    $response['message'] = "Invalid request method, expecting POST";
}

// Send the JSON response
header('Content-Type: application/json');
echo json_encode($response);

?>
