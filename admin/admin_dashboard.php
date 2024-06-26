<?php
require_once '../index.php'; // Ensure this path is correct for including the DB class

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if raw POST data is received
    $data = json_decode(file_get_contents('php://input'), true);
    $tablename=$data['tablename'];
    $action=$data['action'];
    $data = array_filter($data, function($key) { //this can be a function that filters the data array
        return  $key !== 'tablename' ;
        }, ARRAY_FILTER_USE_KEY);

    // Check if json_decode() returned an array
    if (!is_array($data)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid data format']); //this can be a function that returns a json response
        exit;
    }

    switch ($action) {
        case 'fetch':
            if($tablename == 'organizations'){
                $check = DB::selectAll(DB_NAME, $tablename);
                //return all organization
                if ($check) {
                    echo json_encode(['tablename'=>$tablename,'status' => 'success', 'message' => 'Organization exist', 'data' => $check]);
                } 
                else {
                    echo json_encode(['status' => 'error', 'message' => 'NO Organization exist']);
                }
        
        
            }
            
            elseif($tablename == 'users'){
                $check = DB::selectAll(DB_NAME, $tablename);
                //return all users
                if ($check) {
                    echo json_encode(['tablename'=>$tablename, 'status' => 'success', 'message' => 'Users exist', 'data' => $check]);
                } 
                else {
                    echo json_encode(['status' => 'error', 'message' => 'NO Users exist']);
                }
        
        
            }
        
            elseif($tablename =='events')
            {
                $check = DB::FetchEventsWithOrgName();
                //return all events
                if ($check) {
                    echo json_encode(['tablename'=>$tablename, 'status' => 'success', 'message' => 'Events exist', 'data' => $check]);
                } 
                else {
                    echo json_encode(['status' => 'error', 'message' => 'NO Events exist']);
                }
            }
            else {
                echo json_encode(['status' => 'error', 'message' => 'Invalid table name']);
            }
            break;
        
            case 'approve':
                if ($tablename == 'organizations') {
                    // Ensure 'columnName' and 'columnValue' are provided
                    if (!isset($data['columnName']) || !isset($data['columnValue'])) {
                        echo json_encode(['status' => 'error', 'message' => 'columnName or columnValue not provided']);
                        exit;
                    }
                    // Update status to 'Approved' for the given organization ID
                    $check = DB::update(DB_NAME, $tablename, ['Status' => 'Approved'], $data['columnValue'], $data['columnName']);
                    if ($check) {
                        echo json_encode(['tablename' => $tablename, 'status' => 'success', 'message' => ucfirst($tablename) . ' approved']);
                    } else {
                        echo json_encode(['status' => 'error', 'message' => ucfirst($tablename) . ' not approved']);
                    }
                }
                break;
    
            case 'reject':
                if ($tablename == 'organizations') {
                    // Ensure 'columnName' and 'columnValue' are provided
                    if (!isset($data['columnName']) || !isset($data['columnValue'])) {
                        echo json_encode(['status' => 'error', 'message' => 'columnName or columnValue not provided']);
                        exit;
                    }
                    // Update status to 'Rejected' and save reason for rejection for the given organization ID
                    $check = DB::update(DB_NAME, $tablename, ['Status' => 'Rejected', 'ReasonofRegection' => $data['reason']], $data['columnValue'], $data['columnName']);
                    if ($check) {
                        echo json_encode(['tablename' => $tablename, 'status' => 'success', 'message' => ucfirst($tablename) . ' rejected']);
                    } else {
                        echo json_encode(['status' => 'error', 'message' => ucfirst($tablename) . ' not rejected']);
                    }
                }
                break;

            
            default:
            
            break;
    }

}