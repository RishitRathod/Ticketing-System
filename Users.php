
<?php

require_once 'db_connection.php';
require_once 'config.php';

// $conn = new dbConnection(DB_HOST, DB_USER, DB_PASS, DB_NAME);
// $Users= new Users($conn->connection());
// echo json_encode($Users->getTicketUsage(12,12));

/**
 * Class User
 * This class represents a user and provides methods to interact with user-related data in the database.
 */
class Users {
    /**
     * @var PDO The database connection object.
     */
    private $conn;

    /**
     * @var string The name of the users table in the database.
     */
    private $userTable = 'users';

    /**
     * @var string The name of the ticketsales table in the database.
     */
    private $ticketsalesTable = 'ticketsales';

    /**
     * @var string The name of the timeusage table in the database.
     */
    private $timeusageTable = 'timeusage';

    /**
     * User constructor.
     *
     * @param PDO $conn The database connection object.
     */
    public function __construct($conn) {
        $this->conn = $conn;
    }

    /**
     * Fetch details of a user by their UserID.
     *
     * @param int $UserID The unique identifier of the user.
     * @return array An associative array containing user details or an error message if the user is not found.
     * @throws PDOException If there is an error with the database operation.
     */
    public function FetchUserDetails($UserID) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM $this->userTable WHERE UserID = :UserID");
            $stmt->bindParam(':UserID', $UserID);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$result) {
                return ["error" => "User not found", 'message' => $result];
            }
            return $result;
        } catch (PDOException $e) {
            return ['error' => "Fetch User Details failed: " . $e->getMessage()];
        }
    }

    /**
     * Fetches ticket information for a specific user.
     *
     * @param int $UserID The ID of the user.
     * @return array An associative array containing the ticket information, or an error message if the user is not found or the operation fails.
     * @throws PDOException If there is an error with the database operation.
     */
    public function TicketInfo($UserID){
        try {
            $stmt = $this->conn->prepare("SELECT * FROM $this->ticketsalesTable WHERE UserID = :UserID");
            $stmt->bindParam(':UserID', $UserID);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            if (!$result) {
                return ["error" => "User not found", 'message' => $result];
            }
            return $result;
        } catch (PDOException $e) {
            return ['error' => "Fetch User Details failed: " . $e->getMessage()];
        }
    }

   /**
     * Fetches ticket usage information for a specific user and ticket sale.
     *
     * @param int $UserID The ID of the user.
     * @param int $TicketSalesID The ID of the ticket sale.
     * @return array An associative array containing the ticket usage information, or an error message if the operation fails.
     * @throws PDOException If there is an error with the database operation.
     */
    public function getTicketUsage($UserID, $TicketSalesID){
        try {
            $this->conn->query("SET SESSION group_concat_max_len = 10000");
            $stmt = $this->conn->prepare("SELECT 
                u.UserID,
                u.Username,
                u.Email AS UserEmail,
                u.UserPhoto,
                u.userphonenumber,
                GROUP_CONCAT(DISTINCT ts.TicketSalesID) AS TicketSalesIDs,
                GROUP_CONCAT(DISTINCT ts.TimeSlotID) AS TimeSlotIDs,
                GROUP_CONCAT(DISTINCT ts.Quantity) AS Quantities,
                GROUP_CONCAT(DISTINCT tu.TimeUsageID) AS TimeUsageIDs,
                GROUP_CONCAT(DISTINCT tu.EntryTime) AS EntryTimes,
                GROUP_CONCAT(DISTINCT tu.ExitTime) AS ExitTimes
            FROM 
                {$this->userTable} u
            LEFT JOIN 
                {$this->ticketsalesTable} ts ON u.UserID = ts.UserID
            LEFT JOIN 
                {$this->timeusageTable} tu ON ts.TicketSalesID = tu.TicketSalesID
            WHERE 
                u.UserID = :UserID
                AND ts.TicketSalesID = :TicketSalesID
            GROUP BY 
                u.UserID, u.Username, u.Email, u.UserPhoto, u.userphonenumber");
    
            $stmt->bindParam(':UserID', $UserID, PDO::PARAM_INT);
            $stmt->bindParam(':TicketSalesID', $TicketSalesID, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            if (!$result) {
                return ["error" => "User not found", 'message' => $result];
            }
            
            return $result;
    
        } catch (PDOException $e) {
            return ['error' => "Fetch User Details failed: " . $e->getMessage()];
        }
    }

 /**
 * Fetches details of tickets available for purchase at a specific event.
 *
 * @param int $EventID The ID of the event.
 * @return array An associative array containing ticket details for the event, or an error message if the operation fails.
 */
public function GetDetailsAtBuyTickets($EventID)
{
    try {
        $this->conn->query("SET SESSION group_concat_max_len = 10000");
        $stmt = $this->conn->prepare("SELECT 
                    t.TicketID, 
                    t.TicketType, 
                    ts.TimeSlotID,
                    ts.StartTime,
                    ts.EndTime,
                    t.Quantity, 
                    t.Availability, 
                    t.QR_CODE, 
                    t.LimitQuantity, 
                    t.Discount, 
                    t.Price, 
                    e.Capacity,
                    e.EventName,
                    e.StartDate,
                    e.EndDate,
                    o.Name AS OrganizationName
                FROM 
                    tickets t
                INNER JOIN 
                    events e ON t.EventID = e.EventID
                INNER JOIN 
                    timeslots ts ON e.EventID = ts.EventID
                INNER JOIN 
                    organizations o ON e.OrgID = o.OrgID
                WHERE 
                    e.EventID = :EventID
                ORDER BY
                    t.TicketID");

        $stmt->bindParam(':EventID', $EventID, PDO::PARAM_INT);
        
        // Execute the prepared statement
        $stmt->execute();
    
        // Fetch the results
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (!$result) {
            return ["error" => "No details found for EventID: $EventID"];
        }

        $mergedResult = [];
        foreach ($result as $row) {
            $ticketID = $row['TicketID'];
            if (!isset($mergedResult[$ticketID])) {
                $mergedResult[$ticketID] = [
                    "TicketID" => $row['TicketID'],
                    "TicketType" => $row['TicketType'],
                    "TimeSlots" => [],
                    "Quantity" => $row['Quantity'],
                    "Availability" => $row['Availability'],
                    "QR_CODE" => $row['QR_CODE'],
                    "LimitQuantity" => $row['LimitQuantity'],
                    "Discount" => $row['Discount'],
                    "Price" => $row['Price'],
                    "OrganizationName" => $row['OrganizationName'],
                    "Capacity" => $row["Capacity"],
                    "EventName" =>$row['EventName'],
                    "StartDate" =>$row['StartDate'],
                    "EndDate" =>$row['EndDate'],
                ];
            }
            $mergedResult[$ticketID]['TimeSlots'][] = [
                "TimeSlotID" => $row['TimeSlotID'],
                "StartTime" => $row['StartTime'],
                "EndTime" => $row['EndTime']
            ];
        }

        // Reset array keys and return the merged result
        return array_values($mergedResult);

    } catch (PDOException $e) {
        return ['error' => "Fetch Details failed: " . $e->getMessage()];
    }

    
}

    
}
