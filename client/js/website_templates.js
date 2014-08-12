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

function setDomainInfo()
{
	var index = 0;
	var arValidate = new Array;
	
	var rad_val = '';
	for (var i=0; i < document.frm.rdoisprivate_domain.length; i++)
    {
   		if (document.frm.rdoisprivate_domain[i].checked)
      	{
      		rad_val = document.frm.rdoisprivate_domain[i].value;
     	}
    }

	if(rad_val=="")
	{
		alert("Please select Domain type.");
		document.frm.elements["rdoisprivate_domain"][0].focus();
		return false;
	}

	if(rad_val=="0")
	{
		arValidate[index++] = new Array("R", "document.frm.txtdomain", "Domain Name");
		arValidate[index++] = new Array("DM", "document.frm.txtdomain", "Domain Name");
	} else
	{
		arValidate[index++] = new Array("R", "document.frm.txtdomain", "Domain Name");
		arValidate[index++] = new Array("DMP", "document.frm.txtdomain", "Domain Name");
	}

	if(document.frm.rdoisprivate_domain[0].checked == true && document.frm.txtdomain.value == "www")
	{
		alert("'www' is not allowded in sub-domain name");
		document.frm.txtdomain.focus();	
			return false;	
	}
	
	if(document.frm.elements["rdoisprivate_domain"][0].checked)
	{
		var domainname = document.frm.txtdomain.value;
		var domainname1 = domainname.replace("/", "");
		
		if(domainname  != domainname1)
		{
			alert("Character '/' is not allowded in Domain name");
			document.frm.txtdomain.focus();	
			return false;	
		}

		var domainname1 = domainname.replace(".", "");
		
		if(domainname.length != domainname1.length)
		{
			alert("Character '.' is not allowded in Domain name");
			document.frm.txtdomain.focus();	
			return false;	
		}	
	}
	else
	{
		var domainname = document.frm.txtdomain.value;
		var domainname1 = domainname.replace("/", "");
		
		if(domainname  != domainname1)
		{
			alert("Character '/' is not allowded in Domain name");
			document.frm.txtdomain.focus();	
			return false;	
		}
	}
	
	if (!Isvalid(arValidate)){
		return false;
	}

	return true;
}

function domainFunction(isprivate_domain)
{
	if(isprivate_domain!=0)
	{
		document.getElementById('idSubDomain').style.display='none';
		document.getElementById('idprivateDomain').style.display='';
		document.frm.rdoisprivate_domain[1].checked = true;		
		document.getElementById('ishttp').style.display=''; 
		document.getElementById('ishttps').style.display='none';
		document.getElementById('chkRegistrationStep').disabled=true; 
		document.getElementById('chkRegistrationStep').checked=true; 
		document.getElementById('chkSharingEnable').disabled=true; 
		document.getElementById('chkSharingEnable').checked=true;
	}
	else
	{
		document.getElementById('idSubDomain').style.display='';
		document.getElementById('idprivateDomain').style.display='none';
		document.frm.rdoisprivate_domain[0].checked = true;
		document.getElementById('ishttps').style.display=''; 
		document.getElementById('ishttp').style.display='none';
		document.getElementById('chkRegistrationStep').disabled=false; 
		document.getElementById('chkRegistrationStep').checked=false; 
		document.getElementById('chkSharingEnable').disabled=false; 
		document.getElementById('chkSharingEnable').checked=false;
	}
}

function setTeamplateInfo()
{
	var index = 0;
	var arValidate = new Array;
	
	if(document.getElementById('rdobackground_type2').checked==true && document.frm1.filBackgroundImage.value==""  && document.frm1.alreadyUploadedBg.value=="")
	{
		alert("Please select Background Image!");
		document.frm1.filBackgroundImage.focus();
		return false;
	}

	if(document.getElementById('rdobackground_type2').checked==true && document.frm1.filBackgroundImage.value!="")
	{
		if(validateFile(document.frm1.filBackgroundImage,document.frm1.allowImageExts.value)==false)
		{
			document.frm1.filBackgroundImage.focus();
			return false;
		}
	}
	
	if(document.frm1.filBannerImage.value!="")
    {
		if(validateFile(document.frm1.filBannerImage,document.frm1.allowImageExts.value)==false)
		{
			document.frm1.filBannerImage.focus();
			return false;
		}
    }
	
	if (!Isvalid(arValidate)){
		return false;
	}
	//return true;
}

function validateFile (fld, filetypes) 
{
	filetypes = filetypes.toLowerCase();
	
	var valarr = filetypes.split("_");
	
	var files = "";	
	
	var s = fld.value.split('\\');	
	
	var ext = fld.value.split('.');	

	if (valarr.length > 0)
	{
		for (i=0; i<valarr.length; i++)
		{	
			if (trim(valarr[i]) != "")
			{
				aext = valarr[i].split('.');	
				
				if(ext[ext.length-1].toLowerCase() == aext[aext.length-1].toLowerCase())
				{
					return true;
				}
			}
		}
	}	

   alert("Invalid file type.");
   //fld.form.reset();
   fld.value = "";
   fld.focus();
   return false;
}

