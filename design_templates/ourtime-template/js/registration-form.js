	function hidedefaultrow(id, show)
	{	
		if (document.getElementById(id))
		{
			if (show == "1")
				jQuery('#'+id).show(); 				
			else
				jQuery('#'+id).hide(); 									
		}			
	}
	
	function change_select(ids)
	{
		if (document.getElementById(ids))
		{
			var opt = document.getElementById(ids).options;
			
			var sindex = document.getElementById(ids).selectedIndex;
			var svalue = document.getElementById(ids).value;

			for (var j=0; j<opt.length; j++)
			{				
				if (opt[j].value.length == 0) 
					continue;

				var ovalue = opt[j].value;
				var valarr = opt[j].value.split("_");
				
				if (valarr.length > 0)
				{
					var id = valarr[0];
					var showid = valarr[1].split("|");
					var hideid = valarr[2].split("|");						

					for (var i=0; i<showid.length; i++)
					{	
						if (svalue == ovalue)
						{	
							if (jQuery('#row_'+showid[i]))			
							{
								jQuery('#row_'+showid[i]).show();	
								if(showid[i]!="" && document.getElementById("frmshw_"+showid[i]))
								{
									document.getElementById("frmshw_"+showid[i]).value="yes";
								}
							}
						}
						else
						{	
							if (jQuery('#row_'+showid[i]))			
							{
								jQuery('#row_'+showid[i]).hide();				
								clear_form_elements('#row_'+showid[i]);
								
								if(showid[i]!="" && document.getElementById("frmshw_"+showid[i]))
								{
									document.getElementById("frmshw_"+showid[i]).value="no";
								}
							}
						}
					}														

					for (var i=0; i<hideid.length; i++)
					{	
						if (svalue == ovalue)
						{
							if (jQuery('#row_'+hideid[i]))			
							{	
								jQuery('#row_'+hideid[i]).hide();				
								clear_form_elements('#row_'+hideid[i]);		
								if(hideid[i]!="" && document.getElementById("frmshw_"+hideid[i]))
								{
									document.getElementById("frmshw_"+hideid[i]).value="no";
								}
							}
						}
						else
						{	
							if (jQuery('#row_'+hideid[i]))			
							{
								jQuery('#row_'+hideid[i]).show();	
								if(hideid[i]!="" && document.getElementById("frmshw_"+hideid[i]))
								{
									document.getElementById("frmshw_"+hideid[i]).value="yes";
								}
							}
						}
					}		
				}						
			}								
		}
	}
	

	function change_checkbox(ids)
	{
		var radio = document.getElementsByName(ids);
		
		for (var j=0; j<radio.length; j++)
		{
			var valarr = radio[j].value.split("_");
			
			var id = valarr[0];
			var showid = valarr[1].split("|");
			var hideid = valarr[2].split("|");			

			for (var i=0; i<showid.length; i++)
			{	
				if (radio[j].checked == true)
				{
					if (jQuery('#row_'+showid[i]))			
					{
						jQuery('#row_'+showid[i]).show();	
						if(showid[i]!="")
						{
							document.getElementById("frmshw_"+showid[i]).value="yes";
						}
					}
				}
				else
				{	
						if (jQuery('#row_'+showid[i]))			
						{
							jQuery('#row_'+showid[i]).hide();	
							clear_form_elements('#row_'+showid[i]);		
							if(showid[i]!="" && document.getElementById("frmshw_"+showid[i]))
							{
								document.getElementById("frmshw_"+showid[i]).value="no";
							}
						}
					
				}
			}

			for (var i=0; i<hideid.length; i++)
			{
				if (radio[j].checked == true)
				{
					if (jQuery('#row_'+hideid[i]))			
					{
						jQuery('#row_'+hideid[i]).hide();				
						clear_form_elements('#row_'+hideid[i]);		
						if(hideid[i]!="" && document.getElementById("frmshw_"+hideid[i]))
						{
							document.getElementById("frmshw_"+hideid[i]).value="no";
						}
					}
				}
				else
				{	
					if (jQuery('#row_'+hideid[i]))			
					{
						jQuery('#row_'+hideid[i]).show();
						if(hideid[i]!="" && document.getElementById("frmshw_"+hideid[i]))
						{
							document.getElementById("frmshw_"+hideid[i]).value="yes";
						}
					}
				}
			}		
			
   		}			
	}


	function change_radio(ids)
	{
		var radio = document.getElementsByName(ids);

		for (var j=0; j<radio.length; j++)
		{
			var valarr = radio[j].value.split("_");
			
			var id = valarr[0];
			var showid = valarr[1].split("|");
			var hideid = valarr[2].split("|");						
			
			for (var i=0; i<showid.length; i++)
			{	
				if (radio[j].checked == true)
				{	
					if (jQuery('#row_'+showid[i]))			
					{
						jQuery('#row_'+showid[i]).show();	
						if(showid[i]!="" && document.getElementById("frmshw_"+showid[i]))
						{
							document.getElementById("frmshw_"+showid[i]).value="yes";
						}
					}
				}
				else
				{
					if (jQuery('#row_'+showid[i]))			
					{
						jQuery('#row_'+showid[i]).hide();	
						clear_form_elements('#row_'+showid[i]);	
						
						if(showid[i]!="" && document.getElementById("frmshw_"+showid[i]))
						{	
							document.getElementById("frmshw_"+showid[i]).value="no";
						
						}
					}							
				}
			}

			for (var i=0; i<hideid.length; i++)
			{	
				if (radio[j].checked == true)
				{	
					if (jQuery('#row_'+hideid[i]))			
					{
						jQuery('#row_'+hideid[i]).hide();				
						clear_form_elements('#row_'+hideid[i]);	
						if(hideid[i]!="" && document.getElementById("frmshw_"+hideid[i]))
						{
							document.getElementById("frmshw_"+hideid[i]).value="no";
						}
					}
				}
				else
				{
					if (jQuery('#row_'+hideid[i]))			
					{
						jQuery('#row_'+hideid[i]).show();
						if(hideid[i]!="" && document.getElementById("frmshw_"+hideid[i]))
						{
							document.getElementById("frmshw_"+hideid[i]).value="yes";
						}
					}							
				}
			}					
   		}			
	}




	function change_checkbox_default(ids)
	{
		var radio = document.getElementsByName(ids);

		for (var j=0; j<radio.length; j++)
		{
			var valarr = radio[j].value.split("_");
			
			var id = valarr[0];
			var showid = valarr[1].split("|");
			var hideid = valarr[2].split("|");						
			
			for (var i=0; i<showid.length; i++)
			{	
				if (radio[j].checked == true)
				{
					if (jQuery('#row_'+showid[i]))			
					{
						jQuery('#row_'+showid[i]).show();	
						if(showid[i]!="")
						{
							document.getElementById("frmshw_"+showid[i]).value="yes";
						}
					}
				}
				else
				{	
					if (jQuery('#row_'+showid[i]) && showid[i]!="")			
					{
						if(document.getElementById('isSubmit').value!=0 && document.getElementById("frmshw_"+showid[i]).value!='no')
						{
							jQuery('#row_'+showid[i]).hide();	
							clear_form_elements('#row_'+showid[i]);		
							if(showid[i]!="")
							{
								document.getElementById("frmshw_"+showid[i]).value="no";
							}
						}
						else if(document.getElementById('isSubmit').value==1 && document.getElementById("frmshw_"+showid[i]).value=='yes')
						{
							jQuery('#row_'+showid[i]).hide();	
							clear_form_elements('#row_'+showid[i]);		
							if(showid[i]!="")
							{
								document.getElementById("frmshw_"+showid[i]).value="no";
							}
						}
					}
				}
			}

			for (var i=0; i<hideid.length; i++)
			{
				if (radio[j].checked == true)
				{
					if (jQuery('#row_'+hideid[i]))			
					{
						jQuery('#row_'+hideid[i]).hide();				
						clear_form_elements('#row_'+hideid[i]);		
						if(hideid[i]!="")
						{
							document.getElementById("frmshw_"+hideid[i]).value="no";
						}
					}
				}
				else
				{	
					if (jQuery('#row_'+hideid[i]) && hideid[i]!="")			
					{
						if(document.getElementById('isSubmit').value!=0 && document.getElementById("frmshw_"+hideid[i]).value!='no')
						{
							jQuery('#row_'+hideid[i]).show();
							if(hideid[i]!="")
							{
								document.getElementById("frmshw_"+hideid[i]).value="yes";
							}
						}
						else if(document.getElementById('isSubmit').value==1 && document.getElementById("frmshw_"+hideid[i]).value=='yes')
						{
							jQuery('#row_'+hideid[i]).show();
							if(hideid[i]!="")
							{
								document.getElementById("frmshw_"+hideid[i]).value="yes";
							}
						}
					}
				}
			}		
			
   		}			
	}


	function change_radio_default(ids)
	{
		var radio = document.getElementsByName(ids);

		for (var j=0; j<radio.length; j++)
		{
			var valarr = radio[j].value.split("_");
			
			var id = valarr[0];
			var showid = valarr[1].split("|");
			var hideid = valarr[2].split("|");						
			
			for (var i=0; i<showid.length; i++)
			{	
				if (radio[j].checked == true)
				{	
					if (jQuery('#row_'+showid[i]))			
					{
						jQuery('#row_'+showid[i]).show();	
						if(showid[i]!="")
						{
							document.getElementById("frmshw_"+showid[i]).value="yes";
						}
					}
				}
				else
				{
					if (jQuery('#row_'+showid[i]) && showid[i]!="")			
					{
						if(document.getElementById('isSubmit').value!=0 && document.getElementById("frmshw_"+showid[i]).value!='no')
						{
							jQuery('#row_'+showid[i]).hide();	
							clear_form_elements('#row_'+showid[i]);	
							
							if(showid[i]!="")
							{	
								document.getElementById("frmshw_"+showid[i]).value="no";
							
							}
						}
						else if(document.getElementById('isSubmit').value==1 && document.getElementById("frmshw_"+showid[i]).value=='yes')
						{
							jQuery('#row_'+showid[i]).hide();	
							clear_form_elements('#row_'+showid[i]);	
							
							if(showid[i]!="")
							{	
								document.getElementById("frmshw_"+showid[i]).value="no";
							
							}
						}
					}
				}
			}

			for (var i=0; i<hideid.length; i++)
			{	
				if (radio[j].checked == true)
				{	
					if (jQuery('#row_'+hideid[i]))			
					{
						jQuery('#row_'+hideid[i]).hide();				
						clear_form_elements('#row_'+hideid[i]);	
						if(hideid[i]!="")
						{
							document.getElementById("frmshw_"+hideid[i]).value="no";
						}
					}
				}
				else
				{	
					if (jQuery('#row_'+hideid[i]) && hideid[i]!="")			
					{	
						if(document.getElementById('isSubmit').value!=0 && document.getElementById("frmshw_"+hideid[i]).value!='no')						{	
							jQuery('#row_'+hideid[i]).show();
							if(hideid[i]!="")
							{
								document.getElementById("frmshw_"+hideid[i]).value="yes";
							}
						}
						else if(document.getElementById('isSubmit').value==1 && document.getElementById("frmshw_"+hideid[i]).value=='yes')
						{
							jQuery('#row_'+hideid[i]).show();
							if(hideid[i]!="")
							{
								document.getElementById("frmshw_"+hideid[i]).value="yes";
							}
						}
					}
				}
			}					
   		}			
	}


	function change_select_default(ids)
	{
		if (document.getElementById(ids))
		{
			var opt = document.getElementById(ids).options;
			
			var sindex = document.getElementById(ids).selectedIndex;
			var svalue = document.getElementById(ids).value;

			for (var j=0; j<opt.length; j++)
			{				
				if (opt[j].value.length == 0) 
					continue;

				var ovalue = opt[j].value;
				var valarr = opt[j].value.split("_");
				
				if (valarr.length > 0)
				{
					var id = valarr[0];
					var showid = valarr[1].split("|");
					var hideid = valarr[2].split("|");						

					for (var i=0; i<showid.length; i++)
					{	
						if (svalue == ovalue)
						{	
							if (jQuery('#row_'+showid[i]))			
							{
								jQuery('#row_'+showid[i]).show();	
								if(showid[i]!="")
								{
									document.getElementById("frmshw_"+showid[i]).value="yes";
								}
							}
						}
						else
						{	
							if (jQuery('#row_'+showid[i]) && showid[i]!="")			
							{
								if(document.getElementById('isSubmit').value!=0 && document.getElementById("frmshw_"+showid[i]).value!='no')
								{
									jQuery('#row_'+showid[i]).hide();				
									clear_form_elements('#row_'+showid[i]);
									if(showid[i]!="")
									{
										document.getElementById("frmshw_"+showid[i]).value="no";
									}
								}
								else if(document.getElementById('isSubmit').value==1 && document.getElementById("frmshw_"+showid[i]).value=='yes')
								{
									jQuery('#row_'+showid[i]).hide();				
									clear_form_elements('#row_'+showid[i]);
									if(showid[i]!="")
									{
										document.getElementById("frmshw_"+showid[i]).value="no";
									}
								}
							}
						}
					}														

					for (var i=0; i<hideid.length; i++)
					{	
						if (svalue == ovalue)
						{
							if (jQuery('#row_'+hideid[i]))			
							{	
								jQuery('#row_'+hideid[i]).hide();				
								clear_form_elements('#row_'+hideid[i]);		
								if(hideid[i]!="")
								{
									document.getElementById("frmshw_"+hideid[i]).value="no";
								}
							}
						}
						else
						{	
							if (jQuery('#row_'+hideid[i]) && hideid[i]!="")			
							{
								if(document.getElementById('isSubmit').value!=0 && document.getElementById("frmshw_"+hideid[i]).value!='no')
								{
									jQuery('#row_'+hideid[i]).show();	
									if(hideid[i]!="")
									{
										document.getElementById("frmshw_"+hideid[i]).value="yes";
									}
								}
								else if(document.getElementById('isSubmit').value==1 && document.getElementById("frmshw_"+hideid[i]).value=='yes')
								{
									jQuery('#row_'+hideid[i]).show();	
									if(hideid[i]!="")
									{
										document.getElementById("frmshw_"+hideid[i]).value="yes";
									}
								}
							}
							
						}
					}		
				}						
			}								
		}
	}
	