<?php
	require_once("include/general_includes.php");
	require_once(SERVER_ROOT."common/class/clsadminmenu.php");

	$objadminmenu = new adminmenu();
	
	
	$main_menu = 0;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title><?php print SITE_TITLE;?></title>
<link rel="stylesheet" type="text/css" href="<?php echo SERVER_ADMIN_HOST?>css/style.css" >
<script type="text/javascript" src="js/common.js"></script>
<script type="text/javascript" language="Javascript">

var arValidate = new Array;

arValidate[0] = new Array("R", "document.frm.txtuser_username", "Username");
arValidate[1] = new Array("R", "document.frm.txtpassword", "Password");

function validate(arCheck)
{
	/*if (!Isvalid(arCheck))
	{
		return false;
	}*/
	
	return true;	
}
function setaction(actiontype)
{	
	document.frm.action = "admin_menu_db.php";
	
	if (actiontype=="delete")
	{
		mycount = 0;
		
		for(i=0;i<document.frm.elements.length;i++)
		{
			if(document.frm.elements[i].name=="deletedids[]" && document.frm.elements[i].checked)
			{
				mycount++;	
			}
		}

		if(mycount==0)
		{
			alert("You must check at least one checkbox.");
			return false;
		}
	
		if(confirm("Are you sure you want to delete selected body style(s)?"))
		{
			document.frm.mode.value = "delete";
			document.frm.submit();
			return;
		}
		else
			return false;
	}
	else if (actiontype=="active")
	{
		document.frm.mode.value = "active";
		document.frm.submit();		
	}
	
}

</script>
</head>

<body>
<?php include SERVER_ADMIN_ROOT."include/top.php"; ?>
<div class="content_mn">
  <div class="content_mn2">
    <div class="cont_mid">
      <div class="cont_lt">
        <div class="cont_rt">
          <div class="user_tab_mn">
            <div class="blue_title">
              <div class="blue_title_lt">
                <div class="blue_title_rt">
                  <div class="fleft">Contest Admin Users</div>
                  <div class="fright"> <img src="<?php echo SERVER_ADMIN_ROOT?>images/add_new.png" alt="Add New Menu" title="Add New Menu" /> <a href="<?php echo SERVER_ADMIN_HOST?>admin_menu.php" title="Add New Menu">Add New Menu</a></div>
                </div>
              </div>
            </div>
            <div class="blue_title_cont">
              <?php if(isset($_POST["err"])){ 
        	 ($_POST["err"]!="") ? $msg->displayMsg() : "";
      } ?>
          <form id="frm" name="frm" method="post" action="admin_menu_db.php">
					  <fieldset>
							<?php print $objadminmenu->getAdminMenuTree(0, true);?>
				    </fieldset>
						<table width="100%">
          	<tbody><tr><td width="1%"> </td>
            <td width="99%">
            	<input type="hidden" id="mode" name="mode" />
            	<input type="submit" class="btn" value="Delete" name="btnsave" id="btnsave" onClick="javascript: setaction('delete');" />&nbsp;&nbsp;
              <input type="reset" class="btn" value="Cancel" name="btncanel" id="btncanel" />
            </td>
            </tr></tbody></table>          
          </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include SERVER_ADMIN_ROOT."include/footer.php";?>
</body>
</html>