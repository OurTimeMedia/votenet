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
					  <td align="left" valign="top" class="txtbo">Race Group:</td>
					  <td width="82%" align="center" valign="top">					
(<strong>Note:</strong> To select "Race Group" move it from "Available Race Group(s)" to "Selected Race Group(s)") 						  
					   <input type="hidden" name="selRaceGroup" id="selRaceGroup">
				<div class="dhe-body">
<div id="center-wrapper">
	<div class="dhe-example-section" id="ex-2-1">
		<div class="dhe-example-section-content">
			<!-- BEGIN: XHTML for example 2.1 -->
			<div id="example-2-1">
				<div class="column left first">
				<p style="text-Align:center !important; font-weight:bold !important; margin:5px !important;">Selected Race Group(s):</p>
	<ul class="sortable-list">
	<?php
	if(isset($racegroupdata)){
	for($k=0;$k<count($racegroupdata);$k++)
	{
	?>
		<li class="sortable-item" id="<?php echo $racegroupdata[$k]['race_group_id'];?>">
			<?php echo $racegroupdata[$k]['race_group_name'];?>
		</li>
<?php
	}}
?>
	</ul>
</div>
				<div class="column left">
					<p style="text-Align:center !important; font-weight:bold !important; margin:5px !important;">Available Race Group(s):</p>
					<ul class="sortable-list">
<?php 
$i=0; 
for($i=0;$i<count($arrRacegroup);$i++)
{
	$show=1;
	if(isset($racegroupdata)){
	for($k=0;$k<count($racegroupdata);$k++)
	{
		if($arrRacegroup[$i]['race_group_id']!=$racegroupdata[$k]['race_group_id'] )
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
	<li class="sortable-item" id="<?php echo $arrRacegroup[$i]['race_group_id'];?>">
		<?php echo $arrRacegroup[$i]['race_group_name'];?>
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
					  </td>
					</tr>
					<tr class="row01">
						<td align="left" valign="top" >&nbsp;						</td>
						<td align="left" valign="top" >
							<input  type="submit" class="btn" name="btnracegroupsave" id="btnracegroupsave" value="Save" title="Save"/>
							<input  type="button" title="Cancel" name="btncanel" id="btncanel" onclick="<?php echo $cancel_button ?>" value="Cancel" class="btn" />							
							<input  class="input_text" type="hidden" name="racegroup_state_id" id="racegroup_state_id" value="<?php echo $objStateRaceGroup->racegroup_state_id;?>" />														
						</td>
					</tr>
				</table>
		</form>
			</div>
		</td>
	</tr>
</table>