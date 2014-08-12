<?php
class cms
{
	//Property
	var $cms_id;
	var $cms_title;
	var $cms_sub_title;
	
	var $seo_url;
	var $ext_url;
	var $parent;
	var $link_to_cms;
			
	var $cms_content;
	var $meta_title;
	var $meta_desc;
	var $meta_keywords;
	var $cms_active;
	var $front_menu;

	var $checkedids;
	var $uncheckedids;

	//Method
	//Function to retrieve recordset of table
	function fetchrecordset($id='',$condition='',$order='cms_id')
	{
		if($id!='' && $id!= NULL && is_null($id)==false)
		{
		$condition = ' and cms_id='. $id .$condition;
		}
		if($order!='' && $order!= NULL && is_null($order)==false)
		{
			$order = ' order by ' . $order;
		}
		$strquery='SELECT * FROM '.DB_PREFIX.'cms WHERE 1=1 ' . $condition . $order;
		$rs=mysql_query($strquery);
		return $rs;
	}

	//Function to retrieve records of table in form of two dimensional array
	function fetchallasarray($intid=NULL, $stralphabet=NULL,$condition='',$order='cms_id')
	{
		$arrlist = array();
		$i = 0;
		$and = $condition;
		if(!is_null($intid) && trim($intid)!='') $and .= ' AND cms_id = ' . $intid;
		if(!is_null($stralphabet) && trim($stralphabet)!='')	$and .= ' AND cms_id like \'' . $stralphabet . '%\'';
		
		$strquery='SELECT * FROM '.DB_PREFIX.'cms WHERE 1=1 ' . $and . ' ORDER BY '.$order;
		
		$rs=mysql_query($strquery);
		while($arcms= mysql_fetch_array($rs))
		{
			$arrlist[$i]['cms_id']			= $arcms['cms_id'];
			$arrlist[$i]['cms_title']		= $arcms['cms_title'];
			$arrlist[$i]['cms_sub_title']	= $arcms['cms_sub_title'];
			
			$arrlist[$i]['seo_url']			= $arcms['seo_url'];
			$arrlist[$i]['ext_url']			= $arcms['ext_url'];
			$arrlist[$i]['parent']			= $arcms['parent'];
			$arrlist[$i]['link_to_cms']		= $arcms['link_to_cms'];
						
			$arrlist[$i]['cms_content']		= $arcms['cms_content'];
			$arrlist[$i]['meta_title']		= $arcms['meta_title'];
			$arrlist[$i]['meta_desc']		= $arcms['meta_desc'];
			$arrlist[$i]['meta_keywords']	= $arcms['meta_keywords'];
			$arrlist[$i]['cms_active']		= $arcms['cms_active'];
			$arrlist[$i]['front_menu']		= $arcms['front_menu'];
			
			$i++;
		}
		return $arrlist;
	}

	//Function to set field values into object properties
	function setallvalues($id='',$condition='')
	{
		$rs=$this->fetchrecordset($id, $condition);
		if($arcms= mysql_fetch_array($rs))
		{
			$this->cms_id		= $arcms['cms_id'];
			$this->cms_title	= $arcms['cms_title'];
			$this->cms_sub_title= $arcms['cms_sub_title'];
			
			$this->seo_url		= $arcms['seo_url'];
			$this->ext_url		= $arcms['ext_url'];
			$this->parent		= $arcms['parent'];
			$this->link_to_cms	= $arcms['link_to_cms'];
						
			$this->cms_content	= $arcms['cms_content'];
			$this->meta_title	= $arcms['meta_title'];
			$this->meta_desc	= $arcms['meta_desc'];
			$this->meta_keywords= $arcms['meta_keywords'];
			$this->cms_active	= $arcms['cms_active'];
			$this->create_date	= $arcms['create_date'];
			$this->front_menu	= $arcms['front_menu'];
		}
	}

	//Function to get particular field value
	function fieldvalue($field='cms_id',$id='',$condition='',$order='')
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
		$strquery='INSERT INTO '.DB_PREFIX.'cms SET 
					cms_title		= \''.$this->cms_title.'\',
					cms_sub_title	= \''.$this->cms_sub_title.'\',
					
					seo_url			= \''.$this->seo_url.'\',
					ext_url			= \''.$this->ext_url.'\',
					parent			= '.$this->parent.',
					link_to_cms		= '.$this->link_to_cms.',
					
					cms_content		= \''.$this->cms_content.'\',
					meta_title		= \''.$this->meta_title.'\',
					meta_desc		= \''.$this->meta_desc.'\',
					meta_keywords	= \''.$this->meta_keywords.'\',
					cms_active		= \''.$this->cms_active.'\',
					front_menu		= \''.$this->front_menu.'\'';
					
