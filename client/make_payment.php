<?php	
	require_once 'include/general_includes.php';
	$objEncDec = new encdec();
	$objState = new state();
	$objClientAdmin = new client();
	
	$objUser = new user();
	$userId = 0;
	if(isset($_REQUEST['uds']))
	{
		$user_id = $objEncDec->decrypt($_GET['uds']);
		$userId = $objUser->fieldValue("user_id",""," AND user_username='".$user_id."' ");
		$client_id = $objClientAdmin->fieldValue("client_id",$userId);
		$objClientAdmin->client_id = $client_id;
	}
	
	include "make_payment_db.php";
	
	$cancel_button = "javascript: window.location.href='index.php';";
	
	if(!empty($_SESSION["err"]))
	{
		include("make_payment_field.php");
	} else {
		$objClientAdmin->creditCardType = 'Visa';
		$objClientAdmin->expDateMonth = date('m');
		$objClientAdmin->expDateYear = date('Y');
		$objClientAdmin->state = 'CA';
	}
	$mode = 'add';
	 
	include SERVER_CLIENT_ROOT."include/header.php";
	include SERVER_CLIENT_ROOT."include/top_index.php";
?>
<div class="content_mn">
  <div class="content_mn2">
    <div class="cont_mid">
      <div class="cont_lt">
        <div class="cont_rt_fp">
          <div class="user_tab_mn">
          <?php $msg->displayMsg(); ?>
            <div class="blue_title">
              <div class="blue_title_lt">
                <div class="blue_title_rt">
                  <div class="fleft">Make Payment</div>
                  <div class="fright"></div>
                </div>
              </div>
            </div>
            <div class="content-box">
			<div class="content-left-shadow">
				<div class="content-right-shadow">
					<div class="content-box-lt">
						<div class="content-box-rt">
							<div class="blue_title_cont">
							  <?php include SERVER_CLIENT_ROOT."make_payment_form.php";?>
							</div>
						</div>
					</div>
				</div>
			</div>
		  </div>
		</div>
	  </div>
	</div>
  </div>
</div>
</div>
<?php include SERVER_CLIENT_ROOT."include/footer.php";?>
</body>
</html>