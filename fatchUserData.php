<?php

require_once 'config.php';
require_once 'db_connection.php';

if(isset($_SESSION['user'])){
    $host   = DB_HOST;
    $user   = DB_USER;
    $pass   = DB_PASS;
    $db = new dbConnection($host, $user, $pass, DB_NAME);
    $colname=$_SESSION['user']['idColumnName'];
    $id=$_SESSION['user']['id'];
    $data=array($colname=>$id);
    $data=db::selectBy(DB_NAME, $_SESSION['user']['tableName'], $data);

    echo json_encode($data);


}
else{
    echo json_encode(array('error' => 'User not logged in'));
}