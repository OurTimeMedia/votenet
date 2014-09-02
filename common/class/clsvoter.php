<?php
class voter extends common
{
	//Property
	var $voter_id;
	var $client_id;
	var $voter_email;
	var $voter_state_id;
	var $voter_zipcode;
	var $voter_reg_source;
	var $voter_isactive;
	var $created_date;
	var $created_by;
	var $updated_date;
	var $updated_by;
	var $pagingType;
	
	var $checkedids;
	var $uncheckedids;
	
	function voter()
	{
		$this->client_id = 0;
		$this->voter_isactive = 1;		
		$this->voter_reg_source = "Website";		
	}

	
	//Function to get particular field value
	function fieldValue($field = "voter_id",$id = "",$condition = "",$order = "")
	{
		$rs = $this->fetchRecordSet($id, $condition, $order);
		$ret = 0;
		while($rw = mysql_fetch_assoc($rs))
		{
			$ret = $rw[$field];
		}
		return $ret;
	}
	
	//Function to add record into table
	function add() 
	{
		$sQuery  =  "INSERT INTO ".DB_PREFIX."voter 
					
					(client_id, voter_email, voter_state_id, voter_zipcode, voter_reg_source, voter_isactive, created_date, created_by, 
					updated_date, updated_by) 
					
					values(
							'".$this->client_id."', '".$this->voter_email."','".$this->voter_state_id."','".$this->voter_zipcode."','".$this->voter_reg_source."','".$this->voter_isactive."', '".currentScriptDate()."','".$this->created_by."',
							'".currentScriptDate()."','".$this->updated_by."')";
		
				
		
		$this->runquery($sQuery);
		$this->voter_id  =  mysql_insert_id();
		
		$sQuery  =  "UPDATE ".DB_PREFIX."voter SET created_by='".$this->voter_id."',updated_by='".$this->voter_id."' WHERE voter_id ='".$this->voter_id."'";
		$this->runquery($sQuery);
		
		return $this->voter_id;
	}
		
	//Function to update record of table
	function update() 
	{
		$sQuery = "UPDATE ".DB_PREFIX."voter SET 
					client_id = '".$this->client_id."', 
					voter_email = '".$this->voter_email."', 
					voter_state_id = '".$this->voter_state_id."', 
					voter_zipcode = '".$this->voter_zipcode."', 
					voter_reg_source = '".$this->voter_reg_source."', 
					voter_isactive = '".$this->voter_isactive."', 
					updated_date = '".currentScriptDate()."', 
					updated_by = '".$this->updated_by."' 				
					WHERE voter_id = ".$this->voter_id;
		
		return $this->runquery($sQuery);
	}
	
	function setAllValues($id="",$condition="")
	{
		$order = '';
		if($id!="" && $id!= NULL && is_null($id)==false)
		{
			$condition = " and voter_id=". $id .$condition;
		}
		if($order!="" && $order!= NULL && is_null($order)==false)
		{
			$order = " order by " . $order.", voter_id desc";
		}
	
		$strquery="SELECT ".DB_PREFIX."voter.* FROM ".DB_PREFIX."voter WHERE 1=1 " . $condition . $order;
		$rs=mysql_query($strquery);
		
		if($artf_entry= mysql_fetch_array($rs))
		{			
			$this->voter_id = $artf_entry["voter_id"];
			$this->client_id = $artf_entry["client_id"];
			$this->voter_email = $artf_entry["voter_email"];
			$this->voter_state_id = $artf_entry["voter_state_id"];
			$this->voter_zipcode = $artf_entry["voter_zipcode"];
		}
	}
	
	//Function to delete record from table
	function delete() 
	{
		$sQuery = "DELETE FROM ".DB_PREFIX."voter  WHERE voter_id in(".$this->checkedids.")";
		
		$this->runquery($sQuery);
	}

    function fetchRecordSet($id = "",$condition = "",$order = "user_id")
    {
        if ($id != "" && $id != NULL && is_null($id) == false) {
            $condition = " and voter_id = " . $id . $condition;
        }
        if ($order != "" && $order != NULL && is_null($order) == false) {
            $order = " order by " . $order;
        }
        $sQuery = "SELECT * FROM " . DB_PREFIX . "voter WHERE 1 = 1 " . $condition . $order;

        $rs = $this->runquery($sQuery);
        return $rs;
    }
}
?>