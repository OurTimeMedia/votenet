<?php
class adminmenu
{
	var $tmenu;
	var $smenu;

	var $admin_admin_menu_id;
	var $admin_menu_parent_id;
	var $admin_menu_name;
	var $admin_menu_module;
	var $admin_menu_icon;
	var $admin_menu_isactive;
	var $admin_menu_isvisible;
	var $admin_menu_order;
	var $admin_menu_page_name;
	var $pagingType;

	var $checkedids;
	var $uncheckedids;
	
	function fetchRecordSet($id="",$cond="",$ord="m.admin_menu_name")
	{
		if($id != "" && $id !=  NULL && is_null($id)==false)
		{
			$cond = " and m.admin_menu_id=". $id .$cond;
		}
		if($ord != "" && $ord !=  NULL && is_null($ord)==false)
		{
			$ord = " order by " . $ord;
		}
		$qry="select m.*, (select n.admin_menu_name from  " . DB_PREFIX . "admin_menu n where m.admin_menu_parent_id=n.admin_menu_id) as menuparentname from " . DB_PREFIX . "admin_menu m where 1=1 " . $cond . $ord;
		$rs=mysql_query($qry);
		
		return $rs;
	}
	
	function fetchAllAsArray($intid=NULL, $stralphabet=NULL)
	{
		$arrlist = array();
		$i = 0;
		$and = "";
		if(!is_null($intid))$and .= " AND m.admin_menu_id = " . $intid;
		if(!is_null($stralphabet))	$and .= " AND m.admin_menu_name like '" . $stralphabet . "%'";
		
		$qry = "SELECT m.* from " . DB_PREFIX . "admin_menu m WHERE 1=1 " . $and . " ORDER BY m.admin_menu_name";
		$rs=mysql_query($qry);

		while($rw= mysql_fetch_array($rs))
		{
			$arrlist[$i]["admin_menu_id"] 		= $rw["admin_menu_id"];
			$arrlist[$i]["admin_menu_parent_id"] = $rw["admin_menu_parent_id"];
			$arrlist[$i]["admin_menu_name"] 	= $rw["admin_menu_name"];
			$arrlist[$i]["admin_menu_module"] 	= $rw["admin_menu_module"];
			$arrlist[$i]["admin_menu_icon"] 	= $rw["admin_menu_icon"];
			$arrlist[$i]["admin_menu_isactive"] = $rw["admin_menu_isactive"];		
			$arrlist[$i]["admin_menu_order"] 	 = $rw["admin_menu_order"];
			$arrlist[$i]["admin_menu_page_name"] = $rw["admin_menu_page_name"];
			$arrlist[$i]["admin_menu_isvisible"] = $rw["admin_menu_isvisible"];
			
			$i++;
		}
		return $arrlist;
	}
	
	function setAllValues($id="",$cond="")
	{
		$rs=$this->fetchRecordSet($id, $cond);

		if($rw= mysql_fetch_array($rs))
		{
			$this->admin_menu_id = $rw["admin_menu_id"];
			$this->admin_menu_parent_id  = $rw["admin_menu_parent_id"];
			$this->admin_menu_name 	= $rw["admin_menu_name"];
			$this->admin_menu_module 	= $rw["admin_menu_module"];
			$this->admin_menu_icon 	= $rw["admin_menu_icon"];
			$this->admin_menu_isactive = $rw["admin_menu_isactive"];
			$this->admin_menu_order 	= $rw["admin_menu_order"];
			$this->admin_menu_page_name = $rw["admin_menu_page_name"];
			$this->admin_menu_isvisible = $rw["admin_menu_isvisible"];
			
		}
	}
	
	function fieldValue($fld="admin_menu_name",$id="",$cond="",$ord="")
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
		$qry	=	"insert into ". DB_PREFIX . "admin_menu (admin_menu_parent_id, admin_menu_name, admin_menu_module, admin_menu_isactive,  admin_menu_order, admin_menu_page_name, admin_menu_icon, admin_menu_isvisible)";
		$qry 	.=	" values ( '". $this->admin_menu_parent_id ."','". $this->admin_menu_name ."', '". $this->admin_menu_module ."', '". $this->admin_menu_isactive ."', '".$this->admin_menu_order ."','". $this->admin_menu_page_name ."','".$this->admin_menu_icon."','".$this->admin_menu_isvisible."')";

