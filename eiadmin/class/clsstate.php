<?php
class state
{
	//Property
	var $state_id;
	var $state_name;
	var $state_code;
	var $state_active;

	var $checkedids;
	var $uncheckedids;

	//Method
	//Function to retrieve recordset of table
	function fetchrecordset($id='',$condition='',$order='state_id')
	{
		if($id!='' && $id!= NULL && is_null($id)==false)
		{
		$condition = ' and state_id='. $id .$condition;
		}
		if($order!='' && $order!= NULL && is_null($order)==false)
		{
			$order = ' order by ' . $order;
		}
		$strquery='SELECT * FROM '.DB_PREFIX.'state WHERE 1=1 ' . $condition . $order;
		$rs=mysql_query($strquery);
		return $rs;
	}

	//Function to retrieve records of table in form of two dimensional array
	function fetchallasarray($intid=NULL, $stralphabet=NULL,$condition='',$order='state_id')
	{
		$arrlist = array();
		$i = 0;
		$and = $condition;
		if(!is_null($intid) && trim($intid)!='') $and .= ' AND state_id = ' . $intid;
		if(!is_null($stralphabet) && trim($stralphabet)!='')	$and .= ' AND state_id like \'' . $stralphabet . '%\'';
		$strquery='SELECT * FROM '.DB_PREFIX.'state WHERE 1=1 ' . $and . ' ORDER BY '.$order;
		$rs=mysql_query($strquery);
		while($arstate= mysql_fetch_array($rs))
		{
			$arrlist[$i]['state_id'] = $arstate['state_id'];
			$arrlist[$i]['state_name'] = $arstate['state_name'];
			$arrlist[$i]['state_code'] = $arstate['state_code'];
			$arrlist[$i]['state_active'] = $arstate['state_active'];
			$i++;
		}
		return $arrlist;
	}

	//Function to set field values into object properties
	function setallvalues($id='',$condition='')
	{
		$rs=$this->fetchrecordset($id, $condition);
		if($arstate= mysql_fetch_array($rs))
		{
			$this->state_id = $arstate['state_id'];
			$this->state_name = $arstate['state_name'];
			$this->state_code = $arstate['state_code'];
			$this->state_active = $arstate['state_active'];
		}
	}

	//Function to get particular field value
	function fieldvalue($field='state_id',$id='',$condition='',$order='')
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
		$strquery='INSERT INTO '.DB_PREFIX.'state (state_name, state_code, state_active) values(\''.$this->state_name.'\',\''.$this->state_code.'\',\''.$this->state_active.'\')';
		mysql_query($strquery) or die(mysql_error());
		$this->state_id = mysql_insert_id();
		return mysql_insert_id();
	}

	//Function to update record of table
	function update() 
	{
		$strquery='UPDATE '.DB_PREFIX.'state SET state_name=\''.$this->state_name.'\', state_code=\''.$this->state_code.'\', state_active=\''.$this->state_active.'\' WHERE state_id='.$this->state_id;
		return mysql_query($strquery) or die(mysql_error());
	}

	//Function to delete record from table
	function delete() 
	{
		$strquery='DELETE FROM '.DB_PREFIX.'state  WHERE state_id in('.$this->checkedids.')';
		return mysql_query($strquery) or die(mysql_error());
	}

	//Function to active-inactive record of table
	function activeinactive()
	{
		$strquery	=	'UPDATE ' . DB_PREFIX . 'state SET state_active=\'n\' WHERE state_id in(' . $this->uncheckedids . ')';
		$result = mysql_query($strquery) or die(mysql_error());
		if($result == false)
			return ;
		$strquery	=	'UPDATE ' . DB_PREFIX . 'state SET state_active=\'y\' WHERE state_id in(' . $this->checkedids . ')';
		return mysql_query($strquery) or die(mysql_error());
	}
	
	function get_state_codes($strstates = '0')
	{
		$strstate_codes = '';
		if( !empty($strstates) )
		{
			$strquery = 'SELECT state_code FROM ' . DB_PREFIX . 'state WHERE state_id IN (' . $strstates . ')';
			$rs = mysql_query($strquery);
			while( $rw = mysql_fetch_assoc($rs) )
			{
				$strstate_codes .= $rw['state_code'] . ', ';
			}
			
			if( !empty($strstate_codes) )
				$strstate_codes = substr($strstate_codes, 0, -2);
		}
		return $strstate_codes;
	
	}
	
}
?>