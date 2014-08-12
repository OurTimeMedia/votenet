<form name="frm" id="frm" method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
<input type="hidden" name="hdnmode" id="hdnmode" value="<?php echo $mode; ?>" />
<input type="hidden" name="hdnpage_id" id="hdnpage_id" value="<?php echo $objEncDec->encrypt($objWebsitePages->page_id); ?>"/>
<table cellpadding="0" cellspacing="0" width="100%" class="listtab12">
<tr>
  <td width="22%">Name of page:</td>
  <td width="78%"><input name="txtPageName" type="text" class="listtab-input" id="txtPageName" value="<?php echo $objWebsitePages->page_name; ?>" /> <span class="red">*</span></td>
</tr>
<tr>
  <td>Option :</td>
  <td class="radio-bro-none"><input type="radio" name="rdoOption" id="rdoOption" <?php if($objWebsitePages->page_type != "2") { echo " checked ";} ?>value="1" onClick="showHidePageOptions();"/>                                        
	Link
	<input type="radio" name="rdoOption" id="rdoOption" value="2"  onClick="showHidePageOptions();" <?php if($objWebsitePages->page_type == "2") { echo " checked ";} ?> />
	Custom Page <span class="red">*</span></td>
</tr>
<tr id="idContent">
  <td valign="top">Content:  <span class="red">*</span></td>
  <td><textarea name="txtContent" id="txtContent" cols="80" rows="25" class="mceEditor"><?php echo $objWebsitePages->page_content; ?></textarea></td>
</tr>
<tr id="idLink">
  <td valign="top">Link:</td>
  <td><input type="text" class="listtab-input" name="txtLink" id="txtLink" value="<?php echo $objWebsitePages->page_link; ?>" /> <span class="red">*</span></td>
</tr>
<tr>
  <td class="listtab-td-last">&nbsp;</td>
  <td><input name="btn_addpage" type="submit" class="btn_img" id="btn_addpage" value="Save" onClick="return validate();" />
	<input name="button2" type="submit" class="btn_img" id="button2" value="Cancel" onclick="javascript:closeWindow();" /></td>
</tr>
</table>
</form>
<script type="text/javascript" language="javascript">
function showHidePageOptions()
{	
	if(document.frm.rdoOption[1].checked == true)
	{
		document.getElementById('idLink').style.display='none';  
		document.getElementById('idContent').style.display='';
	} 
	else 
	{
		document.getElementById('idLink').style.display=''; 
		document.getElementById('idContent').style.display='none';		
	}
}
showHidePageOptions();

function closeWindow()
{
	self.parent.tb_remove(); 
}
</script>