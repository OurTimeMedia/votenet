<?php
	require_once("include/general_includes.php");
	
	$cmn->isAuthorized("index.php", ADMIN_USER_ID);
	$objEncDec = new encdec();	

	$user_id = 0;
		
	if (isset($_REQUEST['user_id']) && trim($_REQUEST['user_id'])!="")
	{
		$user_id = $objEncDec->decrypt($_REQUEST['user_id']);
		$entityID = $objEncDec->decrypt($_REQUEST['user_id']);
	}
		
	
	//CHECK FOR RECORED EXISTS
	$record_condition = "";	
	
	if (!($cmn->isRecordExists("user", "user_id", $user_id, $record_condition)))
		$msg->sendMsg("client_admin_list.php","",46);
		
	
	$objClientAdmin = new client();	
	$objMenu = new menu();

	include "client_admin_db.php";
	
	$cancel_button = "javascript: window.location.href='client_admin_detail.php?user_id=".$objEncDec->encrypt($user_id)."';";
	
	$objClientAdmin->setAllValues($user_id);
	
	$extraJs = array('prototype.js');
	
	$cmn->defaultMenu = 0;
	include SERVER_CLIENT_ROOT."include/header_menu.php"; 
	include SERVER_CLIENT_ROOT."include/top.php"; 
?>
<div class="content_mn">
  <div class="content_mn2">
    <div class="cont_mid">
      <div class="cont_lt">
        <div class="cont_rt">
         <div class="user_tab_mn">
           <?php $msg->displayMsg(); ?> 
            <div class="blue_title">
              <div class="blue_title_lt">
                <div class="blue_title_rt">
                  <div class="fleft">Contest Admin Access Rights for [ <?php print $objClientAdmin->user_firstname." ".$objClientAdmin->user_lastname;?> ]</div>
                  <div class="fright"> <?php print $cmn->getClientMenuLink("client_admin_detail.php","client_admin_detail","Back","?user_id=".$objEncDec->encrypt($user_id),"back.png",false,'');?> </div>
                </div>
              </div>
            </div>
          
            <div class="content-box">
              	<div class="content-left-shadow">
                	<div class="content-right-shadow">
                        <div class="content-box-lt">
                            <div class="content-box-rt">
                                <div class="blue_title_cont">
          	<form id="frm" name="frm" method="post">
            <table cellpadding="0" cellspacing="0" width="100%" class="table-bg">
                  <tr class="row01">
        			<td>
			<div style="margin:0px;padding:0px;">
				<div class="access_submit" style="margin:0px;padding:5px;">
                    <input type="submit" title="Save" class="btn_img" value="Save" name="btnsave_access" id="btnsave_access"/>&nbsp;&nbsp;
                    <input type="button" class="btn_img" title="Cancel" value="Cancel" name="btncanel" id="btncanel" onClick="<?php print $cancel_button; ?>"/>
                </div>
				
                <div class="access_submit1">
                	<?php print $objMenu->getMenuTree(0,false,true,$user_id);?>
                </div>

                <div class="access_submit" style="margin:0px;padding:5px;">
                    <input type="submit" title="Save" class="btn_img" value="Save" name="btnsave_access" id="btnsave_access"/>&nbsp;&nbsp;
                    <input type="button" class="btn_img" title="Cancel" value="Cancel" name="btncanel" id="btncanel" onClick="<?php print $cancel_button; ?>"/>
                </div>
            </div>
            </td>
                  </tr>                
                </table>
          </form>
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
