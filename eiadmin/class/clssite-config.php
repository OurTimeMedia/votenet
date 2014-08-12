<?php
class site_config
{
	//Property
	var $site_config_id;
	var $admin_name;
	var $admin_email;
	var $from_name;
	var $from_email;
	var $sales_email;
	var $Copy;
	var $street;
	var $town;
	var $state;
	var $zipcode;
	var $phone;
    var $fax;
	
	var $facebook_url;
	var $twitter_url;
	var $blog_url;
	
	var $checkedids;
	var $uncheckedids;

	//Method
	function site_config ( ) {
		$this->setallvalues(1);	
	}
	
	//Function to retrieve recordset of table
	function fetchrecordset($id='',$condition='',$order='site_config_id')
	{
		if($id!='' && $id!= NULL && is_null($id)==false)
		{
		$condition = ' and site_config_id='. $id .$condition;
		}
		if($order!='' && $order!= NULL && is_null($order)==false)
		{
			$order = ' order by ' . $order;
		}
		$strquery='SELECT * FROM '.DB_PREFIX.'site_config WHERE 1=1 ' . $condition . $order;
		$rs=mysql_query($strquery);
		return $rs;
	}

	//Function to retrieve records of table in form of two dimensional array
	function fetchallasarray($intid=NULL, $stralphabet=NULL,$condition='',$order='site_config_id')
	{
		$arrlist = array();
		$i = 0;
		$and = $condition;
		if(!is_null($intid) && trim($intid)!='') $and .= ' AND site_config_id = ' . $intid;
		if(!is_null($stralphabet) && trim($stralphabet)!='')	$and .= ' AND site_config_id like \'' . $stralphabet . '%\'';
		$strquery='SELECT * FROM '.DB_PREFIX.'site_config WHERE 1=1 ' . $and . ' ORDER BY '.$order;
		$rs=mysql_query($strquery);
		while($arsite_config= mysql_fetch_array($rs))
		{
			$arrlist[$i] = $arsite_config;
			$i++;
		}
		return $arrlist;
	}

	//Function to set field values into object properties
	function setallvalues($id='',$condition='')
	{
		$rs=$this->fetchrecordset($id, $condition);
		if($arsite_config= mysql_fetch_array($rs))
		{
			$this->site_config_id = $arsite_config['site_config_id'];
			$this->admin_name = $arsite_config['admin_name'];
			$this->admin_email = $arsite_config['admin_email'];
			$this->from_name = $arsite_config['from_name'];
			$this->from_email = $arsite_config['from_email'];
			
			$this->sales_email = $arsite_config['sales_email'];
			$this->Copy = $arsite_config['copy'];
	
			$this->street = $arsite_config['street'];
			$this->town = $arsite_config['town'];
			$this->state = $arsite_config['state'];
			$this->zipcode = $arsite_config['zipcode'];
			$this->phone = $arsite_config['phone'];
            $this->fax = $arsite_config['fax'];
			$this->create_date = $arsite_config['create_date'];
			
			$this->facebook_url = $arsite_config['facebook_url'];
			$this->twitter_url	= $arsite_config['twitter_url'];
			$this->blog_url		= $arsite_config['blog_url'];
		}
	}

	//Function to get particular field value
	function fieldvalue($field='site_config_id',$id='',$condition='',$order='')
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
		$strquery='INSERT INTO '.DB_PREFIX.'site_config (admin_name, admin_email, from_name, from_email, street, town, state, zipcode, phone, fax, sales_email, copy ) values(\''.$this->admin_name.'\',\''.$this->admin_email.'\',\''.$this->from_name.'\',\''.$this->from_email.'\',\''.$this->street.'\',\''.$this->town.'\',\''.$this->state.'\',\''.$this->zipcode.'\',\''.$this->phone.'\',\''.$this->fax.'\', \''.$this->sales_email.'\',\''.$this->Copy.'\')';
		mysql_query($strquery) or die(mysql_error());
		$this->site_config_id = mysql_insert_id();
		return mysql_insert_id();
	}

	//Function to update record of table
	function update() 
	{
		$strquery='UPDATE '.DB_PREFIX.'site_config SET
			admin_name	= \''.$this->admin_name.'\',
			admin_email=\''.$this->admin_email.'\', from_name=\''.$this->from_name.'\', from_email=\''.$this->from_email.'\', street=\''.$this->street.'\', town=\''.$this->town.'\', state=\''.$this->state.'\', zipcode=\''.$this->zipcode.'\', phone=\''.$this->phone.'\', fax=\''.$this->fax.'\', sales_email=\''.$this->sales_email.'\',
			copy		= \''.$this->Copy.'\',
			facebook_url= \''.$this->facebook_url.'\',
			twitter_url	= \''.$this->twitter_url.'\',
			blog_url	= \''.$this->blog_url.'\'
		WHERE site_config_id='.$this->site_config_id;
		return mysql_query($strquery) or die(mysql_error());
	}

	//Function to delete record from table
	function delete() 
	{
		$strquery='DELETE FROM '.DB_PREFIX.'site_config  WHERE site_config_id in('.$this->checkedids.')';
		return mysql_query($strquery) or die(mysql_error());
	}

	//Function to active-inactive record of table
	function activeinactive()
	{
		$strquery	=	'UPDATE ' . DB_PREFIX . 'site_config SET =\'n\' WHERE site_config_id in(' . $this->uncheckedids . ')';
		$result = mysql_query($strquery) or die(mysql_error());
		if($result == false)
			return ;
		$strquery	=	'UPDATE ' . DB_PREFIX . 'site_config SET =\'y\' WHERE site_config_id in(' . $this->checkedids . ')';
		return mysql_query($strquery) or die(mysql_error());
	}
}
?>