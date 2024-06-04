<?php
require_once '../db_connection.php';
header('Content-Type: application/json');
if($_SERVER['REQUEST_METHOD'] === 'POST')
{   $input = json_decode(file_get_contents('php://input'), true);
    $OrgID = $input['OrgID'];

    $select_org= DB::selectBy(DB_NAME, 'organizations', ['OrgID' => $OrgID]);

    if(!$select_org){
        echo json_encode(['error' => 'no organization found']);
    } else {
        $select_package = DB::selectBy(DB_NAME, 'org_package', ['OrgID' => $OrgID]);
        if(!$select_package){
            echo json_encode(['error' => 'no package found']);
        }
        else{
        $select_event= DB::selectBy(DB_NAME, 'events', ['OrgID' => $OrgID]);
            if(!$select_event){
                echo json_encode(['error' => 'no event found']);
            }
            else {
                // print_r ($select_package);
                // print_r ($select_event);
                // print_r ($select_org);
                $data= array(
                    'org' => $select_org,
                    'package' => $select_package,
                    'event' => $select_event
                );
                http_response_code(200);
                echo json_encode(['status' => 'success','message'=>'sending data' ,'data' => $data]);


            }
        }
    }
}
else {
    echo json_encode(['error' => 'no data found']);
}
?>