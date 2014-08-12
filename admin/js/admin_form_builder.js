var field_type = new Array(0,7,5,4,4,1,3,3,3,3,3,1,2,3,1,3,1,1);

function showHideFieldOptions(fieldtype)
{	
	if(fieldtype != "")
	{
		document.getElementById("hdnfield_type").value = field_type[fieldtype];
		document.getElementById("trFieldSelection").style.display = "";
		
		document.getElementById("trHeaderField").style.display = "";
		document.getElementById("trPdfFieldName").style.display = "";
		document.getElementById("trFieldName").style.display = "";
		
		var tr_blocks = document.getElementsByTagName("tr");
		
		for (var i = 0; i < tr_blocks.length; i++) 
		{
			var idfield = tr_blocks[i].id;
			
			if(idfield.substring(0,8) == "trLabel_")
				document.getElementById(idfield).style.display = "";
			else if(idfield.substring(0,9) == "trChoice_")
				document.getElementById(idfield).style.display = "none";	
			else if(idfield.substring(0,12) == "trFieldNote_")
				document.getElementById(idfield).style.display = "";	
				
		}
		
		document.getElementById("trRequired").style.display = "";
		document.getElementById("trHideByDefault").style.display = "";
		document.getElementById("trChoiceHeader").style.display = "none";		
		
		if(fieldtype == 1)
		{
			document.getElementById("trPdfFieldName").style.display = "none";
			document.getElementById("trHeaderField").style.display = "none";
			document.getElementById("trRequired").style.display = "none";
			
			for (var i = 0; i < tr_blocks.length; i++) 
			{
				var idfield = tr_blocks[i].id;
				
				if(idfield.substring(0,12) == "trFieldNote_")
					document.getElementById(idfield).style.display = "none";
			}
		}
		else if(fieldtype == 10 || fieldtype == 11)
		{		
			document.getElementById("trFieldName").style.display = "";
			if(fieldtype == 10)
				document.getElementById("trFieldName").style.display = "none";
				
			for (var i = 0; i < tr_blocks.length; i++) 
			{
				var idfield = tr_blocks[i].id;
				
				if(idfield.substring(0,12) == "trFieldNote_")
					document.getElementById(idfield).style.display = "none";
			}
		}
		else if((fieldtype > 6 && fieldtype <= 10) || (fieldtype > 12 && fieldtype <= 16))
		{
			document.getElementById("trFieldName").style.display = "none";
			
			for (var i = 0; i < tr_blocks.length; i++) 
			{
				var idfield = tr_blocks[i].id;
				
				if(idfield.substring(0,8) == "trLabel_")
					document.getElementById(idfield).style.display = "none";
			}			
		}		
		else if(fieldtype == 2 || fieldtype == 4 || fieldtype == 6)
		{
			document.getElementById("trChoiceHeader").style.display = "";
			
			for (var i = 0; i < tr_blocks.length; i++) 
			{
				var idfield = tr_blocks[i].id;
				
				if(idfield.substring(0,9) == "trChoice_")
					document.getElementById(idfield).style.display = "";
			}						
		}
	}
	else
	{
		document.getElementById("trFieldSelection").style.display = "none";
		document.getElementById("hdnfield_type").value = "";
	}
}

function formValidate()
{
	var fieldtype = document.getElementById("selFieldType").value;
	var defaultLanguageID = document.frm1.hdndefaultlanguage_id.value;
	var index = 0;
	var arValidate = new Array;
	
	arValidate[index++] = new Array("S", "document.frm1.selRegType", "Registration Type");
	
	if(fieldtype == 1)
	{
		arValidate[index++] = new Array("R", "document.frm1.txtFieldName", "Field Name");
		arValidate[index++] = new Array("R", "document.frm1.txtFieldLabel_"+defaultLanguageID, "Label");
	}
	else if(fieldtype <= 6 || fieldtype == 11 || fieldtype == 12 || fieldtype == 17)
	{
		arValidate[index++] = new Array("S", "document.frm1.selHeaderField", "Header Field");
		arValidate[index++] = new Array("R", "document.frm1.txtFieldName", "Field Name");
		arValidate[index++] = new Array("R", "document.frm1.txtFieldLabel_"+defaultLanguageID, "Label");
		
		if(fieldtype == 2 || fieldtype == 4 || fieldtype == 6)
			arValidate[index++] = new Array("R", "document.frm1.hidAll_Options", "Choice");
	}
	else if(fieldtype > 6)
	{
		arValidate[index++] = new Array("S", "document.frm1.selHeaderField", "Header Field");		
	}

	if (!Isvalid(arValidate)){
		return false;
	}
	return true;	
}

