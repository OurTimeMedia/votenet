<?php
/* template head */
/* end template head */ ob_start(); /* template body */ ?><div id="slider">
	<div class="silder-main">
	<h2>Sponsors:</h2>
	<div class="silder" >            
       		
				<ul id="mycarousel" class="jcarousel-skin-tango">
				<?php 
$_loop0_data = (isset($this->scope["sponsers"]) ? $this->scope["sponsers"] : null);
if ($this->isArray($_loop0_data) === true)
{
	foreach ($_loop0_data as $tmp_key => $this->scope["-loop-"])
	{
		$_loop0_scope = $this->setScope(array("-loop-"));
/* -- loop start output */
?>
				<?php if ((isset($this->scope["islast"]) ? $this->scope["islast"] : null) != 1) {
?>
				<li class="silder-logo"><a href="<?php echo $this->scope["sponser_link"];?>" title="<?php echo $this->scope["sponser_name"];?>" target="_blank" alt="<?php echo $this->scope["sponser_name"];?>"><table cellpadding="0" cellspacing="0" border="0"><tr><td align="center" valign="middle" height="79" width="119"><?php echo $this->scope["sponser_image"];?></td></tr></table></a></li>
				<?php 
}
else {
?>
				<li class="silder-logo" style="margin-right:0px !important;"><a href="<?php echo $this->scope["sponser_link"];?>" title="<?php echo $this->scope["sponser_name"];?>" target="_blank" alt="<?php echo $this->scope["sponser_name"];?>"><table cellpadding="0" cellspacing="0" border="0"><tr><td align="center" valign="middle" height="79" width="119"><?php echo $this->scope["sponser_image"];?></td></tr></table></a></li>
				<?php 
}?>				
				<?php 
/* -- loop end output */
		$this->setScope($_loop0_scope, true);
	}
}
?>

				</ul>					

	</div>
	</div>
</div>
<script type="text/javascript">
jQuery(document).ready(function() {
    jQuery('#mycarousel').jcarousel();
});
</script><?php  /* end template body */
return $this->buffer . ob_get_clean();
?>