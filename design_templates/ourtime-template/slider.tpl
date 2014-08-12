<div id="slider">
	<div class="silder-main">
	<h2>Sponsors:</h2>
	<div class="silder" >            
       		
				<ul id="mycarousel" class="jcarousel-skin-tango">
				{loop $sponsers}
				{if $islast neq 1}
				<li class="silder-logo"><a href="{$sponser_link}" title="{$sponser_name}" target="_blank" alt="{$sponser_name}"><table cellpadding="0" cellspacing="0" border="0"><tr><td align="center" valign="middle" height="79" width="119">{$sponser_image}</td></tr></table></a></li>
				{else}
				<li class="silder-logo" style="margin-right:0px !important;"><a href="{$sponser_link}" title="{$sponser_name}" target="_blank" alt="{$sponser_name}"><table cellpadding="0" cellspacing="0" border="0"><tr><td align="center" valign="middle" height="79" width="119">{$sponser_image}</td></tr></table></a></li>
				{/if}				
				{/loop}
				</ul>					

	</div>
	</div>
</div>
<script type="text/javascript">
jQuery(document).ready(function() {
    jQuery('#mycarousel').jcarousel();
});
</script>