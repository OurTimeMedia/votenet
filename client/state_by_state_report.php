<?php
require_once 'include/general_includes.php';
$objTopClient = new topclientreport();

// check if client is logged in.
$cmn->isAuthorized("index.php", ADMIN_USER_ID);
$userID = $cmn->getSession(ADMIN_USER_ID);
$objpaging = new paging();

$objClient = new client();
$client_id = $objClient->fieldValue("client_id",$userID);

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
$condition ='';
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
					$condition .= " and client_id=".$client_id;
$objTopClient->pagingType ="statebystaterpt";
$objpaging->strorderby = "tot_cnt";
$objpaging->strorder = "desc";

$statewisedata = $objpaging->setPageDetails($objTopClient,"state_by_state_report.php",PAGESIZE,$condition);

// extra css and js
$extraCss = array("ui-lightness/jquery-ui-1.8.4.custom.css","calendar.css");
$extraJs = array("jquery-ui-timepicker-addon.min.js","googleapi.js");
include SERVER_CLIENT_ROOT."include/header.php";
include SERVER_CLIENT_ROOT."include/top.php";
?>
  <div class="content_mn">
    <div class="content_mn2">
      <div class="cont_mid">
        <div class="cont_lt">
          <div class="cont_rt">
            <div class="user_tab_mn">
              <div class="blue_title">
                <div class="blue_title_lt">
                  	<div class="blue_title_rt">
                    <div class="fleft">State By State Summary Report </div>
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
								<div class="white">
                                  <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                    <form id="frm" name="frm" method="post">
                                      <tr>
                                        <td>
<table cellpadding="5" cellspacing="0" border="0" class="border-none" width="100%" style="clear:both;" >
<tr class="row02">
<td width="100%" align="left">
<table width="100%" cellpadding="0" cellspacing="0" class="listtab-rt-bro">
<tbody>
	  <tr>
		<td width="78%" align="left" valign="middle" height="40"><strong>Date From</strong>&nbsp;
		<input type="text" value="<?php echo $txtdatefrom;?>" class="reprot-input" name="txtdatefrom" id="txtdatefrom"/>&nbsp;<img src="<?php echo SERVER_ADMIN_HOST?>images/Calender.png" border="0" onClick="javascript:document.getElementById('txtdatefrom').focus();">&nbsp;&nbsp;&nbsp;
		<strong>Date To</strong>&nbsp;
		<input type="text" value="<?php echo $txtdateto;?>" class="reprot-input" name="txtdateto" id="txtdateto"/>
						&nbsp;<img src="<?php echo SERVER_ADMIN_HOST?>images/Calender.png" border="0" onClick="javascript:document.getElementById('txtdateto').focus();">&nbsp;&nbsp;&nbsp;
						<input type="submit"  class="btn" value="Search" name="btnsearch" id="btnsearch"/>
		  &nbsp;
		  <input type="reset" class="btn" value="Clear" name="btnclear" id="btnclear" onclick="javascript:document.location.href='state_by_state_report.php';"/></td>
		<td width="22%" align="right" valign="middle">
		<?php if(count($statewisedata)>0) { ?>
		<input type="button" class="btn" value="Export to Excel" name="btnclear" id="exprot-btn" onclick="javascript:document.frm.action='state_by_state_report_export.php'; document.frm.submit(); document.frm.action='';">
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
				<tr class="row02" onmouseover="this.className='rowActive'" onmouseout="this.className='row01'">

						<td colspan='2' align="center" class="listtab-rt-bro-user">No Records Found.</td>

					</tr>
				<?php }?>
                                          </table>
                                            <div class="fclear"></div>
                                        </td>
                                      </tr>
                                      <tr>
                                        <td><div id="pager"><?php print $objpaging->drawPanel("panel1"); ?></div></td>
                                      </tr>
                                    </form>
                                  </table></div>
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
</body>
</html>
<script type="text/javascript">
jQuery.noConflict();
jQuery(document).ready(function(){
	jQuery('#txtdatefrom').datepicker({
    });
	jQuery('#txtdateto').datepicker({
    });
});
</script>