    <?php
    /**
     * MPESA RECEIPT API
     * @author Isaac Sichangi - isaacsichangi@gmail.com
     * @version 1.0.0
     * @copyright (c) 2018 Isaac Sichangi
     * Date: 8/7/2018
     * Time: 10:37 PM
     */


    // This file is part of MPESA RECEIPT API software library.
    //
    // MPESA RECEIPT API is free software: you can redistribute it and/or modify it
    // under the terms of the GNU Lesser General Public License as
    // published by the Free Software Foundation, either version 3 of the
    // License, or (at your option) any later version.
    //
    // MPESA RECEIPT API is distributed in the hope that it will be useful, but
    // WITHOUT ANY WARRANTY; without even the implied warranty of
    // MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
    // See the GNU Lesser General Public License for more details.
    //
    // You should have received a copy of the License
    // along with MPESA RECEIPT API. If not, see
    //
    //
    // See LICENSE.TXT file for more information.



    require '../vendor/autoload.php';

    class MpesaReceiptGenerator
    {

     protected $amount;
     protected $name;
     protected $transaction_number;
     protected $phonenumber;
     protected $merchant;
     protected $barcode;
     protected $pdf;
     protected $host;
     protected $font;

        /**
         * MpesaReceiptGenerator constructor.
         * @param $name
         * @param $amount
         * @param $phonenumber
         * @param $transaction_number
         * @param $host
         */
        function __construct($name, $amount, $phonenumber, $transaction_number, $merchant, $host )
     {
         $this->name = $name;
         $this->amount = $amount;
         $this->phonenumber = $phonenumber;
         $this->transaction_number = $transaction_number;
         $this->merchant = $merchant;
         $this->host = $host;
         $this->font = "Helvetica";
         $this->barcode = new Picqer\Barcode\BarcodeGeneratorJPG();
         $this->pdf = new FPDF();

     }


        /**
         * generate pdf receipt of transaction and return the link to the generated receipt
         * @return string
         * @throws \Picqer\Barcode\Exceptions\BarcodeException
         */
        function generateReceipt() {

            $pdf = new FPDF();

            $pdf->AddPage();

            //mpesa header image

            $pdf->Image(__DIR__.'\images\mpesa_header.jpg', 0, 0, 210);

            //amount

            $pdf->SetXY(0, 130);

            $pdf->SetFont($this->font, 'B', 64);

            $pdf->Cell(0, 0,'Ksh'.' '.$this->amount, 0, 1, 'C');

            //Date

            $pdf->SetXY(0, 150);

            $pdf->SetFont($this->font, '', 28);

            $pdf->SetTextColor(108, 157, 64);

            $pdf->Cell(0, 0, date('M j, Y g:i A'), 0, 1, 'C');

            $pdf->Line(0, 160, 210, 160 );

            //Name
         $pdf->SetFont($this->font, '', 24);

          $pdf->SetTextColor(0, 0, 0);

          $pdf->Text(25, 190, "NAME");
         $pdf->SetFont($this->font, '', 20);

         $pdf->Text(25, 200, $this->name);

         //phonenumber

         $pdf->SetFont($this->font, '', 24);

         $pdf->SetTextColor(0, 0, 0);

         $pdf->Text(25, 230, "PHONENUMBER");

         $pdf->SetFont($this->font, '', 20);

         $pdf->Text(25, 240, $this->phonenumber);

         //recipient

         $pdf->SetFont($this->font, '', 24);

         $pdf->Text(125, 190, "RECIPIENT");

         $pdf->SetFont($this->font, '', 20);

         $pdf->Text(125, 200, $this->merchant);

         //transactionnumber

         $pdf->SetFont($this->font, '', 24);



         $pdf->Text(125, 230, "TRANSACTION#");

         $pdf->SetFont($this->font, '', 20);

         $pdf->Text(125, 240, $this->transaction_number);

         //Put barcode

         if(!is_dir('barcode/')){

             mkdir('barcode/');
         }

         $got_barcode = base64_encode($this->barcode->getBarcode($this->transaction_number, "C128", 2, 100));

         fopen("barcode/".$this->transaction_number.".jpg", 'w');

         $save = file_put_contents("barcode/".$this->transaction_number.".jpg",base64_decode($got_barcode));

         $pdf->Image("barcode/".$this->transaction_number.".jpg", 70, 260);

         if(!is_dir('receipts/')){

             mkdir('receipts/');
         }



         if(file_exists('receipts/'.$this->transaction_number.'.pdf')){

             if(!is_dir('duplicate/')){

                 mkdir('duplicate/');
             }
             //move to duplicate folder

             rename('receipts/'.$this->transaction_number.'.pdf', 'duplicate/'.$this->transaction_number.'.pdf');


         }

         $pdf->Output('F', 'receipts/'.$this->transaction_number.'.pdf');


         $path = $this->host.'receipts/'.$this->transaction_number.'.pdf';

         return $path;

     }


    }





    ?>