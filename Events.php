<?php 
require_once 'db_connection.php';
require_once 'config.php';

class Events{

/**
 * The Event class represents a single event in the system.
 * 
 * This class contains properties for various tables related to events, 
 * as well as methods to fetch event details and all events by organization ID from the database.
 * 
 * The FetchEventDetails method retrieves detailed information about a specific event based on 
 * EventID and OrgID, including event name, description, dates, capacity, venue, tickets, 
 * time slots, and ticket sales.
 * 
 * The FetchAllEventsByOrgID method fetches all events associated with a
 * specific organization ID.
 */

    private $conn;

    public function __construct($conn){
        $this->conn = $conn;
    }

    //TablesRealtedToEvents
    /**
     * The name of the table in the database that stores event data.
     *
     * @var string
     */
    private $EventTable = "events";

    /**
     * The name of the table in the database that stores organization data.
     *
     * @var string
     */
    private $OrgTable = "organizations";

    /**
     * The name of the table in the database that stores ticket data.
     *
     * @var string
     */
    private $TicketTable = "tickets";

    /**
     * The name of the table in the database that stores time slot data.
     *
     * @var string
     */
    private $TimeSlotTable = "timeslots";

    /**
     * The name of the table in the database that stores event poster data.
     *
     * @var string
     */
    private $EventPostersTable = "eventposter";

    /**
     * The name of the table in the database that stores ticket sales data.
     *
     * @var string
     */
    private $TicketSalesTable = "ticketsales";


    /**
     * The unique identifier for the event.
     *
     * @var int
     */
    private $EventID;
    
    /**
     * The identifier for the organization that hosts the event.
     *
     * @var int
     */
    private $OrgID;
    
    /**
     * The identifier for the ticket associated with the event.
     *
     * @var int
     */
    private $TicketID;
    
    /**
     * The identifier for the time slot of the event.
     *
     * @var int
     */
    private $TimeSlotID;

    /**
     * @var string The name of the EventBookMark table table in the database.
     */private $userbookmarkedeventsTable = 'userbookmarkedevents';

    
 /**
 * Fetches event details from the database based on the provided EventID and OrgID.
 * This method executes a SQL query to fetch event details including event name, description, 
 * dates, capacity, venue, tickets, time slots, and ticket sales.
 *
 * @param int $EventID The unique identifier for the event.
 * @param int $OrgID The identifier for the organization hosting the event.
 * @return array An array containing the event details or an error message if the query fails.
 * @throws PDOException If there is an error with the database operation.
 */

public function FetchEventDetailsByOrgID( $OrgID) {
    try {
        $this->conn->query("SET SESSION group_concat_max_len = 10000");

        $sql = "SELECT 
        e.EventID, e.OrgID, e.EventName, e.Description, e.StartDate, e.EndDate,
        e.Capacity, e.EventType, e.QR_CODE, e.VenueAddress, e.Country, e.State, e.City,
        o.Name AS OrgName,
        GROUP_CONCAT(DISTINCT ep.poster SEPARATOR ',') AS Posters,
        GROUP_CONCAT(DISTINCT CONCAT(
            '{\"TicketID\":', t.TicketID, 
            ',\"TicketType\":\"', t.TicketType, 
            '\",\"Quantity\":', COALESCE(t.Quantity, 'null'),
            ',\"QR_CODE\":\"', COALESCE(t.QR_CODE, 'null'), 
            '\",\"LimitQuantity\":', COALESCE(t.LimitQuantity, 'null'), 
            ',\"Discount\":', COALESCE(t.Discount, 'null'), 
            ',\"Price\":', COALESCE(t.Price, 'null'), '}'
        ) SEPARATOR ',') AS Tickets,
        GROUP_CONCAT(DISTINCT CONCAT(
            '{\"TimeSlotID\":', tmsl.TimeSlotID, 
            ',\"StartTime\":\"', tmsl.StartTime, 
            '\",\"EndTime\":\"', tmsl.EndTime, 
            '\",\"Availability\":', COALESCE(tmsl.Availability, 'null'), '}'
        ) SEPARATOR ',') AS TimeSlots,
        GROUP_CONCAT(DISTINCT CONCAT(
            '{\"TicketSalesID\":', ts.TicketSalesID, 
            ',\"UserID\":', COALESCE(ts.UserID, 'null'), 
            ',\"Quantity\":', COALESCE(ts.Quantity, 'null'), '}'
        ) SEPARATOR ',') AS TicketSales
    FROM 
        {$this->EventTable} e
    LEFT JOIN 
        {$this->OrgTable} o ON e.OrgID = o.OrgID
    LEFT JOIN 
        {$this->EventPostersTable} ep ON e.EventID = ep.EventID
    LEFT JOIN 
        {$this->TicketTable} t ON e.EventID = t.EventID
    LEFT JOIN 
        {$this->TimeSlotTable} tmsl ON e.EventID = tmsl.EventID
    LEFT JOIN 
        {$this->TicketSalesTable} ts ON t.TicketID = ts.TicketID
    WHERE 
        e.OrgID = :OrgID
    GROUP BY 
        e.EventID, e.OrgID, e.EventName, e.Description, e.StartDate, e.EndDate, 
        e.Capacity, e.EventType, e.QR_CODE, e.VenueAddress, e.Country, e.State,
        e.City, o.Name;";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':OrgID', $OrgID, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as &$row) {
            $row['Posters'] = explode(',', $row['Posters']);
            $row['Tickets'] = json_decode('[' . $row['Tickets'] . ']', true);
            $row['TimeSlots'] = json_decode('[' . $row['TimeSlots'] . ']', true);
            $row['TicketSales'] = json_decode('[' . $row['TicketSales'] . ']', true);
        }
        return $result;

    } catch (PDOException $e) {
        return ["error" => "Select failed: " . $e->getMessage()];
    }
}