function deletePageDetails(page_id)
{
	if(confirm("Are you sure you want to delete selected Page Detail?"))
	{	
		url = "website_page_delete.php?page_id="+page_id+"&flg=delete";
		xmlHttp=getxmlhttpobject(stateChangedPageDelete);
		xmlHttp.open("GET", url , true);
		xmlHttp.send(null);
	}
}

function stateChangedPageDelete() 
{	
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
		var responceVal = xmlHttp.responseText.split("####");
		if (xmlHttp.responseText != '' && responceVal[0] == "Delete")
		{						
			document.getElementById('pagedetail').innerHTML = responceVal[1];
			alert("Page detail deleted successfully!");
		}
	} 
}

function validationSpo()
{
	var index = 0;
	var arValidate = new Array;

	arValidate[index++] = new Array("R", "document.frmsponsors.txtsponsors_name", "Sponsor Name");
	
	if (!Isvalid(arValidate)){
		return false;
	}
	
	var index = 0;
	var arValidate = new Array;
	
	if(document.frmsponsors.alreadyUploaded_S.value=="")
	{
		if(document.frmsponsors.txtsponsors_logo.value=="")
		{
			alert("Please upload sponsor image file.");
			document.frmsponsors.txtsponsors_logo.focus();
			return false;
		}
	}
		
	arValidate[index++] = new Array("R", "document.frmsponsors.txtsponsors_description", "Sponsor Description");
	arValidate[index++] = new Array("R", "document.frmsponsors.txtsponsors_website", "Sponsor Website");
	arValidate[index++] = new Array("W", "document.frmsponsors.txtsponsors_website", "Sponsor Website");

	if (!Isvalid(arValidate)){
		return false;
	}

	return true;
}

function setSponsorsDetails(sponsors_id)
{
	url = "website_sponsors_ajax.php?sponsors_id="+sponsors_id+"&flg=update";
	xmlHttp=getxmlhttpobject(stateChangedSpUpdate);
	xmlHttp.open("GET", url , true);
	xmlHttp.send(null);
}

function stateChangedSpUpdate() 
{
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 	
		if (xmlHttp.responseText != '' && xmlHttp.responseText != '')
		{	
			var responceVal = xmlHttp.responseText.split("####");
		
			document.frmsponsors.txtsponsors_name.value = responceVal[0];
			document.frmsponsors.txtsponsors_description.value = responceVal[1];
			document.frmsponsors.txtsponsors_website.value = responceVal[2];
			document.frmsponsors.alreadyUploaded_S.value = responceVal[3];
			
			var SERVER_ROOT = document.getElementById('SERVER_ROOT').value;
			var SERVER_HOST = document.getElementById('SERVER_HOST').value;
			document.getElementById("uploadedImg_S").style.display = '';
			document.getElementById("uploadedImg_S").innerHTML = "<img src='"+responceVal[3]+"' alt='"+responceVal[0]+"'  title='"+responceVal[0]+"' /><br/><br/>";
			
			document.frmsponsors.hdnmode_S.value = 'edit';
			document.frmsponsors.hdnsponsors_id.value = responceVal[4];
		}
	} 
}

function deleteSponsorsDetails(sponsors_id)
{	
	url = "website_sponsors_ajax.php?sponsors_id="+sponsors_id+"&flg=delete";
	
	xmlHttp=getxmlhttpobject(stateChangedSpDelete);
	xmlHttp.open("GET", url , true);
	xmlHttp.send(null);
}

function stateChangedSpDelete() 
{		
	if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
	{ 
	
		if (xmlHttp.responseText != '')
		{
			cancelSelectedSpDtl();
			
			var res = xmlHttp.responseText;
			
			document.getElementById('sponsorsList').innerHTML = res;
			
			alert("Sponsors detail deleted successfully!");
		}
	} 
}

function cancelSelectedSpDtl()
{
	document.getElementById('hdnmode_S').value = 'add';
	document.getElementById('hdnsponsors_id').value = '';
	document.getElementById('alreadyUploaded_S').value = '';
	document.getElementById('uploadedImg_S').innerHTML = '';
	resetSponsorsDetail();
}


function resetSponsorsDetail()
{
	document.frmsponsors.txtsponsors_name.value = "";
	document.frmsponsors.txtsponsors_description.value = "";
	document.frmsponsors.txtsponsors_website.value = "";
	document.frmsponsors.txtsponsors_logo.value = null;
	document.frmsponsors.reset();
}

