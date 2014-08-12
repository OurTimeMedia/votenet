<form name="frm" id="frm" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" onSubmit="return setDomainInfo();">
<table cellpadding="0" cellspacing="0" border="0" width="100%"  class="table-bg"style="clear:both;" align="center" >
	<tr>
	  <td colspan="10" valign="middle" class="table-raw-title" style="text-align:left; height:30px;">
		<div class="section-title">Domain</div>
	  </td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td><table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-pi">
	<?php if($objPlan->custom_domain == 1) { ?>
	  <td colspan="10" class="radio-bro-none12" style="text-align:left; height:30px; padding:0 0 0 35px;"><input type="radio" name="rdoisprivate_domain" id="rdoisprivate_domain" value="0" checked="checked"  onClick="javascript:if(this.checked){ document.getElementById('idSubDomain').style.display=''; document.getElementById('idprivateDomain').style.display='none'; document.getElementById('ishttp').style.display='none'; document.getElementById('ishttps').style.display=''; document.getElementById('chkRegistrationStep').disabled=false; 
	  document.getElementById('chkRegistrationStep').checked=false; document.getElementById('chkSharingEnable').disabled=false; document.getElementById('chkSharingEnable').checked=false;} else {document.getElementById('idSubDomain').style.display='none'; 
	  document.getElementById('idprivateDomain').style.display=''; document.getElementById('ishttps').style.display='none'; document.getElementById('ishttp').style.display=''; document.getElementById('chkRegistrationStep').disabled=true; 
	  document.getElementById('chkRegistrationStep').checked=true; document.getElementById('chkSharingEnable').disabled=true; document.getElementById('chkSharingEnable').checked=true;}"/>
	
A sub-domain on Election impact
<input type="radio" name="rdoisprivate_domain" id="rdoisprivate_domain" value="1"  onClick="javascript:if(this.checked){ document.getElementById('idSubDomain').style.display='none';  document.getElementById('idprivateDomain').style.display='';   document.getElementById('ishttp').style.display=''; document.getElementById('ishttps').style.display='none'; document.getElementById('chkRegistrationStep').disabled=true; 
document.getElementById('chkRegistrationStep').checked=true; document.getElementById('chkSharingEnable').disabled=true; document.getElementById('chkSharingEnable').checked=true;} else { document.getElementById('idSubDomain').style.display=''; document.getElementById('idprivateDomain').style.display='none';  document.getElementById('ishttps').style.display=''; document.getElementById('ishttp').style.display='none'; document.getElementById('chkRegistrationStep').disabled=false; 
document.getElementById('chkRegistrationStep').checked=false; 
document.getElementById('chkSharingEnable').disabled=false; document.getElementById('chkSharingEnable').checked=false;}"/>
Your own private domain</td>
	</tr>
	<?php } else { ?>
	<tr>
	  <td colspan="10" class="radio-bro-none12" style="display:none;"><input type="radio" name="rdoisprivate_domain" id="rdoisprivate_domain" value="0" checked>
	<input type="radio" name="rdoisprivate_domain" id="rdoisprivate_domain" value="1"></td>
	</tr>
	<?php } ?>
	<tr>
	  <td colspan="10" style="text-align:left; height:30px; padding:0 0 0 35px;"><table width="74%" border="0" cellspacing="0" cellpadding="0" class="top-titel2">
		<tr>
		  <td width="2%" height="40" align="left" valign="top">&nbsp;</td>
		  <td width="98%" colspan="2" align="left" valign="top"><strong> <span style="line-height:30px;">&nbsp;&nbsp;<span id="ishttps">https://</span><span id="ishttp" style="display:none;">http://</span>&nbsp;&nbsp;</span>
			  <input name="txtdomain" type="text" class="listtab-input" id="txtdomain" value="<?PHP echo $cmn->readValueDetail($objWebsite->domain); ?>" />
		  <span id="idSubDomain">.<?php echo SITE_DOMAIN_NAME;?></span></strong>
		  <span id="idprivateDomain" style="display:none;">(<i>Configure your DNS to point CNAME record to <strong>electionimpact.com</strong></i>)</span>	  
		  </td>		 
		</tr>		
		<tr>
		  <td colspan="3"><input name="btn_setDomain" type="submit" class="btn_img" id="btn_setDomain" value="Save" /></td>
		</tr>
	  </table></td>
	</tr></table>
	</td>
	</tr>
  </table>