/**
 * Fetches all events from the database based on the organization ID.
 * 
 *
 * @param int $OrgID The organization ID to filter events by.
 * @return array An array of events matching the organization ID, or an error message if the query fails.
 * @throws PDOException If there is an error with the database operation.
 */
public function FetchEventDetails($EventID) {
    try {
        $this->conn->query("SET SESSION group_concat_max_len = 10000");

        $sql = "SELECT 
        e.EventID, e.OrgID, e.EventName, e.Description, e.StartDate, e.EndDate,
        e.Capacity, e.EventType, e.QR_CODE, e.VenueAddress, e.Country, e.State, e.City,
        o.Name AS OrgName,
        GROUP_CONCAT(DISTINCT ep.poster SEPARATOR ',') AS Posters,
        GROUP_CONCAT(DISTINCT CONCAT(
            '{\"TicketID\":', t.TicketID, 
            ',\"TicketType\":\"', t.TicketType, 
            '\",\"Quantity\":', COALESCE(t.Quantity, 'null'), 
            ',\"QR_CODE\":\"', COALESCE(t.QR_CODE, 'null'), 
            '\",\"LimitQuantity\":', COALESCE(t.LimitQuantity, 'null'), 
            ',\"Discount\":', COALESCE(t.Discount, 'null'), 
            ',\"Availability\":', COALESCE(t.Availability, 'null'), 
            ',\"Price\":', COALESCE(t.Price, 'null'), '}'
        ) SEPARATOR ',') AS Tickets,
        GROUP_CONCAT(DISTINCT CONCAT(
            '{\"TimeSlotID\":', tmsl.TimeSlotID, 
            ',\"StartTime\":\"', tmsl.StartTime, 
            '\",\"EndTime\":\"', tmsl.EndTime, 
            '\",\"Availability\":', COALESCE(tmsl.Availability, 'null'), '}'
        ) SEPARATOR ',') AS TimeSlots,
        GROUP_CONCAT(DISTINCT CONCAT(
            '{\"TicketSalesID\":', ts.TicketSalesID, 
            ',\"UserID\":', COALESCE(ts.UserID, 'null'), 
            ',\"Quantity\":', COALESCE(ts.Quantity, 'null'), '}'
        ) SEPARATOR ',') AS TicketSales
    FROM 
        {$this->EventTable} e
    LEFT JOIN 
        {$this->OrgTable} o ON e.OrgID = o.OrgID
    LEFT JOIN 
        {$this->EventPostersTable} ep ON e.EventID = ep.EventID
    LEFT JOIN 
        {$this->TicketTable} t ON e.EventID = t.EventID
    LEFT JOIN 
        {$this->TimeSlotTable} tmsl ON e.EventID = tmsl.EventID
    LEFT JOIN 
        {$this->TicketSalesTable} ts ON t.TicketID = ts.TicketID
    WHERE 
        e.EventID = :EventID 
    GROUP BY 
        e.EventID, e.OrgID, e.EventName, e.Description, e.StartDate, e.EndDate, 
        e.Capacity, e.EventType, e.QR_CODE, e.VenueAddress, e.Country, e.State,
        e.City, o.Name;";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':EventID', $EventID, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as &$row) {
            $row['Posters'] = explode(',', $row['Posters']);
            $row['Tickets'] = json_decode('[' . $row['Tickets'] . ']', true);
            $row['TimeSlots'] = json_decode('[' . $row['TimeSlots'] . ']', true);
            $row['TicketSales'] = json_decode('[' . $row['TicketSales'] . ']', true);
        }
        return $result;

    } catch (PDOException $e) {
        return ["error" => "Select failed: " . $e->getMessage()];
    }
}

