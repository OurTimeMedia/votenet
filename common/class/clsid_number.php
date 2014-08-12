<?php
class id_number extends common
{
	var $id_number_id;
	var $id_number_name;
	var $id_number_length;
	var $id_number_active;
	var $created_by;
	var $created_date;
	var $updated_by;
	var $updated_date;
	var $pagingType;
	var $defaultlanguage_id;
		
	function id_number()
	{
		$this->id_number_id = 0;
		$this->id_number_name= "";
		$this->id_number_length = "";		
		$this->id_number_active = 1;		
		$this->defaultlanguage_id =1;
	}

	//Function to retrieve recordset of table
	function fetchRecordSet($id="",$condition="",$order="id_number_id")
	{
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
			$condition = " and id_number_id=". $id .$condition;
		}
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order.", id_number_id desc";
		}
		
		$strquery="SELECT * FROM ".DB_PREFIX."id_number WHERE 1=1 " . $condition . $order;
		$rs=mysql_query($strquery);
		return $rs;
	}
	
	function fetchAllAsArray($id = "",$condition = "",$order = "id_number_id")
	{		
		$arrlist = array();
		$sQuery = "SELECT * FROM ".DB_PREFIX."id_number 
		WHERE 1 = 1 " . $condition ." order by  ". $order;
		
		$rs=mysql_query($sQuery);
		$i=0;
		while($arid_number= mysql_fetch_array($rs))
		{
			$arrlist[$i]["id_number_id"] = $arid_number["id_number_id"];
			$arrlist[$i]["id_number_name"] = $arid_number["id_number_name"];
			$arrlist[$i]["id_number_length"] = $arid_number["id_number_length"];
			$arrlist[$i]["id_number_active"] = $arid_number["id_number_active"];
		
			$i++;
		}
		
		return $arrlist;
	}
	
	//Function to get particular field value
	function fieldValue($field="id_number_id",$id="",$condition="",$order="")
	{
		$rs=$this->fetchRecordSet($id, $condition, $order);
		$ret=0;
		while($rw=mysql_fetch_assoc($rs))
		{
			$ret=$rw[$field];
		}
		return $ret;
	}
	
	//Function to add recordset of table
	function addid_number()
	{
		$strQuery="INSERT INTO ".DB_PREFIX."id_number 
					(id_number_name, id_number_length, id_number_active, created_by, created_date, updated_by, updated_date) 
		  values('".$this->id_number_name."', '".$this->id_number_length."','".$this->id_number_active."','".$this->created_by."','".currentScriptDate()."','".$this->updated_by."', '".currentScriptDate()."')";
			mysql_query($strQuery) or die(mysql_error());
			$this->id_number_id = mysql_insert_id();
			return mysql_insert_id();
	}
	
	function setAllValues($id="",$condition="")
	{
		$rs=$this->fetchRecordSet($id, $condition);
		$i=0;

		while($arid_number= mysql_fetch_array($rs))
		{
			$this->id_number_id = $arid_number["id_number_id"];
			$this->id_number_name= $arid_number["id_number_name"];
			$this->id_number_length= $arid_number["id_number_length"];
			$this->id_number_active = $arid_number["id_number_active"];			
			$i++;
		}		
	}
	
	//Function to update recordset of table
	function updateid_number()
	{		
		$strQuery="UPDATE ".DB_PREFIX."id_number SET
					id_number_name= '".$this->id_number_name."', 
					id_number_length= '".$this->id_number_length."', 
					id_number_active = '".$this->id_number_active."', 
					updated_by = '".$this->updated_by."', 
					updated_date = '".currentScriptDate()."' 
					WHERE id_number_id='".$this->id_number_id."'";
	  			    mysql_query($strQuery) or die(mysql_error());
					return 1;	
	}
	
	//Function to delete record from table
	function deleteid_number($id_number_id) 
	{
		$sQuery = "DELETE FROM ".DB_PREFIX."id_number  WHERE id_number_id =".$id_number_id;
		return $this->runquery($sQuery);
	}
	
	function createLanguageDetailForIdNumber($language_id)
	{
		$strquery="SELECT id_number_language_id FROM ".DB_PREFIX."id_number_language WHERE 1=1 AND id_number_id='".$this->id_number_id."' AND language_id='".$language_id."'";
		$rs=mysql_query($strquery);
		if(mysql_num_rows($rs)==0)
		{
			$strQuery="INSERT INTO ".DB_PREFIX."id_number_language 
					(id_number_id, language_id, id_number_name, created_by, created_date, updated_by, updated_date) 
		 	 values('".$this->id_number_id."','".$language_id."','".$this->id_number_name."','".$this->created_by."','".currentScriptDate()."','".$this->updated_by."','".currentScriptDate()."')";
			mysql_query($strQuery) or die(mysql_error());
		}
		else
		{
			$strQuery="UPDATE ".DB_PREFIX."id_number_language SET
					id_number_name='".$this->id_number_name."', 
					updated_by='".$this->updated_by."', 
					updated_date='".currentScriptDate()."' 
					WHERE 1=1 AND id_number_id='".$this->id_number_id."' AND language_id='".$language_id."'";
			mysql_query($strQuery) or die(mysql_error());
		}
	}
	
	function fetchIdNumberLanguage()
	{			
		$strquery="SELECT * FROM ".DB_PREFIX."id_number_language WHERE 1=1 AND id_number_id='".$this->id_number_id."'";
		$rs=mysql_query($strquery);
		$arrList = array();
		$i = 0;
		while($artf_id_numberlanguage = mysql_fetch_array($rs))
		{
			$arrList[$i] = $artf_id_numberlanguage['language_id'];
			$i++;
		}
		
		return $arrList;
	}
	
	function deleteLanguageDetailForIdNumber($language_id)
	{
		$strquery="DELETE FROM ".DB_PREFIX."id_number_language WHERE 1=1 AND id_number_id='".$this->id_number_id."' AND language_id='".$language_id."'";
		mysql_query($strquery);
	}
	
	function deleteAllLanguageDetailForIdNumber($id_number_id)
	{
		$strquery="DELETE FROM ".DB_PREFIX."id_number_language WHERE 1=1 AND id_number_id='".$id_number_id."'";
		mysql_query($strquery);
	}

	//Function to active-inactive record of table
	function activeInactive()
	{
		$sQuery	 = 	"UPDATE ".DB_PREFIX."id_number SET id_number_active = 'n' WHERE id_number_id =".$this->id_number_id;
		return $this->runquery($sQuery);
	}
	
	function fetchIdNumberLanguageDetail()
	{
		$strquery="SELECT * FROM ".DB_PREFIX."id_number_language WHERE 1=1 AND id_number_id='".$this->id_number_id."'";
		$rs=mysql_query($strquery);
		$arrList = array();
		
		if(mysql_num_rows($rs) > 0)
		{
			while($artf_id_numberlanguage = mysql_fetch_array($rs))
			{
				$arrList[$artf_id_numberlanguage['language_id']]["id_number_name"] = $artf_id_numberlanguage['id_number_name'];				
			}
		}
		return $arrList;
	}
}