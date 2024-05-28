<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "world";

$dsn = "mysql:host=$host;dbname=$database;charset=utf8";

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
    exit();
}

$sql = "SELECT countries.name as country, states.name as state, cities.name as city FROM countries
        JOIN states ON countries.id = states.country_id
        JOIN cities ON states.id = cities.state_id";
 
$stmt = $pdo->query($sql);
$countries= $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($countries);

?>
