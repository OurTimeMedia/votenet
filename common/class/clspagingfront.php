<?php
class paging
{	
	var $intRowsPerPage;
	var $intCurrentPage;
	var $intStartRecNo;
	var $intTotalRecords;
	var $intPageSize;
	var $page;
	var $intNextPage;
	var $intPrevPage;
	var $searchfor;
	var $searchoption;
	var $strHiddenvars;
	var $txtSearchText;
	var $strACond;
	var $_strSort;
	var $strHiddenScripts;
	var $strorderby;
	var $strorder;
	var $pagingType;
	
	function paging()
	{
		if(!empty($_POST["hdnorderby"]))
			$this->strorderby  =  trim($_POST["hdnorderby"]);
		else
			$this->strorderby  =  "";
		if(!empty($_POST["hdnorder"]))
			$this->strorder  =  trim($_POST["hdnorder"]);
		else
			$this->strorder  =  "asc";
	}
	function setPageDetailsReports($objCurrentObject,$page1,$intRowsPerPage1,$cond = "")
	{ 
		
		if(!empty($_POST["hdnorderby"]) && trim($_POST["hdnorderby"])!= "")
			$this->strorderby  =  trim($_POST["hdnorderby"]);
		if(!empty($_POST["hdnorder"]) && trim($_POST["hdnorder"])!= "")
			$this->strorder  =  trim($_POST["hdnorder"]);
		$this->page = $page1;
		$this->intRowsPerPage = $intRowsPerPage1;
		if(isset($_POST["txtpagesize"]))
		{
			$this->intRowsPerPage = $_POST["txtpagesize"];
		}
		else
		{
			if($this->intRowsPerPage == "")
			{
				$this->intRowsPerPage = PAGESIZE;
			}
		}
		if(isset($_POST["txtcurrentpage"]))
		{
			$this->intCurrentPage = $_POST["txtcurrentpage"];
		}
		else
		{
			$this->intCurrentPage = 1;
		}		
			$this->intStartRecNo =  (($this->intCurrentPage -1) * $this->intRowsPerPage) + 1;

		if (!empty($this->strorderby)) 
		{
			$strOrderBy  =  $this->strorderby . " " . $this->strorder;	
		}
		else 
		{
			$strOrderBy  =  "";	
		}
		//print_r($objCurrentObject);exit;
		if(!empty($strOrderBy))
		{
			$rsPg=$objCurrentObject->fetchRecordSetReport("", $cond, $strOrderBy);	
		}
		else 
		{
			$rsPg = $objCurrentObject->fetchRecordSetReport("", $cond);	
		}
		$this->intTotalRecords  =  mysql_num_rows($rsPg);
		if(intval($this->intTotalRecords/$this->intRowsPerPage) == $this->intTotalRecords/$this->intRowsPerPage)
		{
			$this->intPageSize = intval($this->intTotalRecords/$this->intRowsPerPage);
		}
		else
		{
			$this->intPageSize = intval($this->intTotalRecords/$this->intRowsPerPage) + 1;
		}
		if($this->intTotalRecords == 0)
		{
			$this->intPageSize = 1;
		}
		if ((intval($this->intCurrentPage)-1)<1)
		{
			$this->intPrevPage = $this->intCurrentPage;
		}
		else
		{
			$this->intPrevPage = intval($this->intCurrentPage)-1;
		}
		if ((intval($this->intCurrentPage)+1)>$this->intPageSize)
		{
			$this->intNextPage = $this->intCurrentPage;
		}
		else
		{
			$this->intNextPage = intval($this->intCurrentPage)+1;
		}
		if(mysql_num_rows($rsPg) > 0)
		{				
			//var_dump($this->intCurrentPage);
			if (($this->intStartRecNo-1)>mysql_num_rows($rsPg))
			{					
				$this->intCurrentPage  =  1;
				//mysql_data_seek($rsPg,10);
			}
			else 
				mysql_data_seek($rsPg,$this->intStartRecNo-1);
			$arRw =  array();
			$tmp = $this->intRowsPerPage;
			if(($this->intStartRecNo+$this->intRowsPerPage)>$this->intTotalRecords)
			{
				$tmp = ($this->intTotalRecords)-($this->intStartRecNo-1);		
			}
			for($i = 0;$i<$tmp;$i++)
			{
				$arRw[] = mysql_fetch_array($rsPg);
			}
		}
		else
		{
			$arRw =  array();
		} 
		return $arRw;
	}
	function setPageDetails($objCurrentObject,$page1,$intRowsPerPage1,$cond = "", $id="",$join="",$limit='',$field='')
	{ 
		
		if(!empty($_POST["hdnorderby"]) && trim($_POST["hdnorderby"])!= "")
			$this->strorderby  =  trim($_POST["hdnorderby"]);

		if(!empty($_POST["hdnorder"]) && trim($_POST["hdnorder"])!= "")
			$this->strorder  =  trim($_POST["hdnorder"]);
		$this->page = $page1;
		$this->intRowsPerPage = $intRowsPerPage1;
		if(isset($_POST["txtpagesize"]))
		{
			$this->intRowsPerPage = $_POST["txtpagesize"];
		}
		else
		{
			if($this->intRowsPerPage == "")
			{
				$this->intRowsPerPage = PAGESIZE;
			}
		}
		if(isset($_POST["txtcurrentpage"]))
		{
			$this->intCurrentPage = $_POST["txtcurrentpage"];
		}
		else
		{
			$this->intCurrentPage = 1;
		}		
		$this->intStartRecNo =  (($this->intCurrentPage -1) * $this->intRowsPerPage) + 1;
		
		if (!empty($this->strorderby)) 
		{
			$strOrderBy  =  $this->strorderby . " " . $this->strorder;	
		}
		else 
		{
			$strOrderBy  =  "";	
		}
		
		//_p($objCurrentObject);
		if(!empty($strOrderBy))
		{
		
//echo $objCurrentObject->pagingType;echo $strOrderBy;exit;
			switch ($objCurrentObject->pagingType)
			{
				case 'cReports':
					$rsPg = $objCurrentObject->fetchRecordSetReport("", $cond, $strOrderBy);	
					break;
				case 'eReports':
					$rsPg = $objCurrentObject->fetchRecordSetReportEntrant("", $cond, $strOrderBy);	
					break;
				case 'jReports':
					$rsPg = $objCurrentObject->fetchRecordSetReportJudge("", $cond, $strOrderBy);	
					break;
				case 'nReports':
					$rsPg = $objCurrentObject->fetchRecordSetJudgeReport($id, $cond, $strOrderBy);	
					break;
				case 'aReports':
					$rsPg = $objCurrentObject->fetchRecordSetReportAll("", $cond, $strOrderBy);
					break;
				case 'statedata':
				$rsPg = $objCurrentObject->fetchRecordSet("", $cond, $strOrderBy,$join);	
					break;
				case 'statebystaterpt':
				$rsPg = $objCurrentObject->statebystatereport("", $cond, $strOrderBy);	
				
					break;	
				case 'toptenstaterpt':
				$rsPg = $objCurrentObject->toptenstatereport("", $cond, $strOrderBy);	
					break;
				case 'mostactivedays':
				$rsPg = $objCurrentObject->mostactivedaysreport("", $cond, $strOrderBy);	
					break;	
				case 'hitreport':
				$rsPg = $objCurrentObject->hitreport("", $cond, $strOrderBy);	
					break;	
				case 'topresourcedetail':
				$rsPg = $objCurrentObject->topresourceclientdetail("", $cond, $strOrderBy);	
					break;		
				case 'montheport':
				$rsPg = $objCurrentObject->monthwisedetail("", $cond, $strOrderBy);	
					break;		
				case 'activedays':
				$rsPg = $objCurrentObject->activedaysdetail("", $cond, $strOrderBy,$limit);	
					break;	
				case 'registantrpt':
				$rsPg = $objCurrentObject->registrantdetail("", $cond, $strOrderBy,$field);	
					break;						
				default:
					$rsPg = $objCurrentObject->fetchRecordSet("", $cond, $strOrderBy);	
					break;
			}
		}		
		else 
		{
			switch ($objCurrentObject->pagingType)
			{
				case 'cReports':
					$rsPg = $objCurrentObject->fetchRecordSetReport("", $cond);	
					break;
				case 'aReports':
					$rsPg = $objCurrentObject->fetchRecordSetReportAll("", $cond);
					break;
				default:
					$rsPg = $objCurrentObject->fetchRecordSet("", $cond);	
					break;
			}
		}
		
		if(is_array($rsPg))
			$this->intTotalRecords  =  count($rsPg);
		else
			$this->intTotalRecords  =  mysql_num_rows($rsPg);
			
		if(intval($this->intTotalRecords/$this->intRowsPerPage) == $this->intTotalRecords/$this->intRowsPerPage)
		{
			$this->intPageSize = intval($this->intTotalRecords/$this->intRowsPerPage);
		}
		else
		{
			$this->intPageSize = intval($this->intTotalRecords/$this->intRowsPerPage) + 1;
		}
		if($this->intTotalRecords == 0)
		{
			$this->intPageSize = 1;
		}
		if ((intval($this->intCurrentPage)-1)<1)
		{
			$this->intPrevPage = $this->intCurrentPage;
		}
		else
		{
			$this->intPrevPage = intval($this->intCurrentPage)-1;
		}
		if ((intval($this->intCurrentPage)+1)>$this->intPageSize)
		{
			$this->intNextPage = $this->intCurrentPage;
		}
		else
		{
			$this->intNextPage = intval($this->intCurrentPage)+1;
		}
		
		if(is_array($rsPg))
		{
			$arRw =  $rsPg;
		}
		else if(mysql_num_rows($rsPg) > 0)
		{				
			//var_dump($this->intCurrentPage);
			if ($intRowsPerPage1 != -1)
			{
				if (($this->intStartRecNo-1)>mysql_num_rows($rsPg))
				{					
					$this->intCurrentPage  =  1;
					//mysql_data_seek($rsPg,10);
				}
				else 
					mysql_data_seek($rsPg,$this->intStartRecNo-1);
				$arRw =  array();
				$tmp = $this->intRowsPerPage;
				if(($this->intStartRecNo+$this->intRowsPerPage)>$this->intTotalRecords)
				{
					$tmp = ($this->intTotalRecords)-($this->intStartRecNo-1);		
				}
			}
			else
			{
				$tmp = mysql_num_rows($rsPg);
			}
			for($i=0;$i<$tmp;$i++)
			{
				$arRw[] = mysql_fetch_array($rsPg);
			}
		}
		else
		{
			$arRw =  array();
		} 
		return $arRw;
	}
	function setPageDetailsRecordSet($rsPg, $page1, $intRowsPerPage1)
	{ 
		$this->page = $page1;
		$this->intRowsPerPage = $intRowsPerPage1;
		if(isset($_POST["txtpagesize"]))
		{
			$this->intRowsPerPage = $_POST["txtpagesize"];
		}
		else
		{
			if($this->intRowsPerPage == "")
			{
				$this->intRowsPerPage = PAGESIZE;
			}
		}
		if(isset($_POST["txtcurrentpage"]))
		{
			$this->intCurrentPage = $_POST["txtcurrentpage"];
		}
		else
		{
			$this->intCurrentPage = 1;
		}		
		$this->intStartRecNo  =  (($this->intCurrentPage -1) * $this->intRowsPerPage) + 1;
		//_p($objCurrentObject);
		$this->intTotalRecords  =  mysql_num_rows($rsPg);
		if(intval($this->intTotalRecords/$this->intRowsPerPage) == $this->intTotalRecords/$this->intRowsPerPage)
		{
			$this->intPageSize = intval($this->intTotalRecords/$this->intRowsPerPage);
		}
		else
		{
			$this->intPageSize = intval($this->intTotalRecords/$this->intRowsPerPage) + 1;
		}
		if($this->intTotalRecords == 0)
		{
			$this->intPageSize = 1;
		}
		if ((intval($this->intCurrentPage)-1)<1)
		{
			$this->intPrevPage = $this->intCurrentPage;
		}
		else
		{
			$this->intPrevPage = intval($this->intCurrentPage)-1;
		}
		if ((intval($this->intCurrentPage)+1)>$this->intPageSize)
		{
			$this->intNextPage = $this->intCurrentPage;
		}
		else
		{
			$this->intNextPage = intval($this->intCurrentPage)+1;
		}
		if(mysql_num_rows($rsPg) > 0)
		{				
			//var_dump($this->intCurrentPage);
		
			if (($this->intStartRecNo-1)>mysql_num_rows($rsPg))
			{					
				$this->intCurrentPage  =  1;
				//mysql_data_seek($rsPg,10);
			}
			else 
				mysql_data_seek($rsPg,$this->intStartRecNo-1);
				
			$arRw =  array();
				
			$tmp = $this->intRowsPerPage;
			
			if(($this->intStartRecNo+$this->intRowsPerPage)>$this->intTotalRecords)
			{
				$tmp = ($this->intTotalRecords)-($this->intStartRecNo-1);				
			}
			
			for($i = 0;$i<$tmp;$i++)
			{
				$arRw[] = mysql_fetch_array($rsPg);
			}
		}
		else
		{
			$arRw =  array();
		} 
		
		return $arRw;
	}	
	
