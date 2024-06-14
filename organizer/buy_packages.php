<?php
require_once '../db_connection.php';
require_once '../config.php';
header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] === 'POST'){
   
    $input = json_decode(file_get_contents('php://input'), true);
    $orgid = $input['orgid'];
    $selectedPackages = $input['selectedPackages'];
    $totalDaysTickets = $input['totalDaysTickets'];
    //remove orgid from the array
    unset($input['orgid']);
    unset($input['selectedPackages']);
    unset($input['totalDaysTickets']);
//    print_r($selectedPackages);

    
    for ($i = 0; $i < count($selectedPackages); $i++) {
        $dataTable1 = [
            'OrgID' => $orgid,
            'PackageID' => $selectedPackages[$i],
            'No_of_Days_Or_Tickets' => $totalDaysTickets[$i],
            'BuyDate' => date('Y-m-d H:i:s')
        ];    
        

        $insertResult = DB::insert(DB_NAME, 'org_package', $dataTable1);
        if (!$insertResult) {
            $response['success'] = false;
            $response['message'] = "Failed to buy packages";
            echo json_encode($response);
            exit();
        }

    }
    $response['success'] = true;
    $response['message'] = "Packages bought successfully";

    echo json_encode($response);
    exit();
    
}