<?php
require_once '../config.php'; // Ensure this path is correct for including the config
require_once '../db_connection.php'; // Ensure this path is correct for including the DB class

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decode the received JSON data
    $data = json_decode(file_get_contents('php://input'), true);
    $tablename = $data['tablename'];
    $orgID = $data['OrgID'];
    
    // Validate the input
    if (!isset($orgID) || !isset($tablename)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid data format']);
        exit;
    }
    
    // Fetch events based on OrgID
    $events = DB::selectBy(DB_NAME, $tablename, ['OrgID' => $orgID]);
    
    if ($events) {
       // echo json_encode(['tablename' => $tablename, 'status' => 'success', 'message' => 'Events exist', 'data' => $events]);
        
        // Fetch details by joining events and eventposter tables
        $detailedEvents = selectByJoin(['OrgID' => $orgID]);
        
        if (is_array($detailedEvents)) {
            echo json_encode(['tablename' => $tablename, 'status' => 'success', 'message' => 'Event details exist', 'data' => $detailedEvents]);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'No event details exist']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No events exist']);
    }
}

function selectByJoin($conditions) {
    try {
        $conn = new PDO("mysql:host=localhost;dbname=ticketing_system", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // $query = "SELECT * FROM events e JOIN eventposter ep ON e.EventID = ep.EventID WHERE ";
        $query = "SELECT *
        FROM events e 
        JOIN eventposter ep ON e.EventID = ep.EventID
        JOIN timeslots ts ON e.EventID = ts.EventID
        JOIN tickets tsale ON e.EventID = tsale.EventID
        WHERE ";
        $queryConditions = [];
        
        foreach ($conditions as $key => $value) {
            if (!preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $key)) {
                throw new PDOException("Invalid parameter name: $key");
            }
            $queryConditions[] = "$key = :$key";
        }
        $query .= implode(" AND ", $queryConditions);
        
        $stmt = $conn->prepare($query);
        
        foreach ($conditions as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return "Select by join condition failed: " . $e->getMessage();
    }
}