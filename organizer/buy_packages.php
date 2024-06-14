<?php
require_once '../db_connection.php';
require_once '../config.php';
header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] === 'POST'){
   
    $input = json_decode(file_get_contents('php://input'), true);
    $orgid = $input['orgid'];
    $selectedPackages = $input['selectedPackages'];
    $totalDaysTickets = $input['totalDaysTickets'];
    $packageType = $input['packageType'];

    //remove orgid from the array
    unset($input['orgid']);
    unset($input['selectedPackages']);
    unset($input['totalDaysTickets']);
    unset($input['packageType']);
    //    print_r($selectedPackages);

    //using the PackageType if separate the packages by type TimeBased and TicketBased
    $TimeBased = [];
    $TicketBased = [];
    $TotalTickets=0;
    $TotalDays=0; 


    for ($i = 0; $i < count($selectedPackages); $i++) {
        if ($packageType[$i] == 'TimeBased') {
            $TimeBased[] = $selectedPackages[$i];
            $TotalDays+=$totalDaysTickets[$i];
        } else {
            $TicketBased[] = $selectedPackages[$i];
            $TotalTickets+=$totalDaysTickets[$i];
        }
    }
    
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

   // Fetch current Amount_of_Days and Amount_of_Tickets from org_plans for the given OrgID
   $orgPlan = DB::selectBy(DB_NAME, 'org_plans', ['OrgID' => $orgid]);
   if (!$orgPlan) {
       $response['success'] = false;
       $response['message'] = "Failed to fetch organization plans";
       $response['data']=$orgPlan;
       echo json_encode($response);
       exit();
   }

   // Update Amount_of_Days and Amount_of_Tickets in org_plans
   $updatedDays = $orgPlan[0]['Amount_of_Days'] + $TotalDays;
   $updatedTickets = $orgPlan[0]['Amount_of_Tickets'] + $TotalTickets;
   $updateData = [
       'Amount_of_Days' => $updatedDays,
       'Amount_of_Tickets' => $updatedTickets
   ];
   
   $updateResult = DB::update(DB_NAME, 'org_plans', $updateData, $orgid,'OrgID');
   if (!$updateResult) {
       $response['success'] = false;
       $response['message'] = "Failed to update organization plans";
       echo json_encode($response);
       exit();
   }

   $response['success'] = true;
   $response['message'] = "Packages bought successfully and organization plans updated";
   echo json_encode($response);
   exit();
}
?>