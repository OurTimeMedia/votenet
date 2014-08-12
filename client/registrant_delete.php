<?php
require_once("include/general_includes.php");

$cmn->isAuthorized("index.php", ADMIN_USER_ID);
$objEncDec = new encdec();	
$rid=0;

if (isset($_REQUEST['rid']) && trim($_REQUEST['rid'])!="")
	$rid = $objEncDec->decrypt($_REQUEST['rid']);
	
//CHECK FOR RECORED EXISTS
$record_condition = "";	
if (!($cmn->isRecordExistsReport("rpt_registration", "rpt_reg_id", $rid, $record_condition)))
	$msg->sendMsg("registrants_list.php","",46);

//END CHECK

global $aClientAdminLookupTables;
	
$objRegistrant = new registrantreport();

$mode=DELETE;

include "registrant_db.php";	

$extraJs = array("registrant.js");
include SERVER_CLIENT_ROOT."include/header.php";
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
                  <div class="fleft"><?php print "Delete Registrant"; ?></div>
                  <div class="fright"> 
                   <?php 
                   		print $cmn->getClientMenuLink("registrants_detail.php","registrants_detail","Back","?rid=".$objEncDec->encrypt($rid),"back.png",false); 
                   ?>
                  
                   </div>
                </div>
              </div>
            </div>
            <div class="content-box">
              	<div class="content-left-shadow">
                	<div class="content-right-shadow">
                        <div class="content-box-lt">
                            <div class="content-box-rt">
                                <div class="blue_title_cont">            
             <?php if(isset($_POST["err"])){ 
        	 ($_POST["err"]!="") ? $msg->displayMsg() : "";
      } ?>
          <form id="frm" name="frm" method="post">
          <table cellpadding="0" cellspacing="0" width="100%" class="listtab">
                  <tr class="row01">
        			<td class="listtab-rt-bro-user">Are you sure you want to delete this registrant?<br/><br/>
          <input type="hidden" name="mode" id="mode" value="delete" />
          <input type="hidden" name="rid" id="rid" value="<?php print $objEncDec->encrypt($rid);?>" />
          <input type="submit" id="btndelete" title="Delete" name="btndelete" value="Delete" class="btn-red" />
          <input type="button" title="Cancel" id="btncancel" name="btncancel" value="Cancel" class="btn" onclick="javascript: window.location.href='registrants_detail.php?rid=<?php print $objEncDec->encrypt($rid);?>';" /></td>
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
<?php include SERVER_CLIENT_ROOT."include/footer.php"; ?>
</body>
</html>