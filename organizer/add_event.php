<?php
require_once '../config.php';
require_once '../db_connection.php';
require '../faker/Faker/src/autoload.php'; // Include the Faker library

use Faker\Factory; // Import the Factory class from Faker namespace

$faker = Factory::create(); // Create a Faker instance

$response = array(); // Initialize an array to hold the response data

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Assuming the input is sent as form-data
    $eventName = $faker->sentence(3); // Generate a fake event name
    $eventType = $faker->randomElement(['Beauty', 'Business', 'Comedy', 'Culture', 'Dance', 'Education', 'Experience', 'Health', 'Music', 'Sports']); // Generate a fake event type
    $description = $faker->paragraph; // Generate a fake event description
    $capacity = $faker->numberBetween(50, 500); // Generate a fake capacity
    $startDate = $faker->dateTimeBetween('+1 days', '+1 month')->format('Y-m-d\TH:i'); // Generate a fake start date
    $endDate = $faker->dateTimeBetween('+1 month', '+2 months')->format('Y-m-d\TH:i'); // Generate a fake end date
    $venueAddress = $faker->address; // Generate a fake venue address
    $country = $faker->country; // Generate a fake country
    $state = $faker->state; // Generate a fake state
    $city = $faker->city; // Generate a fake city

    $orgid = $_POST['orgid']; // Get the organization ID from the POST data

    // Define the data array for insertion into the database
    $dataTable1 = [
        'OrgID' => $orgid,
        'EventName' => $eventName,
        'Description' => $description,
        'StartDate' => $startDate,
        'EndDate' => $endDate,
        'Capacity' => $capacity,
        'EventType' => $eventType,
        'VenueAddress' => $venueAddress,
        'Country'  => $country,
        'State' => $state,
        'City' => $city
    ];

    // Insert into Table1 (events)
    $insertResult = DB::insertGetId(DB_NAME, 'events', $dataTable1);

    if ($insertResult) {
        // If insertion is successful
        $lastEventID = $insertResult;
        $qrCodePath = '../uploads/Organizations/' . $orgid . '/events'.'/'. $lastEventID .'/event_qrcodes';
        $qrCodeFile = $qrCodePath .'/'. $lastEventID . '.svg';

        // Check if directory exists and if not, create it
        if (!is_dir($qrCodePath)) {
            mkdir($qrCodePath, 0777, true);
        }

        // Generate QR code data
        $QRdata = "http://". getHostByName(getHostName())."/Event-Platform/event.php?eventID=".$lastEventID;
        $QRCodeGeneratorBool = QRCodeGenerator::GenerateQRCode($QRdata, $qrCodeFile);

        if($QRCodeGeneratorBool){
            // If QR code generation is successful
            $response['success'] = true;
            $response['eventID'] = $lastEventID;

            // Update the QR code path in the database
            DB::update(DB_NAME, 'events', ['QR_CODE' =>$qrCodeFile], $lastEventID,'EventID');
        } else {
            // If QR code generation fails
            $response['success'] = false;
            $response['message'] = "Failed to generate QR code";
            exit();
        }
    } else {
        // If insertion into Table1 fails
        $response['success'] = false;
        $response['message'] = "Failed to insert into Table1";
        exit();
    }

    // Handle other data insertion (time slots, tickets, event posters) here...

} else {
    // If request method is not POST
    $response['success'] = false;
    $response['message'] = "Invalid request method, expecting POST";
}

// Send the JSON response
header('Content-Type: application/json');
echo json_encode($response);

?>
