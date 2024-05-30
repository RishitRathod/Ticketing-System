<?php

    require_once '../db_connection.php';
    
    db::logout('organizations'); //logout($tablename)
    $url = './organization_login.html';
   
    session_unset();
    session_destroy();

    header('Location: ' . $url);
    exit();
?>