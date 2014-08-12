<?php
/* template head */
if (function_exists('Dwoo_Plugin_include')===false)
	$this->getLoader()->loadPlugin('include');
/* end template head */ ob_start(); /* template body */ ;
echo Dwoo_Plugin_include($this, 'header.tpl', null, null, null, '_root', null);?>

<?php if ((isset($this->scope["Voting_Source"]) ? $this->scope["Voting_Source"] : null) == "Website") {
?>
<div class="step">
  &nbsp;
</div>
<?php 
}?>

<div id="content">
    <div class="content" style="margin: 0px;">
      <div class="step1-main">
        <div class="step1">          
		  <?php if ((isset($this->scope["Voting_State_id"]) ? $this->scope["Voting_State_id"] : null) == 51) {
?>	
          <div class="step-table" style="padding-top: 12px; padding-bottom: 12px;">
            The state of Wyoming does not accept the National Voter Registration form. For more information on voter registration and a link to a Wyoming voter registration form, please click on the following link: <a href="http://soswy.state.wy.us/Elections/RegisteringToVote.aspx" target="_blank">http://soswy.state.wy.us/Elections/RegisteringToVote.aspx</a>
          </div>
		  <?php 
}?>

		  <?php if ((isset($this->scope["Voting_State_id"]) ? $this->scope["Voting_State_id"] : null) == 37) {
?>	
          <div class="step-table" style="padding-top: 12px; padding-bottom: 12px;">
		  <strong>Apply to your town or city clerk's office.  You will be required to fill out a standard voter registration form and will be required to show proof of age, citizenship and domicile.   
		  <br>Please visit <a href="http://sos.nh.gov/RegVote.aspx" target="_blank">http://sos.nh.gov/RegVote.aspx</a> for further information.</strong>
          </div>
		  <?php 
}?>

        </div>
      </div>
    </div>
  </div>
  <div class="step">
  &nbsp;
</div>
<?php if ((isset($this->scope["issponsers"]) ? $this->scope["issponsers"] : null) == 1) {
?>
<?php echo Dwoo_Plugin_include($this, "slider.tpl", null, null, null, '_root', null);?>

<?php 
}?> 
<?php echo Dwoo_Plugin_include($this, 'footer.tpl', null, null, null, '_root', null);?>  <?php  /* end template body */
return $this->buffer . ob_get_clean();
?>