<?php
//include base file
require_once 'include/general_includes.php';
	
//check admin login authentication
$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);

//create class obj	
$objTopClient = new topclientreport();

//check registration date for searching criteria
$txtdatefrom='';
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
//fetch most active time for given date default current date	
$ActiveTime=$objTopClient->mostactivetimereport($frmdate);
arsort($ActiveTime);
//END

//include JS and CSS files
$extraCss = array("calendar.css");
$extraJs = array("jquery-ui-timepicker-addon.min.js,JQuery.js");
include SERVER_ADMIN_ROOT."include/header.php";
include SERVER_ADMIN_ROOT."include/top.php";

if($ActiveTime[0]['tot_cnt'] > 0) {
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

function drawVisualization() {
	// Create and populate the data table.
	var data = new google.visualization.DataTable();
	/*data.addColumn('string', 'x');
	data.addColumn('number', 'Midnight To 7Am');
	data.addColumn('number', '7AM to 10AM');
	data.addColumn('number', '10AM to Noon');
	data.addRow(["5", 8, 40, 20]);
	data.addRow(["10", 31,5,0]);
	data.addRow(["15", 62,6,2]);
	data.addRow(["20", 46,0,50]);  
	data.addRow(["25", 40,0,25]);  
	data.addRow(["30", 73,10,1]);  

	// Create and draw the visualization.
	new google.visualization.LineChart(document.getElementById('visualization')).
		draw(data, {curveType: "function",
					width: 878, height: 250,
					vAxis: {maxValue: 10}}
			);
  }*/
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
	echo 'data.addRow(["'.$resource.'",'.$tnt.']);';
}
	?>  
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
                  <div class="fleft">&nbsp;Most Active Times of the Day</div>
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
						<td width="78%" align="left" valign="middle"><strong>Date </strong>&nbsp;<input type="text" value="<?php echo $txtdatefrom;?>" class="reprot-input" name="txtdatefrom" id="txtdatefrom" readonly="readonly"/>
						 <img src="images/Calender.png" border="0" onClick="javascript:document.getElementById('txtdatefrom').focus();">
						&nbsp;&nbsp;&nbsp;		
						<input type="submit"  class="btn" value="Search" name="btnsearch" id="btnsearch"/>
						&nbsp;				
						<input type="button" class="btn" value="Clear" name="btnclear" id="btnclear" onclick="javascript:document.location.href='reports_most_active_times_of_days.php';" />
						</td>			   
						<td width="22%" height="40" align="right" valign="middle">&nbsp;
						<input type="button" class="btn" value="Export to Excel" name="btnexport" id="btnexport" onclick="javascript:document.frm.action='export_most_active_time.php';document.frm.submit(); document.frm.action='';"/></td>		
			  
			  </tr>
			</tbody>
		  </table>
		  </form>		  
		  </td>
			</tr>
		  
                                            
				<tr bgcolor="#a9cdf5" class="txtbo">
				  <td width="20%" align="left"><strong>Time
				  </strong></td>
				  <td width="80%" align="left" class="listtab-rt-bro-user"><strong>Total Registration</strong></td>
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
				</table></td>
        </tr>	
		<tr>
            <td align="left">&nbsp;</td>
        </tr>		
		<tr>
			<?php if($ActiveTime[0]['tot_cnt'] > 0) { ?>
			<td align="left">
				<div id="visualization" style="width: 858px; height: 250px;"></div>
			</td>
			<?php } ?>            
        </tr>
			</table>			  
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

});
</script>