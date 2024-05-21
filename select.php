<?php

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
                $query .= "$key = :$key AND ";
            }
            $query = rtrim($query, " AND ");
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
}
?>
