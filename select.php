<?php
require_once 'db_connection.php';
 
class select
{
    private $conn;
    private $table;

    public function __construct($conn, $table)
    {
        $this->conn = $conn;
        $this->table = $table;
    }

    public function selectAll()
    {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM " . $this->table);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            return "Select failed: " . $e->getMessage();
        }
    }

    
    
public function selectBy($conditions)
{
    try {
        $query = "SELECT * FROM " . $this->table . " WHERE ";
        foreach ($conditions as $key => $value) {
            if (!preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $key)) {
                throw new PDOException("Invalid parameter name: $key");
            }
            $query .= "$key = :$key ";
        }
        $stmt = $this->conn->prepare($query);
        foreach ($conditions as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return "Select by condition failed: " . $e->getMessage();
    }
}

public function getLastInsertID()
    {
        try {
            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            return "Select failed: " . $e->getMessage();
        }
    }
}
// $host   = DB_HOST;
// $user   = DB_USER;
// $pass   = DB_PASS;
// $dbname = DB_NAME;
// $db = new dbConnection($host, $user, $pass, $dbname);
// echo db::getLastInsertID($dbname, 'events');


?>
