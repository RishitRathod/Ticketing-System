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
    private $OrgPackageTable = "org_package";
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
    public function FetchOrgDetails($OrgID){
        try {

            $this->conn->query("SET SESSION group_concat_max_len = 10000");

                
                $sql= "SELECT 
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
                                '\",\"BuyDate\":\"', op.BuyDate, '\"}'
                            ) SEPARATOR ',') AS Packages
                        FROM 
                            {$this->organizationTable} o
                        INNER JOIN 
                            {$this->OrgPackageTable} op ON o.OrgID = op.OrgID
                        INNER JOIN 
                            {$this->Packages} p ON op.PackageID = p.PackageID
                        GROUP BY
                            o.OrgID,
                            o.Name,
                            o.Email,
                            o.ContactNumber,
                            o.ContactEmail,
                            o.Address,
                            o.Status,
                            o.ContactName;";

            $stmt = $this->conn->prepare($sql);
            $stmt->execute();
            $data= $stmt->fetchAll(PDO::FETCH_ASSOC);
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
    
}