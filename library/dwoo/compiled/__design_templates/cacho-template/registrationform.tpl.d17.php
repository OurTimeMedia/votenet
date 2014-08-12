<?php
/* template head */
/* end template head */ ob_start(); /* template body */ ?><div class="content" style="width: 715px; margin: 5px 7px 0px 7px;">
<div style="float:left; padding:0px 20px 5px 20px;">
<p><span class="specialheadtext">Register to Vote</span>
<span>Make your voice heard! In order to cast your election ballot, you must register to vote. Throughout our nation's history, countless people have struggled long and hard to obtain the right to vote. Thanks to their sacrifices, today our nation's constitution guarantees American citizens of every color, race, gender and religion the right to vote and participate in the electoral process. Voting is one of the most effective ways you have to voice your concerns and aspirations regarding the actions taken by those in public office.</span></p>
<p><span class="specialheadtext">Inscríbete como votante</span>
<span>¡Haz oír tu voz! Para poder votar en las elecciones, primero debes inscribirte como votante. A lo largo de toda la historia de nuestra nación, un número enorme de personas tuvo que luchar por mucho tiempo para conquistar el derecho al voto. Gracias a los sacrificios de esas personas, la Constitución de esta nación garantiza a los ciudadanos de todo color, raza, género y religión el derecho al voto y a la participación en el proceso electoral. El voto es uno de los medios más efectivos con que cuentas para manifestar tus preocupaciones y aspiraciones con respecto a las decisiones y acciones de los que ocupan cargos públicos.</span></p>
</div>
	<div class="contentmain">
    <div class="step2-main">
      <div class="step2">
        <h1>Register to Vote</h1>
		<form id="formID" name="formID" method="post" action="">
        <div class="step2-table">

          <div class="from-main">
			<?php if ((isset($this->scope["language_preference_hide"]) ? $this->scope["language_preference_hide"] : null) == "0") {
?>
			<div class="from">
              <div class="homepageleftside"><span class="span">*</span> Language Preference</div>
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
              <div class="homepageleftside"><span class="span">*</span> Your Zip Code/State</div>
              <div class="homepagerightside"><input name="ZipCode" type="text" class="inputzipcode" id="ZipCode" value="<?php echo $this->scope["value_zipcode"];?>"  maxlength="5" />&nbsp;&nbsp;
              <span class="or">Or</span>&nbsp;&nbsp;
				<select id="state" size="1" name="state" class="inputstate required">
					<option selected="selected" value="">-- Select a State --</option>
					<?php echo $this->scope["statedata"];?>

				</select>
			</div>			              
            </div>			
            <div class="dashedline"></div>
            <div class="from">
              <div class="homepageleftside"><span class="span">*</span> Your Email Address</div>
              <div class="homepagerightside"><input name="Email" type="text" id="Email" class="from-input required email" value="<?php echo $this->scope["value_email"];?>" /></div>
            </div>            
            <div class="from">
			<div class="homepageleftside">&nbsp;</div>
			<div class="homepagerightside"><input type="image" name="btnContinue" src="<?php echo $this->scope["image_dir"];?>continue-btn.jpg" alt="Continue" width="122" height="33" /></div>
			</div>
          </div>
        </div>
		</form>
      </div>
    </div>
	<?php if ((isset($this->scope["Voting_Source"]) ? $this->scope["Voting_Source"] : null) == "Website") {
?>
    <div class="homepageextralinks">
      <div class="officelocation"> <a href="electioncenter.php?keepThis=true&TB_iframe=true&height=450&width=560"  class="thickbox">State Voter Registration Office Locations</a></div>      
	  <div class="keydates">
        <a href="election_dates.php?keepThis=true&TB_iframe=true&height=470&width=545"  class="thickbox">View Key Dates and Deadlines</a></div>      
    </div>
    </div>
	<div class="contentmain">
	<div class="facebook">Help Us Spread the Word:</div>
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
}?>

</div>
<div style="width: 245px; float:left">  
  <div class="grid-box width100 grid-v">
	<div class="module mod-color deepest">
		<h4 style="text-align: center;"><span style="color: #ffffff;">Connect with us on:</span></h4>
		<p style="text-align: center; margin:0;"><a target="_blank" href="http://www.facebook.com/MovimientoHispano"><img width="28" height="29" border="0" onmouseout="this.src='images/hispanicfederation/social/facebook.png';" onmouseover="this.src='images/hispanicfederation/social/facebookc.png';" title="facebook" style="vertical-align: middle;" alt="facebook" src="images/hispanicfederation/social/facebook.png"></a><a target="_blank" href="http://www.youtube.com/user/hispanicfederation1"><img width="57" height="29" border="0" onmouseout="this.src='images/hispanicfederation/social/youtube.png';" onmouseover="this.src='images/hispanicfederation/social/youtubec.png';" title="youtube" style="vertical-align: middle;" alt="youtube" src="images/hispanicfederation/social/youtube.png"></a><a target="_blank" href="http://www.flickr.com/photos/43433856@N08/"><img border="0" onmouseout="this.src='images/hispanicfederation/social/flickr.png';" onmouseover="this.src='images/hispanicfederation/social/flickrc.png';" title="flicker" style="vertical-align: middle;" alt="flicker" src="images/hispanicfederation/social/flickr.png"></a></p>
	</div>
  </div>
  <div class="grid-box width100 grid-v">
    <div class="module mod-box mod-box-header deepest">
      <h4><img width="205" height="166" alt="Stay Informed" src="../design_templates/cacho-template/images/sidebarS.jpg"><br>
        speak up or others will speak for you!</h4>
      <p style="text-align: left;">Sign up below to stay informed about elections and issues you care about.</p>
	  <p><a href="http://www.movimientohispano.org/index.php/en/call-to-action/stay-informed">Sign Up Now!</a></p>
    </div>
  </div>  
  <div class="grid-box width100 grid-v">
    <div class="module mod-box mod-box-header deepest">
      <h4><a target="_blank" href="http://www.vote411.org/pollfinder.php"><img width="205" height="124" title="US Map" alt="Where to Vote" src="../design_templates/cacho-template/images/sidebare.jpg"></a><br>
        Where Can You Vote?</h4>
      <p>Use the polling place locator to find the nearest polling place to your home or office.</p>
      <p><a target="_blank" href="http://www.vote411.org/pollfinder.php">Where to Vote</a></p>
    </div>
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
			state: "Please enter Zip Code or select State.",
			ZipCode: "Please enter a valid 5-digit Zip Code.",
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
</script>   <?php  /* end template body */
return $this->buffer . ob_get_clean();
?>