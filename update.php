<?php

class update
{
    private $conn;
    private $table;

    public function __construct($conn, $table)
    {
        $this->conn = $conn;
        $this->table = $table;
    }

    public function updateData($data, $id,$columnName)
    {
        try {
            $updateString = "";
            foreach ($data as $key => $value) {
                $updateString .= "$key = :$key, ";
            }
            $updateString = rtrim($updateString, ", ");
            $sql = "UPDATE " . $this->table . " SET $updateString WHERE $columnName = :id";
            $stmt = $this->conn->prepare($sql);
            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
            $stmt->bindValue(":id", $id);
            $stmt->execute();
            return updateSuccess;
        } catch (PDOException $e) {
            return "Update failed: " . $e->getMessage();
        }
    }
}





