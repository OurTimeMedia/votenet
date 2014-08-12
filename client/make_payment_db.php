<?php
if (isset($_REQUEST['btnsave'])) {
  $objvalidation = new validation();

  $objvalidation->addValidation("firstName", "First Name", "req");
  $objvalidation->addValidation("lastName", "Last Name", "req");
  $objvalidation->addValidation("creditCardType", "Card type", "sel");
  $objvalidation->addValidation("creditCardNumber", "Card Number", "req");
  $objvalidation->addValidation("expDateMonth", "Expire Month", "sel");
  $objvalidation->addValidation("expDateYear", "Expire Year", "sel");
  $objvalidation->addValidation("cvv2Number", "Card Verification Number", "req");
  $objvalidation->addValidation("address1", "Address 1", "req");
  $objvalidation->addValidation("city", "City", "req");
  $objvalidation->addValidation("state", "State", "sel");
  $objvalidation->addValidation("zip", "ZIP Code", "req");
  $objvalidation->addValidation("amount", "Amount", "req");

  if ($objvalidation->validate()) {
    //Code to assign value of control to all property of object.
    include("make_payment_field.php");

    //Code to add record.
    if (trim($_POST['hdnmode']) == 'add') {
      include ("CallerService.php");

      session_start();


      /**
       * Get required parameters from the web form for the request
       */
      $paymentType = urlencode('Sale');
      $firstName = urlencode($_POST['firstName']);
      $lastName = urlencode($_POST['lastName']);
      $creditCardType = urlencode($_POST['creditCardType']);
      $creditCardNumber = urlencode($_POST['creditCardNumber']);
      $expDateMonth = urlencode($_POST['expDateMonth']);

// Month must be padded with leading zero
      $padDateMonth = str_pad($expDateMonth, 2, '0', STR_PAD_LEFT);

      $expDateYear = urlencode($_POST['expDateYear']);
      $cvv2Number = urlencode($_POST['cvv2Number']);
      $address1 = urlencode($_POST['address1']);
      $address2 = urlencode($_POST['address2']);
      $city = urlencode($_POST['city']);
      $state = urlencode($_POST['state']);
      $zip = urlencode($_POST['zip']);
      $amount = urlencode($_POST['amount']);
//$currencyCode=urlencode($_POST['currency']);
      $currencyCode = "USD";
      //$paymentType = urlencode($_POST['paymentType']);

      /* Construct the request string that will be sent to PayPal.
        The variable $nvpstr contains all the variables and is a
        name value pair string with & as a delimiter */
      $nvpstr = "&PAYMENTACTION=$paymentType&AMT=$amount&CREDITCARDTYPE=$creditCardType&ACCT=$creditCardNumber&EXPDATE=" . $padDateMonth . $expDateYear . "&CVV2=$cvv2Number&FIRSTNAME=$firstName&LASTNAME=$lastName&STREET=$address1&CITY=$city&STATE=$state" .
              "&ZIP=$zip&COUNTRYCODE=US&CURRENCYCODE=$currencyCode";



      /* Make the API call to PayPal, using API signature.
        The API response is stored in an associative array called $resArray */
      $resArray = hash_call("doDirectPayment", $nvpstr);

      /* Display the API response back to the browser.
        If the response from PayPal was a success, display the response parameters'
        If the response was an error, display the errors received using APIError.php.
       */
      $ack = strtoupper($resArray["ACK"]);

      if ($ack != "SUCCESS") {
        $_SESSION['reshash'] = $resArray;
        $location = "APIError.php";
        header("Location: $location");
		die;
      }
	  
	  
	  
      ?>

      <html>
        <head>
          <title>PayPal PHP SDK - DoDirectPayment API</title>
          <link href="sdk.css" rel="stylesheet" type="text/css" />
        </head>
        <body>
          <br>
        <center>
          <font size=2 color=black face=Verdana><b>Do Direct Payment</b></font>
          <br><br>

          <b>Thank you for your payment!</b><br><br>

          <table width=400>

            <?php
            require_once 'ShowAllResponse.php';
            ?>
          </table>
        </center>
        <a class="home" id="CallsLink" href="index.html">Home</a>
      </body>


      <?php
      die;
    }
  }
}
?>