<?php

require_once 'index.php'; // Ensure this path is correct for including the DB class

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if raw POST data is received
    $data = $_POST;
    $tablename = $data['tablename'];
    $data = array_filter($data, function($key) {
        return $key !== 'tablename';
    }, ARRAY_FILTER_USE_KEY);

    // Check if $data is an array
    if (!is_array($data)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid data format']);
        exit;
    }

    if (isset($data['Password'])) {
        $data['Password'] = password_hash($data['Password'], PASSWORD_BCRYPT);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Password is required']);
        exit;
    }

    // Handle file upload if exists
    if (isset($_FILES['UserPhoto']) && $_FILES['UserPhoto']['error'] == UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/' . $data['Username'] . '/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $uploadFile = $uploadDir . basename($_FILES['UserPhoto']['name']);
        if (!move_uploaded_file($_FILES['UserPhoto']['tmp_name'], $uploadFile)) {
            echo json_encode(['status' => 'error', 'message' => 'File upload failed']);
            exit;
        }
        $data['UserPhoto'] = $uploadFile;
    } else {
        $data['UserPhoto'] = ''; // Set to empty if no file is uploaded
    }

    // Check if the email is already registered
    $check = DB::selectBy(DB_NAME, $tablename, ['Email' => $data['Email']]);
    if ($check) {
        echo json_encode(['status' => 'error', 'message' => 'Email already registered']);
        exit;
    }

    // Insert the user data
    $insert = DB::insert(DB_NAME, $tablename, $data);
    if ($insert == insertSuccess) {
        echo json_encode(['status' => 'success', 'message' => 'User registered successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => $insert]);
    }

    exit;
}
?>
