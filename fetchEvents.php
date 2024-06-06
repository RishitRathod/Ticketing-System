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
                $EventID = $data['EventID'];
                $OrgID = $data['OrgID'];
                $response=DB::FetchEventDetailsByOrgID($EventID,$OrgID);
                
                $response['success']=true;
                
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

            default:
                echo json_encode(['success'=>false, 'message'=>'Invalid action']);
        
        }
}