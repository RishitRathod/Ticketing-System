<?php

require_once '../index.php'; // Ensure this path is correct for including the DB class
    
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
    $check = DB::selectBy(DB_NAME, $tablename, ['Email' => $data['Email']]);
    if ($check) {
        if (password_verify($data['Password'], $check[0]['Password'])) {
            
            $sessiondata =db::checkUser(DB_NAME,$tablename ,$check[0]['AdminUsername'], $check[0]['AdminID'], 'AdminID' ,"admin"); //checkUser($dbname, $table,$name,$id,$idColumnName,$role,$tableName)
            echo json_encode(['status' => 'success',
                'message' => 'Login successful',
                'data' => $check[0],
                'serverChahe' => $sessiondata,
                'password' => $data['Password']
            ]);
            
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid password']);
        }

    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email']);
    }
 
}
?>

