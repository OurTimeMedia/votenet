<?php	
require_once 'include/general_includes.php';
$objTopClient = new topclientreport();

// check if user has logged in
$cmn->isAuthorized("index.php", ADMIN_USER_ID);
$userID = $cmn->getSession(ADMIN_USER_ID);
$objClient = new client();
$client_id = $objClient->fieldValue("client_id",$userID);

$objpaging = new paging();
$currentpage=1;
//print_r($_POST);
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
if(isset($_POST['noofdays']) && $_POST['noofdays']!='')
	$noofdays =$_POST['noofdays'];
else	
	$noofdays = 5;
$objTopClient->pagingType = "activedays";
$objpaging->strorderby = "tot_cnt";
$objpaging->strorder = "desc";
$ActiveDays = $objpaging->setPageDetails($objTopClient,"usage_statistics_report.php",PAGESIZE,$condition,'','',$noofdays);

$displaydays = 5;
$noofpages = ceil(count($ActiveDays)/$displaydays);

// extra css and js
$extraCss = array("ui-lightness/jquery-ui-1.8.4.custom.css","calendar.css");
$extraJs = array("jquery-ui-timepicker-addon.min.js","googleapi.js");
include SERVER_CLIENT_ROOT."include/header.php";
include SERVER_CLIENT_ROOT."include/top.php";

