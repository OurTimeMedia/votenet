function CompareDatesChk(str1,str2) 
{ 
    var mon1  = parseInt(str1.substring(0,2),10); 
    var dt1 = parseInt(str1.substring(3,5),10);
    var yr1  = parseInt(str1.substring(6,10),10); 
    var mon2  = parseInt(str2.substring(0,2),10); 
    var dt2 = parseInt(str2.substring(3,5),10); 
    var yr2  = parseInt(str2.substring(6,10),10); 
    var date1 = new Date(yr1, mon1, dt1); 
    var date2 = new Date(yr2, mon2, dt2); 

    if(date2 < date1)
    {
        return '0'; 
    } 
    else 
    { 
        return '1';
    } 
} 


function Isvalid(arCheck, showalert)
{
	var strValidationType = "";
	var strControlName = "";
	var strErrorMsg = "";	
	var strLabel = "";		
	var strValue = "";
	var blError = false;
	
	if (!showalert)
		var showalert = 1;
/*	Help
	strValidationType.toUpperCase() == "R"	Required Field Validation
	strValidationType.toUpperCase() == "E" 	Compare Email address format
	strValidationType.toUpperCase() == "W" 	Compare web address format	
	strValidationType.toUpperCase() == "A"	Compare alphabets A-Z, a-z format
	strValidationType.toUpperCase() == "N"	Compare alphanumeric A-Z, a-z, 0-9 
	strValidationType.toUpperCase() == "I" 	Compare integer 0-9
	strValidationType.toUpperCase() == "F" 	Compare float 0-9 .
	strValidationType.toUpperCase() == "L" 	Compare login name A-Z, a-z, 0-9, -, _
	strValidationType.toUpperCase() == "C" 	Compare two field value for equal
	strValidationType.toUpperCase() == "P" 	Compare two password field value for equal
	strValidationType.toUpperCase() == "PDF" 	Check file type is PDFDOC
	strValidationType.toUpperCase() == "DOC" 	Check file type is DOC
	strValidationType.toUpperCase() == "PDF|DOC" 	Check file type is PDF or DOC
	strValidationType.toUpperCase() == "CD" 	Compare dates
	strValidationType.toUpperCase() == "INZ" 	Check Integer with value > 0
	
*/

	for (var i=0; i<arCheck.length; i++)
	{		
		if (arCheck[i])
			strValidationType = arCheck[i][0];
	
		if (arCheck[i])
			strControlName = arCheck[i][1];
			
		if (arCheck[i])
			strLabel = arCheck[i][2];			
			
//		var strErrorMsg = arCheck[i][2];	
		strErrorMsg = "";
		
		//alert(eval(strControlName));
		
		if (eval(strControlName) == undefined)
		{
			alert(strControlName + " element not found");	
			return false;
		}
		
		if (strValidationType.toUpperCase() == "C")
		{
			var arrctrl = strControlName.split("|");
			var strctrl1 = new String(arrctrl[0]);
			var strctrl2 = new String(arrctrl[1]);
			strValue1 = new String(eval(strctrl1+'.value'));
			strValue2 = new String(eval(strctrl2+'.value'));
			if (trim(strValue1) != trim(strValue2))
			{
				strErrorMsg = strLabel;
				blError = true;
				break;
			}
		}
		else if (strValidationType.toUpperCase() == "P")
		{
			var arrctrl = strControlName.split("|");
			var strctrl1 = new String(arrctrl[0]);
			var strctrl2 = new String(arrctrl[1]);
			strValue1 = new String(eval(strctrl1+'.value'));
			strValue2 = new String(eval(strctrl2+'.value'));
			
			if (strValue2.length>0 && trim(strValue2)=="")
			{
				strErrorMsg = "Space is not allowed.";
				blError = true;
				break;
			}
			if (trim(strValue2) != strValue2)
			{
				strErrorMsg = "Leading and trailing space is not allowed.";
				blError = true;
				break;
			}
			if (trim(strValue1) != trim(strValue2))
			{
				strErrorMsg = strLabel;
				blError = true;
				break;
			}
		}
		else if (strValidationType.toUpperCase() == "CD")
		{
			var arrctrl = strControlName.split("|");
			var strctrl1 = new String(arrctrl[0]);
			var strctrl2 = new String(arrctrl[1]);
			strValue1 = new String(eval(strctrl1+'.value'));
			strValue2 = new String(eval(strctrl2+'.value'));
			if (trim(strValue1) != "" &&  trim(strValue2) !="")
			{

				var fdate,tdate
				arfdate = strValue1.split("/")
				artdate = strValue2.split("/")
		
				fdate = new Date(arfdate[2],arfdate[0],arfdate[1],0,0,0)
				tdate = new Date(artdate[2],artdate[0],artdate[1],0,0,0)
				
				if(fdate>tdate)
				{
					strErrorMsg = strLabel;
					blError = true;
					break;
				}
				
			}
		}
		else
		{
			strValue = new String(eval(strControlName+'.value'));
		}

		if (strValidationType.toUpperCase() == "R")
		{
			if (trim(strValue) == "")
			{
				strErrorMsg = strLabel + " cannot be blank.";
				blError = true;
				break;
			}
		}
		
		if (strValidationType.toUpperCase() == "PASSWORD")
		{
			passwordval = strValue;
			mainlen = passwordval.length;
			changeval = passwordval.replace("'","");
			changeval = changeval.replace('"',"");
			changeval = changeval.replace("<","");
			changeval = changeval.replace(">","");
			changedlen = changeval.length;
			if(mainlen!=changedlen)
			{
				strErrorMsg = 'Special symbols like <,>," are not allowed in password field.';
				blError = true;
				break;
			}
		}
		
		if (strValidationType.toUpperCase() == "E")
		{ 
			if (!isEmail(strValue))
			{
				strErrorMsg = "Please enter valid " + strLabel ;
				blError = true;
				break;				
			}
		}

		if (strValidationType.toUpperCase() == "S")
		{		
			if (strValue == "")
			{
				strErrorMsg = "Please select " + strLabel + ".";
				blError = true;
				break;				
			}
			else if(eval(strValue) == -1 || strValue == -1){
				strErrorMsg = "Please select Sub " + strLabel + ".";
				blError = true;
				break;				
			}
		}

		if (strValidationType.toUpperCase() == "W")
		{
			if (!isWebURL(strValue))
			{
				strErrorMsg = "Invalid " + strLabel ;
				blError = true;
				break;				
			}
		}

		if (strValidationType.toUpperCase() == "L")
		{
			if (!isLoginName(strValue))
			{
				strErrorMsg = "Please enter only alpha numeric value in " + strLabel ;
				blError = true;
				break;				
			}
		}
		
		if (strValidationType.toUpperCase() == "A")
		{
			if (!isAlphabet(strValue))
			{
				strErrorMsg = "Please enter only alphabets in " + strLabel ;
				blError = true;
				break;				
			}
		}
		
		if (strValidationType.toUpperCase() == "N")
		{
			if (!isAlphaNumeric(strValue))
			{
				strErrorMsg = "Please enter only alpha numeric value in " + strLabel ;
				blError = true;
				break;				
			}
		}
		
		
		if (strValidationType.toUpperCase() == "I")
		{
			if (!isInteger(strValue))
			{
				strErrorMsg = "Please enter whole number in " + strLabel + "\n e.g. 1,2,3...";
				blError = true;	
				break;				
			}
		}
		
		if (strValidationType.toUpperCase() == "F")
		{
			if (!isFloat(strValue))
			{
				strErrorMsg = "Please enter numeric value in " + strLabel + "\n e.g. 1, 10.25";
				blError = true;
				break;				
			}
		}		

		if (strValidationType.toUpperCase() == "GTZ")
		{
			if (strValue <= 0)
			{
				strErrorMsg = "Zero is not allowed in " + strLabel;
				blError = true;	
				break;				
			}
			
		}	
		
		if (strValidationType.toUpperCase() == "PDF")
		{
			if (trim(strValue).length!=0)
			{
				arfilename = strValue.split(".");
				if (arfilename[arfilename.length-1].toLowerCase()!="pdf")
				{
					strErrorMsg = "Please select only 'pdf' file for " + strLabel;
					blError = true;
					break;				
				}
			}
		}		

		if (strValidationType.toUpperCase() == "DOC")
		{
			if (trim(strValue).length!=0)
			{
				arfilename = strValue.split(".");
				if (arfilename[arfilename.length-1].toLowerCase()!="doc")
				{
					strErrorMsg = "Please select only 'doc' file for " + strLabel;
					blError = true;
					break;				
				}
			}
		}		

		if (strValidationType.toUpperCase() == "PDF|DOC")
		{
			if (trim(strValue).length!=0)
			{
				arfilename = strValue.split(".");
				if (arfilename[arfilename.length-1].toLowerCase()!="pdf" && arfilename[arfilename.length-1].toLowerCase()!="doc")
				{
					strErrorMsg = "Please select only 'pdf' or 'doc' file for " + strLabel;
					blError = true;
					break;				
				}
			}
		}		

		if (strValidationType.toUpperCase() == "INZ")
		{
			if (!isInteger(strValue))
			{
				strErrorMsg = "Please enter whole number in " + strLabel + "\n e.g. 1,2,3...";
				blError = true;	
				break;				
			}
			else if (parseInt(strValue)<=0)
			{
				strErrorMsg = "Zero is not allowed in " + strLabel;
				blError = true;	
				break;				
			}
		}

		
	}
	
	if (blError)
	{
		alert(strErrorMsg);
		//eval(strControlName+'.select()');
		eval(strControlName+'.focus();');
		return false;
	}
	
	return true;
}

