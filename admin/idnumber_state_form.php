<table cellpadding="0" cellspacing="0" border="0" width="100%"> 
	<tr>
      <td>
      <div>
		<form name="frm" id="frm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="javascript: return validate();">				  
		<table class="listtab" cellpadding="0" cellspacing="0" border="0" width="100%" style="clear:both;">				  
			<tr class="row01">
				<td align="left" valign="top" class="txtbo">State:&nbsp;<span class="compulsory">*</span></td>
				<td width="82%" align="left" valign="top">
					<?php if($state_id == 0) { ?>
					  <select name="selState" id="selState">
					  <option value="">Select State</option>
					  <?php for ($i=0;$i<count($arrState);$i++){ ?>
					  <option value="<?php echo $arrState[$i]['state_id'];?>" <?php if($arrState[$i]['state_id'] == $state_id) { echo "selected";} ?>><?php echo $arrState[$i]['state_code'];?> - <?php echo $arrState[$i]['state_name'];?></option>
					  <?php } ?>
					  </select>
					  <?php } else { ?>
					  <strong><?php echo $objstate->state_code ." - ".$objstate->state_name;?></strong>				
					  <input type="hidden" name="selState" value="<?php echo $state_id;?>">		
					  <?php } ?>
				</td>
			</tr>	
					<tr class="row01">
					  <td align="left" valign="top" class="txtbo">ID Number:&nbsp;<span class="compulsory">*</span></td>
					  <td width="82%" align="center" valign="top">
					  (<strong>Note:</strong> To select "ID Number" move it from "Available ID Number(s)" to "Selected ID Number(s)") 	
					  <input type="hidden" name="selidnumber" id="selidnumber">
				<div class="dhe-body">
<div id="center-wrapper">
	<div class="dhe-example-section" id="ex-2-1">
		<div class="dhe-example-section-content">
			<!-- BEGIN: XHTML for example 2.1 -->
			<div id="example-2-1">
				<div class="column left first">
					<p style="text-Align:center !important; font-weight:bold !important; margin:5px !important;">Selected ID Number(s):</p>
					<ul class="sortable-list">
					<?php
					if(isset($Idnumberdata)){
					for($k=0;$k<count($Idnumberdata);$k++)
					{
					?>
						<li class="sortable-item" id="<?php echo $Idnumberdata[$k]['id_number_id'];?>">
							<?php echo $Idnumberdata[$k]['id_number_name'];?>
						</li>
				<?php
					}}
				?>
					</ul>
				</div>

				<div class="column left">
					<p style="text-Align:center !important; font-weight:bold !important; margin:5px !important;">Available ID Number(s):</p>
					<ul class="sortable-list">
<?php 
$i=0; 
for($i=0;$i<count($arrIdnumber);$i++)
{
	$show=1;
	if(isset($Idnumberdata)){
	for($k=0;$k<count($Idnumberdata);$k++)
	{
		if($arrIdnumber[$i]['id_number_id']!=$Idnumberdata[$k]['id_number_id'] )
		{
			$show=1;
		}
		else
		{
			$show=0;
			break;
		}
	}}
	if($show==1)
	{		
?>
	<li class="sortable-item" id="<?php echo $arrIdnumber[$i]['id_number_id'];?>">
		<?php echo $arrIdnumber[$i]['id_number_name'];?>
	</li>
<?php 
	}
}
?>
	</ul>
</div>

</div>
	<div class="clearer">&nbsp;</div>
<!-- END: XHTML for example 2.1 -->
	</div>
