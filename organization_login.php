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
    $check = DB::selectBy(DB_NAME, $tablename, ['Name' => $data['Username']]);
    if ($check) {
        if (password_verify($data['Password'], $check[0]['Password'])) {
            echo json_encode(['status' => 'success',
                'message' => 'Login successful',
                'data' => $check[0]
            ]);
<<<<<<< HEAD
            SetUserSession($check[0]['Name'], $check[0]['OrganizationID'],'OrganizationID','organization','organizations');
=======
            session_start();
            $_SESSION['Org_Username'] = $check[0]['Name'];
            $_SESSION['Org_ID'] = $check[0]['OrgID'];
            $_SESSION['Org_Email'] = $check[0]['Email'];
            $_SESSION['packagr_id'] = $check[0]['PakageID'];
>>>>>>> b526992df400842d4e82129fb91a36a1b3aa59f7

            header("organization_dashboard.html");
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid password']);
        }

    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email']);
    }
 
}
?>