		mysql_query($qry) or die(mysql_error());
		$this->id = mysql_insert_id();
		return $this->id;
	}
	
	function update()
	{
		$qry	=	"update ". DB_PREFIX . "admin_menu set admin_menu_parent_id='". $this->admin_menu_parent_id ."',admin_menu_name='". $this->admin_menu_name ."' , admin_menu_module ='". $this->admin_menu_module ."', admin_menu_isactive='".$this->admin_menu_isactive."', admin_menu_order='". $this->admin_menu_order ."', admin_menu_page_name='". $this->admin_menu_page_name ."', admin_menu_icon='".$this->admin_menu_icon."', admin_menu_isvisible='".$this->admin_menu_isvisible."' where admin_menu_id=" . $this->admin_menu_id;
		
		
		return mysql_query($qry) or die(mysql_error());
	}
	
	function delete()
	{
		$qry	=	"delete from " . DB_PREFIX . "admin_menu where admin_menu_id=" . $this->admin_menu_id;
		return mysql_query($qry) or die(mysql_error());
	}
	function activeInactive()
	{
		$qry	=	"update " . DB_PREFIX . "admin_menu set admin_menu_isactive=0 where admin_menu_id in(" . $this->uncheckedids . ")";
		$result = mysql_query($qry) or die(mysql_error());
		if ($result == false)
			return $result;

		$qry	=	"update " . DB_PREFIX . "admin_menu set admin_menu_isactive=1 where admin_menu_id in(" . $this->checkedids . ")";
		 
		return mysql_query($qry) or die(mysql_error());
	}

	function getMenu($user_id, $currentmodule)
	{
		$mnucmn = new common();
		$activeadmin_menu_ids = array();
		$activeadmin_menu_id = "";
		$tempmenuid = "";
		
		// Get Active Menus
//		$qry = "select * from " . DB_PREFIX . "admin_menu where admin_menu_isactive=1 and admin_menu_module ='".$currentmodule."'";

		$currentmodule = str_replace("_", "\_",$currentmodule);
		$qry = "select * from " . DB_PREFIX . "admin_menu where admin_menu_isactive=1 and admin_menu_module like '".$currentmodule."%'";		

		// echo $qry; exit;
		
		$rsc = mysql_query($qry);
		if (mysql_num_rows($rsc)>0)
		{
			while ($rwc = mysql_fetch_array($rsc))
			{
				$activeadmin_menu_ids[] = $rwc["admin_menu_id"];
				$tempmenuid = $rwc["admin_menu_parent_id"];
				if ($tempmenuid != 0)
				{
					while ($tempmenuid  !=  0)
					{
						$activeadmin_menu_ids[] = $tempmenuid;
						$qry = "select * from " . DB_PREFIX . "admin_menu where admin_menu_id='".$tempmenuid."'";
						$rsc1 = mysql_query($qry);
						if (mysql_num_rows($rsc1)>0)
						{
							$rwc1 = mysql_fetch_array($rsc1);
							$tempmenuid = $rwc1["admin_menu_parent_id"];
							mysql_free_result($rsc1);
						}
					}
				}
				else
					$activeadmin_menu_ids[] = $rwc["admin_menu_id"];
			}
		}
		// Get Top Level Menus
		if ($user_id==1)	// Allow all menu to Super Admin
			$qry = "select m.* from " . DB_PREFIX . "admin_menu m where m.admin_menu_isactive=1 and m.admin_menu_isvisible=1 and m.admin_menu_parent_id=0 order by admin_menu_order";
		else
			$qry = "select m.* from " . DB_PREFIX . "admin_menu m, " . DB_PREFIX . "admin_user_menu um where m.admin_menu_isactive=1 and m.admin_menu_isvisible=1 and m.admin_menu_parent_id=0 and m.admin_menu_id=um.admin_menu_id and um.user_id=".$user_id." order by admin_menu_order";

		$rs = mysql_query($qry);
		$strmenu = "";
		if (mysql_num_rows($rs)>0)
		{
			$admin_menu_count = mysql_num_rows($rs);
			$admin_menu_index = 1;

			while($rw = mysql_fetch_array($rs))
			{
				$last_menu = "";
				if ($admin_menu_index == $admin_menu_count)
						$last_menu = "style=\"padding-right:14px;\"";

				if (trim($rw["admin_menu_icon"]) != "")
					$admin_menu_icon = "<img src='".MENU_ICONS.$rw["admin_menu_icon"]."' alt='".$rw["admin_menu_name"]."' /> ";
				else
					$admin_menu_icon = "";
					
				$admin_menu_link = $this->getFirstSubmenu($rw["admin_menu_id"], $user_id);
				
				if (trim($admin_menu_link)=="")	// If there is no sub menu for top level menu then use its own link
					$admin_menu_link = $rw["admin_menu_page_name"];
					
				if (in_array($rw["admin_menu_id"], $activeadmin_menu_ids))
				{
					$activeadmin_menu_id = $rw["admin_menu_id"];
					$strmenu .= "<li ".$last_menu." ><a href='".$admin_menu_link."' title='".$rw["admin_menu_name"]."' class='active' ><span>".$rw["admin_menu_name"] ."</span></a></li>\r\n";
				}
				else
					$strmenu .= "<li ".$last_menu."><a href='".$admin_menu_link."' title='".$rw["admin_menu_name"]."'><span>".$rw["admin_menu_name"] ."</span></a></li>\r\n";
			
				$admin_menu_index++;
			}
		}
		$strmenu .= "";

		$output = "<div class=\"menu_mn\">
  					<div class=\"menu_rt\">
				    	<div class=\"menu_mid\">
							<ul class=\"menu_top\">
								".$strmenu."
							</ul>";

		// Get Sub Menus		
		$output .="<div class=\"toplinks\">";
		
		$output .="<ul id=\"mycarousel\" class=\"jcarousel-skin-tango\">";	
		
											
		$found = true;
		$strmenu = "";
		if ($activeadmin_menu_id != "")
		{
			while ($found)
			{
				if ($user_id==1)	// Allow all menu to Super Admin
					$qry = "select m.* from " . DB_PREFIX . "admin_menu m where m.admin_menu_isactive=1 and m.admin_menu_isvisible=1 and m.admin_menu_parent_id=".$activeadmin_menu_id." order by admin_menu_order";
				else
					$qry = "select m.* from " . DB_PREFIX . "admin_menu m, " . DB_PREFIX . "admin_user_menu um where m.admin_menu_isactive=1 and m.admin_menu_isvisible=1 and m.admin_menu_parent_id=".$activeadmin_menu_id." and m.admin_menu_id=um.admin_menu_id and um.user_id=".$user_id." order by admin_menu_order";
					
		
				$rs = mysql_query($qry);
				$strmenu = "";
				$active_found = false;
				if (mysql_num_rows($rs)>0)
				{
					while($rw = mysql_fetch_array($rs))
					{
						$strmenu .= "<li  style=\"width:auto;\">";	
						
						
						if (trim($rw["admin_menu_icon"])  !=  "")
							$admin_menu_icon = "<img src='".MENU_ICONS.$rw["admin_menu_icon"]."' alt='".$rw["admin_menu_name"]."' title='".$rw["admin_menu_name"]."' /> ";
						else
							$admin_menu_icon = "";
							
						if (in_array($rw["admin_menu_id"], $activeadmin_menu_ids))
						{
							$activeadmin_menu_id = $rw["admin_menu_id"];
							$active_found = true;
							$strmenu .= $admin_menu_icon."<a href='".$rw["admin_menu_page_name"]."' title='".$rw["admin_menu_name"]."'><strong>".$rw["admin_menu_name"] ."</strong></a>\r\n";
						}
						else
							$strmenu .= $admin_menu_icon."<a href='".$rw["admin_menu_page_name"]."' title='".$rw["admin_menu_name"]."'>".$rw["admin_menu_name"] ."</a>\r\n";
							
						$strmenu .= "</li>";
						
						
					}
				}
				if ($strmenu != "")
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
		
		$output .="</ul>";	
		
		
		$output .= "</div>
				</div>
			  </div>
			</div>";

		return $output;
	}
	function getFirstSubmenu($admin_menu_id, $user_id)
	{
		$page = "";
		if ($user_id==1)	// Allow all menu to Super Admin
			$qry = "select m.* from " . DB_PREFIX . "admin_menu m where m.admin_menu_parent_id=".$admin_menu_id." and m.admin_menu_isactive=1 and m.admin_menu_isvisible=1 order by admin_menu_isdefault desc,admin_menu_order asc";
		else
			$qry = "select m.* from " . DB_PREFIX . "admin_menu m, " . DB_PREFIX . "admin_user_menu um where m.admin_menu_parent_id=".$admin_menu_id." and m.admin_menu_isactive=1 and m.admin_menu_isvisible=1 and m.admin_menu_id=um.admin_menu_id and um.user_id=".$user_id." order by admin_menu_isdefault desc,admin_menu_order asc";
		$rs = mysql_query($qry);
		
		if (mysql_num_rows($rs)>0)
		{
			$rw = mysql_fetch_array($rs);
			$page = $rw["admin_menu_page_name"];
		}
		
		return $page;
	}	
	function getAdminMenuTree($admin_menu_parent_id = 0, $show_editdelete = false, $for_access_rights = false, $user_id=0)
	{
		global $class_name;
		
		if ($admin_menu_parent_id  !=  0) 
		{
				
		}
		
		$html = "<ul class='access-rights' style='list-style:none;' id='tree_".$admin_menu_parent_id."'>";
		
		/*$html = ' <table cellpadding="0" cellspacing="0" width="100%" class="listtab">
                  <tr>
                    <td><br></td>
                  </tr>';*/
		
		$qry = "select * from " . DB_PREFIX . "admin_menu where admin_menu_isactive=1 and admin_menu_parent_id=".$admin_menu_parent_id." order by admin_menu_order";
		$rs = mysql_query($qry);
		
		while ($rw = mysql_fetch_array($rs))
		{	
			if (strpos($class_name, "class_".$admin_menu_parent_id)===false)
				$class_name .= " class_".$admin_menu_parent_id;
			if ($rw["admin_menu_parent_id"]==0)
				$class_name = "";
			
			$javascript = "";
			$checked = "";
			if ($for_access_rights == true)
			{
				$javascript = " onclick=\"javascript: check_menu('class_".$rw["admin_menu_id"]."', this.checked, 'menu_".$rw["admin_menu_id"]."');\"";
				
				$qry = "select count(adminuser_menu_id) as cnt from ".DB_PREFIX."admin_user_menu where user_id='".$user_id."' and admin_menu_id='".$rw["admin_menu_id"]."'";
				
				//echo $qry; exit;
				$rs_menu = mysql_query($qry);
				if (mysql_num_rows($rs_menu) > 0) 
				{
					$rw_menu = mysql_fetch_array($rs_menu);
					if ($rw_menu["cnt"]>0)
						$checked = "checked";
					
				}
				mysql_free_result($rs_menu);	
			}
			$html .= "<li id='li_".$rw["admin_menu_id"]."'><div><input type='checkbox' id='menu_".$rw["admin_menu_id"]."' name='chk_access[]' ".$javascript." ".$checked." class='checkbox".$class_name."' value='".$rw["admin_menu_id"]."' /> ".$rw["admin_menu_name"]."</div>";
			
			/*$html .= '<tr class="row01">
                    <td style="font-size:16px;">'."<input type='checkbox' id='admin_menu_".$rw["admin_menu_id"]."' name='chk_access[]' ".$javascript." ".$checked." class='checkbox".$class_name."' value='".$rw["admin_menu_id"]."' /> ".$rw["admin_menu_name"].'</td>
                  </tr>';*/
			
			if ($show_editdelete==true)
				$html .= "&nbsp;&nbsp;<a href='admin_menu.php?admin_menu_parent_id=".$rw["admin_menu_id"]."' title='Add'> <img src='images/icons/add_small.gif' /></a>&nbsp;<a href='admin_menu.php?mode=edit&admin_menu_id=".$rw["admin_menu_id"]."' title='Edit'> <img src='images/icons/edit_small.gif' /></a>";
			$qry = "select * from " . DB_PREFIX . "admin_menu where admin_menu_isactive=1 and admin_menu_parent_id=".$rw["admin_menu_id"];
			$rs_sub = mysql_query($qry);
			if (mysql_num_rows($rs_sub)>0)
			{
				$html .= $this->getAdminMenuTree($rw["admin_menu_id"], $show_editdelete, $for_access_rights,$user_id);
				$class_name = "";
			}
			$html .= "</li>";
		}
		return $html."</ul>";
	}
	
	function getMainParentMenu($imenuParantId)
	{
		$sQry = "select m.* from " . DB_PREFIX . "admin_menu m where m.admin_menu_isactive=1 and m.admin_menu_isvisible=1 and m.admin_menu_id='".$imenuParantId."'";
		
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
				return $resultArray['admin_menu_name'];
			//}
		}
	}
	
	function getMenuFieldValue($tableName,$fieldName,$getFieldName,$entityID)
	{
		echo $sQry = "select ".$getFieldName." from " . DB_PREFIX . $tableName." where ".$fieldName."='".$entityID."'";
		
		$rs = mysql_query($sQry);
		
		if (mysql_num_rows($rs) > 0) 
		{
			$resultArray = mysql_fetch_assoc($rs);	
			return 	$resultArray[$getFieldName];	
		}
	}
	
	function getParentMenuID($moduleName)
	{
		$sQry = "select m.admin_menu_parent_id,m.admin_menu_name from " . DB_PREFIX . "admin_menu m where m.admin_menu_isactive=1 and m.admin_menu_isvisible=1 and m.admin_menu_module='".$moduleName."'";
		
		$rs = mysql_query($sQry);
		
		if (mysql_num_rows($rs) > 0) 
		{
			$resultArray = mysql_fetch_assoc($rs);	
			return 	$resultArray['admin_menu_parent_id']."##".$resultArray['admin_menu_name'];	
		}
	}
	
	function getTotClients($regtype="")
	{
		$condition = '';
		if($regtype==30)
		{
			$condition = " AND register_date between DATE_SUB( '".currentScriptDate()."' ,INTERVAL 30 DAY ) AND '".currentScriptDate()."' ";
		}
		else if($regtype=="today")
		{
			$condition = " AND register_date between DATE_SUB( '".currentScriptDate()."' ,INTERVAL 1 DAY ) AND '".currentScriptDate()."' ";
		}
		else if($regtype==7)
		{
			$condition = " AND register_date between DATE_SUB( '".currentScriptDate()."' ,INTERVAL 7 DAY ) AND '".currentScriptDate()."' ";
		}
		else if($regtype=="Year")
		{
			$condition = " AND register_date between DATE_SUB( '".currentScriptDate()."' ,INTERVAL 1 YEAR ) AND '".currentScriptDate()."' ";
		}
		
		$sQry = "SELECT count(cl.client_id) as totClients FROM " . DB_PREFIX . "client cl," . DB_PREFIX . "user ur WHERE 1=1 AND cl.client_id=ur.client_id ".$condition;
		
		$rs = mysql_query($sQry);
		$res = mysql_fetch_assoc($rs);
		return $res["totClients"];
	}
	
	function getTotVoters($condition="",$regtype="")
	{
		if($regtype==30)
		{
			$condition.= " AND voting_date between DATE_SUB( '".currentScriptDate()."' ,INTERVAL 30 DAY ) AND '".currentScriptDate()."' ";
		}
		else if($regtype=="today")
		{
			$condition.= " AND voting_date between DATE_SUB( '".currentScriptDate()."' ,INTERVAL 1 DAY ) AND '".currentScriptDate()."' ";
		}
		else if($regtype==7)
		{
			$condition.= " AND voting_date between DATE_SUB( '".currentScriptDate()."' ,INTERVAL 7 DAY ) AND '".currentScriptDate()."' ";
		}
		else if($regtype=="Month")
		{
			$condition.= " AND voting_date between DATE_SUB( '".currentScriptDate()."' ,INTERVAL 1 MONTH ) AND '".currentScriptDate()."' ";
		}
		else if($regtype=="Year")
		{
			$condition.= " AND voting_date between DATE_SUB( '".currentScriptDate()."' ,INTERVAL 1 YEAR ) AND '".currentScriptDate()."' ";
		}
		
		$sQry = "SELECT count(v.rpt_reg_id 	) as totVoters FROM " . REPORT_DB_PREFIX . "rpt_registration v WHERE 1=1 ".$condition;
	//	echo $sQry."<br>";
		$rs = mysql_query($sQry);
		$res = mysql_fetch_assoc($rs);
		return $res["totVoters"];
	}
	
	function getTotContests($lastThirty=0)
	{
		$condition = '';
		if($lastThirty==1)
		{
			$condition = " AND entry_start_date between DATE_SUB( '".currentScriptDate()."' ,INTERVAL 30 DAY ) AND '".currentScriptDate()."' ";
		}
		$sQry = "SELECT count(ct.contest_id) as totContests FROM " . DB_PREFIX . "contest ct WHERE 1=1 ".$condition;
		
		$rs = mysql_query($sQry);
		$res = mysql_fetch_assoc($rs);
		return $res["totContests"];
	}
	
	function getTotNewContest($lastThirty=0)
	{
		$condition = '';
		
		if($lastThirty==1)
		{
			$condition = " AND entry_start_date between '".currentScriptDate()."' AND DATE_ADD( '".currentScriptDate()."' ,INTERVAL 30 DAY ) ";
		}
		
		$sQry = "SELECT count(ct.contest_id) as totNewContest FROM " . DB_PREFIX . "contest ct WHERE 1=1 AND entry_start_date>'".currentScriptDate()."' ".$condition;
		
		$rs = mysql_query($sQry);
		$res = mysql_fetch_assoc($rs);
		return $res["totNewContest"];
	}
	
	function getCompletedContest($lastThirty=0)
	{
		$condition = '';
		if($lastThirty==1)
		{
			$condition = " AND winner_announce_date between DATE_SUB( '".currentScriptDate()."' ,INTERVAL 30 DAY ) AND '".currentScriptDate()."' ";
		}
		$sQry = "SELECT count(ct.contest_id) as totComplContest FROM " . DB_PREFIX . "contest ct WHERE 1=1 AND contest_status=2 ".$condition;
		
		$rs = mysql_query($sQry);
		$res = mysql_fetch_assoc($rs);
		return $res["totComplContest"];
	}
	
	function getActiveDtlContest($lastThirty=0)
	{
		$condition = '';
		if($lastThirty==1)
		{
			$condition = " AND entry_start_date between DATE_SUB( '".currentScriptDate()."' ,INTERVAL 30 DAY ) AND '".currentScriptDate()."' ";
		}
		$sQry = "SELECT count(ct.contest_id) as totComplContest FROM " . DB_PREFIX . "contest ct WHERE 1=1 AND entry_start_date<='".currentScriptDate()."' AND winner_announce_date>='".currentScriptDate()."' AND contest_status=1 ".$condition;
		
		$rs = mysql_query($sQry);
		$res = mysql_fetch_assoc($rs);
		return $res["totComplContest"];
	}
	
	
	function getActiveContests()
	{
		$sQry = "SELECT ct.*,ur.user_firstname,ur.user_lastname FROM " . DB_PREFIX . "contest ct," . DB_PREFIX . "client cl," . DB_PREFIX . "user ur WHERE 1=1 AND contest_status=1 AND entry_start_date<='".currentScriptDate()."' AND winner_announce_date>='".currentScriptDate()."'  AND cl.client_id=ct.client_id AND cl.client_id=ur.client_id GROUP BY ct.contest_id limit 0,3 ";
		$rs = mysql_query($sQry);
		$aContests = array();
		$i = 0;
		while($res = mysql_fetch_assoc($rs))
		{
			$aContests[$i]["contest_id"] = $res["contest_id"];
			$aContests[$i]["contest_title"] = $res["contest_title"];
			$aContests[$i]["client_name"] = $res["user_firstname"]." ".$res["user_lastname"];
			$aContests[$i]["contest_create_date"] = $res["contest_create_date"];
			$aContests[$i]["no_of_entrants"] = $this->getNoEntrants($aContests[$i]["contest_id"]);
			$aContests[$i]["entry_start_date"] = $res["entry_start_date"];
			$aContests[$i]["entry_end_date"] = $res["winner_announce_date"];
			$i++;
		}
		return $aContests;
	}
	
	function getUpcomingContests()
	{
		$sQry = "SELECT * FROM " . DB_PREFIX . "contest ct WHERE 1=1 AND contest_status=1 AND entry_start_date between '".currentScriptDate()."' AND DATE_ADD( '".currentScriptDate()."' ,INTERVAL 15 DAY ) ORDER BY  entry_start_date ASC limit 0,3 ";
		$rs = mysql_query($sQry);
		$aContests = array();
		$i = 0;
		while($res = mysql_fetch_assoc($rs))
		{
			$aContests[$i]["contest_id"] = $res["contest_id"];
			$aContests[$i]["contest_title"] = $res["contest_title"];
			$aContests[$i]["contest_create_date"] = $res["contest_create_date"];
			$aContests[$i]["no_of_entrants"] = $this->getNoEntrants($aContests[$i]["contest_id"]);
			$aContests[$i]["entry_start_date"] = $res["entry_start_date"];
			$aContests[$i]["entry_end_date"] = $res["winner_announce_date"];
			$i++;
		}
		return $aContests;
	}
	
	function getNoEntrants($contest_id)
	{
		$condition = " AND contest_id='".$contest_id."' ";
		$sQry = "SELECT count(ct.entry_id) as totContests FROM " . DB_PREFIX . "entry ct WHERE 1=1 ".$condition;
		
		$rs = mysql_query($sQry);
		$res = mysql_fetch_assoc($rs);
		return $res["totContests"];
	}
	
	function getRevenue($lastThirty=0)
	{
		$condition = '';
		if($lastThirty==1)
		{
			$condition = " AND cp.payment_date between DATE_SUB( '".currentScriptDate()."' ,INTERVAL 30 DAY ) AND '".currentScriptDate()."'";
		}
		
		$sQry = "SELECT sum(cp.amount) as cntRevenue FROM " . DB_PREFIX . "contest ct, " . DB_PREFIX . "contest_payment cp WHERE 1=1 AND cp.payment_iscancel!=1 AND ct.payment_iscancel!=1 AND ct.contest_id=cp.contest_id ".$condition."";
		$rs = mysql_query($sQry);
		$res = mysql_fetch_assoc($rs);
		
		$condition = '';
		if($lastThirty==1)
		{
			$condition = " AND en.entry_date between DATE_SUB( '".currentScriptDate()."' ,INTERVAL 30 DAY ) AND '".currentScriptDate()."'";
		}
		$sQry = "SELECT sum(en.entry_amount) as cntRevenue FROM " . DB_PREFIX . "entry en WHERE 1=1 AND en.payment_status=1 ".$condition."";
		$rs = mysql_query($sQry);
		$resset = mysql_fetch_assoc($rs);
		$ePayment = 0;
		if($resset["cntRevenue"]>0)
			$ePayment = $resset["cntRevenue"];
		return "<span title='Revenue generated by Clients' style='cursor:help'>".$res["cntRevenue"]."</span>|<span title='Revenue generated by Entrants' style='cursor:help'>$".$ePayment."</span>";
	}

}
?>