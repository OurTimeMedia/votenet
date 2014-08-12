<?php
/* template head */
if (function_exists('Dwoo_Plugin_include')===false)
	$this->getLoader()->loadPlugin('include');
/* end template head */ ob_start(); /* template body */ ;
echo Dwoo_Plugin_include($this, 'header_home.tpl', null, null, null, '_root', null);?>

<?php echo $this->scope["err_msg"];?>

<?php echo Dwoo_Plugin_include($this, "registrationform.tpl", null, null, null, '_root', null);?>

<?php if ((isset($this->scope["issponsers"]) ? $this->scope["issponsers"] : null) == 1) {
?>
<?php echo Dwoo_Plugin_include($this, "slider.tpl", null, null, null, '_root', null);?>

<?php 
}?>

<?php echo Dwoo_Plugin_include($this, 'footer.tpl', null, null, null, '_root', null);
 /* end template body */
return $this->buffer . ob_get_clean();
?>