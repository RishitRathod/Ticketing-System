<?php
require_once '../db_connection.php';
require_once '../config.php';

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        $action = $data['action'];

        switch ($action) {
            case 'add':
                $tablename = $data['tablename'];
                $packages = $data['packages'];

                foreach ($packages as $package) {
                    $insert = DB::insert(DB_NAME, $tablename, $package);
                    if ($insert !== insertSuccess) {
                        echo json_encode(['status' => 'error', 'message' => $insert]);
                        exit;
                    }
                }
                echo json_encode(['status' => 'success', 'message' => 'Packages added successfully']);
                break;

            case 'delete':
                $pakageID = $data['PakageID'];
                $delete = DB::delete(DB_NAME, 'Packages', ['PakageID' => $pakageID]);
                if ($delete) {
                    echo json_encode(['status' => 'success', 'message' => 'Package deleted successfully']);
                } else {
                    echo json_encode(['status' => 'error', 'message' => 'Failed to delete package']);
                }
                break;

            default:
                echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
                break;
        }
        break;

    case 'GET':
        $result = DB::selectAll(DB_NAME, 'Packages');
        echo json_encode(['status' => 'success', 'packages' => $result]);
        break;


    default:
        echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
        break;
}
?>
