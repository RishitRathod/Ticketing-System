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
  
// "link1" => "http://". getHostByName(getHostName())."/Ticketing-System/user/get_details.php?id=1",
// "ticketsalesID" => 1,
// "ticketUsageID" => 1,
// 'link2' => "http://". getHostByName(getHostName())."/Ticketing-System/user/get_details.php?id=2",
// //echo getHostByName(getHostName());
// ];
// //  $quad = implode(" ", $dataTable1);
// // // print_r($quad) . "</br>";
// // $quad= str_replace(' ', '', $quad);
// // print_r($quad)."</br>";
// $quad = json_encode($dataTable1);
// print_r($quad);

// QRCodeGenerator::GenerateQRCode($quad, 'test.svg');
?>

