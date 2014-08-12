<?php
require_once 'include/general_includes.php';

$cmn->isAuthorized("index.php", ADMIN_USER_ID);
$objEncDec = new encdec();
	
	
$objClientAdmin = new client();
$user_id = $cmn->getSession(ADMIN_USER_ID);
$client_id = $objClientAdmin->fieldValue("client_id",$user_id);

$gadget_link = array();
$gadget_images[1] = GADGET_DIR."banner1.jpg";
$gadget_images[2] = GADGET_DIR."banner2.jpg";
$gadget_images[3] = GADGET_DIR."banner3.jpg";
$gadget_images[4] = GADGET_DIR."banner4.jpg";
$gadget_images[5] = GADGET_DIR."banner5.jpg";
$gadget_images[6] = GADGET_DIR."banner6.jpg";
$gadget_images[7] = GADGET_DIR."banner7.jpg";
$gadget_images[8] = GADGET_DIR."banner8.jpg";

for($i=1; $i <=8; $i++)
{
	$gadget_link[$i] = "<a href='".SERVER_HOST."voter/register_vote.php?user=".$objEncDec->encrypt($client_id)."' alt='Register to vote'><img src='".$gadget_images[$i]."' border='0' /></a>";
}

include SERVER_CLIENT_ROOT."include/header.php";
include SERVER_CLIENT_ROOT."include/top.php";
?>
  <!--Start content -->
  <div class="content_mn">
    <div class="content_mn2">
      <div class="cont_mid">
        <div class="cont_lt">
          <div class="cont_rt">
          	<div class="dashboard-cont">
            	<table width="100%" border="0" cellspacing="0" cellpadding="0">
            	  <tr>
            	    <td align="left" valign="top" width="290"><div class="notification-main">
            	      <div class="notification-title">Available Web Banners</div>
            	      <div class="notification-mid"><p><strong>Select Size for Web Banners</strong><img src="<?PHP echo SERVER_CLIENT_HOST; ?>images/arrow-img.png" align="right" width="29" height="19" /></p>
                      <ul style="min-height:150px !important;">
                      	<li><a href="javascript:showBanners(1);" id="heading1" class="banner-active">468 x 60</a></li>
                        <li><a href="javascript:showBanners(2);" id="heading2">300 x 250</a></li>
                        <li><a href="javascript:showBanners(3);" id="heading3">285 x 230</a></li>
                        <li><a href="javascript:showBanners(4);" id="heading4">160 x 600</a></li>
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
                  <div class="dashboard-tl-title">468 x 60 Web Banners</div>
                </div>
              </div>
              <div class="dashboard-content">
                <table cellpadding="0" cellspacing="0" border="0" width="100%" style="clear:both;" >
                   <tr>
                   	<td>&nbsp;</td>
                   </tr>
                  <tr>
                    <td height="30" align="left"><img src="<?php echo $gadget_images[1];?>" width="468" height="60" /><br />
                      </td>
                  </tr>
                  <tr>
                    <td width="80%" height="30" align="left"><strong>Embed Code:</strong></td>
                    </tr>
                  <tr>
                    <td height="30" align="left"><input type="text" value="<?php echo $gadget_link[1];?>"  class="input-banner" name="txtsearchname"/><br /></td>
                  </tr>
                  <tr>
                  	<td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="30" align="left"><img src="<?php echo $gadget_images[2];?>" width="468" height="60" /></td>
                  </tr>
                  <tr>
                    <td width="80%" height="30" align="left"><strong>Embed Code:</strong></td>
                    </tr>
                  <tr>
                    <td height="30" align="left"><input type="text" value="<?php echo $gadget_link[2];?>"  class="input-banner" name="txtsearchname"/></td>
                  </tr>
                  <tr>
                    <td height="30" align="left">&nbsp;</td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
          
          <div class="dashboard-bl-panel" id="panel2" style="display:none;">
            <div class="dashboard-br-panel">
              <div class="dashboard-title">
                <div class="dashboard-tr-title">
                  <div class="dashboard-tl-title">300 x 250 Web Banners</div>
                </div>
              </div>
              <div class="dashboard-content">
                <table cellpadding="0" cellspacing="0" border="0" width="100%" style="clear:both;" >
                	 <tr>
                   	<td>&nbsp;</td>
                   </tr>
                  <tr>
                    <td height="30" align="left"><img src="<?php echo $gadget_images[3];?>" width="300" height="250" /><br />
                      </td>
                  </tr>
                  <tr>
                    <td width="80%" height="30" align="left"><strong>Embed Code:</strong></td>
                    </tr>
                  <tr>
                    <td height="30" align="left"><input type="text" value="<?php echo $gadget_link[3];?>"  class="input-banner" name="txtsearchname"/><br /></td>
                  </tr>
                  <tr>
                  	<td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="30" align="left"><img src="<?php echo $gadget_images[4];?>" width="300" height="250" /></td>
                  </tr>
                  <tr>
                    <td width="80%" height="30" align="left"><strong>Embed Code:</strong></td>
                    </tr>
                  <tr>
                    <td height="30" align="left"><input type="text" value="<?php echo $gadget_link[4];?>"  class="input-banner" name="txtsearchname"/></td>
                  </tr>
                  <tr>
                    <td height="30" align="left">&nbsp;</td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
          
          
          <div class="dashboard-bl-panel" id="panel3" style="display:none;">
            <div class="dashboard-br-panel">
              <div class="dashboard-title">
                <div class="dashboard-tr-title">
                  <div class="dashboard-tl-title">285 x 230 Web Banners</div>
                </div>
              </div>
              <div class="dashboard-content">
                <table cellpadding="0" cellspacing="0" border="0" width="100%" style="clear:both;" >
                	 <tr>
                   	<td>&nbsp;</td>
                   </tr>
                  <tr>
                    <td height="30" align="left"><img src="<?php echo $gadget_images[5];?>" width="285" height="230" /><br />
                      </td>
                  </tr>
                  <tr>
                    <td width="80%" height="30" align="left"><strong>Embed Code:</strong></td>
                    </tr>
                  <tr>
                    <td height="30" align="left"><input type="text" value="<?php echo $gadget_link[5];?>"  class="input-banner" name="txtsearchname"/><br /></td>
                  </tr>
                  <tr>
                  	<td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="30" align="left"><img src="<?php echo $gadget_images[6];?>" width="285" height="230" /></td>
                  </tr>
                  <tr>
                    <td width="80%" height="30" align="left"><strong>Embed Code:</strong></td>
                    </tr>
                  <tr>
                    <td height="30" align="left"><input type="text" value="<?php echo $gadget_link[6];?>"  class="input-banner" name="txtsearchname"/></td>
                  </tr>
                  <tr>
                    <td height="30" align="left">&nbsp;</td>
                  </tr>
                </table>
              </div>
            </div>
          </div>
          
          
          <div class="dashboard-bl-panel" id="panel4" style="display:none;">
            <div class="dashboard-br-panel">
              <div class="dashboard-title">
                <div class="dashboard-tr-title">
                  <div class="dashboard-tl-title">160 x 600 Web Banners</div>
                </div>
              </div>
              <div class="dashboard-content">
                <table cellpadding="0" cellspacing="0" border="0" width="100%" style="clear:both;" >
                	 <tr>
                   	<td>&nbsp;</td>
                   </tr>
                  <tr>
                    <table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="50%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="left" valign="top"><img src="<?php echo $gadget_images[7];?>" width="160" height="600" /></td>
      </tr>
      <tr>
        <td height="30" align="left" valign="middle"><strong>Embed Code:</strong></td>
      </tr>
      <tr>
        <td height="30" align="left" valign="middle"><input type="text" value="<?php echo $gadget_link[7];?>"  class="input-banner4" name="txtsearchname2"/></td>
      </tr>
    </table>
                      
    </td>
    <td width="50%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="left" valign="top"><img src="<?php echo $gadget_images[8];?>" width="160" height="600" /></td>
      </tr>
      <tr>
        <td height="30" align="left" valign="middle"><strong>Embed Code:</strong></td>
      </tr>
      <tr>
        <td height="30" align="left" valign="middle"><input type="text" value="<?php echo $gadget_link[8];?>"  class="input-banner4" name="txtsearchname"/></td>
      </tr>
    </table></td>
  </tr>
</table>
                  </tr>
                  <tr>
                    <td height="30" align="left">&nbsp;</td>
                  </tr>
                </table>
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
function showBanners(id)
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
	}
	if(id==2)
	{
		document.getElementById('heading2').setAttribute("class","banner-active");
		document.getElementById('panel2').style.display='';
	}
	if(id==3)
	{
		document.getElementById('heading3').setAttribute("class","banner-active");
		document.getElementById('panel3').style.display='';
	}
	if(id==4)
	{
		document.getElementById('heading4').setAttribute("class","banner-active");
		document.getElementById('panel4').style.display='';
	}
}
</script>
<?php include SERVER_CLIENT_ROOT."include/footer.php";?>
</body>
</html>