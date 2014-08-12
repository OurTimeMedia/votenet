<?php
/* template head */
if (function_exists('Dwoo_Plugin_include')===false)
	$this->getLoader()->loadPlugin('include');
/* end template head */ ob_start(); /* template body */ ;
echo Dwoo_Plugin_include($this, 'header.tpl', null, null, null, '_root', null);?>

<style>
#blanket {
background-color:#111;
opacity: 0.65;
filter:alpha(opacity=65);
position:absolute;
z-index: 9001;
top:0px;
left:0px;
width:100%;
}
#popUpDiv {
position:absolute;
background-color:#eeeeee;
width:300px;
height:300px;
z-index: 9002;
top: 145px !important;
}
</style>
<script type="text/javascript" src="js/csspopup.js"></script>
<?php if ((isset($this->scope["hide_steps"]) ? $this->scope["hide_steps"] : null) == "0") {
?>
<div class="step">
  <ul>	
	<li  id="step1">Register</li>
	<li  id="step2">Review</li>
	<li class="step-act" id="step3">Share</li>	
  </ul>
</div>
<?php 
}?>

<div id="content">
    <div class="content">
      <div class="step1-main">
        <div class="step1">
          <h1>Step 3: Spread the Word via Social Media</h1>
          <div class="step-table">
            <?php echo Dwoo_Plugin_include($this, 'registration_step3.php', null, null, null, '_root', null);?>

          </div>
        </div>
		<div class="step1">
          <h1>Add to Your Calendar</h1>
          <div class="step-table">
            <?php echo Dwoo_Plugin_include($this, 'registration_step4.php', null, null, null, '_root', null);?>

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
<?php echo Dwoo_Plugin_include($this, 'footer.tpl', null, null, null, '_root', null);?>  

<?php  /* end template body */
return $this->buffer . ob_get_clean();
?>