<?php
require_once '../db_connection.php';
header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] === 'POST')
{
    $input = json_decode(file_get_contents('php://input'), true);
    $EventID = $input['EventID'];
    $poster=array();;
    $select_event= DB::selectBy(DB_NAME, 'events', ['EventID' => $EventID]);
    $select_Poster;
    $select_TimeSlots;
    $select_Tickets;

    if(count($select_event) > 0)
    {
        foreach($select_event as $event)
        {
            $select_Poster= DB::selectBy(DB_NAME, 'eventposter', ['EventID' => $EventID]);
            $select_TimeSlots= DB::selectBy(DB_NAME, 'timeslots', ['EventID' => $EventID]);
            $select_Tickets= DB::selectBy(DB_NAME, 'tickets', ['EventID' => $EventID]);
        }
        if(!$select_Poster){
            echo json_encode(['error' => 'no poster found']);
        }
        else if(!$select_TimeSlots){
            echo json_encode(['error' => 'no timeslots found']);
        }
        else if(!$select_Tickets){
            echo json_encode(['error' => 'no tickets found']);
        }
        else{
            $data= array(
                'event' => $select_event,
                'poster' => $select_Poster,
                'timeslots' => $select_TimeSlots,
                'tickets' => $select_Tickets
            );
            http_response_code(200);
            echo json_encode(['status' => 'success','message'=>'sending data' ,'data' => $data]);
        }

    }
}
else {
    echo json_encode(['error' => 'no data found']);
}