<?php
require_once 'include/general_includes.php';
$objTopClient = new topclientreport();

// check if client is logged in.
$cmn->isAuthorized("index.php", ADMIN_USER_ID);
$userID = $cmn->getSession(ADMIN_USER_ID);

$objClient = new client();
$client_id = $objClient->fieldValue("client_id",$userID);

if(isset($_POST['txtdatefrom']) &&  $_POST['txtdatefrom']!='')
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

$ActiveTime=$objTopClient->mostactivetimereport($frmdate,$client_id);
arsort($ActiveTime);

// include extra css and js
$extraCss = array("ui-lightness/jquery-ui-1.8.4.custom.css","calendar.css");	
$extraJs = array("jquery-ui-timepicker-addon.min.js","googleapi.js");
include SERVER_CLIENT_ROOT."include/header.php";
include SERVER_CLIENT_ROOT."include/top.php";

if($ActiveTime[0]['tot_cnt'] > 0) {
?>
<script type="text/javascript" src="js/googleapi.js"></script>
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

   data.addColumn('string', 'Time');
data.addColumn('number', 'Registrations');

<?php 
$keys= array_keys($ActiveTime[0]);

for($i=0;$i<count($ActiveTime[0]);$i++)
{
	if($keys[$i] == 'tot_cnt')
		break;
		
	if($keys[$i]=='cnt_mid_to_7')
	{
		$resource="Midnight To 7AM";
	}
	else if($keys[$i]=='cnt_7_to_10')
	{
		$resource="7AM to 10AM";
	}
	else if($keys[$i]=='cnt_10_to_noon')
	{
		$resource="10AM to Noon";
	}
	else if($keys[$i]=='cnt_noon_to_3')
	{
		$resource="Noon to 3PM";
	}
	else if($keys[$i]=='cnt_3_to_6')
	{
		$resource="3PM to 6PM";
	}
	else if($keys[$i]=='cnt_6_to_mid')
	{
		$resource="6PM to Midnight";
	}
	if($ActiveTime[0][$keys[$i]]>0) $tnt=$ActiveTime[0][$keys[$i]];else $tnt= 0; 
	echo "data.addRow(['".$resource."',".$tnt."]);";
}
	?>
  /*['Midnight To 7Am',1001],
  ['7AM to 10AM',500],
  ['10AM to Noon',5000],
  ['Noon to 6PM',15000],
  ['6PM to Midnight',10000],*/

	// Create and draw the visualization.
	new google.visualization.ColumnChart(document.getElementById('visualization')).
		draw(data, {curveType: "function",
					width: chartwidth, height: 250, chartArea:{left: 70, width:chartareawidth},
					vAxis: {title: 'Registrations', titleTextStyle: {color: 'black'}},
					hAxis: {title: 'Time', titleTextStyle: {color: 'black'}}}
			);
  }
  google.setOnLoadCallback(drawVisualization);
</script>
<?php } ?>

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
                    <div class="fleft">Most Active Times Of The Day Report</div>
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
                                        <td>
                                        <div class="white">
                                          <table cellpadding="5" cellspacing="0" border="0" class="border-none" width="100%" style="clear:both;" >
                                            <tr class="row02">
                                              <td width="100%" align="left"><table width="100%" cellpadding="0" cellspacing="0" class="listtab-rt-bro">
                                                <tbody>
                                                  <tr>
                                                    <td width="9%" align="left" valign="middle"><strong>Select Date</strong></td>
                                                    <td width="16%" valign="middle"><input type="text" value="<?php echo $txtdatefrom;?>" class="reprot-input" name="txtdatefrom" id="txtdatefrom"/>
                                                      &nbsp;<img src="<?php echo SERVER_ADMIN_HOST?>images/Calender.png" border="0" onClick="javascript:document.getElementById('txtdatefrom').focus();"></td>
                                                    <td width="35%" height="40" valign="middle"><input type="submit"  class="btn" value="Search" name="btnsearch" id="btnsearch"/>
                                                      &nbsp;
                                                   <input type="button" class="btn" value="Clear" name="btnclear" id="btnclear" onclick="javascript:document.location.href='active_times_report.php';"/></td>
                                                    <td width="40%" align="right" valign="middle"><input type="button" class="btn" value="Export to Excel" name="btnclear" id="exprot-btn" onclick="javascript:document.frm.action='active_times_export_report.php?txtdatefrom=<?php echo $frmdate;?>';document.frm.submit(); document.frm.action='';"/></td>
                                                  </tr>
                                                </tbody>
                                              </table></td>
                                            </tr>
                                          </table>
                                          <table cellpadding="0" cellspacing="0" border="0" class="listtab" width="100%" style="clear:both;" >
                                              
                                              <tr bgcolor="#a9cdf5" class="txtbo">
                                             <td width="19%" align="left"><strong>Timings</strong></td>                            
                                                <td width="81%" align="left" class="listtab-rt-bro-user"><strong>Total Registration</strong></td>
                                            </tr>
                                              <?php 
											  $keys= array_keys($ActiveTime[0]);
											  for($i=0;$i<count($ActiveTime[0]);$i++)
											  {
											  if($keys[$i]!='tot_cnt')
											  {
											  if($i%2==0)
											  {
											  ?>
                                              <tr class="row01" onmouseover="this.className='rowActive'" onmouseout="this.className='row01'">
											  <?php }else{?>
											   <tr class="row02" onmouseover="this.className='rowActive'" onmouseout="this.className='row02'">
											   <?php }?>
											  <?php if($keys[$i]=='cnt_mid_to_7')
											  {
												$resource="Midnight To 7AM";
											  }
											  else if($keys[$i]=='cnt_7_to_10')
											  {
												$resource="7AM to 10AM";
											  }
											 else if($keys[$i]=='cnt_10_to_noon')
											  {
												$resource="10AM to Noon";
											  }
											  else if($keys[$i]=='cnt_noon_to_3')
											  {
												$resource="Noon to 3PM";
											  }
											  else if($keys[$i]=='cnt_3_to_6')
											  {
												$resource="3PM to 6PM";
											  }
											  else if($keys[$i]=='cnt_6_to_mid')
											  {
												$resource="6PM to Midnight";
											  }
											  ?>
                                                <td align="left"><?php echo $resource;?></td>
												
                                                <td align="left" class="listtab-rt-bro-user"><?php if($ActiveTime[0][$keys[$i]]>0)echo $ActiveTime[0][$keys[$i]];else echo 0; ?></td>
                                              </tr>
											  <?php }} ?>
											  
											                        
                                          </table><br />

                                            <div class="fclear"></div>
                                        </div></td>
                                      </tr>
                                    </form>
									<?php if($ActiveTime[0]['tot_cnt'] > 0) { ?>
                                    <tr>
                    					<td colspan="8" align="left"><div id="visualization" style="width: 858px; height: 250px;"></div></td>
                  					</tr>
									<?php } ?>
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
	document.getElementById('ui-datepicker-div').style.display='none';
});
jQuery(document).ready(function(){
	jQuery('#txtdateto').datepicker({
    });
	document.getElementById('ui-datepicker-div').style.display='none';	
});
</script>