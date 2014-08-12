<?php	
//error_reporting(1);
require_once './include/general_includes.php';

require_once SERVER_ROOT.'common/class/clscreate_client_sponsors.php';

$cmn->isAuthorized("index.php", ADMIN_USER_ID);

$objSponsors = new create_client_sponsors();	
$objEncDec = new encdec();

$userID = $cmn->getSession(ADMIN_USER_ID);
$objClient = new client();
$objSponsors->client_id = $objClient->fieldValue("client_id",$userID);

//include SERVER_CONTEST_ROOT."contest_step4_db.php";

if(isset($_GET['flg']) && $_GET['flg']=="delete")
{
	$objSponsors->sponsors_id = intval($objEncDec->decrypt($_REQUEST["sponsors_id"]));
	$objSponsors->setAllValuesSponsors($objSponsors->sponsors_id);
		
	$tmp_banner_dir = "ElectionImpactProd/files/sponsors/".$objSponsors->sponsors_logo;
	//$s3 = new s3(AMAZON_KEY, AMAZON_SECRET_KEY);
	//$s3->deleteObject(BUCKET_NAME,$tmp_banner_dir);
	
	$objSponsors->deleteSponsorsDtl();

	$condition = " AND ".DB_PREFIX."sponsors.client_id='".$objSponsors->client_id."' ";
	$orderby = "sponsors_id asc";
	$aSponsorsDetail = $objSponsors->fetchAllAsArraySponsors("","",$condition,$orderby);
	
	$sLIstingHTML = '';
	
	$sLIstingHTML.='<table width="95%" align="center" cellpadding="0" cellspacing="0" class="listtab">
      <tr>
        <td width="27%" bgcolor="#a6caf4" class="listtab-td"><strong>Name</strong></td>
        <td width="58%" align="left" bgcolor="#a6caf4" class="sponsors-table2"><strong>Logo</strong></td>
        <td width="15%" bgcolor="#a6caf4" class="sponsors-table-right"><strong>Action </strong></td>
        </tr>';
	if(count($aSponsorsDetail)>0) {  
		for($i=0;$i<count($aSponsorsDetail);$i++)
		{
			//$sponsorPath = AMAZON_S3_LINK.BUCKET_NAME."/ElectionImpactProd/files/sponsors/" . $aSponsorsDetail[$i]['sponsors_logo'];
			
			$sponsorPath = SERVER_HOST.SPONSER_IMAGE . $aSponsorsDetail[$i]['sponsors_logo'];
			
			$sLIstingHTML.='<tr class="row02">
			<td class="listtab-td">'.$aSponsorsDetail[$i]['sponsors_name'].'</td>
			<td align="left" class="sponsors-table-bottam"><img src="'.$sponsorPath.'" alt="'.$aSponsorsDetail[$i]['sponsors_name'].'"  title="'.$aSponsorsDetail[$i]['sponsors_name'].'" /></td>
			<td class="sponsors-table-right1"><table width="50%" border="0" cellspacing="0" cellpadding="0" class="listtab-rt-bro1">
			<tr>
				<td align="left" valign="middle"><a href="#Sp"><img src="'.SERVER_CLIENT_HOST.'images/edit.png" width="16" height="17" onclick="return setSponsorsDetails(\''.$objEncDec->encrypt($aSponsorsDetail[$i]["sponsors_id"]).'\');"></a></td>
				<td align="left" valign="middle"><a href="javascript:deleteSponsorsDetails(\''.$objEncDec->encrypt($aSponsorsDetail[$i]["sponsors_id"]).'\');"><img src="'.SERVER_CLIENT_HOST.'images/delete2.gif" width="16" height="16"></a></td>
          </tr>
        </table></td>
        </tr>';
		}  
	} 
	else 
	{
		$sLIstingHTML.='<tr class="row01">
			<td align="center" colspan="3">No Sponsors Details Added Yet!</td>
		   </tr>';
	}
    $sLIstingHTML.='</table>';
	
	echo $sLIstingHTML;
	exit;
}

if (isset($_GET['flg']) && $_GET['flg']=="update")
{	
	$objSponsors->setAllValuesSponsors($objEncDec->decrypt($_REQUEST["sponsors_id"]));
	
	//$sponsorPath = AMAZON_S3_LINK.BUCKET_NAME."/ElectionImpactProd/files/sponsors/" . $objSponsors->sponsors_logo;
	$sponsorPath = SERVER_HOST.SPONSER_IMAGE . $objSponsors->sponsors_logo;
	echo html_entity_decode($objSponsors->sponsors_name)."####".html_entity_decode($objSponsors->sponsors_description)."####".html_entity_decode($objSponsors->sponsors_website)."####".$sponsorPath."####".$_REQUEST['sponsors_id'];
	exit;
}
?>