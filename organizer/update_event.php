<?php
require_once '../config.php';
require_once '../db_connection.php';

header('Content-Type: application/json');
$response = array('success' => true); // Initialize an array to hold the response data

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
$action = $_POST['action'];

if ($action == 'update')
    {    // Assuming the input is sent as form-data
    $eventName = $_POST['EventName'];
    $eventType = $_POST['EventType'];
    $description = $_POST['Description'];
    $capacity = $_POST['Capacity'];
    $startDate = $_POST['StartDate'];
    $endDate = $_POST['EndDate'];
    $venueAddress = $_POST['VenueAddress'];
    $Country = $_POST['Country'];
    $State = $_POST['State'];
    $City = $_POST['City'];
    $orgID = $_POST['orgid']; // Organization ID
    $eventID = $_POST['orgid']; // Event ID

    $dataTable1 = [
        'EventName' => $eventName,
        'Description' => $description,
        'StartDate' => $startDate,
        'EndDate' => $endDate,
        'Capacity' => $capacity,
        'EventType' => $eventType,
        'VenueAddress' => $venueAddress,
        'Country' => $Country,
        'State' => $State,
        'City' => $City
    ];

    // Update event
    $updateResult = DB::update(DB_NAME, 'events', $dataTable1, $_POST['orgid'],'EventID' );

    if (!$updateResult) {
        $response['success'] = false;
        $response['message'] = "An error occurred while updating the event!";
    } else {
        // Delete existing time slots
        $deleteResult1 = DB::delete(DB_NAME, 'timeslots', $_POST['orgid'],'EventID');

        if (!$deleteResult1) {
            $response['success'] = false;
            $response['message'] = "An error occurred while deleting time slots!";
        } else {
            // Delete existing tickets
            $deleteResult2 = DB::delete(DB_NAME, 'tickets',$_POST['orgid'],'EventID');

            if (!$deleteResult2) {
                $response['success'] = false;
                $response['message'] = "An error occurred while deleting tickets!";
            } else {
                // Delete existing event posters
                $deleteResult3 = DB::delete(DB_NAME, 'eventposter', $_POST['orgid'],'EventID');

                if (!$deleteResult3) {
                    $response['success'] = false;
                    $response['message'] = "An error occurred while deleting event posters!";
                } else {
                    // Insert new time slots if present
                    if (isset($_POST['StartTimeSlot']) && isset($_POST['EndTimeSlot'])) {
                        $timeSlots = [];
                        foreach ($_POST['StartTimeSlot'] as $index => $startTime) {
                            if (isset($_POST['EndTimeSlot'][$index])) {
                                $timeSlotData = [
                                    'EventID' => $eventID,
                                    'StartTime' => $startTime,
                                    'EndTime' => $_POST['EndTimeSlot'][$index]
                                ];
                                DB::insert(DB_NAME, 'timeslots', $timeSlotData);
                                $timeSlots[] = $timeSlotData;
                            }
                        }
                        if (empty($timeSlots)) {
                            $response['success'] = false;
                            $response['message'] = "Failed to insert time slots";
                        }
                    } else {
                        $response['success'] = false;
                        $response['message'] = "No time slots provided to insert";
                    }

                    // Insert new tickets if present
                    if (isset($_POST['TicketType'])) {
                        $tickets = [];
                        foreach ($_POST['TicketType'] as $index => $ticketType) {
                            $tickets[] = [
                                'EventID' => $eventID,
                                'TicketType' => $ticketType,
                                'Quantity' => $_POST['Quantity'][$index],
                                'LimitQuantity' => $_POST['LimitQuantity'][$index],
                                'Discount' => $_POST['Discount'][$index],
                                'Price' => $_POST['Price'][$index]
                            ];
                        }
                        foreach ($tickets as $ticket) {
                            DB::insert(DB_NAME, 'tickets', $ticket);
                        }
                    } else {
                        $response['success'] = false;
                        $response['message'] = "No tickets provided to insert";
                    }

                    // Handle event poster upload if present
                    if (isset($_FILES['EventPoster'])) {
                        $posterFile = $_FILES['EventPoster'];
                        $uploadDirectory = '../uploads/Organizations/' . $orgID . '/events/' . $eventID . '/event_posters/';
                        if (!is_dir($uploadDirectory)) {
                            mkdir($uploadDirectory, 0777, true);
                        }
                        foreach ($posterFile['name'] as $index => $name) {
                            $posterPath = $uploadDirectory . $name;
                            if (move_uploaded_file($posterFile['tmp_name'][$index], $posterPath)) {
                                DB::insert(DB_NAME, 'eventposter', ['EventID' => $eventID, 'poster' => $posterPath]);
                            } else {
                                $response['success'] = false;
                                $response['message'] = "Failed to upload event poster";
                            }
                        }
                    } else {
                        $response['success'] = false;
                        $response['message'] = "No event poster provided";
                    }
                }
            }
        }
    }
    // Final response
    if (!isset($response['message'])) {
        $response['message'] = "Event updated successfully";
    }
    echo json_encode($response);
}

    if($action == 'delete'){
        $eventID = $_POST['eventID'];
        $deleteResult1 = DB::delete(DB_NAME, 'tickets', $eventID,'EventID');
        if (!$deleteResult1) {
            http_response_code(500);
            echo "Error `deleting tickets";
            exit();
        }

        $deleteResult2 = DB::delete(DB_NAME, 'timeslots', $eventID,'EventID');
        if (!$deleteResult2) {
            http_response_code(500);
            echo "Error deleting timeslots";
            exit();
        }

        $deleteResult3 = DB::delete(DB_NAME, 'eventposter', $eventID,'EventID');
        if (!$deleteResult3) {
            http_response_code(500);
            echo "Error deleting event poster";
            exit();
        }

        $deleteResult4 = DB::delete(DB_NAME, 'events', $eventID,'EventID');
        if (!$deleteResult4) {
            http_response_code(500);
            echo "Error deleting event";
            exit();
        }
        //also delete the files realted to the event
        $uploadDirectory = '../uploads/Organizations/' . $orgID . '/events/' . $eventID . '/';
    
        try {
            if (is_dir($uploadDirectory)) {
                $files = glob($uploadDirectory . '*', GLOB_MARK); //GLOB_MARK adds a slash to directories returned
                foreach ($files as $file) {
                    if (!unlink($file)) {
                        throw new Exception("Failed to delete file: $file");
                    }
                }
                if (!rmdir($uploadDirectory)) {
                    throw new Exception("Failed to delete directory: $uploadDirectory");
                }
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo 'Caught exception: ',  $e->getMessage(), "\n";
            exit();
        }
        


        http_response_code(200);
        echo "Event deleted successfully";

    }

}
?>
