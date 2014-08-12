<?php
require_once 'include/general_includes.php';

$cmn->isAuthorized("index.php", ADMIN_USER_ID);
$objEncDec = new encdec();
	
$objClientAdmin = new client();
$user_id = $cmn->getSession(ADMIN_USER_ID);
$client_id = $objClientAdmin->fieldValue("client_id",$user_id);

$objclientsocialmediacontent=  new clientsocialmediacontent();

$condition = " AND (".DB_PREFIX."socialmediacontent.client_id='".$client_id."' OR ".DB_PREFIX."socialmediacontent.client_id='0') ";
$objpaging->strorderby = "client_id";
$objpaging->strorder = "desc";

$objclientsocialmediacontent->setAllValues("", $condition);

include "share_message_db.php";

$extraJs = array("share_msg.js");

include SERVER_CLIENT_ROOT."include/header.php";
include SERVER_CLIENT_ROOT."include/top.php";
?>

  <!--Start content -->
  <div class="content_mn">
    <div class="content_mn2">
      <div class="cont_mid">
        <div class="cont_lt">
          <div class="cont_rt">
		  <?php $msg->displayMsg(); ?>
          	<div class="dashboard-cont">
            	<table width="100%" border="0" cellspacing="0" cellpadding="0">
            	  <tr>
            	    <td align="left" valign="top" width="290"><div class="notification-main">
            	      <div class="notification-title">Share Messages</div>
            	      <div class="notification-mid">
                      <ul style="min-height:150px !important;">
                      	<li><a href="javascript:showcontent(1);" id="heading1" class="banner-active">Facebook Share</a></li>
                        <li><a href="javascript:showcontent(2);" id="heading2">Twitter Share</a></li>
						<li><a href="javascript:showcontent(3);" id="heading3">Google Plus Share</a></li>
						<li><a href="javascript:showcontent(4);" id="heading4">Tumblr Share</a></li>                      
					</ul>
                      </div>
            	      <div class="notification-bot"></div>
          	      </div></td>
            	    <td align="left" valign="top">
                        <div class="dashboard-top-panel">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
							  <tr>
								<td width="49%" align="left" valign="top"><div class="dashboard-left-panel">
								  <div class="dashboard-bl-panel" id="panel1" style="display:;">
									<div class="dashboard-br-panel">
									  <div class="dashboard-title">
										<div class="dashboard-tr-title">
										  <div class="dashboard-tl-title">Facebook Share</div>
										</div>
									  </div>
									  <div class="dashboard-content">
										<form name="frm" id="frm" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" onsubmit="javascript: return validate();" enctype="multuserart/form-data">
											<input type="hidden" value="1" name="currentshow" id="currentshow">
											<input type="hidden" value="<?php echo $client_id?>" name="client_id" id="client_id">
											<table cellpadding="0" cellspacing="0" width="100%" class="listtab12">
												<tr class="row01" >
													<td width="12%" align="left" valign="top"><strong>Message :</strong></td>
													<td align="left" valign="top" width="78%"><textarea rows="5" cols="50" id="fcontent" name="fcontent"><?php echo $cmn->readValue($objclientsocialmediacontent->fb_content);?></textarea></td>
												</tr>
												<tr class="row01">
													<td align="left" valign="top">&nbsp;</td>
													<td align="left" valign="top" ><input type="submit" value="Save" id="btnSave" class="btn_img" name="btnSave"></td>
												</tr>
											</table>
										</form>
									  </div>
									</div>
								  </div>
								  
								  <div class="dashboard-bl-panel" id="panel2" style="display:none;">
									<div class="dashboard-br-panel">
									  <div class="dashboard-title">
										<div class="dashboard-tr-title">
										  <div class="dashboard-tl-title">Twitter Share</div>
										</div>
									  </div>
									  <div class="dashboard-content">
									   <form name="frm1" id="frm1" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" onsubmit="javascript: return validate();" enctype="multuserart/form-data">
											<input type="hidden" value="2" name="currentshow" id="currentshow">
											<input type="hidden" value="<?php echo $client_id?>" name="client_id" id="client_id">
											<table cellpadding="0" cellspacing="0" width="100%" class="listtab12">
												<tr class="row01" >
													<td width="12%" align="left" valign="top"><strong>Message :</strong></td>
													<td align="left" valign="top" width="78%"><textarea rows="5" cols="50" id="tcontent" name="tcontent"><?php echo $cmn->readValue($objclientsocialmediacontent->tw_content);?></textarea></td>
												</tr>
												<tr class="row01">
													<td align="left" valign="top">&nbsp;</td>
													<td align="left" valign="top" ><input type="submit" value="Save" id="btnSave" class="btn_img" name="btnSave"></td>
												</tr>
											</table>
										</form>
									  </div>
									</div>
								  </div>
								  <div class="dashboard-bl-panel" id="panel3" style="display:none;">
									<div class="dashboard-br-panel">
									  <div class="dashboard-title">
										<div class="dashboard-tr-title">
										  <div class="dashboard-tl-title">Google Plus Share</div>
										</div>
									  </div>
									  <div class="dashboard-content">
										<form name="frm2" id="frm2" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" onsubmit="javascript: return validate();" enctype="multuserart/form-data">
											<input type="hidden" value="3" name="currentshow" id="currentshow">
											<input type="hidden" value="<?php echo $client_id?>" name="client_id" id="client_id">
											<table cellpadding="0" cellspacing="0" width="100%" class="listtab12">
												<tr class="row01" >
													<td width="12%" align="left" valign="top"><strong>Title :</strong></td>
													<td align="left" valign="top" width="78%"><input type="textbox" value="<?php echo $cmn->readValue($objclientsocialmediacontent->google_title);?>" name="gtitle" id="gtitle" style="width:295px;"></td>
												</tr>
												<tr class="row01" >
													<td width="12%" align="left" valign="top"><strong>Message :</strong></td>
													<td align="left" valign="top" width="78%"><textarea rows="5" cols="50" id="gcontent" name="gcontent"><?php echo $cmn->readValue($objclientsocialmediacontent->google_content);?></textarea></td>
												</tr>
												<tr class="row01">
													<td align="left" valign="top">&nbsp;</td>
													<td align="left" valign="top" ><input type="submit" value="Save" id="btnSave" class="btn_img" name="btnSave"></td>
												</tr>
											</table>
										</form>				
									  </div>
									</div>
								  </div>

								   <div class="dashboard-bl-panel" id="panel4" style="display:none;">
									<div class="dashboard-br-panel">
									  <div class="dashboard-title">
										<div class="dashboard-tr-title">
										  <div class="dashboard-tl-title">Tumblr Share</div>
										</div>
									  </div>
									  <div class="dashboard-content">
										<form name="frm3" id="frm3" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" onsubmit="javascript: return validate();" enctype="multuserart/form-data">
											<input type="hidden" value="4" name="currentshow" id="currentshow">
											<input type="hidden" value="<?php echo $client_id?>" name="client_id" id="client_id">
											<table cellpadding="0" cellspacing="0" width="100%" class="listtab12">
												<tr class="row01" >
													<td width="12%" align="left" valign="top"><strong>Title :</strong></td>
													<td align="left" valign="top" width="78%"><input type="textbox" value="<?php echo $cmn->readValue($objclientsocialmediacontent->tumblr_title);?>" name="tumblrtitle" id="tumblrtitle" style="width:295px;"></td>
												</tr>
												<tr class="row01" >
													<td width="12%" align="left" valign="top"><strong>Message :</strong></td>
													<td align="left" valign="top" width="78%"><textarea rows="5" cols="50" id="tucontent" name="tucontent"><?php echo $cmn->readValue($objclientsocialmediacontent->tumblr_content);?></textarea></td>
												</tr>
												<tr class="row01">
													<td align="left" valign="top">&nbsp;</td>
													<td align="left" valign="top" ><input type="submit" value="Save" id="btnSave" class="btn_img" name="btnSave"></td>
												</tr>
											</table>
										</form>
									  </div>
									</div>
								  </div>
								</div></td>
								</tr>
						</table>
                    </div>                      
                    </td>
          	    </tr>
          	  </table>
                <div class="clear"></div>				
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="clear"></div>
</div>

<script type="text/javascript">
var currentshow = 1;

function showcontent(id)
{
	document.getElementById('heading1').setAttribute("class","");
	document.getElementById('heading2').setAttribute("class","");
	document.getElementById('heading3').setAttribute("class","");
	document.getElementById('heading4').setAttribute("class","");
	
	document.getElementById('panel1').style.display='none';
	document.getElementById('panel2').style.display='none';
	document.getElementById('panel3').style.display='none';
	document.getElementById('panel4').style.display='none';
	
	if(id==1)
	{
		document.getElementById('heading1').setAttribute("class","banner-active");
		document.getElementById('panel1').style.display='';
		currentshow=1;
	}
	if(id==2)
	{
		currentshow=2;
		document.getElementById('heading2').setAttribute("class","banner-active");
		document.getElementById('panel2').style.display='';
	}
	if(id==3)
	{
		currentshow=3;
		document.getElementById('heading3').setAttribute("class","banner-active");
		document.getElementById('panel3').style.display='';
	}
	if(id==4)
	{
		currentshow=4;
		document.getElementById('heading4').setAttribute("class","banner-active");
		document.getElementById('panel4').style.display='';
	}
}
</script>
<?php include SERVER_CLIENT_ROOT."include/footer.php";?>
</body>
</html>