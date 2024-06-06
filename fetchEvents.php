<?php 
require_once 'db_connection.php';
header('Content-Type: application/json');
if($_SERVER['REQUEST_METHOD']==='POST'){
    $data = json_decode(file_get_contents('php://input'), true);
    $action=$data['action'];
    
    switch($action){
        case 'fetchPaginatedEventData':
            $limit = $data['limit'];
            $offset = $data['offset'];
            $response=DB::fetchPaginatedEventData($limit, $offset);
            //add sucess message to response
            if(!$response){
                $response['success']=false;
                $response['message']='No events found';
                echo json_encode($response);
                exit();
            }
            $response['success']=true;
            echo json_encode($response);
            break;

        }
}