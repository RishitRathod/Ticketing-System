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
                                                TK.Quantity
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

/**
 * Fetches ticket details based on TicketSalesID for insertion into the timeusage table.
 *
 * @param int $TicketSalesID The TicketSalesID to fetch ticket details for.
 * @return array|string Returns an array of ticket details if successful, or an error message if failed.
 */
public function GetDetailsToInsertintoTimeUsagetableatEntry($TicketSalesID){
    try {
        $sql = "SELECT
                    TS.TicketID,
                    TS.EventID,
                    TS.TimeSlotID,
                    TS.TicketSalesID
                FROM
                    ticketsales TS
                INNER JOIN
                    events E ON TS.EventID = E.EventID

                WHERE
                    TS.TicketSalesID = :TicketSalesID;
                ";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':TicketSalesID', $TicketSalesID);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC); // Use fetch instead of fetchAll
        return $this->InsertIntoTimeUsage($result);
      //  return $result;
    } catch (PDOException $e) {
        return "Fetch failed: " . $e->getMessage();
    }
}



/**
 * Inserts ticket usage data into the timeusage table.
 *
 * @param array $data An associative array containing the data to be inserted.
 * @return string Success message or error message in case of failure.
 */
private function InsertIntoTimeUsage($data){
    try{
        $insert=DB::insert(DB_NAME, $this->ticketusageTable, $data);
        if(!$insert){
            return "Insert failed";
        }
        return $insert;

    } catch (PDOException $e) {
        return "Insert failed: " . $e->getMessage();
    }

}

}

 $conn = new dbConnection(DB_HOST, DB_USER, DB_PASS, DB_NAME);

$obj= new TicketUsage($conn->connection());
echo json_encode($obj->GetDetailsToInsertintoTimeUsagetableatEntry(13));