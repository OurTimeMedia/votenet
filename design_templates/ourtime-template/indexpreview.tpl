{include(file='header.tpl')}
<div id="content">
{$err_msg}
{include(file="registrationformpreview.tpl")}
</div>
{if $issponsers == 1}
{include(file="slider.tpl")}
{/if}
{include(file='footer.tpl')}