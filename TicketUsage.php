<?php
require_once 'config.php';
require_once 'db_connection.php';
class TicketUsage{
    private $conn;
    private $ticketusageTable = 'timeusage';
    
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function SetTimes($TicketSalesID){
        try{
            $stmt = $this->conn->prepare("UPDATE $this->ticketusageTable SET EntryTime = NOW() WHERE TicketSalesID = :TicketSalesID");
            $stmt->bindParam(':TicketSalesID', $TicketSalesID);
            $stmt->execute();
            return updateSuccess;
        } catch (PDOException $e) {
            return "Update failed: " . $e->getMessage();
        }
    }

}
 $conn = new dbConnection(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$obj= new TicketUsage($conn->connection());
echo json_encode($obj->SetTimes(12));