/**
 * Fetches all events from the database based on the organization ID. 
 *
 * @param int $OrgID The organization ID to filter events by.
 * @return array An array of events matching the organization ID, or an error message if the query fails.
 * @throws PDOException If there is an error with the database operation.
 */

function FetchAllEventsByOrgID($OrgID){
    try {
        $this->conn->query("SET SESSION group_concat_max_len = 10000");
    $sql = "SELECT * from {$this->EventTable} where OrgID = :OrgID";
    $stmt = $this->conn->prepare($sql);
    $stmt->bindParam(':OrgID', $OrgID, PDO::PARAM_INT);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    return $result;
    
    } catch (PDOException $e) {
        return ["error" => "Select failed: " . $e->getMessage()];
    }
    
}

/**
 * Fetches all events from the database based on the event category.
 * 
 * @param string $Catagory The event category to filter events by.
 * @return array An array of events matching the event category, or an error message if the query fails.
 * @throws PDOException If there is an error with the database operation.
 */
function GetEventsByCatagory($Catagory,$limit,$offset){
    try {
        $this->conn->query("SET SESSION group_concat_max_len = 10000");

        $sql = "SELECT 
                e.EventID, e.EventName, e.StartDate, e.EndDate, e.VenueAddress,EventType,
                GROUP_CONCAT(DISTINCT ep.poster SEPARATOR ',') AS Posters
            FROM 
                events e
            LEFT JOIN 
                eventposter ep ON e.EventID = ep.EventID
            WHERE 
                e.EventType = :Catagory
            GROUP BY 
                e.EventID, e.EventName, e.StartDate, e.EndDate, e.VenueAddress,e.EventType
            LIMIT :limit OFFSET :offset";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':Catagory', $Catagory, PDO::PARAM_STR);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as &$row) {
            $row['Posters'] = explode(',', $row['Posters']);
        }
        return $result;

    } catch (PDOException $e) {
        return ["error" => "Select failed: " . $e->getMessage()];
    }
}


/**
 * Fetches all events from the database based on the event category.
 * 
 * @param string $Catagory The event category to filter events by.
 * @return array An array of events matching the event category, or an error message if the query fails.
 * @throws PDOException If there is an error with the database operation.
 */
public function fetchPaginatedEventData($limit, $offset) {
    try {
        $this->conn->query("SET SESSION group_concat_max_len = 10000");

        $sql = "SELECT 
                    e.EventID, e.EventName, e.StartDate, e.EndDate, e.VenueAddress, e.EventType,
                    GROUP_CONCAT(DISTINCT ep.poster SEPARATOR ',') AS Posters
                FROM 
                    events e
                LEFT JOIN 
                    eventposter ep ON e.EventID = ep.EventID
                LEFT JOIN 
                    organizations o ON e.OrgID = o.OrgID
                WHERE  
                    o.Status = 'Approved'   
                GROUP BY 
                    e.EventID, e.EventName, e.StartDate, e.EndDate, e.VenueAddress, e.EventType
                LIMIT :limit OFFSET :offset";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as &$row) {
            $row['Posters'] = explode(',', $row['Posters']);
        }
        return $result;

    } catch (PDOException $e) {
        return ["error" => "Select failed: " . $e->getMessage()];
    }
}


/**
 * Fetches all events from the database based on the organization ID.
 * 
 * @param int $OrgID The organization ID to filter events by.
 * @return array An array of events matching the organization ID, or an error message if the query fails.
 * @throws PDOException If there is an error with the database operation.
 */
