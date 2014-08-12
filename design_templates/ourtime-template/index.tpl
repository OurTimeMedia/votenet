{include(file='header.tpl')}
<div>
{$err_msg}
{include(file="registrationform.tpl")}
</div>
{if $issponsers == 1}
{include(file="slider.tpl")}
{/if}
{include(file='footer.tpl')}