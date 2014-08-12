/*	function fetch_remote_page(AJAXURL, action)
{ 
	var xmlHttp;

        if (window.XMLHttpRequest) { // Mozilla, Safari, ...

         var xmlHttp = new XMLHttpRequest();

       } else if (window.ActiveXObject) { // IE

         var xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");

       }

    xmlHttp.open('POST', AJAXURL, true);

    xmlHttp.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xmlHttp.onreadystatechange = function() {

        if (xmlHttp.readyState == 4) {
			var str=xmlHttp.responseText;
			alert(str);
            document.getElementById("usr_avail").src='security_images/'+str+".jpg";

        }

    }

    xmlHttp.send(AJAXURL);
	
	
	
	
		
}*/

function fetch_remote_page(handler)
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
var xmlHttp;

function fetch_remote_page()
{	
	url = "http://192.168.10.2:8081/1848/site/security_image.php";
	xmlHttp=getxmlhttpobject(stateChanged);
	xmlHttp.open("POST", url, true); 
	xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xmlHttp.setRequestHeader("Connection", "close");
	xmlHttp.send();
}

function stateChanged() 
{		
	alert(xmlHttp.readyState)
	alert(xmlHttp.responseText)
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 	
		if (xmlHttp.responseText != '' && xmlHttp.responseText != '')
		{	
			var responceVal = xmlHttp.responseText;
			alert(responceVal);
		}
	}	
}
