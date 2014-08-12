<form name="frm" id="frm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="javascript: return validate();" enctype="multipart/form-data">
	
	<table cellpadding="0" cellspacing="0" border="0" class="listtab">

		<tr class="row01" >
			<td align="left" valign="top" width="15%"  class="txtbo">
				Language Name:&nbsp;<?php print COMPULSORY_FIELD; ?>
			</td>

			<td align="left" valign="top">
				<input  class="input_text" type="text" name="txtlanguage_name" id="txtlanguage_name" value="<?php echo htmlspecialchars($objLanguage->language_name); ?>" maxlength="100" />
			</td>

		</tr>
        
        <tr class="row01" >
			<td align="left" valign="top" width="15%"  class="txtbo">
				Language Code:&nbsp;<?php print COMPULSORY_FIELD; ?>
			</td>

			<td align="left" valign="top">
				<input  class="input_small" type="text" name="txtlanguage_code" id="txtlanguage_code" value="<?php echo htmlspecialchars($objLanguage->language_code); ?>" maxlength="5" />
			</td>

		</tr>
        
        <tr class="row01">
			<td align="left" valign="top" class="txtbo">
				Image:
			</td>

			<td align="left" valign="top">
			
				<?php 
                  
                  if (!empty($objLanguage->language_icon)) {
                  	
						?>
							<input type="hidden" name="alreadyUploaded" value="<?php echo $objLanguage->language_icon;?>" />
							<img src='<?php echo SERVER_HOST ?>common/files/image.php/<?php echo $objLanguage->language_icon?>?width=16&amp;height=16&amp;cropratio=1:1&amp;image=/files/languages/<?php echo $objLanguage->language_icon?>' alt='<?php echo htmlspecialchars($objLanguage->language_name); ?>'  title='<?php echo htmlspecialchars($objLanguage->language_name); ?>' />
			<br/><br/>
						<?php
						
                  }
                  ?>
				<input class="input_text" type="file" name="language_icon" id="language_icon" />
			</td>

		</tr>
        
        <tr class="row01" >
			<td align="left" valign="top" width="15%"  class="txtbo">
				Language Order:&nbsp;<?php print COMPULSORY_FIELD; ?>
			</td>

			<td align="left" valign="top">
				<input  class="input_small" type="text" name="txtlanguage_order" id="txtlanguage_order" value="<?php echo htmlspecialchars($objLanguage->language_order); ?>" maxlength="2"/>
			</td>

		</tr>

		<tr class="row01">
			<td align="left" valign="top" class="txtbo">
				Active:
			</td>

			<td align="left" valign="top">
				<label><input  type="radio" name="rdolanguage_isactive" id="rdolanguage_isactive" class="radio" value="1" <?php ($objLanguage->language_isactive==1) ? print 'checked="checked"' : '' ?> />Yes</label>
				<label><input  type="radio" name="rdolanguage_isactive" id="rdolanguage_isactive" class="radio" value="0" <?php ($objLanguage->language_isactive==0) ? print 'checked="checked"' : '' ?> />No</label>
			</td>

		</tr>
        
        <tr class="row01">
			<td align="left" valign="top" class="txtbo">
				Publish:
			</td>

			<td align="left" valign="top">
				<label><input  type="radio" name="rdolanguage_ispublish" id="rdolanguage_ispublish" class="radio" value="1" <?php ($objLanguage->language_ispublish==1) ? print 'checked="checked"' : '' ?> />Yes</label>
				<label><input  type="radio" name="rdolanguage_ispublish" id="rdolanguage_ispublish" class="radio" value="0" <?php ($objLanguage->language_ispublish==0) ? print 'checked="checked"' : '' ?> />No</label>
			</td>

		</tr>
        <tr class="row01">
        	<td class="txtbo" colspan="2">&nbsp;</td>
        </tr>
        <tr class="blue_title">
			<td align="left" valign="top" class="blue_title_rt" colspan="2">
				Language Configuration Section mock-up for Language : <?php echo htmlspecialchars($objLanguage->language_name); ?>
			</td>
		</tr>
       
        <?PHP
		   if(is_array($resourceArray))
		   {
		   		for($i=0;$i<count($resourceArray);$i++)
				{
					$resDtl = $objLanguage->fetchLanguageResourceRel($resourceArray[$i]["resource_id"],$objLanguage->language_id);
					?>
                    <tr class="row01">
                    <td align="left" valign="top" class="txtbo" colspan="2">
                     <?PHP echo ucwords(strtolower($resourceArray[$i]["resource_text"])); ?>: <br />
                     <input  class="input_text_title" type="hidden" name="txtField<?PHP echo $i; ?>" id="txtField<?PHP echo $i; ?>" value="<?PHP echo $resourceArray[$i]["resource_id"]."###".ucwords(strtolower($resourceArray[$i]["resource_text"])); ?>" maxlength="255" />
                       <input  class="input_text_title" type="text" name="txt<?PHP echo $resourceArray[$i]["resource_id"]; ?>" id="txt<?PHP echo $resourceArray[$i]["resource_id"]; ?>" value="<?php echo html_entity_decode(htmlspecialchars($resDtl["resource_text"])); ?>" maxlength="500" />
                    </td>
        
                </tr>
		<?PHP	}
		   }
		?>
	    
		<tr class="row01">
			<td align="left" valign="top"  class="txtbo">&nbsp;
			</td>
			<td align="left" valign="top" >
				<input  type="submit" class="btn" name="btnsave" id="btnsave" value="Save"/>
				<input  type="button" title="Cancel" name="btncanel" id="btncanel" onclick="<?php echo $cancel_button ?>" value="Cancel" class="btn" />
				<input type="hidden" name="hdnmode" id="hdnmode" value="<?php echo $mode; ?>" />
				<input type="hidden" name="hdnlanguage_id" id="hdnlanguage_id" value="<?php echo $objLanguage->language_id; ?>"/>
				
				<input type="hidden" name="hdnclient_id" id="hdnclient_id" value="0"/>
				<input type="hidden" name="hdnlanguage_order" id="hdnlanguage_order" value="0"/>
                <input type="hidden" name="txttotfields" id="txttotfields" value="<?PHP echo count($resourceArray); ?>" />
			</td>
		</tr>
	</table>
</form>