<?php	
require_once 'include/general_includes.php';
$objTopClient = new topclientreport();

// check if client is logged in.
$cmn->isAuthorized("index.php", ADMIN_USER_ID);
$userID = $cmn->getSession(ADMIN_USER_ID);

$objClient = new client();
$client_id = $objClient->fieldValue("client_id",$userID);

$objTopClient = new topclientreport();
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

$sourcedata=$objTopClient->topresourcedetail($frmdate,$todate,$client_id);
arsort($sourcedata[0]);
$datedata=$objTopClient->datewisedetail($frmdate,$todate,'',$client_id);

$noofpages=ceil(count($datedata)/10);
$currentpage=1;

$extraCss = array("ui-lightness/jquery-ui-1.8.4.custom.css","calendar.css");	
$extraJs = array("jquery-ui-timepicker-addon.min.js","googleapi.js");
?>
<?php
include SERVER_CLIENT_ROOT."include/header.php";
include SERVER_CLIENT_ROOT."include/top.php";

if(count($datedata) > 0) {
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
</script>
<script type="text/javascript">
      function drawVisualization() {
        // Create and populate the data table.
        var data = new google.visualization.DataTable();
      
data.addColumn('string', 'Year');
 
		 data.addColumn('number', 'Facebook');
		 data.addColumn('number', 'Gadget');
		 data.addColumn('number', 'Website');
		 data.addColumn('number', 'Mobile');
		 
		<?php
			if(count($datedata)>10)
				$loop=10;
			else
				$loop=count($datedata);
				
		for($i=0;$i<$loop;$i++)
		{ 
			$dt=explode("-",$datedata[$i]['reg_date']);
			$regdate=$dt[1]."/".$dt[2]."/".$dt[0];
		echo 'data.addRow(["'.$regdate.'",'.$datedata[$i]['tot_cnt_facebook'].','.$datedata[$i]['tot_cnt_gadget'].','.$datedata[$i]['tot_cnt_website'].','.$datedata[$i]['tot_cnt_mobile'].']);';
		}?>
		
             
        // Create and draw the visualization.
        new google.visualization.AreaChart(document.getElementById('visualization')).
            draw(data, {curveType: "function",
                        width: chartwidth, height: 250, pointSize:4, chartArea:{left: 70, width:chartareawidth},
                      vAxis: {title: 'Registrants', titleTextStyle: {color: 'black'}}, 
						hAxis: {maxValue:10}
			}
                );
      }
      function drawVisualization1() {
        // Create and populate the data table.
			var data = new google.visualization.DataTable();
			data.addColumn('string', 'Year');
      
		 data.addColumn('number', 'Facebook');
		 data.addColumn('number', 'Gadget');
		 data.addColumn('number', 'Website');
		 data.addColumn('number', 'Mobile');
		 

         <?php 			if(count($datedata)>10)
				$loop=10;
			else
				$loop=count($datedata);
		for($i=0;$i<$loop;$i++)
		{ 
			$dt=explode("-",$datedata[$i]['reg_date']);
			if($i==0)
				$regdatestart=$dt[1]."/".$dt[2]."/".$dt[0];
			$regdate=$dt[1]."/".$dt[2]."/".$dt[0];
		
		echo 'data.addRow(["'.$regdate.'",'.$datedata[$i]['tot_cnt_facebook'].','.$datedata[$i]['tot_cnt_gadget'].','.$datedata[$i]['tot_cnt_website'].','.$datedata[$i]['tot_cnt_mobile'].']);';
		}?>

        // Create and draw the visualization.
        new google.visualization.ColumnChart(document.getElementById('visualization1')).
            draw(data, {curveType: "function",	
						width: chartwidth, height: 250, chartArea:{left: 70, width:chartareawidth},
                        vAxis: {title: 'Registrants', titleTextStyle: {color: 'black'}}, 
						hAxis: {maxValue:10,maxAlternation:2}
}
                );
      }
	  google.setOnLoadCallback(drawVisualization);
	   google.setOnLoadCallback(drawVisualization1);

function next(str,noofpages,flag)
{
	
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
			eval(response);
			//res=response.split("|^^|");
			if(flag==1)
			{
				var currentpage=document.getElementById('currentpage').value;
				eval(response);
				var curpage=eval(currentpage)+1;
				//alert(curpage);
				document.getElementById('currentpage').value=curpage;
				document.getElementById('paging1').innerHTML=curpage+"/"+noofpages;
			//	alert(noofpages+"=="+curpage);
				if(noofpages==curpage)
					document.getElementById("next1").innerHTML='&nbsp;<img src="../images/next-gery-arrow.jpg" width="14" height="11" alt="Next">&nbsp;';
				if(curpage>1)	
					document.getElementById("prev1").innerHTML='&nbsp;<img src="../images/prev-blue-arrow.jpg" width="14" height="11" alt="prev" onclick="return prev(\'<?php echo $regdate;?>\',\'<?php echo $noofpages;?>\',1)" style="cursor:pointer;" >&nbsp;';
				if(noofpages>curpage)	
					document.getElementById("next1").innerHTML='&nbsp;<img src="../images/next-blue-arrow.jpg" width="14" height="11" alt="Next"  onclick="return next(\''+res[1]+'\',<?php echo $noofpages;?>,1)" style="cursor:pointer;">&nbsp;';
				
			}
			else
			{
				var currentpage2=document.getElementById('currentpage2').value;
				eval(response);
				var curpage2=eval(currentpage2)+1;
				//alert(curpage);
				document.getElementById('currentpage2').value=curpage2;
				document.getElementById('paging2').innerHTML=curpage2+"/"+noofpages;
			//	alert(noofpages+"=="+curpage2);
				if(curpage2>1)	
					document.getElementById("prev2").innerHTML='&nbsp;<img src="../images/prev-blue-arrow.jpg" width="14" height="11" alt="prev" onclick="return prev(\'<?php echo $regdate;?>\',\'<?php echo $noofpages;?>\',2)" style="cursor:pointer;" >&nbsp;';
				if(noofpages==curpage2)
				{
					//alert("IN");
					document.getElementById("next2").innerHTML='&nbsp;<img src="../images/next-gery-arrow.jpg" width="14" height="11" alt="NEXT">&nbsp;';
				}
				if(noofpages>curpage)	
					document.getElementById("next2").innerHTML='&nbsp;<img src="../images/next-blue-arrow.jpg" width="14" height="11" alt="Next"  onclick="return next(\''+res[1]+'\',<?php echo $noofpages;?>,1)" style="cursor:pointer;">&nbsp;';
			}
		}
	}
  
