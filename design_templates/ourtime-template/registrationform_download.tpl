{include(file='header.tpl')}
<div>
    <div class="content">
      <div class="step1-main">
        <div class="step1" id="pdfgeneration">
		{if $mobile_device}
          <h1 class='generate_h1'>Step 3: Print and Sign</h1>
		  <div class='step-table'>
		  <div style='width:100%; text-align:justify; padding-top:10px; padding-bottom:10px;'><strong>We have emailed a copy of your completed voter registration form to the email address you provided.  Please note that are not yet registered.  You need to download the form, print it and sign/date it.  Instructions are provided along with the form we sent you.</strong></div>		  
		  <div style='width:100%; text-align:justify; padding-top:10px; padding-bottom:10px;'><strong>{$LANG_ADOBE_REQUIRED_TEXT}</strong></div>
		  </div>
		{else}
          <h1 class="generate_h1">{$LANG_WAIT_FOR_GENERATING_VOTER_REGISTRATION_FORM}</h1>
          <div class="step-table">
           <div style="width:100%; text-align:center; height:100px;">
		   <img src="{$image_dir}please_wait.gif" border="0" style="padding-top:40px;">		   
		   </div>		   
          </div>
		{/if}  
        </div>
      </div>
    </div>
  </div>
  {include(file='registrationform2_db.php')}
{include(file='footer.tpl')}