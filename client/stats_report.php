<?php	
require_once 'include/general_includes.php';
$objTopClient = new topclientreport();

// check if user is logged in.
$cmn->isAuthorized("index.php", ADMIN_USER_ID);
$userID = $cmn->getSession(ADMIN_USER_ID);

$objClient = new client();
$client_id = $objClient->fieldValue("client_id",$userID);
	
$objEncDec = new encdec();
$objpaging = new paging();

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
$condition='';
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
	
$condition .= " and ".REPORT_DB_PREFIX."rpt_page_hit.client_id=".$client_id;	
$objTopClient->pagingType ="hitreport";
$objpaging->strorderby = "tot_cnt";
$objpaging->strorder = "desc";
$pagedata = $objpaging->setPageDetails($objTopClient,"stats_report.php",PAGESIZE,$condition);

// extra css and js
$extraCss = array("ui-lightness/jquery-ui-1.8.4.custom.css","calendar.css");	
$extraJs = array("jquery-ui-timepicker-addon.min.js","googleapi.js");
?>
<?php
include SERVER_CLIENT_ROOT."include/header.php";
include SERVER_CLIENT_ROOT."include/top.php";
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
<script type="text/javascript">
      google.load('visualization', '1', {packages: ['corechart']});
    </script>
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
     /*  data.addColumn('string', 'Pages');
        data.addColumn('number', 'Hits');
        
		data.addRow(["Home", 8]);
        data.addRow(["About US", 31]);
       */ 
		
	 data.addColumn('string', 'Pages');
        data.addColumn('number', 'Hits');
    <?php for($i=0;$i<count($pagedata);$i++){if($pagedata[$i]['page_name']=='') echo 'data.addRow(["Home",'.$pagedata[$i]['tot_cnt'].']);'; else echo 'data.addRow(["'.$pagedata[$i]['page_name'].'",'.$pagedata[$i]['tot_cnt'].']);'; }?>
        // Create and draw the visualization.
        new google.visualization.ColumnChart(document.getElementById
		('visualization')).
            draw(data, {curveType: "function",
                        width: chartwidth, height: 250, chartArea:{left: 70, width:chartareawidth},
                         vAxis: {title: 'Hits', titleTextStyle: {color: 'black'}},
						hAxis: {title: 'Pages', titleTextStyle: {color: 'black'}}});
    }
	google.setOnLoadCallback(drawVisualization);
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
                    <div class="fleft">Hits Report</div>
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
		<td width="100%" align="left">
		<table width="100%" cellpadding="0" cellspacing="0" class="listtab-rt-bro1">
			<tbody>
				<tr>
					<td width="78%" align="left" valign="middle" height="40">
					<strong>Date From</strong>
					&nbsp;
					<input type="text" value="<?php echo $txtdatefrom;?>" class="reprot-input" name="txtdatefrom" id="txtdatefrom"/>&nbsp;<img src="<?php echo SERVER_ADMIN_HOST?>images/Calender.png" border="0" onClick="javascript:document.getElementById('txtdatefrom').focus();">
					&nbsp;&nbsp;&nbsp;
					<strong>Date To</strong>
					&nbsp;
					<input type="text" value="<?php echo $txtdateto;?>" class="reprot-input" name="txtdateto" id="txtdateto"/>
					&nbsp;<img src="<?php echo SERVER_ADMIN_HOST?>images/Calender.png" border="0" onClick="javascript:document.getElementById('txtdateto').focus();">
					&nbsp;&nbsp;&nbsp;
						<input type="submit"  class="btn" value="Search" name="btnsearch" id="btnsearch"/>
		&nbsp;<input type="button" class="btn" value="Clear" name="btnclear" id="btnclear" onclick="javascript:document.location.href='stats_report.php';"/>
					</td>
					<td width="22%" align="right" valign="middle">
					<?php if(count($pagedata)>0) { ?>
					<input type="button" class="btn" value="Export to Excel" name="btnclear" id="exprot-btn" onclick="javascript:document.frm.action='stats_report_export.php';document.frm.submit(); document.frm.action='';">
					<?php } ?>
					</td>
				</tr>
			</tbody>
		</table>
	</td>
</tr>
</table>
<table cellpadding="0" cellspacing="0" border="0" class="listtab" width="100%" style="clear:both;" >
	<tr bgcolor="#a9cdf5" class="txtbo">
		<td width="20%" align="left">
			<strong>Page</strong><?php //$objpaging->_sortImages("page_name", $cmn->getCurrentPageName()); ?>
		</td>                            
		<td width="80%" align="left" class="listtab-rt-bro-user">
			<strong>Total Hits </strong><?php //$objpaging->_sortImages("tot_cnt", $cmn->getCurrentPageName()); ?>
		</td>
	</tr>
	<?php 
	if(count($pagedata)>0)
	{
	for($i=0;$i<count($pagedata);$i++){?>									  
	<tr class="row01" onmouseover="this.className='rowActive'" onmouseout="this.className='row01'">
		<td align="left">
			<?php if($pagedata[$i]['page_name']=='') echo "Home"; else echo $pagedata[$i]['page_name']?>
		</td>
		<td align="left" class="listtab-rt-bro-user">
			<?php echo $pagedata[$i]['tot_cnt']?>
		</td>
	</tr>
  <?php }}else{?>
  <tr class="row01" onmouseover="this.className='rowActive'" onmouseout="this.className='row01'">
		<td  colspan=2 class="listtab-rt-bro-user" align='center'>No Records Found.</td></tr>

  <?php }?>
</table><br />
		<div class="fclear"></div>
    </div>
	</td>
    </tr>
    <tr>
		<td><?php //include "include/pager.php";?></td>
    </tr>
    </form>
	<?php 
	if(count($pagedata)>0)
	{
	?>
	<tr>
		<td colspan="7" align="left"><div id="visualization" style="width: 800px; height: 250px;"></div></td>
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
<script type="text/javascript">
jQuery.noConflict();
jQuery(document).ready(function(){
	jQuery('#txtdatefrom').datepicker({
    });
	jQuery('#txtdateto').datepicker({
    });
});
</script>
<?php include "include/footer.php";?>