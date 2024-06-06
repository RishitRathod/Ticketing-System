<?php

    require_once '../db_connection.php';
    
    db::logout('admin'); //logout($tablename)
    $url = './admin_login.html';
   
    session_unset();
    session_destroy();

    header('Location: ' . $url);
    exit();
?>