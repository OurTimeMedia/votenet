<?php
/* template head */
if (function_exists('Dwoo_Plugin_include')===false)
	$this->getLoader()->loadPlugin('include');
/* end template head */ ob_start(); /* template body */ ;
echo Dwoo_Plugin_include($this, 'header.tpl', null, null, null, '_root', null);?>

<div>
    <div class="content">
      <div class="step1-main">
        <div class="step1" id="pdfgeneration">
		<?php if ((isset($this->scope["mobile_device"]) ? $this->scope["mobile_device"] : null)) {
?>
          <h1 class='generate_h1'>Step 3: Print and Sign</h1>
		  <div class='step-table'>
		  <div style='width:100%; text-align:justify; padding-top:10px; padding-bottom:10px;'><strong>We have emailed a copy of your completed voter registration form to the email address you provided.  Please note that are not yet registered.  You need to download the form, print it and sign/date it.  Instructions are provided along with the form we sent you.</strong></div>		  
		  <div style='width:100%; text-align:justify; padding-top:10px; padding-bottom:10px;'><strong><?php echo $this->scope["LANG_ADOBE_REQUIRED_TEXT"];?></strong></div>
		  </div>
		<?php 
}
else {
?>
          <h1 class="generate_h1"><?php echo $this->scope["LANG_WAIT_FOR_GENERATING_VOTER_REGISTRATION_FORM"];?></h1>
          <div class="step-table">
           <div style="width:100%; text-align:center; height:100px;">
		   <img src="<?php echo $this->scope["image_dir"];?>please_wait.gif" border="0" style="padding-top:40px;">		   
		   </div>		   
          </div>
		<?php 
}?>  
        </div>
      </div>
    </div>
  </div>
  <?php echo Dwoo_Plugin_include($this, 'registrationform2_db.php', null, null, null, '_root', null);?>

<?php echo Dwoo_Plugin_include($this, 'footer.tpl', null, null, null, '_root', null);
 /* end template body */
return $this->buffer . ob_get_clean();
?>