	function setPageDetailsNew($objCurrentObject,$page1,$intRowsPerPage1,$cond = "")
	{ 
		if(!empty($_POST["hdnorderby"]) && trim($_POST["hdnorderby"])!= "")
			$this->strorderby  =  trim($_POST["hdnorderby"]);

		if(!empty($_POST["hdnorder"]) && trim($_POST["hdnorder"])!= "")
			$this->strorder  =  trim($_POST["hdnorder"]);
			
		$this->page = $page1;
		$this->intRowsPerPage = $intRowsPerPage1;
		
		if(isset($_POST["txtpagesize"]))
		{
			$this->intRowsPerPage = $_POST["txtpagesize"];
		}
		else
		{
			if($this->intRowsPerPage == "")
			{
				$this->intRowsPerPage = PAGESIZE;
			}
		}
	
		if(isset($_POST["txtcurrentpage"]))
		{
			$this->intCurrentPage = $_POST["txtcurrentpage"];
		}
		else
		{
			$this->intCurrentPage = 1;
		}		
		
		$this->intStartRecNo =  (($this->intCurrentPage -1) * $this->intRowsPerPage) + 1;

		if (!empty($this->strorderby)) $strOrderBy  =  $this->strorderby . " " . $this->strorder;
		else $strOrderBy  =  "";
		
		//_p($objCurrentObject);
		if(!empty($strOrderBy))$rsPg = $objCurrentObject->fetchRecordSetNew("", $cond, $strOrderBy);
		else $rsPg = $objCurrentObject->fetchRecordSetNew("", $cond);
		
		$this->intTotalRecords  =  mysql_num_rows($rsPg);
		
		if(intval($this->intTotalRecords/$this->intRowsPerPage) == $this->intTotalRecords/$this->intRowsPerPage)
		{
			$this->intPageSize  =  intval($this->intTotalRecords/$this->intRowsPerPage);
		}
		else
		{
			$this->intPageSize = intval($this->intTotalRecords/$this->intRowsPerPage) + 1;
		}
		if($this->intTotalRecords == 0)
		{
			$this->intPageSize = 1;
		}
		if((intval($this->intCurrentPage)-1)<1)
		{
			$this->intPrevPage = $this->intCurrentPage;
		}
		else
		{
			$this->intPrevPage = intval($this->intCurrentPage)-1;
		}
		
		if((intval($this->intCurrentPage)+1)>$this->intPageSize)
		{
			$this->intNextPage = $this->intCurrentPage;
		}
		else
		{
			$this->intNextPage = intval($this->intCurrentPage)+1;
		}
		if(mysql_num_rows($rsPg) > 0)
		{				
			//var_dump($this->intCurrentPage);
			if (($this->intStartRecNo-1)>mysql_num_rows($rsPg))
			{					
				$this->intCurrentPage  =  1;
				//mysql_data_seek($rsPg,10);
			}
			else 
				mysql_data_seek($rsPg,$this->intStartRecNo-1);
			$arRw =  array();
			$tmp = $this->intRowsPerPage;
			if(($this->intStartRecNo+$this->intRowsPerPage)>$this->intTotalRecords)
			{
				$tmp = ($this->intTotalRecords)-($this->intStartRecNo-1);
			}
			for($i = 0;$i<$tmp;$i++)
			{
				$arRw[] = mysql_fetch_array($rsPg);
			}
		}
		else
		{
			$arRw =  array();
		} 
		
		return $arRw;
	}
	
	function setPageDetailsLatest($objCurrentObject,$page1,$intRowsPerPage1,$cond = "")
	{ 
		if(!empty($_POST["hdnorderby"]) && trim($_POST["hdnorderby"])!= "")
			$this->strorderby  =  trim($_POST["hdnorderby"]);

		if(!empty($_POST["hdnorder"]) && trim($_POST["hdnorder"])!= "")
			$this->strorder  =  trim($_POST["hdnorder"]);
			
		$this->page = $page1;
		$this->intRowsPerPage = $intRowsPerPage1;
		
		if(isset($_POST["txtpagesize"]))
		{
			$this->intRowsPerPage = $_POST["txtpagesize"];
		}
		else
		{
			if($this->intRowsPerPage == "")
			{
				$this->intRowsPerPage = PAGESIZE;
			}
		}
	
		if(isset($_POST["txtcurrentpage"]))
		{
			$this->intCurrentPage = $_POST["txtcurrentpage"];
		}
		else
		{
			$this->intCurrentPage = 1;
		}		
		
		$this->intStartRecNo =  (($this->intCurrentPage -1) * $this->intRowsPerPage) + 1;

		if (!empty($this->strorderby)) $strOrderBy  =  $this->strorderby . " " . $this->strorder;
		else $strOrderBy  =  "";
		
		//_p($objCurrentObject);
		if(!empty($strOrderBy))$rsPg = $objCurrentObject->fetchRecordSetNew("", $cond, $strOrderBy);
		else $rsPg = $objCurrentObject->fetchRecordSetLatest("", $cond);
		
		$this->intTotalRecords  =  mysql_num_rows($rsPg);
		
		if(intval($this->intTotalRecords/$this->intRowsPerPage) == $this->intTotalRecords/$this->intRowsPerPage)
		{
			$this->intPageSize  =  intval($this->intTotalRecords/$this->intRowsPerPage);
		}
		else
		{
			$this->intPageSize = intval($this->intTotalRecords/$this->intRowsPerPage) + 1;
		}
		
		if($this->intTotalRecords == 0)
		{
			$this->intPageSize = 1;
		}
		
		if ((intval($this->intCurrentPage)-1)<1)
		{
			$this->intPrevPage = $this->intCurrentPage;
		}
		else
		{
			$this->intPrevPage = intval($this->intCurrentPage)-1;
		}
		
		if ((intval($this->intCurrentPage)+1)>$this->intPageSize)
		{
			$this->intNextPage = $this->intCurrentPage;
		}
		else
		{
			$this->intNextPage = intval($this->intCurrentPage)+1;
		}
		
		if(mysql_num_rows($rsPg) > 0)
		{				
			//var_dump($this->intCurrentPage);
		
			if (($this->intStartRecNo-1)>mysql_num_rows($rsPg))
			{					
				$this->intCurrentPage  =  1;
				//mysql_data_seek($rsPg,10);
			}
			else 
				mysql_data_seek($rsPg,$this->intStartRecNo-1);
				
			$arRw =  array();
				
			$tmp = $this->intRowsPerPage;
			
			if(($this->intStartRecNo+$this->intRowsPerPage)>$this->intTotalRecords)
			{
				$tmp = ($this->intTotalRecords)-($this->intStartRecNo-1);				
			}
			
			for($i = 0;$i<$tmp;$i++)
			{
				$arRw[] = mysql_fetch_array($rsPg);
			}
		}
		else
		{
			$arRw =  array();
		} 
		
		return $arRw;
	}
	
