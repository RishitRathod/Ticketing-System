<?php
require_once '../db_connection.php';
require_once '../config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if raw POST data is received
    $data = json_decode(file_get_contents('php://input'), true);

    $action=$data['action'];
    
    // Check if json_decode() returned an array
    if (!is_array($data)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid data format']); //this can be a function that returns a json response
        exit;
    }
    //only for package table no need to chack tablename in this case 
    switch ($action) {
        case 'fetch':
            $check = DB::selectAll(DB_NAME, 'packages');
            //return all organization
            if ($check) {
                echo json_encode(['status' => 'success', 'message' => 'packages exist', 'data' => $check]);
            } 
            else {
                echo json_encode(['status' => 'error', 'message' => 'NO packages exist']);
            }
            break;
        case 'add':
            $data = array_filter($data, function($key) {
                return  $key !== 'action' ;
                }, ARRAY_FILTER_USE_KEY);
            
            
            $insert = DB::insert(DB_NAME, 'packages', $data);
            if ($insert == insertSuccess) {
                echo json_encode(['status' => 'success', 'message' => 'package added successfully']);
            } else {
                echo json_encode(['status' => 'error', 'message' => $insert]);
            }
            break;
        case 'update':
            $data = array_filter($data, function($key) {
                return  $key !== 'action' ;
                }, ARRAY_FILTER_USE_KEY);
            $update = DB::update(DB_NAME, 'packages', $data, ['PackageID' => $data['PackageID']],"PakageID");
            if ($update == updateSuccess) {
                echo json_encode(['status' => 'success', 'message' => 'package updated successfully']);
            } else {
                echo json_encode(['status' => 'error', 'message' => $update]);
            }
            break;
        case 'delete':
            $delete = DB::delete(DB_NAME, 'packages', ['PackageID' => $data['PackageID']]);
            if ($delete == deleteSuccess) {
                echo json_encode(['status' => 'success', 'message' => 'package deleted successfully']);
            } else {
                echo json_encode(['status' => 'error', 'message' => $delete]);
            }
            break;
        default:
            echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
    }

}
