<?php
class demo
{
	//Property
	var $id;
	var $title;
	var $first_name;
	var $last_name;
	var $organization;
	var $email;
	var $phone;
	var $request_for;
	
	var $checkedids;
	var $uncheckedids;

	//Method
	//Function to retrieve recordset of table
	function fetchrecordset($id='',$condition='',$order='id')
	{
		if($id!='' && $id!= NULL && is_null($id)==false)
		{
			$condition = ' and id='. $id .$condition;
		}
		if($order!='' && $order!= NULL && is_null($order)==false)
		{
			$order = ' order by ' . $order;
		}
		$strquery='SELECT * FROM '.DB_PREFIX.'demo WHERE 1=1 ' . $condition . $order;
		$rs=mysql_query($strquery);
		return $rs;
	}

	//Function to retrieve records of table in form of two dimensional array
	function fetchallasarray($intid=NULL, $stralphabet=NULL,$condition='',$order='id')
	{
		$arrlist = array();
		$i = 0;
		$and = $condition;
		if(!is_null($intid) && trim($intid)!='') $and .= ' AND id = ' . $intid;
		if(!is_null($stralphabet) && trim($stralphabet)!='')	$and .= ' AND id like \'' . $stralphabet . '%\'';
		$strquery='SELECT * FROM '.DB_PREFIX.'demo WHERE 1=1 ' . $and . ' ORDER BY '.$order;
		$rs=mysql_query($strquery);
		while($ardoc= mysql_fetch_array($rs))
		{
			$arrlist[$i]['id']			= $ardoc['id'];
			$arrlist[$i]['title']		= $ardoc['title'];
			$arrlist[$i]['first_name']	= $ardoc['first_name'];
			$arrlist[$i]['last_name']	= $ardoc['last_name'];
			$arrlist[$i]['organization']= $ardoc['organization'];
			$arrlist[$i]['email']		= $ardoc['email'];
			$arrlist[$i]['phone']		= $ardoc['phone'];
			$i++;
		}
		return $arrlist;
	}

	//Function to set field values into object properties
	function setallvalues($id='',$condition='')
	{
		$rs=$this->fetchrecordset($id, $condition);
		if($ardoc= mysql_fetch_array($rs))
		{
			$this->id			= $ardoc['id'];
			$this->title		= $ardoc['title'];
			$this->first_name	= $ardoc['first_name'];
			$this->last_name	= $ardoc['last_name'];
			$this->organization	= $ardoc['organization'];
			$this->email		= $ardoc['email'];
			$this->phone		= $ardoc['phone'];
			$this->request_for	= $ardoc['request_for'];
		}
	}

	//Function to get particular field value
	function fieldvalue($field='id',$id='',$condition='',$order='')
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
		$strquery='INSERT INTO '.DB_PREFIX.'demo SET
					title			= \''.$this->title.'\',
					first_name		= \''.$this->first_name.'\',
					last_name		= \''.$this->last_name.'\',
					organization	= \''.$this->organization.'\',
					email			= \''.$this->email.'\',
					phone			= \''.$this->phone.'\',
					request_for		= \''.$this->request_for.'\'';
		mysql_query($strquery) or die(mysql_error());
		$this->id = mysql_insert_id();
		return mysql_insert_id();
	}

	//Function to update record of table
	function update()
	{
		$strquery='UPDATE '.DB_PREFIX.'demo SET 
					title			= \''.$this->title.'\',
					first_name		= \''.$this->first_name.'\',
					last_name		= \''.$this->last_name.'\',
					organization	= \''.$this->organization.'\',
					email			= \''.$this->email.'\',
					phone			= \''.$this->phone.'\',
					request_for		= \''.$this->request_for.'\'
					WHERE id		= '.$this->id;

		return mysql_query($strquery) or die(mysql_error());	
	}
	
	//Function to delete record from table
	function delete()
	{
		$strquery='DELETE FROM '.DB_PREFIX.'demo  WHERE id in('.$this->checkedids.')';
		return mysql_query($strquery) or die(mysql_error());
	}
	
	//Function to active-inactive record of table
	function activeinactive()
	{
		$strquery	=	'UPDATE ' . DB_PREFIX . 'demo SET active=\'n\',modified_date	= \''.time().'\' WHERE id in(' . $this->uncheckedids . ')';
		$result = mysql_query($strquery) or die(mysql_error());
		if($result == false)
			return ;
		$strquery	=	'UPDATE ' . DB_PREFIX . 'demo SET active=\'y\',modified_date	= \''.time().'\' WHERE id in(' . $this->checkedids . ')';
		return mysql_query($strquery) or die(mysql_error());
	}
}