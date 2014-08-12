<?php
class paging
{
	public $intRowsPerPage;
	public $intCurrentPage;
	public $intStartRecNo;
	public $intTotalRecords;
	public $intPageSize;
	public $page;
	public $intNextPage;
	public $intPrevPage;
	public $searchfor;
	public $searchoption;
	public $strHiddenpublics;
	public $txtSearchText;
	public $strACond;
	public $_strSort;
	public $strHiddenScripts;
	public $strorderby;
	public $strOrder;
	
	/*function paging()
	{
	}*/
	
	function set_page_details($recordset,$page1,$intRowsPerPage1)
	{ 
		
		$this->page=$page1;
		$this->intRowsPerPage=$intRowsPerPage1;
		
		/*if(isset($_REQUEST["currentpage"]) && trim($_REQUEST['currentpage']=='all'))
		{
			$this->intRowsPerPage=mysql_num_rows($recordset);
		}*/

		if(isset($_REQUEST["currentpage"]) && trim($_REQUEST['currentpage']!='all'))
		{
			$this->intCurrentPage=$_REQUEST["currentpage"];
		}
		else
		{
			$this->intCurrentPage=1;
		}		
		
		$this->intStartRecNo= (($this->intCurrentPage -1) * $this->intRowsPerPage) + 1;

		$rsPg=$recordset;
		$this->intTotalRecords = mysql_num_rows($rsPg);
		
		if(intval($this->intTotalRecords/$this->intRowsPerPage)==$this->intTotalRecords/$this->intRowsPerPage)
		{
			$this->intPageSize=intval($this->intTotalRecords/$this->intRowsPerPage);
		}
		else
		{
			$this->intPageSize=intval($this->intTotalRecords/$this->intRowsPerPage) + 1;
		}
		
		if($this->intTotalRecords==0)
		{
			$this->intPageSize=1;
		}
		
		if ((intval($this->intCurrentPage)-1)<1)
		{
			$this->intPrevPage=$this->intCurrentPage;
		}
		else
		{
			$this->intPrevPage=intval($this->intCurrentPage)-1;
		}
		
		if ((intval($this->intCurrentPage)+1)>$this->intPageSize)
		{
			$this->intNextPage=$this->intCurrentPage;
		}
		else
		{
			$this->intNextPage=intval($this->intCurrentPage)+1;
		}
		
		if(mysql_num_rows($rsPg) > 0)
		{				
			//var_dump($this->intCurrentPage);
		
			if (($this->intStartRecNo-1)>mysql_num_rows($rsPg))
			{					
				$this->intCurrentPage = 1;
				//mysql_data_seek($rsPg,10);
			}
			else 
				mysql_data_seek($rsPg,$this->intStartRecNo-1);
				
			$arRw= array();
				
			$tmp=$this->intRowsPerPage;
			
			if(($this->intStartRecNo+$this->intRowsPerPage)>$this->intTotalRecords)
			{
				$tmp=($this->intTotalRecords)-($this->intStartRecNo-1);				
			}
			
			for($i=0;$i<$tmp;$i++)
			{
				$arRw[]=mysql_fetch_array($rsPg);
			}
			
			//get all records in case of all
			if(isset($_REQUEST["currentpage"]) && trim($_REQUEST['currentpage']=='all'))
			{
				mysql_data_seek($recordset,0);
				unset($arRw);
				$arRw = array();
				while ( $arrecord = mysql_fetch_assoc($recordset) ) {
					$arRw[] = $arrecord;
				}
			}
		}
		else
		{
			$arRw= array();
		} 
		
		return $arRw;
	}
	
	function draw_number_panel($frm="frm",$height="20",$cssTextbox="textbox",$cssFont="tahoma11grays",$cssLine="doline")
	{
		
		if($this->intPageSize<=1) {
			return "";
			exit;
		}
		$strNextButton 	= "";
		$strLastButton 	= "";
		$strPrevPage		= "";
		$strFirstPage		= "";
		$strpage				= "";
		
		if (intval($this->intCurrentPage) == 1)
		{
			$strPrevPage  ="";
		}
		else
		{
			if (strpos($this->page,"?")===false)
				$page_link = $this->page."?currentpage=". $this->intPrevPage;
			else
				$page_link = $this->page."&currentpage=". $this->intPrevPage;
			$strPrevPage  ="<a title=\"Go to previous page.\" href=\"".$page_link."\">Previous</a>\n\r";
		}
		if ((intval($this->intCurrentPage)*intval($this->intRowsPerPage) >= intval($this->intTotalRecords)))
		{
			$strNextButton ="";
		}
		else 
		{
			if (strpos($this->page,"?")===false)
				$page_link = $this->page."?currentpage=". $this->intNextPage;
			else
				$page_link = $this->page."&currentpage=". $this->intNextPage;
			$strNextButton ="<a title=\"Go to next page.\" href=\"".$page_link."\">Next</a>\n\r";
		}

	    $strpage .="<div class=\"pager\">
                    	<table width=\"100%\">
                    		<tr>
								"; #<td align=\"left\">
		/*if (($this->intStartRecNo+(PAGESIZE-1))>$this->intTotalRecords)
			$strpage .= "Result: ".$this->intStartRecNo."-".$this->intTotalRecords ." of ".$this->intTotalRecords."";
		else
			$strpage .= "Result: ".$this->intStartRecNo."-".($this->intStartRecNo+(PAGESIZE-1))." of ".$this->intTotalRecords."";
		*/
		$strpage .= "<td align=\"left\">"; #</td>
		$strpage .= $strPrevPage;
		
		if (($this->intCurrentPage-4)<=0)
			$start_no = 1;
		else
			$start_no = ($this->intCurrentPage-4);

		if (($this->intCurrentPage+4)>$this->intPageSize)
			$end_no = $this->intPageSize;
		else
			$end_no = ($this->intCurrentPage+4);


		for($i=$start_no; $i<=$end_no;$i++)
		{
			if($i == $this->intCurrentPage && trim($_REQUEST['currentpage'])!='all')
			{
				$highlightPageNumber = " class=\"active\" ";
				$link = "<strong>$i</strong>";
			}
			else 
			{
				$highlightPageNumber = "";
				if (strpos($this->page,"?")===false)
					$page_link = $this->page."?currentpage=".$i;
				else
					$page_link = $this->page."&currentpage=".$i;
				
				$link = "<a title=\"Go to page ".$i.".\" ".$highlightPageNumber." href=\"".$page_link."\">$i</a>";
					
			}
			$strpage .="<span ".$highlightPageNumber." >".$link."</span>\n\r";
		}
		$page_link = $this->page."?currentpage=all";
		if ( trim($_REQUEST['currentpage']) == 'all' ) {
			$highlightPageNumber = " class=\"active\" ";
		}
		else {
			$highlightPageNumber = '';
		}
		$strpage .= $strNextButton;
		$strpage .= "</td>
					</tr>
				</table>
			</div>";

		
		$strpage .="		" . $this->strHiddenpublics ."";
			
		return $strpage;
	}
}

?>