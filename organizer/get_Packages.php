<?php
require_once '../db_connection.php';
require_once '../config.php';


if($_SERVER['REQUEST_METHOD'] === 'POST'){
   
    $result = DB::selectAll(DB_NAME, 'packages');
    
    if ($result) {
        $response['success'] = true;
        $response['data'] = $result;
    } else {
        $response['success'] = false;
        $response['message'] = "Failed to get packages";
    }
    echo json_encode($response);
    
}