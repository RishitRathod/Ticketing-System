<?php
session_start();
class User{
    

    private $conn;
    private $table;

    public function __construct($conn, $table)
    {   
        $this->conn = $conn;
        $this->table = $table;
    }
     function  SetUserSession($name,$id,$idColumnName,$role){
        try{
            
    
            //set the session array
                $_SESSION['user'] = array(
                    'name' => $name,
                    'id' => $id,
                    'role' => $role,
                    'tableName' =>$this->table,
                    'idColumnName' => $idColumnName
                );
                //return the session array
                return ($_SESSION['user']);
        }
        catch (PDOException $e) {
            return "Session failed: " . $e->getMessage();
        }
    }

    function isUserloggedIn(){
        if(isset($_SESSION['user'])){
            $data=$_SESSION['user'];
            json_encode(['status'=>true,'message'=>'User logged in as '.$data['name'],'role'=>$data['role'],'id'=>$data['id'],'tableName'=>$data['tableName'],'idColumnName'=>$data['idColumnName']]);
        }
        else{
            json_encode(['status'=>false,'message'=>'User not logged in' ]);
        }
    }

    function getUserRole(){
        if(isset($_SESSION['user'])){
            return $_SESSION['user']['role'];
        }
        else{
            return false;
        }
    }

    function getUserId(){
        if(isset($_SESSION['user'])){
            return $_SESSION['user']['id'];
        }
        else{
            return false;
        }
    }

    function getUserName(){
        if(isset($_SESSION['user'])){
            return $_SESSION['user']['name'];
        }
        else{
            return false;
        }
    }

    function getUserTableName(){
        if(isset($_SESSION['user'])){
            return $_SESSION['user']['tableName'];
        }
        else{
            return false;
        }
    }

    function getUserTableIdColumnName(){
        if(isset($_SESSION['user'])){
            return $_SESSION['user']['idColumnName'];
        }
        else{
            return false;
        }
    }

    function logout(){
        if($this->isUserloggedIn()){
            unset($_SESSION['user']);
            session_destroy();
            echo "User logged out successfully by lougout"."</br>";
            return true;
        }
        else{
            echo "User not logged in said by lougout"."</br>";
            return false;
        }
    }


}


 //call the method of this class here to test it
// $host   = DB_HOST;
// $user   = DB_USER;
// $pass   = DB_PASS;
// $dbname = DB_NAME;
// $db = new dbConnection($host, $user, $pass, $dbname);
// $user= new User($db->connection(),'users');
// echo $user-> isUserloggedIn();
// $boll =$user->logout();
// if($boll)
// {echo "User logged out successfully main"."</br>";}
// else 
// {echo "User logged in main"."</br>";}




?>
