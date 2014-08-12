<?php
//include base file
require_once 'include/general_includes.php';
	
//check admin login authentication
$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);

//create class obj	
$objpaging = new paging();
$objTopClient = new topclientreport();

$condition = "";

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
if(isset($_POST['txtdateto']) && $_POST['txtdateto']!='' )
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
if($frmdate && $todate=='')
{
	$condition .= " and reg_date>=".$frmdate;
}	
else if($todate && $frmdate=='')
{
	$condition .= " and reg_date<= ".$todate;
}	
else if($todate!='' && $frmdate!='')
	$condition .= " and reg_date between '".$frmdate."' and '".$todate."'";
			
//fetch most active state data			
$objTopClient->pagingType ="toptenstaterpt";
$objpaging->strorderby = "tot_cnt";
$objpaging->strorder = "desc";

$statewisedata = $objpaging->setPageDetails($objTopClient,"reports_state_by_state_summary.php",PAGESIZE,$condition);
//END

//include JS and CSS files
$extraJs = array("jquery-ui-timepicker-addon.min.js");
$extraCss = array("calendar.css");
include SERVER_ADMIN_ROOT."include/header.php";
include SERVER_ADMIN_ROOT."include/top.php";

if(count($statewisedata) > 0) { 
?>
<script type="text/javascript" src="js/googleapi.js"></script>
<script type="text/javascript">
var chartwidth = 880;
var chartareawidth = 685;

if(window.innerWidth > 1024)
{
	chartwidth = window.innerWidth - 146;
	chartareawidth = chartwidth - 200;
} 
   
google.load('visualization', '1', {packages: ['corechart']});

  
function drawVisualization() 
{
	// Create and populate the data table.
	var data = new google.visualization.DataTable();
 
data.addColumn('string', 'States');
data.addColumn('number', 'Registrations');

<?php if(count($statewisedata)>0 && is_array($statewisedata) && $statewisedata[0]['state_name']!='')
{

	for($i=0;$i<count($statewisedata);$i++)
	{
		if($i==0)
			$regstatestart=$statewisedata[$i]['state_name'];
		$regstate=$statewisedata[$i]['state_name'];
	echo 'data.addRow(["'.$statewisedata[$i]['state_name'].'",'.$statewisedata[$i]['tot_cnt'].']);';
	}
}?>
	// Create and draw the visualization.
	new google.visualization.ColumnChart(document.getElementById('visualization')).
		draw(data, {curveType: "function",
					width: chartwidth, height: 250, pointSize:4, chartArea:{left: 70, width:chartareawidth}, 
					vAxis: {title: 'Registrations', titleTextStyle: {color: 'black'}, textStyle: {fontSize: 12}},
					hAxis: {title: 'States', textStyle: {fontSize: 12}, titleTextStyle: {color: 'black'}}});
}
google.setOnLoadCallback(drawVisualization);
</script>
<?php } ?>
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
                  <div class="fleft">&nbsp;Top 10 Most Active States Report</div>
                  <div class="fright">&nbsp;</div>
                </div>
              </div>
            </div>           
            <div class="blue_title_cont">
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
			<tr>
                                        <td>
			<table cellpadding="0" cellspacing="0" border="0" class="listtab" width="100%" style="clear:both;" >
			<tr><td colspan="2" align="left">
			<form name="frm" id="frm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="javascript: return validate();">			
			<table width="100%" cellpadding="0" cellspacing="0" class="listtab-rt-bro">
			<tbody>
			  <tr>
				<td width="78%" align="left" valign="middle"><strong>Date From</strong>&nbsp;<input type="text" value="<?php echo $txtdatefrom;?>" class="reprot-input" name="txtdatefrom" id="txtdatefrom" readonly="readonly"/>
				 <img src="images/Calender.png" border="0" onClick="javascript:document.getElementById('txtdatefrom').focus();">
				 &nbsp;&nbsp;&nbsp;
				 <strong>Date To</strong>&nbsp;
				 <input type="text" value="<?php echo $txtdateto;?>" class="reprot-input" name="txtdateto" id="txtdateto" readonly="readonly"/>
				<img src="images/Calender.png" border="0" onClick="javascript:document.getElementById('txtdateto').focus();">
				&nbsp;&nbsp;&nbsp;
				<input type="submit"  class="btn" value="Search" name="btnsearch" id="btnsearch"/>
				  &nbsp;
				<input style="cursor:pointer" type="button" class="btn" value="Clear" name="btnclear" id="btnclear" onclick="document.location.href='reports_top_10_most_active_state.php'"/>
				</td>			   
				<td width="22%" height="40" valign="middle" align="right">	
				<?php if(count($statewisedata) > 0) { ?>
				<input type="button" class="btn" value="Export to Excel" name="btnexport" id="btnexport" onclick="javascript:document.frm.action='export_top_active_state.php';document.frm.submit(); document.frm.action='';"/>				
				<?php } ?>
				</td>			  
			  </tr>
			</tbody>
		  </table>
		
		  
		  </td>
                                           
			
                                            <tr bgcolor="#a9cdf5" class="txtbo">
                                              <td width="20%" align="left"><strong>State
											  </strong></td>
                                              <td width="80%" align="left" class="listtab-rt-bro-user"><strong>Total Registration</strong></td>
                                            </tr>
				<?php 
				if(count($statewisedata)>0 && is_array($statewisedata) && $statewisedata[0]['state_name']!=''){
				for($i=0;$i<count($statewisedata);$i++)
				{?>
					<tr class="row02" onmouseover="this.className='rowActive'" onmouseout="this.className='row01'">
						<td align="left"><?php echo $statewisedata[$i]['state_name']?></td>
						<td align="left" class="listtab-rt-bro-user"><?php echo $statewisedata[$i]['tot_cnt']?></td>
					</tr>
				<?php }}else{?>
				<tr class="row02" onmouseover="this.className='rowActive'" onmouseout="this.className='row01'">
				
						<td colspan='2' align="center"><strong>No Records Found.</strong></td>
						
					</tr>
				<?php }?>		
			</table></td>
        </tr>	
		<?php if(count($statewisedata) > 0) { ?>
		<tr>
            <td align="left">&nbsp;</td>
        </tr>			
		<tr>
            <td align="left">
				<div id="visualization" style="width: 858px; height: 250px;"></div>
			</td>
        </tr>
		<?php } ?>
			</table>
			  </form>
			</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include SERVER_ADMIN_ROOT."include/footer.php"; ?>
<script type="text/javascript">
jQuery.noConflict();
jQuery(document).ready(function(){
	jQuery('#txtdatefrom').datepicker({
    });
	jQuery('#txtdateto').datepicker({
    });
});
</script>