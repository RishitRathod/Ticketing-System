<?php

class delete
{
    private $conn;
    private $table;

    public function __construct($conn, $table)
    {
        $this->conn = $conn;
        $this->table = $table;
    }

    public function deleteData($id,$columnName)
    {
        try {
            $sql = "DELETE FROM " . $this->table . " WHERE $columnName = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindValue(":id", $id);
            $stmt->execute();
            return deleteSuccess;
        } catch (PDOException $e) {
            return "Delete failed: " . $e->getMessage();
        }
    }
}
?>
