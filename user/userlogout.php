<?php

    require_once '../db_connection.php';
    
    db::logout('users'); //logout($tablename)
    $url = './user_dashboard1.php';
    header('Location: ' . $url);
?>