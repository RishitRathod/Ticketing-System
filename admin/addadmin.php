<?php

require_once '../index1.php'; // Ensure this path is correct for including the DB class
    
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if raw POST data is received
    $data = json_decode(file_get_contents('php://input'), true);
    $tablename=$data['tablename'];
    $action=$data['Action'];
    unset($data['tablename']); 
    unset($data['Action']);


    // Check if json_decode() returned an array
    if (!is_array($data)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid data format']);
        exit;
    }

    switch ($action) {
        case 'add':
            // Insert the admin data
            $data['Password']= password_hash($data['Password'], PASSWORD_DEFAULT);

            $insert = DB::insert(DB_NAME, $tablename, $data);
            if ($insert === insertSuccess) {
                echo json_encode(['status' => 'success', 'message' => 'Admin registered successfully']);
            } else {
                echo json_encode(['status' => 'error', 'message' => $insert]);
            }
            break;
        
            case 'update':
                // Update the admin data
                $id = $data['id'];
                $ColumnName = 'AdminID';
                unset($data['id']);
                $update = DB::update(DB_NAME, $tablename, $data, $id, $ColumnName);
                if ($update === updateSuccess) {
                    echo json_encode(['status' => 'success', 'message' => 'Admin updated successfully']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => $update]);
                }
                break;
            case 'delete':
                // Delete the admin data
                $id = $data['id'];
                $ColumnName = 'AdminID';
                $delete = DB::delete(DB_NAME, $tablename, $id, $ColumnName);
                if ($delete === deleteSuccess) {
                    echo json_encode(['status' => 'success', 'message' => 'Admin deleted successfully']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => $delete]);
                }
                break;
            case 'fetch':
                // Fetch the admin data
                $select = DB::selectAll(DB_NAME, $tablename);
                if ($select) {
                    echo json_encode(['status' => 'success', 'data' => $select]);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to fetch admin data']);
                }
                break;
            case 'edit':
                // Fetch the admin data
                $id = $data['id'];
                $ColumnName = 'AdminID';
                $select = DB::selectBy(DB_NAME, $tablename, [$ColumnName => $id]);
                if ($select) {
                    echo json_encode(['status' => 'success', 'data' => $select]);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to fetch admin data']);
                }
                break;
        default:
            echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
            break;
    }
    
    
   

 
}
?>