function addOption()
{
	var arValidate = new Array;
	jQuery("[rel=req_opt]").each(function(index)
	{		
		arValidate[index++] = new Array("R", "document.getElementById('"+jQuery(this).attr('id')+"')",  "Choice Text");		
  	});
	
	if (!Isvalid(arValidate)){		
		return false;
	}
	var languages = document.getElementById("hidlanguage_ids").value.split(",");
	
	var all_options = document.getElementById("hidAll_Options").value;
	var arrAll_options = all_options.split("^#^");				// ^#^ is for the main array with the multiple language	
	
	if(arrAll_options.length > 0)
	{
		if(document.getElementById("trOptions").style.display == "none")
			document.getElementById("trOptions").style.display = "";		
		
		var option_text = "";
		for(var lang=0; lang<languages.length; lang++)
		{			
			if(lang == 0)
			{
				option_text = document.getElementById("txtChoice_"+languages[lang]).value;
				addRow("tblOptions", option_text);
				document.getElementById("txtChoice_"+languages[lang]).value = "";
			}
			else
			{
				var option_lang_text = document.getElementById("txtChoice_"+languages[lang]).value;
				if(option_lang_text == "")
					option_lang_text = " ";
				option_text += "#^#" + option_lang_text;
				document.getElementById("txtChoice_"+languages[lang]).value = "";
			}
		}
		
		if(document.getElementById("hidAll_Options").value == "")
		{
			document.getElementById("hidAll_Options").value = option_text;
			
		}
		else
		{
			document.getElementById("hidAll_Options").value += "^#^" + option_text;
			try
			{
				document.getElementById("hidAll_Options_Id").value += "," ;
			}
			catch(err)
			{
				
			}
		}
	}
	else
	{
		document.getElementById("trOptions").style.display = "none";		
	}
}

function addRow(tableID, option_text) 		// Function used to store the funtion
{ 	
	var table = document.getElementById(tableID);	

	var rowCount = table.rows.length;
	var row = table.insertRow(rowCount);

	var cell1 = row.insertCell(0);
	cell1.innerHTML = option_text;

	var cell3 = row.insertCell(1);
	delete_img_path = "images/delete2.gif";

	cell3.innerHTML = "<img src='"+delete_img_path+"' onclick='return deleteOptipon(this)' />";
}


function deleteOptipon(ctrl)
{
	var all_options = document.getElementById("hidAll_Options").value;
	var arrAll_options = all_options.split("^#^");				// ^#^ is for the main array with the multiple language	
	
	try
	{
		var all_options_id = document.getElementById("hidAll_Options_Id").value;
		var arrAll_Options_Id = all_options_id.split(",");
	}
	catch(err)
	{ }
	
	
	arrAll_options.splice(ctrl.parentNode.parentNode.rowIndex-1,1);
	try
	{
		arrAll_Options_Id.splice(ctrl.parentNode.parentNode.rowIndex-1,1);
	}
	catch(err)
	{ }
	
	deleteRow("tblOptions", ctrl.parentNode.parentNode.rowIndex);

	document.getElementById("hidAll_Options").value = arrAll_options.join("^#^");
	
	try
	{
		document.getElementById("hidAll_Options_Id").value = arrAll_Options_Id.join(",");
	}
	catch(err)
	{
		
	}
	
	if(document.getElementById("hidAll_Options").value == "")
		document.getElementById("trOptions").style.display = "none";
}

function deleteRow(tableID, idx) 
{
	var table = document.getElementById(tableID);	
	try
	{
		table.deleteRow(idx);
	}
	catch(err)
	{
		
	}	
}

function deleteField(ctrl, field_id)
{	
	if(confirm("Are you sure you want to delete this field?"))
	{
		var data1 = "field_id="+field_id+"&mode=delete";;
		location.href="admin_form_builder.php?"+data1;
	}	
}

function remove_field_properties()
{		
	var removecondition = false;
	
	jQuery("input:radio[name=condition]:checked").each(function(index){				
		var condtion_field_id = jQuery(this).attr('id');
		document.getElementById(condtion_field_id).checked  = false;
		removecondition = true;
	  });		
	
	if(removecondition == true)
	{
		alert("Condition removed. Please save your settings.");	
		removecondition = false;
	}
}