xmlhttp.open("GET","getdatereport.php?txtdatefrom="+str+"&flag="+flag,true);

xmlhttp.send();
}
function prev(str,noofpages,flag)
{
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
			if(flag==1)
			{
				var currentpage=document.getElementById('currentpage').value;
				eval(response);
				var curpage=eval(currentpage)-1;
				//alert("--ww"+curpage);
				document.getElementById('currentpage').value=curpage;
				document.getElementById('paging1').innerHTML=curpage+"/"+noofpages;
				//	alert(noofpages+"=="+curpage);
				if(curpage==1)
					document.getElementById("prev1").innerHTML='&nbsp;<img src="../images/prev-grey-arrow.jpg" width="14" height="11" alt="prev">&nbsp;';
				if(noofpages>curpage)
					document.getElementById("next1").innerHTML='&nbsp;<img src="../images/next-blue-arrow.jpg" width="14" height="11" alt="Next"  onclick="return next(\'<?php echo $regdate;?>\',<?php echo $noofpages;?>,1)" style="cursor:pointer;">&nbsp;';
			}
			else
			{
				var currentpage2=document.getElementById('currentpage2').value;
				eval(response);
				var curpage2=eval(currentpage2)-1;
				//alert("--ww"+curpage);
				document.getElementById('currentpage2').value=curpage2;
				document.getElementById('paging2').innerHTML=curpage2+"/"+noofpages;
				//	alert(noofpages+"=="+curpage);
				if(curpage2==1)
					document.getElementById("prev2").innerHTML='&nbsp;<img src="../images/prev-grey-arrow.jpg" width="14" height="11" alt="prev">&nbsp;';
				if(noofpages>curpage2)
					document.getElementById("next2").innerHTML='&nbsp;<img src="../images/next-blue-arrow.jpg" width="14" height="11" alt="Next"  onclick="return next(\'<?php echo $regdate;?>\',<?php echo $noofpages;?>,2)" style="cursor:pointer;">&nbsp;';	
			}
		}
	}
