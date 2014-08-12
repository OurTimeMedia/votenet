function searchrecord()
{
	document.frm.txtcurrentpage.value = "1";
	document.frm.submit();	
}

function searchclear()
{
	window.location.href="judge_question_list.php";
}

function setaction(actiontype)
{	
	document.frm.action = "judge_question_list.php";
	
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
	
		if(confirm("Are you sure you want to delete selected Judge Question(s)?"))
		{
			document.frm.hdnmode.value = "delete";
			document.frm.submit();
			return;
		}
		else
			return false;
	}
	else if (actiontype=="active")
	{
		document.frm.hdnmode.value = "active";
		document.frm.submit();		
	}
	
}

function setfocus()
{
	document.frm.txtusername.focus();
}

function validate()
{
	var index = 0;
	var arValidate = new Array;
	arValidate[index++] = new Array("R", "document.frm.txtjudge_question", "Question");
	arValidate[index++] = new Array("R", "document.frm.rdojudge_question_isactive", "Active");
	
	if (!Isvalid(arValidate))
	{
		return false;
	}
	
	return true;	
}