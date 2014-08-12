<?php
	require_once("include/general_includes.php");
	$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);
	$objFinanceMakePayment = new finance_make_payment();
	
	$client_payment_id = 0;
	
	if (isset($_REQUEST['hdnclient_payment_id']) && trim($_REQUEST['hdnclient_payment_id'])!="")
		$client_payment_id = $_REQUEST['hdnclient_payment_id'];
	
	//set mode...
	$mode = ADD;
	if ($client_payment_id > 0)
		$mode = EDIT;
	
	//CHECK FOR RECORED EXISTS
	//$record_condition = " AND client_payment_id='".$objFinanceMakePayment->client_payment_id."' ";	
	$record_condition = "";	
	
	if ($mode==EDIT && !($cmn->isRecordExists("client_payment", "client_payment_id", $client_payment_id, $record_condition)))
	{	
		$msg->sendMsg("finance_make_payment.php","",46);
	}
	//END CHECK

	$aPayments = $objFinanceMakePayment->fetchPaymentTypes();
	$sPayments = '';
	
	for($k=0;$k<count($aPayments);$k++)
	{	
		$sPayments.= $aPayments[$k]['payment_type'].",";
	}

	include SERVER_ADMIN_ROOT."finance_make_payment_db.php";
	
	$cancel_button = "javascript: window.location.href='finance_all_payments.php';";

	//code to assign property to object...
	
	if(!empty($_SESSION["err"]))
	{
		include_once "finance_make_payment_field.php";

		// Set red border for error fields
		$err_fields = split("\|", $_SESSION["err_fields"]);
		unset($_SESSION["err_fields"]);
		for ($i=0;$i<count($err_fields);$i++)
		{
			$err_fields[$i] = "class_".$err_fields[$i];
			$$err_fields[$i] = "input-red-border";
		}
	}
	
	if ($mode == EDIT)
	{	
		$objFinanceMakePayment->setAllValues($client_payment_id);
	}
	$extraJs = array("finance_make_payment.js");
	include SERVER_ADMIN_ROOT."include/header.php";
	include SERVER_ADMIN_ROOT."include/top.php";
	$condition = " AND ur.user_type_id = '".USER_TYPE_SUPER_CLIENT_ADMIN."' ";
	$aClients = $objFinanceMakePayment->fetchClients("","",$condition);
	
	if(isset($client_payment_id) && $client_payment_id > 0)
	{		
		$disbalevar = "disabled";
	}
?>
<div class="content_mn">
    <div class="cont_mid">
        <div class="cont_rt">
          <div class="user_tab_mn">
          <?php $msg->displayMsg(); ?>
            <div class="blue_title">
               <div class="blue_title_rt">
                  <div class="fleft"><?php print "Make Payment"; ?></div>
                  <div class="fright">&nbsp;</div>
              </div>
            </div>
            <div class="blue_title_cont">
             <?php include SERVER_ADMIN_ROOT."finance_make_payment_form.php";?>
            </div>
          </div>
        </div>
     
    </div>
 
</div>
<?php include SERVER_ADMIN_ROOT."include/footer.php"; ?>