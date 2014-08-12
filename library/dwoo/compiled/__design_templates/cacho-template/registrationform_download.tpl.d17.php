<?php
/* template head */
if (function_exists('Dwoo_Plugin_include')===false)
	$this->getLoader()->loadPlugin('include');
/* end template head */ ob_start(); /* template body */ ;
echo Dwoo_Plugin_include($this, 'header.tpl', null, null, null, '_root', null);?>

<div id="content">
    <div class="content">
      <div class="step1-main">
        <div class="step1" id="pdfgeneration">
          <h1 class='generate_h1'>Generating your Registration Form.  This may take a few seconds.</h1>
          <div class="step-table">
           <div style="width:100%; text-align:center; height:100px;">
		   <img src="<?php echo $this->scope["image_dir"];?>please_wait.gif" border="0" style="padding-top:40px;">		   
		   </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <?php echo Dwoo_Plugin_include($this, 'registrationform2_db.php', null, null, null, '_root', null);?>

<?php echo Dwoo_Plugin_include($this, 'footer.tpl', null, null, null, '_root', null);
 /* end template body */
return $this->buffer . ob_get_clean();
?>