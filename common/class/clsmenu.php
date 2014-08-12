<?php
class menu extends common 
{
	var $tmenu;
	var $smenu;

	var $menu_id;
	var $menu_parent_id;
	var $menu_name;
	var $menu_module;
	var $menu_icon;
	var $menu_isactive;
	var $menu_isvisible;
	var $menu_order;
	var $menu_page_name;
	var $pagingType;

	var $checkedids;
	var $uncheckedids;
	
	function fetchRecordSet($id="",$cond="",$ord="m.menu_name")
	{
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
			$cond = " and m.menu_id=". $id .$cond;
		}
		if($ord!="" && $ord!= NULL && is_null($ord)==false)
		{
			$ord = " order by " . $ord;
		}
		$qry="select m.*, (select n.menu_name from  " . DB_PREFIX . "menu n where m.menu_parent_id=n.menu_id) as menuparentname from " . DB_PREFIX . "menu m where 1=1 " . $cond . $ord;
		$rs=mysql_query($qry);
		
		return $rs;
	}
	
	function fetchAllAsArray($intid=NULL, $stralphabet=NULL)
	{
		$arrlist = array();
		$i = 0;
		$and = "";
		if(!is_null($intid))$and .= " AND m.menu_id = " . $intid;
		if(!is_null($stralphabet))	$and .= " AND m.menu_name like '" . $stralphabet . "%'";
		
		$qry = "SELECT m.* from " . DB_PREFIX . "menu m WHERE 1=1 " . $and . " ORDER BY m.menu_name";
		$rs=mysql_query($qry);

		while($rw= mysql_fetch_array($rs))
		{
			$arrlist[$i]["menu_id"] 		= $rw["menu_id"];
			$arrlist[$i]["menu_parent_id"] = $rw["menu_parent_id"];
			$arrlist[$i]["menu_name"] 	= $rw["menu_name"];
			$arrlist[$i]["menu_module"] 	= $rw["menu_module"];
			$arrlist[$i]["menu_icon"] 	= $rw["menu_icon"];
			$arrlist[$i]["menu_isactive"] = $rw["menu_isactive"];		
			$arrlist[$i]["menu_order"] 	 = $rw["menu_order"];
			$arrlist[$i]["menu_page_name"] = $rw["menu_page_name"];
			$arrlist[$i]["menu_isvisible"] = $rw["menu_isvisible"];
			
			$i++;
		}
		return $arrlist;
	}
	
	function setAllValues($id="",$cond="")
	{
		$rs=$this->fetchRecordSet($id, $cond);

		if($rw= mysql_fetch_array($rs))
		{
			$this->menu_id = $rw["menu_id"];
			$this->menu_parent_id  = $rw["menu_parent_id"];
			$this->menu_name 	= $rw["menu_name"];
			$this->menu_module 	= $rw["menu_module"];
			$this->menu_icon 	= $rw["menu_icon"];
			$this->menu_isactive = $rw["menu_isactive"];
			$this->menu_order 	= $rw["menu_order"];
			$this->menu_page_name = $rw["menu_page_name"];
			$this->menu_isvisible = $rw["menu_isvisible"];
			
		}
	}
	
	function fieldValue($fld="menu_name",$id="",$cond="",$ord="")
	{
		$rs=$this->fetchRecordSet($id, $cond, $ord);
		$ret=0;

		while($rw=mysql_fetch_assoc($rs))
		{
			$ret=$rw[$fld];
		}
		return $ret;
	}

	function add()
	{
		$qry	=	"insert into ". DB_PREFIX . "menu (menu_parent_id, menu_name, menu_module, menu_isactive,  menu_order, menu_page_name, menu_icon, menu_isvisible)";
		$qry 	.=	" values ( '". $this->menu_parent_id ."','". $this->menu_name ."', '". $this->menu_module ."', '". $this->menu_isactive ."', '".$this->menu_order ."','". $this->menu_page_name ."','".$this->menu_icon."','".$this->menu_isvisible."')";

		mysql_query($qry) or die(mysql_error());
		$this->id = mysql_insert_id();
		return $this->id;
	}
	
	function update()
	{
		$qry	=	"update ". DB_PREFIX . "menu set menu_parent_id='". $this->menu_parent_id ."',menu_name='". $this->menu_name ."' , menu_module ='". $this->menu_module ."', menu_isactive='".$this->menu_isactive."', menu_order='". $this->menu_order ."', menu_page_name='". $this->menu_page_name ."', menu_icon='".$this->menu_icon."', menu_isvisible='".$this->menu_isvisible."' where menu_id=" . $this->menu_id;
		
		
		return mysql_query($qry) or die(mysql_error());
	}
	
	function delete()
	{
		$qry	=	"delete from " . DB_PREFIX . "menu where menu_id=" . $this->menu_id;
		return mysql_query($qry) or die(mysql_error());
	}
	function activeInactive()
	{
		$qry	=	"update " . DB_PREFIX . "menu set menu_isactive=0 where menu_id in(" . $this->uncheckedids . ")";
		$result = mysql_query($qry) or die(mysql_error());
		if ($result == false)
			return $result;

		$qry	=	"update " . DB_PREFIX . "menu set menu_isactive=1 where menu_id in(" . $this->checkedids . ")";
		 
		return mysql_query($qry) or die(mysql_error());
	}

	function getMenu($user_id, $currentmodule, $setScroll=1)
	{
		$mnucmn = new common();
		$activemenu_ids = array();
		$activemenu_id = "";
		$tempmenuid = "";
		
		// Get Active Menus
//		$qry = "select * from " . DB_PREFIX . "menu where menu_isactive=1 and menu_module ='".$currentmodule."'";

		$qry = "select * from " . DB_PREFIX . "menu where menu_isactive=1 and menu_module like '".$currentmodule."%'";		
	
		$rsc = mysql_query($qry);
		if (mysql_num_rows($rsc)>0)
		{	
			while ($rwc = mysql_fetch_array($rsc))
			{
			
				$activemenu_ids[] = $rwc["menu_id"];
			
				$tempmenuid = $rwc["menu_parent_id"];
				if ($tempmenuid!=0)
				{
					while ($tempmenuid != 0)
					{
						$activemenu_ids[] = $tempmenuid;
						$qry = "select * from " . DB_PREFIX . "menu where menu_id='".$tempmenuid."'";
						
						$rsc1 = mysql_query($qry);
						if (mysql_num_rows($rsc1)>0)
						{
							$rwc1 = mysql_fetch_array($rsc1);
							$tempmenuid = $rwc1["menu_parent_id"];
							mysql_free_result($rsc1);
						}
					}
				}
				else
					$activemenu_ids[] = $rwc["menu_id"];
			}
		}
		
		// Get Top Level Menus
	
		if ($user_id==1 || $this->getSession(ADMIN_USER_TYPE_ID)==3)	// Allow all menu to Super Admin
			$qry = "select m.* from " . DB_PREFIX . "menu m where m.menu_isactive=1 and m.menu_isvisible=1 and m.menu_parent_id=0 order by menu_order desc";
		else
			$qry = "select m.* from " . DB_PREFIX . "menu m, " . DB_PREFIX . "user_menu um where m.menu_isactive=1 and m.menu_isvisible=1 and m.menu_parent_id=0 and m.menu_id=um.menu_id and um.user_id=".$user_id." order by menu_order desc";

		$rs = mysql_query($qry);
		$strmenu = "";
		if (mysql_num_rows($rs)>0)
		{
			$menu_count = mysql_num_rows($rs);
			$menu_index = 1;

			while($rw = mysql_fetch_array($rs))
			{
				$last_menu = "";
				if ($menu_index == $menu_count)
						$last_menu = "style=\"padding-right:14px;\"";

				if (trim($rw["menu_icon"])!="")
					$menu_icon = "<img src='".MENU_ICONS.$rw["menu_icon"]."' alt='".$rw["menu_name"]."' /> ";
				else
					$menu_icon = "";
					
				$menu_link = $this->getFirstSubmenu($rw["menu_id"], $user_id);
				
				if (trim($menu_link)=="")	// If there is no sub menu for top level menu then use its own link
					$menu_link = $rw["menu_page_name"];
				
				if (in_array($rw["menu_id"], $activemenu_ids))
				{
					$activemenu_id = $rw["menu_id"];					
					$strmenu .= "<li><a href='".$menu_link."' title='".$rw["menu_name"]."' class='active' ><b>&nbsp;</b><em>".$rw["menu_name"] ."</em></a></li>\r\n";
				}
				else
					$strmenu .= "<li><a href='".$menu_link."' title='".$rw["menu_name"]."'><b>&nbsp;</b><em>".$rw["menu_name"] ."</em></a></li>\r\n";
			
				$menu_index++;
			}
		}
		$strmenu .= "";
		
		$output = "<div class=\"menu_mn\">
  					<div class=\"menu_rt\">
				    	<div class=\"menu-left\">
				    	<div class=\"main-menu\">
							<ul class=\"tabs\">
								".$strmenu."
							</ul>";

		// Get Sub Menus		
		$output .="<div class=\"toplinks\">";
		if($setScroll==1)
		{
			$output .="<ul id=\"mycarousel\" class=\"jcarousel-skin-tango\">";
		}
		$found = true;
		$strmenu = "";
		if ($activemenu_id!="")
		{
			while ($found)
			{
				if ($user_id==1 || $this->getSession(ADMIN_USER_TYPE_ID)==3)	// Allow all menu to Super Admin
					$qry = "select m.* from " . DB_PREFIX . "menu m where m.menu_isactive=1 and m.menu_isvisible=1 and m.menu_parent_id=".$activemenu_id." order by menu_order";
				else
					$qry = "select m.* from " . DB_PREFIX . "menu m, " . DB_PREFIX . "user_menu um where m.menu_isactive=1 and m.menu_isvisible=1 and m.menu_parent_id=".$activemenu_id." and m.menu_id=um.menu_id and um.user_id=".$user_id." order by menu_order";
				
				$rs = mysql_query($qry);
				$strmenu = "";
				$active_found = false;
				if (mysql_num_rows($rs)>0)
				{
					while($rw = mysql_fetch_array($rs))
					{
						if($setScroll==1)
						{
							$strmenu .= "<li  style=\"width:auto;\">";	
						}
						if (trim($rw["menu_icon"])!="")
							$menu_icon = "<img src='".MENU_ICONS.$rw["menu_icon"]."' alt='".$rw["menu_name"]."' title='".$rw["menu_name"]."' /> &nbsp;";
						else
							$menu_icon = "";
						if (in_array($rw["menu_id"], $activemenu_ids))
						{
							$activemenu_id = $rw["menu_id"];
							$active_found = true;
							$strmenu .= $menu_icon."<a href='".$rw["menu_page_name"]."' title='".$rw["menu_name"]."'><strong>".$rw["menu_name"] ."</strong></a>\r\n";
						}
						else
							$strmenu .= $menu_icon."<a href='".$rw["menu_page_name"]."' title='".$rw["menu_name"]."'>".$rw["menu_name"] ."</a>\r\n";
							
							$strmenu .= "&nbsp;&nbsp;&nbsp;&nbsp;";
							if($setScroll==1)
							{
								$strmenu .= "</li>";
							}
					}
				}
				if ($strmenu!="")
				{
					$output .= $strmenu;
				}
				
				if ($active_found)
				 $found = true;
				else
					$found = false;
					
				$found = false; // Restric submenu
			}
		}
		
		if($setScroll==1)
		{
			$output .= "</ul>";
		}
		$output .= "</div>
				</div>
				</div>
			  </div>
			</div>";

		return $output;
	}
	function getFirstSubmenu($menu_id, $user_id)
	{
		$page = "";
		if ($user_id==1)	// Allow all menu to Super Admin
			$qry = "select m.* from " . DB_PREFIX . "menu m where m.menu_parent_id=".$menu_id." and m.menu_isactive=1 and m.menu_isvisible=1 order by menu_isdefault desc,menu_order asc";
		else
			$qry = "select m.* from " . DB_PREFIX . "menu m, " . DB_PREFIX . "user_menu um where m.menu_parent_id=".$menu_id." and m.menu_isactive=1 and m.menu_isvisible=1 and m.menu_id=um.menu_id and um.user_id=".$user_id." order by menu_isdefault desc,menu_order asc";
		
		$rs = mysql_query($qry);
		
		if (mysql_num_rows($rs)>0)
		{
			$rw = mysql_fetch_array($rs);
			$page = $rw["menu_page_name"];
		}
		
		return $page;
	}	
	function getMenuTree($menu_parent_id = 0, $show_editdelete = false, $for_access_rights = false, $user_id=0, $loopcnt = -1)
	{
		global $class_name;
		
		$loopcnt++;

		if($loopcnt == 0)
			$html = "<ul class='access-rights' style='list-style:none; padding-left:0px; margin-left:0px;' id='tree_".$menu_parent_id."'>";
		else if($loopcnt == 1)
			$html = "<ul class='access-rights' style='list-style:none;padding-left:0px; margin-left:0px;' id='tree_".$menu_parent_id."'>";
		else if($loopcnt == 2)
			$html = "<ul class='access-rights' style='list-style:none; padding-left:".(40*$loopcnt)."px;' id='tree_".$menu_parent_id."'>";	
		else 
			$html = "<ul class='access-rights' style='list-style:none;' id='tree_".$menu_parent_id."'>";
			
		$qry = "select * from " . DB_PREFIX . "menu where menu_isactive=1 and menu_parent_id=".$menu_parent_id." order by menu_order";
		$rs = mysql_query($qry);
		
		$cnt = 1;
		while ($rw = mysql_fetch_array($rs))
		{	
			if (strpos($class_name, "class_".$menu_parent_id)===false)
				$class_name .= " class_".$menu_parent_id;
			if ($rw["menu_parent_id"]==0)
				$class_name = "";
			
			$javascript = "";
			$checked = "";
			if ($for_access_rights == true)
			{
				$javascript = " onclick=\"javascript: check_menu('class_".$rw["menu_id"]."', this.checked, 'menu_".$rw["menu_id"]."');\"";
				$qry = "select count(user_menu_id) as cnt from ".DB_PREFIX."user_menu where user_id='".$user_id."' and menu_id='".$rw["menu_id"]."'";
				
				//echo $qry; exit;
				
				$rs_menu = mysql_query($qry);
				$rw_menu = mysql_fetch_array($rs_menu);
				if ($rw_menu["cnt"]>0)
					$checked = "checked";
				mysql_free_result($rs_menu);
			}
			
			$isAccessible = "";
			if($rw["menu_isforaccess"]==0)
			{
				$isAccessible = "none";
			}
			if($loopcnt == 0)
				$html .= "<li id='li_".$rw["menu_id"]."' ><div style='display:".$isAccessible."; font-size: 14px; text-transform:uppercase;' class=\"table-raw-title2\" ><input type='checkbox' id='menu_".$rw["menu_id"]."' name='chk_access[]' ".$javascript." ".$checked." class='checkbox".$class_name."' value='".$rw["menu_id"]."' /> ".$rw["menu_name"]."</div>";
			else
			{
				if($loopcnt == 1)
				{
					if($cnt == mysql_num_rows($rs))
						$html .= "<li id='li_".$rw["menu_id"]."'><div style='padding-left:40px; display:".$isAccessible."'><input type='checkbox' id='menu_".$rw["menu_id"]."' name='chk_access[]' ".$javascript." ".$checked." class='checkbox".$class_name."' value='".$rw["menu_id"]."' /><strong> ".$rw["menu_name"]."</strong></div>";
						
					else
						$html .= "<li id='li_".$rw["menu_id"]."' style='border-bottom: 1px solid #5899C5;'><div style='padding-left:40px; display:".$isAccessible."'><input type='checkbox' id='menu_".$rw["menu_id"]."' name='chk_access[]' ".$javascript." ".$checked." class='checkbox".$class_name."' value='".$rw["menu_id"]."' /><strong> ".$rw["menu_name"]."</strong></div>";
				}	
				else
					$html .= "<li id='li_".$rw["menu_id"]."' ><div style='display:".$isAccessible."'><input type='checkbox' id='menu_".$rw["menu_id"]."' name='chk_access[]' ".$javascript." ".$checked." class='checkbox".$class_name."' value='".$rw["menu_id"]."' /> ".$rw["menu_name"]."</div>";
			}	
			
			if ($show_editdelete==true)
				$html .= "&nbsp;&nbsp;<a href='menu.php?menu_parent_id=".$rw["menu_id"]."' title='Add'> <img src='".SERVER_CLIENT_HOST."images/icons/add_small.gif' /></a>&nbsp;<a href='menu.php?mode=edit&menu_id=".$rw["menu_id"]."' title='Edit'> <img src='".SERVER_CLIENT_HOST."images/icons/edit_small.gif' /></a>";
			$qry = "select * from " . DB_PREFIX . "menu where menu_isactive=1 and menu_parent_id=".$rw["menu_id"];
			$rs_sub = mysql_query($qry);
			if (mysql_num_rows($rs_sub)>0)
			{
				$html .= $this->getMenuTree($rw["menu_id"], $show_editdelete, $for_access_rights,$user_id, $loopcnt);
				// $class_name = "";
				
				if($class_name != "")
				{
					$tmp_clsname_arr = explode(" ", $class_name);
					unset($tmp_clsname_arr[count($tmp_clsname_arr) - 1]);
					
					$class_name = implode(" ",$tmp_clsname_arr);
				}
			}
			$html .= "</li>";
			
			$cnt++;
		}
		return $html."</ul>";
	}
	
	function getParentMenuID($moduleName)
	{
		$sQry = "select m.menu_parent_id,m.menu_name from " . DB_PREFIX . "menu m where m.menu_isactive=1 and m.menu_isvisible=1 and m.menu_parent_id <> '0' and m.menu_module='".$moduleName."'";
		
		$rs = mysql_query($sQry);
		
		if (mysql_num_rows($rs) > 0) 
		{
			$resultArray = mysql_fetch_assoc($rs);	
			return 	$resultArray['menu_parent_id']."##".$resultArray['menu_name'];
		}
	}
	
	function getMainParentMenu($imenuParantId)
	{
		$sQry = "select m.* from " . DB_PREFIX . "menu m where m.menu_isactive=1 and m.menu_isvisible=1 and m.menu_id='".$imenuParantId."'";
		
		$rs = mysql_query($sQry);
		
		if (mysql_num_rows($rs) > 0) 
		{
			$resultArray = mysql_fetch_assoc($rs);	
			
			/*if ($resultArray['admin_menu_parent_id'] != 0) 
			{	
				return $this->getMainParentMenu($resultArray['admin_menu_parent_id']);
			}
			else
			{*/
				return $resultArray['menu_name'];
			//}
		}
	}
	
	function getMenuFieldValue($tableName,$fieldName,$getFieldName,$entityID)
	{
		$sQry = "select ".$getFieldName." from " . DB_PREFIX . $tableName." where ".$fieldName."='".$entityID."'";
		
		$rs = mysql_query($sQry);
		
		if (mysql_num_rows($rs) > 0) 
		{
			$resultArray = mysql_fetch_assoc($rs);	
			return 	$resultArray[$getFieldName];	
		}
	}
}
?>