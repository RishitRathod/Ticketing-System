<?php
require_once 'db_connection.php';

class DB
{
    static function selectAll($dbname, $table)
    {
        $host   = DB_HOST;
        $user   = DB_USER;
        $pass   = DB_PASS;
        $db = new dbConnection($host, $user, $pass, $dbname);
        $select = new select($db->connection(), $table);
        return $select->selectAll();
    }

    static function selectBy($dbname, $table, $conditions)
    {
        $host   = DB_HOST;
        $user   = DB_USER;
        $pass   = DB_PASS;
        $db = new dbConnection($host, $user, $pass, $dbname);
        $select = new select($db->connection(), $table);
        return $select->selectBy($conditions);
    }
    
    static function update($dbname, $table, $data, $id , $ColumnName)
    {
        $host   = DB_HOST;
        $user   = DB_USER;
        $pass   = DB_PASS;
        $db = new dbConnection($host, $user, $pass, $dbname);
        $update = new update($db->connection(), $table);
        return $update->updateData($data, $id, $ColumnName);
    }
    static function insert($dbname, $table, $data)
    {
        $host   = DB_HOST;
        $user   = DB_USER;
        $pass   = DB_PASS;
        $db = new dbConnection($host, $user, $pass, $dbname);
        $insert = new insert($db->connection(), $table);
        return $insert->insertData($data) ;
    }

    static function insertGetId($dbname, $table, $data)
    {
        $host   = DB_HOST;
        $user   = DB_USER;
        $pass   = DB_PASS;
        $db = new dbConnection($host, $user, $pass, $dbname);
        $insert = new insert($db->connection(), $table);
        return $insert->insertDataReturnID($data) ;
    }

    static function delete($dbname, $table, $id)
    {
        $host   = DB_HOST;
        $user   = DB_USER;
        $pass   = DB_PASS;
        $db = new dbConnection($host, $user, $pass, $dbname);
        $delete = new delete($db->connection(), $table);
        return $delete->deleteData($id);
    }

    static function checkUser($dbname, $table,$name,$id,$idColumnName,$role){

        $host   = DB_HOST;
        $user   = DB_USER;
        $pass   = DB_PASS;
        
        $db = new dbConnection($host, $user, $pass, $dbname);
        $User= new User($db->connection(),$table); 
        $sessiondata=$User->SetUserSession($name,$id,$idColumnName,$role);
        return $sessiondata;

    }

    static function logout($table){
        $host   = DB_HOST;
        $user   = DB_USER;
        $pass   = DB_PASS;
        $db = new dbConnection($host, $user, $pass, DB_NAME);
        $User= new User($db->connection(),$table);
        return $User->logout();
    }

    static function isUserloggedIn($table){
        $host   = DB_HOST;
        $user   = DB_USER;
        $pass   = DB_PASS;
        $db = new dbConnection($host, $user, $pass, DB_NAME);
        $User= new User($db->connection(),$table);
        return $User->isUserloggedIn();
    }


    static function getLastInsertID($dbname, $table)
    {
        $host   = DB_HOST;
        $user   = DB_USER;
        $pass   = DB_PASS;
        $db = new dbConnection($host, $user, $pass, $dbname);
        $select = new select($db->connection(), $table);
        return $select->getLastInsertID();
    }


}


// //  //call the method of this class here to test it
// $host   = DB_HOST;
// $user   = DB_USER;
// $pass   = DB_PASS;
// $dbname = DB_NAME;
// $db = new dbConnection($host, $user, $pass, $dbname);
// echo db::getLastInsertID($dbname, 'events');

// // //echo ($set);
// print_r( ($set));

?>
