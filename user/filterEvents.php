<?php
require_once('../config.php');
require_once('../db_connection.php');

header('Content-Type: application/json');

try {
    
    $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $category = $_GET['category'] ?? null;
    $location = $_GET['location'] ?? 'All';
    $searchTerm = $_GET['searchTerm'] ?? '';
    $duration = $_GET['duration'] ?? '';
    $price = $_GET['price'] ?? '';
    $minPrice = $_GET['minPrice'] ?? '';
    $maxPrice = $_GET['maxPrice'] ?? '';

    $sql = "SELECT e.EventID, e.EventName, e.Description, e.StartDate, e.EndDate, e.VenueAddress, e.City, e.State, e.Country, t.Price, ep.poster
            FROM events e
            LEFT JOIN tickets t ON e.EventID = t.EventID
            LEFT JOIN eventposter ep ON e.EventID = ep.EventID
            WHERE 1=1";

    $conditions = [];
    $params = [];

    if ($category) {
        $conditions[] = "e.EventType = ?";
        $params[] = $category;
    }

    if ($location && $location !== 'All') {
        $conditions[] = "(e.City LIKE ? OR e.State LIKE ? OR e.Country LIKE ?)";
        $paramValue = "%$location%";
        $params = array_merge($params, [$paramValue, $paramValue, $paramValue]);
    }

    if ($searchTerm) {
        $conditions[] = "(e.EventName LIKE ? OR e.Description LIKE ? e.City LIKE ? OR e.State LIKE ? OR e.Country LIKE ?)";
        $paramValue = "%$searchTerm%";
        $params = array_merge($params, [$paramValue, $paramValue,$paramValue, $paramValue, $paramValue]);
    }

    // Duration filtering logic remains the same, omitted for brevity

    if ($minPrice && $maxPrice) {
        $conditions[] = "t.Price BETWEEN ? AND ?";
        $params = array_merge($params, [$minPrice, $maxPrice]);
    }

    foreach ($conditions as $condition) {
        $sql .= " AND $condition";
    }

    // Price ordering logic
    if ($price === 'LowToHigh') {
        $sql .= " ORDER BY t.Price ASC";
    } elseif ($price === 'HighToLow') {
        $sql .= " ORDER BY t.Price DESC";
    }

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);

    $events = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($events);
} catch (PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}   