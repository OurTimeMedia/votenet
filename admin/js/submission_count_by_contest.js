var displayDivId;

function getxmlhttpobject(handler)
{ 
	var objXmlHttp=null

	if (navigator.userAgent.indexOf("MSIE")>=0)
	{ 
		var strName="Msxml2.XMLHTTP"
		if (navigator.appVersion.indexOf("MSIE 5.5")>=0)
		{
			strName="Microsoft.XMLHTTP"
		} 
		try
		{ 
			objXmlHttp=new ActiveXObject(strName)
			objXmlHttp.onreadystatechange=handler 
			return objXmlHttp
		} 
		catch(e)
		{ 
			alert("Error. Scripting for ActiveX might be disabled") 
			return 
		} 
	} 
	if (navigator.userAgent.indexOf("Mozilla")>=0 || navigator.userAgent.indexOf("Opera")>=0)
	{
		objXmlHttp=new XMLHttpRequest()
		objXmlHttp.onload=handler
		objXmlHttp.onerror=handler 
		
		return objXmlHttp
	}
}

function stateChangedUpdate() 
{
	if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete")
	{ 	
		if (xmlHttp.responseText != '' && xmlHttp.responseText != '')
		{	
			document.getElementById(displayDivId).style.display = 'block';
			if(document.getElementById('contestDivID'))
			{
				document.getElementById('contestDivID').style.display = 'none';
			}
			document.getElementById(displayDivId).innerHTML = xmlHttp.responseText;
		}
	} 
}

function showActiveContests(clientId,contestId)
{
	
	displayDivId = 'contestDiv';
	
	if (clientId != '' && clientId != 0 )
	{
		document.getElementById('exportDiv').style.display = 'none';
		
		url = "reports_submission_count_by_contest_ajax.php?client_id="+clientId;
	
		if (contestId != '')
		{
			document.getElementById('exportDiv').style.display = 'block';
			
			url = url+"&contest_id="+contestId;
		}
		
		xmlHttp=getxmlhttpobject(stateChangedUpdate);
		xmlHttp.open("GET", url , true);
		xmlHttp.send(null);
	}
	
}

function showActivateContests(clientId,contestId)
{
	
	displayDivId = 'contestDivIDAjax';
	
	if (clientId != '' && clientId != 0 )
	{
	
		url = "reports_lookup_judgment_ajax.php?client_id="+clientId;
	
		if (contestId != '')
		{
		
			url = url+"&contest_id="+contestId;
		}
	
		xmlHttp=getxmlhttpobject(stateChangedUpdate);
		xmlHttp.open("GET", url , true);
		xmlHttp.send(null);
	}
	else
	{
			document.getElementById('contestDivIDAjax').style.display = 'none';
			document.getElementById('contestDivID').style.display = '';
	}
	
}


function showCompletedContests(clientId,contestId)
{
	
	displayDivId = 'contestDivIDAjax';
	
	if (clientId != '' && clientId != 0 )
	{
	
		url = "reports_revenue_client_per_contest_ajax.php?client_id="+clientId;
	
		if (contestId != '')
		{
		
			url = url+"&contest_id="+contestId;
		}
	
		xmlHttp=getxmlhttpobject(stateChangedUpdate);
		xmlHttp.open("GET", url , true);
		xmlHttp.send(null);
	}
	else
	{
			document.getElementById('contestDivIDAjax').style.display = 'none';
			document.getElementById('contestDivID').style.display = '';
	}
	
}


function showReport()
{
	clientId = document.getElementById('client_id').value;
	
	
	
	if (clientId != '' && clientId != 0 )
	{
		contestId = document.getElementById('contest_id').value;
		
		if (contestId == -1)
		{
			alert("No active contest is available for selected client");
			return false;
		}
		else if (contestId != '' && contestId != 0 )
		{
			document.frm.submit();
		}
		else
		{
			alert("Please select contest");
			return false;
		}
		
	}
}

