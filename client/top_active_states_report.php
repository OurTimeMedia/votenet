<?php
require_once 'include/general_includes.php';
$objTopClient = new topclientreport();

// check if client is logged in.
$cmn->isAuthorized("index.php", ADMIN_USER_ID);
$userID = $cmn->getSession(ADMIN_USER_ID);
$objClient = new client();
$client_id = $objClient->fieldValue("client_id",$userID);
	$objpaging = new paging();
$currentpage=1;
$condition='';
	if($client_id!='')
	$condition .= " and client_id=".$client_id;	
$objTopClient->pagingType ="statebystaterpt";
$objpaging->strorderby = "tot_cnt";
$objpaging->strorder = "desc";

$statewisedata = $objpaging->setPageDetails($objTopClient,"state_by_state_report.php",PAGESIZE,$condition);
$displaystate = 5;
 $noofpages = ceil(count($statewisedata)/$displaystate);
 
// include extra css and js
$extraCss = array("ui-lightness/jquery-ui-1.8.4.custom.css","calendar.css");
$extraJs = array("jquery-ui-timepicker-addon.min.js","googleapi.js");
include SERVER_CLIENT_ROOT."include/header.php";
include SERVER_CLIENT_ROOT."include/top.php";
?>

<script type="text/javascript">
var chartwidth = 880;
var chartareawidth = 685;

if(document.documentElement.offsetWidth > 1024)
{
	chartwidth = document.documentElement.offsetWidth - 146;
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
		if(count($statewisedata)>$displaystate)
			$loop=$displaystate;
		else
			$loop=count($statewisedata);
		for($i=0;$i<$loop;$i++)
		{
			if($i==0)
				$regstatestart=$statewisedata[$i]['state_name'];
			$regstate=$statewisedata[$i]['state_name'];
			echo "data.addRow(['".$statewisedata[$i]['state_name']."',".$statewisedata[$i]['tot_cnt']."]);";
		}
}?>
	// Create and draw the visualization.
	 new google.visualization.ColumnChart(document.getElementById
		('visualization')).
            draw(data, {curveType: "function",
                        width: chartwidth, height: 230, chartArea:{left: 70, width:chartareawidth},
                         vAxis: {title: 'Registrations', titleTextStyle: {color: 'black'}},
						hAxis: {title: 'States', titleTextStyle: {color: 'black'}}});}
<?php 
	if(count($statewisedata)>0 && is_array($statewisedata) && $statewisedata[0]['state_name']!=''){
?>	
google.setOnLoadCallback(drawVisualization);
<?php }?>
function next()
{
	var currentpage=document.getElementById('currentpage').value;
	var curpage=eval(currentpage)+1;
	var noofpages=<?php echo $noofpages;?>;
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
		if(xmlhttp.readyState==4 && xmlhttp.status==200)
		{
			var res;
			var response=xmlhttp.responseText;
		//	alert(response);
			eval(response);
		//	alert(noofpages+"=="+curpage);
			document.getElementById('currentpage').value=curpage;
			document.getElementById('paging1').innerHTML=curpage+"/"+noofpages;
			if(noofpages==curpage)
				document.getElementById("next1").innerHTML='<img src="../images/next-gery-arrow.jpg" width="14" height="11" alt="prev">';
			if(curpage>1)	
				document.getElementById("prev1").innerHTML='<img src="../images/prev-blue-arrow.jpg" width="14" height="11" alt="PREV" onclick="return prev()" style="cursor:pointer;" >';
			if(noofpages>curpage)
				document.getElementById("next1").innerHTML='<img src="../images/next-blue-arrow.jpg" width="14" height="11" alt="Next"  onclick="return next()" style="cursor:pointer;">';	
		}
	}
	xmlhttp.open("GET","getstatereport.php?curpage="+curpage,true);
	xmlhttp.send();
}
function prev()
{
var currentpage=document.getElementById('currentpage').value;
	var curpage=eval(currentpage)-1;
	var noofpages=<?php echo $noofpages;?>;
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
		//	alert(response);
			var curpage=eval(currentpage)-1;
			document.getElementById('currentpage').value=curpage;
			document.getElementById('paging1').innerHTML=curpage+"/"+noofpages;
			//	alert(noofpages+"=="+curpage);
			if(curpage==1)
				document.getElementById("prev1").innerHTML='<img src="../images/prev-grey-arrow.jpg" width="14" height="11" alt="prev">';
			if(noofpages>curpage)
				document.getElementById("next1").innerHTML='<img src="../images/next-blue-arrow.jpg" width="14" height="11" alt="Next"  onclick="return next()" style="cursor:pointer;">';
		}
	}
