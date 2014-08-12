<script type="text/javascript" language="Javascript">
<!--

function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}

function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}

function Isvalid(arCheck)
{
	var strValidationType = "";
	var strControlName = "";
	var strErrorMsg = "";	
	var strLabel = "";		
	var strValue = "";
	var blError = false;
	
	var blMessage = false;
	
/*	Help
	strValidationType.toUpperCase() == "R"	Required Field Validation
	strValidationType.toUpperCase() == "E" 	Compare Email address format
	strValidationType.toUpperCase() == "PH" Compare phone number format	
	strValidationType.toUpperCase() == "W" 	Compare web address format	
	strValidationType.toUpperCase() == "A"	Compare alphabets A-Z, a-z format
	strValidationType.toUpperCase() == "N"	Compare alphanumeric A-Z, a-z, 0-9 
	strValidationType.toUpperCase() == "I" 	Compare integer 0-9
	strValidationType.toUpperCase() == "F" 	Compare float 0-9 .
	strValidationType.toUpperCase() == "L" 	Compare login name A-Z, a-z, 0-9, -, _
	strValidationType.toUpperCase() == "C" 	Compare two field value for equal	
	strValidationType.toUpperCase() == "RM" Required with message	
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
		
		if (arCheck[i])
		{
			if (arCheck[i].length>=4)
			{
				blMessage = true;
				
				strErrorMsg = arCheck[i][3];				
			}
		}
		
		//alert(eval(strControlName));
		
		if (eval(strControlName) == undefined)
		{
			alert(strControlName + " element home_box_not found.");	
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
				if (!blMessage)
					strErrorMsg = strLabel;
				
				blError = true;
				break;
			}
		}
		else
		{
			strValue = new String(eval(strControlName+'.value'));
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
		
		if (strValidationType.toUpperCase() == "P")
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

		if (strValidationType.toUpperCase() == "RM")
		{
			if (trim(strValue) == "")
			{
				if (!blMessage)
				{	//strErrorMsg = strLabel + " cannot be blank.";					
					strErrorMsg = strLabel;
				}

				blError = true;
				break;
			}
		}

		if (strValidationType.toUpperCase() == "R")
		{
			if (trim(strValue) == "")
			{
				if (!blMessage)
				{	//strErrorMsg = strLabel + " cannot be blank.";					
					strErrorMsg = strLabel + " <?php print LANG_JS_CANNOT_BE_BLANK; ?>.";
				}

				blError = true;
				break;
			}
		}
		
		if (strValidationType.toUpperCase() == "E")
		{ 
			if (!isEmail(strValue))
			{
				if (!blMessage)
	//				strErrorMsg = "Invalid " + strLabel ;
					strErrorMsg = "<?php print LANG_JS_INVALID; ?> " + strLabel +"." ;
					
				blError = true;
				break;				
			}
		}

		if (strValidationType.toUpperCase() == "PH")
		{ 
			if (!isValidPhoneNumber(strValue))
			{
				if (!blMessage)
	//				strErrorMsg = "Invalid " + strLabel ;
					strErrorMsg = "<?php print LANG_JS_INVALID; ?> " + strLabel +"." ;
					
				blError = true;
				break;				
			}
		}
		

		if (strValidationType.toUpperCase() == "W")
		{
			if (!isWebURL(strValue))
			{
				if (!blMessage)
	//				strErrorMsg = "Invalid " + strLabel ;
					strErrorMsg = "<?php print LANG_JS_INVALID; ?> " + strLabel +".";
					
				blError = true;
				break;				
			}
		}

		if (strValidationType.toUpperCase() == "L")
		{
			if (!isLoginName(strValue))
			{
				if (!blMessage)
	//				strErrorMsg = "Please enter only alpha numeric value in " + strLabel ;
					strErrorMsg = "<?php print LANG_JS_ALPHA_NUMBER; ?> " + strLabel+"." ;
					
				blError = true;
				break;				
			}
		}
		
		if (strValidationType.toUpperCase() == "A")
		{
			if (!isAlphabet(strValue))
			{
				if (!blMessage)
	//				strErrorMsg = "Please enter only alphabets in " + strLabel ;
					strErrorMsg = "<?php print LANG_JS_ALPHA_ONLY; ?> " + strLabel+"." ;			
					
				blError = true;
				break;				
			}
		}
		
		if (strValidationType.toUpperCase() == "N")
		{
			if (!isAlphaNumeric(strValue))
			{
				if (!blMessage)
	//				strErrorMsg = "Please enter only alpha numeric value in " + strLabel ;
					strErrorMsg = "<?php print LANG_JS_ALPHA_NUMBER; ?> " + strLabel+"." ;
					
				blError = true;
				break;				
			}
		}
	
		
		if (strValidationType.toUpperCase() == "S")
		{	
			if (strValue == "" || strValue == "undefined")
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
		
		if (strValidationType.toUpperCase() == "SM")
		{	
			if (!blMessage)
			{	
				strErrorMsg = strLabel;			
			}
			blError = true;
			break;	
		}
		
		
		if (strValidationType.toUpperCase() == "ARR")
		{	
			if (!blMessage)
			{	//strErrorMsg = strLabel + " cannot be blank.";					
				strErrorMsg = strLabel;
			}

			blError = true;
			break;
				
		}
		
		if (strValidationType.toUpperCase() == "ARRAY")
		{	
			if (!blMessage)
			{				
				strErrorMsg = "Please select "+strLabel+"." ;		
			}

			blError = true;
			break;
				
		}
		
		if (strValidationType.toUpperCase() == "I")
		{
			if (!isInteger(strValue))
			{
				if (!blMessage)
	//				strErrorMsg = "Please enter whole number in " + strLabel + "\n e.g. 1,2,3...";
					strErrorMsg = "<?php print LANG_JS_INTEGER_ONLY; ?> " + strLabel + "\n e.g. 1,2,3...";
					
				blError = true;	
				break;				
			}
		}
		
		if (strValidationType.toUpperCase() == "F")
		{
			if (!isFloat(strValue))
			{
				if (!blMessage)
	//				strErrorMsg = "Please enter numeric value in " + strLabel + "\n e.g. 1, 10.25";
					strErrorMsg = "<?php print LANG_JS_NUMBER_ONLY; ?> " + strLabel + "\n e.g. 1, 10.25.";
					
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



function isValidPhoneNumber(str)
{
	/*var pat = /[0-9, ,-,(,),.,-]+/g;
	var vr = str;
	var vr = vr.replace(pat,"");
	if (vr) { return false; }
	
	if(isNaN(parseInt(str.substring(str.length-2, str.length-1))))
	{	
		return false;
	}
	
	var stripped = str.replace(/--/g, '@');     
	var stripped = stripped.replace(/((/g, '@'); 
	var stripped = stripped.replace(/))/g, '@'); 
	var stripped = stripped.replace(/../g, '@'); 
    var stripped = stripped.replace(/[\(\)\.\-\ ]/g, '');     

    if (str == "") {
        return false;
    } else if (isNaN(parseInt(stripped))) {
        return false;
    } else if (!(stripped.length == 10)) {
        return false;
    }*/
	
	//var pat = /[0-9, ,-,(,),.,-]+/g;
	var pat = /[0-9,-,(,),-]+/g;
	var vr = str;
	var vr = vr.replace(pat,"");
	if (vr) { return false; }
	
	var stripped = str.replace(/[\(\)\.\-\ ]/g, '');
	if (str == "") {
	 return false;
    } else if (isNaN(parseInt(stripped))) {
        return false; 
	} /*else if (!(stripped.length == 10)) {
        return false;
	}*/
	
	/*if(str.search(/^\d{3}\-\d{3}\-\d{4}$/)==-1 && str.search(/^\d{3}\.\d{3}\.\d{4}$/)==-1 && str.search(/^\(\d{3}\)\d{3}\-\d{4}$/)==-1  && str.search(/^\(\d{3}\)\ \d{3}\-\d{4}$/)==-1 && str.search(/^\(\d{3}\)\ \d{3}\.\d{4}$/)==-1 && str.search(/^\(\d{3}\)\d{3}\.\d{4}$/)==-1 && str.search(/^\d{10}$/)==-1 && str.search(/^\(\d{3}\)\d{7}$/)==-1 && str.search(/^\d{3}\.\d{7}$/)==-1 && str.search(/^\d{3}\-\d{7}$/)==-1)
	{
		return false;
	}*/
	
    return true;
}

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
	
	var r1 = new RegExp("^(http(s)?):\/\/+[a-zA-Z0-9\\-\\.]{2,}\\.[a-zA-Z]{2,4}$");
	
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
	var pat = /[a-z,A-Z .-]+/g;
	var vr = str;
	var vr = vr.replace(pat,"");
	
	var pat1 = /[']/;
	var vr1 = vr;
	var vr1 = vr1.replace(pat1,"");
	if (vr1) { return false; }
	
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

function validateImageFile (fld) 
{
    if(!/(\.JPG|\.JPEG|\.GIF|\.PNG|\.BMP|\.TIF|\.TIFF)$/i.test(fld.value.toUpperCase())) 	        
	{
		alert("Invalid file type.\n - Only .jpg, .jpeg, .gif, .png, .bmp, .tif files are allowed.");
		fld.value = "";
		fld.focus();
		return false;
	}
	return true;
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
     
   alert("Invalid file type. Allowed file types are "+ filetypes.split("_").join(",") + ".");
   fld.parentNode.innerHTML = fld.parentNode.innerHTML;
   //fld.form.reset();
   fld.value = "";
   //fld.focus;
   return false;
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

function doDefaultTinyMCEInit_Single(c, id)
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
	tinyMCE.execCommand('mceAddControl', false, id);
}

function clear_form_elements(ele) 
{
    jQuery(ele).find(':input').each(function() {
        switch(this.type) {
            case 'text':
            case 'textarea':
            case 'password':
            case 'select-multiple':
            case 'select-one':
            case 'file':
                jQuery(this).val('');
                break;
            case 'checkbox':
            case 'radio':
                this.checked = false;
        }
    });
}

//-->
</script>