<?php
class template
{
	//Property
	var $template_id;
	var $template_name;
	var $template_folder;
	var $template_isprivate;
	var $template_header_image;
	var $template_background_color;
	var $template_background_image;
	var $template_ispublish;
	var $template_isactive;
	var $created_by;
	var $created_date;
	var $updated_by;
	var $updated_date;
	var $pagingType;
	var $checkedids;
	var $uncheckedids;
	function template()
	{
		$this->template_isprivate = 1;
		$this->template_ispublish = 1;
		$this->template_isactive = 1;
	}
	//Method
	//Function to retrieve recordset of table
	function fetchRecordSet($id="",$condition="",$order="template_id")
	{
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
			$condition = " and template_id=". $id .$condition;
		}
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order.", template_id desc";
		}
		$strquery="SELECT * FROM ".DB_PREFIX."template WHERE 1=1 " . $condition . $order;
		$rs=mysql_query($strquery);
		return $rs;
	}
	//Function to retrieve records of table in form of two dimensional array
	function fetchAllAsArray($intid=NULL, $stralphabet=NULL,$condition="",$order="template_id")
	{
		$arrlist = array();
		$i = 0;
		$and = $condition;
		if(!is_null($intid) && trim($intid)!="") $and .= " AND template_id = " . $intid;
		if(!is_null($stralphabet) && trim($stralphabet)!="")	$and .= " AND template_id like '" . $stralphabet . "%'";
		$strquery="SELECT * FROM ".DB_PREFIX."template WHERE 1=1 " . $and . " ORDER BY ".$order;
		$rs=mysql_query($strquery);
		while($artf_template= mysql_fetch_array($rs))
		{
			$arrlist[$i]["template_id"] = $artf_template["template_id"];
			$arrlist[$i]["template_name"] = $artf_template["template_name"];
			$arrlist[$i]["template_folder"] = $artf_template["template_folder"];
			$arrlist[$i]["template_isprivate"] = $artf_template["template_isprivate"];
			$arrlist[$i]["template_header_image"] = $artf_template["template_header_image"];
			$arrlist[$i]["template_thumb_image"] = $artf_template["template_thumb_image"];
			$arrlist[$i]["template_background_color"] = $artf_template["template_background_color"];
			$arrlist[$i]["template_background_image"] = $artf_template["template_background_image"];
			$arrlist[$i]["template_ispublish"] = $artf_template["template_ispublish"];
			$arrlist[$i]["template_isactive"] = $artf_template["template_isactive"];
			$arrlist[$i]["created_by"] = $artf_template["created_by"];
			$arrlist[$i]["created_date"] = $artf_template["created_date"];
			$arrlist[$i]["updated_by"] = $artf_template["updated_by"];
			$arrlist[$i]["updated_date"] = $artf_template["updated_date"];
			$i++;
		}
		return $arrlist;
	}
	//Function to retrieve records of table in form of two dimensional array
	function fetchAllAsArrayPrivate($intid=NULL, $stralphabet=NULL,$condition="",$order= "template_id")
	{
		$arrlist = array();
		$i = 0;
		$and = $condition;
		if(!is_null($intid) && trim($intid)!="") $and .= " AND ".DB_PREFIX."template.template_id = " . $intid;
		if(!is_null($stralphabet) && trim($stralphabet)!="")	$and .= " AND ".DB_PREFIX."template.template_id like '" . $stralphabet . "%'";
		$strquery="SELECT * FROM ".DB_PREFIX."template,".DB_PREFIX."template_private WHERE 1=1 AND ".DB_PREFIX."template.template_id=".DB_PREFIX."template_private.template_id AND ".DB_PREFIX."template.template_isprivate='1' " . $and . " ORDER BY ".$order;
		$rs=mysql_query($strquery);
		while($artf_template= mysql_fetch_array($rs))
		{
			$arrlist[$i]["template_id"] = $artf_template["template_id"];
			$arrlist[$i]["template_name"] = $artf_template["template_name"];
			$arrlist[$i]["template_folder"] = $artf_template["template_folder"];
			$arrlist[$i]["template_isprivate"] = $artf_template["template_isprivate"];
			$arrlist[$i]["template_header_image"] = $artf_template["template_header_image"];
			$arrlist[$i]["template_thumb_image"] = $artf_template["template_thumb_image"];
			$arrlist[$i]["template_background_color"] = $artf_template["template_background_color"];
			$arrlist[$i]["template_background_image"] = $artf_template["template_background_image"];
			$arrlist[$i]["template_ispublish"] = $artf_template["template_ispublish"];
			$arrlist[$i]["template_isactive"] = $artf_template["template_isactive"];
			$arrlist[$i]["created_by"] = $artf_template["created_by"];
			$arrlist[$i]["created_date"] = $artf_template["created_date"];
			$arrlist[$i]["updated_by"] = $artf_template["updated_by"];
			$arrlist[$i]["updated_date"] = $artf_template["updated_date"];
			$i++;
		}
		return $arrlist;
	}
	//Function to set field values into object properties
	function setAllValues($id="",$condition="")
	{
		$rs=$this->fetchRecordSet($id, $condition);
		if($artf_template= mysql_fetch_array($rs))
		{
			$this->template_id = $artf_template["template_id"];
			$this->template_name = $artf_template["template_name"];
			$this->template_folder = $artf_template["template_folder"];
			$this->template_isprivate = $artf_template["template_isprivate"];
			$this->template_header_image = $artf_template["template_header_image"];
			$this->template_thumb_image = $artf_template["template_thumb_image"];
			$this->template_background_color = $artf_template["template_background_color"];
			$this->template_background_image = $artf_template["template_background_image"];
			$this->template_ispublish = $artf_template["template_ispublish"];
			$this->template_isactive = $artf_template["template_isactive"];
			$this->created_by = $artf_template["created_by"];
			$this->created_date = $artf_template["created_date"];
			$this->updated_by = $artf_template["updated_by"];
			$this->updated_date = $artf_template["updated_date"];
		}
	}

	//Function to get particular field value
	function fieldValue($field="template_id",$id="",$condition="",$order="")
	{
		$rs=$this->fetchRecordSet($id, $condition, $order);
		$ret=0;
		while($rw=mysql_fetch_assoc($rs))
		{
			$ret=$rw[$field];
		}
		return $ret;
	}

	//Function to active-inactive record of table
	function activeInactive()
	{	
		$strquery	=	"UPDATE " . DB_PREFIX . "template SET template_isactive='0' WHERE template_id in(" . $this->uncheckedids . ")";
		$result = mysql_query($strquery) or die(mysql_error());
		if($result == false)
			return ;
		$strquery	=	"UPDATE " . DB_PREFIX . "template SET template_isactive='1' WHERE template_id in(" . $this->checkedids . ")";
		return mysql_query($strquery) or die(mysql_error());
	}
	
	//Function to public-private record of table
	function publicPrivate()
	{	
		$strquery	=	"UPDATE " . DB_PREFIX . "template SET template_isprivate='0' WHERE template_id in(" . $this->uncheckedids . ")";
		$result = mysql_query($strquery) or die(mysql_error());
		if($result == false)
			return ;
		$strquery	=	"UPDATE " . DB_PREFIX . "template SET template_isprivate='1' WHERE template_id in(" . $this->checkedids . ")";
		return mysql_query($strquery) or die(mysql_error());
	}
}
?>