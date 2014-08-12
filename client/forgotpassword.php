<?php
	require_once("include/general_includes.php");
	
	$objClientAdmin = new client();
	
	$objUser = new user();
	$userId = 0;
	if(isset($_REQUEST['uId']))
	{
		$userId = $objUser->fieldValue("user_id",""," AND user_username='".$_REQUEST['uId']."' ");
		$client_id = $objClientAdmin->fieldValue("client_id",$userId);
		$objClientAdmin->client_id = $client_id;
	}
	
	include "forgotpassword_db.php";
	
	$cancel_button = "javascript: window.location.href='index.php';";
	
	if(!empty($_SESSION["err"]))
	{
		include("forgotpassword_field.php");

		// Set red border for error fields
		$err_fields = split("\|", $_SESSION["err_fields"]);
		unset($_SESSION["err_fields"]);
		for ($i=0;$i<count($err_fields);$i++)
		{
			$err_fields[$i] = "class_".$err_fields[$i];
			$$err_fields[$i] = "input-red-border";
		}
	}
	$mode = 'add';
	
	$extraJs = array("forgotpassword.js");
	include "include/header_login.php";
	include "include/top_index.php";?>
 
<!--Start content -->
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
                  <div class="fleft">Forgot Password ?</div>
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
              <?php include SERVER_CLIENT_ROOT."forgotpassword_form.php";?>
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
<?php include SERVER_CLIENT_ROOT."include/footer.php"; ?>