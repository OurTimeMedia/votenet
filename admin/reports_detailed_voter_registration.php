<?php
//include base file
require_once 'include/general_includes.php';
	
//check admin login authentication
$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);

//create class obj	
$objpaging = new paging();
$objEncDec = new encdec();
$objTopClient = new topclientreport();

//get field page details
if(isset($_POST['txtFieldPage']) && $_POST['txtFieldPage']==1)
{
	$objTopClient->saveselectedfield($_POST,0);
}

//fetch selected fields from admin
$aSelectedFields= $objTopClient->selectedfield(2);

// all field details
$aFileds = $objTopClient->fetchFields();

//create field list
if(count($aSelectedFields)>0)
{
	$fields='';
	for($i=0;$i<count($aSelectedFields);$i++)
	{
		$fields .="field_".$aSelectedFields[$i]['field_id'].",";
	}
}
else //if field are not selected then default
{
	$fields='rpt_reg_id,client_id,voter_email,voter_state_id,voter_zipcode,voting_date,state_name,voter_reg_source,';
}
	
//check registration date for searching criteria	
if(isset($_POST['txtdatefrom']) && $_POST['txtdatefrom']!='')
{
	$txtdatefrom=$_POST['txtdatefrom'];
	$fromdate=explode("/",$_POST['txtdatefrom']);
	$frmdate=$fromdate[2]."-".$fromdate[0]."-".$fromdate[1];
}
else
{
	$frmdate='';
	$txtdatefrom='';
}
if(isset($_POST['txtdateto']) && $_POST['txtdateto']!='')
{
	$txtdateto=$_POST['txtdateto'];
	$dateto=explode("/",$_POST['txtdateto']);
	$todate=$dateto[2]."-".$dateto[0]."-".$dateto[1];
}
else
{
	$todate='';
	$txtdateto='';
}
$condition ='';
if($frmdate && $todate=='')
{
	$condition .= " and voting_date>=".$frmdate;
}	
else if($todate && $frmdate=='')
{
	$condition .= " and voting_date<= ".$todate;
}	
else if($todate!='' && $frmdate!='')
	$condition .= " and voting_date between '".$frmdate."' and '".$todate."'";
	
$txtsearchname = "";

//seaching criteria	
if(isset($_REQUEST['txtsearchname']))
{
	$txtsearchname = $_REQUEST['txtsearchname'];
	
	if (trim($_REQUEST['txtsearchname'])!="")
	for($i=0;$i<count($aFileds);$i++) { 
		if($i==0)
		$condition .= ' and ';
		$condition .= " voter_reg_source like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%' or ";
		$condition .= " voter_zipcode like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%' or ";
		$condition .= " voter_email like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%' or ";
		$condition .= " state_name like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%' or ";
		$condition .= 'field_'.$aFileds[$i]['field_id']." like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%'";
		if($i<count($aFileds)-1)
			$condition .=" || ";
		}
}
	 
//fetch register voter data
$objTopClient->pagingType ="registantrpt";
$objpaging->strorderby = "voting_date";
$objpaging->strorder = "desc";
$voterdetail = $objpaging->setPageDetails($objTopClient,"reports_detailed_voter_registration.php",PAGESIZE,$condition,'','','',$fields);

$totRecords = $objTopClient->registrantdetailcount("", $condition);

$recordSel = "";
if($totRecords > 10000)
{
	$recordSel = "<strong>Export Records</strong> <select id='resRec' name='resRec'>";
	
	for($i=1; $i<= $totRecords; $i = ($i+10000))
	{
		if(($i+10000) >= $totRecords)
			$recordSel.= "<option value='".($i."-".$totRecords)."'>".("From ".$i." to ".$totRecords)."</option>";
		else
			$recordSel.= "<option value='".($i."-".($i+9999))."'>".("From ".$i." to ".($i+9999))."</option>";
	}
	
	$recordSel.= "</select> ";
}

$definedColSpan=9;

//include js and css files
$extraJs = array("jquery-ui-timepicker-addon.min.js");
$extraCss = array("calendar.css");
	
