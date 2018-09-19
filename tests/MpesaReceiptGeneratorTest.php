<?php
/**
 * MPESA RECEIPT GENERATE TEST CLASS
 * User: Isaac Sichangi
 * Date: 8/17/2018
 * Time: 5:40 PM
 */

date_default_timezone_set("Africa/Nairobi");

require_once ('../vendor/autoload.php');

//create mpesa receipt object
$mpesa = new MpesaReceiptGenerator("Bob Collymore", 3000, "0724567876", "MPJ54C33P", "Uchumi Supermarket", "http://localhost/MpesaReceiptApi/tests/");

try {

    //generate receipt and return path of pdf receipt which can be sent as a link via sms or email message
    $path = $mpesa->generateReceipt();


//view path
   echo $path;

} catch (\Picqer\Barcode\Exceptions\BarcodeException $e) {


}

?>

