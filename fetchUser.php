<?php
require_once 'config.php';
require_once 'db_connection.php';
header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $input = json_decode(file_get_contents('php://input'), true);
    
    $action=$input['action'];
    switch ($action)
    {
        case 'FetchUserDetails':
            $UserID = $input['UserID'];
            $response = DB::FetchUserDetails($UserID);
            if($response){
                echo json_encode(['status' => 'success', 'message' => 'Data fetched successfully', 'data' => $response]);
            }else{
                echo json_encode(['status' => 'error', 'message' => 'No data found']);
            }
            break;

        case 'TicketInfo':
            $UserID = $input['UserID'];
            $response = DB::TicketInfo($UserID);
            if($response){
                echo json_encode(['status' => 'success', 'message' => 'Data fetched successfully', 'data' => $response]);
            }else{
                echo json_encode(['status' => 'error', 'message' => 'No data found']);
            }
            break;

        case 'getTicketUsage':
            $UserID = $input['UserID'];
            $TicketSalesID = $input['TicketSalesID'];
            $response = DB::getTicketUsage($UserID,$TicketSalesID);
            if($response){
                echo json_encode(['status' => 'success', 'message' => 'Data fetched successfully', 'data' => $response]);
            }else{
                echo json_encode(['status' => 'error', 'message' => 'No data found']);
            }
            break;

        case 'GetDetailsAtBuyTickets':
        $EventID = $input['EventID'];
        $response = DB::GetDetailsAtBuyTickets($EventID);
        if($response){
            echo json_encode(['status' => 'success', 'message' => 'Data fetched successfully', 'data' => $response]);
        }else{
            echo json_encode(['status'=> 'error',
            'message'=> '
            No data found']);
    }
    break;
    
    case 'getUserEventDetails':
        $UserID = $input['UserID'];
        $response = DB::getUserEventDetails($UserID);
        if($response){
            echo json_encode(['status' => 'success', 'message' => 'Data fetched successfully', 'data' => $response]);
        }else{
            echo json_encode(['status'=> 'error',
            'message'=> '
            No data found']);
    }
    break;
        
}

    
}    
?>