<?php
class user_rights
{
	//Property
	var $user_right_id;
	var $user_role_id;
	var $menu_id;
	var $user_right;

	var $checkedids;
	var $uncheckedids;

	//Method
	//Function to retrieve recordset of table
	function fetchrecordset($id="",$condition="",$order="user_right_id")
	{
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
		$condition = " and user_right_id=". $id .$condition;
		}
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order;
		}
		$strquery="SELECT * FROM ".DB_PREFIX."user_rights WHERE 1=1 " . $condition . $order;
		$rs=mysql_query($strquery);
		return $rs;
	}

	//Function to retrieve records of table in form of two dimensional array
	function fetchallasarray($intid=NULL, $stralphabet=NULL,$condition="",$order="user_right_id")
	{
		$arrlist = array();
		$i = 0;
		$and = $condition;
		if(!is_null($intid) && trim($intid)!="") $and .= " AND user_right_id = " . $intid;
		if(!is_null($stralphabet) && trim($stralphabet)!="")	$and .= " AND user_right_id like '" . $stralphabet . "%'";
		$strquery="SELECT * FROM ".DB_PREFIX."user_rights WHERE 1=1 " . $and . " ORDER BY ".$order;
		$rs=mysql_query($strquery);
		while($aruser_rights= mysql_fetch_array($rs))
		{
			$arrlist[$i]["user_right_id"] = $aruser_rights["user_right_id"];
			$arrlist[$i]["user_role_id"] = $aruser_rights["user_role_id"];
			$arrlist[$i]["menu_id"] = $aruser_rights["menu_id"];
			$arrlist[$i]["user_right"] = $aruser_rights["user_right"];
			$i++;
		}
		return $arrlist;
	}

	//Function to set field values into object properties
	function setallvalues($id="",$condition="")
	{
		$rs=$this->fetchrecordset($id, $condition);
		if($aruser_rights= mysql_fetch_array($rs))
		{
			$this->user_right_id = $aruser_rights["user_right_id"];
			$this->user_role_id = $aruser_rights["user_role_id"];
			$this->menu_id = $aruser_rights["menu_id"];
			$this->user_right = $aruser_rights["user_right"];
			$this->create_date = $aruser_rights["create_date"];
		}
	}

	//Function to get particular field value
	function fieldvalue($field="user_right_id",$id="",$condition="",$order="")
	{
		$rs=$this->fetchrecordset($id, $condition, $order);
		$ret=0;
		while($rw=mysql_fetch_assoc($rs))
		{
			$ret=$rw[$field];
		}
		return $ret;
	}

	//Function to add record into table
	function add() 
	{
		$strquery="INSERT INTO ".DB_PREFIX."user_rights (user_role_id, menu_id, user_right) values('".$this->user_role_id."','".$this->menu_id."','".$this->user_right."')";
		mysql_query($strquery) or die(mysql_error());
		$this->user_right_id = mysql_insert_id();
		return mysql_insert_id();
	}

	//Function to update record of table
	function update() 
	{
		$strquery="UPDATE ".DB_PREFIX."user_rights SET user_role_id='".$this->user_role_id."', menu_id='".$this->menu_id."', user_right='".$this->user_right."' WHERE user_right_id=".$this->user_right_id;
		return mysql_query($strquery) or die(mysql_error());
	}

	//Function to delete record from table
	function delete() 
	{
		$strquery="DELETE FROM ".DB_PREFIX."user_rights  WHERE user_role_id = ". (int) $this->user_role_id;
		return mysql_query($strquery) or die(mysql_error());
	}

	//Function to active-inactive record of table
	function activeinactive()
	{
		$strquery	=	"UPDATE " . DB_PREFIX . "user_rights SET ='n' WHERE user_right_id in(" . $this->uncheckedids . ")";
		$result = mysql_query($strquery) or die(mysql_error());
		if($result == false)
			return ;
		$strquery	=	"UPDATE " . DB_PREFIX . "user_rights SET ='y' WHERE user_right_id in(" . $this->checkedids . ")";
		return mysql_query($strquery) or die(mysql_error());
	}
	
	function set_checked_status ( $user_rights_array, $menu_id, $user_right ) {
		$strreturn = '';
		if ( is_array($user_rights_array) && count($user_rights_array) ) {
			$inttotal_user_rights = count($user_rights_array);
			for ( $intcounter = 0; $intcounter < $inttotal_user_rights; $intcounter++ ) {
				$intmenu_id = (int) $user_rights_array[$intcounter]['menu_id'];
				$intuser_right = (int) $user_rights_array[$intcounter]['user_right'];
				if ( $intmenu_id == $menu_id && $intuser_right == $user_right ) {
					$strreturn = 'checked="checked"';
					break;
				}
			}
		}
		return $strreturn;
	}
	
	function get_user_rights ( ) {
		global $cmn;
		$arreturn = array(
										'view' => false
										, 'add' => false
										, 'add' => false
										, 'edit' => false
										, 'delete' => false
										, 'export' => false
								  );
		$user_id = (int) $cmn->get_session(ADMIN_USER_ID);
		$current_page = strtolower(trim(basename($_SERVER['PHP_SELF'])));
		$strquery = 'SELECT user_right FROM ' . DB_PREFIX . 'user_rights WHERE user_role_id =  (SELECT user_role_id FROM ' . DB_PREFIX . 'user WHERE user_id = ' . $user_id . ' LIMIT 1) AND menu_id = (SELECT menu_id FROM ' . DB_PREFIX . 'menu WHERE listing_page = \'' . $current_page . '\' OR addedit_page = \'' . $current_page . '\' LIMIT 1)';
		$rsuser_rights = mysql_query($strquery) or die(mysql_error());
		if ( $rsuser_rights && mysql_num_rows($rsuser_rights) ) {
			while ( $aruser_right = mysql_fetch_assoc($rsuser_rights) ) {
				switch ( (int) $aruser_right['user_right'] ) {
					case 1: //view
						$arreturn['view'] = true;
						break;	
					case 2: //add
						$arreturn['add'] = true;
						break;	
					case 3: //edit
						$arreturn['edit'] = true;
						break;	
					case 4: //delete
						$arreturn['delete'] = true;
						break;	
					case 6: //export
						$arreturn['export'] = true;
						break;	
				}
			}	
		}
		mysql_free_result($rsuser_rights);
		return $arreturn;
	}
	
	function check_page_rights ( $user_rights_array ) {
		global $msg;
		$page_type = '';
		$allow_access = false;
		$current_page = strtolower(trim(basename($_SERVER['PHP_SELF'])));
		if ( $current_page == 'index.php' || $current_page == 'dashboard.php' || $current_page == 'site-config.php' | $current_page == 'change-password.php' || $current_page == 'menu-list.php' || $current_page == 'menu-addedit.php' || $current_page == 'logout.php' ) {
			return;	
		}
		$strquery = 'SELECT listing_page, addedit_page FROM ' . DB_PREFIX . 'menu WHERE listing_page = \'' . $current_page . '\' OR addedit_page = \'' . $current_page . '\'';	
		$rsmenu = mysql_query($strquery) or die(mysql_error());
		if ( $rsmenu && mysql_num_rows($rsmenu) ) {
			while ( $armenu = mysql_fetch_assoc($rsmenu) ) {
				if ( trim($armenu['listing_page']) == $current_page ) {
					$page_type = 'LISTING';
					break;	
				}
				if ( trim($armenu['addedit_page']) == $current_page ) {
					$page_type = 'ADDEDIT';
					break;	
				}
			}
		}
		if ( $page_type == 'LISTING' ) { //view or delete or edit
			if ( $user_rights_array['view'] || $user_rights_array['delete'] || $user_rights_array['add'] || $user_rights_array['edit'] ) {
				$allow_access = true;
			}
		}
		if ( $page_type == 'ADDEDIT' ) { //view or add or edit
			if ( $user_rights_array['view'] || $user_rights_array['add'] || $user_rights_array['edit'] ) {
				$allow_access = true;
			}	
		}
		if ( ! $allow_access ) {
			$msg->send_msg('dashboard.php', '', 44);
			exit();
		}
	}
}
?>