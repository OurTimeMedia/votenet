

function setContestPlan(contest_plan_id)
{	
	if(contest_plan_id!=document.getElementById("txtctid").value && document.getElementById("txtctid").value!=0)
	{
		if(confirm("You have to reset all information if you change plan type. Are you sure you want to change plan type for you contest?"))
		{ 
			document.frm.txtcontest_plan_id.value=contest_plan_id;
			document.frm.txtplanchanged.value=1;
			document.frm.submit();
		}
	}
	else
	{
		document.frm.txtcontest_plan_id.value=contest_plan_id;
		document.frm.submit();
	}
}

function domainFunction(isprivate_domain)
{
	if(isprivate_domain!=0)
	{
		document.getElementById('tr2').style.display='none';
	}
	else
	{
		document.getElementById('tr2').style.display='';
	}
}

function setContestDetail()
{
	var defaultLanguageID = document.frm.hdndefaultlanguage_id.value;
	var index = 0;
	var arValidate = new Array;
	
	var rad_val = '';
	for (var i=0; i < document.frm.rdoismonitory_awards.length; i++)
    {
   		if (document.frm.rdoismonitory_awards[i].checked)
      	{
      		rad_val = document.frm.rdoismonitory_awards[i].value;
     	}
    }

	if(rad_val=="")
	{
		alert("Please select Monetary Awards option.");
		document.frm.elements["rdoismonitory_awards"][0].focus();
		return false;
	}

	if(rad_val==1)
	{
		arValidate[index++] = new Array("S", "document.frm.selcurrency_id", "Award Currency");
	}
	
	arValidate[index++] = new Array("R", "document.frm.txtcontest_title_"+defaultLanguageID, "Contest Title");
	arValidate[index++] = new Array("R", "document.frm.txtcontest_description_"+defaultLanguageID, "Description");
	arValidate[index++] = new Array("R", "document.frm.txtcontest_rules_"+defaultLanguageID, "Contest Rules");
	arValidate[index++] = new Array("R", "document.frm.txtorganizer_name", "Organizer Name");
	arValidate[index++] = new Array("R", "document.frm.txtorganizer_address", "Organizer Address");
	arValidate[index++] = new Array("S", "document.getElementById('rdoisprivate_domain')", "Domain Type");
	arValidate[index++] = new Array("R", "document.frm.txtdomain", "Domain Name");
	arValidate[index++] = new Array("DM", "document.frm.txtdomain", "Domain Name");
	arValidate[index++] = new Array("S", "document.getElementById('rdoismoderation')", "Moderation Type");
	arValidate[index++] = new Array("R", "document.frm.txtwinner_announce_date", "Announcement Date");
	arValidate[index++] = new Array("S", "document.getElementById('rdowinner_type')", "Winner Selection Method");

	if (!Isvalid(arValidate)){
		return false;
	}
	return true;
}

function setCurrencyVal(shw)
{
	if(shw==1)
	{
		document.getElementById('currency-type').style.display='';
	}
	else
	{
		document.getElementById('currency-type').style.display='none';
	}
}

function showLanguageFields(language_id)
{
		if(eval("document.frm.chklanguage_"+language_id+".checked")==true)
		{
			document.getElementById("contest_title_"+language_id).style.display = "";
			document.getElementById("contest_description_"+language_id).style.display = "";
			document.getElementById("contest_rules_"+language_id).style.display = "";
		}
		else
		{
			document.getElementById("contest_title_"+language_id).style.display = "none";
			document.getElementById("contest_description_"+language_id).style.display = "none";
			document.getElementById("contest_rules_"+language_id).style.display = "none";
		}
}

function showhide()
{
	if(document.getElementById('selcollect_entry_fees').value > 0)
	{
		document.getElementById('trfees').style.display = '';
		document.getElementById('trpayment').style.display = '';
		document.getElementById('trpaypal').style.display = '';		
	}
	else
	{
		document.getElementById('trfees').style.display = 'none';
		document.getElementById('trpayment').style.display = 'none';
		document.getElementById('trpaypal').style.display = 'none';		
	}		
}

