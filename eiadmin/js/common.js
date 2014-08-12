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

function MM_showHideLayers() { //v6.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) if ((obj=MM_findObj(args[i]))!=null) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}
function MM_goToURL() { //v3.0
  var i, args=MM_goToURL.arguments; document.MM_returnValue = false;
  for (i=0; i<(args.length-1); i+=2) eval(args[i]+".location='"+args[i+1]+"'");
}
function proadmin(){
}
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function checkEmptyString(ctrlstring)
{	
	msg = "";
	msg1 = "";
	msgstring = "Please enter values for the following fields:\n";
	msgstring1 = "Please select atleast one value for the following fields:\n";
	ctrlfocus = "";

	ctrl = ctrlstring.split(";");
	for(i=0; i<ctrl.length; i++)
	{
		var ctrlname = ctrl[i].split(",");
		var a = ctrlname[0];
		if(a.substring(a.length-2,a.length) == "[]")
		{
			b = '"' + a + '.value' + '"';
			//alert(eval(b));
			if(eval(b) == "")
			{
				if(ctrlfocus == "")
				{
					ctrlfocus = ctrlname[0] + ".focus()";
				}
				msg1 = msg1 + "\n" + ctrlname[1];
			}	
		}
		else
		{		
			if(eval(ctrlname[0]).value.split(" ").join("").length == 0)
			{
				if(ctrlfocus == "")
				{
					ctrlfocus = ctrlname[0] + ".focus()";
				}
				msg = msg + "\n" + ctrlname[1];
			}
		}
	}
	if(msg.length > 0)
	{
		msgstring = msgstring + msg;
		return true;
	}
	if(msg1.length > 0)
	{
		if(msg.length > 0)
			msgstring = msgstring + msgstring1 + msg1;
		else
			msgstring = msgstring1 + msg1;
	}		
	return false;	
}

function logincheck(redirect_to, ctrlstring)
{
	submitflag = 1;
	if ( ctrlstring != "" ) {
		if ( checkEmptyString(ctrlstring) ) {
			alert(msgstring);
			eval(ctrlfocus);
			submitflag = 0;
		}
	}
	if ( submitflag == 1 ) {
		document.frm.action = redirect_to;
		document.frm.submit();
	}	
}

function edit_inplace(id)
{
document.frm.id.value = id;
document.frm.submit();
}

function edit_save(redirect_to, ctrlstring)
{
	submitflag = 1;
	if ( ctrlstring != "" ) {
		if ( checkEmptyString(ctrlstring) ) {
			alert(msgstring);
			eval(ctrlfocus);
			submitflag = 0;
		}
	}
	if ( submitflag == 1 ) {
		document.frm.action = redirect_to;
		document.frm.submit();
	}	
}

function edit_save_format(redirect_to, ctrlstring, checkformat, checkfieldid)
{
	submitflag = 1;
	if ( ctrlstring != "" ) {
		if ( checkEmptyString(ctrlstring) ) {
			alert(msgstring);
			eval(ctrlfocus);
			submitflag = 0;
		}
	}
	if( submitflag == 1 )
	{
		if(checkformat == "confirm")
		{
			ctrl = ctrlstring.split(";");
			var ctrlname1 = ctrl[checkfieldid].split(",");
			var ctrlname2 = ctrl[checkfieldid+1].split(",");
			if(eval(ctrlname1[0]).value != eval(ctrlname2[0]).value)
			{
				alert("New password and Confirm password does not match.");	
				ctrlfocus = ctrlname1[0] + ".focus()";
				eval(ctrlfocus);
				submitflag = 0;
			}
		}	
		if(checkformat == "email")
		{
			ctrl = ctrlstring.split(";");
			var ctrlname1 = ctrl[checkfieldid].split(",");
			if(!isEmail(eval(ctrlname1[0]).value))
			{
				alert("Please enter email in proper format.");	
				ctrlfocus = ctrlname1[0] + ".focus()";
				eval(ctrlfocus);
				submitflag = 0;
			}
		}	
	}
	if ( submitflag == 1 ) {
		
		document.frm.action = redirect_to;
		document.frm.submit();
	}	
}

function cancel_inplace(id)
{
document.frm.id.value = -1;
document.frm.submit();
}

function save_inplace(redirect_to, ctrlstring)
{
	submitflag = 1;
	if ( ctrlstring != "" ) {
		if ( checkEmptyString(ctrlstring) ) {
			alert(msgstring);
			eval(ctrlfocus);
			submitflag = 0;
		}
	}
	if ( submitflag == 1 ) {
		document.frm.action = redirect_to;
		document.frm.submit();
	}
}
function save_inplace_format(redirect_to, ctrlstring, checkformat, checkfieldid)
{
	/*
		redirect_to = file name to be redirected to
		ctrlstring = control name : display name pair string of controls to be varified for null
		checkformat = confirm -------------  confirm field
					  email ---------------  for email format validation
		checkfieldid = number of the control in the ctrlstring variable
	*/
	submitflag = 1;
	if ( ctrlstring != "" ) {
		if ( checkEmptyString(ctrlstring) ) {
			alert(msgstring);
			eval(ctrlfocus);
			submitflag = 0;
		}
	}
	if( submitflag == 1 )
	{
		if(checkformat == "confirm")
		{
			ctrl = ctrlstring.split(";");
			var ctrlname1 = ctrl[checkfieldid].split(",");
			var ctrlname2 = ctrl[checkfieldid+1].split(",");
			if(eval(ctrlname1[0]).value != eval(ctrlname2[0]).value)
			{
				alert("New password and Confirm password does not match.");	
				ctrlfocus = ctrlname1[0] + ".focus()";
				eval(ctrlfocus);
				submitflag = 0;
			}
		}	
		if(checkformat == "email")
		{
			ctrl = ctrlstring.split(";");
			var ctrlname1 = ctrl[checkfieldid].split(",");
			if(!isEmail(eval(ctrlname1[0]).value))
			{
				alert("Please enter email in proper format.");	
				ctrlfocus = ctrlname1[0] + ".focus()";
				eval(ctrlfocus);
				submitflag = 0;
			}
		}	
	}
	if ( submitflag == 1 ) {
		document.frm.action = redirect_to;
		document.frm.submit();
	}
}
function isPhoneReg(str)
{
var supported = 0;
var tempStr = str;
var tempReg = new RegExp("[0-9][0-9][0-9][-][0-9][0-9][0-9][-][0-9][0-9][0-9][0-9]");

if(!tempReg.test(tempStr))
    {
	alert("Phone number must be in 213-891-1373 format.\nPlz dont put space or any other character.")   
    }
return 	tempReg.test(tempStr);
}
function isEmail(str) 
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


	function checkInt(a)
	{
		a= Ltriming(RLtriming(a));
		if (a.split(" ").join("").length ==0)
		{
			return false;
		}
		var Anum = "0123456789";
		for (i=0;i<a.length;i++)
		{
			if (Anum.indexOf(a.substr(i,1)) == -1)
			{
				//alert(Anum.indexOf(a.substr(i,1)) + "," + a.substr(i,1));
				return false;
			}
		}
		return true;
	}
	function checkFloat(a)
	{
		a= Ltriming(RLtriming(a));
		if (a.split(" ").join("").length ==0)
		{
			return false;
		}
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
	function Ltriming(a)
	{
		var aa=a;
		var ctr=0;
		for (ctr=0;ctr<a.length;ctr++)
		{
			if (aa.substr(ctr,1)==' ')
			{
				ctr=ctr-1;
				aa=aa.replace(' ','');
			}
			else
			{
				break;
			}
		}
	
		return aa;	
	}
	function RLtriming(a)
	{
		var aa=a;
		var ctr=0;
		for (ctr=aa.length-1;ctr>=0;ctr--)
		{
			if (aa.substr(ctr,1)==' ')
			{
				ctr=ctr;
				aa=aa.replace(' ','');
			}
			else
			{
				break;
			}
		}
		return aa;	
	}



function int_Digits(e)
{	
	if(window.event)
    {
		
		if((event.keyCode>=48 && event.keyCode<=57) || event.keyCode == 8 || event.keyCode == 13 || event.keyCode == 0) {
			return true;	
		}
		else
		{	
			event.keyCode=0;
			return false;
		}
	}
	 else
        {
				key = e.which;     //firefox
				
				if((key >=48 && key <= 57) || key == 8 || key == 13 || key == 0) {
				return true;	
				}
				else
				{	
					key=0;
					return false;
		
				}

        }
}


function  onlynumber(e)
{
	if(window.event)
    {		
		if(event.keyCode>=48 && event.keyCode<=57 || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 45|| event.keyCode == 13 || event.keyCode == 0) 
		{
			return true;	
		}
		else
		{	
			event.keyCode=0;alert("Please enter numberic figures.")
			return false;
		}
	}
	else
    {
		var count=0
		key = e.which;     //firefox	
		if((key >=48 && key <= 57) || key == 8 || key == 9 || key == 45|| key == 13 || key == 0) 
		{
			return true;	
		}
		else
		{	
			key=0;
			alert("Please enter numberic figures.")
			return false;	
		}

    }
}
function phone_Digits()
{
	if((event.keyCode>=48 && event.keyCode<=57)  || event.keyCode == 45) {}
	else
	{	event.keyCode=0;alert("Phone number allows [0-9] and - only.")	}
}

function zip_Digits()
{
	if((event.keyCode>=48 && event.keyCode<=57)  || event.keyCode == 45) {}
	else
	{	event.keyCode=0;alert("Zip code allows [0-9] and - only.")	}
}


function floatDigits()
{
	if(event.keyCode == 46 || (event.keyCode>=48 && event.keyCode<=57)) {}
	else
	{	event.keyCode=0;	}
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

function trim(tmp)
{
	var temp;
	temp = tmp;
	//tmp = "      this is test     ";
	pat = /^\s+/;
	temp = temp.replace(pat, "");
	pat = /\s+$/;
	temp = temp.replace(pat, "");
	//alert(":" + tmp + ":");
	return temp;
}

function is_greater_date(dt1,dt2)
{

	var ard1=dt1.split("/");
	var ard2=dt2.split("/");
	var d1=new Date(Date.parse(ard1[2]+ "/" +ard1[1]+ "/" +ard1[0]));
	var d2=new Date(Date.parse(ard2[2]+ "/" +ard2[1]+ "/" +ard2[0]));

	if(d1>d2)
	{
		return true;
	}
	else
	{
		return false;	
	}
}
//function go(a,b,action)
//{
////	document.panel1.action = action;
//	//document.frm.action = action;
//	
//	if ( a != "" && a == "nothing") 
//	{
//		//document.frm.cpage.value = "";		
//	}
//	
//	if (b != "go")
//	{
//		if ( a != "nothing" && a != "" )
//		{ 
//			document.frm.hdnorderby.value = a;
//			document.frm.hdnorder.value = b;	
//		}
//	}
//	
//	if (b == "go")
//	{
//		//document.panel1.cpage.value = a;
//	}	
//
//	document.frm.submit();
//}

function RowHoverIn(Row)
{
	Row.className='tblrowMousehover';
}

function RowHoverOut(Row,rowclass)
{
	Row.className=rowclass;
}	
function intDigits_dot(e)
{
	if(window.event)
    {
		if(event.keyCode>=48 && event.keyCode<=57 || event.keyCode == 8) {
			return true;	
		}
		else
		{	
			event.keyCode=0;
			return false;
		}
	}
	 else
        {
				key = e.which;     //firefox
				if(key >=48 && key <= 57 || key == 8 || key == 0) {
				return true;	
				}
				else
				{	
					return false;
		
				}

        }
}


function create_element(elm)
{
	var el = document.createElement( elm );		
	if(arguments.length>1)
	{
		for(var i=0; i<arguments.length; i++)
		{
			var argtype = typeof arguments[i];
			switch( argtype.toLowerCase() )
			{
				case "object":	
					if( arguments[i].length==2 )
					{							
						el.setAttribute( arguments[i][0],arguments[i][1] );
					}//if array length==2
				break;
			}//switch
		}//for i
	}//if args
	return el;	
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


function formatnumber(myNum, numOfDec) 
{ 
	var decimal = 1 
	for(i=1; i<=numOfDec;i++) 
	decimal = decimal *10 
	var myFormattedNum = (Math.round(myNum * decimal)/decimal).toFixed(numOfDec) 
	return(myFormattedNum) 
}

function set_text ( objtextbox, default_value, event_type ) {
	if ( event_type == 'focus' ) {
		if ( objtextbox.value == default_value ) {
			objtextbox.value = '';
		}
	}
	if ( event_type == 'blur' ) {
		if ( objtextbox.value.split(' ').join('') == ''){
			objtextbox.value = default_value;
		}
	}
}

function slide_div_down(divmain)
{
	if(document.getElementById(divmain).style.display=="none"){
		Effect.SlideDown(divmain,{duration:0.7});
	}
}


function set_action(actiontype,entity_name)
{	
	
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
			alert("You must check atleast one checkbox.");
			return false;
		}
	
		if(confirm("Are you sure you want to delete selected "+entity_name+"(s)?"))
		{
			document.frm.hdnmode.value = "delete";
			document.frm.submit();
			return;
		}
		else
			return false;
	}
	else
	{
		document.frm.hdnmode.value = actiontype;
		document.frm.submit();		
	}
}

function set_action_ies(actiontype,entity_name)
{	
	
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
			alert("You must check atleast one checkbox.");
			return false;
		}
	
		if(confirm("Are you sure you want to delete selected "+entity_name+"(ies)?"))
		{
			document.frm.hdnmode.value = "delete";
			document.frm.submit();
			return;
		}
		else
			return false;
	}
	else
	{
		document.frm.hdnmode.value = actiontype;
		document.frm.submit();		
	}
}

