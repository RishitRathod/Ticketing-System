<?php
require_once "../db_connection.php";
header('Content-Type: application/json');
if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $input = json_decode(file_get_contents('php://input'), true);
    $UserID = $input['UserID'];
    $select_user= DB::selectBy(DB_NAME, 'users', ['UserID' => $UserID]);
    if(!$select_user){
        echo json_encode(['error' => 'no user found']);
    } else {
        $data= array(
            'user' => $select_user
        );
        
            http_response_code(200);
            echo json_encode(['status' => 'success','message'=>'sending data' ,'data' => $data]);
        }
    }
