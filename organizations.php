<?php

require_once 'db_connection.php';
require_once 'config.php';
// $conn = new dbConnection(DB_HOST, DB_USER, DB_PASS, DB_NAME);
// $org= new Organizations($conn->connection());
// echo json_encode($org->CheckOrgStatus(9));
class Organizations{
/**
 * Class Organizations
 * 
 * Represents a class for handling organization data in the database.
 * Contains properties for database connection and table names.
 * Includes a constructor to initialize the class with a database connection.
 */


    private $conn;

/**
  * Represents the declaration of private properties $organizationTable, $OrgPackageTable and $Packages
  * with assigned table names "organizations", "org_pakaage" and "packages" respectively.
  * @var string
*/
    private $organizationTable = "organizations";
    private $OrgPlansTable = "org_plans";
    private $Packages = "packages";

/**
 * Represents a constructor for initializing a class with a database connection.
 */
    public function __construct($conn){
        $this->conn = $conn;
        
    }

    /**
     * Fetches organization details based on the provided OrgID.
     * Executes a SQL query to retrieve organization details along with package information.
     * Returns an associative array containing the fetched data.
     * If an exception (PDOException) occurs during the process, returns an error message.
     *
     * @param int $OrgID The ID of the organization for which details are to be fetched.
     * @return array Associative array containing organization and package details, or an error message.
     * @throws PDOException If there is an error with the database operation.
     */
    public function FetchOrgDetails($OrgID) {
        try {
            $this->conn->query("SET SESSION group_concat_max_len = 10000");

            $sql = "SELECT 
                o.OrgID,
                o.Name AS OrganizationName,
                o.Email AS OrganizationEmail,
                o.ContactNumber AS OrganizationContactNumber,
                o.ContactEmail AS OrganizationContactEmail,
                o.Address AS OrganizationAddress,
                o.Status AS OrganizationStatus,
                o.ContactName AS OrganizationContactName,
                GROUP_CONCAT(DISTINCT CONCAT(
                    '{\"PackageID\":', op.PackageID, 
                    ',\"PackageName\":\"', p.PackageName, 
                    '\",\"Amount\":', p.Amount, 
                    ',\"PackageType\":\"', p.PackageType, 
                    '\",\"Expiry_date\":\"', op.Expiry_date,
                    '\",\"Amount_of_Days\":', op.Amount_of_Days,  
                    ',\"Amount_of_Tickets\":', op.Amount_of_Tickets, '\"}'
                )) AS Packages
            FROM 
                {$this->organizationTable} o
            INNER JOIN 
                {$this->OrgPlansTable} op ON o.OrgID = op.OrgID
            INNER JOIN 
                {$this->Packages} p ON op.PackageID = p.PackageID
            WHERE o.OrgID = :OrgID
            GROUP BY
                o.OrgID,
                o.Name,
                o.Email,
                o.ContactNumber,
                o.ContactEmail,
                o.Address,
                o.Status,
                o.ContactName";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindparam(":OrgID", $OrgID, PDO::PARAM_INT);
            $stmt->execute();
            $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $data;

        } catch (PDOException $e) {
            return ["error" => "Select failed: " . $e->getMessage()];
        }
    }

  /**
     * Fetches the status of an organization based on the provided OrgID.
     * Executes a SQL query to retrieve the status and reason of rejection (if any) for the organization.
     * Returns an array with the status information including 'Approved', 'Pending', 'Rejected', or 'Unknown'.
     * If the organization is not found, returns an error message.
     * If an exception (PDOException) occurs during the process, returns an error message.
     *
     * @param int $OrgID The ID of the organization for which status is to be checked.
     * @return array Associative array containing the status information or an error message.
     * @throws PDOException If there is an error with the database operation.
    */
    function CheckOrgStatus($OrgID){
        try {
            $sql = "SELECT Status,ReasonofRegection FROM {$this->organizationTable} WHERE OrgID = :OrgID";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':OrgID', $OrgID, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if($result===false){
                return ["error" => "Organization not found", 'message'=> $result];
            }
            return $result;
            
        } catch (PDOException $e) {
            return ["error" => "Select failed: " . $e->getMessage()];

        }
    }

    /**
     * Fetches organization details based on the provided OrgID.
     * Executes a SQL query to retrieve organization details.
     * Returns an associative array containing the fetched data.
     * If an exception (PDOException) occurs during the process, returns an error message.
     *
     * @param int $OrgID The ID of the organization for which details are to be fetched.
     * @return array Associative array containing organization details or an error message.
     * @throws PDOException If there is an error with the database operation.
     */
    public function GetOrgDetails($OrgID){
        try {
            $sql = "SELECT * FROM {$this->organizationTable} WHERE OrgID = :OrgID";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':OrgID', $OrgID, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if($result===false){
                return ["error" => "Organization not found", 'message'=> $result];
            }
            return $result;
            
        } catch (PDOException $e) {
            return ["error" => "Select failed: " . $e->getMessage()];

        }
    }

