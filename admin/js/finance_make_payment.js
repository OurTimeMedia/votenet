function searchrecord()
{
	document.frm.txtcurrentpage.value = "1";
	document.frm.submit();	
}

function search_record(frm)
{
	if(document.frm.txtdateto.value<document.frm.txtdatefrom.value && document.frm.txtdateto.value!='' && document.frm.txtdatefrom.value!='')
	{
		alert("'To Date' should be greater than 'From Date'!");
		document.frm.txtdatefrom.focus;
		return false;
	}
	return true;
}

function search_record_daily(frm)
{
	
	if(document.frm.txtdateto.value<document.frm.txtdatefrom.value && document.frm.txtdateto.value!='' && document.frm.txtdatefrom.value!='')
	{
		alert("'Payment To Date' should be greater than 'Payment From Date'!");
		document.frm.txtdatefrom.focus;
		return false;
	}
	
	if(document.frm.txtcdateto.value<document.frm.txtcdatefrom.value && document.frm.txtcdateto.value!='' && document.frm.txtcdatefrom.value!='')
	{
		alert("'Contest To Date' should be greater than 'Contest From Date'!");
		document.frm.txtcdatefrom.focus;
		return false;
	}
	return true;
}

function getxmlhttpobject(handler)
{ 
	var objXmlHttp=null

/*	if (navigator.userAgent.indexOf("Opera")>=0)
	{
		alert("This feature is not compatible with Opera") 
		return 
	}*/
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
function stateChanged() 
{
	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
		if (xmlHttp.responseText != '')
		{
			document.getElementById("ContestNames").innerHTML = xmlHttp.responseText;
			if(document.getElementById("loadingimg"))
			{
				document.getElementById("loadingimg").style.display='none';
			}
		}
	} 
}
var xmlHttp;
var divId;
function getContestBasedOnClient(client_id,contest_id,type)
{
	if(document.getElementById("loadingimg"))
	{
		document.getElementById("loadingimg").style.display='';
	}
	url = "getAjaxRelData.php?client_id="+client_id+"&contest_id="+contest_id+"&flg=contest&type="+type;
	xmlHttp=getxmlhttpobject(stateChanged);
	xmlHttp.open("GET", url , true);
	xmlHttp.send(null);
}


function validateCancel()
{
	var index = 0;
	var arValidate = new Array;
	arValidate[index++] = new Array("R", "document.frm.txtpayment_cancel_remark", "Cancel Payment Remark");
	if (!Isvalid(arValidate)){
		return false;
	}
}

function validate()
{
	var index = 0;
	var arValidate = new Array;
	
	arValidate[index++] = new Array("S", "document.frm.selclient_id", "Client");
	
	arValidate[index++] = new Array("R", "document.frm.txtamount", "Amount");
	arValidate[index++] = new Array("F", "document.frm.txtamount", "Amount");
	arValidate[index++] = new Array("GTZ", "document.frm.txtamount", "Amount");
	arValidate[index++] = new Array("S", "document.frm.selpayment_type_id", "Payment Type");
	if (!Isvalid(arValidate)){
		return false;
	}

	return true;	
}