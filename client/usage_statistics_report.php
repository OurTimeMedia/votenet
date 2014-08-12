<?php
require_once 'include/general_includes.php';
$objTopClient = new topclientreport();

// check if client is logged in.
$cmn->isAuthorized("index.php", ADMIN_USER_ID);
$userID = $cmn->getSession(ADMIN_USER_ID);
$objTopClient = new topclientreport();
$objpaging = new paging();
//print_r($_POST);

$objClient = new client();
$client_id = $objClient->fieldValue("client_id",$userID);

$state=$objTopClient->statedetail($client_id);
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
$condition='';
if($frmdate && $todate=='')
		{
			$condition .= " and reg_date>=".$frmdate;
		}
		if($todate && $frmdate=='')
		{
			$condition .= " and reg_date<= ".$todate;
		}
		if($todate!='' && $frmdate!='')
			$condition .= " and reg_date between '".$frmdate."' and '".$todate."'";
		if($client_id!='')
			$condition .=" and rds.client_id=".$client_id;
	if(isset($_POST['state_id']) && $_POST['state_id']!=''  && $_POST['state_id']>0)
		$condition .=" and rds.state_id=".$_POST['state_id'];
$objTopClient->pagingType ="montheport";
$objpaging->strorderby = "tot_cnt";
$objpaging->strorder = "desc";
$monthdata = $objpaging->setPageDetails($objTopClient,"usage_statistics_report.php",PAGESIZE,$condition);

// include extra css and js

$extraCss = array("ui-lightness/jquery-ui-1.8.4.custom.css","calendar.css");	
$extraJs = array("jquery-ui-timepicker-addon.min.js","googleapi.js");
include SERVER_CLIENT_ROOT."include/header.php";
include SERVER_CLIENT_ROOT."include/top.php";

?>
<?php //print $objpaging->drawPanelei("panel1"); ?>
<script type="text/javascript">
var chartwidth = 880;
var chartareawidth = 685;

if(document.documentElement.offsetWidth > 1024)
{
	chartwidth = document.documentElement.offsetWidth - 146;
	chartareawidth = chartwidth - 200;
} 

google.load('visualization', '1', {packages: ['corechart']});

      function drawVisualization() {
        // Create and populate the data table.
        var data = new google.visualization.DataTable();
      
	data.addColumn('string', 'Month');
    data.addColumn('number', 'Registrations');
    
	<?php
	for($i=0;$i<count($monthdata);$i++)
	{
		echo "data.addRow(['".$monthdata[$i]['month'].", ".$monthdata[$i]['year']."',".$monthdata[$i]['tot_cnt']."]);";
	}?>
    

        // Create and draw the visualization.
        new google.visualization.ColumnChart(document.getElementById('visualization')).
            draw(data, {curveType: "function",
                        width: chartwidth, height: 230, chartArea:{left: 70, width:chartareawidth},
                        vAxis: {title: 'Registrations', titleTextStyle: {color: 'black'}},
						hAxis: {title: 'Months', titleTextStyle: {color: 'black'}}}
                );
      }
      <?php							if(count($monthdata)>0)
		{?>
	  google.setOnLoadCallback(drawVisualization);
	  <?php }?>

</script>
<script type="text/javascript">


	var slideDownInitHeight = new Array();
	var slidedown_direction = new Array();

	var slidedownActive = false;
	var contentHeight = false;
	var slidedownSpeed = 3; 	// Higher value = faster script
	var slidedownTimer = 7;	// Lower value = faster script
	function slidedown_showHide(boxId,trid)
	{
		if(!slidedown_direction[boxId])slidedown_direction[boxId] = 1;
		if(!slideDownInitHeight[boxId])slideDownInitHeight[boxId] = 0;
		var trid=trid;
		var star='document.getElementById("' + trid + '").style.display=""';
		eval(star);
		if(slideDownInitHeight[boxId]==0)slidedown_direction[boxId]=slidedownSpeed; else slidedown_direction[boxId] = slidedownSpeed*-1;

		slidedownContentBox = document.getElementById(boxId);
		var subDivs = slidedownContentBox.getElementsByTagName('DIV');
		for(var no=0;no<subDivs.length;no++){
			if(subDivs[no].className=='dhtmlgoodies_content')slidedownContent = subDivs[no];
		}
		contentHeight = slidedownContent.offsetHeight;
		slidedownContentBox.style.visibility='visible';
		slidedownActive = true;
		slidedown_showHide_start(slidedownContentBox,slidedownContent,trid);
	}
	function slidedown_showHide_start(slidedownContentBox,slidedownContent,trid)
	{
		var trid=trid;
		if(!slidedownActive)return;
		slideDownInitHeight[slidedownContentBox.id] = slideDownInitHeight[slidedownContentBox.id]/1 + slidedown_direction[slidedownContentBox.id];

		if(slideDownInitHeight[slidedownContentBox.id] <= 0){
			slidedownActive = false;
			slidedownContentBox.style.visibility='hidden';
			var star='document.getElementById("' + trid + '").style.display="none"';
		eval(star);

			slideDownInitHeight[slidedownContentBox.id] = 0;
		}
		if(slideDownInitHeight[slidedownContentBox.id]>contentHeight){
			slidedownActive = false;
		}
		slidedownContentBox.style.height = slideDownInitHeight[slidedownContentBox.id] + 'px';
		slidedownContent.style.top = slideDownInitHeight[slidedownContentBox.id] - contentHeight + 'px';

		setTimeout('slidedown_showHide_start(document.getElementById("' + slidedownContentBox.id + '"),document.getElementById("' + slidedownContent.id + '"),"'+trid+'")',slidedownTimer);	// Choose a lower value than 10 to make the script move faster
	}

	function setSlideDownSpeed(newSpeed)
	{
		slidedownSpeed = newSpeed;
	}
	</script>
