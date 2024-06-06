<?php
require_once '../config.php';
require_once '../db_connection.php';
header('Content-Type: application/json');

function addPackage($input){
        
    if(!is_array($input)){
        echo json_encode(['status' => 'error', 'message' => 'Invalid data format']);
        exit;
    }

    if ( !isset($input['Days'])||!isset($input['PackageName']) || !isset($input['PackageType']) || !isset($input['Amount']) ) {
        echo json_encode(['status' => 'error', 'message' => 'Missing or invalid input data']);
        exit;
    }

    $data = [
        'Days' => $input['Days'],
        'PackageName' => $input['PackageName'],
        'PackageType' => $input['PackageType'],
        'Amount' => $input['Amount']
    ];

    $insert = DB::insert(DB_NAME, 'packages', $data);
    if($insert){
        echo json_encode(['status' => 'success', 'message' => 'Data inserted successfully']);
    }else{
        echo json_encode(['status' => 'error', 'message' => 'Data insertion failed']);
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
            
        case "update":
            if(!isset($input['id'])){
                echo json_encode(['status' => 'error', 'message' => 'Missing id']);
                exit;
            }

            $id = $input['id'];
            unset($input['id']);
            $update = DB::update(DB_NAME, 'packages', $input, $id, 'PackageID');
            if($update){
                echo json_encode(['status' => 'success', 'message' => 'Data updated successfully']);
            }else{
                echo json_encode(['status' => 'error', 'message' => 'Data update failed']);
            }
            break;  

        default:
            echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
            


        }


   }