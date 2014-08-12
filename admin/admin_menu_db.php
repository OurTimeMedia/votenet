<?php
require_once("include/general_includes.php");
require_once(SERVER_ROOT."common/class/clsadminmenu.php");

//$cmn->isAuthorized("index.php");
	
$cmn->checkPostMethod('admin_menu.php');

$objadminmenu =	new adminmenu();

if (isset($_POST["txtadmin_menu_name"]))
{
	$objadminmenu->admin_menu_id = $_POST['admin_menu_id'];
	$objadminmenu->admin_menu_parent_id = $_POST['cboadmin_menu_parent_id'];
	$objadminmenu->admin_menu_name = $cmn->setVal(trim($_POST["txtadmin_menu_name"]));
	$objadminmenu->admin_menu_module = $cmn->setVal(trim($_POST["txtadmin_menu_module"]));
	$objadminmenu->admin_menu_page_name = $cmn->setVal(trim($_POST["txtadmin_menu_page_name"]));	
	$objadminmenu->admin_menu_icon = $cmn->setVal(trim($_POST["txtadmin_menu_icon"]));	
	$objadminmenu->admin_menu_order = $cmn->setVal(trim($_POST["txtadmin_menu_order"]));
	$objadminmenu->admin_menu_isactive = $cmn->setVal(trim($_POST["optadmin_menu_isactive"]));
	$objadminmenu->admin_menu_isvisible = $cmn->setVal(trim($_POST["optadmin_menu_isvisible"]));
}

if (trim($_POST['mode']) == 'edit' && !empty($_POST['admin_menu_id']))
{
	
	if($cmn->isDuplicate("admin_menu","admin_menu_name",$objadminmenu->admin_menu_name,"admin_menu_id",$objadminmenu->admin_menu_id,"admin_menu_parent_id = '". $objadminmenu->admin_menu_parent_id ."'"))
	{
		$strhidden	=	$cmn->getPostedValuesAsHidden();
		$msg->sendMsg("admin_menu.php","Menu",7,"",$strhidden);
		exit();
	}
	else
	{
		$objadminmenu->update();
		$msg->sendMsg("admin_menu_list.php","Menu ",4);
		exit();
	}
}
elseif (trim($_POST['mode']) == 'delete')
{ 
	if (count($_POST['deletedids']) == 0)
	{
		$msg->sendMsg("admin_menu_list.php","Menu ",9);
	}
	else 
	{
		for ($i=0; $i<count($_POST['deletedids']); $i++)
		{
			$objadminmenu->admin_menu_id =	$_POST['deletedids'][$i];
			$objadminmenu->delete();
		}
		
		$msg->sendMsg("admin_menu_list.php","Menu ",5);
	}
	exit();
}
elseif (trim($_POST['mode']) == 'active')
{ 
	if (isset($_POST['activeids']))
		$arrayactiveids = $_POST['activeids'];
	else
		$arrayactiveids = array("0");
		
	$objadminmenu->checkedids = implode(",",$arrayactiveids);
	$objadminmenu->uncheckedids = $_POST['inactiveids'];
	$objadminmenu->activeInactive();
	$msg->sendMsg("admin_menu_list.php","Menu ",15);
	exit();
}
else 
{
//	if($cmn->isDuplicate("menu","admin_menu_page_name",$objadminmenu->admin_menu_page_name,"","","admin_menu_parent_id = '". $objadminmenu->admin_menu_parent_id ."'"))
//	{
//		$strhidden	=	$cmn->getPostedValuesAsHidden();
//		$msg->sendMsg("admin_menu.php","Menu",7,"",$strhidden);
//		exit();
//	}
//	else
//	{
		$objadminmenu->add();
		$msg->sendMsg("admin_menu_list.php","Menu",3);
		exit();
//	}
}

?>
