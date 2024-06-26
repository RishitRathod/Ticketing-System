<?php 
require_once 'db_connection.php';
header('Content-Type: application/json');
if($_SERVER['REQUEST_METHOD']=== 'POST'){
    $data = json_decode(file_get_contents('php://input'), true);
    $action=$data['action'];
    
    switch($action){
        case 'fetchPaginatedEventData':
            try { 
                $limit = $data['limit'];
                $offset = $data['offset'];
                $response=DB::fetchPaginatedEventData($limit, $offset);
                //add sucess message to response
                
                $response['success']=true;
                $response['status']='success';
                echo json_encode($response);
            }
            catch(Exception $e){
            echo json_encode(['success'=>false, 'message'=>$e->getMessage(),'data'=>$response]);
            }
            break;

        case 'FetchEventDetailsByOrgID':
            try { 
                $OrgID = $data['OrgID'];
                $data=DB::FetchEventDetailsByOrgID($OrgID);
                
                $response['success']=true;
                $response['status']= 'success';
                $response['data']=$data;
                echo json_encode($response);
            }
            catch(Exception $e){
                echo json_encode(['success'=>false, 'message'=>$e->getMessage(),'data'=>$response]);
            }
            break;

        case 'FetchEventDetails':
            try { 
                $EventID = $data['EventID'];
                $response;
                $data=DB::FetchEventDetails($EventID);
                $response['data']=$data;
                $response['success']=true;
                $response['status']='success';

                echo json_encode($response);
            }
            catch(Exception $e){
                echo json_encode(['success'=>false, 'message'=>$e->getMessage(),'data'=>$response]);
            }
            break;
        case 'FetchAllEventsByOrgID':
           try { 
                $OrgID = $data['OrgID'];
                $response=DB::FetchAllEventsByOrgID($OrgID);
                
                $response['success']=true;
                echo json_encode($response);
            }
            catch(Exception $e){
                echo json_encode(['success'=>false, 'message'=>$e->getMessage(),'data'=>$response]);
            }
            break;
        case 'GetEventsByCatagory':
            try { 
                $Catagory = $data['Catagory'];
                $limit = $data['limit'];
                $offset = $data['offset'];
                $response=DB::GetEventsByCatagory($Catagory,$limit,$offset);
                $response['success']=true;
                echo json_encode($response);
            }
            catch(Exception $e){
                echo json_encode(['success'=>false, 'message'=>$e->getMessage(),'data'=>$response]);
            }
            break;
        case 'fetchPaginatedEventDataByOrgID':
            try{
                $limit = $data['limit'];
                $offset = $data['offset'];
                $OrgID = $data['OrgID'];
                $response=DB::fetchPaginatedEventDataByOrgID($limit, $offset, $OrgID);
                $response['success']=true;
                echo json_encode($response);
            }
            catch(Exception $e){
                echo json_encode(['success'=>false, 'message'=>$e->getMessage(),'data'=>$response]);
            }
            break;

            case "GetRegisterUsersForEvent":
                try{
                    $EventID = $data['EventID'];
                    $response['data'] = DB::GetRegisterUsersForEvent($EventID);

                    $response['status'] = true;
                    $response['message'] = 'Data fetched successfully';
                    echo json_encode($response);
                }
                catch(Exception $e){
                    echo json_encode(['status'=>false, 'message'=>$e->getMessage(),'data'=>$response]);
                }
                break;

            case 'FetchBookmarkedEvent':
                try{
                    $UserID = $data['UserID'];
                    $response['data'] = DB::FetchBookmarkedEvent($UserID);

                    $response['status'] = true;
                    $response['message'] = 'Data fetched successfully';
                    echo json_encode($response);
                }
                catch(Exception $e){
                    echo json_encode(['status'=>false, 'message'=>$e->getMessage(),'data'=>$response]);
                }
                break;

            default:
                echo json_encode(['success'=>false, 'message'=>'Invalid action']);
        
        case 'DeleteEventPoster':
            try{
                $EventID = $data['EventID'];
                $pathwithName = $data['path'];
                $response = DB::DeleteEventPoster($EventID,$pathwithName);
                $response['success'] = true;
                $response['message'] = 'Event poster deleted successfully';
                echo json_encode($response);
            }
            catch(Exception $e){
                echo json_encode(['success'=>false, 'message'=>$e->getMessage(),'data'=>$response]);

            }

        case 'GetTicketSumByEventID':
            try{
                $EventID = $data['EventID'];
                $response = DB::GetTicketSumByEventID($EventID);
                $response['success'] = true;
                $response['message'] = 'Data fetched successfully';
                echo json_encode($response);
            }
            catch(Exception $e){
                echo json_encode(['success'=>false, 'message'=>$e->getMessage(),'data'=>$response]);
            }

        case 'FetchEventDetailsByEventID':
            try{
                $EventID = $data['EventID'];
                $response = DB::FetchEventDetailsByEventID($EventID);
                $response['status']='success';
                $response['success'] = true;
                $response['message'] = 'Data fetched successfully';
                echo json_encode($response);
            }
            catch(Exception $e){
                echo json_encode(['success'=>false, 'message'=>$e->getMessage(),'data'=>$response]);
            }

        case 'FetchEventsWithOrgName':
            try{
                $response = DB::FetchEventsWithOrgName();
                $response['status']='success';
                $response['success'] = true;
                $response['message'] = 'Data fetched successfully';
                echo json_encode($response);
            }
            catch(Exception $e){
                echo json_encode(['success'=>false, 'message'=>$e->getMessage(),'data'=>$response]);
            }

    }
}