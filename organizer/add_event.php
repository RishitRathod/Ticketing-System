<?php

require_once '../config.php';
require_once '../db_connection.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    // Data for insertion into Table1
    $eventData = array(
        'column1' => 'value1',
        'column2' => 'value2',
        // Add more columns and values as needed
    );
    
    // Data for insertion into Table2
    $dataTable2 = array(
        'columnA' => 'valueA',
        'columnB' => 'valueB',  
        // Add more columns and values as needed
    );
    
    // Data for insertion into Table3
    $dataTable3 = array(
        'columnX' => 'valueX',
        'columnY' => 'valueY',
        // Add more columns and values as needed
    );
    
    // Insert into Table1
    $resultTable1 = DB::insert(DB_NAME, 'Table1', $dataTable1);
    echo "Insert into Table1 result: $resultTable1 <br>";
    
    // Insert into Table2
    $resultTable2 = DB::insert(DB_NAME, 'Table2', $dataTable2);
    echo "Insert into Table2 result: $resultTable2 <br>";
    
    // Insert into Table3
    $resultTable3 = DB::insert(DB_NAME, 'Table3', $dataTable3);
    echo "Insert into Table3 result: $resultTable3 <br>";    
}