</form>  
  <br /><br />
  <form name="frm1" id="frm1" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" onSubmit="return setTeamplateInfo();" enctype="multipart/form-data">
  <input type="hidden" name="SERVER_ROOT" id="SERVER_ROOT" value="<?PHP echo SERVER_ROOT; ?>" /> 
  <input type="hidden" name="SERVER_HOST" id="SERVER_HOST" value="<?PHP echo SERVER_HOST; ?>" /> 
  <input type="hidden" name="client_id" id="client_id" value="<?PHP echo $client_id; ?>" /> 
<?PHP 
$showColor = '';
$showBgImage = 'display:none;';
$chkBgImage = '';
$chkBgColor = 'checked';

if($objWebsite->background_color!='') { $showColor = ''; $chkBgColor='checked';} 
if($objWebsite->background_image!='') { $showBgImage = ''; $showColor = 'display:none;'; $chkBgImage='checked'; $chkBgColor=''; }
?>								
  <table cellpadding="0" cellspacing="0" border="0" width="100%"  class="table-bg"style="clear:both;" align="center" >
	<tr>
	  <td colspan="10" valign="middle" class="table-raw-title" style="text-align:left; height:30px;">
		<div class="section-title">Templates</div>
	  </td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
	  <td align="left" valign="top">
	  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-pi">
		<tr>
		  <td align="left" valign="middle" style="padding:0 0 10px 0; *padding:0 0 10px 35px">
		  <span style="text-align:left; height:30px;"><img src="<?php echo SERVER_CLIENT_HOST?>images/arrow-red.png" alt="" /></span>&nbsp;<strong> Customize Your Template</strong></td>
		</tr>                                       
		<tr>
		  <td>
			<div id="upload_area" style="display:none;"></div>
			<div id="upload_area1" style="display:none;"></div>
			<div id="idCustomize" >
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
			<tr>
				<td>&nbsp;</td>
			</tr>
			<tr>
			  <td colspan="2" height="25" align="left" valign="middle" class="radio-bro-none">
				<input type="checkbox" name="chkHideBanner" id="chkHideBanner" onclick="showHideBannerSection();" value="1" <?php if($objWebsite->hide_banner == 1) { ?> checked <?php } ?>>Hide <strong>Banner</strong>.
			  </td>
			</tr>
			<tr id="trBannerSection" <?php if($objWebsite->hide_banner == 1) { ?> style="display:none;" <?php } ?>>
			  <td height="25" colspan="2" align="left" valign="middle"><span style="text-align: left; border: medium none;">Banner Image:&nbsp;
				  <label>
					<input type="file" id="filBannerImage" name="filBannerImage" />
					<input type="hidden" name="alreadyUploadedBn" id="alreadyUploadedBn" value="<?PHP echo $objWebsite->banner_image; ?>" />
					<?PHP if($objWebsite->banner_image!="")  {?>
<a href="clientbanner.php?height=295&width=960" class="thickbox" title="View Banner Image" style="text-decoration:none;"><strong>Click to view Banner Image</strong></a> <a href="website_templates.php?act=delbanner"><strong>[Delete]</strong></a>
<?PHP } ?>
				  </label>