    public function AttendanceByEvent($EventID){
       try {$sql="SELECT 
    u.UserID,
    u.Username,
    u.Email,
    u.UserPhoto,
    u.userphonenumber,
    ts.TicketSalesID,
    ts.TicketID,
    ts.EventID,
    ts.TimeSlotID,
    ts.Name AS BuyerName,
    ts.Email AS BuyerEmail,
    ts.Phone AS BuyerPhone,
    ts.Quantity,
    ts.PurchaseDate,
    ts.Status AS TicketStatus,
    ts.QR_CODE AS TicketQRCode,
    ts.EventDate,
    tu.TimeUsageID,
    tu.EntryTime,
    tu.ExitTime,
    tu.TimeslotID AS TimeUsageSlotID,
    tu.TicketSalesID AS TimeUsageSalesID
FROM 
    users u
LEFT JOIN 
    ticketsales ts ON u.UserID = ts.UserID
LEFT JOIN 
    timeusage tu ON ts.TicketSalesID = tu.TicketSalesID
WHERE 
    ts.EventID = :EventID
GROUP BY 
    u.UserID;
";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':EventID', $EventID, PDO::PARAM_INT);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
    catch (PDOException $e) {
        return ["error" => "Select failed: " . $e->getMessage()];
    }
    }

    public function AttendanceByEventForOrg($EventID){
        try {$sql="SELECT 
     u.UserID,
     u.Username,
     u.Email,
    --  u.UserPhoto,
     u.userphonenumber,
    --  ts.TicketSalesID,
    --  ts.TicketID,
    --  ts.EventID,
     ts.TimeSlotID,
     ts.Name AS BuyerName,
     ts.Email AS BuyerEmail,
     ts.Phone AS BuyerPhone,
     ts.Quantity,
     ts.PurchaseDate,
    --  ts.Status AS TicketStatus,
    --  ts.QR_CODE AS TicketQRCode,
     ts.EventDate,
     t.TimeSlotID,
     t.StartTime,
     t.EndTime,
    --  tu.TimeUsageID,
    --  tu.EntryTime,
    --  tu.ExitTime,
    --  tu.TimeslotID AS TimeUsageSlotID,
    --  tu.TicketSalesID AS TimeUsageSalesID
    e.EventName

 FROM 
     users u
 LEFT JOIN 
     ticketsales ts ON u.UserID = ts.UserID
LEFT JOIN
    events e ON ts.EventID = e.EventID
LEFT JOIN 
    timeslots t ON ts.TimeSlotID = t.TimeSlotID

--  LEFT JOIN 
--      timeusage tu ON ts.TicketSalesID = tu.TicketSalesID
 WHERE 
     ts.EventID = :EventID
 GROUP BY 
     u.UserID;
 ";
         $stmt = $this->conn->prepare($sql);
         $stmt->bindParam(':EventID', $EventID, PDO::PARAM_INT);
         $stmt->execute();
         $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
         return $result;
     }
     catch (PDOException $e) {
         return ["error" => "Select failed: " . $e->getMessage()];
     }
     }

    
    //write doc comment for this function
    
    public function FetchOrgPackages($OrgID) {
        try {
            $sql = "SELECT 
                p.PackageID, 
                p.PackageName, 
                p.Amount, 
                p.PackageType, 
                op.Expiry_date, 
                op.Amount_of_Days AS No_of_Days_Or_Tickets,
                op.Amount_of_Tickets AS balance
            FROM 
                {$this->OrgPlansTable} op
            INNER JOIN 
                {$this->Packages} p ON op.PackageID = p.PackageID
            WHERE 
                op.OrgID = :OrgID";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(':OrgID', $OrgID, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (count($result) > 0) {
                return $result;
            } else {
                return "No data found. Please buy a package first.";
            }

        } catch (PDOException $e) {
            return ["error" => "Select failed: ". $e->getMessage()];
        }
    }

     public function validatePackage($PackageID, $OrgID) {
        try {
            $sql = "SELECT 
                op.PackageID, 
                op.OrgID, 
                p.PackageName, 
                p.Amount, 
                p.PackageType, 
                op.Expiry_date,
                op.Amount_of_Days AS No_of_Days_Or_Tickets,
                op.Amount_of_Tickets AS balance
            FROM 
                {$this->OrgPlansTable} op
            INNER JOIN 
                {$this->Packages} p ON op.PackageID = p.PackageID
            WHERE
                op.PackageID = :PackageID AND op.OrgID = :OrgID
            GROUP BY p.PackageID";

            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(":PackageID", $PackageID, PDO::PARAM_INT);
            $stmt->bindParam(":OrgID", $OrgID, PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;

        } catch (PDOException $e) {
            return ["error" => "Failed to fetch package: " . $e->getMessage()];
        }
    }
}
// $conn = new dbConnection(DB_HOST, DB_USER, DB_PASS, DB_NAME);
// $org= new Organizations($conn->connection());
// // echo json_encode($org->FetchOrgPackages(9));
// echo json_encode($org->FetchOrgDetails(9));

    
?>