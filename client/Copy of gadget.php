<?php
	require_once("include/general_includes.php");
	$main_menu = 1;
?>
<?php include "include/header.php"; ?>
<?php include "include/top.php"; ?>
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
            	      <div class="notification-mid"><p><strong>Select Size for Web Banners</strong><img src="images/arrow-img.png" align="right" width="29" height="19" /></p>
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
                    <td height="30" align="left"><img src="images/banner.png" width="468" height="60" /><br />
                      </td>
                  </tr>
                  <tr>
                    <td width="80%" height="30" align="left"><strong>Embed Code:</strong></td>
                    </tr>
                  <tr>
                    <td height="30" align="left"><input type="text" value="<a href='http://www.electionimpact.com?user=ptanner' alt='Register to vote'>"  class="input-banner" name="txtsearchname"/><br /></td>
                  </tr>
                  <tr>
                  	<td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="30" align="left"><img src="images/banner.png" width="468" height="60" /></td>
                  </tr>
                  <tr>
                    <td width="80%" height="30" align="left"><strong>Embed Code:</strong></td>
                    </tr>
                  <tr>
                    <td height="30" align="left"><input type="text" value="<a href='http://www.electionimpact.com?user=ptanner' alt='Register to vote'>"  class="input-banner" name="txtsearchname"/></td>
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
                    <td height="30" align="left"><img src="images/banner2.png" width="300" height="250" /><br />
                      </td>
                  </tr>
                  <tr>
                    <td width="80%" height="30" align="left"><strong>Embed Code:</strong></td>
                    </tr>
                  <tr>
                    <td height="30" align="left"><input type="text" value="<a href='http://www.electionimpact.com?user=ptanner' alt='Register to vote'>"  class="input-banner" name="txtsearchname"/><br /></td>
                  </tr>
                  <tr>
                  	<td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="30" align="left"><img src="images/banner2.png" width="300" height="250" /></td>
                  </tr>
                  <tr>
                    <td width="80%" height="30" align="left"><strong>Embed Code:</strong></td>
                    </tr>
                  <tr>
                    <td height="30" align="left"><input type="text" value="<a href='http://www.electionimpact.com?user=ptanner' alt='Register to vote'>"  class="input-banner" name="txtsearchname"/></td>
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
                    <td height="30" align="left"><img src="images/banner3.png" width="285" height="230" /><br />
                      </td>
                  </tr>
                  <tr>
                    <td width="80%" height="30" align="left"><strong>Embed Code:</strong></td>
                    </tr>
                  <tr>
                    <td height="30" align="left"><input type="text" value="<a href='http://www.electionimpact.com?user=ptanner' alt='Register to vote'>"  class="input-banner" name="txtsearchname"/><br /></td>
                  </tr>
                  <tr>
                  	<td>&nbsp;</td>
                  </tr>
                  <tr>
                    <td height="30" align="left"><img src="images/banner3.png" width="285" height="230" /></td>
                  </tr>
                  <tr>
                    <td width="80%" height="30" align="left"><strong>Embed Code:</strong></td>
                    </tr>
                  <tr>
                    <td height="30" align="left"><input type="text" value="<a href='http://www.electionimpact.com?user=ptanner' alt='Register to vote'>"  class="input-banner" name="txtsearchname"/></td>
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
        <td align="left" valign="top"><img src="images/banner4.png" width="160" height="600" /></td>
      </tr>
      <tr>
        <td height="30" align="left" valign="middle"><strong>Embed Code:</strong></td>
      </tr>
      <tr>
        <td height="30" align="left" valign="middle"><input type="text" value="&lt;a href='http://www.electionimpact.com?user=ptanner' alt='Register to vote'&gt;"  class="input-banner4" name="txtsearchname2"/></td>
      </tr>
    </table>
                      
    </td>
    <td width="50%" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="left" valign="top"><img src="images/banner4.png" width="160" height="600" /></td>
      </tr>
      <tr>
        <td height="30" align="left" valign="middle"><strong>Embed Code:</strong></td>
      </tr>
      <tr>
        <td height="30" align="left" valign="middle"><input type="text" value="&lt;a href='http://www.electionimpact.com?user=ptanner' alt='Register to vote'&gt;"  class="input-banner4" name="txtsearchname"/></td>
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
	jQuery("body").append("<div id='TB_load'><img src='"+imgLoader.src+"' /></div>");//add loader to the page
	jQuery('#TB_load').show();//show loader
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
	jQuery('#TB_load').remove();//show loader
}
</script>

<!--Start footer -->
<?php include "include/footer.php"; ?>
<div class="clear"></div>
</div>
</body>
</html>