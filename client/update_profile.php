<?php
	require_once("include/general_includes.php");
	
	$objClientAdmin = new client();
	
	include "update_profile_db.php";
	
	if(!empty($_SESSION["err"]))
	{
		include("update_profile_field.php");

		// Set red border for error fields
		$err_fields = explode("\|", $_SESSION["err_fields"]);
		unset($_SESSION["err_fields"]);
		for ($i=0;$i<count($err_fields);$i++)
		{
			$err_fields[$i] = "class_".$err_fields[$i];
			$$err_fields[$i] = "input-red-border";
		}
	}
	$mode = 'edit';
	$record_condition = "";	
	$user_id = $cmn->getSession(ADMIN_USER_ID);
	
	if ($mode==EDIT && !($cmn->isRecordExists("user", "user_id", $user_id, $record_condition)))
		$msg->sendMsg("update_profile.php","",46);
	
	$objClientAdmin->setAllValues($user_id);
	
	$extraJs = array("update_profile.js");
	include SERVER_CLIENT_ROOT."include/header.php";
	include SERVER_CLIENT_ROOT."include/top.php";
	
?>
<div class="content_mn">
  <div class="content_mn2">
    <div class="cont_mid">
      <?php $msg->displayMsg(); ?>
      <div class="cont_lt">
        <div class="cont_rt">
          <div class="user_tab_mn">
            <div class="blue_title">
              <div class="blue_title_lt">
                <div class="blue_title_rt">
                  <div class="fleft">Update Profile</div>
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
              <?php include SERVER_CLIENT_ROOT."update_profile_form.php";?>
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
