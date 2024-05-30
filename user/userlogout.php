<?php
    session_start();
    require_once '../db_connection.php';
    
    db::logout('users'); // Logout method from your DB class
    session_unset();
    session_destroy();

    $url = './user_dashboard1.php';
    header('Location: ' . $url);
    exit();
?>