	function setPageDetailsNewHaving($objCurrentObject,$page1,$intRowsPerPage1,$cond = "", $havingCond = "")
	{ 
		if(!empty($_POST["hdnorderby"]) && trim($_POST["hdnorderby"])!= "")
			$this->strorderby  =  trim($_POST["hdnorderby"]);

		if(!empty($_POST["hdnorder"]) && trim($_POST["hdnorder"])!= "")
			$this->strorder  =  trim($_POST["hdnorder"]);
			
		$this->page = $page1;
		$this->intRowsPerPage = $intRowsPerPage1;
		
		/*if(isset($_POST["txtpagesize"]))
		{
			$this->intRowsPerPage = $_POST["txtpagesize"];
		}
		else
		{
			if($this->intRowsPerPage == "")
			{
				$this->intRowsPerPage = PAGESIZEAJAX;
			}
		}*/
		
		if($this->intRowsPerPage == "")
		{
			$this->intRowsPerPage = PAGESIZEAJAX;
		}
	
		/*if(isset($_POST["txtcurrentpage"]))
		{
			$this->intCurrentPage = $_POST["txtcurrentpage"];
		}
		else
		{
			$this->intCurrentPage = 1;
		}	*/	
		
		if($this->intCurrentPage=='')
		{
			$this->intCurrentPage =1;
		}
		
		$this->intStartRecNo =  (($this->intCurrentPage -1) * $this->intRowsPerPage) + 1;

		if (!empty($this->strorderby)) $strOrderBy  =  $this->strorderby . " " . $this->strorder;
		else $strOrderBy  =  "";
		
		//_p($objCurrentObject);
		if(!empty($strOrderBy))$rsPg = $objCurrentObject->fetchRecordSetNew("", $cond, $havingCond, $strOrderBy);
		else $rsPg = $objCurrentObject->fetchRecordSetNew("", $cond, $havingCond);
		
		$this->intTotalRecords  =  mysql_num_rows($rsPg);
		
		if(intval($this->intTotalRecords/$this->intRowsPerPage) == $this->intTotalRecords/$this->intRowsPerPage)
		{
			$this->intPageSize  =  intval($this->intTotalRecords/$this->intRowsPerPage);
		}
		else
		{
			$this->intPageSize = intval($this->intTotalRecords/$this->intRowsPerPage) + 1;
		}
		
		if($this->intTotalRecords == 0)
		{
			$this->intPageSize = 1;
		}
		
		if ((intval($this->intCurrentPage)-1)<1)
		{
			$this->intPrevPage = $this->intCurrentPage;
		}
		else
		{
			$this->intPrevPage = intval($this->intCurrentPage)-1;
		}
		
		if ((intval($this->intCurrentPage)+1)>$this->intPageSize)
		{
			$this->intNextPage = $this->intCurrentPage;
		}
		else
		{
			$this->intNextPage = intval($this->intCurrentPage)+1;
		}
		
		if(mysql_num_rows($rsPg) > 0)
		{				
			//var_dump($this->intCurrentPage);
		
			if (($this->intStartRecNo-1)>mysql_num_rows($rsPg))
			{					
				$this->intCurrentPage  =  1;
				//mysql_data_seek($rsPg,10);
			}
			else 
				mysql_data_seek($rsPg,$this->intStartRecNo-1);
				
			$arRw =  array();
				
			$tmp = $this->intRowsPerPage;
			
			if(($this->intStartRecNo+$this->intRowsPerPage)>$this->intTotalRecords)
			{
				$tmp = ($this->intTotalRecords)-($this->intStartRecNo-1);				
			}
			
			for($i = 0;$i<$tmp;$i++)
			{
				$arRw[] = mysql_fetch_array($rsPg);
			}
		}
		else
		{
			$arRw =  array();
		} 
		
		return $arRw;
	}
	
	function setPageDetailsList($objCurrentObject,$page1,$intRowsPerPage1,$cond = "")
	{ 
		if(!empty($_POST["hdnorderby"]) && trim($_POST["hdnorderby"])!= "")
			$this->strorderby  =  trim($_POST["hdnorderby"]);

		if(!empty($_POST["hdnorder"]) && trim($_POST["hdnorder"])!= "")
			$this->strorder  =  trim($_POST["hdnorder"]);
			
		$this->page = $page1;
		$this->intRowsPerPage = $intRowsPerPage1;
		
		if(isset($_POST["txtpagesize"]))
		{
			$this->intRowsPerPage = $_POST["txtpagesize"];
		}
		else
		{
			if($this->intRowsPerPage == "")
			{
				$this->intRowsPerPage = PAGESIZE;
			}
		}
	
		if(isset($_POST["txtcurrentpage"]))
		{
			$this->intCurrentPage = $_POST["txtcurrentpage"];
		}
		else
		{
			$this->intCurrentPage = 1;
		}		
		
		$this->intStartRecNo =  (($this->intCurrentPage -1) * $this->intRowsPerPage) + 1;

		if (!empty($this->strorderby)) $strOrderBy  =  $this->strorderby . " " . $this->strorder;
		else $strOrderBy  =  "";
		
		//_p($objCurrentObject);
		if(!empty($strOrderBy))$rsPg = $objCurrentObject->fetchImportFileList("", $cond, $strOrderBy);
		else $rsPg = $objCurrentObject->fetchImportFileList("", $cond);
		
		$this->intTotalRecords  =  mysql_num_rows($rsPg);
		
		if(intval($this->intTotalRecords/$this->intRowsPerPage) == $this->intTotalRecords/$this->intRowsPerPage)
		{
			$this->intPageSize  =  intval($this->intTotalRecords/$this->intRowsPerPage);
		}
		else
		{
			$this->intPageSize = intval($this->intTotalRecords/$this->intRowsPerPage) + 1;
		}
		
		if($this->intTotalRecords == 0)
		{
			$this->intPageSize = 1;
		}
		
		if ((intval($this->intCurrentPage)-1)<1)
		{
			$this->intPrevPage = $this->intCurrentPage;
		}
		else
		{
			$this->intPrevPage = intval($this->intCurrentPage)-1;
		}
		
		if ((intval($this->intCurrentPage)+1)>$this->intPageSize)
		{
			$this->intNextPage = $this->intCurrentPage;
		}
		else
		{
			$this->intNextPage = intval($this->intCurrentPage)+1;
		}
		
		if(mysql_num_rows($rsPg) > 0)
		{				
			//var_dump($this->intCurrentPage);
		
			if (($this->intStartRecNo-1)>mysql_num_rows($rsPg))
			{					
				$this->intCurrentPage  =  1;
				//mysql_data_seek($rsPg,10);
			}
			else 
				mysql_data_seek($rsPg,$this->intStartRecNo-1);
				
			$arRw =  array();
				
			$tmp = $this->intRowsPerPage;
			
			if(($this->intStartRecNo+$this->intRowsPerPage)>$this->intTotalRecords)
			{
				$tmp = ($this->intTotalRecords)-($this->intStartRecNo-1);				
			}
			
			for($i = 0;$i<$tmp;$i++)
			{
				$arRw[] = mysql_fetch_array($rsPg);
			}
		}
		else
		{
			$arRw =  array();
		} 
		
		return $arRw;
	}
	
	function setHidden()
	{
		print "<input type = \"hidden\" name = \"txtcurrentpage\" value = \"" . $this->intCurrentPage ."\">";
		print "<input type = \"hidden\" name = \"txtpageno1\" value = \"" .$this->intCurrentPage ."\">";
		print "<input type = \"hidden\" name = \"txtpagesize\" value = \"" . $this->intRowsPerPage ."\">";
		print "<input type = \"hidden\" name = \"txtSort\" value = \"" . $this->_strSort ."\">";
			
	}
	