function trim(tmp)
{
	var temp;
	temp = tmp;
	pat = /^\s+/;
	temp = temp.replace(pat, "");
	pat = /\s+$/;
	temp = temp.replace(pat, "");
	return temp;
}

function isEmail(str) 
{
	var arstr = str.split(';');
	
	if (arstr.length > 0)
	{
		for(i=0; i<arstr.length; i++)
		{
			if (!validateEmail(trim(arstr[i])))
				return false;
		}
	}
	else
		return validateEmail(str);
		
	return true;

}

function validateEmail(str)
{

// are regular expressions supported?
  var supported = 0;
  if (window.RegExp) {
	var tempStr = "a";
	var tempReg = new RegExp(tempStr);
	if (tempReg.test(tempStr)) supported = 1;
  }
  if (!supported) 
	return (str.indexOf(".") > 2) && (str.indexOf("@") > 0);
	  var r1 = new RegExp("(@.*@)|(\\.\\.)|(@\\.)|(^\\.)");
	  var r2 = new RegExp("^.+\\@(\\[?)[a-zA-Z0-9\\-\\.]+\\.([a-zA-Z]{2,3}|[0-9]{1,3})(\\]?)$");
	  return (!r1.test(str) && r2.test(str));

}

//http(s)?://([\w-]+\.)+[\w-]+(/[\w- ./?%&=]*)?

