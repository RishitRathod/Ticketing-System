<?php

use chillerlan\QRCode\QRCode;
use \chillerlan\QRCode\Common\EccLevel;

require_once 'vendor/autoload.php';
class QRCodeGenerator
{
    public static function GenerateQRCode($data, $outputFile)
    {
        $data = str_replace(' ', '', $data);
        $options = new chillerlan\QRCode\QROptions([
            'eccLevel'   => EccLevel::H,
            'scale'      => 5,    

        ]);


        $qrcode = (new QRCode( $options))->render($data, $outputFile);
        if ($qrcode !== false) {
           // printf('<img src="%s" style="width:900px ;hight:900px;"  alt="QR Code" />', $outputFile);
            return true;
        } else {
           // echo 'Failed to generate QR code.';
            return false;
        }
    }
}

// $dataTable1 = [
//     'OrgID' => 10,
//     'EventName' => "Name",
//     'Description' => "desc",
//     'StartDate' => "08/08/2021",
//     'EndDate' => "10/08/2021",
//     'Capacity' => 50,
//     'EventType' => "beauty",
//     'VenueAddress' => "Address 1 Address 2",
//     'Country'  => "India",
//     'State' => "gujarat",
//     'City' => "Rajot"
// //echo getHostByName(getHostName());


// ];
// $quad = implode(" ", $dataTable1);
// print_r($quad) . "</br>";
// $quad= str_replace(' ', '', $quad);
// print_r($quad)."</br>";
// $quad = json_encode($quad);
// print_r($quad);

// QRCodeGenerator::GenerateQRCode($quad, 'test.svg');
// ?>

