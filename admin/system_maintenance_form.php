<form name="frm" id="frm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="javascript: return validate();" enctype="multipart/form-data">
	
	<table cellpadding="0" cellspacing="0" border="0" class="listtab">

		<tr class="row01" >
			<td align="left" valign="top" width="15%"  class="txtbo" colspan="2">
				Site Status:&nbsp;<br />
                <label><input  type="radio" name="rdosite_config_isonline" id="rdosite_config_isonline" class="radio" value="2" <?php ($objSystemMaintenance->site_config_isonline==2) ? print 'checked="checked"' : '' ?> /><font color="#006600">Online</font></label><br />
				<label><input  type="radio" name="rdosite_config_isonline" id="rdosite_config_isonline" class="radio" value="1" <?php ($objSystemMaintenance->site_config_isonline==1) ? print 'checked="checked"' : '' ?> /><font color="#CC0000">Off-line</font></label>
			</td>
		</tr>
		
        <tr class="row01">
			<td align="left" valign="top" class="txtbo" colspan="2">
				Off-line message:<br /><br />
                <textarea class="input_desc_more" name="txtsite_config_offline_message" id="txtsite_config_offline_message"><?php echo htmlspecialchars($objSystemMaintenance->site_config_offline_message); ?></textarea>
			</td>


		</tr>
        
        <tr class="row01">
			<td align="left" valign="top" class="txtbo" colspan="2">
				Image:<br /><br />
                 <?php 
                  
                  if (!empty($objSystemMaintenance->site_config_image)) {
                  	
						?>
							<input type="hidden" name="alreadyUploaded" value="<?php echo $objSystemMaintenance->site_config_image;?>" />
							<img src='<?php echo SERVER_HOST ?>common/files/image.php/<?php echo $objSystemMaintenance->site_config_image?>?width=200&amp;height=100&amp;cropratio=1:1&amp;image=/files/maintanance/<?php echo $objSystemMaintenance->site_config_image?>' alt=''  title='' />
			<br/><br/>
						<?php
						
                  }
                  ?>
				<input class="input_text" type="file" name="site_config_image" id="site_config_image" />
			</td>


		</tr>
       

		<tr class="row01">
			
			<td align="left" valign="top" colspan="2">
				<input  type="submit" class="btn" name="btnsave" id="btnsave" value="Save"/>
				<input type="hidden" name="hdnmode" id="hdnmode" value="<?php echo $mode; ?>" />
				<input type="hidden" name="hdnsite_config_id" id="hdnsite_config_id" value="<?php echo $objSystemMaintenance->site_config_id; ?>"/>
				
			</td>
		</tr>
	</table>
</form>