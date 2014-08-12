<?php
	$title			= $cmn->getval(trim($cmn->read_value($_POST['title'],'')));
	$first_name		= $cmn->getval(trim($cmn->read_value($_POST['first_name'],'')));
	$last_name		= $cmn->getval(trim($cmn->read_value($_POST['last_name'],'')));
	$organization	= $cmn->getval(trim($cmn->read_value($_POST['organization'],'')));
	$email			= $cmn->getval(trim($cmn->read_value($_POST['email'],'')));
	$phone			= $cmn->getval(trim($cmn->read_value($_POST['phone'],'')));
	
	require_once 'request-info-db.php';
?>
<div id="header-sub">
	<h1>Request Information</h1>
	<p class="register">Register and Mobilize Voters.Online.</p>
</div>
<script type="text/javascript" src="<?php echo SITE_URL; ?>js/jquery.validate.js"></script> 
<script type="text/javascript">
	$('document').ready(function(){
		$('#form').validate();
	});
</script> 
<div id="middle-sub">
	<?php $msg->display_msg(); ?>
	<form name="form" id="form" action="" method="post">
		<ul id="ngothastyle3">
        	<li>
				<label class="form-label">&nbsp;</label>
				<div class="error"><?php echo REQUIRED_SENTENCE; ?></div>
			</li>
			<li>
				<label class="form-label">&nbsp;&nbsp;Title</label>
				<input type="text" name="title" class="" />
			</li>
			<li>
				<label class="form-label"><span>*</span>First Name</label>
				<input type="text" name="first_name" class="required" />
			</li>
			<li>
				<label class="form-label"><span>*</span>Last Name</label>
				<input type="text" name="last_name" class="required" />
			</li>
			<li>
				<label class="form-label"><span>*</span>Organization</label>
				<input type="text" name="organization" class="required" />
			</li>
			<li>
				<label class="form-label"><span>*</span>Email</label>
				<input type="text" name="email" class="required email" />
			</li>
			<li>
				<label class="form-label">&nbsp;&nbsp;Phone</label>
				<input type="text" name="phone" class="" />
			</li>
			<li>
				<label class="form-label">&nbsp;</label>
				<input type="submit" name="Submit" value="Submit" class="btn-block" /> <input type="reset" name="Submit2" value="Reset"  class="btn-block"  />
			</li>
		</ul>
	</form>
</div>