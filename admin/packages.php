<?php
require_once '../config.php';
require_once '../db_connection.php';
header('Content-Type: application/json');

function addPackage($input){
        
    if(!is_array($input)){
        echo json_encode(['status' => 'error', 'message' => 'Invalid data format']);
        exit;
    }

    if (!isset($input['PackageName']) || !isset($input['PackageType']) || !isset($input['Amount']) || !is_array($input['PackageName']) || !is_array($input['PackageType']) || !is_array($input['Amount'])) {
        echo json_encode(['status' => 'error', 'message' => 'Missing or invalid input data']);
        exit;
    }


    $insert=null;
    for ($i = 0; $i < count($input['PackageName']); $i++) {
        $data = [
            'PackageName' => $input['PackageName'][$i],
            'PackageType' => $input['PackageType'][$i],
            'Amount' => $input['Amount'][$i]
        ];
        $insert = DB::insert(DB_NAME, 'packages', $data);
    }
    
    if($insert!=null){
        echo json_encode(['status' => 'success', 'message' => 'Data submitted successfully']);
    }else{
        echo json_encode(['status' => 'error', 'message' => 'Data submission failed']);
    }
}


if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $input = json_decode(file_get_contents('php://input'), true);
    // print_r($input);
    // exit();
    //remove the action key from the input array
    $action = $input['action'];
    unset($input['action']);
    // print_r($input);
    // exit();
    switch ($action) {
        case 'fetch':
            $packages = DB::selectAll(DB_NAME, 'packages');
            if($packages){
                echo json_encode(['status' => 'success', 'message' => 'Data fetched successfully', 'data' => $packages]);
            }else{
                echo json_encode(['status' => 'error', 'message' => 'No data found']);
            }
            break;
        case 'add':
            addPackage($input);
            break;

        case "delete":
            $id = $input['id'];
            $delete = DB::delete(DB_NAME, 'packages', $id, 'PackageID');
            if($delete){
                echo json_encode(['status' => 'success', 'message' => 'Data deleted successfully']);
            }else{
                echo json_encode(['status' => 'error', 'message' => 'Data deletion failed']);
            }
            break;
        
        case "select":
            $id = $input['id'];
            $package = DB::update(DB_NAME, 'packages', ['PackageID' => $id]);
            if($package){
                echo json_encode(['status' => 'success', 'message' => 'Data fetched successfully', 'data' => $package]);
            }else{
                echo json_encode(['status' => 'error', 'message' => 'No data found']);
            }
            break;
        default:
            echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
            


        }


   }