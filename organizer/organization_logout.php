<?php

    require_once '../db_connection.php';
    
    db::logout('organizations'); //logout($tablename)
    $url = './organization_login.html';
    header('Location: ' . $url);
?>