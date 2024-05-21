<?php

require_once 'index.php'; // Ensure this path is correct for including the DB class

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if raw POST data is received
    $data = json_decode(file_get_contents('php://input'), true);
    $tablename=$data['tablename'];
    $data = array_filter($data, function($key) {
        return  $key !== 'tablename' ;
        }, ARRAY_FILTER_USE_KEY);

    // Check if json_decode() returned an array
    if (!is_array($data)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid data format']);
        exit;
    }

    //login the admin
    $check = DB::selectBy(DB_NAME, $tablename, ['AdminUsername' => $data['AdminUsername']]);
    if ($check) {
        if (password_verify($data['Password'], $check[0]['Password'])) {
            echo json_encode(['status' => 'success',
                'message' => 'Login successful',
                'data' => $check[0]
            ]);
            session_start();
            $_SESSION['AdminUsername'] = $check[0]['AdminUsername'];
            $_SESSION['AdminID'] = $check[0]['AdminID'];
            $_SESSION['AdminEmail'] = $check[0]['Email'];
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid password']);
        }

    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email']);
    }
 
}
?>
