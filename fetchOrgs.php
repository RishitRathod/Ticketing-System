<?php
require_once 'config.php';
require_once 'db_connection.php';
header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $input = json_decode(file_get_contents('php://input'), true);
    // print_r($input);
    // exit();
    //remove the action key from the input array
    $action = $input['action'];
    switch ($action){
        case 'FetchOrgDetails':
            $OrgID = $input['OrgID'];
            $response = DB::FetchOrgDetails($OrgID);
            if($response){
                echo json_encode(['status' => 'success', 'message' => 'Data fetched successfully', 'data' => $response]);
            }else{
                echo json_encode(['status' => 'error', 'message' => 'No data found']);

            }
            break;
            
        case 'CheckOrgStatus':
            $OrgID = $input['OrgID'];
            $response = DB::CheckOrgStatus($OrgID);
            if($response){
                echo json_encode(['status' => 'success', 'message' => 'Data fetched successfully', 'data' => $response]);
            }else{
                echo json_encode(['status' => 'error', 'message' => 'No data found']);
            }
            break;
        
        case 'GetOrgDetails':
            $OrgID = $input['OrgID'];
            $response = DB::GetOrgDetails($OrgID);
            if($response){
                echo json_encode(['status' => 'success', 'message' => 'Data fetched successfully', 'data' => $response]);
            }else{
                echo json_encode(['status' => 'error', 'message' => 'No data found']);
            }
            break;

        case 'FetchOrgPackages':
            $OrgID = $input['OrgID'];
            $response = DB::FetchOrgPackages($OrgID);
            if($response){
                echo json_encode(['status' => 'success', 'message' => 'Data fetched successfully', 'data' => $response]);
            }else{
                echo json_encode(['status' => 'error', 'message' => 'No data found']);
            }
            break;

        case 'AttendanceByEvent':
            $EventID = $input['EventID'];
            $response = DB::AttendanceByEvent($EventID);
            if($response){
                echo json_encode(['status' => 'success', 'message' => 'Data fetched successfully', 'data' => $response]);
            }else{
                echo json_encode(['status' => 'error', 'message' => 'No data found']);
            }
            break;
        case 'validatePackage':
            $OrgID = $input['OrgID'];
            $PackageID = $input['PackageID'];
            $response=DB::validatePackage($PackageID,$OrgID);
            if($response){
                echo json_encode(['status' => 'success', 'message' => 'Data fetched successfully', 'data' => $response]);
            }else{
                echo json_encode(['status'=> 'error','message'=> 'No data found']);
            }
            break;
        
        case "AttendanceByEventForOrg":
            $EventID = $input["EventID"];
            $response = DB::AttendanceByEventForOrg($EventID);
            if($response){
                echo json_encode(["status"=> "success","message"=> "Data fetched successfully","data"=> $response]);
            }else{
                echo json_encode(["status"=> "error", "message"=> "No data found"]);
            }
            break;

        case 'getBalance':
            $OrgID = $input['OrgID'];
            $response = DB::getBalance($OrgID);
            if($response){
                echo json_encode(['status' => 'success', 'message' => 'Data fetched successfully', 'data' => $response]);
            }else{
                echo json_encode(['status' => 'error', 'message' => 'No data found']);
            }
            break;
            
        case 'setBalance':
            $OrgID = $input['OrgID'];
            $Amount_of_Days = $input['Amount_of_Days'];
            $Amount_of_Tickets = $input['Amount_of_Tickets'];
            $response = DB::setBalance($OrgID, $Amount_of_Days, $Amount_of_Tickets);
            if($response){
                echo json_encode(['status' => 'success', 'message' => 'Balance updated successfully']);
            }else{
                echo json_encode(['status' => 'error', 'message' => 'Failed to update balance']);
            }
            break;
        
        case 'SearchEvents':
            $OrgID = $input['OrgID'];
            $searchTerm = $input['searchTerm'];
            $response = DB::SearchEvents($OrgID, $searchTerm);
            if($response){
                echo json_encode(['status' => 'success', 'message' => 'Data fetched successfully', 'data' => $response]);
            }else{
                echo json_encode(['status' => 'error', 'message' => 'No data found']);
            }
            break;

            default:
            echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
            break;

            case 'GetOrgAnnualPlanDetail':
                $OrgID = $input['OrgID'];
                $response=DB::GetOrgAnnualPlanDetail($OrgID);
                if($response){
                    echo json_encode(['status'=> 'success','message'=> 'Data fetched successfully','data'=> $response]);
                }else{
                    echo json_encode(['status'=> 'error', 'message'=> 'No data found' ,"data" => $response]);
                } 
                break;


    
        }
        

}else{
    echo json_encode(['status' => 'error', 'message' => 'Only POST requests are allowed']);
}
