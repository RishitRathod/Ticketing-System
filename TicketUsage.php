<?php
require_once 'config.php';
require_once 'db_connection.php';
/**
 * Class TicketUsage
 * 
 * This class handles operations related to the time usage of tickets, 
 * particularly setting the entry time for a ticket in the database.
 */
class TicketUsage{
    /**
     * @var PDO $conn The database connection.
     */
    private $conn;

    /**
     * @var string $ticketusageTable The name of the table where time usage data is stored.
     */
    private $ticketusageTable = 'timeusage';

    /**
     * @var string $ticketSalesTable The name of the table where ticket sales data is stored.
     */
    private $ticketSalesTable = 'ticketsales';

    /**
     * Constructor for TicketUsage.
     *
     * @param PDO $conn The database connection to be used by the class.
     */

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    /**
     * Sets the entry time for a given TicketSalesID to the current time.
     *
     * @param int $TicketSalesID The ID of the ticket sale to update.
     * @return string Success message or error message in case of failure.
     */


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

/**
 * Retrieves ticket usage data for a specific user.
 *
 * @param int|string $UserID The ID of the user for whom to retrieve ticket usage data.
 * @return array|string An array of ticket usage data if successful, or an error message if the operation fails.
 */

    public function GetTicketsDataByUserID($UserID){
        try{
            $stmt = $this->conn->prepare("SELECT
                                                E.EventName,
                                                O.Name AS OrgName,
                                                TS.EventDate,
                                                T.StartTime,
                                                T.EndTime,
                                                T.Availability,
                                                TK.TicketType,
                                                TS.Quantity,
                                                 TS.QR_CODE
                                            FROM
                                                ticketsales TS
                                            INNER JOIN
                                                events E ON TS.EventID = E.EventID
                                            INNER JOIN
                                                organizations O ON E.OrgID = O.OrgID
                                            INNER JOIN
                                                timeslots T ON TS.TimeSlotID = T.TimeSlotID
                                            INNER JOIN
                                                tickets TK ON TS.TicketID = TK.TicketID
                                            WHERE
                                                TS.UserID = :UserID;");
            $stmt->bindParam(':UserID', $UserID);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return "Update failed: " . $e->getMessage();
        }
    }
<<<<<<< HEAD

// /**
//  * Fetches ticket details based on TicketSalesID for insertion into the timeusage table.
//  *
//  * @param int $TicketSalesID The TicketSalesID to fetch ticket details for.
//  * @return array|string Returns an array of ticket details if successful, or an error message if failed.
//  */
// public function GetDetailsToInsertintoTimeUsagetableatEntry($TicketSalesID){
//     try {
//         $sql = "SELECT
//                     TS.TicketID,
//                     TS.EventID,
//                     TS.TimeSlotID,
//                     TS.TicketSalesID
//                 FROM
//                     ticketsales TS
//                 INNER JOIN
//                     events E ON TS.EventID = E.EventID

//                 WHERE
//                     TS.TicketSalesID = :TicketSalesID;
//                 ";
//         $stmt = $this->conn->prepare($sql);
//         $stmt->bindParam(':TicketSalesID', $TicketSalesID);
//         $stmt->execute();
//         $result = $stmt->fetch(PDO::FETCH_ASSOC); // Use fetch instead of fetchAll
//         return $this->InsertIntoTimeUsage($result);
//       //  return $result;
//     } catch (PDOException $e) {
//         return "Fetch failed: " . $e->getMessage();
//     }
// }



/**
 * Inserts ticket usage data into the timeusage table.
 *
 * @param array $data An associative array containing the data to be inserted.
 * @return array|string Success message or error message in case of failure.
 */
public function UpdateEntryOrExitTimes($TicketSalesID){
    try{
        
        $checkEntrytime= $this->conn->prepare("SELECT EntryTime IS  NULL AS is_null FROM $this->ticketusageTable WHERE TicketSalesID = :TicketSalesID");
        $checkEntrytime->bindParam(':TicketSalesID', $TicketSalesID);
        $checkEntrytime->execute();
        $result = $checkEntrytime->fetch(PDO::FETCH_ASSOC);
         if($result['is_null']==1){
            $stmt = $this->conn->prepare("UPDATE $this->ticketusageTable SET EntryTime = NOW(), isattending = 1  WHERE TicketSalesID = :TicketSalesID");
            $stmt->bindParam(':TicketSalesID', $TicketSalesID);
            $stmt->execute();
            

            return ['status'=>'sucess' ,'message'=>'EntryTimeUpdated'];

        }else{
            $stmt = $this->conn->prepare("UPDATE $this->ticketusageTable SET ExitTime = NOW(),  isattending = 0 WHERE TicketSalesID = :TicketSalesID");
            $stmt->bindParam(':TicketSalesID', $TicketSalesID);
            $stmt->execute();

            // $stmt = $this->conn->prepare("UPDATE  $this->ticketusageTable set isattending = 0 WHERE TicketSalesID = :TicketSalesID");
            // $stmt->bindParam(':TicketSalesID', $TicketSalesID);
            // $stmt->execute();


            return ['status'=>'sucess' ,'message'=>'ExitTimeUpdated'];

        }


=======
    public function FetchTicketDetails($TicketSalesID){
        try{
            $sql ="SELECT
                        TS.TicketID,
                        TS.EventID,
                        TS.TimeSlotID,
                        TS.EventDate,
                        TS.Quantity,
                        E.Venue,
                        E.EventName,
                        O.Name AS OrgName
                    FROM
                        ticketsales TS
                    INNER JOIN
                        events E ON TS.EventID = E.EventID
                    INNER JOIN
                        organizations O ON E.OrgID = O.OrgID
                    WHERE
                        TS.TicketSalesID = :TicketSalesID;
                    ";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':TicketSalesID', $TicketSalesID);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            return "Update failed: " . $e->getMessage();
        }
>>>>>>> a46369b64ae301c0fbcf931e2c6744755bb9c1ea
    }
    catch(PDOException $e){
        return "Update failed: " . $e->getMessage();
    }
  }
}

<<<<<<< HEAD
// $conn = new dbConnection(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// $obj= new TicketUsage($conn->connection());
// echo json_encode($obj->UpdateEntryOrExitTimes(14));
?>
=======
//  $conn = new dbConnection(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// $obj= new TicketUsage($conn->connection());
// echo json_encode($obj->GetTicketsDataByUserID(25));
>>>>>>> a46369b64ae301c0fbcf931e2c6744755bb9c1ea
