<?php
class testimonial
{
	//Property
	var $id;
	var $title;
	var $content;
	var $by_name;
	var $old_by_name;
	var $date;
	var $active;

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
		$strquery='SELECT * FROM '.DB_PREFIX.'testimonial WHERE 1=1 ' . $condition . $order;
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
		$strquery='SELECT * FROM '.DB_PREFIX.'testimonial WHERE 1=1 ' . $and . ' ORDER BY '.$order;
		$rs=mysql_query($strquery);
		while($ardoc= mysql_fetch_array($rs))
		{
			$arrlist[$i]['id']			= $ardoc['id'];
			$arrlist[$i]['title']		= $ardoc['title'];
			$arrlist[$i]['content']		= $ardoc['content'];
			$arrlist[$i]['by_name']		= $ardoc['by_name'];
			$arrlist[$i]['date']		= $ardoc['date'];
			$arrlist[$i]['active']		= $ardoc['active'];
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
			$this->content		= $ardoc['content'];
			$this->by_name		= $ardoc['by_name'];
			$this->date			= $ardoc['date'];
			$this->active		= $ardoc['active'];
			$this->create_date	= $ardoc['create_date'];
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
		global $cmn;
		if($_FILES['txt_file']['name'] != '')
		{
			$newImageName	= $cmn->uploadandresizeimage('txt_file',59,55,TESTIMONIAL_UPLOAD_DIR);
			$extQuery		= 'by_name			= \''.$newImageName.'\',';
		}
		
		$strquery='INSERT INTO '.DB_PREFIX.'testimonial SET
					title			= \''.$this->title.'\',
					content			= \''.$this->content.'\',
					'.$extQuery.'
					date			= \''.$this->date.'\',
					modified_date	= \''.time().'\',
					active			= \''.$this->active.'\'';
		mysql_query($strquery) or die(mysql_error());
		$this->id = mysql_insert_id();
		return mysql_insert_id();
	}

	//Function to update record of table
	function update()
	{
		global $cmn;
		
		if($_FILES['txt_file']['name'] != '')
		{
			$newImageName	= $cmn->uploadandresizeimage('txt_file',59,55,TESTIMONIAL_UPLOAD_DIR);
			$extQuery		= 'by_name			= \''.$newImageName.'\',';
			
			unlink(TESTIMONIAL_UPLOAD_DIR.$this->old_by_name);
			unlink(TESTIMONIAL_UPLOAD_DIR.TESTIMONIAL_THUMB_PREFIX.$this->old_by_name);
		}
		
		$strquery='UPDATE '.DB_PREFIX.'testimonial SET 
					title			= \''.$this->title.'\',
					content			= \''.$this->content.'\',
					'.$extQuery.'
					date			= \''.$this->date.'\',
					active			= \''.$this->active.'\',
					modified_date	= \''.time().'\'
					WHERE id		= '.$this->id;

		return mysql_query($strquery) or die(mysql_error());	
	}
	
	//Function to delete record from table
	function delete()
	{
		$this->deleteFiles($this->checkedids);
		
		$strquery='DELETE FROM '.DB_PREFIX.'testimonial  WHERE id in('.$this->checkedids.')';
		return mysql_query($strquery) or die(mysql_error());
	}
	
	//Function to delete files from folders
	function deleteFiles($ids)
	{
		$rows	= $this->fetchallasarray(NULL,NULL,' AND id in('.$ids.')');
		
		for($c=0;$c<count($rows); $c++)
			@unlink(TESTIMONIAL_UPLOAD_DIR.$rows[$c]['by_name']);
	}
	
	//Function to active-inactive record of table
	function activeinactive()
	{
		$strquery	=	'UPDATE ' . DB_PREFIX . 'testimonial SET active=\'n\',modified_date	= \''.time().'\' WHERE id in(' . $this->uncheckedids . ')';
		$result = mysql_query($strquery) or die(mysql_error());
		if($result == false)
			return ;
		$strquery	=	'UPDATE ' . DB_PREFIX . 'testimonial SET active=\'y\',modified_date	= \''.time().'\' WHERE id in(' . $this->checkedids . ')';
		return mysql_query($strquery) or die(mysql_error());
	}
	
	function updateImage($ids)
	{
		$strquery	=	'UPDATE ' . DB_PREFIX . 'testimonial SET by_name=\'\', modified_date	= \''.time().'\' WHERE id in(' . $ids . ')';
		
		$result = mysql_query($strquery) or die(mysql_error());
		
		return true;
	}
}