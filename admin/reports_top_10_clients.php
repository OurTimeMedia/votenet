<?php
//include base file
require_once 'include/general_includes.php';
	
//check admin login authentication
$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);

//create class obj	
$objpaging = new paging();
$objTopClient = new topclientreport();

//check registration date for searching criteria
if(isset($_POST['txtdatefrom']) && $_POST['txtdatefrom']!='')
{
	$txtdatefrom=$_POST['txtdatefrom'];
	$fromdate=explode("/",$_POST['txtdatefrom']);
	$frmdate=$fromdate[2]."-".$fromdate[0]."-".$fromdate[1];
}
else
{
	$txtdatefrom="";
	$frmdate='';	
}	
if(isset($_POST['txtdateto']) && $_POST['txtdateto']!='' )
{
	$txtdateto=$_POST['txtdateto'];
	$dateto=explode("/",$_POST['txtdateto']);
	$todate=$dateto[2]."-".$dateto[0]."-".$dateto[1]; 
}
else
{
	$txtdateto="";
	$todate='';
}	

//FEtch top most client data	
$orderby="tot_cnt DESC,rc.client_username asc";	
$clientdata=$objTopClient->topclientdetail($frmdate,$todate,$orderby);
//END

//include JS and CSS files
$extraJs = array("jquery-ui-timepicker-addon.min.js");
$extraCss = array("calendar.css");
	
include SERVER_ADMIN_ROOT."include/header.php";
include SERVER_ADMIN_ROOT."include/top.php";
?>
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
                  <div class="fleft">&nbsp;Top 10 Clients</div>
                  <div class="fright">&nbsp;</div>
                </div>
              </div>
            </div>           
            <div class="blue_title_cont">
			<table cellpadding="0" cellspacing="0" border="0" class="listtab" width="100%" style="clear:both;" >
			<tr><td colspan="2">
			<form name="frm" id="frm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="javascript: return validate();">			
			<table width="100%" cellpadding="0" cellspacing="0" class="listtab-rt-bro">
			<tbody>
			  <tr>
				<td width="78%" align="left" valign="middle"><strong>Date From</strong>&nbsp;<input type="text" value="<?php echo $txtdatefrom; ?>" class="reprot-input" name="txtdatefrom" id="txtdatefrom" readonly="readonly"/>
				 <img src="images/Calender.png" border="0" onClick="javascript:document.getElementById('txtdatefrom').focus();">
				 &nbsp;&nbsp;&nbsp;
				 <strong>Date To</strong>&nbsp;<input type="text" value="<?php echo $txtdateto; ?>" class="reprot-input" name="txtdateto" id="txtdateto" readonly="readonly"/>
				<img src="images/Calender.png" border="0" onClick="javascript:document.getElementById('txtdateto').focus();">
				&nbsp;&nbsp;&nbsp;
				<input type="submit"  class="btn" value="Search" name="btnsearch" id="btnsearch"/>
				  &nbsp;
				<input type="button" class="btn" value="Clear" name="btnclear" id="btnclear" onclick="javascript:document.location.href='reports_top_10_clients.php';" />
				</td>			   
				<td width="22%" height="40" align="right" valign="middle">&nbsp;
				<?php if(count($clientdata) > 0) { ?>
				<input type="button" class="btn" value="Export to Excel" name="btnexport" id="btnexport" onclick="javascript:document.frm.action='export_topclient.php';document.frm.submit(); document.frm.action='';"/>
				<?php } ?>
				</td>			  
			  </tr>
			</tbody>
		  </table>
		  </form>	  
			</td></tr>			
			
                                            
                                            <tr bgcolor="#a9cdf5" class="txtbo">
                                              <td width="20%" align="left"><strong>Client
											  </strong></td>
                                              <td width="80%" align="left" class="listtab-rt-bro-user"><strong>Total Registration</strong></td>
                                            </tr>
				<?php 
				if(count($clientdata)>0 && is_array($clientdata) && $clientdata[0]['client_name']!=''){
				for($i=0;$i<count($clientdata);$i++)
				{?>
					<tr class="row02" onmouseover="this.className='rowActive'" onmouseout="this.className='row01'">
						<td align="left"><?php echo $clientdata[$i]['client_name']?></td>
						<td align="left" class="listtab-rt-bro-user"><?php echo $clientdata[$i]['tot_cnt']?></td>
					</tr>
				<?php }}else{?>
				<tr class="row02" onmouseover="this.className='rowActive'" onmouseout="this.className='row01'">
				
						<td colspan='2' align="center"><strong>No Records Found.</strong></td>
						
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