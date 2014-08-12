<div class="content">
	<div style="width:100%; float:left;">
    <div class="step2-main">
      <div class="step2">
        <h1>Register to Vote</h1>
		
        <div class="step2-table">

          <div class="from-main">
			<div class="from">
              <div style="float:left; width:28%; text-align:left;"><span class="span">*</span> Language Preference</div>
              <div style="float:left; width:72%; text-align:left;">{$language_preference}</div>
			</div>	
            <div class="from">
              <div style="float:left; width:28%; text-align:left;"><span class="span">*</span> Your Zip Code/State</div>
              <div style="float:left; width:72%; text-align:left;"><input name="ZipCode" type="text" class="from-input" id="ZipCode" value="{$value_zipcode}"  style="width: 120px;" />&nbsp;&nbsp;
              <span class="or">Or</span>&nbsp;&nbsp;
				<select tabindex="2" id="state" size="1" name="state" class="from-input required" style="width: 200px;">
					<option selected="selected" value="">-- Select a State --</option>
					{$statedata}
				</select>
			</div>			              
            </div>
            <div style="border-bottom:1px dotted #ccc; float:left; margin-bottom:12px; width:100%; height:1px;"></div>
            <div class="from">
              <div style="float:left; width:28%; text-align:left;"><span class="span">*</span> Your Email Address</div>
              <div style="float:left; width:72%; text-align:left;"><input name="Email" type="text" id="Email" class="from-input required email" value="{$value_email}" /></div>
            </div>            
            <div class="from">
			<div style="float:left; width:28%; text-align:left;">&nbsp;</div>
			<div style="float:left; width:28%; text-align:left;"><br /><input type="image" name="btnContinue" src="{$image_dir}continue-btn.jpg" alt="Continue" width="122" height="33" /></div>
			</div>
          </div>
        </div>		
      </div>
    </div>

    <div style="width:100%; float:left; padding-bottom:20px;">
      <div style="width:auto; float:left; padding-left:120px;"> <a href="googlemap.php?keepThis=true&TB_iframe=true&height=450&width=560"  class="thickbox">Find Your Election Center</a></div>      
	  <div style="width:auto; float:right; text-align:right; padding-right:120px;">
        <a href="election_dates.php?keepThis=true&TB_iframe=true&height=450&width=545"  class="thickbox">View Key Dates and Deadline</a></div>      
    </div>
    </div>
	<div style="width:100%; float:left;">
	<div class="facebook">Help Us Spread the Word:</div>
		<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=323953510985672";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
		
      <div class="fb-like" data-href="https://www.electionimpact.com" data-send="false" data-width="720" data-show-faces="false"></div>
	</div>
</div>
<script type="text/javascript">
function validate()
{
	var index = 0;
	var arValidate = new Array;
	
	if(document.formID.ZipCode.value == "" && document.formID.state.value == "") 
	{
		alert("Please enter Zip code or select State.");
		document.formID.ZipCode.focus();
		return false;
	}
	
	if(document.formID.ZipCode.value != "")
	{
		arValidate[index++] = new Array("I", "document.formID.ZipCode", "Zip code");
		
		if(document.formID.ZipCode.value.length != 5)
		{
			alert("Please enter valid Zip code.");
			document.formID.ZipCode.focus();
			return false;
		}
	}
		
	arValidate[index++] = new Array("R", "document.formID.Email", "Email Address");
	arValidate[index++] = new Array("E", "document.formID.Email", "Email Address");
	
	if (!Isvalid(arValidate))
	{
		return false;
	}
	
	return true;
}

jQuery(document).ready(function() {
    jQuery("#formID").validate({
		rules: {
			state: {
			  required: "#rdAddSel2:checked"
			},
			ZipCode: {
			  required: "#rdAddSel1:checked" 
			},
			Email: "required"
		},
		messages: {
			ZipCode: "Please enter Zip code.",
			state: "Please select State.",
			Email: "Please enter valid Email Address."
		}		
	});
});

function availableAddress()
{
	if(document.formID.rdAddSel[0].checked == true)
	{
		document.formID.state.disabled=true;
		document.formID.state.value="";
		document.formID.ZipCode.disabled=false;
	}
	if(document.formID.rdAddSel[1].checked == true)
	{
		document.formID.ZipCode.value="";
		document.formID.ZipCode.disabled=true;
		document.formID.state.disabled=false;
	}
}
</script>   