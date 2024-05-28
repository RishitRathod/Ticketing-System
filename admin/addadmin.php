<?php

require_once '../index.php'; // Ensure this path is correct for including the DB class
    
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if raw POST data is received
    $data = json_decode(file_get_contents('php://input'), true);
    $tablename=$data['tablename'];
    $data = array_filter($data, function($key) {
        return  $key !== 'tablename' ;
        }, ARRAY_FILTER_USE_KEY);
    
    $data['Password']= password_hash($data['Password'], PASSWORD_DEFAULT);

    // Check if json_decode() returned an array
    if (!is_array($data)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid data format']);
        exit;
    }

    
    
    // Insert the admin data
    $insert = DB::insert(DB_NAME, $tablename, $data);
    if ($insert === insertSuccess) {
        echo json_encode(['status' => 'success', 'message' => 'Admin registered successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $insert]);
    }

 
}
?>

