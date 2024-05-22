<?php

session_start();

class User{

    static function  SetUserSession($name,$id,$idColumnName,$role,$tableName){

        $_SESSION['user'] = array(
            'name' => $name,
            'id' => $id,
            'role' => $role,
            'tableName' => $tableName,
            'idColumnName' => $idColumnName
        );
        
    //return the session array
    return $_SESSION['user'];
    
    

}
}




?>