function showAccountDtl(selpayment_method)
{
	if (selpayment_method == 1)
	{	
		document.getElementById('trpaypal').style.display='';
	}
	else
	{
		document.getElementById('trpaypal').style.display='none';
	}
}

function setContestSubmission()
{
	var index = 0;
	var arValidate = new Array;

	arValidate[index++] = new Array("R", "document.frm.txtentry_start_date", "Start Date & Time");
	arValidate[index++] = new Array("R", "document.frm.txtentry_end_date", "End Date & Time");
	
	if (!Isvalid(arValidate)){
		return false;
	}
	
	var startDate = document.frm.txtentry_start_date.value;
	var startDateVal = startDate.split(" ");
	
	var endDate = document.frm.txtentry_end_date.value;
	var endDateVal = endDate.split(" ");
	
	//var chkDateVal = CompareDatesChk(startDateVal[0],endDateVal[0]);
	var chkDateVal = CompareDatesTimeChk(startDate,endDate);
	
	if(chkDateVal==0)
	{
		alert("End Date should be greater than Start Date!");
		document.frm.txtentry_start_date.focus;
		return false;
	}
	
	/*var startTime = startDateVal[1].split(":");
	var endTime = endDateVal[1].split(":");

	var startHours = startTime[0];
	var endHours = endTime[0];


	if(startDateVal[2]=='pm')
	{
		startHours = parseInt(startTime[0])+12;
	}

	if(endDateVal[2]=='pm')
	{	
		endHours = parseInt(endTime[0])+12;
	}
	
	if(endDateVal[0]==startDateVal[0] && startHours>=endHours)
	{
		alert("'End Date' should be grater then 'Start Date'!");
		document.frm.txtentry_start_date.focus;
		return false;
	}*/
	
	var index = 0;
	var arValidate = new Array;
	arValidate[index++] = new Array("S", "document.frm.selcollect_entry_fees", "Collect Entry Fees");
	
	if(document.frm.selcollect_entry_fees.value==1)
	{
		arValidate[index++] = new Array("R", "document.frm.txtfees_value", "Fees Value");
		arValidate[index++] = new Array("F", "document.frm.txtfees_value", "Fees Value");
		arValidate[index++] = new Array("INZ", "document.frm.txtfees_value", "Fees Value");
		arValidate[index++] = new Array("S", "document.frm.selpayment_method", "Payment Type");
		if(document.frm.selpayment_method.value==1)
		{
			arValidate[index++] = new Array("R", "document.frm.txtpaypal_busines_account", "PayPal Business Account Email");
			arValidate[index++] = new Array("E", "document.frm.txtpaypal_busines_account", "PayPal Business Account Email");
		}
	}
	
	if (!Isvalid(arValidate)){
		return false;
	}
	
	if(document.frm.hidtotal_fields_onform.value<=0)
	{
		alert("Please enter at least one field for submission form");
		return false;
	}
	
	return true;	
}


function setTemplateDetail(template_id,template_thumb_image,template_background_color,template_background_image,template_name,template_header_image)
{
	document.frm.txttemplate_id.value = template_id;
	
	document.frm.txtbackground_color.value = template_background_color;
	document.frm.txtbackground_image.value = template_background_image;
	document.frm.txttemplate_header_image.value = template_header_image;
	var SERVER_HOST = document.frm.SERVER_HOST.value;
	var SERVER_HOST = document.frm.SERVER_HOST.value;
	
	document.getElementById('txtbackground_color_cust').value = template_background_color;
	
	document.getElementById('templateImage').innerHTML = "<img src='"+SERVER_HOST+"common/files/image.php/"+template_thumb_image+"?width=165&amp;height=109&amp;cropratio=1:1&amp;image=/files/templates/"+template_thumb_image+"' alt='"+template_name+"' title='"+template_name+"' style='border:5px solid #7eb6f5;'/>";

	document.getElementById('selectedTemplate').style.display='';
}