		mysql_query($strquery) or die(mysql_error());
		$this->cms_id = mysql_insert_id();
		return mysql_insert_id();
	}

	//Function to update record of table
	function update() 
	{
		$strquery='UPDATE '.DB_PREFIX.'cms SET
					cms_title		= \''.$this->cms_title.'\',
					cms_sub_title	= \''.$this->cms_sub_title.'\',
					
					seo_url			= \''.$this->seo_url.'\',
					ext_url			= \''.$this->ext_url.'\',
					parent			= '.$this->parent.',
					link_to_cms		= '.$this->link_to_cms.',
					
					cms_content		= \''.$this->cms_content.'\',
					meta_title		= \''.$this->meta_title.'\',
					meta_desc		= \''.$this->meta_desc.'\',
					meta_keywords	= \''.$this->meta_keywords.'\',
					front_menu		= \''.$this->front_menu.'\',
					cms_active		= \''.$this->cms_active.'\'
					WHERE cms_id='.$this->cms_id;
		echo $strquery;
		return mysql_query($strquery) or die(mysql_error());
	}

	//Function to delete record from table
	function delete() 
	{
		$strquery='DELETE FROM '.DB_PREFIX.'cms  WHERE cms_id in('.$this->checkedids.')';
		return mysql_query($strquery) or die(mysql_error());
	}

	//Function to active-inactive record of table
	function activeinactive()
	{
		$strquery	=	'UPDATE ' . DB_PREFIX . 'cms SET cms_active=\'n\' WHERE cms_id in(' . $this->uncheckedids . ')';
		$result = mysql_query($strquery) or die(mysql_error());
		if($result == false)
			return ;
		$strquery	=	'UPDATE ' . DB_PREFIX . 'cms SET cms_active=\'y\' WHERE cms_id in(' . $this->checkedids . ')';
		return mysql_query($strquery) or die(mysql_error());
	}
	
	function getCmsCombo($selected)
	{
		global $cmn;
		
		$cmsArray 	= $this->fetchallasarray(NULL, NULL, ' AND parent=0 ');
		$returnHtml = '';
		
		if(count($cmsArray)>0)
		{
			for($b=0; $b<count($cmsArray); $b++)
			{
				$returnHtml.= "<option value='". $cmn->getval($cmsArray[$b]['cms_id']) . "' ";
	
				if ($selected == $cmsArray[$b]['cms_id']) {$returnHtml.= "selected=\"selected\""; }
				$returnHtml.= ">" . $cmn->getval($cmsArray[$b]['cms_title']) . "</option>";
				
				$returnHtml.= $this->getChildCmsCombo($selected,$cmsArray[$b]['cms_id'],1);
			}
		}
		
		return $returnHtml;
	}
	
	function getChildCmsCombo($selected,$pId,$leval)
	{
		global $cmn;
		
		$cmsArray 	= $this->fetchallasarray(NULL, NULL, ' AND parent='.$pId);
		$returnHtml = '';
		$lines		= '\'--';
		
		for($c=0; $c<($leval-1); $c++)
		{
			$space.= '&nbsp;&nbsp;&nbsp;&nbsp;';
		}
		
		$leval	= $leval+1;
		
		if(count($cmsArray)>0)
		{
			for($b=0; $b<count($cmsArray); $b++)
			{
				$returnHtml.= "<option value='". $cmn->getval($cmsArray[$b]['cms_id']) . "' ";
	
				if ($selected == $cmsArray[$b]['cms_id']) {$returnHtml.= "selected=\"selected\""; }
				$returnHtml.= ">".$space.$lines. $cmn->getval($cmsArray[$b]['cms_title']) . "</option>";
				
				$returnHtml.= $this->getChildCmsCombo($selected,$cmsArray[$b]['cms_id'],$leval);
			}
		}
		
		return $returnHtml;
	}
	
	function getCmsList($selected,$level=99,$selectedParent = '')
	{
		global $cmn;
		
		/* if($selected == '')
			$selected = 'home'; */
		
		$cmsArray 	= $this->fetchallasarray(NULL, NULL, ' AND cms_active = \'y\' AND front_menu = \'y\' AND parent=0 ');
		$returnHtml = '';
		
		if(0)
		{
			echo '<pre>';
			print_r($cmsArray);
			echo '</pre>';
		}
		
		if(count($cmsArray)>0)
		{
			for($b=0; $b<count($cmsArray); $b++)
			{
				$seoUrl	= SITE_URL;
				$cmsParent 	= $this->fetchallasarray(NULL, NULL, ' AND cms_active = \'y\' AND front_menu = \'y\' AND cms_id='.$cmsArray[$b]['parent']);
				
				if($cmsArray[$b]['link_to_cms'] > 0)
				{
					$link2cms 	= $this->fetchallasarray(NULL, NULL, ' AND cms_active = \'y\' AND front_menu = \'y\' AND cms_id='.$cmsArray[$b]['link_to_cms']);
					
					if($link2cms[0]['parent'] > 0)
					{
						$link2cmsParent 	= $this->fetchallasarray(NULL, NULL, ' AND cms_active = \'y\' AND front_menu = \'y\' AND cms_id='.$link2cms[0]['parent']);
						
						if($link2cmsParent[0]['seo_url'] != '')
							$seoUrl.= $link2cmsParent[0]['seo_url'].'/';
					}
					
					$seoUrl.= $link2cms[0]['seo_url'].'/';
				}
				else
				{
					if($cmsParent[0]['seo_url'] != '')
						$seoUrl.= $cmsParent[0]['seo_url'].'/';
					
					if($cmsArray[$b]['seo_url'] != '')
						$seoUrl.= $cmsArray[$b]['seo_url'].'/';
					
					if($cmsArray[$b]['ext_url'] != '')
						$seoUrl = $cmsArray[$b]['ext_url'];
				}
				
				
				$actClass	= (($selected == $cmsArray[$b]['seo_url'] or $selectedParent == $cmsArray[$b]['seo_url']) and $cmsArray[$b]['ext_url'] == '') ? 'class="active"' : '';
				
				$returnHtml.= '<li><a href="'.$seoUrl.'" '.$actClass.'><span>'.$cmn->getval($cmsArray[$b]['cms_title']).'</span></a>';
				
				if($level > 0)
					$returnHtml.= $this->getChildCmsList($selected,$cmsArray[$b]['cms_id'],1);
				$returnHtml.= "</li>";
			}
		}
		
		return $returnHtml;
	}
	
	function getChildCmsList($selected,$pId,$leval)
	{
		global $cmn;
		
		/* if($selected == '')
			$selected = 'home'; */

		$cmsArray 	= $this->fetchallasarray(NULL, NULL, ' AND cms_active = \'y\' AND front_menu = \'y\' AND parent='.$pId);
		$returnHtml = '';
		
		if(count($cmsArray)>0)
		{
			$returnHtml.= "<ul>";
			for($b=0; $b<count($cmsArray); $b++)
			{
				$seoUrl	= SITE_URL;
				$cmsParent 	= $this->fetchallasarray(NULL, NULL, ' AND cms_active = \'y\' AND front_menu = \'y\' AND cms_id='.$cmsArray[$b]['parent']);
				
				if($cmsArray[$b]['link_to_cms'] > 0)
				{
					$link2cms 	= $this->fetchallasarray(NULL, NULL, ' AND cms_active = \'y\' AND front_menu = \'y\' AND cms_id='.$cmsArray[$b]['link_to_cms']);
					
					if($link2cms[0]['parent'] > 0)
					{
						$link2cmsParent 	= $this->fetchallasarray(NULL, NULL, ' AND cms_active = \'y\' AND front_menu = \'y\' AND cms_id='.$link2cms[0]['parent']);
						
						if($link2cmsParent[0]['seo_url'] != '')
							$seoUrl.= $link2cmsParent[0]['seo_url'].'/';
					}
					
					$seoUrl.= $link2cms[0]['seo_url'].'/';
				}
				else
				{
					if($cmsParent[0]['seo_url'] != '')
						$seoUrl.= $cmsParent[0]['seo_url'].'/';
					
					if($cmsArray[$b]['seo_url'] != '')
						$seoUrl.= $cmsArray[$b]['seo_url'].'/';
					
					if($cmsArray[$b]['ext_url'] != '')
						$seoUrl = $cmsArray[$b]['ext_url'];
				}
				
				$actClass	= (($selected == $cmsArray[$b]['seo_url'] or $selectedParent == $cmsArray[$b]['seo_url']) and $cmsArray[$b]['ext_url'] == '') ? 'class="active"' : '';
				
				$returnHtml.= '<li><a href="'.$seoUrl.'" '.$actClass.'>'.$cmn->getval($cmsArray[$b]['cms_title']).'</a>';
				$returnHtml.= $this->getChildCmsList($selected,$cmsArray[$b]['cms_id'],1);
				$returnHtml.= "</li>";
			}
			
			$returnHtml.= "</ul>";
		}
		
		return $returnHtml;
	}
}