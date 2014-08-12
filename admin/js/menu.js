// JavaScript Document
function submitfrm(frm)
{ 

	/* if(frm.cbomenu_parent_id.value == 0)
	{
		alert("Please select parent menu.");
		frm.cbomenu_parent_id.focus();
		return false;
	} */
	if(frm.cbomenu_group_id.value == 0)
	{
		alert("Please select menu group.");
		frm.cbomenu_group_id.focus();
		return false;
	}
	if(trim(frm.txtmenu_name.value).length==0)
	{
		alert("Please enter menu name.");
		frm.txtmenu_name.focus();
		return false;
	}

	if(trim(frm.txtmenu_pagename.value).length==0)
	{
		alert("Please enter menu pagename.");
		frm.txtmenu_pagename.focus();
		return false;
	}

	if(trim(frm.txtmenu_link.value).length==0)
	{
		alert("Please enter menu link.");
		frm.txtmenu_link.focus();
		return false;
	}

	if(trim(frm.txtmenu_order.value).length==0)
	{
		alert("Please enter menu order.");
		frm.txtmenu_order.focus();
		return false;
	}

}

function searchrecord()
{
	document.frm.txtcurrentpage.value = "1";
	document.frm.submit();	
}

function searchclear()
{
	window.location.href="menu_list.php";
}

function setaction(actiontype)
{	
	document.frm.action = "menu_db.php";
	
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
	
		if(confirm("Are you sure you want to delete selected body style(s)?"))
		{
			document.frm.mode.value = "delete";
			document.frm.submit();
			return;
		}
		else
			return false;
	}
	else if (actiontype=="active")
	{
		document.frm.mode.value = "active";
		document.frm.submit();		
	}
	
}

function setfocus()
{
	document.frm.txtmenu_name.focus();
}