// "^(ftp|https?):\/\/(www\.)?[a-z0-9\-\.]{3,}\.[a-z]{3}$"

// http(s)?://([\w-]+\.)+[\w-]+(/[\w- ./?%&=]*)?

function isWebURL(str) 
{

 // are regular expressions supported?
  var supported = 0;
  if (window.RegExp) {
	var tempStr = "a";
	var tempReg = new RegExp(tempStr);
	if (tempReg.test(tempStr)) supported = 1;
  }
  if (!supported) 
	return (str.indexOf(".") > 2);	  

	var r1 = new RegExp("^(http(s)?):\/\/+(www\.)+[a-zA-Z0-9\\-\\.]{2,}\\.[a-zA-Z]{2,}$");	  	
	
	return (r1.test(str) );	  
}

function isValidURL(url){ 
    var RegExp = /^(([\w]+:)?\/\/)?(([\d\w]|%[a-fA-f\d]{2,2})+(:([\d\w]|%[a-fA-f\d]{2,2})+)?@)?([\d\w][-\d\w]{0,253}[\d\w]\.)+[\w]{2,4}(:[\d]+)?(\/([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)*(\?(&?([-+_~.\d\w]|%[a-fA-f\d]{2,2})=?)*)?(#([-+_~.\d\w]|%[a-fA-f\d]{2,2})*)?$/; 
    if(RegExp.test(url)){ 
        return true; 
    }else{ 
        return false; 
    } 
} 

function isValidEmail(email){ 
    var RegExp = /^((([a-z]|[0-9]|!|#|$|%|&|'|\*|\+|\-|\/|=|\?|\^|_|`|\{|\||\}|~)+(\.([a-z]|[0-9]|!|#|$|%|&|'|\*|\+|\-|\/|=|\?|\^|_|`|\{|\||\}|~)+)*)@((((([a-z]|[0-9])([a-z]|[0-9]|\-){0,61}([a-z]|[0-9])\.))*([a-z]|[0-9])([a-z]|[0-9]|\-){0,61}([a-z]|[0-9])\.)[\w]{2,4}|(((([0-9]){1,3}\.){3}([0-9]){1,3}))|(\[((([0-9]){1,3}\.){3}([0-9]){1,3})\])))$/ 
    if(RegExp.test(email)){ 
        return true; 
    }else{ 
        return false; 
    } 
} 


function isLoginName(str)
{
	var pat = /[a-z,A-Z,0-9,\-,\_]+/g;
	var vr = str;
	var vr = vr.replace(pat,"");
	if (vr) { return false; }
	
	return true;
}

function isAlphabet(str)
{
	var pat = /[a-z,A-Z,.,-, ]+/g;
	var vr = str;
	var vr = vr.replace(pat,"");
	
	var pat1 = /[']/;
	var vr1 = vr;
	var vr1 = vr1.replace(pat1,"");
	if (vr1) { return false; }
	
	return true;
	var vr = str;
	var vr = vr.replace(pat,"");
	
	var pat1 = /[']/;
	var vr1 = vr;
	var vr1 = vr1.replace(pat1,"");
	if (vr1) { return false; }
	
	return true;
}

function isFileExt(str)
{
	var pat = /^[.][a-zA-Z ]+/g;
	var vr = str;
	var vr = vr.replace(pat,"");
	if (vr) { return false; }
	
	return true;
}

function isAlphaNumeric(str)
{
	var pat = /[a-z,A-Z,0-9]+/g;
	var vr = str;
	var vr = vr.replace(pat,"");
	if (vr) { return false; }
	
	return true;
}

function isInteger(a)
{
	if (a.split(" ").join("").length == 0)
	{
		return false;
	}
	
	var Anum = "0123456789";
	
	for (i=0;i<a.length;i++)
	{
		if (Anum.indexOf(a.substr(i,1)) == -1)
		{
			return false;
		}		
	}
	
	return true;
}

function isFloat(a)
{	

	if (a.split(" ").join("").length ==0)
	{
		return false;
	}
	/*
	var Anum = "0123456789.";
	
	for (i=0;i<a.length;i++)
	{
		if (Anum.indexOf(a.substr(i,1)) == -1)
		{
			return false;
		}
		
	}
	if (isNaN(a))
	{
		return false;
	}
	*/	
		
	var pat = /[0-9,\.]+/g;
	var vr = a;
	var vr = vr.replace(pat,"");
	if (vr) { return false; }		
	
	return true;
}

// To format a given number upto specified decimals

function FormatNumber(N, D)
{
	var r, ro, ra, s, No;
	
	r = 0;
	ro = 1;
	
	r = parseFloat(N);
	
	ro = parseInt(D+1);
	
	ro = parseFloat(1*(Math.pow(10, ro)));
	
	ra = parseFloat(5/ro);

	r = parseFloat(r + ra);
			
	ro = parseFloat(ro/10);
	
	r = parseFloat(r*ro);
	
	r = parseInt(r);
	
	r = parseFloat(r/ro);
	
	s = new String(r);		
	
	if (s.indexOf(".") == -1)
	{
		r = r + ".00";
	}
	else
	{
		
		if ((s.substr(s.indexOf(".")+1)).length == 1)
		{
			r = r + "0";
		}
	}
	
	return r;
}			
function RowHoverIn(Row)
{
	Row.className='row-mousehover';
}

function RowHoverOut(Row,rowclass)
{
	Row.className=rowclass;
}	
function doBasicTinyMCEInit(c)
{
	var base_url = window.location.pathname;
	base_url = base_url.substr(1);
	base_url = base_url.substr(0,base_url.indexOf('admin/'));
	base_url = window.location.protocol + '//' + window.location.host + '/' + base_url
	
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		plugins : "imagemanager,safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,undo,redo,|,cleanup,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "hr,removeformat,visualaid,|,sub,sup,|,charmap,iespell,|,print,|,fullscreen",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,
		
		 paste_auto_cleanup_on_paste : true,
		document_base_url : base_url,
		
		content_css : c

	});
}	
function toggleEditor(id) {
	var elm = document.getElementById(id);

	if (tinyMCE.getInstanceById(id) == null)
		tinyMCE.execCommand('mceAddControl', false, id);
	else
		tinyMCE.execCommand('mceRemoveControl', false, id);
}

function doBasicTinyMCEInit_Single(c, id)
{
	var base_url = window.location.pathname;
	base_url = base_url.substr(1);
	base_url = base_url.substr(0,base_url.indexOf('admin/'));
	base_url = window.location.protocol + '//' + window.location.host + '/' + base_url
	
	tinyMCE.init({
		// General options
		mode : "textarea",
		theme : "advanced",
		plugins : "imagemanager,safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,undo,redo,|,cleanup,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "hr,removeformat,visualaid,|,sub,sup,|,charmap,iespell,|,print,|,fullscreen",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,
		
		 paste_auto_cleanup_on_paste : true,
		document_base_url : base_url,
		
		content_css : c

	});
	tinyMCE.execCommand('mceAddControl', false, id);
}	

function doDefaultTinyMCEInit(c)
{
	var base_url = window.location.pathname;
	base_url = base_url.substr(1);
	base_url = base_url.substr(0,base_url.indexOf('admin/'));
	base_url = window.location.protocol + '//' + window.location.host + '/' + base_url
	
	tinyMCE.init({
		// General options
		mode : "textareas",
		theme : "advanced",
		plugins : "imagemanager,safari,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template",

		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull",
		theme_advanced_buttons2 : "",
		theme_advanced_buttons3 : "",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,
		
		 paste_auto_cleanup_on_paste : true,
		document_base_url : base_url,
		
		content_css : c

	});
}	
function search_record(frm)
{
	frm.txtcurrentpage.value =1;
	frm.submit();
}


function GetXmlHttpObject(handler)
{ 
	var objXmlHttp=null

	if (window.ActiveXObject)
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
	if (window.XMLHttpRequest)
	{
		objXmlHttp=new XMLHttpRequest()
		objXmlHttp.onload=handler
		objXmlHttp.onerror=handler 
		return objXmlHttp
	}
}


// Check all checkbox
function checkall(form)
{
	for (var i=0;i<form.elements.length;i++) 
	{
	    var e = form.elements[i];
	    if ((e.name != 'main') && (e.type=='checkbox')) 
	    {
	    	if(form.main.checked == true)
			{
			   e.checked = true;
			}
			else
			{
				e.checked = false;
			}
		}
	  }
}

// Checkbox checked count
function checkCount(form)
{
	
	  var TotalOn = 0;
	  
	  for (var i=0;i<form.elements.length;i++) {
	    var e = form.elements[i];
	    if ((e.name != 'main') && (e.type=='checkbox')) {
	     
	      if (e.checked) {
	       TotalOn++;
	      }
	    }
	  }
	  
	  return TotalOn;
}


// Check one checkbox
function checkOne(form)
{
	 var TotalBoxes = 0;
	 
	 for (var i=0;i<form.elements.length;i++) 
	{
	    var e = form.elements[i];
	    if ((e.name != 'main') && (e.type=='checkbox')) 
	    {
	    	TotalBoxes++;
		}
	  }
	 
	 var TotalOn = checkCount(form);
	  
	  if (TotalBoxes == TotalOn) {
	    form.main.checked=true;
	  }
	  else {
	   form.main.checked=false;
	  }
}

function check_menu(filter_class, checked, id)
{
	// Check/Uncheck all sub items of current menu
	ele = document.getElementsByClassName(filter_class);
	for (i=0;i<ele.length;i++)
	{
		ele[i].checked = checked;
	}
	
	if (checked)	// If sub menu checked then all its parent must be checked
	{
		var class_name = new String(document.getElementById(id).className.replace("checkbox ",""));
		arr_ids = class_name.split(" ");
		for (i=0;i<arr_ids.length;i++)
		{
			arr_ids[i] = arr_ids[i].replace("class_","");
			if (document.getElementById("menu_"+arr_ids[i]))
				document.getElementById("menu_"+arr_ids[i]).checked = checked;
		}
	}
	else	// If all sub menu are  unchecked then its parent must be unchecked
	{
		var is_checked = 0;
		var class_name = new String(document.getElementById(id).className.replace("checkbox ",""));
		arr_ids = class_name.split(" ");
		arr_all_ids = document.getElementsByClassName(arr_ids[0]);
		for (i=0;i<arr_all_ids.length;i++)
		{
				if (arr_all_ids[i].checked)
					is_checked = 1;
		}
		if (is_checked == 0)
		{
			if (document.getElementById("menu_"+arr_ids[0].replace("class_","")))
				document.getElementById("menu_"+arr_ids[0].replace("class_","")).checked = false;
		}
	}
}