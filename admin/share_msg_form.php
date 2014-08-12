<form name="frm" id="frm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="javascript: return validate();" enctype="multipart/form-data">
	<table width="100%" cellspacing="0" cellpadding="0" border="0" align="center" style="clear:both;" class="listtab">					
		<tr>
		  <td valign="middle" bgcolor="#a9cdf5" style="text-align:left; height:30px;" class="txtbo" colspan="2">Facebook Share</td>
		</tr>
		<tr class="row01">
		  <td valign="top" align="left" class="txtbo">Default Message:</td>
		  <td width="82%" valign="middle" align="left"><textarea  cols="50" rows="5" name="fcontent" id="fcontent"><?php echo $cmn->readValue($data['fb_content']); ?></textarea></td>
		</tr>
		<tr>
		  <td valign="middle" bgcolor="#a9cdf5" style="text-align:left; height:30px;" class="txtbo" colspan="2">Twitter Share</td>
		</tr>
		<tr class="row01">
		  <td valign="top" align="left" class="txtbo">Default Message:</td>
		  <td width="82%" valign="middle" align="left"><textarea  cols="50" rows="5" name="tcontent" id="tcontent"><?php echo $cmn->readValue($data['tw_content']); ?></textarea></td>
		</tr>
		<tr>
		  <td valign="middle" bgcolor="#a9cdf5" style="text-align:left; height:30px;" class="txtbo" colspan="2">Google Plus Share</td>
		</tr>
		<tr class="row01">
		  <td valign="top" align="left" class="txtbo">Default Title:</td>
		  <td width="82%" valign="middle" align="left"><input type="textbox" name="gtitle" id="gtitle" value="<?php echo $cmn->readValue($data['google_title']);?>" style="width:295px;"></td>
		</tr>
		<tr class="row01">
		  <td valign="top" align="left" class="txtbo">Default Message:</td>
		  <td width="82%" valign="middle" align="left"><textarea  cols="50" rows="5" name="gcontent" id="gcontent"><?php echo $cmn->readValue($data['google_content']); ?></textarea></td>
		</tr>
		<tr>
		  <td valign="middle" bgcolor="#a9cdf5" style="text-align:left; height:30px;" class="txtbo" colspan="2">Tumblr Share</td>
		</tr>
		<tr class="row01">
		  <td valign="top" align="left" class="txtbo">Default Title:</td>
		  <td width="82%" valign="middle" align="left"><input type="textbox" name="tumblrtitle" id="tumblrtitle" value="<?php echo $cmn->readValue($data['tumblr_title']);?>"  style="width:295px;"></td>
		</tr>
		<tr class="row01">
		  <td valign="top" align="left" class="txtbo">Default Message:</td>
		  <td width="82%" valign="middle" align="left"><textarea  cols="50" rows="5" name="tucontent" id="tucontent"><?php echo $cmn->readValue($data['tumblr_content']); ?></textarea></td>
		</tr>
		<tr class="row01">
		  <td valign="top" align="left" class="txtbo">&nbsp;</td>
		  <td width="82%" valign="middle" align="left"><input  type="submit" class="btn" name="btnSave" id="btnSave" value="Save"/></td>
		</tr>
	</table>	
</form>