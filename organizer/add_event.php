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
        $Country = $_POST['Country'];
        $State = $_POST['State'];
        $City = $_POST['City'];

        $orgid = $_POST['orgid'];

        $dataTable1 = [
            'OrgID' => $orgid,
            'EventName' => $eventName,
            'Description' => $description,
            'StartDate' => $startDate,
            'EndDate' => $endDate,
            'Capacity' => $capacity,
            'EventType' => $eventType,
            'VenueAddress' => $venueAddress,
            'Country'  => $Country,
            'State' => $State,
            'City' => $City
        ];
        

        //Insert into Table1 (events)
        $insertResult = DB::insertGetId(DB_NAME, 'events', $dataTable1);
        if ($insertResult) {
             $lastEventID = $insertResult;
            $qrCodePath = '../uploads/Organizations/' . $orgid . '/events'.'/'. $lastEventID .'/event_qrcodes';
            $qrCodeFile = $qrCodePath .'/'. $lastEventID . '.svg';
            // Check if directory exists and if not, create it
            if (!is_dir($qrCodePath)) {
                mkdir($qrCodePath, 0777, true);
            }
            //pass link to eventpage
            $QRdata = "http://". getHostByName(getHostName())."/Ticketing-System/user/get_details.php?id=".$lastEventID;            $QRCodeGeneratorBool = QRCodeGenerator::GenerateQRCode($QRdata, $qrCodeFile);            if($QRCodeGeneratorBool){
                $response['success'] = true;
                $response['eventID'] = $lastEventID;
                DB::update(DB_NAME, 'events', ['QR_CODE' =>$qrCodeFile], $lastEventID,'EventID');
            }else{

                $response['success'] = false;
                $response['message'] = "Failed to generate QR code";
                exit();
            }

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
                        'EndTime' => $_POST['EndTimeSlot'][$index],
                        'Availability' => $capacity
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
                    'Price' => $_POST['Price'][$index],
                    'TicketType' => $_POST['TicketType'][$index],
                    'Availability' => $_POST['Quantity'][$index]
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

        if (isset($_FILES['EventPoster'])) {
            $posterFile = $_FILES['EventPoster'];
            //$uploadDirectory = '../uploads/events/' . $lastEventID . '/event_posters/';
            $uploadDirectory = '../uploads/Organizations/' . $orgid . '/events'.'/'. $lastEventID .'/'.'event_posters/';
            // Create the directory if it doesn't exist
            if (!is_dir($uploadDirectory)) {
                mkdir($uploadDirectory, 0777, true);
            }
    
            foreach ($posterFile['name'] as $index => $name) {
                $posterPath = $uploadDirectory . $name;
                if (move_uploaded_file($posterFile['tmp_name'][$index], $posterPath)) {
                    db::insert(DB_NAME, 'eventposter', ['EventID' => $lastEventID, 'poster' => $posterPath]);
                    $response['success'] = true;
                    $response['message'] = "Event added successfully";
                } else {
                    $response['success'] = false;
                    $response['message'] = "Failed to upload event poster";
                }
            }
        } else {
            $response['success'] = false;
            $response['message'] = "No event poster provided";

        }

    } else {
        $response['success'] = false;
        $response['message'] = "Invalid request method, expecting POST";
    }
    

    // Send the JSON response
    header('Content-Type: application/json');
    echo json_encode($response);

    ?>