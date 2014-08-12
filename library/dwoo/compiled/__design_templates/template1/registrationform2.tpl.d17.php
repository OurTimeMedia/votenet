<?php
/* template head */
if (function_exists('Dwoo_Plugin_include')===false)
	$this->getLoader()->loadPlugin('include');
/* end template head */ ob_start(); /* template body */ ;
echo Dwoo_Plugin_include($this, 'header.tpl', null, null, null, '_root', null);?>

<?php if ((isset($this->scope["hide_steps"]) ? $this->scope["hide_steps"] : null) == "0") {
?>
<?php if ((isset($this->scope["Voting_Source"]) ? $this->scope["Voting_Source"] : null) == "Website") {
?>
<div class="step">
  <ul>
	<li id="step1">Register</li>
	<li class="step-act"  id="step2">Review</li>
	<li id="step3">Share</li>	
  </ul>
</div>
<?php 
}?>

<?php 
}?>

<div>
    <div class="content">
      <div class="step1-main">
        <div class="step1">
          <h1><?php echo $this->scope["reg_step"];?> 2: <?php echo $this->scope["reg_review_and_download"];?></h1>
          <div class="step-table">
            <?php echo Dwoo_Plugin_include($this, 'registration_step2.php', null, null, null, '_root', null);?>

          </div>
        </div>
      </div>
    </div>
  </div>
<?php if ((isset($this->scope["issponsers"]) ? $this->scope["issponsers"] : null) == 1) {
?>
<?php echo Dwoo_Plugin_include($this, "slider.tpl", null, null, null, '_root', null);?>

<?php 
}?> 
<?php echo Dwoo_Plugin_include($this, 'footer.tpl', null, null, null, '_root', null);?>  <?php  /* end template body */
return $this->buffer . ob_get_clean();
?>