xmlhttp.open("GET","getstatereport_prev.php?curpage="+curpage,true);
	xmlhttp.send();
}
</script>
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
                    <div class="fleft">Most Active States Report</div>
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
                                        <td><div class="white"><br />

                                            <table cellpadding="0" cellspacing="0" border="0" class="listtab" width="100%" style="clear:both;" >
                                              <tr bgcolor="#a9cdf5" class="txtbo">
                                                <td width="20%" align="left"><strong>State Name</strong><?php $objpaging->_sortImages("state_name", $cmn->getCurrentPageName()); ?></td>
                                                <td width="80%" align="left" class="listtab-rt-bro-user"><strong>Total Registration</strong><?php $objpaging->_sortImages("tot_cnt", $cmn->getCurrentPageName()); ?></td>
                                              </tr>
                                              <?php 
				if(count($statewisedata)>0 && is_array($statewisedata) && $statewisedata[0]['state_name']!=''){
				for($i=0;$i<count($statewisedata);$i++)
				{
				if($i%2==0)
				{
				?>
				<tr class="row01" onmouseover="this.className='rowActive'" onmouseout="this.className='row01'">
				<?php }else{?>
					<tr class="row02" onmouseover="this.className='rowActive'" onmouseout="this.className='row01'">
					<?php }?>
						<td align="left"><?php echo $statewisedata[$i]['state_name']?></td>
						<td align="left" class="listtab-rt-bro-user"><?php echo $statewisedata[$i]['tot_cnt']?></td>
					</tr>
				<?php }}else{?>
				<tr class="row01" onmouseover="this.className='rowActive'" onmouseout="this.className='row01'">
				
						<td colspan='2' align="center" class="listtab-rt-bro-user"><strong>No record Found.</strong></td>
						
					</tr>
				<?php }?>                          
<tr>
                                        <td style="display:none"><?php print $objpaging->drawPanel("panel1"); ?></td>
                                      </tr>				
                                            </table>
                                            <br />
                                            <div class="fclear"></div>
                                          </div></td>
                                      </tr>
                                      <tr>
                                        <td></td>
                                      </tr>
                                    </form>
									<?php 
										if(count($statewisedata)>0 && is_array($statewisedata) && $statewisedata[0]['state_name']!=''){
										
										?>
                                    <tr>
                    					<td colspan="8" align="left"><?php if($noofpages > 1) { ?><div class="next-prev-block-activestate">
										
										<ul>
      	  <li id="prev1">
			<img src="../images/prev-grey-arrow.jpg" width="14" height="11" alt="prev" onclick="return prev()" style="cursor:pointer;" id="areaprev" />
		  </li>
       	  <li id="paging1">&nbsp;<?php echo $currentpage;?>/<?php echo $noofpages;?>&nbsp;</li>
       	  <li id="next1"><img src="../images/next-blue-arrow.jpg" width="14" height="11" alt="prev" onclick="return next()" style="cursor:pointer;" id="areanext" /></li>
       	 </ul>
        </div><?php } ?><div id="visualization" style="width:800px; height: 250px;"></div></td>
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

</script>
</body>
</html>