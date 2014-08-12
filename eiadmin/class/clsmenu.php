<?php
class menu
{
	//Property
	var $menu_id;
	var $menu_name;
	var $listing_page;
	var $addedit_page;
	var $menu_icon;
	var $menu_order;
	var $menu_active;

	var $checkedids;
	var $uncheckedids;

	//Method
	//Function to retrieve recordset of table
	function fetchrecordset($id="",$condition="",$order="menu_id")
	{
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
		$condition = " and menu_id=". $id .$condition;
		}
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order;
		}
		$strquery="SELECT * FROM ".DB_PREFIX."menu WHERE 1=1 " . $condition . $order;
		$rs=mysql_query($strquery);
		return $rs;
	}

	//Function to retrieve records of table in form of two dimensional array
	function fetchallasarray($intid=NULL, $stralphabet=NULL,$condition="",$order="menu_id")
	{
		$arrlist = array();
		$i = 0;
		$and = $condition;
		if(!is_null($intid) && trim($intid)!="") $and .= " AND menu_id = " . $intid;
		if(!is_null($stralphabet) && trim($stralphabet)!="")	$and .= " AND menu_id like '" . $stralphabet . "%'";
		$strquery="SELECT * FROM ".DB_PREFIX."menu WHERE 1=1 " . $and . " ORDER BY ".$order;
		$rs=mysql_query($strquery);
		while($armenu= mysql_fetch_array($rs))
		{
			$arrlist[$i]["menu_id"] = $armenu["menu_id"];
			$arrlist[$i]["menu_name"] = $armenu["menu_name"];
			$arrlist[$i]["listing_page"] = $armenu["listing_page"];
			$arrlist[$i]["addedit_page"] = $armenu["addedit_page"];
			$arrlist[$i]["menu_icon"] = $armenu["menu_icon"];
			$arrlist[$i]["menu_order"] = $armenu["menu_order"];
			$arrlist[$i]["menu_active"] = $armenu["menu_active"];
			$i++;
		}
		return $arrlist;
	}

	//Function to set field values into object properties
	function setallvalues($id="",$condition="")
	{
		$rs=$this->fetchrecordset($id, $condition);
		if($armenu= mysql_fetch_array($rs))
		{
			$this->menu_id = $armenu["menu_id"];
			$this->menu_name = $armenu["menu_name"];
			$this->listing_page = $armenu["listing_page"];
			$this->addedit_page = $armenu["addedit_page"];
			$this->menu_icon = $armenu["menu_icon"];
			$this->menu_order = $armenu["menu_order"];
			$this->menu_active = $armenu["menu_active"];
		}
	}

	//Function to get particular field value
	function fieldvalue($field="menu_id",$id="",$condition="",$order="")
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
		$strquery="INSERT INTO ".DB_PREFIX."menu (menu_name, listing_page, addedit_page, menu_icon, menu_order, menu_active) values('".$this->menu_name."','".$this->listing_page."','".$this->addedit_page."','".$this->menu_icon."','".$this->menu_order."','".$this->menu_active."')";
		mysql_query($strquery) or die(mysql_error());
		$this->menu_id = mysql_insert_id();
		return mysql_insert_id();
	}

	//Function to update record of table
	function update() 
	{
		$strquery="UPDATE ".DB_PREFIX."menu SET menu_name='".$this->menu_name."', listing_page='".$this->listing_page."', addedit_page='".$this->addedit_page."', menu_icon='".$this->menu_icon."', menu_order='".$this->menu_order."', menu_active='".$this->menu_active."' WHERE menu_id=".$this->menu_id;
		return mysql_query($strquery) or die(mysql_error());
	}

	//Function to delete record from table
	function delete() 
	{
		$strquery="DELETE FROM ".DB_PREFIX."menu  WHERE menu_id in(".$this->checkedids.")";
		return mysql_query($strquery) or die(mysql_error());
	}

	//Function to active-inactive record of table
	function activeinactive()
	{
		$strquery	=	"UPDATE " . DB_PREFIX . "menu SET menu_active='n' WHERE menu_id in(" . $this->uncheckedids . ")";
		$result = mysql_query($strquery) or die(mysql_error());
		if($result == false)
			return ;
		$strquery	=	"UPDATE " . DB_PREFIX . "menu SET menu_active='y' WHERE menu_id in(" . $this->checkedids . ")";
		return mysql_query($strquery) or die(mysql_error());
	}
}
?>