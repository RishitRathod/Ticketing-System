<?php

class insert
{
    private $conn;
    private $table;

    public function __construct($conn, $table)
    {
        $this->conn = $conn;
        $this->table = $table;
    }

    public function insertData($data)
    {
        try {
            $keys = implode(',', array_keys($data));
            $placeholders = ':' . implode(', :', array_keys($data));
            $sql = "INSERT INTO " . $this->table . " ($keys) VALUES ($placeholders)";
            $stmt = $this->conn->prepare($sql);
            foreach ($data as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
            $stmt->execute();
            return insertSuccess;
        } catch (PDOException $e) {
            return "Insert failed: " . $e->getMessage();
        }
    }


public function insertDataReturnID($data)
{
    try {
        $keys = implode(',', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO " . $this->table . " ($keys) VALUES ($placeholders)";
        $stmt = $this->conn->prepare($sql);
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->execute();
        return $this->conn->lastInsertId();
    } catch (PDOException $e) {
        return "Insert failed: " . $e->getMessage();
    }
}
}


?>
