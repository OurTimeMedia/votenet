<?php 
set_time_limit(0);
$domain = $_REQUEST['domain'];
$objWebsite = new website();
$condition = " AND domain='".$domain."' ";
$client_id = $objWebsite->fieldValue("client_id","",$condition);
$index = -1;
require_once (COMMON_CLASS_DIR ."clscommon.php");
$cmn = new common();
if(isset($_SESSION['err']))
{
	echo str_replace("##imgpath##",BASE_DIR,$_SESSION['err']);
	$msg->clearMsg();
}
?>
<p class="font14">
	<?php echo LANG_ADD_CALENDER_NOTE_1; ?><br /><?php echo LANG_ADD_CALENDER_NOTE_2; ?><br />
</p>
<p></p>
<h3><strong><?php echo LANG_ELECTION_IMPACT_ICALENDER; ?>:</strong></h3>
<p class="font14">
	<img src="../images/cle-icon.png" width="77" height="79" style="float:left;" />&nbsp;<a href="webcal://www.<?php echo SITE_DOMAIN_NAME;?>/voter/ElectionImpact_icalendar.php?sid=<?php echo $_SESSION['EI_VOTER_SESSION_Home_State_ID'];?>"><?php echo LANG_CLICK_HERE; ?></a> <?php echo LANG_DOWNLOAD_CALENDER_FEED; ?><br />
	&nbsp;<a href="ElectionImpact_icalendar.php?sid=<?php echo $_SESSION['EI_VOTER_SESSION_Home_State_ID'];?>"><?php echo LANG_CLICK_HERE; ?></a> <?php echo LANG_DOWNLOAD_CALENDER_ICS; ?></p>
<p>&nbsp;</p>