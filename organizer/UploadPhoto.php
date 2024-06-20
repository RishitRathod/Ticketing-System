<?php
require_once '../index.php'; // Ensure this path is correct for including the DB class
require_once '../db_connection.php';
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    // echo $_POST['OrgID'];
    // print_r( $_FILES['file']s);
    if(isset($_FILES['file']) && $_FILES['file']['error'] == 0 && isset($_POST['OrgID'])){
        $file = $_FILES['file'];
        $filename = $file['name'];
        $fileTmpName = $file['tmp_name'];
        $fileSize = $file['size'];
        $fileError = $file['error'];
        $OrgID=$_POST['OrgID'];
        $path="../uploads/Organizations/".$OrgID."/"."Userlogo/";
        if (!file_exists($path)) {
            if(!mkdir($path, 0777, true)){
                echo json_encode(['status' => 'error', 'message' => 'Error creating directory']);
                exit;
            }

        }
        $fileExt = explode('.', $filename);
        $fileActualExt = strtolower(end($fileExt));
        $allowed = array('jpg', 'jpeg', 'png');
        if (!in_array($fileActualExt, $allowed)) {
            echo json_encode(['status' => 'error', 'message' => 'Invalid file type only jpg, jpeg, png allowed']);
            exit;
        }
        if ($fileError !== 0) {
            echo json_encode(['status' => 'error', 'message' => 'Error uploading file due to file error']);
            exit;
        }
        if ($fileSize > 1000000) {
            echo json_encode(['status' => 'error', 'message' => 'File is too large']);
            exit;
        }
        $fileNameNew = uniqid('', true) . "." . $fileActualExt;
       // echo $fileNameNew;
        $fileDestination = $path.$fileNameNew;
        if (move_uploaded_file($fileTmpName, $fileDestination)) {
            //echo json_encode(['status' => 'success', 'message' => 'File uploaded successfully', 'path' => $fileDestination]);
            $result=DB::update(DB_NAME, 'organizations', ['orgphoto' => $fileDestination], $OrgID, 'OrgID');
            if( $result!=='Update Successfully'){
                echo json_encode(['status' => 'error', 'message' => 'Error uploading file due to db issues' . $result]);
                exit;
            }
            echo json_encode(['status'=> 'success','message'=> '
            File uploaded successfully'.$result,'path'=> $fileDestination]);
            header("Location: ./org_profile.html");
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Error uploading file due to move error']);
            exit;
        }



    }
    else {
        echo json_encode(['status' => 'error', 'message' => 'No file uploaded']);
        exit;
    }



        
}else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
    exit;
}