</div>
</div>
					  
				<!--	  <select name="selRaceGroup" id="selRaceGroup">
					  <option value="">Select ID Number</option>
					  <?php for ($i=0;$i<count($arrEligCrit);$i++){ ?>
					  <option value="<?php echo $arrEligCrit[$i]['id_number_id'];?>" <?php if($arrEligCrit[$i]['id_number_id'] == $objStateIdNumber->id_number_id) { echo "selected";} ?>><?php echo $arrEligCrit[$i]['id_number_name'];?></option>
					  <?php } ?>
					  </select>-->
					  </td>
					</tr>
					<tr class="row01">
		  <td align="left" valign="top" class="txtbo">Language</td>
		  <td width="82%" align="left" valign="top">
		  <table cellpadding="0" cellspacing="0" border="0" width="80%" style="clear:both;">
		  <?php
		  $arrLanguages = $objStateIdNumber->fetchIdNumberNoteLanguage();		
		  $arrIdNumberLanguages = $objStateIdNumber->fetchIdNumberLanguageDetail();

		for($i=0;$i<count($language);$i++)
		{
			$checked='';
			$disabled ='';
			if($language[$i]['language_id']==1)
			{
					$checked = 'checked';
					$disabled = 'disabled="disabled"';
			}
			
			if(in_array($language[$i]['language_id'],$arrLanguages))
			{
				$checked = 'checked';
			}									
			
			if($i%3==0){
			echo "<tr>";$j=0;}
		  ?>
			  <td><input type="checkbox" name="language[]" value="<?php echo $language[$i]['language_id']?>" id="<?php echo $language[$i]['language_name']?>" <?php echo $checked?> <?php echo $disabled?> onclick="display_lanrows('<?php echo $language[$i]['language_name']?>', '<?php echo $language[$i]['language_id']?>')"   />	
			  <?php echo $language[$i]['language_name']?></td>
			  <?php if($j==3){
			echo "</tr>";
			} }?>
			
		  </table></td>
		  </tr>	
					<?php $state_idnumber_note_text = "";
		  for($i=0;$i<count($language);$i++) {
								$styleDetail = '';
								$lableField = 'Note:';								
								
								if($language[$i]['language_id']!=1)
								{
									$styleDetail = 'style="display:none;"';
									$lableField = '&nbsp;';
									$state_idnumber_note_text = "";
								}
	
								if(isset($_POST["language"]) && in_array($language[$i]['language_id'],$_POST["language"]))
								{
									$styleDetail = '';
									
									if(isset($_POST["id_number_note_".$language[$i]['language_id']]))
									{
										$state_idnumber_note_text = $cmn->readValueDetail($_POST["id_number_note_".$language[$i]['language_id']]);
									}
									else
									{	
										if(isset($arrIdNumberLanguages[$language[$i]['language_id']]['state_idnumber_note_text']))
											$state_idnumber_note_text = $cmn->readValueDetail($arrIdNumberLanguages[$language[$i]['language_id']]['state_idnumber_note_text']);
									}		
								}
								else if(!isset($_POST["language"]) && count($_POST) > 0 && $language[$i]['language_id']!=1)
								{
									$styleDetail = 'style="display:none;"';
								}
								else if(in_array($language[$i]['language_id'],$arrLanguages))
								{
									$styleDetail = '';
									
									if(isset($_POST["id_number_note_".$language[$i]['language_id']]))
									{
										$state_idnumber_note_text = $cmn->readValueDetail($_POST["id_number_note_".$language[$i]['language_id']]);
									}
									else
									{										
										if(isset($arrIdNumberLanguages[$language[$i]['language_id']]['state_idnumber_note_text']))
											$state_idnumber_note_text = $cmn->readValueDetail($arrIdNumberLanguages[$language[$i]['language_id']]['state_idnumber_note_text']);
									}		
								}								
					  ?>
					<tr class="row01" <?php echo $styleDetail;?> id="id_numbernote_<?php echo $language[$i]['language_name']?>">
						<td align="left" valign="top" class="txtbo"><?php echo $lableField?>	&nbsp;</td>
			
						<td align="left" valign="top" >
							<input  class="input_text" type="text" name="id_number_note_<?php echo $language[$i]['language_id']?>" value="<?php echo $state_idnumber_note_text?>" id="id_number_note_<?php echo $language[$i]['language_id']?>" maxlength="400" />	<img src="images/<?php echo $language[$i]['language_icon']?>" style="margin-left:10px;" />					</td>
					</tr>
					<?php } ?>
					<tr class="row01">
						<td align="left" valign="top" >&nbsp;						</td>
						<td align="left" valign="top" >
							<input  type="submit" class="btn" name="btnidnumbersave" id="btnidnumbersave" value="Save" title="Save"/>
							<input  type="button" title="Cancel" name="btncanel" id="btncanel" onclick="<?php echo $cancel_button ?>" value="Cancel" class="btn" />							
						<input  class="input_text" type="hidden" name="idnumber_state_id" id="idnumber_state_id" value="<?php echo $objStateIdNumber->idnumber_state_id;?>" />		
						</td>
					</tr>
				</table>
		</form>
			</div>
		</td>
	</tr>
</table>