<?php
require_once '../db_connection.php'; // Ensure this path is correct for including the DB class

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Decode the received JSON data
    $data = json_decode(file_get_contents('php://input'), true);
    $EventID = $data['EventID'];
    $tableName = $data['tableName'];

    // Debugging: Log received data
    error_log("Received Event ID: " . $EventID . ", TableName: " . $tableName);

    // Validate the input
    if (!isset($EventID) || !isset($tableName)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid data format']);
        exit;
    }

    // Fetch detailed event data
    $detailedEvents = selectByJoin($EventID);

    if (is_array($detailedEvents)) {
        // Combine data of all four objects into one array
        $mergedData = [];
        foreach ($detailedEvents as $event) {
            $mergedData[] = $event;
        }

        echo json_encode(['tablename' => $tableName, 'status' => 'success', 'message' => 'Event details exist', 'data' => $mergedData]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No event details exist']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}

function selectByJoin($EventID) {
    try {
        $conn = new PDO("mysql:host=localhost;dbname=ticketing_system", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query = "SELECT *
                  FROM events e 
                  left JOIN eventposter ep ON e.EventID = ep.EventID
                  left JOIN timeslots ts ON e.EventID = ts.EventID
                  left JOIN tickets tsale ON e.EventID = tsale.EventID
                  WHERE e.EventID = :EventID"; // Specify the table alias for EventID

        $stmt = $conn->prepare($query);

        // Bind the EventID parameter
        $stmt->bindValue(":EventID", $EventID); // Ensure $EventID exists and has the correct value

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return "Select by join condition failed: " . $e->getMessage();
    }
}

?>