<style type="text/css">
	.dhtmlgoodies_contentBox
	{
		height:0px;
		visibility:hidden;
		overflow:hidden;
	}
	.dhtmlgoodies_content{
		position:relative;
		width:100%;
	}
</style>
</head>
<body>
  <!--Start content -->
  <div class="content_mn">
    <div class="content_mn2">
      <div class="cont_mid">
        <div class="cont_lt">
          <div class="cont_rt">
            <div class="user_tab_mn">
              <div class="blue_title">
                <div class="blue_title_lt">
                  	<div class="blue_title_rt">
                    <div class="fleft">Monthly Usage Report</div>
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
                                  <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                    <form id="frm" name="frm" method="post">
                                      <tr>
                                        <td><div class="white">
<table cellpadding="5" cellspacing="0" border="0" class="border-none" width="100%" style="clear:both;" >
<tr class="row02">
<td width="100%" align="left"><table width="100%" cellpadding="0" cellspacing="0" class="listtab-rt-bro">
<tbody>
<tr>
<td width="78%" align="left" valign="middle" height="40"><strong>Date From</strong>&nbsp;<input type="text" value="<?php echo $txtdatefrom;?>" class="reprot-input" name="txtdatefrom" id="txtdatefrom"/>&nbsp;<img src="<?php echo SERVER_ADMIN_HOST?>images/Calender.png" border="0" onClick="javascript:document.getElementById('txtdatefrom').focus();">&nbsp;&nbsp;&nbsp;<strong>Date To</strong>&nbsp;<input type="text" value="<?php echo $txtdateto;?>" class="reprot-input" name="txtdateto" id="txtdateto"/>
&nbsp;<img src="<?php echo SERVER_ADMIN_HOST?>images/Calender.png" border="0" onClick="javascript:document.getElementById('txtdateto').focus();">&nbsp;&nbsp;&nbsp;
	<label>
		<select name="state_id" id="state_id">
			<option value="0">Select State</option>
		<?php

		for($i=0;$i<count($state);$i++)
		{?>
		<option value="<?php echo $state[$i]['state_id']?>" <?php if(isset($_POST['state_id']) && $state[$i]['state_id']==$_POST['state_id']) echo "selected";?>><?php echo $state[$i]['state_name']?></option>
			  <?php }?>
		</select>
	</label>
	&nbsp;&nbsp;&nbsp;
		<input type="submit"  class="btn" value="Search" name="btnsearch" id="btnsearch"/>&nbsp;
		<input type="button" class="btn" value="Clear" name="btnclear" id="btnclear" onclick="javascript:document.location.href='usage_statistics_report.php';"/>&nbsp;
	</td>
	<td width="22%" align="right" valign="middle">
	<?php if(count($monthdata)>0){ ?>
		<input type="button" class="btn" value="Export to Excel" name="btnclear" id="exprot-btn" onclick="javascript:document.frm.action='monthly_report_export.php';document.frm.submit();document.frm.action='';"/>
	<?php } ?>	
	</td>
</tbody>
</table>
</td>
                                            </tr>
                                          </table>

<table cellpadding="0" cellspacing="0" border="0" class="listtab" width="100%" style="clear:both;" >
	<tr bgcolor="#a9cdf5" class="txtbo">
		<td width="20%" align="left">
			<strong>Month</strong><?php $objpaging->_sortImages("reg_date", $cmn->getCurrentPageName()); ?>
		</td>
		<td width="80%" align="left" class="listtab-rt-bro-user" >
			<strong>Total Registration</strong><?php $objpaging->_sortImages("tot_cnt", $cmn->getCurrentPageName()); ?>
		</td>
	</tr>
<?php
		if(count($monthdata)>0)
		{
			for($i=0;$i<count($monthdata);$i++)
			{
				if($i%2==0)
				{
?>
		<tr class="row01" onmouseover="this.className='rowActive'" onmouseout="this.className='row01'">
		<?php }else{?>
		<tr class="row02" onmouseover="this.className='rowActive'" onmouseout="this.className='row02'">
		<?php }?>
		<td align="left"> <?php echo $monthdata[$i]['month'].",&nbsp;".$monthdata[$i]['year'];?></td>
		<td align="left" class="listtab-rt-bro-user"><?php echo $monthdata[$i]['tot_cnt'];?></td>
		</tr>
		<?php }}else{?>
		<tr class="row01" onmouseover="this.className='rowActive'" onmouseout="this.className='row01'">
		<td colspan="2" class="listtab-rt-bro-user" align='center'>No Records Found.</td>
		</tr>
                                            <?php }?>
                                          </table><br />
                                          <div class="fclear"></div>
                                        </div></td>
                                      </tr>
                                      <tr>
                                        <td style="display:none"><?php print $objpaging->drawPanel("panel1"); ?></td>
                                      </tr>
                                    </form>
		<?php							if(count($monthdata)>0)
		{?>
                                    <tr>
											<td colspan="8" align="left"><div id="visualization" style="width: 800px; height: 250px;"></div></td>
                  					</tr>
									<?php }?>
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
  <div class="clear"></div>
</div>
<!--Start footer -->
<?php include "include/footer.php"; ?>
<div class="clear"></div>
</div>
<script type="text/javascript">

jQuery(document).ready(function(){
	jQuery('#txtdatefrom').datepicker({
    });
	jQuery('#txtdateto').datepicker({
    });
});
</script>
</body>
</html>