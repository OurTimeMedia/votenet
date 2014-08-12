<?php
/* template head */
if (function_exists('Dwoo_Plugin_include')===false)
	$this->getLoader()->loadPlugin('include');
/* end template head */ ob_start(); /* template body */ ;
echo Dwoo_Plugin_include($this, 'header1.tpl', null, null, null, '_root', null);?>

<div id="contentPOPUP1" style="margin:2px;">    
      <div class="step-tablePOPUP1">
	  <h1><?php echo $this->scope["LANG_STATE_VOTER_REGISTRATION_OFFICE_LOCATION_TEXT"];?></h1>
	  <div class="step-table" style="width:538px;">
		<?php echo Dwoo_Plugin_include($this, 'electioncenter_popup.php', null, null, null, '_root', null);?>

	  </div>	
</div>
</div>
</body></html><?php  /* end template body */
return $this->buffer . ob_get_clean();
?>