if(count($ActiveDays)>0){
?>
<script type="text/javascript" src="js/googleapi.js"></script>
<script type="text/javascript">
var chartwidth = 880;
var chartareawidth = 685;

if(document.documentElement.offsetWidth > 1024)
{
	chartwidth = document.documentElement.offsetWidth - 150;
	chartareawidth = chartwidth - 200;
}    
google.load('visualization', '1', {packages: ['corechart']});
	  
function drawVisualization() {
    // Create and populate the data table.
	var data = new google.visualization.DataTable();
    data.addColumn('string', 'Date');
    data.addColumn('number', 'Registration');
    <?php
	if(count($ActiveDays)>=$displaydays)
	$dis=$displaydays;
	else
	$dis=count($ActiveDays);
	for($i=0;$i<$dis;$i++)
	{
		$dt=explode("-",$ActiveDays[$i]['reg_date']);
			if($i==0)
				$regdatestart=$dt[1]."/".$dt[2]."/".$dt[0];
			$regdate=$dt[1]."/".$dt[2]."/".$dt[0];
		echo "data.addRow(['".$regdate."',".$ActiveDays[$i]['tot_cnt']."]);";
    }
	?>
        // Create and draw the visualization.
        new google.visualization.ColumnChart(document.getElementById('visualization')).
            draw(data, {curveType: "function",
                        width: chartwidth, height: 230, chartArea:{left: 70, width:chartareawidth},
                        vAxis: {title: 'Registrations', titleTextStyle: {color: 'black'}},
						hAxis: {title: 'Dates', titleTextStyle: {color: 'black'}}}
                );
      }
  	  google.setOnLoadCallback(drawVisualization);
	function next(date)
	{
		var currentpage = document.getElementById('currentpage').value;
		var noofpages = <?php echo $noofpages;?>;
		var noofdays = <?php echo $noofdays;?>;
		var txtdateto=date;
		var txtdatefrom=document.getElementById('txtdatefrom').value;
		if (window.XMLHttpRequest)
		{ // code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				var res;
				var response=xmlhttp.responseText;	//alert(response);
				res=response.split("|^|");
				//alert(res);
				eval(res[0]);
				var curpage=eval(currentpage)+1;
				document.getElementById('currentpage').value=curpage;
				document.getElementById('paging1').innerHTML=curpage+"/"+noofpages;
				//alert(noofpages+"=="+curpage);
				if(noofpages==curpage)
					document.getElementById("next1").innerHTML='<img src="../images/next-gery-arrow.jpg" width="14" height="11" alt="prev">';
				if(curpage>1)	
					document.getElementById("prev1").innerHTML='<img src="../images/prev-blue-arrow.jpg" width="14" height="11" alt="prev" onclick="return prev(\''+res[2]+'\',\'<?php echo $noofpages;?>\',1)" style="cursor:pointer;" >';
				if(noofpages>curpage)	
					document.getElementById("next1").innerHTML='<img src="../images/next-blue-arrow.jpg" width="14" height="11" alt="Next"  onclick="return next(\''+res[1]+'\',<?php echo $noofpages;?>,1)" style="cursor:pointer;">';
			}
		}
		xmlhttp.open("GET","getdaysreport.php?txtdatefrom=<?php echo $regdate;?>&txtdateto="+txtdateto+"&noofdays="+noofdays+"&currentpage="+eval(eval(currentpage)+1),true);
		xmlhttp.send();
	}	 
	function prev(date)
	{
		var currentpage = document.getElementById('currentpage').value;
		var noofpages = <?php echo $noofpages;?>;
		var noofdays = <?php echo $noofdays;?>;
		var txtdateto = document.getElementById('txtdateto').value;
		var txtdatefrom = date;
		if (window.XMLHttpRequest)
		{// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp=new XMLHttpRequest();
		}
		else
		{// code for IE6, IE5
			xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange=function()
		{
			if (xmlhttp.readyState==4 && xmlhttp.status==200)
			{
				var res;
				var response=xmlhttp.responseText;
				res=response.split("|^|");	
			//	alert(res);
				eval(res[0]);
				var curpage=eval(currentpage)-1;
				//alert(curpage);
				document.getElementById('currentpage').value=curpage;
				document.getElementById('paging1').innerHTML=curpage+"/"+noofpages;
				//alert(noofpages+"=="+curpage);
				if(curpage==1)
					document.getElementById("prev1").innerHTML='<img src="../images/prev-grey-arrow.jpg" width="14" height="11" alt="prev">';
				if(noofpages>curpage)
					document.getElementById("next1").innerHTML='<img src="../images/next-blue-arrow.jpg" width="14" height="11" alt="Next"  onclick="return next(\'<?php echo $regdate;?>\',<?php echo $noofpages;?>,1)" style="cursor:pointer;">';
			}
		}
		xmlhttp.open("GET","getdaysreport_prev.php?txtdatefrom="+txtdatefrom+"&txtdateto="+txtdateto+"&noofdays="+noofdays+"&currentpage="+eval(eval(currentpage)-1),true);
		xmlhttp.send();
	}  
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
                    <div class="fleft">Most Active Days Report</div>
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
									<input type="hidden" value="1" name="currentpage" id="currentpage">
									
									<tr>
                                        <td>
                                        <div class="white">
                                          <table cellpadding="5" cellspacing="0" border="0" class="border-none" width="100%" style="clear:both;" >
                                            <tr class="row02">
                                              <td width="100%" align="left"><table width="100%" cellpadding="0" cellspacing="0" class="listtab-rt-bro">
                                                <tbody>
                                                  <tr>
                                                    <td width="78%" align="left" valign="middle" height="40"><strong>Date From</strong>&nbsp;<input type="text" value="<?php echo $txtdatefrom;?>" class="reprot-input" name="txtdatefrom" id="txtdatefrom"/>
			&nbsp;<img src="<?php echo SERVER_ADMIN_HOST?>images/Calender.png" border="0" onClick="javascript:document.getElementById('txtdatefrom').focus();">&nbsp;&nbsp;&nbsp;<strong>Date To</strong>&nbsp;<input type="text" value="<?php echo $txtdateto;?>" class="reprot-input" name="txtdateto" id="txtdateto"/>
                                                    &nbsp;<img src="<?php echo SERVER_ADMIN_HOST?>images/Calender.png" border="0" onClick="javascript:document.getElementById('txtdateto').focus();">&nbsp;&nbsp;&nbsp;Show Top&nbsp;
	<select name="noofdays" id="noofdays">
	  <option value="5" <?php if($noofdays==5) echo "selected";?>>5</option>
	  <option value="10" <?php if($noofdays==10) echo "selected";?>>10</option>
	  <option value="20" <?php if($noofdays==20) echo "selected";?>>20</option>
	  <option value="30" <?php if($noofdays==30) echo "selected";?> >30</option>
	  <option value="50" <?php if($noofdays==50) echo "selected";?>>50</option>
	  </select>
                                                    &nbsp;Days&nbsp;&nbsp;&nbsp;<input type="submit"  class="btn" value="Search" name="btnsearch" id="btnsearch"/>
                                                      &nbsp;
                                                    <input type="button" class="btn" value="Clear" name="btnclear" id="btnclear" onclick="javascript:document.location.href='active_days_report.php';"/></td>
                                                    <td width="22%" align="right" valign="middle">
													<?php if(count($ActiveDays)>0){ ?>
													<input type="button" class="btn" value="Export to Excel" name="btnclear" id="exprot-btn" onclick="javascript:document.frm.action='active_days_report_export.php';document.frm.submit(); document.frm.action='';">
													<?php } ?>
													</td>
                                                  </tr>
                                                </tbody>
                                              </table></td>
                                            </tr>
                                          </table>
										 
                                          <table cellpadding="0" cellspacing="0" border="0" class="listtab" width="100%" style="clear:both;" >
                                            
                                            <tr bgcolor="#a9cdf5" class="txtbo">
                                              <td width="20%" align="left"><strong>Active Days</strong><?php //$objpaging->_sortImages("reg_date", $cmn->getCurrentPageName()); ?></td>
                                              <td width="80%" align="left" class="listtab-rt-bro-user"><strong>Total Registration</strong><?php //$objpaging->_sortImages("tot_cnt", $cmn->getCurrentPageName()); ?></td>
                                            </tr>
											 <?php 
											 if(count($ActiveDays)>0){
											  for($i=0;$i<count($ActiveDays);$i++)
											  {
											  if($i%2==0)
											  {
											  ?>
                                              <tr class="row01" onmouseover="this.className='rowActive'" onmouseout="this.className='row01'">
											  <?php }else{?>
											   <tr class="row02" onmouseover="this.className='rowActive'" onmouseout="this.className='row02'">
											   <?php }?>
                                              <td align="left" width="22%"><?php echo $ActiveDays[$i]['reg_date'];?></td>
                                              <td align="left" width="78%" class="listtab-rt-bro-user"><?php echo $ActiveDays[$i]['tot_cnt'];?></td>
                                            </tr>
											<?php } 
											} else { 
											?>
											<tr class="row01" onmouseover="this.className='rowActive'" onmouseout="this.className='row01'">
													<td colspan='2' align="center" class="listtab-rt-bro-user">No Records Found.</td>
											</tr>
                                            <?php } ?>
                                          </table><br />
                <div class="fclear"></div>
                                        </div></td>
                                      </tr>
                                    </form>
	<?php if(count($ActiveDays)>0){ ?>									
	<tr>
		<td colspan="8" align="left"><div class="next-prev-block-activestate">
		<?php if($noofpages>1){?>
		<ul>
      	  <li id="prev1"><img src="../images/prev-grey-arrow.jpg" width="14" height="11" alt="prev" onclick="return prev('<?php echo $regdatestart;?>',<?php echo $noofpages;?>,1)" style="cursor:pointer;" id="areaprev" /></li>
       	  <li id="paging1">&nbsp;<?php echo $currentpage;?>/<?php echo $noofpages;?>&nbsp;</li>
		
       	  <li id="next1"><img src="../images/next-blue-arrow.jpg" width="14" height="11" alt="prev" onclick="return next('<?php echo $regdate;?>',<?php echo $noofpages;?>,1)" style="cursor:pointer;" id="areanext" /></li>
       	 
	
		 </ul>
		 <?php }?>
		 
        </div><div id="visualization" style="width: 858px; height: 250px;"></div></td>
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
jQuery.noConflict();
jQuery(document).ready(function(){
	jQuery('#txtdatefrom').datepicker({
    });
	jQuery('#txtdateto').datepicker({
    });
});
</script>
</body>
</html>