var previewbanner = 0;
var param = "";
var isimageup = 0;
function preparePreview()
{	
	previewbanner = 0;
	param = "";
		
	var SERVER_ROOT = document.getElementById('SERVER_ROOT').value;
	var SERVER_HOST = document.getElementById('SERVER_HOST').value;
			
	if(document.getElementById('rdobackground_type2').checked==true && document.frm1.filBackgroundImage.value!="")
	{	
		if(validateFile(document.frm1.filBackgroundImage,document.frm1.allowImageExts.value)==true)
		{			
			var txtbgImage = "tmp_bgImage_"+document.frm1.client_id.value;
			ajaxUpload(document.frm1,'ajaxupload_s3.php?filename=filBackgroundImage&output=jpg&maxSize=9999999999&maxW=&fullPath='+ SERVER_HOST+'common/files/background/&relPath='+SERVER_ROOT+'common/files/background/&colorR=255&colorG=255&colorB=255&maxH=300&namefile='+txtbgImage,'upload_area','','');
			
			param = "&bgImage=true";
			
			isimageup++;
		}
		else
		{
			return false;
		}
	}
	else
	{
		previewbanner = previewbanner + 1;
	}
	
	if(document.frm1.txtTopNavBackgroundColor.value!="")
	{
		param = param + "&navBgColor="+document.frm1.txtTopNavBackgroundColor.value;
	}
	
	if(document.frm1.txtTopNavTextColor.value!="")
	{
		param = param + "&navTextColor="+document.frm1.txtTopNavTextColor.value;
	}
	
	if(document.getElementById('rdobackground_type1').checked==true && document.frm1.txtBackgroundColor.value!="")
	{
		param = param + "&bgColor="+document.frm1.txtBackgroundColor.value;
	}
	
	if(document.getElementById('chkHideBanner').checked==true)
	{
		param = param + "&HideBanner=1";
	}
	if(document.getElementById('chkHideTopNavigation').checked==true)
	{
		param = param + "&HideTopNavigation=1";
	}
	if(document.getElementById('chkRegistrationStep').checked==true)
	{
		param = param + "&HideRegistrationStep=1";
	}
	
	if(document.getElementById('chkHideBanner').checked==false && document.frm1.filBannerImage.value!="")
    {		
		if(validateFile(document.frm1.filBannerImage,document.frm1.allowImageExts.value)==true)
		{
			var txtbannerImage = "tmp_bannerImage_"+document.frm1.client_id.value;
			ajaxUpload1(document.frm1,'ajaxupload1_s3.php?filename=filBannerImage&output=jpg&maxSize=9999999999&maxW=&fullPath='+ SERVER_HOST+'common/files/banners/&relPath='+SERVER_ROOT+'common/files/banners/&colorR=255&colorG=255&colorB=255&maxH=300&namefile='+txtbannerImage,'upload_area1','','');
			
			param = param + "&bannerImage=true";
			
			isimageup++;
		}
		else
		{
			return false;
		}
    }
	else
	{
		previewbanner = previewbanner + 1;
	}
		
	if(isimageup == 0)
	{
		var url = "preview_template.php?act=preview"+param;	
		setTimeout("window.open('"+url+"','_blank')",1000);
	}
}

function ajaxuploadResponse()
{
	previewbanner = previewbanner + 1;
	
	if(previewbanner == 2)
	{
		var url = "preview_template.php?act=preview"+param;	
		setTimeout("window.open('"+url+"','_blank')",1000);
	}
}

function ajaxupload1Response()
{
	previewbanner = previewbanner + 1;
	
	if(previewbanner == 2)
	{
		var url = "preview_template.php?act=preview"+param;	
		setTimeout("window.open('"+url+"','_blank')",1000);
	}
}

function showHideShareOptions()
{
	if(document.getElementById('chkSharingEnable').checked==true)
		document.getElementById('trShareOptions').style.display = '';
	else	
		document.getElementById('trShareOptions').style.display = 'none';
}

function enableDisableURLOpt()
{
	if(document.getElementById('chkRedirectURL').checked==true)
		document.getElementById('txtRedirectURL').disabled = false;
	else		
		document.getElementById('txtRedirectURL').disabled = true;
}

function setSharingOption()
{
	var index = 0;
	var arValidate = new Array;
		
	if(document.getElementById('chkSharingEnable').checked==true && document.getElementById('chkRedirectURL').checked==true && document.getElementById('txtRedirectURL').value == "")
	{	
		arValidate[index++] = new Array("R", "document.frm2.txtRedirectURL", "Redirect user to URL");	
	}
	
	if (!Isvalid(arValidate)){
		return false;
	}
}

function showHideTopNavigation()
{
	if(document.getElementById('chkHideTopNavigation').checked==true)
	{
		document.getElementById('trTopNavigationBg').style.display = 'none';
		document.getElementById('trTopNavigationColor').style.display = 'none';
	}
	else
	{
		document.getElementById('trTopNavigationBg').style.display = '';
		document.getElementById('trTopNavigationColor').style.display = '';
	}
}

function showHideBannerSection()
{
	if(document.getElementById('chkHideBanner').checked==true)
	{
		document.getElementById('trBannerSection').style.display = 'none';
	}
	else
	{
		document.getElementById('trBannerSection').style.display = '';
	}
}
