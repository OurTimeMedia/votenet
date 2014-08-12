<?php
/* template head */
if (function_exists('Dwoo_Plugin_include')===false)
	$this->getLoader()->loadPlugin('include');
/* end template head */ ob_start(); /* template body */ ;
echo Dwoo_Plugin_include($this, 'header1.tpl', null, null, null, '_root', null);?>

<div id="contentPOPUP">
<div style="height=50px">&nbsp;</div>
    <div class="contentPOPUP">

        <div class="step-tablePOPUP">
	  <h1> Post Message To Facebook</h1>
	  <div class="step-tablePOPUP">
		<?php echo Dwoo_Plugin_include($this, 'facebookpostit_step4.php', null, null, null, '_root', null);?>

  </div>

</div>
</div>
</div>
</body></html><?php  /* end template body */
return $this->buffer . ob_get_clean();
?>