function set_action_nos(actiontype,entity_name)
{	
	
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
			alert("You must check atleast one checkbox.");
			return false;
		}
	
		if(confirm("Are you sure you want to delete selected "+entity_name+"?"))
		{
			document.frm.hdnmode.value = "delete";
			document.frm.submit();
			return;
		}
		else
			return false;
	}
	else
	{
		document.frm.hdnmode.value = actiontype;
		document.frm.submit();		
	}
}

function showimage(img){
	window.open(img,"winimg","width=217,height=144,top=250,left=400");
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
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,undo,redo,|,cleanup,code,|,insertdate,inserttime,preview,|,forecolor,backcolor,|,insertimage",
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
		theme_advanced_buttons1 : "save,newdocument,|,bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,styleselect,formatselect,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "cut,copy,paste,pastetext,pasteword,|,search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,cleanup,help,code,|,insertimage,insertdate,inserttime,preview,|,forecolor,backcolor",
		theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid,|,sub,sup,|,charmap,emotions,iespell,media,advhr,|,print,|,ltr,rtl,|,fullscreen",
		theme_advanced_buttons4 : "insertlayer,moveforward,movebackward,absolute,|,styleprops,|,cite,abbr,acronym,del,ins,attribs,|,visualchars,nonbreaking,template,pagebreak,restoredraft",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,
		
		 paste_auto_cleanup_on_paste : true,
		document_base_url : base_url,
		
		// Style formats
		style_formats : [
			{title : 'Bold text', inline : 'b'},
			{title : 'Red text', inline : 'span', styles : {color : '#ff0000'}},
			{title : 'Red header', block : 'h1', styles : {color : '#ff0000'}},
			{title : 'Example 1', inline : 'span', classes : 'example1'},
			{title : 'Example 2', inline : 'span', classes : 'example2'},
			{title : 'Table styles'},
			{title : 'Table row 1', selector : 'tr', classes : 'tablerow1'}
		],
		
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

function set_text ( objtextbox, default_value, event_type ) {
	if ( event_type == 'focus' ) {
		if ( objtextbox.value == default_value ) {
			objtextbox.value = '';
		}
	}
	if ( event_type == 'blur' ) {
		if ( objtextbox.value.split(' ').join('') == ''){
			objtextbox.value = default_value;
		}
	}
}

function setdelete_checkbox ( checkbox_status ) {
	if ( document.frm.deletedids ) {
		if ( document.frm.deletedids.length == undefined ) {
			if ( document.frm.deletedids.disabled == false ) {
				document.frm.deletedids.checked = checkbox_status;		
			}
		}		
		else {
			for ( intcounter = 0; intcounter < document.frm.deletedids.length; intcounter++ ) {
				if ( document.frm.deletedids[intcounter] ) {
					if ( document.frm.deletedids[intcounter].disabled == false ) {
						document.frm.deletedids[intcounter].checked = checkbox_status;
					}
				}
			}	
		}
	}
}

function go_back ( ) {
	window.history.back();	
}

function open_window(pageURL, title,w,h) {
	var left = (screen.width/2)-(w/2);
	var top = (screen.height/2)-(h/2);
	var targetWin = window.open (pageURL, title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width='+w+', height='+h+', top='+top+', left='+left);
}

function seoURL(e)
{
  var keynum;
  var keychar;
  var numcheck;

  if(e.keyCode==9)
    return true;
  else
  {
      if(window.event) // IE
      {
        keynum = e.keyCode;
      }
      else if(e.which) // Netscape/Firefox/Opera
      {
        keynum = e.which;
      }    
		
		alert(keynum);
		
		if((keynum>=48 && keynum<=57 ) || (keynum>=97 && keynum<=122 )|| keynum==13 || keynum==8 || keynum==9 || keynum==45 || keynum==95)
		{
			return true;
		}
		else
		{
            keynum=0;
            return false;
		}
	}
}