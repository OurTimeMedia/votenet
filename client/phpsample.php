<?php
/**
	 * @Election Impact
	 *
	 * @version 1.0
	 * @author Election Impact
	 *
	 * Code to retrive completion report of register voter
	 */
// include baseclass 	 
include("clsapibase.php");

//require variables
$apikey="NVHR-GVFS-NR0RDRGT-0SGT-0TLR";//api key from client admin panel
//$URL = "http://ourtime.electionimpact.com/client/votnet_test/get_data.php";
$URL="http://www.electionimpact.com/client/get_data.php";
$referal="http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF'];

//searching criteria
if(isset($_REQUEST['txtsearchname']))
	$searchname = $_REQUEST['txtsearchname'];
else
	$searchname ='';
if(isset($_REQUEST['state_code']))
	$state_code = $_REQUEST['state_code'];// state code
else	
	$state_code = '';
if(isset($_REQUEST['reg_source']))	
	$reg_source = $_REQUEST['reg_source']; // API,facebook
else
	$reg_source ='';
if(isset($_REQUEST['txtdateto']))
	$regdateTo=$_REQUEST['txtdateto'];//format 2012-01-14
else
	$regdateTo='';
if(isset($_REQUEST['txtdatefrom']))	
	$regdateFrom=$_REQUEST['txtdatefrom'];//format 2012-01-1
else
	$regdateFrom='';
/////

//variable define
$error=0;//error variable define
$Norecord=0;//record found or not
$nooftotaldata=0;
$noofpages=0;

// get current page detail for paging
if(isset($_REQUEST['page']) && $_REQUEST['page']>0)
	$page=$_REQUEST['page'];
else
	$page=1;

//per page record 
$per_page_rec=50;

//pass values
$fields=array('api_key'=>$apikey,'state_code'=>$state_code,'regdateTo'=>$regdateTo,'regdateFrom'=>$regdateFrom,'reg_source'=>$reg_source,'searchname'=>$searchname,'page'=>$page,'per_page_rec'=>$per_page_rec);
$fields_string='';
foreach($fields as $key=>$value) { if($value !=''){$fields_string .= $key.'='.$value.'&';} }
rtrim($fields_string,'&');

//call base call to get response from api
$objresponse=new apibase();
$objresponse->url=$URL;
$objresponse->referer=$referal;
$response=$objresponse->get_response($fields_string);

// check error is exitst or not	
if(isset($response['Error']) && strlen($response['Error'])>5)
	$error=1;
else if(isset($response['Norecord']))	
	$Norecord=1;
