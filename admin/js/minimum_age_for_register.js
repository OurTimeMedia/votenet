function validate()
{		
	var boxes = document.getElementsByTagName("textarea"); 
	
	for(var i = 0; i < boxes.length; i++)
	{
		var boxnamearr = boxes[i].name.split("_");
		
		if(boxnamearr.length == 2)
		{
			var selectedc = 0;
			//var cfieldname = eval("document.frm.chkAgeCriteria_"+boxnamearr[1]);
			var cfieldname = document.frm.elements["chkAgeCriteria_"+boxnamearr[1]+"[]"];
					
			for(var j=0; j < cfieldname.length; j++)
			{
				if(cfieldname[j].checked == true)
					selectedc++;
			}
			
			if(selectedc == 0)
			{
				alert("Please select Age Criteria for all states.");
				cfieldname[0].focus();
				return false;			
			}
			
			if(boxes[i].value.split(" ").join("").length==0)
			{
				alert("Please enter Notes for all states.");
				boxes[i].focus();
				return false;	
			}	
		}	
	}
	
	return true;	
}

function showHideElectionType(election_type, state_id)
{
	if(election_type.checked == true)
		document.getElementById("selElectionType_"+state_id).disabled = false;
	else
		document.getElementById("selElectionType_"+state_id).disabled = true;
}