<?php

use chillerlan\QRCode\Output\QRFpdf;
use chillerlan\QRCode\Output\QRGdImage;
use chillerlan\QRCode\QRCode;
use \chillerlan\QRCode\Common\EccLevel;

require_once '../QR-Code-Generator/vendor/autoload.php';
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
          //  printf('<img src="%s" style="width:900px ;hight:900px;"  alt="QR Code" />', $outputFile);
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
//     'VenueAddress' => "Address 1 Address 2 Address 3 Address 4 Address 5 Address 6 Address 7 Address 8 Address 9 Address 10 Address 11 Address 12 Address 13 Address 14 Address 15 Address 16 Address 17 Address 18 Address 19 Address 20 Address 21 Address 22 Address 23 Address 24 Address 25 Address 26 Address 27 Address 28 Address 29 Address 30 Address 31 Address 32 Address 33 Address 34 Address 35 Address 36 Address 37 Address 38 Address 39 Address 40 Address 41 Address 42 Address 43 Address 44 Address 45 Address 46 Address 47 Address 48 Address 49 Address 50 Address 51 Address 52 Address 53 Address 54 Address 55 Address 56 Address 57 Address 58 Address 59 Address 60 Address 61 Address 62 Address 63 Address 64 Address 65 Address 66 Address 67 Address 68 Address 69 Address 70 Address 71 Address 72 Address 73 Address 74 Address 75 Address 76 Address 77 Address 78 Address 79 Address 80 Address 81 Address 82 Address 83 Address 84 Address 85 Address 86 Address 87 Address 88 Address 89 Address 90 Address 91 Address 92 Address 93 Address 94 Address 95 Address 96 Address 97 Address 98 Address 99 Address 100 Address 101 Address 102 Address 103 Address 104 Address 105 Address 106 Address 107 Address 108 Address 109 Address 110 Address 111 Address 112 Address 113 Address 114 Address 115 Address 116 Address 117 Address 118 Address 119 Address 120 Address 121 Address 122 Address 123 Address 124 Address 125 Address 126 Address 127 Address 128 Address 129 Address 130 Address 131 Address 132 Address 133 Address 134 Address 135 Address 136 Address 137 Address 138 Address 139 Address 140 Address 141 Address 142 Address 143 Address 144 Address 145 Address 146 Address 147 Address 148 Address 149 Address 150 Address 151 Address 152 Address 153 Address 154 Address 155 Address 156 Address 157 Address 158 Address 159 Address 160 Address 161 Address 162 Address 163 Address 164 Address 165 Address 166 Address 167 Address",
//     'Country'  => "India",
//     'State' => "gujarat",
//     'City' => "Rajot"
// echo getHostByName(getHostName());


// ];
// $quad = implode(" ", $dataTable1);
// print_r($quad) . "</br>";
// $quad= str_replace(' ', '', $quad);
// print_r($quad)."</br>";
// $quad = json_encode($quad);
// print_r($quad);

// QRCodeGenerator::GenerateQRCode($quad, 'test.svg');
?>

