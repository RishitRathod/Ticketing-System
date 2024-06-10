<?php
require_once '../db_connection.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $UserID = $data['UserID'];
    $EventID = $data['EventID'];

    // Mandatory fields
    $mandatoryFields = ['TicketID', 'TimeSlotID', 'EventID', 'UserID', 'Name', 'Quantity','EventDate'];

    // Check if all mandatory fields are present
    foreach ($mandatoryFields as $field) {
        if (empty($data[$field])) {
            echo json_encode(['status' => 'error', 'message' => "Missing mandatory field: $field"]);
            exit;
        }
    }

    // Check if at least one of Email or Phone is provided
    // if (empty($data['Email']) && empty($data['Phone'])) {
    //     echo json_encode(['status' => 'error', 'message' => 'Either Email or Phone must be provided']);
    //     exit;
    // }

    // Set default value for PurchaseDate if not provided
    if (empty($data['PurchaseDate'])) {
        $data['PurchaseDate'] = date('Y-m-d H:i:s');
    }

    $qrCodePath = '../uploads/user/' . $UserID . '/events'.'Tickets'.'/'. $EventID .'/'.'ticket_qrcode/';
    $qrCodeFile = $qrCodePath .'/'. $EventID . '.svg';
    // Check if directory exists and if not, create it
    if (!is_dir($qrCodePath)) {
        mkdir($qrCodePath, 0777, true);
    }
    //pass link to eventpage
    $QRdata = "http://". getHostByName(getHostName())."/ticketing-system/user/my_tickets.php?id=".$EventID;
    $QRCodeGeneratorBool = QRCodeGenerator::GenerateQRCode($QRdata, $qrCodeFile);
    if($QRCodeGeneratorBool) {
        $response['success'] = true;
        $response['eventID'] = $EventID;
        $data['QR_CODE']= $qrCodeFile;
    }else{
        $response['success'] = false;
        $response['message'] = "Failed to generate QR code";
            exit();
        }

    // Insert into ticketsales table
    $insert = DB::insertGetId(DB_NAME, 'ticketsales', $data);

    if (!$insert) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to submit ticket','ErrorMessage'=> $insert]);
        exit();
    }
    echo json_encode(['status' => 'success', 'message' => 'Ticket submitted successfully', "TicketSaleID" => $insert]);
    

    } else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
