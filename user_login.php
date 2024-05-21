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
    $check = DB::selectBy(DB_NAME, $tablename, ['Username' => $data['Username']]);
    if ($check) {
        if (password_verify($data['Password'], $check[0]['Password'])) {
            echo json_encode(['status' => 'success',
                'message' => 'Login successful',
                
            ]);
            session_start();
            $_SESSION['Username'] = $check[0]['Username'];
            $_SESSION['UserID'] = $check[0]['UserID'];
            $_SESSION['UserEmail'] = $check[0]['Email'];
            $_SESSION['Role'] = 'User';
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid password']);
        }

    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid Username']);
    }
 
}
?>