public function fetchPaginatedEventDataByOrgID($limit, $offset, $OrgID) {
    try {
        $this->conn->query("SET SESSION group_concat_max_len = 10000");

        $sql = "SELECT 
                e.EventID, e.EventName, e.StartDate, e.EndDate, e.VenueAddress,EventType,
                GROUP_CONCAT(DISTINCT ep.poster SEPARATOR ',') AS Posters
            FROM 
                events e
            LEFT JOIN 
                eventposter ep ON e.EventID = ep.EventID
            WHERE 
                e.OrgID = :OrgID
            GROUP BY 
                e.EventID, e.EventName, e.StartDate, e.EndDate, e.VenueAddress,e.EventType
            LIMIT :limit OFFSET :offset";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt->bindParam(':OrgID', $OrgID, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as &$row) {
            $row['Posters'] = explode(',', $row['Posters']);
        }
        return $result;

    } catch (PDOException $e) {
        return ["error" => "Select failed: " . $e->getMessage()];
    }
}

public function GetRegisterUsersForEvent($EventID){
    try {
        $sql = "SELECT 
            u.UserID, 
            u.Username, 
            u.Email, 
            u.UserPhoto, 
            u.userphonenumber,
            t.TicketID, 
            t.TicketType, 
            t.Quantity AS TicketQuantity, 
            t.Availability AS TicketAvailability, 
            t.QR_CODE AS TicketQRCode, 
            t.LimitQuantity, 
            t.Discount, 
            t.Price,
            ts.TicketSalesID, 
            ts.TimeSlotID, 
            ts.Name AS TicketSalesName, 
            ts.Email AS TicketSalesEmail, 
            ts.Phone AS TicketSalesPhone, 
            ts.Quantity AS TicketSalesQuantity, 
            ts.PurchaseDate, 
            ts.Status AS TicketSalesStatus, 
            ts.QR_CODE AS TicketSalesQRCode, 
            ts.EventDate,
            tu.TimeUsageID, 
            tu.EntryTime, 
            tu.ExitTime, 
            tu.isattending, 
            tu.Quantity AS TimeUsageQuantity,
            tsl.TimeSlotID, 
            tsl.StartTime, 
            tsl.EndTime, 
            tsl.Availability AS TimeslotAvailability
        FROM users u
        INNER JOIN ticketsales ts ON u.UserID = ts.UserID
        INNER JOIN tickets t ON ts.TicketID = t.TicketID
        INNER JOIN timeusage tu ON ts.TicketSalesID = tu.TicketSalesID
        INNER JOIN timeslots tsl ON ts.TimeSlotID = tsl.TimeSlotID
        WHERE ts.EventID = :EventID";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':EventID', $EventID, PDO::PARAM_INT);
        if($stmt->execute()){
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result; }
        else{
            return ["error"=> "". $stmt->errorInfo()[2] ];
        }

    } catch (PDOException $e) {
        return ["error" => "Select failed: " . $e->getMessage()];
    
}
}

public function FetchBookmarkedEvent($UserID){
    
    try {
        $this->conn->query("SET SESSION group_concat_max_len = 10000");

        $sql = "SELECT 
                    e.EventID, e.EventName, e.StartDate, e.EndDate, e.VenueAddress, e.EventType,
                    GROUP_CONCAT(DISTINCT ep.poster SEPARATOR ',') AS Posters
                FROM 
                    bookmarks b
                INNER JOIN 
                    events e ON b.EventID = e.EventID
                LEFT JOIN 
                    eventposter ep ON e.EventID = ep.EventID
                WHERE 
                    b.UserID = :UserID
                GROUP BY 
                    e.EventID, e.EventName, e.StartDate, e.EndDate, e.VenueAddress, e.EventType";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':UserID', $UserID, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($result as &$row) {
            $row['Posters'] = explode(',', $row['Posters']);
        }
        return $result;

    } catch (PDOException $e) {
        return ["error" => "Select failed: " . $e->getMessage()];
    }
}


}

// $conn = new dbConnection(DB_HOST, DB_USER, DB_PASS, DB_NAME);
// $Event = new Events($conn->connection());
// $events = $Event->GetRegisterUsersForEvent(241);
// echo json_encode($events);

?>
