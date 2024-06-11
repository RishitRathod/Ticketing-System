<?php
require_once 'config.php';
require_once 'db_connection.php';
header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $input = json_decode(file_get_contents('php://input'), true);
    
    $action=$input['action'];
    switch ($action)
    {
        case 'GetTicketsDataByUserID':
            $UserID = $input['UserID'];
            $response = DB::GetTicketsDataByUserID($UserID);
            if($response){
                echo json_encode(['status' => 'success', 'message' => 'Data fetched successfully', 'data' => $response]);
            }else{
                echo json_encode(['status' => 'error', 'message' => 'No data found']);
            }
            break;

        case 'SetTimes':
            $TicketSalesID = $input['TicketSalesID'];
            $response = DB::SetTimes($TicketSalesID);
            if($response){
                echo json_encode(['status' => 'success', 'message' => 'Data fetched successfully', 'data' => $response]);
            }else{
                echo json_encode(['status' => 'error', 'message' => 'No data found']);
            }
            break;

        
      default :
            echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
            break;
}

    
}    
?>