<?php
require_once('../config.php');
require_once('../db_connection.php');

// Fetch and filter events
$category = $_GET['category'] ?? null;
$location = $_GET['location'] ?? 'All';
$searchTerm = $_GET['searchTerm'] ?? '';
$duration = $_GET['duration'] ?? '';
$price = $_GET['price'] ?? '';
$minPrice = $_GET['minPrice'] ?? '';
$maxPrice = $_GET['maxPrice'] ?? '';

// SQL query to fetch events
$sql = "SELECT e.EventID, e.EventName, e.Description, e.StartDate, e.EndDate, e.VenueAddress, e.City, e.State, e.Country, t.Price, ep.poster
        FROM events e
        LEFT JOIN tickets t ON e.EventID = t.EventID
        LEFT JOIN eventposter ep ON e.EventID = ep.EventID
        WHERE 1=1";

// Filter by category
if ($category) {
    $sql .= " AND e.EventType = '$category'";
}

// Filter by location
if ($location && $location !== 'All') {
    $sql .= " AND (e.City LIKE '%$location%' OR e.State LIKE '%$location%' OR e.Country LIKE '%$location%')";
}

// Filter by search term
if ($searchTerm) {
    $sql .= " AND (e.EventName LIKE '%$searchTerm%' OR e.Description LIKE '%$searchTerm%')";
}

// Filter by duration
if ($duration) {
    $now = date('Y-m-d');
    if ($duration == 'Today') {
        $sql .= " AND '$now' BETWEEN e.StartDate AND e.EndDate";
    } elseif ($duration == 'ThisWeek') {
        $weekStart = date('Y-m-d', strtotime('monday this week'));
        $weekEnd = date('Y-m-d', strtotime('sunday this week'));
        $sql .= " AND (e.StartDate BETWEEN '$weekStart' AND '$weekEnd' OR e.EndDate BETWEEN '$weekStart' AND '$weekEnd')";
    } elseif ($duration == 'ThisMonth') {
        $monthStart = date('Y-m-01');
        $monthEnd = date('Y-m-t');
        $sql .= " AND (e.StartDate BETWEEN '$monthStart' AND '$monthEnd' OR e.EndDate BETWEEN '$monthStart' AND '$monthEnd')";
    }
}

// Filter by price
if ($minPrice && $maxPrice) {
    $sql .= " AND t.Price BETWEEN $minPrice AND $maxPrice";
} elseif ($price) {
    if ($price == 'LowToHigh') {
        $sql .= " ORDER BY t.Price ASC";
    } elseif ($price == 'HighToLow') {
        $sql .= " ORDER BY t.Price DESC";
    }
}

// Execute query
$result = $conn->query($sql);

$events = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $events[] = [
            'id' => $row['EventID'],
            'name' => $row['EventName'],
            'description' => $row['Description'],
            'date' => $row['StartDate'] . ' to ' . $row['EndDate'],
            'location' => $row['VenueAddress'] . ', ' . $row['City'] . ', ' . $row['State'] . ', ' . $row['Country'],
            'price' => $row['Price'],
            'poster' => $row['poster']
        ];
    }
}

header('Content-Type: application/json');
echo json_encode($events);

$conn->close();
?>