function designValidations()
{
	var index = 0;
	var arValidate = new Array;
	
	if(document.frm.txttemplate_id.value=="" || document.frm.txttemplate_id.value==0)
	{
		alert("Please select Template!");
		return false;
	}

	if(document.getElementById('rdobackground_type2').checked==true && document.frm.txtbackground_image_cust.value=="" && document.frm.alreadyUploadedBg.value==document.getElementById('defaultBgImageValue').value)
	{
		alert("Please select Background Image!");
		document.frm.txtbackground_image_cust.focus();
		return false;
	}

	if(document.getElementById('rdobackground_type2').checked==true && document.frm.alreadyUploadedBg.value=="")
	{
		if(validateFile(document.frm.txtbackground_image_cust,document.frm.allowImageExts.value)==false)
		{
			document.frm.txtbackground_image_cust.focus();
			return false;
		}
	}
	
	if(document.frm.txtheader_banner_image_cust.value!="")
    {
		if(validateFile(document.frm.txtheader_banner_image_cust,document.frm.allowImageExts.value)==false)
		{
			document.frm.txtheader_banner_image_cust.focus();
			return false;
		}
    }
	
	if (!Isvalid(arValidate)){
		return false;
	}
	//return true;
}

function paymentValidations()
{
	var index = 0;
	var arValidate = new Array;
	
	arValidate[index++] = new Array("R", "document.frm.txtbillingname", "Billing Name");
	arValidate[index++] = new Array("R", "document.frm.txtbill_address1", "Address1");
	arValidate[index++] = new Array("R", "document.frm.txtbill_address2", "Address2");
	arValidate[index++] = new Array("R", "document.frm.txtbill_city", "City");
	arValidate[index++] = new Array("R", "document.frm.txtbill_state", "State");
	arValidate[index++] = new Array("R", "document.frm.txtbill_zipcode", "Zip Code");
	arValidate[index++] = new Array("S", "document.frm.selcountry_id", "Country");
	
	if(document.getElementById('rdotransaction_type1'))
	{
		if(document.getElementById('rdotransaction_type1').checked == true && document.frm.txtpaymentstatus.value!=1)
		{
			arValidate[index++] = new Array("S", "document.frm.selcc_type", "Credit Card Type");
			arValidate[index++] = new Array("R", "document.frm.txtcc_number", "Card Number");
			arValidate[index++] = new Array("S", "document.frm.selcc_expiry_month", "Expiry Month");
			arValidate[index++] = new Array("S", "document.frm.selcc_expiry_year", "Expiry Year");
			arValidate[index++] = new Array("R", "document.frm.txtcc_cvv_no", "CVV");
		}
	}

	if (!Isvalid(arValidate)){
		return false;
	}
	return true;
}

function setStatus(statusVal)
{		
		document.getElementById('txtcontest_status').value = statusVal;
}


function deleteField(ctrl, field_id)
{	
	if(confirm("Are you sure you want to delete this field?"))
	{
		var data1 = "field_id="+field_id+"&edit=0";;
		jQuery.ajax({type: "POST", url: "field_ajax_delete.php", data: data1, success: function(msg2){					 
			 if(msg2 != "")
				alert(msg2);
			 document.getElementById("tblPreview").deleteRow(ctrl.parentNode.parentNode.rowIndex);
			 document.getElementById("hidtotal_fields_onform").value = document.getElementById("hidtotal_fields_onform").value - 1;
			 //alert(msg2);
		   }
		});
	}	
}

function chkFromToDates()
{
	var startDateVal = document.getElementById('txtdatefrom').value;
	var endDateVal = document.getElementById('txtdateto').value;
	if(startDateVal!="" && endDateVal!="")
	{
		var chkDateVal = CompareDatesChk(startDateVal,endDateVal);
		if(chkDateVal==0)
		{
			alert("End Date should be greater than Start Date!");
			document.getElementById('txtdatefrom').focus;
			return false;
		}
		return true;
	}
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