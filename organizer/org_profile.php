<?php

require_once '../index1.php'; // Ensure this path is correct for including the DB class

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if raw POST data is received
    $data = json_decode(file_get_contents('php://input'), true);
    $tablename=$data['Tablename'];
    $OrgID=$data['OrgID'];
    $data = array_filter($data, function($key) {
        return  $key !== 'Tablename' && $key !== 'OrgID';
        }, ARRAY_FILTER_USE_KEY);

    // Check if json_decode() returned an array
    if (!is_array($data)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid data format']);
        exit;
    }

    
  


    // Insert the organization data
    $insert = DB::update(DB_NAME, $tablename, $data,$OrgID,"OrgID" );
    if ($insert === updateSuccess) {
        echo json_encode(['status' => 'success', 'message' => 'Organization registered successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $insert]);
    }

    
    exit;
}
?>
