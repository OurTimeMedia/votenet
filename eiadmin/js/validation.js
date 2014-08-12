function Isvalid(arCheck)
{
	var strValidationType = "";
	var strControlName = "";
	var strErrorMsg = "";	
	var strLabel = "";		
	var strValue = "";
	var blError = false;
	var blFocus = true;
/*	Help

	strValidationType.toUpperCase() == "A"	Compare alphabets A-Z, a-z format
	strValidationType.toUpperCase() == "B" 	Compare numeric value between range.	
	strValidationType.toUpperCase() == "C" 	Compare two field value for equal
	strValidationType.toUpperCase() == "E" 	Compare Email address format
	strValidationType.toUpperCase() == "F" 	Compare float 0-9 .
	strValidationType.toUpperCase() == "G" 	Greater then zero.
	strValidationType.toUpperCase() == "M" 	Max length check.
	strValidationType.toUpperCase() == "H" 	Required to select Check box	
	strValidationType.toUpperCase() == "0" 	Required to select Check box	
	strValidationType.toUpperCase() == "I" 	Compare integer 0-9
	strValidationType.toUpperCase() == "L" 	Compare login name A-Z, a-z, 0-9, -, _
	strValidationType.toUpperCase() == "N"	Compare alphanumeric A-Z, a-z, 0-9 	
	strValidationType.toUpperCase() == "P" 	Compare two password field value for equal	
	strValidationType.toUpperCase() == "R"	Required Field Validation
	strValidationType.toUpperCase() == "S" 	Select Value from Dropdown.		
	strValidationType.toUpperCase() == "U"	Required to upload file
	strValidationType.toUpperCase() == "W" 	Compare web address format	
	strValidationType.toUpperCase() == "FD" Check folder name	
	strValidationType.toUpperCase() == "IMG" Check file extension is .jpg, .jpeg, .gif (Image)
	strValidationType.toUpperCase() == "MP3" Check file extension is .xls (MS Excel)
	strValidationType.toUpperCase() == "PDF" Check file extension is .pdf
*/
	for (var i=0; i<arCheck.length; i++)
	{		
		if (arCheck[i])
			strValidationType = arCheck[i][0];
	
		if (arCheck[i])
			strControlName = arCheck[i][1];
			
		if (arCheck[i])
			strLabel = arCheck[i][2];			
			
		strErrorMsg = "";		
		
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
		else if (strValidationType.toUpperCase() == "M")
		{
			var arrctrl = strControlName.split("|");
			var strctrl1 = new String(arrctrl[0]);
			var strctrl2 = new String(arrctrl[1]);
			strValue1 = new String(eval(strctrl1+'.value'));
			strValue2 = new Number(strctrl2);
			if ((trim(strValue1).length) > strValue2)
			{
				strErrorMsg = strLabel + " should not exeed " + strValue2 + " characters.";
				blError = true;
				strControlName = strctrl1;
				break;
			}
		}
		else
		{
			strValue = new String(eval(strControlName+'.value'));
		}

		if (strValidationType.toUpperCase() == "A")
		{
			if (!isAlphabet(strValue))
			{
				strErrorMsg = "Please enter only alphabets in " + strLabel + ".";
				blError = true;
				break;				
			}
		}
		
		if (strValidationType.toUpperCase() == "B")
		{
			strValue = new Number(strValue);
						
			var minimumValue = new String(arCheck[i][3]);
			minimumValue = new Number(minimumValue);
			
			var maximumValue = new String(arCheck[i][4]);			
			maximumValue = new Number(maximumValue);
		
			if (strValue > maximumValue)
			{
				strErrorMsg = strLabel + " should be between " + minimumValue + " and " + maximumValue + ".";
				blError = true;
				break;				
			}

			if (strValue < minimumValue)
			{
				strErrorMsg = strLabel + " should be between " + minimumValue + " and " + maximumValue + ".";
				blError = true;
				break;				
			}
		}

		if (strValidationType.toUpperCase() == "E")
		{ 
			if (!isEmail(strValue))
			{
				strErrorMsg = "Please enter valid " + strLabel + ".";
				blError = true;
				break;				
			}
		}

		if (strValidationType.toUpperCase() == "F")
		{
			if (!isFloat(strValue))
			{
				strErrorMsg = "Please enter numeric value in " + strLabel + "\n e.g. 1,2...";
				blError = true;
				break;				
			}
		}
		
		if (strValidationType.toUpperCase() == "PRICE")
		{
			if (!isFloat(strValue))
			{
				strErrorMsg = "Please enter valid price.";
				blError = true;
				break;				
			}
		}
		
		if (strValidationType.toUpperCase() == "G")
		{
			if (parseFloat(strValue)<=0)
			{
				strErrorMsg = "Please enter numeric value which is greater than zero in " + strLabel + "\n e.g. 1,2...";
				blError = true;
				break;				
			}
		}		

		if (strValidationType.toUpperCase() == "H")
		{
			if (!(eval(strControlName).checked))
			{
				strErrorMsg = "Please select " + strLabel + ".";
				blError = true;
				break;				
			}
		}	
		
		if (strValidationType.toUpperCase() == "O")
		{
			var blvalid = false;
			
			var control = eval(strControlName);
			for ( intcounter = 0; intcounter < parseInt(control.length); intcounter++ ) {
				if ( control[intcounter].checked ) {
					blvalid = true;
					break;
				}
			}
						
			if ( ! blvalid)
			{
				strErrorMsg = "Please select an option in " + strLabel + ".";
				blFocus = false;
				blError = true;
				break;				
			}
		}		


		if (strValidationType.toUpperCase() == "I")
		{
			if (!isInteger(strValue))
			{
				//strErrorMsg = "Please enter whole number in " + strLabel + "\n e.g. 1,2,3...";
				strErrorMsg = "Enter valid " + strLabel + ".";
				blError = true;	
				break;				
			}
		}

		if (strValidationType.toUpperCase() == "L")
		{
			if (!isLoginName(strValue))
			{
				strErrorMsg = "Please enter only A-Z, a-z, 0-9, -, _ in " + strLabel + ".";
				blError = true;
				break;				
			}
		}		
		
		if (strValidationType.toUpperCase() == "N")
		{
			if (!isAlphaNumeric(strValue))
			{
				strErrorMsg = "Please enter only alpha numeric value in " + strLabel + ".";
				blError = true;
				break;				
			}
		}		

		if (strValidationType.toUpperCase() == "R")
		{
			if (trim(strValue) == "")
			{
				strErrorMsg = "Please enter " + strLabel + ".";
				blError = true;
				break;
			}
		}

		if (strValidationType.toUpperCase() == "S")
		{			
			if (eval(strValue) == 0 && strValue == "")
			{
				strErrorMsg = "Please select " + strLabel + ".";
				blError = true;
				break;				
			}
		}	

		if (strValidationType.toUpperCase() == "U")
		{
			if (trim(strValue) == "")
			{
				strErrorMsg = "Please upload " + strLabel + ".";
				blError = true;
				break;
			}
		}

		if (strValidationType.toUpperCase() == "W")
		{
			if (!isValidURL(strValue))
			{
				strErrorMsg = "Invalid " + strLabel + ".";
				blError = true;
				break;				
			}
		}
		if (strValidationType.toUpperCase() == "FD")
		{
			if (!CheckFolderName(strValue))
			{
				strErrorMsg = strLabel +' can not contain any of following characters:\n \ / : * ? \ " < > |';
				blError = true;
				break;				
			}
		}		

		if (strValidationType.toUpperCase() == "MP3")
		{
			if (trim(strValue).length!=0)
			{
				arfilename = strValue.split(".");
				if (arfilename[arfilename.length-1].toLowerCase()!="mp3")
				{
					strErrorMsg = "Please select only 'mp3' file.";
					blError = true;
					break;				
				}
			}
		}		
		
		if (strValidationType.toUpperCase() == "PDF")
		{
			if (trim(strValue).length!=0)
			{
				arfilename = strValue.split(".");
				if (arfilename[arfilename.length-1].toLowerCase()!="pdf")
				{
					strErrorMsg = "Please select only 'pdf' file.";
					blError = true;
					break;				
				}
			}
		}		
		
		if (strValidationType.toUpperCase() == "IMG")
		{
			if (trim(strValue).length!=0)
			{
				if(!/(\.JPG|\.JPEG|\.GIF|\.PNG)$/i.test(strValue.toUpperCase())) 	        
				{
					strErrorMsg = "Please select valid image (.jpg, .jpeg, .gif, .png) file in " + strLabel + ".";
					blError = true;
					break;				
				}
			}
		}		
		
		if (strValidationType.toUpperCase() == "DOC")
		{
			if (trim(strValue).length!=0)
			{
				if(!/(\.DOC|\.DOCX|\.ZIP|\.PDF|\.ODT|\.RTF|\.TXT)$/i.test(strValue.toUpperCase())) 	        
				{
					strErrorMsg = "Please select valid image (.doc, .docx, .zip, .pdf, .odt, .rtf, .txt) file in " + strLabel + ".";
					blError = true;
					break;				
				}
			}
		}		
		
		if (strValidationType.toUpperCase() == "FLV")
		{
			if (trim(strValue).length!=0)
			{
				arfilename = strValue.split(".");
				if (arfilename[arfilename.length-1].toLowerCase()!="flv")
				{
					strErrorMsg = "Please select only 'flv' file.";
					blError = true;
					break;				
				}
			}
		}
		
	}
	
	if (blError)
	{
		
		alert(strErrorMsg);
		if ( blFocus ) {
			eval(strControlName+'.focus();');
		}
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
			if (!isValidEmail(trim(arstr[i])))
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
	var pat = /[a-z,A-Z ]+/g;
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
	a = trim(a);

	if (a.split(" ").join("").length ==0)
	{
		return false;
	}
	/*	
	var pat = /[0-9,\.]+/g;
	var vr = a;
	var vr = vr.replace(pat,"");
	if (vr) { return false; }		
	*/

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

function validateImageFile(fld) 
{
	if(!/(\.JPG|\.JPEG|\.GIF|\.PNG)$/i.test(fld.value.toUpperCase())) 	        
	{
		alert("Invalid image file type.\n - Only .jpg, .jpeg, .gif or .png files are allowed.");
		fld.value = "";
		fld.focus();
		return false;
	}
	return true;
}

function validateCSSFile (fld) 
{
	if(!/(\.css)$/i.test(fld.value.toUpperCase())) 	        
	{
		alert("Invalid style sheet file type.\n - Only .css files are allowed.");
		fld.value = "";
		fld.focus();
		return false;
	}
	return true;
}

function checkselected(form, control)
{
	var intindex = 0;
    var intelements = eval(form).length;
    var strcontrolname = '';
	
	var intcount = 0;

    for (intindex=0; intindex<intelements; intindex++)
    {
	    strcontrolname = eval(form).elements[intindex].name;    	
		
	    if (strcontrolname.indexOf(control) >= 0)
	    {
			if (eval(form).elements[intindex].checked)
			{
				intcount = intcount+1;
			}			
	    }		
    }
	
	return intcount;
}

/* FUNCTION FOR TINYMCE */

function toggleEditor(id) {
	var elm = document.getElementById(id);

	if (tinyMCE.getInstanceById(id) == null)
		tinyMCE.execCommand('mceAddControl', false, id);
	else
		tinyMCE.execCommand('mceRemoveControl', false, id);
}

function doTinyMCEInit(c)
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
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,undo,redo,|,link,unlink,anchor,image,cleanup,code,|,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,iespell,media,advhr,|,print,|,fullscreen",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,
		
		 paste_auto_cleanup_on_paste : true,
		document_base_url : base_url,
		
		content_css : c

	});
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

/* END OF FUNCTION TINYMCE */

function search_record(frm)
{
	frm.txtcurrentpage.value =1;
	frm.submit();
}
function getToday()
{
	var today = new Date();
	var dd = today.getDate();
	var mm = today.getMonth()+1;//January is 0!
	var yyyy = today.getFullYear();
	if(dd<10){dd='0'+dd}
	if(mm<10){mm='0'+mm}
	
	return mm+'/'+dd+'/'+yyyy;
}
function CheckFolderName(str)
{
	str = trim(str);

	if (str.split(" ").join("").length == 0)
	{
		return false;
	}
	var Anum = '\\/:*?\"<>|';
	
	for (i=0;i<Anum.length;i++)
	{
		if (str.indexOf(Anum.substr(i,1)) >=0 )
		{
			return false;
		}		
	}
	return true;
}