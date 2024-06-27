<?php

require_once 'config.php';
require_once 'select.php';
require_once 'update.php';
require_once 'insert.php';
require_once 'delete.php';
require_once 'checkUser.php';
require_once 'index1.php';
require_once 'QR-Code-Generator/QRCodeGenerator.php';
require_once 'Events.php';
require_once 'Organizations.php';
require_once 'Users.php';
require_once 'TicketUsage.php';

class dbConnection
{
    private $host;
    private $user;
    private $pass;
    private $dbname;
    private $conn;

    public function __construct($host, $user, $pass, $dbname)
    {
        $this->host = $host;
        $this->user = $user;
        $this->pass = $pass;
        $this->dbname = $dbname;
    }

    public function connection()
    {
        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname", $this->user, $this->pass);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database Not Connected: " . $e->getMessage());
        }
        return $this->conn;
    }
}
?>
