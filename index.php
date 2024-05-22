<?php
require_once 'config.php';
require_once 'db_connection.php';
require_once 'select.php';
require_once 'update.php';
require_once 'insert.php';
require_once 'delete.php';

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
        return $insert->insertData($data);
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
}
?>
