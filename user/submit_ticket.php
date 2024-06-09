<?php
require_once '../db_connection.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    // Mandatory fields
    $mandatoryFields = ['TicketID', 'TimeSlotID', 'EventID', 'UserID', 'Name', 'Quantity', 'Status'];

    // Check if all mandatory fields are present
    foreach ($mandatoryFields as $field) {
        if (empty($data[$field])) {
            echo json_encode(['status' => 'error', 'message' => "Missing mandatory field: $field"]);
            exit;
        }
    }

    // Check if at least one of Email or Phone is provided
    if (empty($data['Email']) && empty($data['Phone'])) {
        echo json_encode(['status' => 'error', 'message' => 'Either Email or Phone must be provided']);
        exit;
    }

    // Set default value for PurchaseDate if not provided
    if (empty($data['PurchaseDate'])) {
        $data['PurchaseDate'] = date('Y-m-d H:i:s');
    }

    // Insert into ticketsales table
    $insert = DB::insert(DB_NAME, 'ticketsales', $data);

    if ($insert) {
        echo json_encode(['status' => 'success', 'message' => 'Ticket submitted successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to submit ticket']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}