&nbsp;For best results, your image should be<strong> 950px</strong> wide and <strong>170px</strong> height</span></td>
			  <td>                                            
			  <td height="25" align="left" valign="middle">&nbsp;</td>
			</tr>
			<tr>
			  <td height="18" colspan="2" align="left" valign="middle"></td>			    
			  <td height="18" align="left" valign="middle">&nbsp;</td>
			</tr>
			<tr>
			  <td colspan="2" height="25" align="left" valign="middle" class="radio-bro-none"><input type="checkbox" name="chkHideTopNavigation" id="chkHideTopNavigation" onclick="showHideTopNavigation();" value="1" <?php if($objWebsite->hide_navigation == 1) { ?> checked <?php } ?>>Hide <strong>Top Navigation Panel</strong>.
			  </td>
			</tr>
		<tr id="trTopNavigationBg" <?php if($objWebsite->hide_navigation == 1) { ?> style="display:none;" <?php } ?>>
			  <td width="19%" height="25" align="left" valign="middle" class="radio-bro-none">
				Top Navigation Background Color:</td>
			  <td width="81%" height="25" align="left" valign="middle" id="tdTopNavBackgroundColor"><input type="text" id="txtTopNavBackgroundColor" name="txtTopNavBackgroundColor" class="color" value="<?php echo $objWebsite->top_nav_background_color;?>"></td>
			</tr>
			<tr id="trTopNavigationColor" <?php if($objWebsite->hide_navigation == 1) { ?> style="display:none;" <?php } ?>>
			  <td width="19%" height="25" align="left" valign="middle" class="radio-bro-none">
				Top Navigation Text Color:</td>
			  <td width="81%" height="25" align="left" valign="middle" id="tdTopNavTextColor"><input type="text" id="txtTopNavTextColor" name="txtTopNavTextColor" class="color" value="<?php echo $objWebsite->top_nav_text_color;?>"></td>
			</tr>
			<tr>
			  <td height="18" colspan="2" align="left" valign="middle"></td>			    
			  <td height="18" align="left" valign="middle">&nbsp;</td>
			</tr>
			<tr>
			  <td width="19%" height="25" align="left" valign="middle" class="radio-bro-none"><input class="radio-bro-none" type="radio" name="rdobackground_type" id="rdobackground_type1" value="1"  onClick="document.getElementById('tdbgfile').style.display='none';document.getElementById('tdbgcolor').style.display='';" <?PHP echo $chkBgColor; ?>/>
				Background Color:</td>
			  <td width="81%" height="25" align="left" valign="middle" id="tdbgcolor" style="<?PHP echo $showColor; ?>"><input type="text" id="txtBackgroundColor" name="txtBackgroundColor" class="color" value="<?php echo $objWebsite->background_color;?>"></td>
			</tr>			
			<tr>
			  <td height="30" align="left" valign="middle" class="radio-bro-none"><input type="radio" name="rdobackground_type" id="rdobackground_type2" value="2" class="radio-bro-none" onClick="document.getElementById('tdbgfile').style.display='';document.getElementById('tdbgcolor').style.display='none';" <?PHP echo $chkBgImage; ?>/>
				Background Image:</td>
				 <td align="left" style="text-align:left; border:none; padding-bottom:5px; <?PHP echo $showBgImage; ?>" id="tdbgfile">
