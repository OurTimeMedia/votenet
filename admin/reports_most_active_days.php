<?php
//include base file
require_once 'include/general_includes.php';
	
//check admin login authentication
$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);

//create class obj	
$objpaging = new paging();
$objTopClient = new topclientreport();

//variable define
$condition = "";
$currentpage=1;

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
//generate conditions
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

// total no of pages
if(isset($_POST['noofdays']) && $_POST['noofdays']!='')
	$noofdays =$_POST['noofdays'];
else	
	$noofdays = 5;

//fetch most active days in given ranage or 	
$objTopClient->pagingType = "activedays";
$objpaging->strorderby = "tot_cnt";
$objpaging->strorder = "desc";
$mostActiveDays = $objpaging->setPageDetails($objTopClient,"reports_most_active_days.php",-1,$condition,'','',$noofdays);
//END

//
$displaydays = 5;
$noofpages = ceil(count($mostActiveDays)/$displaydays);


$extraJs = array("jquery-ui-timepicker-addon.min.js");
$extraCss = array("calendar.css");

include SERVER_ADMIN_ROOT."include/header.php";
include SERVER_ADMIN_ROOT."include/top.php";

if(count($mostActiveDays)>0){
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
    data.addColumn('string', 'date');
    data.addColumn('number', 'Registration');
    <?php
	if(count($mostActiveDays)>=$displaydays)
	$dis=$displaydays;
	else
	$dis=count($mostActiveDays);
	for($i=0;$i<$dis;$i++)
	{
		$dt=explode("-",$mostActiveDays[$i]['reg_date']);
			if($i==0)
				$regdatestart=$dt[1]."/".$dt[2]."/".$dt[0];
			$regdate=$dt[1]."/".$dt[2]."/".$dt[0];
		echo 'data.addRow(["'.$regdate.'",'.$mostActiveDays[$i]['tot_cnt'].']);';
    }
	?>
        // Create and draw the visualization.
        new google.visualization.ColumnChart(document.getElementById('visualization')).
            draw(data, {curveType: "function",
                        width: chartwidth, height: 250, chartArea:{left: 70, width:chartareawidth},
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
					document.getElementById("next1").innerHTML='<img src="images/next-gery-arrow.jpg" width="14" height="11" alt="prev">';
				if(curpage>1)	
					document.getElementById("prev1").innerHTML='<img src="images/prev-blue-arrow.jpg" width="14" height="11" alt="prev" onclick="return prev(\''+res[2]+'\',\'<?php echo $noofpages;?>\',1)" style="cursor:pointer;" >';
				if(noofpages>curpage)	
					document.getElementById("next1").innerHTML='<img src="images/next-blue-arrow.jpg" width="14" height="11" alt="Next"  onclick="return next(\''+res[1]+'\',<?php echo $noofpages;?>,1)" style="cursor:pointer;">';
			}
		}
		xmlhttp.open("GET","getdaysreport.php?txtdatefrom="+date+"&txtdateto=<?php echo $txtdateto;?>&noofdays="+noofdays+"&currentpage="+eval(eval(currentpage)+1),true);
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
					document.getElementById("prev1").innerHTML='<img src="images/prev-grey-arrow.jpg" width="14" height="11" alt="prev">';
				if(noofpages>curpage)
					document.getElementById("next1").innerHTML='<img src="images/next-blue-arrow.jpg" width="14" height="11" alt="Next"  onclick="return next(\'<?php echo $regdate;?>\',<?php echo $noofpages;?>,1)" style="cursor:pointer;">';
			}
		}
		xmlhttp.open("GET","getdaysreport_prev.php?txtdatefrom="+txtdatefrom+"&txtdateto="+txtdateto+"&noofdays="+noofdays+"&currentpage="+eval(eval(currentpage)-1),true);
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
           <?php $msg->displayMsg(); ?> 
            <div class="blue_title">
              <div class="blue_title_lt">
                <div class="blue_title_rt">
                  <div class="fleft">&nbsp;Most Active Days</div>
                  <div class="fright">&nbsp;</div>
                </div>
              </div>
            </div>           
            <div class="blue_title_cont">
			<table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                  <td><div>
			<table cellpadding="0" cellspacing="0" border="0" class="listtab" width="100%" style="clear:both;" >
			<tr><td colspan="2" align="left">
			<form name="frm" id="frm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="javascript: return validate();">		
			<input type="hidden" value="1" name="currentpage" id="currentpage">			
			<table width="100%" cellpadding="0" cellspacing="0" class="listtab-rt-bro">
			<tbody>
			  <tr>
				<td width="78%" align="left" valign="middle"><strong>Date From</strong>&nbsp;<input type="text" value="<?php echo $txtdatefrom;?>" class="reprot-input" name="txtdatefrom" id="txtdatefrom" readonly="readonly"/>
				 <img src="images/Calender.png" border="0" onClick="javascript:document.getElementById('txtdatefrom').focus();">
				 &nbsp;&nbsp;&nbsp;
				 <strong>Date To</strong>&nbsp;<input type="text" value="<?php echo $txtdateto;?>" class="reprot-input" name="txtdateto" id="txtdateto" readonly="readonly"/>
				<img src="images/Calender.png" border="0" onClick="javascript:document.getElementById('txtdateto').focus();">
				&nbsp;&nbsp;&nbsp;
				<strong>Show Top</strong>&nbsp;<select name="noofdays" id="noofdays" style="width:50px;">
	  <option value="5" <?php if($noofdays==5) echo "selected";?>>5</option>
	  <option value="10" <?php if($noofdays==10) echo "selected";?>>10</option>
	  <option value="20" <?php if($noofdays==20) echo "selected";?>>20</option>
	  <option value="30" <?php if($noofdays==30) echo "selected";?> >30</option>
	  <option value="50" <?php if($noofdays==50) echo "selected";?>>50</option>
	  </select>&nbsp;Days
				&nbsp;&nbsp;
				<input type="submit"  class="btn" value="Search" name="btnsearch" id="btnsearch"/>
				  &nbsp;
				<input style="cursor:pointer" type="button" class="btn" value="Clear" name="btnclear" id="btnclear" onclick="document.location.href='reports_most_active_days.php'"/>
				</td>			   
				<td width="12%"  valign="middle" align="right"><?php if(count($mostActiveDays) > 0) { ?>
				<input type="button" class="btn" value="Export to Excel" name="btnexport" id="btnexport" onclick="javascript:document.frm.action='export_most_active_days.php';document.frm.submit(); document.frm.action='';"/>
				<?php } else { ?>&nbsp;<?php } ?></td>				
			  </tr>
			</tbody>
		  </table>
			</td>
          </tr>                             
			<tr bgcolor="#a9cdf5" class="txtbo">
				<td width="20%" align="left"><strong>Days
				</strong></td>
				<td width="80%" align="left" class="listtab-rt-bro-user"><strong>Total Registration</strong></td>
			</tr>
				<?php 
				if(count($mostActiveDays)>0 && is_array($mostActiveDays) && $mostActiveDays[0]['reg_date']!=''){
				for($i=0;$i<count($mostActiveDays);$i++)
				{?>
					<tr class="row02" onmouseover="this.className='rowActive'" onmouseout="this.className='row01'">
						<td align="left"><?php echo $mostActiveDays[$i]['reg_date']?></td>
						<td align="left" class="listtab-rt-bro-user"><?php echo $mostActiveDays[$i]['tot_cnt']?></td>
					</tr>
				<?php }}else{?>
				<tr class="row01" onmouseover="this.className='rowActive'" onmouseout="this.className='row01'">
				
						<td colspan='2' align="center"><strong>No Records Found.</strong></td>
						
					</tr>
				<?php }?>
			</table></div>
                    <div class="fclear"></div></td>
                </tr>
                <tr>
                  <td align="left">&nbsp;</td>
                </tr>
				
				<?php if(count($mostActiveDays)>0){ ?>									
				<tr>
					<td colspan="8" align="left"><div class="next-prev-block-activestate">
					<?php if($noofpages>1){?>
					<ul>
					  <li id="prev1"><img src="images/prev-grey-arrow.jpg" width="14" height="11" alt="PREV" onclick="return prev('<?php echo $regdatestart;?>',<?php echo $noofpages;?>,1)" style="cursor:pointer;" id="areaprev" /></li>
					  <li id="paging1">&nbsp;<?php echo $currentpage;?>/<?php echo $noofpages;?>&nbsp;</li>					
					  <li id="next1"><img src="images/next-blue-arrow.jpg" width="14" height="11" alt="NEXT" onclick="return next('<?php echo $regdate;?>',<?php echo $noofpages;?>,1)" style="cursor:pointer;" id="areanext" /></li>
					 </ul> 
					 <?php }?>					 
					</div><div id="visualization" style="width: 858px; height: 250px;"></div></td>
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
	</div>
  </div>
</div>
</div>
<div class="clear"></div>
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