function searchrecord()
{
	document.frm.txtcurrentpage.value = "1";
	document.frm.submit();	
}

function searchclear()
{
	window.location.href="send_notification_list.php";
}

function setaction(actiontype)
{	
	document.frm.action = "send_notification_list.php";
	
	if (actiontype=="delete")
	{
		mycount = 0;
		
		for(i=0;i<document.frm.elements.length;i++)
		{
			if(document.frm.elements[i].name=="deletedids[]" && document.frm.elements[i].checked)
			{
				mycount++;	
			}
		}

		if(mycount==0)
		{
			alert("You must check at least one checkbox.");
			return false;
		}
	
		if(confirm("Are you sure you want to delete selected Notification(s)?"))
		{	
			document.frm.hdnmode.value = "delete";
			document.frm.submit();
			return;
		}
		else
			return false;
	}
}

function setfocus()
{
	document.frm.txtnotification_title.focus();
}

function selectAllCmbVal(selObj)
{
	if(selObj.value=="All")
	{
		selObj.options[1].selected=false; 
		for (i = 2; i < selObj.options.length; i++) { 
			selObj.options[i].selected=true; 
		}
		
	}
}

function validate()
{

	var index = 0;
	var arValidate = new Array;
	arValidate[index++] = new Array("R", "document.frm.txtnotification_title", "Title/Subject Line");
	
	if (!Isvalid(arValidate)){
		return false;
	}
	
	tinyMCE.triggerSave(); 
	var index = 0;
	var arValidate = new Array;
	arValidate[index++] = new Array("R", "document.frm.txtnotification_body", "Message");
	
	if (!Isvalid(arValidate)){
		tinyMCE.execCommand('mceFocus', false, 'txtnotification_body');
		return false;
	}
	
	/*var oEditor = FCKeditorAPI.GetInstance('txtnotification_body');
	var contents = oEditor.GetXHTML(true); 
	var txtnotification_body = document.getElementById('txtnotification_body___Frame');
	if (contents == "null" || contents == "" )
	{
		alert("Message can not be blank.")
		txtnotification_body.focus();
		return false;
	}*/

	var index = 0;
	var arValidate = new Array;
	arValidate[index++] = new Array("S", "document.frm.selnotification_type", "Message Type");
	arValidate[index++] = new Array("S", "document.frm.selnotification_user_type", "User Type");
	//arValidate[index++] = new Array("R", "document.frm.txtnotification_usernames", "User Names");
	if (!Isvalid(arValidate)){
		return false;
	}
		
	/*var unames = document.frm.txtnotification_usernames.value;
	usernames = unames.split(",");

	for(i=0;i<usernames.length;i++)
	{
		var un = usernames[i]+",";
		var u = document.frm.definedUsers.value;
		if(u.indexOf(un)==-1)
		{
			alert("Please Enter valid User Names!");
			document.frm.txtnotification_usernames.focus();
			return false;
		}
	}*/

	arValidate[index++] = new Array("R", "document.frm.txtnotification_send_date", "Send Date-Time");
	
	if (!Isvalid(arValidate)){
		return false;
	}
	
	var index = 0;
	var arValidate = new Array;
	//arValidate[index++] = new Array("R", "document.frm.rdonotification_isactive", "Active");
	arValidate[index++] = new Array("S", "document.frm.rdonotification_isactive", "Active");
	if (!Isvalid(arValidate)){
		return false;
	}
	return true;	
}