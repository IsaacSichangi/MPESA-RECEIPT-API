<h1>MPESA RECEIPT API PHP</h1>

This is a library to generate a pdf receipt for an mpesa transaction which can be sent as a link via sms or email to the customer.It can be integrated with the official safaricom/mpesa api.

<h2>REQUIREMENTS</h2>

* PHP >=5.4.0

<h3>INSTALLATION</h3>

composer require isaacsichangi/mpesareceiptapi:1.0.0

<h3> HOW TO USE </h3>

<h5>require_once ('vendor/autoload.php');</h5>

//create mpesa receipt object
<h5>$mpesa = new MpesaReceiptGenerator("Bob Collymore", 3000, "0724XXXXXX", "MPJ54C33P", "Company XYZ", "https://www.companyxyz.com/");</h5>

<h5>try {<h5>

<p>  //generate receipt and return path of pdf receipt which can be sent as a link via sms or email message</p>
 <h5> $path = $mpesa->generateReceipt();</h5>


<p>//view path</p>
<h5> echo $path;</h5>

<p>//handle exception</p>
<h5>} catch (\Picqer\Barcode\Exceptions\BarcodeException $e) {</h5>


<h5>} </h5>

<h3>CREDITS</h3>

Isaac Sichangi - isaacsichangi@gmail.com

<h3>LIVE DEMO</h3>

Send 10ksh to MPESA till number 564305 to see a sample receipt