include SERVER_ADMIN_ROOT."include/header.php";
include SERVER_ADMIN_ROOT."include/top.php";
?>
<script type="text/javascript">
jQuery.noConflict();					
jQuery(function()
{	
	// Dialog Link
	jQuery('#dialog_link').click(function(){
	jQuery('#dialog').dialog();
	return false;
	});	
});
</script>
		<div class="content_mn">
		<div class="content_mn2">
		  <div class="cont_mid">
			<div class="cont_lt">
			  <div class="cont_rt">
				<div class="user_tab_mn">
				  <div class="blue_title">
					<div class="blue_title_lt">
						<div class="blue_title_rt">
						Detailed Voter Registration Report 
						  <div class="fright"></div>
					  </div>
					</div>
				  </div>
				  <div class="content-box">
					<div class="content-left-shadow">
						<div class="content-right-shadow">
							<div class="content-box-lt">
								<div class="content-box-rt" id="content-box-rt11">
									<div class="blue_title_cont">
									  <table width="100%" cellpadding="0" cellspacing="0" border="0">
										<form id="frm" name="frm" method="post">
										  <tr>
											<td><div class="white">
	<table width="100%" cellpadding="5" cellspacing="0" border="0" class="listtab"  style="clear:both;" >
	<tr class="row02">
				  <td align="left">
	<table width="100%" cellpadding="0" cellspacing="0" class="listtab-rt-bro">
	<tbody>
	  <tr>
		<td width="50%" align="left" valign="middle">
		<table width="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td align="left"><strong>Keyword:</strong>&nbsp;<input type="text" value="<?php echo $txtsearchname?>" class="reprot-input" name="txtsearchname" id="txtsearchname"/></td>
		</tr>
		<tr>
			<td align="left"><strong>Date From:</strong>&nbsp;<input type="text" value="<?php echo $txtdatefrom?>" class="reprot-input" name="txtdatefrom" id="txtdatefrom"/>
		  &nbsp;<img src="<?php echo SERVER_ADMIN_HOST?>images/Calender.png" border="0" onClick="javascript:document.getElementById('txtdatefrom').focus();">
		&nbsp;&nbsp;  
		<strong>Date To:</strong>&nbsp;<input type="text" value="<?php echo $txtdateto;?>" class="reprot-input" name="txtdateto" id="txtdateto"/>
		 &nbsp;<img src="<?php echo SERVER_ADMIN_HOST?>images/Calender.png" border="0" onClick="javascript:document.getElementById('txtdateto').focus();"></td>
		</tr>
		</table>		
		 <input type="submit"  class="btn" value="Search" name="btnsearch" id="btnsearch"/>
		  &nbsp;
		  <input type="button" class="btn" value="Clear" name="btnclear" id="btnclear" onclick="javascript:document.location.href='reports_detailed_voter_registration.php';"//></td>		
		<td width="50%" align="right" valign="middle">
		<table width="100%" cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td align="right"><a id="dialog_link" style="padding-left:10px;text-decoration:none;">		
		<input type="button" class="btn" value="Apply Filter" name="btnclear" id="filter_btn"/></a></td>
		</tr>
		<tr>
			<td align="right">			
			<?php echo $recordSel; ?><input type="button" class="btn" value="Export to Excel" name="btnexport" id="btnexport" style="margin-top:5px;" onclick="javascript:document.frm.action='voter_registration_export.php';document.frm.submit(); document.frm.action='';"/></td>
		</tr>
		</table></td>
	  </tr>
	</tbody>
	</table></td>
	</tr>
	</table>
	<table width="100%" cellpadding="0" cellspacing="0" border="0"  style="clear:both;" >
	  <tr bgcolor="#a6caf4" class="txtbo"><td>
	  <?PHP if(count($aSelectedFields)>0) {
	  // when fields are selected
					  			 ?>
                                   	<div style="width:885px;overflow:auto; border-left: 1px solid #73ABE7;  border-right: 1px solid #73ABE7" id="horizontal_div">                                   
						  
                          <table width="100%" cellpadding="0" class="listtab" cellspacing="0" border="0" style="border: none;">
                          <tr bgcolor="#a9cdf5" class="txtbo">
							   <td width="15%" align="left" valign="top"><strong>Email</strong><?php $objpaging->_sortImages("voter_email", $cmn->getCurrentPageName()); ?></td>
								<?PHP 			
								if(count($aSelectedFields) <= 5)
									$fieldwidth = ceil(75/count($aSelectedFields));
								else
									$fieldwidth = 10;
									
								for($y=0;$y<count($aSelectedFields);$y++)
								{ ?>
									<td style="width:<?php echo $fieldwidth;?>%; min-width: 100px;"  valign="top" align="left"><strong><?PHP echo $aSelectedFields[$y]['field_caption']; ?></strong><?php $objpaging->_sortImages('field_'.$aSelectedFields[$y]['field_id'], $cmn->getCurrentPageName()); ?></td>
							  
								<?PHP } ?>
								<td align="center" width="10%" valign="top"><strong>Action</strong></td>
							</tr>
                    	<?PHP 
						if(count($voterdetail)>0)
						{
							for ($i=0;$i<count($voterdetail);$i++)
							{	if($i%2==0) $strrow_class = "row01"; else $strrow_class="row2";?>
                    	       	<tr class="<?PHP echo $strrow_class; ?>">
								 <td align="left" valign="top"><a href="mailto:<?PHP echo $voterdetail[$i]['voter_email']; ?>"><?PHP echo $voterdetail[$i]['voter_email']; ?></a></td>
                          <?PHP for($y=0;$y<count($aSelectedFields);$y++)
                                { 
								  ?>
                                     <td align="left" valign="top">
									 <?PHP echo $voterdetail[$i]['field_'.$aSelectedFields[$y]['field_id']]; ?>&nbsp;</td>
                             <?PHP }?>
							 <td align="center" class="listtab-rt-bro-user"><a href="voter_registration_detail.php?voterid=<?php print $objEncDec->encrypt(htmlspecialchars($voterdetail[$i]["rpt_reg_id"])); ?>" class="gray_btn_view">	View</a></td>
							 <?php
								 } ?>
								 
                                 </tr>
                 	<?PHP }  else { ?>
                               <tr class="row01">
                                  <td align="center" colspan="<?PHP echo (count($aSelectedFields)+2); ?>"><strong>No records found!</strong></td>
                               </tr>
                    <?PHP } ?>
                    </table>    
                             
					 <?PHP  

						  { ?>
                               </div></td></tr><tr><td>
					<?PHP } }
					  else { 
					  //display default fields
					  ?>
                           <table width="100%" cellpadding="0" class="listtab" cellspacing="0" border="0">
                          <tr bgcolor="#a9cdf5" class="txtbo">                           
							<td width="20%" align="left"><strong>Email</strong><?php $objpaging->_sortImages("voter_email", $cmn->getCurrentPageName()); ?></td>
							 <td width="15%" align="left" nowrap="nowrap"><strong>Voter State</strong><?php $objpaging->_sortImages("state_name", $cmn->getCurrentPageName()); ?></td>
							<td width="12%" align="left"><strong>Voter Zip Code</strong><?php $objpaging->_sortImages("voter_zipcode", $cmn->getCurrentPageName()); ?></td>
							<td width="20%" align="left"><strong>Voter Registration Date</strong><?php $objpaging->_sortImages("voting_date", $cmn->getCurrentPageName()); ?></td>
							<td width="22%" align="left"><strong>Registration Source</strong><?php $objpaging->_sortImages("voter_reg_source", $cmn->getCurrentPageName()); ?></td>
							<td align="center" class="listtab-rt-bro-user"><strong>Action</strong></td>
                          </tr>
                          <?PHP 
						   	if(count($voterdetail)>0)
							{
						  	for ($i=0;$i<count($voterdetail);$i++)
							{	if($i%2==0) $strrow_class = "row01"; else $strrow_class="row2";
						  ?>
                          <tr class="<?PHP echo $strrow_class; ?>">
							<td align="left" valign="top"><a href="mailto:<?PHP echo $voterdetail[$i]['voter_email']; ?>"><?PHP echo $voterdetail[$i]['voter_email']; ?></a>&nbsp;</td>
							<td align="left" valign="top"><?PHP echo $voterdetail[$i]['state_name']; ?>&nbsp;</td>
                            <td align="left" valign="top"><?PHP echo $voterdetail[$i]['voter_zipcode']; ?>&nbsp;</td>
                            <td align="left" valign="top"><?PHP echo  date("m/d/Y",strtotime($voterdetail[$i]['voting_date'])); ?>&nbsp;</td>
                            <td align="left" valign="top"><?PHP echo $voterdetail[$i]['voter_reg_source']; ?>&nbsp;</td>
                            <td align="center" class="listtab-rt-bro-user"><a href="voter_registration_detail.php?voterid=<?php print $objEncDec->encrypt(htmlspecialchars($voterdetail[$i]["rpt_reg_id"])); ?>" class="gray_btn_view">	View</a></td>	
                          </tr>
                         
                          <?PHP } } else { ?>
                          	 <tr class="row01">
                            	<td align="center" colspan="<?PHP echo $definedColSpan; ?>">No Records Found.</td>
                            </tr>
                          <?PHP } ?>
                           </table>
						 <?PHP  }
						  ?>
						  </td></tr>

		</table>
		<div class="fclear"></div>
		</div></td>
										  </tr>
										   <tr>
                  <td align="left"><div id="pager"><?php print $objpaging->drawPanel("panel1"); ?></div></td>
                </tr>
										</form>
									  </table>
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
	 
	  
	
