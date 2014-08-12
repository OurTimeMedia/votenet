<?php
/* template head */
/* end template head */ ob_start(); /* template body */ ?></div>
<?php if ((isset($this->scope["Voting_Source"]) ? $this->scope["Voting_Source"] : null) == "Website") {
?>
        <div id="footer">
        	<div id="footer-left"><a href="http://www.electionimpact.com" target="_blank"><img src="<?php echo $this->scope["image_dir"];?>powered-by-logo.jpg" alt="Election Impact" width="206" height="47" /></a></div>
            <div id="footer-right">&copy; 2011-2012 Votenet&trade; Solutions<br />
            <!-- <a href="#" class="txtbluebo">Privacy Policy</a>|<a href="#" class="txtbluebo">Terms &amp; Conditions</a>--></div> 
        </div>
<?php 
}?>

	<div class="clear"></div>
</div>
</body>
</html><?php  /* end template body */
return $this->buffer . ob_get_clean();
?>