<?php
require_once '../db_connection.php';
header('Content-Type: application/json');
if($SERVER['REQUEST_METHOD'] === 'POST'){
    $input = json_decode(file_get_contents('php://input'), true);

    $EventID = $input['EventID'];
    $action = $input['action'];
    switch($action){
        case 'getEventDetails':
        default:
            
            echo json_encode(['status'=> 'failed' ,'error' => 'Invalid action' ]);
    }


}