<div id="dialog" title="Apply Filter" style="display:none;">
<form name="frmFields" id="frmFields" method="post">
  <table cellpadding="2" cellspacing="1" border="0" width="100%">    	
	<input type="hidden" name="txtFieldPage" id="txtFieldPage" value="1" />
	<input type="hidden" name="report_id" id="report_id" value="2" />	 
		<tr>
		  <?PHP		
				$field_header_id = 0;
				$endTag = '';
				$j = 0;
				for($i=0;$i<count($aFileds);$i++) { 
				$isChecked = '';	
				if(count($aSelectedFields)>0)
				{
					for($y=0;$y<count($aSelectedFields);$y++)
					{
						if($aFileds[$i]['field_id']==$aSelectedFields[$y]['field_id'])
						{
							$isChecked = 'checked="checked"';
							break;
						}
					}
				}
				
				if($field_header_id != $aFileds[$i]['field_header_id'])
				{
					$field_header_id = $aFileds[$i]['field_header_id'];
					
					if($i != 0)
						echo '</tr><tr><td colspan="4"><hr /></td></tr><tr>';
						
					$j = 0;
				}	
				
				if(($j+1)%2==0) { $endTag = '</tr><tr>'; } else { $endTag = ''; }
		  ?>
		  <td width="3%" valign="top" align="left"><input type="checkbox" name="field[]" value="<?PHP echo $aFileds[$i]['field_id']; ?>" <?PHP echo $isChecked; ?> ></td>
		  <td width="47%" valign="top" align="left"><?PHP echo $aFileds[$i]['field_caption']; ?></td>
		   <?PHP  echo $endTag; 
		   $j++;		   
		   } ?>
		</tr>
	    <tr><td colspan="4" align="center"> <input type="button" id="btnok" name="btnok" class="btn" value="Save"  onClick="javascript:document.frmFields.submit();" /></td> </tr>
  </table>
  </form>
</div>
<!--Start footer -->
<?php include "include/footer.php"; ?>
<div class="clear"></div>
</div>
</body>
</html>
<script language="javascript1.1">	
if(document.getElementById('content-box-rt11').offsetWidth > 924)
		document.getElementById('horizontal_div').style.width = (document.getElementById('content-box-rt11').offsetWidth - ((document.getElementById('content-box-rt11').offsetWidth)*4/100))-2+"px";
</script>
<script type="text/javascript">
jQuery.noConflict();
jQuery(document).ready(function(){
	jQuery('#txtdatefrom').datepicker({
	});
	jQuery('#txtdateto').datepicker({
	});
});
</script>