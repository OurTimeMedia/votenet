
<table cellpadding="0" cellspacing="0" border="0" width="100%"> 
	<tr>
      <td>
      <div>
		<form name="frm" id="frm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="javascript: return validate();">				
			      	<table class="listtab" cellpadding="0" cellspacing="0" border="0" width="100%" style="clear:both;">
					<tr class="row01">
					  <td align="left" valign="top" class="txtbo">State:</td>
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
					  <td align="left" valign="top" class="txtbo">Eligibility Criteria:					  
					  </td>
					  <td width="82%" align="center" valign="top">
					  (<strong>Note:</strong> To select "Eligibility Criteria" move it from "Available Eligibility Criteria" to "Selected Eligibility Criteria")
					 <input type="hidden" name="selEligibilityCriteria" id="selEligibilityCriteria">
				<div class="dhe-body">
<div id="center-wrapper">
	<div class="dhe-example-section" id="ex-2-1">
		<div class="dhe-example-section-content">
			<!-- BEGIN: XHTML for example 2.1 -->
			<div id="example-2-1">
				<div class="column left first">
					<p style="text-Align:center !important; font-weight:bold !important; margin:5px !important;">Selected Eligibility Criteria:</p>
					<ul class="sortable-list">
					
					<?php if(isset($eligibilitycriteriadata) && $eligibilitycriteriadata !='') { for($i=0;$i<count($eligibilitycriteriadata);$i++) {?>
					<li class="sortable-item" id="<?php echo $eligibilitycriteriadata[$i]['eligibility_criteria_id'];?>"><?php echo $eligibilitycriteriadata[$i]['eligibility_criteria'];?>
					</li>
						<?php
						}}
				?>

					</ul>

				</div>
				
				<div class="column left">
					<p style="text-Align:center !important; font-weight:bold !important; margin:5px !important;">Available Eligibility Criteria:</p>
					<ul class="sortable-list">
<?php 
$i=0; 
for($i=0;$i<count($arrEligCrit);$i++)
{
	$show=1;
	if(isset($eligibilitycriteriadata)){
	for($k=0;$k<count($eligibilitycriteriadata);$k++)
	{
		if($arrEligCrit[$i]['eligibility_criteria_id']!=$eligibilitycriteriadata[$k]['eligibility_criteria_id'] )
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
	<li class="sortable-item" id="<?php echo $arrEligCrit[$i]['eligibility_criteria_id'];?>">
		<?php echo $arrEligCrit[$i]['eligibility_criteria'];?>
	</li>
<?php 
	}
}
?>
	</ul>
</div>		
			</div>

			<div class="clearer">&nbsp;</div>

			<!-- END: XHTML for example 2.3 -->

		</div>
	</div>

	
	

</div>
					  </td>
					</tr>
					<tr class="row01">
						<td align="left" valign="top" >&nbsp;						</td>
						<td align="left" valign="top" >
							<input  type="submit" class="btn" name="btnEligibilityCriteria" id="btnEligibilityCriteria" value="Save" title="Save"/>
							<input  type="button" title="Cancel" name="btncanel" id="btncanel" onclick="<?php echo $cancel_button ?>" value="Cancel" class="btn" />							
							<input  class="input_text" type="hidden" name="eligibility_state_id" id="eligibility_state_id" value="<?php echo $objStateElig->eligibility_state_id;?>" />														
						</td>
					</tr>
				</table>
		</form>
			</div>
		</td>
	</tr>
</table>