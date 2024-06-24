<?php
require_once 'config.php';
require_once 'db_connection.php';
header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $input = json_decode(file_get_contents('php://input'), true);
    // print_r($input);
    // exit();
    //remove the action key from the input array
    $action = $input['action'];
    switch ($action){
        case 'getUserId':
            $response = DB::getUserId();
            if($response){
                echo json_encode(['status' => 'success', 'message' => 'Data fetched successfully', 'data' => $response]);
            }else{
                echo json_encode(['status' => 'error', 'message' => 'No data found']);

            }
            break;
    
        }
        

}else{
    echo json_encode(['status' => 'error', 'message' => 'Only POST requests are allowed']);
}
