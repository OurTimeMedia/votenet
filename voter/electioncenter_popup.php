<?php
require_once("include/common_includes.php");
require_once("include/general_includes.php");
require COMMON_CLASS_DIR.'clspoll_booth.php';
require COMMON_CLASS_DIR.'clsstate.php';
require_once (COMMON_CLASS_DIR ."clspagingfront.php");
$objpaging = new paging();
$objState= new state();
$cmn = new common();

if(isset($_POST['selState']))
	$state_id=$_POST['selState'];
else	
	$state_id=0;
	
$language_id = $cmn->getSession('voter_language_id');
$objState = new state();
$objState->language_id = $language_id;
$arrState = $objState->fetchAllAsArrayFront();


	$objPollbooth= new poll_booth();
	if(isset($_POST['selState']) && $_POST['selState']>0)
	{
		$state_id=$_POST['selState'];
		$condition=" and pba.state_id=".$state_id." and poll_booth_active =1";
	}
	else	
	{
		$state_id=0;
		$condition=" and poll_booth_active =1";
//	$result = $objPollbooth->fetchAllAsArray($state_id,$condition);
	}
	
$objPollbooth->pagingType = "cReports";
$objpaging->strorderby = "s.state_name";
$objpaging->strorder = "Asc";
$objPollbooth->language_id = $language_id;
$result = $objpaging->setPageDetails($objPollbooth,"electioncenter.php",PAGESIZE,$condition);

?>


<style>
.listtab {
    border-left: 1px solid #73ABE7;
    font-size: 12px;
    width: 100%;
}

.txtbo {
    font-weight: bold;
    vertical-align: top;
}

.listtab td {
    border-bottom: 1px solid #73ABE7;
    border-right: 1px solid #73ABE7;
    padding: 5px;
}

#pager {
    background: none repeat scroll 0 0 #A9CDF5;
    border: 1px solid #A9CDF5;
    height: 30px;
    padding: 5px 0 5px 5px;
	font-size: 12px;
}

#pager td{
    font-size: 12px;
}
</style>
</head>

<body >
<form id="frm" method="post" name="frm" action="electioncenter.php">
<table width="100%" border="0" cellspacing="0" cellpadding="3">
	<tr>
		<td align="left" width="100%" style="font-size:12px;" colspan="2"><b>{$LANG_SELECT_STATE_TEXT}:</b> <select name="selState" id="selState" class="from-input" onchange="this.form.submit();" style="float:none;">
								<option value="">{$LANG_SELECT_A_STATE_TEXT}</option>
							<?php for ($i=0;$i<count($arrState);$i++){ ?>
							  <option value="<?php echo $arrState[$i]['state_id'];?>" <?php if(isset($_REQUEST['selState']) && $arrState[$i]['state_id'] == $_REQUEST['selState']) { echo "selected";} ?>><?php echo $arrState[$i]['state_name'];?></option>
							<?php } ?>							
							</select></td>
	</tr>
	<tr>
	<td colspan="2">
	
<table cellpadding="0" cellspacing="0" border="0" class="listtab" width="100%" style="clear:both;">
  <tr bgcolor="#a9cdf5" class="txtbo">
	<td width="20%" align="left" nowrap="nowrap"><strong>{$LANG_STATE_TEXT}</strong>
		<?php $objpaging->_sortImages("election_type_name", $cmn->getCurrentPageName()); ?></td>
	<td width="20%" align="left" nowrap="nowrap"><strong>{$LANG_ADDRESS_TEXT}</strong>
		<?php $objpaging->_sortImages("state_code", $cmn->getCurrentPageName()); ?></td>
	
  </tr>
  <?php 
  if( count($result)>0){
for($i=0;$i<count($result);$i++)
	{ 
		?>
  <?php if($i%2==0) $strrow_class = "row01"; else $strrow_class="row2";?>
  <tr class="<?php echo $strrow_class?>">
	<td align="left"><?php print $cmn->readValueDetail($result[$i]["state_name"]); ?>&nbsp;</td>
	<td align="left"><?php echo $result[$i]['poll_booth_address1']." ".$result[$i]['poll_booth_address2'].", <br/>".$result[$i]['poll_booth_city'].", ".$result[$i]['state_code']." ".$result[$i]['poll_booth_zipcode']; ?>&nbsp;</td>
	
  </tr>
  
  <?php 
	} ?>
	
	<?php }
	 if (count($result)==0){ ?>
  <tr>
	<td colspan="2" align="center"><strong>No record found.<strong></td>
  </tr>
  <?php } ?>
</table>
<?php
 if(count($result)>0) { ?>
<tr>
                  <td colspan="2"><div id="pager"><?php print $objpaging->drawPanel("panel1"); ?></div></td>
                </tr>
				<?php }?>
</td>
</tr>	
<tr>	
	<td align="left" valign="middle" colspan="2">&nbsp;</td>
</tr>
</table></form>