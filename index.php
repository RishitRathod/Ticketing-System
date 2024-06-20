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

    static function delete($dbname, $table, $id,$ColumnName)
    {
        $host   = DB_HOST;
        $user   = DB_USER;
        $pass   = DB_PASS;
        $db = new dbConnection($host, $user, $pass, $dbname);
        $delete = new delete($db->connection(), $table);
        return $delete->deleteData($id,$ColumnName);
    }

    static function FetchEventDetailsByOrgID($OrgID){
        $host   = DB_HOST;
        $user   = DB_USER;
        $pass   = DB_PASS;
        $dbname = DB_NAME;
        $db = new dbConnection($host, $user, $pass, $dbname);
        $Events= new Events($db->connection());
        return $Events->FetchEventDetailsByOrgID($OrgID);
    }

    static function FetchEventDetails($EventID){
        $host   = DB_HOST;
        $user   = DB_USER;
        $pass   = DB_PASS;
        $dbname = DB_NAME;
        $db = new dbConnection($host, $user, $pass, $dbname);
        $Events= new Events($db->connection());
        return $Events->FetchEventDetails($EventID);
    }

    static function FetchAllEventsByOrgID($OrgID){
        $host   = DB_HOST;
        $user   = DB_USER;
        $pass   = DB_PASS;
        $dbname = DB_NAME;
        $db = new dbConnection($host, $user, $pass, $dbname);
        $Events= new Events($db->connection());
        return $Events->FetchAllEventsByOrgID($OrgID);
    }

    static function GetEventsByCatagory($Catagory,$limit,$offset){
        $host   = DB_HOST;
        $user   = DB_USER;
        $pass   = DB_PASS;
        $dbname = DB_NAME;
        $db = new dbConnection($host, $user, $pass, $dbname);
        $Events= new Events($db->connection());
        return $Events->GetEventsByCatagory($Catagory,$limit,$offset);
    }

    static function fetchPaginatedEventData($limit, $offset){
        $host   = DB_HOST;
        $user   = DB_USER;
        $pass   = DB_PASS;
        $dbname = DB_NAME;
        $db = new dbConnection($host, $user, $pass, $dbname);
        $Events= new Events($db->connection());
        return $Events->fetchPaginatedEventData($limit, $offset);
    }

    static function fetchPaginatedEventDataByOrgID($limit, $offset, $OrgID){
        $host   = DB_HOST;
        $user   = DB_USER;
        $pass   = DB_PASS;
        $dbname = DB_NAME;
        $db = new dbConnection($host, $user, $pass, $dbname);
        $Events= new Events($db->connection());
        return $Events->fetchPaginatedEventDataByOrgID($limit, $offset, $OrgID);
    }

    static function FetchOrgDetails($OrgID){
        $host   = DB_HOST;
        $user   = DB_USER;
        $pass   = DB_PASS;
        $dbname = DB_NAME;
        $db = new dbConnection($host, $user, $pass, $dbname);
        $Organizations= new Organizations($db->connection());
        return $Organizations->FetchOrgDetails($OrgID);
    }

    static function CheckOrgStatus($OrgID){
        $host   = DB_HOST;
        $user   = DB_USER;
        $pass   = DB_PASS;
        $dbname = DB_NAME;
        $db = new dbConnection($host, $user, $pass, $dbname);
        $Organizations= new Organizations($db->connection());
        return $Organizations->CheckOrgStatus($OrgID);
    }

    static function GetOrgDetails($OrgID){
        $host   = DB_HOST;
        $user   = DB_USER;
        $pass   = DB_PASS;
        $dbname = DB_NAME;
        $db = new dbConnection($host, $user, $pass, $dbname);
        $Organizations= new Organizations($db->connection());
        return $Organizations->GetOrgDetails($OrgID);
    }

    static function FetchOrgPackages($OrgID){
        $host   = DB_HOST;
        $user   = DB_USER;
        $pass   = DB_PASS;
        $dbname = DB_NAME;
        $db = new dbConnection($host, $user, $pass, $dbname);
        $Organizations= new Organizations($db->connection());
        return $Organizations->FetchOrgPackages($OrgID);
    }
    
    static function getBalance($OrgID){
        $host   = DB_HOST;
        $user   = DB_USER;
        $pass   = DB_PASS;
        $dbname = DB_NAME;
        $db = new dbConnection($host, $user, $pass, $dbname);
        $Organizations= new Organizations($db->connection());
        return $Organizations->getBalance($OrgID);
    }

    static function setBalance($OrgID,$Amount,$columnname){
        $host   = DB_HOST;
        $user   = DB_USER;
        $pass   = DB_PASS;
        $dbname = DB_NAME;
        $db = new dbConnection($host, $user, $pass, $dbname);
        $Organizations= new Organizations($db->connection());
        return $Organizations->setBalance($OrgID,$Amount,$columnname);
    }
    
    static function SearchEvents($OrgID,$SearchTerm){
        $host   = DB_HOST;
        $user   = DB_USER;
        $pass   = DB_PASS;
        $dbname = DB_NAME;
        $db = new dbConnection($host, $user, $pass, $dbname);
        $Orgs= new Organizations($db->connection());
        return $Orgs->SearchEvents($OrgID,$SearchTerm);
    }

     static function validatePackage($PackageID,$OrgID){
        $host = DB_HOST;
        $user = DB_USER;
        $pass = DB_PASS;
        $dbname = DB_NAME;
        $db = new dbConnection($host, $user, $pass,$dbname);
        $Organizations= new Organizations($db->connection());
        return $Organizations->ValidatePackage($PackageID,$OrgID);

     }

     static function GetOrgAnnualPlanDetail($OrgID){
        $host = DB_HOST;
        $user = DB_USER;
        $pass = DB_PASS;
        $dbname = DB_NAME;
        $db = new dbConnection($host, $user,$pass, $dbname);
        $Orgs= new Organizations($db->connection());
        return $Orgs->GetOrgAnnualPlanDetail($OrgID);
        
     }

     static function AttendanceByEventForOrg($EventID){

        $host = DB_HOST;
        $user = DB_USER;
        $pass = DB_PASS;
        $dbname = DB_NAME;
        $db = new dbConnection($host, $user, $pass,$dbname);
        $Organizations= new Organizations($db->connection());
        return $Organizations->AttendanceByEventForOrg($EventID);
     }

    static function AttendanceByEvent($EventID){
        $host   = DB_HOST;
        $user   = DB_USER;
        $pass   = DB_PASS;
        $dbname = DB_NAME;
        $db = new dbConnection($host, $user, $pass, $dbname);
        $Organizations= new Organizations($db->connection());
        return $Organizations->AttendanceByEvent($EventID);
    }

    static function FetchUserDetails($UserID){
        $host   = DB_HOST;
        $user   = DB_USER;
        $pass   = DB_PASS;
        $dbname = DB_NAME;
        $db = new dbConnection($host, $user, $pass, $dbname);
        $Users= new Users($db->connection());
        return $Users->FetchUserDetails($UserID);
    }

    static function TicketInfo($UserID){
        $host   = DB_HOST;
        $user   = DB_USER;
        $pass   = DB_PASS;
        $dbname = DB_NAME;
        $db = new dbConnection($host, $user, $pass, $dbname);
        $Users= new Users($db->connection());
        return $Users->TicketInfo($UserID);
    }

    
    static function getTicketUsage($UserID, $TicketSalesID){
        $host   = DB_HOST;
        $user   = DB_USER;
        $pass   = DB_PASS;
        $dbname = DB_NAME;
        $db = new dbConnection($host, $user, $pass, $dbname);
        $Users= new Users($db->connection());
        return $Users->getTicketUsage($UserID, $TicketSalesID);
    }

    static function GetDetailsAtBuyTickets($EventID){
        $host   = DB_HOST;
        $user   = DB_USER;
        $pass   = DB_PASS;
        $dbname = DB_NAME;
        $db = new dbConnection($host, $user, $pass, $dbname);
        $Users= new Users($db->connection());
        return $Users->GetDetailsAtBuyTickets($EventID);
    }
    static function GetTciektDetails($TicketSalesID){
        $host   = DB_HOST;
        $user   = DB_USER;
        $pass   = DB_PASS;
        $dbname = DB_NAME;
        $db = new dbConnection($host, $user, $pass, $dbname);
        $TicketUsage= new TicketUsage($db->connection());
        return $TicketUsage->GetTciektDetails($TicketSalesID);
    }


    static function SetTimes($TicketSalesID){
        $host   = DB_HOST;
        $user   = DB_USER;
        $pass   = DB_PASS;
        $dbname = DB_NAME;
        $db = new dbConnection($host, $user, $pass, $dbname);
        $TicketUsage= new TicketUsage($db->connection());
        return $TicketUsage->SetTimes($TicketSalesID);
    }

    static function GetTicketsDataByUserID($UserID){
        $host   = DB_HOST;
        $user   = DB_USER;
        $pass   = DB_PASS;
        $dbname = DB_NAME;
        $db = new dbConnection($host, $user, $pass, $dbname);
        $TicketUsage= new TicketUsage($db->connection());
        return $TicketUsage->GetTicketsDataByUserID($UserID);
    }

    // static function GetDetailsToInsertintoTimeUsagetableatEntry($TicketSalesID){
    //     $host   = DB_HOST;
    //     $user   = DB_USER;
    //     $pass   = DB_PASS;
    //     $dbname = DB_NAME;
    //     $db = new dbConnection($host, $user, $pass, $dbname);
    //     $TicketUsage= new TicketUsage($db->connection());
    //     return $TicketUsage->GetDetailsToInsertintoTimeUsagetableatEntry($TicketSalesID);
    // }

    static function UpdateEntryOrExitTimes($TicketSalesID,$amountPeopleEnterOrExit,$EntryOrExit){
        $host   = DB_HOST;
        $user   = DB_USER;
        $pass   = DB_PASS;
        $dbname = DB_NAME;
        $db = new dbConnection($host, $user, $pass, $dbname);
        $TicketUsage= new TicketUsage($db->connection());
        return $TicketUsage->UpdateEntryOrExitTimes($TicketSalesID,$amountPeopleEnterOrExit,$EntryOrExit);
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

    static function getUserID(){
        $host   = DB_HOST;
        $user   = DB_USER;
        $pass   = DB_PASS;
        $db = new dbConnection($host, $user, $pass, DB_NAME);
        $User= new User($db->connection(),'users');
        return $User->getUserID();
    
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
