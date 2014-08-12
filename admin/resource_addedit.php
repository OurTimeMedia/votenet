<?php
	require_once("include/general_includes.php");
	
	$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);

	
	$resource_id = 0;
		
	if (isset($_REQUEST['hdnresource_id']) && trim($_REQUEST['hdnresource_id'])!="")
		$resource_id = $_REQUEST['hdnresource_id'];
		
	//set mode...
	$mode = ADD;
	if ($resource_id > 0)
		$mode = EDIT;
		
	//CHECK FOR RECORED EXISTS
	$record_condition = "";	
	
	if ($mode==EDIT && !($cmn->isRecordExists("resource", "resource_id", $resource_id, $record_condition)))
		$msg->sendMsg("resource_list.php","",46);
		  
	//END CHECK

	$objResource = new resource();

	include SERVER_ADMIN_ROOT."resource_db.php";
	
	$cancel_button = "javascript: window.location.href='resource_list.php';";
	
	//code to assign property to object...
	if(!empty($_SESSION["err"]))
	{
			$objResource->resource_id = $cmn->setVal(trim($cmn->readValue($_POST["hdnresource_id"],"")));
			$objResource->resource_name = $cmn->setVal(trim($cmn->readValue($_POST["txtresource_name"],"")));
			$objResource->resource_text = $cmn->setVal(trim($cmn->readValue($_POST["txtresource_text"],"")));
			$objResource->resource_page = $cmn->setVal(trim($cmn->readValue($_POST["txtresource_page"],"")));
			$objResource->resource_isactive = $cmn->setVal(trim($cmn->readValue($_POST["rdoresource_isactive"],"")));

		// Set red border for error fields
		$err_fields = split("\|", $_SESSION["err_fields"]);
		unset($_SESSION["err_fields"]);
		for ($i=0;$i<count($err_fields);$i++)
		{
			$err_fields[$i] = "class_".$err_fields[$i];
			$$err_fields[$i] = "input-red-border";
		}
	}
	else if ($mode == EDIT)
	{
		$objResource->setAllValues($resource_id);
		$cancel_button = "javascript: window.location.href='resource_list.php?resource_id=".$resource_id."';";
	}

	$extraJs = array("resource.js");
	include SERVER_ADMIN_ROOT."include/header.php";
	include SERVER_ADMIN_ROOT."include/top.php";
?>

<div class="content_mn">
    <div class="cont_mid">
        <div class="cont_rt">
          <div class="user_tab_mn">
          <?php $msg->displayMsg(); ?>
            <div class="blue_title">
               <div class="blue_title_rt">
                  <div class="fleft"><?php if ($mode==EDIT) { print "Edit Resource"; } else { print "Create Resource"; } ?></div>
                  <div class="fright"> 
                   <?php 
                   		if ($mode==EDIT) 
                   		{
                   			print $cmn->getAdminMenuLink("resource_detail.php","resource_detail","Back","?resource_id=".$resource_id,"back.png",false); 
                   		
                   		}
                   		else 
                   		{
                   			print $cmn->getAdminMenuLink("resource_list.php","resource_list","Back","","back.png",false); 
                   		}
                   ?>
                  
                   </div>
              </div>
            </div>
            <div class="blue_title_cont">
             <form name="frm" id="frm" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" onsubmit="javascript: return validate();">
	<table class="listtab" cellpadding="0" cellspacing="0" border="0" width="100%" style="clear:both;">

		<tr>
			<td align="left" valign="top" width="15%">
				Resource name:&nbsp;<?php print COMPULSORY_FIELD; ?>
			</td>

			<td align="left" valign="top">
				<input type="text" name="txtresource_name" id="txtresource_name" value="<?php echo htmlspecialchars($objResource->resource_name); ?>" maxlength="200" />
			</td>

		</tr>

		<tr>
			<td align="left" valign="top">
				Resource text:&nbsp;<?php print COMPULSORY_FIELD; ?>
			</td>

			<td align="left" valign="top">
				<input type="text" name="txtresource_text" id="txtresource_text" value="<?php echo htmlspecialchars($objResource->resource_text); ?>" maxlength="1000" />
			</td>

		</tr>

		<tr>
			<td align="left" valign="top">
				Resource page:
			</td>

			<td align="left" valign="top">
				<input type="text" name="txtresource_page" id="txtresource_page" value="<?php echo htmlspecialchars($objResource->resource_page); ?>" maxlength="50" />
			</td>

		</tr>

		<tr>
			<td align="left" valign="top">
				Resource isactive:
			</td>

			<td align="left" valign="top">
				<label><input  type="radio" name="rdoresource_isactive" id="rdoresource_isactive" class="radio" value="1" <?php ($objResource->resource_isactive==1) ? print 'checked="checked"' : '' ?> />Yes</label>
				<label><input  type="radio" name="rdoresource_isactive" id="rdoresource_isactive" class="radio" value="0" <?php ($objResource->resource_isactive==0) ? print 'checked="checked"' : '' ?> />No</label>
				
			</td>

		</tr>

		<tr>
			<td align="left" valign="top" >&nbsp;
			</td>
			<td align="left" valign="top" >

				<input  type="submit" class="btn" name="btnsave" id="btnsave" value="Save"/>
				<input  type="button" name="btncanel" id="btncanel" onclick="<?php echo $cancel_button ?>" value="Cancel" class="btn" />
				<input type="hidden" name="hdnmode" id="hdnmode" value="<?php echo $mode; ?>"/>
				<input type="hidden" name="hdnresource_id" id="hdnresource_id" value="<?php echo $objResource->resource_id; ?>"/>
				
			</td>

		</tr>

	</table>
</form>
            </div>
          </div>
        </div>
     
    </div>
 
</div>
<?php include SERVER_ADMIN_ROOT."include/footer.php"; ?>
<script type="text/javascript" language="javascript">
document.getElementById('txtresource_title').focus();
</script>