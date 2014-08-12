<?php
require_once 'include/general_includes.php';
$objTopClient = new topclientreport();

// check if user is logged in.
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

// extra css and js
$extraCss = array("ui-lightness/jquery-ui-1.8.4.custom.css","calendar.css");	
$extraJs = array("jquery-ui-timepicker-addon.min.js","googleapi.js");
include SERVER_CLIENT_ROOT."include/header.php";
include SERVER_CLIENT_ROOT."include/top.php";
arsort($sourcedata[0]);

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
                    <div class="fleft">Registration Source Report</div>
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
		<td width="10%" align="left" valign="middle"><strong>Date From</strong></td>
		<td width="17%" valign="middle"><input type="text" value="<?php echo $txtdatefrom;?>" class="reprot-input" name="txtdatefrom" id="txtdatefrom"/>&nbsp;<img src="<?php echo SERVER_ADMIN_HOST?>images/Calender.png" border="0" onClick="javascript:document.getElementById('txtdatefrom').focus();"></td>
		<td width="7%" align="left" valign="middle"><strong>Date To</strong></td>
		<td width="18%" valign="middle"><input type="text" value="<?php echo $txtdateto;?>" class="reprot-input" name="txtdateto" id="txtdateto"/>
						&nbsp;<img src="<?php echo SERVER_ADMIN_HOST?>images/Calender.png" border="0" onClick="javascript:document.getElementById('txtdateto').focus();"></td>
		<td width="28%" height="40" valign="middle"><input type="submit"  class="btn" value="Search" name="btnsearch" id="btnsearch"/>
		  &nbsp;
		  <input type="reset" class="btn" value="Clear" name="btnclear" id="btnclear" onclick="javascript:document.location.href='top_source_report.php';"/></td>
		<td width="24%" align="right" valign="middle"><input type="button" class="btn" value="Export to Excel" name="btnclear" id="exprot-btn" onclick="javascript:document.frm.action='top_source_report_export.php';document.frm.submit(); document.frm.action='';" /></td>
	  </tr>
	</tbody>
  </table></td>
                                            </tr>
                                          </table>
                                           
										   <table cellpadding="0" cellspacing="0" border="0" class="listtab" width="100%" style="clear:both;" >
                                              
                                              <tr bgcolor="#a9cdf5" class="txtbo">
                                             <td width="25%" align="left"><strong>Registration Source</strong></td>                            
                                                <td width="75%" align="left" class="listtab-rt-bro-user"><strong>Total Registration</strong></td>
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
											  <?php if($keys[$i]=='tot_cnt_gadget')
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
                                                                   
                                            </table><br />

                                            <div class="fclear"></div>
                                          </div></td>
                                      </tr>
                                      <tr>
                                        <td></td>
                                      </tr>
                                    </form>
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