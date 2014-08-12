<?php
require_once("include/general_includes.php");

$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);
$user_id = 0;
if (isset($_REQUEST['user_id']) && trim($_REQUEST['user_id'])!="")
{
	$user_id = $_REQUEST['user_id'];
	$entityID = $_REQUEST['user_id'];
}	
//CHECK FOR RECORED EXISTS
$record_condition = "";	
if (!($cmn->isRecordExists("user", "user_id", $user_id, $record_condition)))
	$msg->sendMsg("client_admin_list.php","",46);
//END CHECK

$objPlan = new plan();
$objLanguage = new language();

$condi=" and language_isactive=1 and language_ispublish=1";
$language=$objLanguage->fetchRecordSet("",$condi);

$objClientAdmin = new client();
$cancel_button = "javascript: window.location.href='client_admin_list.php';";
$objClientAdmin->setAllValues($user_id);

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
                  <div class="fleft">Client  Details</div>
                  <div class="fright"> 
                  <?php print $cmn->getAdminMenuLink("client_admin_list.php","client_admin_list","Back","","back.png",false);?>
            <?php print ($user_id==1 && $cmn->getSession(SYSTEM_ADMIN_USER_ID)!=1) ? "" : $cmn->getAdminMenuLink("client_admin_addedit.php","client_admin_addedit","Edit","?hdnuser_id=".$user_id,"edit.png",false);?>
            <?php print ($user_id!=1) ? $cmn->getAdminMenuLink("client_admin_delete.php","client_admin_delete","Delete","?user_id=".$user_id,"delete.png",false):"";?>
            <?php print ($user_id!=1) ? $cmn->getAdminMenuLink("client_admin_login.php","client_admin_login","Login As Client Admin","?user_id=".$user_id,"key_icon.png",false,"","_blank"):"";?>
           		 </div>
                </div>
              </div>
            </div>
            <div class="blue_title_cont">
             <table cellpadding="0" cellspacing="0" border="0" class="listtab" width="100%">

				<tr class="row01">
					<td align="left" valign="top" width="15%" class="txtbo">
						Username:
					</td>
		
					<td align="left" valign="top">
						&nbsp;<?php echo htmlspecialchars($objClientAdmin->user_username); ?>
					</td>
		
				</tr>
		
				<tr class="row02">
					<td align="left" valign="top" class="txtbo">
						First Name:
					</td>
		
					<td align="left" valign="top">
						&nbsp;<?php echo htmlspecialchars($objClientAdmin->user_firstname); ?>
					</td>
		
				</tr>
		
				<tr class="row01">
					<td align="left" valign="top" class="txtbo">
						Last Name:
					</td>
		
					<td align="left" valign="top">
						&nbsp;<?php echo htmlspecialchars($objClientAdmin->user_lastname); ?>
					</td>
		
				</tr>
				
				<tr class="row02">
					<td align="left" valign="top" class="txtbo">
						Company:
					</td>
		
					<td align="left" valign="top">
						&nbsp;<?php echo htmlspecialchars($objClientAdmin->user_company); ?>
					</td>
		
				</tr>
		
				<tr class="row01">
					<td align="left" valign="top" class="txtbo">
						Email:
					</td>
		
					<td align="left" valign="top">
						&nbsp;<a title="<?php print htmlspecialchars($objClientAdmin->user_email); ?>" href="mailto:<?php print htmlspecialchars($objClientAdmin->user_email); ?>"><?php echo htmlspecialchars($objClientAdmin->user_email); ?></a>
					</td>
		
				</tr>
		
				
		
				<tr class="row02">
					<td align="left" valign="top" class="txtbo">
						Phone:
					</td>
		
					<td align="left" valign="top">
						&nbsp;<?php echo htmlspecialchars($objClientAdmin->user_phone); ?>
					</td>
		
				</tr>
		
				<tr class="row01">
					<td align="left" valign="top" class="txtbo">
						Address1:
					</td>
		
					<td align="left" valign="top">
						&nbsp;<?php echo htmlspecialchars($objClientAdmin->user_address1); ?>
					</td>
		
				</tr>
		
				<tr class="row02">
					<td align="left" valign="top" class="txtbo">
						Address2:
					</td>
		
					<td align="left" valign="top">
						&nbsp;<?php echo htmlspecialchars($objClientAdmin->user_address2); ?>
					</td>
		
				</tr>
		
				<tr class="row01">
					<td align="left" valign="top" class="txtbo">
						City:
					</td>
		
					<td align="left" valign="top">
						&nbsp;<?php echo htmlspecialchars($objClientAdmin->user_city); ?>
					</td>
		
				</tr>
		
				<tr class="row02">
					<td align="left" valign="top" class="txtbo">
						State:
					</td>
		
					<td align="left" valign="top">
						&nbsp;<?php echo htmlspecialchars($objClientAdmin->user_state); ?>
					</td>
		
				</tr>
		
				<tr class="row01">
					<td align="left" valign="top" class="txtbo">
						Country:
					</td>
		
					<td align="left" valign="top">
						&nbsp;<?php if($objClientAdmin->user_country != 0 ) echo $cmn->getContryNameById($objClientAdmin->user_country); ?>
					</td>
		
				</tr>
				<?php 
				$clientLanguages = array();
				$clientLanguages = explode(",",$objClientAdmin->languages);
								
				$clientSelLanguages = array();
				for($i=0;$i<count($language);$i++)
				{
					if(in_array($language[$i]['language_id'],$clientLanguages))
							$clientSelLanguages[] = $language[$i]['language_name'];
				}			
				?>
				<tr class="row02">
					<td align="left" valign="top" class="txtbo">
						Languages:
					</td>		
					<td align="left" valign="top">
					&nbsp;<?php echo implode(", ", $clientSelLanguages); ?>
					</td>		
				</tr>		
				<tr class="row01">
					<td align="left" valign="top" class="txtbo">
						Plan:
					</td>		
					<td align="left" valign="top">&nbsp;<?php echo $objPlan->fieldValue("plan_title", htmlspecialchars($objClientAdmin->plan_id)); ?></td>
				</tr>
				<tr class="row02">
					<td align="left" valign="top" class="txtbo">
						Expiry Date:
					</td>
		
					<td align="left" valign="top">&nbsp;<?php echo htmlspecialchars($objClientAdmin->expiry_date); ?>
					
					</td>
		
				</tr>
				<tr class="row01">
					<td align="left" valign="top" class="txtbo">
						Allow Credit:
					</td>		
					<td align="left" valign="top">					
						&nbsp;<?php ($objClientAdmin->allow_credit==1) ? print 'Yes' : print 'No' ?>
					</td>		
				</tr>				
				<tr class="row02">
					<td align="left" valign="top" class="txtbo">
						Active:
					</td>
		
					<td align="left" valign="top">
					
						&nbsp;<?php ($objClientAdmin->user_isactive==1) ? print 'Yes' : print 'No' ?>
					</td>
		
				</tr>
		
			</table>
            </div>
          </div>
        </div>
      </div>
    </div>
 
</div>
<?php include SERVER_ADMIN_ROOT."include/footer.php"; ?>