	function drawPanel($frm = "frm",$height = "20",$cssTextbox = "textbox",$cssFont = "tahoma11grays",$cssLine = "doline")
	{
		$strNextButton 	 =  "";
		$strLastButton 	 =  "";
		$strPrevPage	 =  "";
		$strFirstPage	 =  "";
		$strPage		 =  "";
		
		if (intval($this->intCurrentPage)  ==  1)
		{
			$strPrevPage   = "<td><img src = \"".SERVER_ADMIN_HOST."images/arrow_back_disabled.gif\" alt = \"Previous\" title = \"Previous\" align = \"absmiddle\" border = \"0\"></td>";
			$strFirstPage  = "<td><img src = \"".SERVER_ADMIN_HOST."images/arrow_first_1_disabled.gif\" alt = \"First\" title = \"First\" align = \"absmiddle\" border = \"0\"></td>";
		}
		else
		{
			$strPrevPage   = "<td><a href = \"Javascript:_" . $frm ."_changepage('". $this->intPrevPage ."');\"><img src = \"".SERVER_ADMIN_HOST."images/arrow_back.gif\" alt = \"Previous\" title = \"Previous\" align = \"absmiddle\" border = \"0\" ></a></td>";
			$strFirstPage  = "<td><a href = \"Javascript:_" . $frm ."_changepage('1');\"><img src = \"".SERVER_ADMIN_HOST."images/arrow_first_1.gif\" alt = \"First\" title = \"First\" align = \"absmiddle\" border = \"0\"></a></td>";
		}
		if ((intval($this->intCurrentPage)*intval($this->intRowsPerPage) >=  intval($this->intTotalRecords)))
		{
			$strNextButton  = "<td><img src = \"".SERVER_ADMIN_HOST."images/arrow_next_disabled.gif\" alt = \"Next\" title = \"Next\" align = \"absmiddle\" border = \"0\"></td>";
			$strLastButton  = "<td><img src = \"".SERVER_ADMIN_HOST."images/arrow_last_1_disabled.gif\" alt = \"Last\" title = \"Last\" align = \"absmiddle\" border = \"0\"></td>";
		}
		else 
		{
			$strNextButton  = "<td><a href = \"Javascript:_" . $frm ."_changepage('" .$this->intNextPage ."');\"><img src = \"".SERVER_ADMIN_HOST."images/arrow_next.gif\" alt = \"Next\" title = \"Next\" align = \"absmiddle\" border = \"0\"  ></a></td>";
			$strLastButton  = "<td><a href = \"Javascript:_" . $frm ."_changepage('" . intval($this->intPageSize) . "');\"><img src = \"".SERVER_ADMIN_HOST."images/arrow_last_1.gif\" align = \"absmiddle\" alt = \"Last\" title = \"Last\" border = \"0\"></a></td>";
		}
		$intSelectedPageSize  =  "";
		
		$pagesizearray  =  array (10,20,50,75,100,150);
		
		$intSelectedPageSize  =  "<td> <select class = \"paging-select\" onChange = \"Javascript:_" . $frm ."_changepagesize(this.value);\" name = \"txtpagesize\" class = \"". $cssTextbox ."\" maxlength = '3'> ";

		foreach($pagesizearray as $key =>$value)
		{			
			$intSelectedPageSize .=  "<option value = '$value' ";
			
			if ($value  ==  $this->intRowsPerPage) 
				$intSelectedPageSize .=  "selected = \"selected\"";
			
			$intSelectedPageSize .=  ">$value</option>";	
			
		}
		
		$intSelectedPageSize .=  "</select>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
		
		$this->printJScript($frm);
		$strPage .= "<table class = \"tbl-noborder msg-table\"><tr><td>".LANG_RECORD_PER_PAGE.":</td>";
		$strPage .= 	$intSelectedPageSize;
		$strPage .=  $strFirstPage;
		$strPage .=  $strPrevPage;
		$strPage .= "<td>&nbsp;&nbsp;".LANG_PAGE_TEXT." ". $this->intCurrentPage . " ".LANG_OF_TEXT." ". $this->intPageSize . "&nbsp;&nbsp;</td>";
		$strPage .=  $strNextButton;
		$strPage .=  $strLastButton;
		$strPage .= "<td>&nbsp;&nbsp;&nbsp;&nbsp;".LANG_GOTO_PAGE_TEXT.":</td>";
		$strPage .= "<td><input name = \"txtpageno\" type = \"text\" class = \"paging-textbox\" style = \"width:34px;height:15px;\" maxlength = '5'>&nbsp;&nbsp;</td>";
		$strPage .= "<td><a href = \"Javascript:_" . $frm ."_GotoPage('-1');\"><img src = \"".SERVER_ADMIN_HOST."images/go.gif\" alt = \"Go!\" title = \"Go!\" align = \"absmiddle\" border = \"0\"></a>";
				
		$strPage .= "		" . $this->strHiddenvars ."";
		$strPage .= "		<input type = \"hidden\" name = \"txtcurrentpage\" value = \"". $this->intCurrentPage ."\">";
		$strPage .= "		<input type = \"hidden\" name = \"txtpageno1\" value = \"".$this->intCurrentPage ."\">";
		$strPage .= "		<input name = \"txtSearchText\" type = \"hidden\" id = \"txtSearchText1\" value = \"". $this->txtSearchText ."\">";
		$strPage .= "		<input type = \"hidden\" name = \"txtSort\" value = \"" .$this->_strSort ."\">";
		$strPage .= "		<input type = \"hidden\" name = \"hdnorderby\" value = \"" .$this->strorderby ."\">";
		$strPage .= "		<input type = \"hidden\" name = \"hdnorder\" value = \"" .$this->strorder ."\">";
		$strPage .= "		<script language = \"javascript\" type = \"text/javascript\">". $this->strHiddenScripts . "</script></td></tr></table>";
//		$strPage .= "	</form> ";
			
		return $strPage;
	}
	
	
	function drawPanelAJAX($frm = "frm",$height = "20",$cssTextbox = "textbox",$cssFont = "tahoma11grays",$cssLine = "doline")
	{	
		$strNextButton 	 =  "";
		$strLastButton 	 =  "";
		$strPrevPage	 =  "";
		$strFirstPage	 =  "";
		$strPage		 =  "";
		
		$contest_id = $_REQUEST['contest_id'];
		$isSubmit = $_REQUEST['isSubmit'];
		
		$txtsortby = $_REQUEST['hdnorderby'];
		$txtsorting = $_REQUEST['hdnorder'];
		$txtpagesize = $_REQUEST['txtpagesize'];
		
		$urlAJAX2 = "";
		if(isset($_REQUEST['pageVal']) && $_REQUEST['pageVal']==1)
		{
			$seluser_type_id = $_REQUEST['seluser_type_id'];
			$txtsearchname = $_REQUEST['txtsearchname'];
			$serachBy = $_REQUEST['serachBy'];
			$selected = $_REQUEST['selected'];
		
			$urlAJAX = 'search_audience_ajax.php?contest_id='.$contest_id.'&isSubmit='.$isSubmit.'&txtsearchname='.$txtsearchname.'&serachBy='.$serachBy.'&hdnorderby='.$txtsortby.'&selected='.$selected.'&seluser_type_id='.$seluser_type_id.'&pageVal=1&hdnorder='.$txtsorting.'&txtpagesize='.$txtpagesize;
		}
		elseif(isset($_REQUEST['pageVal']) && $_REQUEST['pageVal']==2)
		{
			$selected = $_REQUEST['selected'];
			$urlAJAX = 'search_audience_selected_ajax.php?contest_id='.$contest_id.'&isSubmit='.$isSubmit.'&hdnorderby='.$txtsortby.'&pageVal=2&hdnorder='.$txtsorting.'&selected='.$selected.'&txtpagesize='.$txtpagesize;
			$urlAJAX2 = 'search_audience_selected_ajax.php?contest_id='.$contest_id.'&isSubmit='.$isSubmit.'&hdnorderby='.$txtsortby.'&pageVal=2&hdnorder='.$txtsorting.'&selected='.$selected.'&txtpagesize='.$txtpagesize;
		}
		elseif(isset($_REQUEST['pageVal']) && $_REQUEST['pageVal']==3)
		{
			$seluser_type_id = $_REQUEST['seluser_type_id'];
			$txtsearchname = $_REQUEST['txtsearchname'];
			$serachBy = $_REQUEST['serachBy'];
			$selected = $_REQUEST['selected'];
		
			$urlAJAX = 'search_target_audience_ajax.php?contest_id='.$contest_id.'&isSubmit='.$isSubmit.'&txtsearchname='.$txtsearchname.'&serachBy='.$serachBy.'&hdnorderby='.$txtsortby.'&selected='.$selected.'&seluser_type_id='.$seluser_type_id.'&pageVal=3&hdnorder='.$txtsorting.'&txtpagesize='.$txtpagesize;
		}
		else
		{
			$seljudge_round_id = $_REQUEST['seljudge_round_id'];
			$selscore_type = $_REQUEST['selscore_type'];
			$txtscoreval = $_REQUEST['txtscoreval'];
			$txtsearchname = $_REQUEST['txtsearchname'];
			$serachBy = $_REQUEST['serachBy'];
			
			$urlAJAX = 'search_winner_ajax.php?contest_id='.$contest_id.'&isSubmit='.$isSubmit.'&seljudge_round_id='.$seljudge_round_id.'&txtsearchname='.$txtsearchname.'&selscore_type='.$selscore_type.'&txtscoreval='.$txtscoreval.'&serachBy='.$serachBy.'&hdnorderby='.$txtsortby.'&hdnorder='.$txtsorting.'&txtpagesize='.$txtpagesize;
		}
		
		if (intval($this->intCurrentPage)  ==  1)
		{
			$strPrevPage   = "<td><img src = \"".SERVER_ADMIN_HOST."images/arrow_back_disabled.gif\" alt = \"Previous\" title = \"Previous\" align = \"absmiddle\" border = \"0\"></td>";
			$strFirstPage  = "<td><img src = \"".SERVER_ADMIN_HOST."images/arrow_first_1_disabled.gif\" alt = \"First\" title = \"First\" align = \"absmiddle\" border = \"0\"></td>";
		}
		else
		{
			$strPrevPage   = "<td><a href = \"Javascript:_" . $frm ."_changepage('". $this->intPrevPage ."','".$urlAJAX."&txtcurrentpage=" .$this->intPrevPage ."');\"><img src = \"".SERVER_ADMIN_HOST."images/arrow_back.gif\" alt = \"Previous\" title = \"Previous\" align = \"absmiddle\" border = \"0\" ></a></td>";
			$strFirstPage  = "<td><a href = \"Javascript:_" . $frm ."_changepage('1','".$urlAJAX."&txtcurrentpage=1');\"><img src = \"".SERVER_ADMIN_HOST."images/arrow_first_1.gif\" alt = \"First\" title = \"First\" align = \"absmiddle\" border = \"0\"></a></td>";
		}
		if ((intval($this->intCurrentPage)*intval($this->intRowsPerPage) >=  intval($this->intTotalRecords)))
		{
			$strNextButton  = "<td><img src = \"".SERVER_ADMIN_HOST."images/arrow_next_disabled.gif\" alt = \"Next\" title = \"Next\" align = \"absmiddle\" border = \"0\"></td>";
			$strLastButton  = "<td><img src = \"".SERVER_ADMIN_HOST."images/arrow_last_1_disabled.gif\" alt = \"Last\" title = \"Last\" align = \"absmiddle\" border = \"0\"></td>";
		}
		else 
		{
			$strNextButton  = "<td><a href = \"Javascript:_" . $frm ."_changepage('" .$this->intNextPage ."','".$urlAJAX."&txtcurrentpage=" .$this->intNextPage ."');\"><img src = \"".SERVER_ADMIN_HOST."images/arrow_next.gif\" alt = \"Next\" title = \"Next\" align = \"absmiddle\" border = \"0\"  ></a></td>";
			$strLastButton  = "<td><a href = \"Javascript:_" . $frm ."_changepage('" . intval($this->intPageSize) . "','".$urlAJAX."&txtcurrentpage=" .$this->intPageSize ."');\"><img src = \"".SERVER_ADMIN_HOST."images/arrow_last_1.gif\" align = \"absmiddle\" alt = \"Last\" title = \"Last\" border = \"0\"></a></td>";
		}
		$intSelectedPageSize  =  "";
		
		$pagesizearray  =  array (5,10,20,40,80,120);
		
		
		$intSelectedPageSize  =  "<td>";
		
		if($frm=="panel1")
		{
			$intSelectedPageSize.=  "<input type='hidden' name='txtPassedURL' id='txtPassedURL' value=".$urlAJAX." />";
		}
		else
		{
			$intSelectedPageSize.=  "<input type='hidden' name='txtPassedURL2' id='txtPassedURL2' value=".$urlAJAX2." />";
		}
		$intSelectedPageSize.=  "<select class = \"paging-select\" onChange = \"Javascript:_" . $frm ."_changepagesize(this.value);\" name = \"txtpagesize\" class = \"". $cssTextbox ."\" maxlength = '3'> ";

		foreach($pagesizearray as $key =>$value)
		{			
			$intSelectedPageSize .=  "<option value = '$value' ";
			
			if ($value  ==  $this->intRowsPerPage) 
				$intSelectedPageSize .=  "selected = \"selected\"";
			
			$intSelectedPageSize .=  ">$value</option>";	
			
		}
		
		$intSelectedPageSize .=  "</select>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
		
		$this->printJScriptAJAX($frm,$urlAJAX);
		$strPage .= "<table class = \"tbl-noborder msg-table\"><tr><td>Records per page:</td>";
		$strPage .= 	$intSelectedPageSize;
		$strPage .=  $strFirstPage;
		$strPage .=  $strPrevPage;
		$strPage .= "<td>&nbsp;&nbsp;Page ". $this->intCurrentPage . " of ". $this->intPageSize . "&nbsp;&nbsp;</td>";
		$strPage .=  $strNextButton;
		$strPage .=  $strLastButton;
		$strPage .= "<td>&nbsp;&nbsp;&nbsp;&nbsp;Goto page:</td>";
		$strPage .= "<td><input name = \"txtpageno\" id = \"txtpageno\" type = \"text\" class = \"paging-textbox\" style = \"width:34px;height:15px;\" maxlength = '5'></td>";
		$strPage .= "<td>&nbsp;&nbsp;<a href = \"Javascript:_" . $frm ."_GotoPage('-1');\"><img src = \"".SERVER_ADMIN_HOST."images/go.gif\" alt = \"Go!\" title = \"Go!\" align = \"absmiddle\" border = \"0\"></a>";
				
		$strPage .= "		" . $this->strHiddenvars ."";
		$strPage .= "		<input type = \"hidden\" name = \"txtcurrentpage\" value = \"". $this->intCurrentPage ."\">";
		$strPage .= "		<input type = \"hidden\" name = \"txtpageno1\" value = \"".$this->intCurrentPage ."\">";
		$strPage .= "		<input name = \"txtSearchText\" type = \"hidden\" id = \"txtSearchText1\" value = \"". $this->txtSearchText ."\">";
		$strPage .= "		<input type = \"hidden\" name = \"txtSort\" value = \"" .$this->_strSort ."\">";
		$strPage .= "		<input type = \"hidden\" name = \"hdnorderby\" value = \"" .$this->strorderby ."\">";
		$strPage .= "		<input type = \"hidden\" name = \"hdnorder\" value = \"" .$this->strorder ."\">";
		$strPage .= "		<script language = \"javascript\" type = \"text/javascript\">". $this->strHiddenScripts . "</script></td></tr></table>";
//		$strPage .= "	</form> ";
			
		return $strPage;

	}
	
	
	function printJScriptAJAX($frm,$urlAJAX)
	{
		if($frm=="panel2")
		{
			$divId = "selectedUsersResult";
			$elementId = "txtPassedURL2";
		}
		else
		{
			$divId = "ajaxBasedList";
			$elementId = "txtPassedURL";
		}

		$strJScript = "<script language = \"javascript\">
		function _" . $frm ."_setpagesize()
		{
			//alert(\"sss\");
			if (document." . $frm .".txtpagesize.value < 1)
			{
				alert(\"You are requested to enter a non decimal numeric value grater than 0.\");
				document." . $frm .".txtpagesize.value = '". $this->intPageSize ."';
				document." . $frm .".txtpagesize.focus();
				return false;
			}
			if (!checkInt(document." . $frm .".txtpagesize.value))
			{
				document." . $frm .".txtpagesize.value = '".$this->intPageSize ."';
				document." . $frm .".txtpagesize.focus();
				alert(\"You are requested to enter numeric value.\");
				document." . $frm .".txtpagesize.focus();
				return false;
			}
		
			document." . $frm .".action = \"". $this->page ."\";
			document." . $frm .".submit();
		}
		
		function _" . $frm ."_changepagesize(val)
		{						
			passedURL = document.getElementById('".$elementId."').value+'&txtpagesize='+val;
			//document.frm.txtcurrentpage.value  =  1;
			//document.frm.action = \"". $this->page ."\";
			
			$('#".$divId."').load(passedURL);
			//document.frm.submit();
		}
		
		function _" . $frm ."_changepage(a,passedURL)
		{
			//alert(a);
			//if(_" . $frm ."_chkpgsize())
			{
					document.frm.txtcurrentpage.value = a;
					if (a == -1) 
					{
						document.frm.txtcurrentpage.value = document.frm.txtpageno.value;
					}
					
					//document.frm.action = \"". $this->page ."\";
					$('#".$divId."').load(passedURL);
					//document.frm.submit();
			}
		}
		
		function _" . $frm ."_GotoPage(a)
		{
			if(_" . $frm ."_chkpgsize())
			{
				passedURL = document.getElementById('".$elementId."').value+'&txtcurrentpage='+document.getElementById('txtpageno').value;
				if(document.frm.txtpageno.value <=  ". $this->intPageSize ." && document.frm.txtpageno.value>0)
				{
					document.frm.txtcurrentpage.value = a;
					if (a == -1) 
					{
						document.frm.txtcurrentpage.value = document.frm.txtpageno.value;
					}
					
					$('#".$divId."').load(passedURL);
					//document.frm.action = \"" . $this->page ."\";
					//document.frm.submit();
				}
				else
				{
					alert(\"Please enter proper page number.\");
				}
			}
		}
		
		function _" . $frm ."_intDigits()
		{
			if(event.keyCode>= 48 && event.keyCode <=  57) {}
			else
			{	event.keyCode = 0;	}
		}
		
		function _" . $frm ."_trim(tmp)
		{
			//var temp;
			temp  =  tmp;
			//tmp  =  \"      this is test     \";
			pat  =  /^\s+/;
			temp  =  temp.replace(pat, \"\");
			pat  =  /\s+$/;
			temp  =  temp.replace(pat, \"\");
			//alert(\":\" + tmp + \":\");
			return temp;
		}

		function _" . $frm ."_chkpgsize()
		{
			//var flg = false;
			if(_" . $frm ."_trim(document.frm.txtpagesize.value).length>0)
			{
				if(parseInt(_" . $frm ."_trim(document.frm.txtpagesize.value))>0)
				{
					flg = true;
				}else
				{
					alert(\"Records per page can not be zero or less than zero.\");
					document." . $frm .".txtpagesize.focus();
				}
			
			}else
			{
				alert(\"Please enter No. of Records per page.\")
			}
			
			return flg;
		}
		function go(a,b,action,passedURL)
		{
			
			if (b !=  'go')
			{
				if ( a !=  'nothing' && a !=  '' )
				{ 
					document.frm.hdnorderby.value  =  a;
					document.frm.hdnorder.value  =  b;	
				}
			}
			
			if (b  ==  'go')
			{
			} 

			$('#".$divId."').load(passedURL);	
			//document.frm.action = action;
			//document.frm.target = '_self';
			//document.frm.submit();
		}
		function goAJAX1(a,b,action,passedURL)
		{
			
			if (b !=  'go')
			{
				if ( a !=  'nothing' && a !=  '' )
				{ 
					document.frm.hdnorderby.value  =  a;
					document.frm.hdnorder.value  =  b;	
				}
			}
			
			if (b  ==  'go')
			{
			} 
		
			$('#ajaxBasedList').load(passedURL);	
			//document.frm.action = action;
			//document.frm.target = '_self';
			//document.frm.submit();
		}
		function goAJAX(a,b,action,passedURL)
		{
			
			if (b !=  'go')
			{
				if ( a !=  'nothing' && a !=  '' )
				{ 
					document.frm.hdnorderby.value  =  a;
					document.frm.hdnorder.value  =  b;	
				}
			}
			
			if (b  ==  'go')
			{
			} 
		
			$('#selectedUsersResult').load(passedURL);	
			//document.frm.action = action;
			//document.frm.target = '_self';
			//document.frm.submit();
		}
		
		</script>";
		
		print $strJScript;
	
	}
	
	
	function drawPanelNew($frm = "frm",$height = "20",$cssTextbox = "textbox",$cssFont = "tahoma11grays",$cssLine = "doline")
	{
		$strNextButton 	 =  "";
		$strLastButton 	 =  "";
		$strPrevPage	 =  "";
		$strFirstPage	 =  "";
		$strPage		 =  "";
		
		if (intval($this->intCurrentPage)  ==  1)
		{
			$strPrevPage   = "		<td width = \"14\"><img src = \"admin/images/icons/arrow_left_disabled.gif\" alt = \"Previous\" border = \"0\"></td>";
			$strFirstPage  = "		<td width = \"14\"><img src = \"admin/images/icons/arrow_first_disabled.gif\" alt = \"First\" border = \"0\"></td>";
		}
		else
		{
			$strPrevPage   = "		<td width = \"14\"><a href = \"Javascript:_" . $frm ."_changepage('". $this->intPrevPage ."');\"><img src = \"admin/images/icons/arrow_first.gif\" alt = \"Previous\" border = \"0\" ></a></td>";
			$strFirstPage  = "		<td width = \"14\"><a href = \"Javascript:_" . $frm ."_changepage('1');\"><img src = \"admin/images/icons/tostart.gif\" alt = \"First\" border = \"0\"></a></td>";
		}
		if ((intval($this->intCurrentPage)*intval($this->intRowsPerPage) >=  intval($this->intTotalRecords)))
		{
			$strNextButton  = "		<td width = \"14\"><img src = \"admin/images/icons/arrow_right_disabled.gif\" alt = \"Next\" border = \"0\"></td>";
			$strLastButton  = "		<td width = \"14\"><img src = \"admin/images/icons/arrow_last_disabled.gif\" alt = \"Last\" border = \"0\"></td>";
		}
		else 
		{
			$strNextButton  = "		<td width = \"14\"><a href = \"Javascript:_" . $frm ."_changepage('" .$this->intNextPage ."');\"><img src = \"admin/images/icons/arrow_right.gif\" alt = \"Next\" border = \"0\"  ></a></td>";
			$strLastButton  = "		<td width = \"14\"><a href = \"Javascript:_" . $frm ."_changepage('" . intval($this->intPageSize) . "');\"><img src = \"admin/images/icons/arrow_last.gif\" alt = \"Last\" border = \"0\"></a></td>";
		}
		$intSelectedPageSize  =  "";
		
		$pagesizearray  =  array (10,20,50,75,100);
		
		$intSelectedPageSize  =  " <select class = \"txtbox\" onChange = \"Javascript:_" . $frm ."_changepagesize(this.value);\" name = \"txtpagesize\" class = \"". $cssTextbox ."\" maxlength = '3'> ";

		foreach($pagesizearray as $key =>$value)
		{			
			$intSelectedPageSize .=  "<option value = '$value' ";
			
			if ($value  ==  $this->intRowsPerPage) 
				$intSelectedPageSize .=  "selected = \"selected\"";
			
			$intSelectedPageSize .=  ">$value</option>";	
			
		}
		
		$intSelectedPageSize .=  "</select>";
		
		$this->printJScript($frm);
		$strPage .= "<table class = \"tblpaging\" border = \"0\" cellspacing = \"0\" cellpadding = \"0\">";
		$strPage .= "	<tr>";
	    $strPage .= "    <td height = \"". $height ."\" class = \"" .$cssLine . "\">";
		$strPage .= "	<table  border = \"0\" align = \"center\" cellpadding = \"0\" cellspacing = \"4\">";
		$strPage .= "	  <tr>";
		$strPage .= "		<td width = \"200\" align = \"left\">";

		$strPage .= "<table  border = \"0\" cellspacing = \"0\" cellpadding = \"0\">";
		$strPage .= "	<tr>";
		$strPage .= "		<td align = \"right\">Records per page:&nbsp;&nbsp;";
		$strPage .= 		$intSelectedPageSize;
		$strPage .= "	<tr>";
		$strPage .= "	</table>";
		
		$strPage .= "		</td>";
		$strPage .=  $strFirstPage;
		$strPage .=  $strPrevPage;
		$strPage .= "		<td width = \"141\" align = \"center\" valign = \"middle\" class = \"". $cssFont ."\">Page ". $this->intCurrentPage . " of ". $this->intPageSize . " </td>";
		$strPage .=  $strNextButton;
		$strPage .=  $strLastButton;
		$strPage .= "		<td width = \"70\" align = \"right\" class = \"". $cssFont ."\">Goto page:&nbsp;&nbsp;</td>";
		$strPage .= "		<td width = \"36\"><input name = \"txtpageno\" type = \"text\" class = \"txtbox\" style = \"width:34px;height:15px;\" maxlength = '5'></td>";
		$strPage .= "		<td width = \"20\"><a href = \"Javascript:_" . $frm ."_GotoPage('-1');\"><img src = \"admin/images/icons/arrow_right.gif\" alt = \"Go!\" border = \"0\"></a></td>";
		$strPage .= "	  </tr>";
		$strPage .= "	</table>";
				
		$strPage .= "		" . $this->strHiddenvars ."";
		$strPage .= "		<input type = \"hidden\" name = \"txtcurrentpage\" value = \"". $this->intCurrentPage ."\">";
		$strPage .= "		<input type = \"hidden\" name = \"txtpageno1\" value = \"".$this->intCurrentPage ."\">";
		$strPage .= "		<input name = \"txtSearchText\" type = \"hidden\" id = \"txtSearchText1\" value = \"". $this->txtSearchText ."\">";
		$strPage .= "		<input type = \"hidden\" name = \"txtSort\" value = \"" .$this->_strSort ."\">";
		$strPage .= "		<input type = \"hidden\" name = \"hdnorderby\" value = \"" .$this->strorderby ."\">";
		$strPage .= "		<input type = \"hidden\" name = \"hdnorder\" value = \"" .$this->strorder ."\">";
		$strPage .= "		<script language = \"javascript\" type = \"text/javascript\">". $this->strHiddenScripts . "</script>";
		$strPage .= "	</td> </tr> </table>";
			
		return $strPage;
	}
	
	function printJScript($frm)
	{
		$strJScript = "<script language = \"javascript\">
		function _" . $frm ."_setpagesize()
		{
			//alert(\"sss\");
			if (document." . $frm .".txtpagesize.value < 1)
			{
				alert(\"You are requested to enter a non decimal numeric value grater than 0.\");
				document." . $frm .".txtpagesize.value = '". $this->intPageSize ."';
				document." . $frm .".txtpagesize.focus();
				return false;
			}
			if (!checkInt(document." . $frm .".txtpagesize.value))
			{
				document." . $frm .".txtpagesize.value = '".$this->intPageSize ."';
				document." . $frm .".txtpagesize.focus();
				alert(\"You are requested to enter numeric value.\");
				document." . $frm .".txtpagesize.focus();
				return false;
			}
		
			document." . $frm .".action = \"". $this->page ."\";
			document." . $frm .".submit();
		}
		
		function _" . $frm ."_changepagesize()
		{						
			document.frm.txtcurrentpage.value  =  1;
			document.frm.action = \"". $this->page ."\";
			document.frm.submit();
		}
		
		function _" . $frm ."_changepage(a)
		{
			//alert(a);
			//if(_" . $frm ."_chkpgsize())
			{
					document.frm.txtcurrentpage.value = a;
					if (a == -1) 
					{
						document.frm.txtcurrentpage.value = document.frm.txtpageno.value;
					}
					
					document.frm.action = \"". $this->page ."\";
					document.frm.submit();
			}
		}
		
		function _" . $frm ."_GotoPage(a)
		{
			if(_" . $frm ."_chkpgsize())
			{

				if(document.frm.txtpageno.value <=  ". $this->intPageSize ." && document.frm.txtpageno.value>0)
				{
					document.frm.txtcurrentpage.value = a;
					if (a == -1) 
					{
						document.frm.txtcurrentpage.value = document.frm.txtpageno.value;
					}
					document.frm.action = \"" . $this->page ."\";
					document.frm.submit();
				}
				else
				{
					alert(\"Please enter proper page number.\");
				}
			}
		}
		
		function _" . $frm ."_intDigits()
		{
			if(event.keyCode>= 48 && event.keyCode <=  57) {}
			else
			{	event.keyCode = 0;	}
		}
		
		function _" . $frm ."_trim(tmp)
		{
			//var temp;
			temp  =  tmp;
			//tmp  =  \"      this is test     \";
			pat  =  /^\s+/;
			temp  =  temp.replace(pat, \"\");
			pat  =  /\s+$/;
			temp  =  temp.replace(pat, \"\");
			//alert(\":\" + tmp + \":\");
			return temp;
		}

		function _" . $frm ."_chkpgsize()
		{
			//var flg = false;
			if(_" . $frm ."_trim(document.frm.txtpagesize.value).length>0)
			{
				if(parseInt(_" . $frm ."_trim(document.frm.txtpagesize.value))>0)
				{
					flg = true;
				}else
				{
					alert(\"Records per page can not be zero or less than zero.\");
					document." . $frm .".txtpagesize.focus();
				}
			
			}else
			{
				alert(\"Please enter No. of Records per page.\")
			}
			
			return flg;
		}
		function go(a,b,action)
		{
			
			if (b !=  'go')
			{
				if ( a !=  'nothing' && a !=  '' )
				{ 
					document.frm.hdnorderby.value  =  a;
					document.frm.hdnorder.value  =  b;	
				}
			}
			
			if (b  ==  'go')
			{
			}	
			document.frm.action = action;
			//document.frm.target = '_self';
			document.frm.submit();
		}
		
		</script>";
		
		print $strJScript;
	
	}
	
	function _sortImagesAJAX($colname, $strActionFile)
	{	
		$colname  =  strtolower(trim($colname));
		
		if (!empty($_POST['hdnorderby']))	$sortcolumn  =  $_POST['hdnorderby'];
		else 								$sortcolumn  =  "";
		
		if (!empty($_POST['hdnorder']))		$sortorder  =  $_POST['hdnorder'];
		else 								$sortorder  =  "";
		

		//For Default Sort column & sort order
		if (!empty($this->strorderby)) $sortcolumn  =  $this->strorderby;
		
		if (!empty($this->strorder)) $sortorder  =  $this->strorder;

		$contest_id = $_REQUEST['contest_id'];
		$isSubmit = $_REQUEST['isSubmit'];
		
		
		$txtsortby = $_REQUEST['hdnorderby'];
		$txtsorting = $_REQUEST['hdnorder'];
		$txtpagesize = $_REQUEST['txtpagesize'];
		
		if(isset($_REQUEST['pageVal']) && $_REQUEST['pageVal']==1)
		{
			$seluser_type_id = $_REQUEST['seluser_type_id'];
			$txtsearchname = $_REQUEST['txtsearchname'];
			$serachBy = $_REQUEST['serachBy'];
			$selected = $_REQUEST['selected'];
			
			$urlAJAXAsc = 'search_audience_ajax.php?contest_id='.$contest_id.'&isSubmit='.$isSubmit.'&txtsearchname='.$txtsearchname.'&serachBy='.$serachBy.'&pageVal=1&seluser_type_id='.$seluser_type_id.'&hdnorderby='.$colname.'&txtsortby='.$txtsortby.'&txtsorting='.$txtsorting.'&txtpagesize='.$txtpagesize.'&selected='.$selected.'&hdnorder=asc';
			$urlAJAXDesc = 'search_audience_ajax.php?contest_id='.$contest_id.'&isSubmit='.$isSubmit.'&txtsearchname='.$txtsearchname.'&serachBy='.$serachBy.'&pageVal=1&seluser_type_id='.$seluser_type_id.'&hdnorderby='.$colname.'&txtsortby='.$txtsortby.'&txtsorting='.$txtsorting.'&txtpagesize='.$txtpagesize.'&selected='.$selected.'&hdnorder=desc';
		}
		elseif(isset($_REQUEST['pageVal']) && $_REQUEST['pageVal']==3)
		{
			$seluser_type_id = $_REQUEST['seluser_type_id'];
			$txtsearchname = $_REQUEST['txtsearchname'];
			$serachBy = $_REQUEST['serachBy'];
			$selected = $_REQUEST['selected'];
			
			$urlAJAXAsc = 'search_target_audience_ajax.php?contest_id='.$contest_id.'&isSubmit='.$isSubmit.'&txtsearchname='.$txtsearchname.'&serachBy='.$serachBy.'&pageVal=3&seluser_type_id='.$seluser_type_id.'&hdnorderby='.$colname.'&txtsortby='.$txtsortby.'&txtsorting='.$txtsorting.'&txtpagesize='.$txtpagesize.'&selected='.$selected.'&hdnorder=asc';
			$urlAJAXDesc = 'search_target_audience_ajax.php?contest_id='.$contest_id.'&isSubmit='.$isSubmit.'&txtsearchname='.$txtsearchname.'&serachBy='.$serachBy.'&pageVal=3&seluser_type_id='.$seluser_type_id.'&hdnorderby='.$colname.'&txtsortby='.$txtsortby.'&txtsorting='.$txtsorting.'&txtpagesize='.$txtpagesize.'&selected='.$selected.'&hdnorder=desc';
		}
		else
		{
			$seljudge_round_id = $_REQUEST['seljudge_round_id'];
			$selscore_type = $_REQUEST['selscore_type'];
			$txtscoreval = $_REQUEST['txtscoreval'];
			$txtsearchname = $_REQUEST['txtsearchname'];
			$serachBy = $_REQUEST['serachBy'];
		
			$urlAJAXAsc = 'search_winner_ajax.php?contest_id='.$contest_id.'&isSubmit='.$isSubmit.'&seljudge_round_id='.$seljudge_round_id.'&txtsearchname='.$txtsearchname.'&selscore_type='.$selscore_type.'&txtscoreval='.$txtscoreval.'&serachBy='.$serachBy.'&hdnorderby='.$colname.'&txtsortby='.$txtsortby.'&txtsorting='.$txtsorting.'&txtpagesize='.$txtpagesize.'&hdnorder=asc';
			$urlAJAXDesc = 'search_winner_ajax.php?contest_id='.$contest_id.'&isSubmit='.$isSubmit.'&seljudge_round_id='.$seljudge_round_id.'&txtsearchname='.$txtsearchname.'&selscore_type='.$selscore_type.'&txtscoreval='.$txtscoreval.'&serachBy='.$serachBy.'&hdnorderby='.$colname.'&txtsortby='.$txtsortby.'&txtsorting='.$txtsorting.'&txtpagesize='.$txtpagesize.'&hdnorder=desc';
	}

		$sortType = '';
		if ($sortcolumn  ==  $colname)
		{
			if ($sortorder  ==  "desc")
			{
				$sortType.="<a href = \"JavaScript:go('$colname','asc','$strActionFile','".$urlAJAXAsc."');\" title = 'Ascending'><img src = \"".SERVER_ADMIN_HOST."images/icons/arrow_down_mini.gif\" align = \"texttop\" border = \"0\"></a>";
				$sortType.="<a href = \"JavaScript:go('$colname','desc','$strActionFile','".$urlAJAXDesc."');\" title = 'Descending'><img src = \"".SERVER_ADMIN_HOST."images/icons/arrow_up_green_mini.gif\" align = \"texttop\" border = \"0\"></a>";
			}
			else
			{
				$sortType.="<a href = \"JavaScript:go('$colname','asc','$strActionFile','".$urlAJAXAsc."');\" title = 'Ascending'><img src = \"".SERVER_ADMIN_HOST."images/icons/arrow_down_green_mini.gif\" align = \"texttop\" border = \"0\"></a>";
				$sortType.="<a href = \"JavaScript:go('$colname','desc','$strActionFile','".$urlAJAXDesc."');\" title = 'Descending'><img src = \"".SERVER_ADMIN_HOST."images/icons/arrow_up_mini.gif\" align = \"texttop\" border = \"0\"></a>";
			}
		}
		else
		{
			$sortType.="<a href = \"JavaScript:go('$colname','asc','$strActionFile','".$urlAJAXAsc."');\" title = 'Ascending'><img src = \"".SERVER_ADMIN_HOST."images/icons/arrow_down_mini.gif\" align = \"texttop\" border = \"0\"></a>";
			$sortType.="<a href = \"JavaScript:go('$colname','desc','$strActionFile','".$urlAJAXDesc."');\" title = 'Descending'><img src = \"".SERVER_ADMIN_HOST."images/icons/arrow_up_mini.gif\" align = \"texttop\" border = \"0\"></a>";
		}
	
		return $sortType;
	}
	
	function _sortImagesAJAX1($colname, $strActionFile)
	{	
		$colname  =  strtolower(trim($colname));
		
		if (!empty($_POST['hdnorderby']))	$sortcolumn  =  $_POST['hdnorderby'];
		else 								$sortcolumn  =  "";
		
		if (!empty($_POST['hdnorder']))		$sortorder  =  $_POST['hdnorder'];
		else 								$sortorder  =  "";
		

		//For Default Sort column & sort order
		if (!empty($this->strorderby)) $sortcolumn  =  $this->strorderby;
		
		if (!empty($this->strorder)) $sortorder  =  $this->strorder;

		$contest_id = $_REQUEST['contest_id'];
		$isSubmit = $_REQUEST['isSubmit'];
		
		
		$txtsortby = $_REQUEST['hdnorderby'];
		$txtsorting = $_REQUEST['hdnorder'];
		$txtpagesize = $_REQUEST['txtpagesize'];
	
			$seluser_type_id = $_REQUEST['seluser_type_id'];
			$txtsearchname = $_REQUEST['txtsearchname'];
			$serachBy = $_REQUEST['serachBy'];
			$selected = $_REQUEST['selected'];
			
			$urlAJAXAsc = 'search_audience_ajax.php?contest_id='.$contest_id.'&isSubmit='.$isSubmit.'&txtsearchname='.$txtsearchname.'&serachBy='.$serachBy.'&pageVal=1&seluser_type_id='.$seluser_type_id.'&hdnorderby='.$colname.'&txtsortby='.$txtsortby.'&txtsorting='.$txtsorting.'&txtpagesize='.$txtpagesize.'&selected='.$selected.'&hdnorder=asc';
			$urlAJAXDesc = 'search_audience_ajax.php?contest_id='.$contest_id.'&isSubmit='.$isSubmit.'&txtsearchname='.$txtsearchname.'&serachBy='.$serachBy.'&pageVal=1&seluser_type_id='.$seluser_type_id.'&hdnorderby='.$colname.'&txtsortby='.$txtsortby.'&txtsorting='.$txtsorting.'&txtpagesize='.$txtpagesize.'&selected='.$selected.'&hdnorder=desc';
	

		$sortType = '';
		if ($sortcolumn  ==  $colname)
		{
			if ($sortorder  ==  "desc")
			{
				$sortType.="<a href = \"JavaScript:goAJAX1('$colname','asc','$strActionFile','".$urlAJAXAsc."');\" title = 'Ascending'><img src = \"".SERVER_ADMIN_HOST."images/icons/arrow_down_mini.gif\" align = \"texttop\" border = \"0\"></a>";
				$sortType.="<a href = \"JavaScript:goAJAX1('$colname','desc','$strActionFile','".$urlAJAXDesc."');\" title = 'Descending'><img src = \"".SERVER_ADMIN_HOST."images/icons/arrow_up_green_mini.gif\" align = \"texttop\" border = \"0\"></a>";
			}
			else
			{
				$sortType.="<a href = \"JavaScript:goAJAX1('$colname','asc','$strActionFile','".$urlAJAXAsc."');\" title = 'Ascending'><img src = \"".SERVER_ADMIN_HOST."images/icons/arrow_down_green_mini.gif\" align = \"texttop\" border = \"0\"></a>";
				$sortType.="<a href = \"JavaScript:goAJAX1('$colname','desc','$strActionFile','".$urlAJAXDesc."');\" title = 'Descending'><img src = \"".SERVER_ADMIN_HOST."images/icons/arrow_up_mini.gif\" align = \"texttop\" border = \"0\"></a>";
			}
		}
		else
		{
			$sortType.="<a href = \"JavaScript:goAJAX1('$colname','asc','$strActionFile','".$urlAJAXAsc."');\" title = 'Ascending'><img src = \"".SERVER_ADMIN_HOST."images/icons/arrow_down_mini.gif\" align = \"texttop\" border = \"0\"></a>";
			$sortType.="<a href = \"JavaScript:goAJAX1('$colname','desc','$strActionFile','".$urlAJAXDesc."');\" title = 'Descending'><img src = \"".SERVER_ADMIN_HOST."images/icons/arrow_up_mini.gif\" align = \"texttop\" border = \"0\"></a>";
		}
	
		return $sortType;
	}
	
	function _sortImagesAJAX2($colname, $strActionFile)
	{	
		$colname  =  strtolower(trim($colname));
		
		if (!empty($_POST['hdnorderby']))	$sortcolumn  =  $_POST['hdnorderby'];
		else 								$sortcolumn  =  "";
		
		if (!empty($_POST['hdnorder']))		$sortorder  =  $_POST['hdnorder'];
		else 								$sortorder  =  "";
		

		//For Default Sort column & sort order
		if (!empty($this->strorderby)) $sortcolumn  =  $this->strorderby;
		
		if (!empty($this->strorder)) $sortorder  =  $this->strorder;

		$contest_id = $_REQUEST['contest_id'];
		$isSubmit = $_REQUEST['isSubmit'];
		
		
		$txtsortby = $_REQUEST['hdnorderby'];
		$txtsorting = $_REQUEST['hdnorder'];
		$txtpagesize = $_REQUEST['txtpagesize'];
		
		$selected = $_REQUEST['selected'];
		$urlAJAXAsc = 'search_audience_selected_ajax.php?contest_id='.$contest_id.'&isSubmit='.$isSubmit.'&pageVal=2&hdnorderby='.$colname.'&txtsortby='.$txtsortby.'&txtsorting='.$txtsorting.'&selected='.$selected.'&txtpagesize='.$txtpagesize.'&hdnorder=asc';
		$urlAJAXDesc = 'search_audience_selected_ajax.php?contest_id='.$contest_id.'&isSubmit='.$isSubmit.'&pageVal=2&hdnorderby='.$colname.'&txtsortby='.$txtsortby.'&txtsorting='.$txtsorting.'&selected='.$selected.'&txtpagesize='.$txtpagesize.'&hdnorder=desc';
		
		$sortType = '';
		if ($sortcolumn  ==  $colname)
		{
			if ($sortorder  ==  "desc")
			{
				$sortType.="<a href = \"JavaScript:goAJAX('$colname','asc','$strActionFile','".$urlAJAXAsc."');\" title = 'Ascending'><img src = \"".SERVER_ADMIN_HOST."images/icons/arrow_down_mini.gif\" align = \"texttop\" border = \"0\"></a>";
				$sortType.="<a href = \"JavaScript:goAJAX('$colname','desc','$strActionFile','".$urlAJAXDesc."');\" title = 'Descending'><img src = \"".SERVER_ADMIN_HOST."images/icons/arrow_up_green_mini.gif\" align = \"texttop\" border = \"0\"></a>";
			}
			else
			{
				$sortType.="<a href = \"JavaScript:goAJAX('$colname','asc','$strActionFile','".$urlAJAXAsc."');\" title = 'Ascending'><img src = \"".SERVER_ADMIN_HOST."images/icons/arrow_down_green_mini.gif\" align = \"texttop\" border = \"0\"></a>";
				$sortType.="<a href = \"JavaScript:goAJAX('$colname','desc','$strActionFile','".$urlAJAXDesc."');\" title = 'Descending'><img src = \"".SERVER_ADMIN_HOST."images/icons/arrow_up_mini.gif\" align = \"texttop\" border = \"0\"></a>";
			}
		}
		else
		{
			$sortType.="<a href = \"JavaScript:goAJAX('$colname','asc','$strActionFile','".$urlAJAXAsc."');\" title = 'Ascending'><img src = \"".SERVER_ADMIN_HOST."images/icons/arrow_down_mini.gif\" align = \"texttop\" border = \"0\"></a>";
			$sortType.="<a href = \"JavaScript:goAJAX('$colname','desc','$strActionFile','".$urlAJAXDesc."');\" title = 'Descending'><img src = \"".SERVER_ADMIN_HOST."images/icons/arrow_up_mini.gif\" align = \"texttop\" border = \"0\"></a>";
		}
	
		return $sortType;
	}
	
	function _sortImages($colname, $strActionFile)
	{	
		$colname  =  strtolower(trim($colname));
		
		if (!empty($_POST['hdnorderby']))	$sortcolumn  =  $_POST['hdnorderby'];
		else 								$sortcolumn  =  "";
		
		if (!empty($_POST['hdnorder']))		$sortorder  =  $_POST['hdnorder'];
		else 								$sortorder  =  "";
		

		//For Default Sort column & sort order
		if (!empty($this->strorderby)) $sortcolumn  =  $this->strorderby;
		
		if (!empty($this->strorder)) $sortorder  =  $this->strorder;


		if ($sortcolumn  ==  $colname)
		{
			if ($sortorder  ==  "desc")
			{
				print "<a href = \"JavaScript:go('$colname','asc','$strActionFile');\" title = 'Ascending'><img src = \"".SERVER_ADMIN_HOST."images/icons/arrow_down_mini.gif\" align = \"texttop\" border = \"0\"></a>";
				print "<a href = \"JavaScript:go('$colname','desc','$strActionFile');\" title = 'Descending'><img src = \"".SERVER_ADMIN_HOST."images/icons/arrow_up_green_mini.gif\" align = \"texttop\" border = \"0\"></a>";
			}
			else
			{
				print "<a href = \"JavaScript:go('$colname','asc','$strActionFile');\" title = 'Ascending'><img src = \"".SERVER_ADMIN_HOST."images/icons/arrow_down_green_mini.gif\" align = \"texttop\" border = \"0\"></a>";
				print "<a href = \"JavaScript:go('$colname','desc','$strActionFile');\" title = 'Descending'><img src = \"".SERVER_ADMIN_HOST."images/icons/arrow_up_mini.gif\" align = \"texttop\" border = \"0\"></a>";
			}
		}
		else
		{
			print "<a href = \"JavaScript:go('$colname','asc','$strActionFile');\" title = 'Ascending'><img src = \"".SERVER_ADMIN_HOST."images/icons/arrow_down_mini.gif\" align = \"texttop\" border = \"0\"></a>";
			print "<a href = \"JavaScript:go('$colname','desc','$strActionFile');\" title = 'Descending'><img src = \"".SERVER_ADMIN_HOST."images/icons/arrow_up_mini.gif\" align = \"texttop\" border = \"0\"></a>";
		}
	
		return true;
	}
}

?>