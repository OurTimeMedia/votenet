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
	Add to your Calendar will allow to download iCalendar file or subscribe for iCalnedar feed.<br />
	If you subscribe for iCalendar feed, your calendar will automatically update when we updates Election dates or Registration Deadline dates.<br />
</p>
<p></p>
<h3><strong>Election Impact iCalender:</strong></h3>
<p class="font14">
	<img src="../images/cle-icon.png" width="77" height="79" style="float:left;" />&nbsp;<a href="webcal://<?php echo SITE_DOMAIN_NAME;?>/voter/ElectionImpact_icalendar.php?sid=<?php echo $_SESSION['EI_VOTER_SESSION_Home_State_ID'];?>">Click here</a> to get all Election Dates and your Form Due / Registration date in a single iCalender feed.<br />
	&nbsp;<a href="ElectionImpact_icalendar.php?sid=<?php echo $_SESSION['EI_VOTER_SESSION_Home_State_ID'];?>">Click here</a> to download iCalender in .ics format and import it manually in your Calender application.</p>
<p>&nbsp;</p>