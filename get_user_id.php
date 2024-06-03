<?php
require_once 'db_connection.php';
require_once 'config.php';

if($_SERVER['REQUEST_METHOD'] === 'POST'){

    $id=DB::getUserID();
    if ($id) {
        $response['success'] = true;
        $response['data'] = $id;
        echo json_encode($response);
    } else {
        $response['success'] = false;
        $response['message'] = "Failed to get user id";
        echo json_encode($response);
    }
}