<input type="file" name="filBackgroundImage" id="filBackgroundImage" style="vertical-align:top;">
<input type="hidden" name="alreadyUploadedBg" id="alreadyUploadedBg" value="<?PHP echo $objWebsite->background_image; ?>" />
<?PHP if($objWebsite->background_image!="")  {?>
<a href="clientBackground.php?height=295&width=960" class="thickbox" title="View Background Image" style="text-decoration:none;"><strong>Click to view Background Image</strong></a> <a href="website_templates.php?act=delbg"><strong>[Delete]</strong></a>
<?PHP } ?>
					
			  <td height="25" align="left" valign="middle">&nbsp;</td>
			</tr>                                         
			<tr>
			  <td height="18" colspan="2" align="left" valign="middle"></td>			    
			  <td height="18" align="left" valign="middle">&nbsp;</td>
			</tr>
			
			<tr>
			  <td colspan="2" height="25" align="left" valign="middle" class="radio-bro-none"><input type="checkbox" name="chkRegistrationStep" id="chkRegistrationStep" value="1" <?php if($objWebsite->hide_steps == 1) { ?> checked <?php } ?>>Hide <strong>Registration Steps Button</strong>.
			  </td>
			</tr>
		  </table>
		  </div>
		  </td>
		</tr>
		<tr>
		  <td>&nbsp;</td>
		</tr>
		<tr>
		  <td>
		  <input type="hidden" name="allowImagesExts" id="allowImageExts" value="<?PHP echo implode("_",$extensions['image']); ?>" />
		  <input name="btnTemplate" type="submit" class="btn_img" id="btnTemplate" value="Save" />
		  <a href="javascript:void(0)" onClick="return preparePreview();" style="display:none;"><input name="btnPreview" type="button" class="btn_img" id="btnPreview" value="Preview" /> </a></td>
		</tr>
	  </table>
	  </td>
	</tr>
  </table>
  </form>  
  <br /><br />
  <form name="frm2" id="frm2" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" onSubmit="return setSharingOption();" enctype="multipart/form-data">
	<table cellpadding="0" cellspacing="0" border="0" width="100%"  class="table-bg"style="clear:both;" align="center" >
	<tr>
	  <td colspan="10" valign="middle" class="table-raw-title" style="text-align:left; height:30px;">
		<div class="section-title">Skip Share Step</div>
	  </td>
	</tr>
	<tr>
		<td>&nbsp;</td>
	</tr>
	<tr>
	  <td align="left" valign="top">
	  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-pi">		                                   
		<tr>
		  <td>			
			<table width="100%" border="0" cellspacing="0" cellpadding="5" class="top-titel2">			
			<tr>
			  <td width="100%" height="25" align="left" valign="middle" class="radio-bro-none"><input type="checkbox" name="chkSharingEnable" id="chkSharingEnable" onclick="showHideShareOptions();" value="0" <?php if($objWebsite->is_sharing != 1) { ?> checked <?php } ?>>Skip <strong>Step 3: Spread the Word via Social Media (SHARE)</strong> step.
			  </td>
			</tr>
			<tr id="trShareOptions" <?php if($objWebsite->is_sharing == 1) { ?> style="display:none;"<?php } ?>>
			<td width="100%" height="25" align="left" valign="middle" style="padding-left:25px;"><input type="checkbox" name="chkRedirectURL" id="chkRedirectURL" value="1" onclick="enableDisableURLOpt();" <?php if($objWebsite->sharing_redirect_url != "") {?> checked <?php } ?>>Redirect user to URL:&nbsp; <input type="text" class="listtab-input" name="txtRedirectURL" id="txtRedirectURL" value="<?php echo $objWebsite->sharing_redirect_url;?>" style="width:350px" <?php if($objWebsite->sharing_redirect_url == "") {?> disabled <?php } ?>><br/>
			<span style="padding-left:145px;">(E.g. http://www.example.com/mypage.html)</span>
			</td>	
			</tr>
			<tr>
			<td width="100%" align="left" valign="middle" style="padding-left:25px;"><img src="<?PHP echo SERVER_CLIENT_HOST; ?>images/sharing_option.jpg" border="0">
			</td>			
			</tr>	
		  </table>		  
		  </td>
		</tr>
		<tr>
		  <td>&nbsp;</td>
		</tr>
		<tr>
		  <td><input name="btnShare" type="submit" class="btn_img" id="btnShare" value="Save" /></td>
		</tr>
	  </table>
	  </td>
	</tr>
  </table>
  </form>  
  <br /><br />
  <!-- 
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="table-bg" style="clear:both;" >
<tr>
	  <td valign="middle" class="table-raw-title" style="text-align:left; height:30px;">
		<div class="section-title"><a name="mpage"></a>Manage Pages</div>
		
		<div class="section-right" style="line-height:0;">
		<table cellpadding="0" cellspacing="0" border="0">
        <tr>
		<td valign="middle">
		<img src="<?PHP echo SERVER_CLIENT_HOST; ?>images/add_new.png" align="left" border="0"/>
		&nbsp;</td>
		<td>
		<a href="website_pages_addedit.php?height=480&width=850&TB_iframe=true" class="section-anchor thickbox" title="Add New Page" style="text-decoration:none;">Add New Page</a>
		</td>
		</table></div>
	  </td>
	</tr>
  <tr>
    <td align="left" valign="middle" style="text-align:left;" id="pagedetail"><br />
      <table width="95%" align="center" cellpadding="0" cellspacing="0" class="listtab">
        <tr>
          <td width="85%" bgcolor="#a6caf4" class="listtab-td"><strong>Page Name</strong></td>
          <td width="15%" bgcolor="#a6caf4" class="sponsors-table-right1"><strong>Action</strong></td>
          </tr>
		  <?php 
		  
		  if(count($arrWebsitePages) > 0) { 
		  foreach($arrWebsitePages as $awpkey=>$awpval ) {
		  ?>
		  <tr class="row01">
          <td class="listtab-td"><?php echo $awpval['page_name'];?></td>
          <td class="sponsors-table-right1"><table width="50%" border="0" cellspacing="0" cellpadding="0" class="listtab-rt-bro1">
            <tr>
              <td align="left" valign="middle"><a href="website_pages_addedit.php?pid=<?php echo $objEncDec->encrypt($cmn->readValueDetail($awpval['page_id']));?>&height=480&width=850&TB_iframe=true" class="thickbox" title="Edit Page"><img src="<?PHP echo SERVER_CLIENT_HOST; ?>images/edit.png" alt="" width="16" height="17" alt="Edit"  /></a></td>
            <td align="left" valign="middle"><a href="javascript:deletePageDetails('<?php echo $objEncDec->encrypt($cmn->readValueDetail($awpval['page_id']));?>');"><img src="<?PHP echo SERVER_CLIENT_HOST; ?>images/delete.gif" alt="Delete" width="16" height="16" /></a></td>
              </tr>
            </table></td>
          </tr>
		  <?php }} else { ?>
		  <tr class="row01">
          <td class="sponsors-table-right1" align="center" colspan="2">No Pages Found.</td>
          </tr>
		  <?php } ?>
        </table></td>
  </tr>
  </table><br /><br />
-->  
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="table-bg" style="clear:both;" >
  <tr>
    <td valign="middle" class="table-raw-title" style="text-align:left; height:30px;"><div class="section-title"><a name="Sp"></a>Manage Sponsors</div></td>
  </tr>
  <tr>
    <td align="left" valign="middle" height="20"></td>
  </tr>
  <tr>
    <td align="left" valign="middle" style="text-align:left;">
	<form name="frmsponsors" id="frmsponsors" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>" enctype="multipart/form-data" onSubmit="return validationSpo();">
	<input type="hidden" name="SERVER_ROOT" id="SERVER_ROOT" value="<?PHP echo SERVER_ROOT; ?>" /> 
    <input type="hidden" name="SERVER_HOST" id="SERVER_HOST" value="<?PHP echo SERVER_HOST; ?>" /> 
	<table width="95%" border="0" align="center" cellpadding="0" cellspacing="0" class="spo2">
      <tr>
        <td width="15%" height="25" align="left" valign="middle">Name:</td>
        <td width="81%" height="25" align="left" valign="middle"><input name="txtsponsors_name" type="text" class="listtab-input" id="txtsponsors_name" value="" /> <span class="red">*</span></td>
      </tr>
      <tr>
        <td height="25" align="left" valign="top">Logo:</td>
        <td height="25" align="left" valign="middle"><input type="file" id="txtsponsors_logo" name="txtsponsors_logo" /> <span class="red">*</span>
		<div id="uploadedImg_S" style="display:none;">
		</div></td>
      </tr>
      <tr>
        <td height="25" align="left" valign="top">Description:</td>
        <td height="25" align="left" valign="middle"><textarea name="txtsponsors_description" class="listtab-text-box" id="txtsponsors_description" cols="45" rows="5"></textarea> <span class="red">*</span></td>
      </tr>
      <tr>
        <td height="25" align="left" valign="middle">Website:</td>
        <td height="25" align="left" valign="middle"><input name="txtsponsors_website" type="text" class="listtab-input" id="txtsponsors_website" value="" /> <span class="red">*</span> (e.g. http://www.example.com)</td>
      </tr>
      <tr>
        <td align="left" valign="middle">&nbsp;</td>
        <td height="25" align="left" valign="top"><input type="submit" value="Save" id="btnSponsor" class="btn_img" name="btnSponsor"></td>
      </tr>
    </table>
	<input type="hidden" name="alreadyUploaded_S" id="alreadyUploaded_S" value="" />
	<input type="hidden" name="hdnmode_S" id="hdnmode_S" value="<?php echo ADD;?>"/>
    <input type="hidden" name="hdnsponsors_id" id="hdnsponsors_id" value=""/>
	</form>
    <br />
<br />
<div id="sponsorsList">
<table width="95%" align="center" cellpadding="0" cellspacing="0" class="listtab">
      <tr>
        <td width="27%" bgcolor="#a6caf4" class="listtab-td"><strong>Name</strong></td>
        <td width="58%" align="left" bgcolor="#a6caf4" class="sponsors-table2"><strong>Logo</strong></td>
        <td width="15%" bgcolor="#a6caf4" class="sponsors-table-right"><strong>Action </strong></td>
        </tr>
		<?PHP if(count($aSponsorsDetail)>0) {  
			for($i=0;$i<count($aSponsorsDetail);$i++)
			{
			//$sponsorPath = AMAZON_S3_LINK.BUCKET_NAME."/ElectionImpactProd/files/sponsors/" . $aSponsorsDetail[$i]['sponsors_logo'];
			$sponsorPath = SERVER_HOST.SPONSER_IMAGE . $aSponsorsDetail[$i]['sponsors_logo'];
		?>
		<tr class="row02">
        <td class="listtab-td"><?PHP echo $aSponsorsDetail[$i]['sponsors_name']; ?></td>
        <td align="left" class="sponsors-table-bottam"><img src='<?PHP echo $sponsorPath;?>' alt='<?PHP echo $aSponsorsDetail[$i]['sponsors_name']; ?>'  title='<?PHP echo $aSponsorsDetail[$i]['sponsors_name']; ?>' /></td>
        <td class="sponsors-table-right1"><table width="50%" border="0" cellspacing="0" cellpadding="0" class="listtab-rt-bro1">
          <tr>
            <td align="left" valign="middle"><a href="#Sp"><img src="<?PHP echo SERVER_CLIENT_HOST; ?>images/edit.png" width="16" height="17" onclick="return setSponsorsDetails('<?PHP echo $objEncDec->encrypt($aSponsorsDetail[$i]["sponsors_id"]); ?>');"></a></td>
            <td align="left" valign="middle"><a href="javascript:deleteSponsorsDetails('<?PHP echo $objEncDec->encrypt($aSponsorsDetail[$i]["sponsors_id"]); ?>');"><img src="<?PHP echo SERVER_CLIENT_HOST; ?>images/delete2.gif" width="16" height="16"></a></td>
          </tr>
        </table></td>
        </tr>
		<?PHP }  } else {  ?>
		  <tr class="row01">
			<td align="center" colspan="3">No Sponsors Details Added Yet!</td>
		   </tr>
		<?PHP } ?>
    </table>
</div>	
	</td>
  </tr>
</table>
<?php if($objPlan->custom_domain == 1) { ?>
<script type="text/javascript">
	domainFunction(<?PHP echo $objWebsite->is_subdomain; ?>);
</script>
<?php } ?>	