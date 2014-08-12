function validate()
{
	var index = 0;
	var arValidate = new Array;
		
	arValidate[index++] = new Array("R", "document.frm.txtPageName", "Name of page");	
		
	if (!Isvalid(arValidate)){
		return false;
	}	
	
	var rad_val = '';
	for (var i=0; i < document.frm.rdoOption.length; i++)
    {
   		if (document.frm.rdoOption[i].checked)
      	{
      		rad_val = document.frm.rdoOption[i].value;
     	}
    }

	if(rad_val=="")
	{
		alert("Please select Option.");
		document.frm.elements["rdoOption"][0].focus();
		return false;
	}
	
	
	if(document.frm.rdoOption[1].checked == false)
	{
		arValidate[index++] = new Array("R", "document.frm.txtLink", "Link");	
		arValidate[index++] = new Array("W", "document.frm.txtLink", "Link");
	}
	else
	{
		tinyMCE.triggerSave(); 
		var index = 0;
		var arValidate = new Array;
		arValidate[index++] = new Array("R", "document.frm.txtContent", "Content");
		
		if (!Isvalid(arValidate)){
			tinyMCE.execCommand('mceFocus', false, "txtContent");
			return false;
		}
	}
		
	if (!Isvalid(arValidate)){
		return false;
	}
	return true;	
}