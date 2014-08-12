<?php
	require_once("include/general_includes.php");
	
	$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);

	$client_payment_id=0;
	
	if (isset($_REQUEST['client_payment_id']) && trim($_REQUEST['client_payment_id'])!="")
		$client_payment_id = $_REQUEST['client_payment_id'];
	
	//CHECK FOR RECORED EXISTS
	$record_condition = "";	
	if ( !($cmn->isRecordExists("client_payment", "client_payment_id ", $client_payment_id, $record_condition)))
		$msg->sendMsg("finance_pending_payments.php","",46);

	//END CHECK

	/*global $aContestCancelLookupTables;
	
	if($cmn->validateDeletedIds($client_payment_id, $aContestCancelLookupTables)==false)
		$msg->sendMsg("finance_pending_payments.php","Pending Payments",47);
		*/
	$objFinancePendingPayment = new finance_pending_payment();
	
	$mode=CANCEL;
	
	include "finance_pending_payment_db.php";	

?>

<?php
	$extraJs = array("finance_make_payment.js");
	include SERVER_ADMIN_ROOT."include/header.php";
	include SERVER_ADMIN_ROOT."include/top.php";
?>

<div class="content_mn">
    <div class="cont_mid">
      <div class="cont_lt">
        <div class="cont_rt">
          <div class="user_tab_mn">
          <?php $msg->displayMsg(); ?>
            <div class="blue_title">
              <div class="blue_title_lt">
                <div class="blue_title_rt">
                  <div class="fleft"><?php print "Cancel Payment"; ?></div>
                  <div class="fright"> 
                   <?php 
                   		print $cmn->getAdminMenuLink("finance_pending_payments.php","finance_pending_payments","Back","","back.png",false); 
                   ?>
                   </div>
                </div>
              </div>
            </div>
            <div class="blue_title_cont_delete">
            <div class="access_submit">
             <?php if(isset($_POST["err"])){ 
        	 ($_POST["err"]!="") ? $msg->displayMsg() : "";
      } ?>
          <form id="frm" name="frm" method="post" onsubmit="javascript: return validateCancel();" >
        	Are you sure you want to cancel payment for <strong><?php print $cmn->readValueDetail($aClientID["contest_title"]);?></strong> ?<br/><br/>
            <span class="txtbo">Cancel Payment Remark :&nbsp;<?php print COMPULSORY_FIELD; ?></span><br />
            <textarea  class="input_desc_more" name="txtpayment_cancel_remark" id="txtpayment_cancel_remark"><?php echo $cmn->readValueDetail($objFinanceMakePayment->payment_description); ?></textarea><br/><br/>
          <input type="hidden" name="mode" id="mode" value="delete" />
          <input type="hidden" name="client_payment_id" id="client_payment_id" value="<?php print $client_payment_id;?>" />
          <input type="submit" id="btncancel" title="Cancel" name="btncancel" value="Cancel Payment" class="btn-red" />
          <input type="button" title="Back" id="btncancel" name="btncancel" value="Cancel" class="btn" onclick="javascript: window.location.href='finance_pending_payments.php';" />
        	</form>
        	</div>
            </div>
          </div>
        </div>
      </div>
    </div>
 
</div>
<?php include SERVER_ADMIN_ROOT."include/footer.php"; ?>