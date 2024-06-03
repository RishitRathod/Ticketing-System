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

    // Debug: Log the initial data fetch
    error_log("Initial Events: " . print_r($events, true));
    
    if ($events) {
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

        // Debug: Log the full SQL query with bound values
        $fullQuery = $query;
        foreach ($conditions as $key => $value) {
            $fullQuery = str_replace(":$key", "'$value'", $fullQuery);
        }
        error_log("SQL Query with values: $fullQuery");

        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Debug: Print the fetched results
        error_log("Results: " . print_r($results, true));

        return $results;
    } catch (PDOException $e) {
        error_log("Select by join condition failed: " . $e->getMessage());
        return [];
    }
}
?>
