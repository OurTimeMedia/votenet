<?php
	require_once("include/general_includes.php");
	
	$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);

	$user_id = 0;
		
	if (isset($_REQUEST['user_id']) && trim($_REQUEST['user_id'])!="")
		$user_id = $_REQUEST['user_id'];
		
	
	//CHECK FOR RECORED EXISTS
	$record_condition = "";	
	
	if (!($cmn->isRecordExists("user", "user_id", $user_id, $record_condition)))
		$msg->sendMsg("system_admin_list.php","",46);
		
	
	$objSystemAdmin = new user();
	$objAdminMenu = new adminmenu();

	include "system_admin_db.php";
	
	$cancel_button = "javascript: window.location.href='system_admin_detail.php?user_id=".$user_id."';";
	
	$objSystemAdmin->setAllValues($user_id);
?>
<script type="text/javascript" language="javascript">
function check_menu(filter_class, checked, id)
{
	// Check/Uncheck all sub items of current menu
	ele = document.getElementsByClassName(filter_class);
	for (i=0;i<ele.length;i++)
	{
		ele[i].checked = checked;
	}
	
	if (checked)	// If sub menu checked then all its parent must be checked
	{
		var class_name = new String(document.getElementById(id).className.replace("checkbox ",""));
		arr_ids = class_name.split(" ");
		for (i=0;i<arr_ids.length;i++)
		{
			arr_ids[i] = arr_ids[i].replace("class_","");
			if (document.getElementById("menu_"+arr_ids[i]))
				document.getElementById("menu_"+arr_ids[i]).checked = checked;
		}
	}
	else	// If all sub menu are  unchecked then its parent must be unchecked
	{
		var is_checked = 0;
		var class_name = new String(document.getElementById(id).className.replace("checkbox ",""));
		arr_ids = class_name.split(" ");
		arr_all_ids = document.getElementsByClassName(arr_ids[0]);
		for (i=0;i<arr_all_ids.length;i++)
		{
				if (arr_all_ids[i].checked)
					is_checked = 1;
		}
		if (is_checked == 0)
		{
			if (document.getElementById("menu_"+arr_ids[0].replace("class_","")))
				document.getElementById("menu_"+arr_ids[0].replace("class_","")).checked = false;
		}
	}
}
</script>
<?php include SERVER_ADMIN_ROOT."include/header.php"; ?>
<?php include SERVER_ADMIN_ROOT."include/top.php"; ?>
<div class="content_mn">
  <div class="content_mn2">
    <div class="cont_mid">
      <div class="cont_lt">
        <div class="cont_rt">
         <div class="user_tab_mn">
           <?php $msg->displayMsg(); ?> 
            <div class="blue_title">
              <div class="blue_title_lt">
                <div class="blue_title_rt">
                  <div class="fleft">System Admin Access Rights for [ <?php print $objSystemAdmin->user_firstname." ".$objSystemAdmin->user_lastname;?> ]</div>
                  <div class="fright"> <?php print $cmn->getAdminMenuLink("system_admin_detail.php","system_admin_detail","Back","?user_id=".$user_id,"back.png",false,'');?> </div>
                </div>
              </div>
            </div>
          
            <div class="blue_title_cont">
          	<form id="frm" name="frm" method="post">
			<div style="margin:0px;padding:0px;">
          	
          	<?php print $objAdminMenu->getAdminMenuTree(0,false,true,$user_id);?>
          	
	          	<div class="access_submit">
		          	<input type="submit" title="Save" class="btn" value="Save" name="btnsave_access" id="btnsave_access"/>&nbsp;&nbsp;
	                <input type="button" class="btn" title="Cancel" value="Cancel" name="btncanel" id="btncanel" onClick="<?php print $cancel_button; ?>"/>
	          	</div>
		            
            </div>
            
          </form>
        </div>
       
          </div>
        </div>
      </div>
    </div> 
  </div>
</div>
<?php include "include/footer.php";?>