xmlhttp.open("GET","getdatereport_prev.php?txtdatefrom="+str+"&flag="+flag,true);
xmlhttp.send();
}
</script>
<?php } ?>
  <div class="content_mn"> 
    <div class="content_mn2">
      <div class="cont_mid">
        <div class="cont_lt">
          <div class="cont_rt">
            <div class="user_tab_mn">
              <div class="blue_title">
                <div class="blue_title_lt">
                  	<div class="blue_title_rt">
                    <div class="fleft">Daily Usage Report</div>
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
									<input type="hidden" value="1" name="currentpage2" id="currentpage2">
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
                                                    &nbsp;<img src="<?php echo SERVER_ADMIN_HOST?>images/Calender.png" border="0" onClick="javascript:document.getElementById('txtdateto').focus();">&nbsp;&nbsp;&nbsp;<input type="submit"  class="btn" value="Search" name="btnsearch" id="btnsearch"/>
                                                      &nbsp;
                                                    <input type="button" class="btn" value="Clear" name="btnclear" id="btnclear" onclick="javascript:document.location.href='date_wise_report.php';"/></td>
                                                    <td width="22%" align="right" valign="middle">
													<?php if(count($datedata) > 0) { ?>
													<input type="button" class="btn" value="Export to Excel" name="btnclear" id="exprot-btn" onclick="javascript:document.frm.action='date_wise_report_export.php';document.frm.submit(); javascript:document.frm.action='';"/>
													<?php } ?>
													</td>
                                                  </tr>
                                                </tbody>
                                              </table></td>
                                            </tr>
                                          </table>
										
                                        
                                            <div class="fclear"></div>
                                        </div></td>
                                      </tr>
									  <tr>&nbsp;</tr>
									  <tr><table cellpadding="0" cellspacing="0" border="0"  width="100%" style="clear:both;" >
                                              
                                              <tr  class="txtbo">
                                             <td width="20%" align="left" style="padding-left:11px; padding-top:5px; " class="section-title" ><strong> Summary</strong></td>
                                              </tr></table></tr>
											  <tr bgcolor="#FFFFFF">
                                          <table cellpadding="0" cellspacing="0" border="0" class="listtab" width="100%" style="clear:both;" >
                                              
                                              <tr bgcolor="#a9cdf5" class="txtbo">
                                             <td width="20%" align="left"><strong>Source</strong></td>                            
                                                <td width="80%" align="left" class="listtab-rt-bro-user"><strong>Total Registration</strong></td>
                                            </tr>
											 <?php 
											  $keys= array_keys($sourcedata[0]);
											  for($i=0;$i<count($sourcedata[0]);$i++)
											  {
													if($i%2==0)
													{
											  ?>
                                              <tr class="row01" onmouseover="this.className='rowActive'" onmouseout="this.className='row01'">
											  <?php }else{?>
											   <tr class="row02" onmouseover="this.className='rowActive'" onmouseout="this.className='row02'">
											   <?php }?>
											  <?php if($keys[$i]=='tot_cnt_api')
											  {
												$resource="API";
											  }
											  else if($keys[$i]=='tot_cnt_gadget')
											  {
												$resource="Gadget";
											  }
											 else if($keys[$i]=='tot_cnt_facebook')
											  {
												$resource="Facebook";
											  }
											  else if($keys[$i]=='tot_cnt_website')
											  {
												$resource="Website";
											  }
											  else if($keys[$i]=='tot_cnt_mobile')
											  {
												$resource="Mobile";
											  }
											  ?>
                                                <td align="left"><?php echo $resource;?></td>
												
                                                <td align="left" class="listtab-rt-bro-user"><?php if($sourcedata[0][$keys[$i]]>0)echo $sourcedata[0][$keys[$i]];else echo 0; ?></td>
                                              </tr>
											  <?php }?>
                                          </table></tr>
                                    </form>
									
									<?php if(count($datedata) > 0) { ?>
                                    <tr>
                                      <td colspan="8" align="left"><table cellpadding="0" cellspacing="0" border="0"  width="100%" style="clear:both;" >
                                              
                                              <tr  class="txtbo">
                                             <td width="20%" align="left" style="padding-left:11px; padding-top:20px;" class="section-title" ><strong> Day By Day Analysis Charts </strong></td>
                                              </tr></table></td>
                                    </tr>
                                    <tr>
                    					<td colspan="8" align="left">
										<div class="next-prev-block-title">Area Chart</div>
                                        <?php if($noofpages > 1) { ?>
										<div class="next-prev-block">
										
       	 <ul>
      	  <li id="prev1"><img src="../images/prev-grey-arrow.jpg" width="14" height="11" alt="prev" onclick="return prev('<?php echo $noofpages;?>',<?php echo $noofpages;?>,1)" style="cursor:pointer;" id="areaprev" /></li>
       	  <li id="paging1">&nbsp;<?php echo $currentpage;?>/<?php echo $noofpages;?>&nbsp;</li>
       	  <li id="next1"><img src="../images/next-blue-arrow.jpg" width="14" height="11" alt="prev" onclick="return next('<?php echo $regdate;?>',<?php echo $noofpages;?>,1)" style="cursor:pointer;" id="areanext" /></li>
       	 </ul>
        </div>
		<?php } ?>
                                        <div id="visualization" style="width: 858px; height: 250px; border-top:0px;">                                        </div>        </td>
                  					</tr>
									<tr><td>&nbsp;</td></tr>
									 <tr>
                    					<td bgcolor="#FFFFFF"  colspan="8" align="left">
										<div class="next-prev-block1-title">Column Chart</div>
										<?php if($noofpages > 1) { ?>
                                        <div class="next-prev-block1">
       	 <ul>
      	  <li id="prev2"><img src="../images/prev-grey-arrow.jpg" width="14" height="11" alt="prev" onclick="return prev('<?php echo $regdatestart;?>',<?php echo $noofpages;?>,2)" style="cursor:pointer;" id="areaprev" /></li>
       	  <li id="paging2">&nbsp;<?php echo $currentpage;?>/<?php echo $noofpages;?>&nbsp;</li>
       	  <li id="next2"><img src="../images/next-blue-arrow.jpg" width="14" height="11" alt="prev" onclick="return next('<?php echo $regdate;?>',<?php echo $noofpages;?>,2)" style="cursor:pointer;" id="areanext" /></li>
       	 </ul>
        </div>
		<?php } ?>
        <div id="visualization1" style="width: 858px; height: 250px; background-color:#FFFFFF"></div></td>
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