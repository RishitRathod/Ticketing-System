<?php
require_once 'checkUser.php';
require_once 'index.php'; // Ensure this path is correct for including the DB class

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if raw POST data is received
    $data = json_decode(file_get_contents('php://input'), true);
    $tablename=$data['tablename'];
    $data = array_filter($data, function($key) { //this can be a function that filters the data array
        return  $key !== 'tablename' ;
        }, ARRAY_FILTER_USE_KEY);

    // Check if json_decode() returned an array
    if (!is_array($data)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid data format']); //this can be a function that returns a json response
        exit;
    }

    //login the admin
    $check = DB::selectBy(DB_NAME, $tablename, ['Username' => $data['Username']]);
    if ($check) {
        if (password_verify($data['Password'], $check[0]['Password'])) {
            echo json_encode(['status' => 'success',
                'message' => 'Login successful',
                
            ]);
            SetUserSession($check[0]['Username'], $check[0]['UserID'],'UserID','user','users');

        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid password']);
        }

    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid Username']);
    }
 
}
?>
