<?php

require_once '../index.php'; // Ensure this path is correct for including the DB class

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if raw POST data is received
    $data = json_decode(file_get_contents('php://input'), true);
    $tablename=$data['tablename'];
    $data = array_filter($data, function($key) {
        return  $key !== 'tablename' ;
        }, ARRAY_FILTER_USE_KEY);

    // Check if json_decode() returned an array
    if (!is_array($data)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid data format']);
        exit;
    }

    if (isset($data['Password'])) {
        $data['Password'] = password_hash($data['Password'], PASSWORD_BCRYPT);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Password is required']);
        exit;
    }

    // Check if the organization is already registered
    $check = DB::selectBy(DB_NAME, $tablename, ['email' => $data['Email']]);
    if ($check) {
        echo json_encode(['status' => 'error', 'message' => 'Organization already registered']);
        exit;
    }

    // Insert the organization data
    $insert = DB::insert(DB_NAME, $tablename, $data);
    if ($insert == insertSuccess) {
        echo json_encode(['status' => 'success', 'message' => 'Organization registered successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $insert]);
    }

    exit;
}
?>
