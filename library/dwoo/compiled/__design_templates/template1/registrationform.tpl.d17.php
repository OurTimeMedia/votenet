<?php
/* template head */
/* end template head */ ob_start(); /* template body */ ?><div class="content">
	<div class="contentmain">
    <div class="step2-main">
      <div class="step2">
        <h1><?php echo $this->scope["LANG_REGISTER_TO_VOTE_TEXT"];?></h1>
		<form id="formID" name="formID" method="post" action="">
        <div class="step2-table">

          <div class="from-main">
			<?php if ((isset($this->scope["language_preference_hide"]) ? $this->scope["language_preference_hide"] : null) == "0") {
?>
			<div class="from">
              <div class="homepageleftside"><span class="span">*</span> <?php echo $this->scope["LANG_LANGUAGE_PREFERENCE_TEXT"];?></div>
              <div class="homepagerightside"><?php echo $this->scope["language_preference"];?></div>
			</div>
			<?php 
}
else {
?>
			<?php echo $this->scope["language_preference"];?>	
			<?php 
}?>			
            <div class="from">
              <div class="homepageleftside"><span class="span">*</span> <?php echo $this->scope["LANG_YOUR_ZIP_STATE_TEXT"];?></div>
              <div class="homepagerightside"><input name="ZipCode" type="text" class="inputzipcode" id="ZipCode" value="<?php echo $this->scope["value_zipcode"];?>" maxlength="5" />&nbsp;&nbsp;
              <span class="or"><?php echo $this->scope["LANG_OR_TEXT"];?></span>&nbsp;&nbsp;
				<select id="state" size="1" name="state" class="inputstate required">
					<option selected="selected" value="">-- <?php echo $this->scope["LANG_SELECT_A_STATE_TEXT"];?> --</option>
					<?php echo $this->scope["statedata"];?>

				</select>
			</div>			              
            </div>			
            <div class="dashedline"></div>
            <div class="from">
              <div class="homepageleftside"><span class="span">*</span> <?php echo $this->scope["LANG_YOUR_EMAIL_ADDRESS_TEXT"];?></div>
              <div class="homepagerightside"><input name="Email" type="text" id="Email" class="from-input required email" value="<?php echo $this->scope["value_email"];?>" /></div>
            </div>            
            <div class="from">
			<div class="homepageleftside">&nbsp;</div>
			<div class="homepagerightside"><input type="image" name="btnContinue" src="<?php echo $this->scope["image_dir"];
echo $this->scope["LANG_CONTINUE_TEXT"];?>" alt="Continue" width="122" height="33" /></div>
			</div>
          </div>
        </div>
		</form>
      </div>
    </div>
	<?php if ((isset($this->scope["Voting_Source"]) ? $this->scope["Voting_Source"] : null) == "Website") {
?>    
	<div class="homepageextralinks">
      <div class="officelocation"> <a href="electioncenter.php?keepThis=true&TB_iframe=true&height=450&width=560"  class="thickbox"><?php echo $this->scope["LANG_STATE_VOTER_REGISTRATION_OFFICE_LOCATION_TEXT"];?></a></div>      
	  <div class="keydates">
        <a href="election_dates.php?keepThis=true&TB_iframe=true&height=470&width=545"  class="thickbox"><?php echo $this->scope["LANG_VIEW_KEY_DATES_AND_DEADLINES_TEXT"];?></a></div>      
    </div>
    </div>
	<?php if ((isset($this->scope["mobile_device"]) ? $this->scope["mobile_device"] : null)) {
?>
	<?php 
}
else {
?>
	<div class="contentmain">	
	<div class="facebook"><?php echo $this->scope["LANG_HELP_US_SPREAD_THE_WORD"];?>:</div>
		<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=209440782426123";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
	    
	  <div class="fb-like" data-href="<?php echo $this->scope["site_domain_link"];?>" data-send="false" data-width="720" data-show-faces="false"></div>
	</div>  
	<?php 
}

}?>

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
			  required: function(element) {
					if(jQuery("#ZipCode").val() == "")
					{						
						return true;
					}
					else {
						return false;
					}
			  }
			},
			ZipCode: {
			  required: function(element) {
					if(jQuery("#ZipCode").val() != "")
					{	
						return true;
					}
					else {
						return false;
					}
			  },
			  minlength: 5,	
			},
			Email: "required"
		},
		errorPlacement: function(error, element) {
		 if (element.attr("name") == "ZipCode" || element.attr("name") == "state" )
		   error.insertAfter("#state");
		 else
		   error.insertAfter(element);
	   },
		messages: {
			state: "<?php echo $this->scope["LANG_PLEASE_ENTER_ZIP_OR_STATE"];?>",
			ZipCode: "<?php echo $this->scope["LANG_ENTER_5DIGIT_ZIPCODE"];?>",
			Email: "<?php echo $this->scope["LANG_PLEASE_ENTER_VALID_EMAIL_ADDRESS"];?>"
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
</script>   <?php  /* end template body */
return $this->buffer . ob_get_clean();
?>