else
{
	$voterdetail=($response['VoterList']);
	// total no of records 
	$nooftotaldata=$response['nototaldata'];
	// total no of pages
	$noofpages= ceil($nooftotaldata/$per_page_rec);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head><body>
<table width="100%" cellpadding="2"  cellspacing="2" border="0" align="center" style="font-size:13px; color:#000;font-family:Arial, Helvetica, sans-serif;">
<form id="frm" name="frm" method="post">
<input type="hidden" value="1" name="page"id="page">
<tr>
	<td><input type="textbox" value="" name="txtsearchname"id="txtsearchname"></td>
	<td>
	<select name="state_code" id="state_code">
	  <option value="0">Select State</option>
		  		  <option value="AL" >AL - Alabama</option>
		  		  <option value="AK" >AK - Alaska</option>
		  		  <option value="AZ" >AZ - Arizona</option>
		  		  <option value="AR" >AR - Arkansas</option>
		  		  <option value="CA" >CA - California</option>
		  		  <option value="CO" >CO - Colorado</option>
		  		  <option value="CT" >CT - Connecticut</option>
		  		  <option value="DE" >DE - Delaware</option>
		  		  <option value="DC" >DC - District of Columbia</option>
		  		  <option value="FL" >FL - Florida</option>
		  		  <option value="GA" >GA - Georgia</option>
		  		  <option value="HI" >HI - Hawaii</option>
		  		  <option value="ID" >ID - Idaho</option>
		  		  <option value="IL" >IL - Illinois</option>
		  		  <option value="IN" >IN - Indiana</option>
		  		  <option value="IA" >IA - Iowa</option>
		  		  <option value="KS" >KS - Kansas</option>
		  		  <option value="KY" >KY - Kentucky</option>
		  		  <option value="LA" >LA - Louisiana</option>
		  		  <option value="ME" >ME - Maine</option>
		  		  <option value="MD" >MD - Maryland</option>
		  		  <option value="MA" >MA - Massachusetts</option>
		  		  <option value="MI" >MI - Michigan</option>
		  		  <option value="MN" >MN - Minnesota</option>
		  		  <option value="MS" >MS - Mississippi</option>
		  		  <option value="MO" >MO - Missouri</option>
		  		  <option value="MT" >MT - Montana</option>
		  		  <option value="NE" >NE - Nebraska</option>
		  		  <option value="NV" >NV - Nevada</option>
		  		  <option value="NH" >NH - New Hampshire</option>
		  		  <option value="NJ" >NJ - New Jersey</option>
		  		  <option value="NM" >NM - New Mexico</option>
		  		  <option value="NY" >NY - New York</option>
		  		  <option value="NC" >NC - North Carolina</option>
		  		  <option value="ND" >ND - North Dakota</option>
		  		  <option value="OH" >OH - Ohio</option>
		  		  <option value="OK" >OK - Oklahoma</option>
		  		  <option value="OR" >OR - Oregon</option>
		  		  <option value="PA" >PA - Pennsylvania</option>
		  		  <option value="RI" >RI - Rhode Island</option>
		  		  <option value="SC" >SC - South Carolina</option>
		  		  <option value="SD" >SD - South Dakota</option>
		  		  <option value="TN" >TN - Tennessee</option>
		  		  <option value="TX" >TX - Texas</option>
		  		  <option value="UT" >UT - Utah</option>
		  		  <option value="VT" >VT - Vermont</option>
		  		  <option value="VA" >VA - Virginia</option>
		  		  <option value="WA" >WA - Washington</option>
		  		  <option value="WV" >WV - West Virginia</option>
		  		  <option value="WI" >WI - Wisconsin</option>
		  		  <option value="WY" >WY - Wyoming</option>
		  	  </select>
	</td>
	<td>
		<select name="reg_source" id="reg_source">
			<option value="0">Registration Source</option>
			<option value="Website">Website</option>
			<option value="Gadget">Gadget</option>
			<option value="Facebook">Facebook</option>
		</select>
	</td>
	<td>
		Date From :<input type="text" value="" class="reprot-input" name="txtdatefrom" id="txtdatefrom" /><!-- date format 2012-01-1-->
	</td>
	<td>
		Date To :<input type="text" value="" class="reprot-input" name="txtdateto" id="txtdateto"/><!-- date format 2012-01-14-->
	</td>
	<td>
		<input type="submit" value="Submit" />
	</td>
</tr>
</form>
<tr><td colspan="6">&nbsp;</td></tr>
</table>
<?php if($error==0)
{
?>
<table width="96%" cellpadding="1"  cellspacing="0"  align="center" style="border: 1px solid #5899c5;font-size:13px; color:#000;font-family:Arial, Helvetica, sans-serif;">
	<tr bgcolor="#a6caf4" style="line-height:25px;">
		<td width="10%" align="left"><strong>Salutation</strong></td>
        <td width="20%" align="left"><strong>Name</strong></td>
		<td width="20%" align="left"><strong>Email</strong></td>
		<td width="10%" align="left" ><strong>State</strong></td>
		<td width="8%" align="left"><strong>Zip Code</strong></td>
		<td width="15%" align="left"><strong>Registration Date</strong></td>
		<td width="31%" align="left"><strong>Registration Source</strong></td>
	</tr>
	<!-- display response data -->
    <?PHP 
	if($Norecord==0)
	{	
		if(count($voterdetail)>0)
		{
			for ($i=0;$i<count($voterdetail);$i++)
			{	
				if($i%2==0)
					$strrow_class = "background:#ffffff;line-height:20px;"; 
				else 
					$strrow_class="background:#eef6ff;line-height:20px;";
	?>
	<tr style="<?PHP echo $strrow_class; ?>">
		<td align="left" valign="top">
			<?PHP echo $voterdetail->Registrant[$i]->Name->Salutation; ?>&nbsp;</td>
		<td width="20%" valign="top">
			<?php echo $voterdetail->Registrant[$i]->Name->First_Name." ".$voterdetail->Registrant[$i]->Name->Middle_Name." ".$voterdetail->Registrant[$i]->Name->Last_Name;?></td>
		<td align="left" valign="top">
			<a href="mailto:<?PHP echo $voterdetail->Registrant[$i]->emailid; ?>"><?PHP echo $voterdetail->Registrant[$i]->emailid; ?></a>&nbsp;
		</td>
		<td align="left" valign="top">
			<?PHP echo $voterdetail->Registrant[$i]->state_name; ?>&nbsp;</td>
		<td align="left" valign="top">
			<?PHP echo $voterdetail->Registrant[$i]->zipcode ?>&nbsp;</td>
		<td align="left" valign="top">
			<?PHP $dt=explode(" ",$voterdetail->Registrant[$i]->voting_date);echo $dt[0];  ?>&nbsp;
		</td>
		<td align="left" valign="top">
			<?PHP echo $voterdetail->Registrant[$i]->registration_source; ?>&nbsp;
		</td>
	</tr>
	<?PHP 
			} 
		}
	}
	else //if no record exits
	{ ?>
		<tr>
			<td align="center" colspan="7" >
				<strong>No records found!</strong>
			</td>
		</tr>
	<?PHP
	}
	?>
	</table>
	<table width="100%" cellpadding="2"  cellspacing="2" border="0" style="font-size:13px; color:#000;font-family:Arial, Helvetica, sans-serif;">
		<tr>
			<td>
				&nbsp;
			</td>	
			<td>
			<?php if($nooftotaldata>0)
			{
			?>
				<strong>No. OF PAGES : <?php echo $noofpages?>&nbsp;&nbsp;</strong>
			<?php	
				if($noofpages>1)
				{	
					if($page>1) 
						echo "&nbsp;<a href='phpsample.php?page=".($page-1)."'><<&nbsp;PREV&nbsp;</a>";
				?>
					&nbsp;&nbsp;GO TO:
					<input type="text" name="noofpage" value="<?php echo $page;?>" maxlength="3" style="width:20px;" onblur="document.location.href='phpsample.php?page='+this.value;">&nbsp;&nbsp;<?php if($page<$noofpages) echo "<a href='phpsample.php?page=".($page+1)."'>NEXT>></a>";?>&nbsp;
				<?php 
				}
			}?>
			</td>
		</tr>
	</table>
	<?php 
	}
	else //dispaly error
	{
?>
		<table width="100%" cellpadding="0"  cellspacing="0" border="0" style="font-size:13px; color:#000;font-family:Arial, Helvetica, sans-serif;">
			<tr>
				<td align="center">
					<strong>Error in the request.<br><?php echo $response['Error'];?></strong>
				</td>
			</tr>
		</table>
<?php }?>
</body>
</html>