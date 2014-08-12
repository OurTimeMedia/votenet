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
	
	function paging()
	{
		if(!empty($_REQUEST["hdnorderby"]))
			$this->strorderby = trim($_REQUEST["hdnorderby"]);
		else
			$this->strorderby = "";
		
		if(!empty($_REQUEST["hdnorder"]))
			$this->strorder = trim($_REQUEST["hdnorder"]);
		else
			$this->strorder = "asc";
	}
	
	function set_page_details($objCurrentObject,$page1,$intRowsPerPage1,$cond="")
	{ 
		global $cmn;
		if(!empty($_REQUEST["hdnorderby"]) && trim($_REQUEST["hdnorderby"])!="")
			$this->strorderby = trim($_REQUEST["hdnorderby"]);

		if(!empty($_REQUEST["hdnorder"]) && trim($_REQUEST["hdnorder"])!="")
			$this->strorder = trim($_REQUEST["hdnorder"]);
			
		$this->page=$page1;
		$this->intRowsPerPage=$intRowsPerPage1;
		
		if(isset($_REQUEST["txtpagesize"]))
		{
			$this->intRowsPerPage=$_REQUEST["txtpagesize"];
		}
		else
		{
			if($this->intRowsPerPage=="")
			{
				$this->intRowsPerPage=PAGESIZE;
			}
		}
		
		$page_state = $cmn->get_page_state();
	
		if(isset($_REQUEST["txtcurrentpage"]))
		{
			$this->intCurrentPage=$_REQUEST["txtcurrentpage"];
		}
		else if ( isset($page_state['paging']['current_page']) && intval($page_state['paging']['current_page']) > 0 ) {
			$this->intCurrentPage = (int) $page_state['paging']['current_page'];
		}
		else
		{
			$this->intCurrentPage=1;
		}		
		
		$this->intStartRecNo= (($this->intCurrentPage -1) * $this->intRowsPerPage) + 1;

		if (!empty($this->strorderby)) $strOrderBy = $this->strorderby . " " . $this->strorder;
		else $strOrderBy = "";
		

		if(!empty($strOrderBy))$rsPg=$objCurrentObject->fetchrecordset("", $cond, $strOrderBy);
		else $rsPg=$objCurrentObject->fetchrecordset("", $cond);
		
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
			if (($this->intStartRecNo-1)>mysql_num_rows($rsPg))
			{					
				$this->intCurrentPage = 1;
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
		}
		else
		{
			$arRw= array();
		} 
		
		return $arRw;
	}

	function set_page_details_recordset($rsPg, $page1, $intRowsPerPage1)
	{ 
		$this->page=$page1;
		$this->intRowsPerPage=$intRowsPerPage1;
		
		if(isset($_REQUEST["txtpagesize"]))
		{
			$this->intRowsPerPage=$_REQUEST["txtpagesize"];
		}
		else
		{
			if($this->intRowsPerPage=="")
			{
				$this->intRowsPerPage=PAGESIZE;
			}
		}
	
		if(isset($_REQUEST["txtcurrentpage"]))
		{
			$this->intCurrentPage=$_REQUEST["txtcurrentpage"];
		}
		else
		{
			$this->intCurrentPage=1;
		}		
		
		$this->intStartRecNo = (($this->intCurrentPage -1) * $this->intRowsPerPage) + 1;

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
			if (($this->intStartRecNo-1)>mysql_num_rows($rsPg))
			{					
				$this->intCurrentPage = 1;
			}
			else 
				mysql_data_seek($rsPg,$this->intStartRecNo-1);
				
			$arRw= array();
				
			$tmp=$this->intRowsPerPage;
			
			if(($this->intStartRecNo+$this->intRowsPerPage)>$this->intTotalRecords)
			{
				$tmp=($this->intTotalRecords)-($this->intStartRecNo-1);				
			}
			
			if($intRowsPerPage1==0)
				$tmp=mysql_num_rows($rsPg);
				
			for($i=0;$i<$tmp;$i++)
			{
				$arRw[]=mysql_fetch_array($rsPg);
			}
		}
		else
		{
			$arRw= array();
		} 
		
		return $arRw;
	}	
	
	function set_page_details_new($objCurrentObject,$page1,$intRowsPerPage1,$cond="")
	{ 
		if(!empty($_REQUEST["hdnorderby"]) && trim($_REQUEST["hdnorderby"])!="")
			$this->strorderby = trim($_REQUEST["hdnorderby"]);

		if(!empty($_REQUEST["hdnorder"]) && trim($_REQUEST["hdnorder"])!="")
			$this->strorder = trim($_REQUEST["hdnorder"]);
			
		$this->page=$page1;
		$this->intRowsPerPage=$intRowsPerPage1;
		
		if(isset($_REQUEST["txtpagesize"]))
		{
			$this->intRowsPerPage=$_REQUEST["txtpagesize"];
		}
		else
		{
			if($this->intRowsPerPage=="")
			{
				$this->intRowsPerPage=PAGESIZE;
			}
		}
	
		if(isset($_REQUEST["txtcurrentpage"]))
		{
			$this->intCurrentPage=$_REQUEST["txtcurrentpage"];
		}
		else
		{
			$this->intCurrentPage=1;
		}		
		
		$this->intStartRecNo= (($this->intCurrentPage -1) * $this->intRowsPerPage) + 1;

		if (!empty($this->strorderby)) $strOrderBy = $this->strorderby . " " . $this->strorder;
		else $strOrderBy = "";
		
		if(!empty($strOrderBy))$rsPg=$objCurrentObject->fetchrecordset_new("", $cond, $strOrderBy);
		else $rsPg=$objCurrentObject->fetchrecordset_new("", $cond);
		
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
			if (($this->intStartRecNo-1)>mysql_num_rows($rsPg))
			{					
				$this->intCurrentPage = 1;
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
		}
		else
		{
			$arRw= array();
		} 
		
		return $arRw;
	}
	
	function sethidden()
	{
		print "<input type=\"hidden\" name=\"txtcurrentpage\" value=\"" . $this->intCurrentPage ."\">";
		print "<input type=\"hidden\" name=\"txtpageno1\" value=\"" .$this->intCurrentPage ."\">";
		print "<input type=\"hidden\" name=\"txtpagesize\" value=\"" . $this->intRowsPerPage ."\">";
		print "<input type=\"hidden\" name=\"txtSort\" value=\"" . $this->_strSort ."\">";			
	}
	
	function draw_panel($frm="frm",$height="20",$cssTextbox="textbox",$cssFont="tahoma11grays",$cssLine="doline")
	{
		$strNextButton 	= "";
		$strLastButton 	= "";
		$strPrevPage	= "";
		$strFirstPage	= "";
		$strPage		= "";
		
		if (intval($this->intCurrentPage) == 1)
		{
			$strPrevPage  ="<td><img src=\"" . ADMIN_THEME . "images/icons/arrow_back_disabled.gif\" alt=\"Previous\" align=\"absmiddle\" border=\"0\"></td>";
			$strFirstPage ="<td><img src=\"" . ADMIN_THEME . "images/icons/arrow_first_1_disabled.gif\" alt=\"First\" align=\"absmiddle\" border=\"0\"></td>";
		}
		else
		{
			$strPrevPage  ="<td><a href=\"Javascript:_" . $frm ."_changepage('". $this->intPrevPage ."');\"><img src=\"" . ADMIN_THEME . "images/icons/arrow_back.gif\" alt=\"Previous\" align=\"absmiddle\" border=\"0\" ></a></td>";
			$strFirstPage ="<td><a href=\"Javascript:_" . $frm ."_changepage('1');\"><img src=\"" . ADMIN_THEME . "images/icons/arrow_first_1.gif\" alt=\"First\" align=\"absmiddle\" border=\"0\"></a></td>";
		}
		if ((intval($this->intCurrentPage)*intval($this->intRowsPerPage) >= intval($this->intTotalRecords)))
		{
			$strNextButton ="<td><img src=\"" . ADMIN_THEME . "images/icons/arrow_next_disabled.gif\" alt=\"Next\" align=\"absmiddle\" border=\"0\"></td>";
			$strLastButton ="<td><img src=\"" . ADMIN_THEME . "images/icons/arrow_last_1_disabled.gif\" alt=\"Last\" align=\"absmiddle\" border=\"0\"></td>";
		}
		else 
		{
			$strNextButton ="<td><a href=\"Javascript:_" . $frm ."_changepage('" .$this->intNextPage ."');\"><img src=\"" . ADMIN_THEME . "images/icons/arrow_next.gif\" alt=\"Next\" align=\"absmiddle\" border=\"0\"  ></a></td>";
			$strLastButton ="<td><a href=\"Javascript:_" . $frm ."_changepage('" . intval($this->intPageSize) . "');\"><img src=\"" . ADMIN_THEME . "images/icons/arrow_last_1.gif\" align=\"absmiddle\" alt=\"Last\" border=\"0\"></a></td>";
		}
		$intSelectedPageSize = "";
		
		$pagesizearray = array (10,20,50,75,100,150);
		
		$intSelectedPageSize = "<td> <select class=\"paging-select\" onChange=\"Javascript:_" . $frm ."_changepagesize(this.value);\" name=\"txtpagesize\" class=\"". $cssTextbox ."\" maxlength='3'> ";

		foreach($pagesizearray as $key=>$value)
		{			
			$intSelectedPageSize .= "<option value='$value' ";
			
			if ($value == $this->intRowsPerPage) 
				$intSelectedPageSize .= "selected=\"selected\"";
			
			$intSelectedPageSize .= ">$value</option>";	
			
		}
		
		$intSelectedPageSize .= "</select>&nbsp;&nbsp;&nbsp;&nbsp;</td>";
		
		$this->printJScript($frm);
		$strPage .="<table class=\"tbl-noborder msg-table\"><tr><td>Records per page:</td>";
		$strPage .=	$intSelectedPageSize;
		$strPage .= $strFirstPage;
		$strPage .= $strPrevPage;
		$strPage .="<td>&nbsp;&nbsp;Page ". $this->intCurrentPage . " of ". $this->intPageSize . "&nbsp;&nbsp;</td>";
		$strPage .= $strNextButton;
		$strPage .= $strLastButton;
		$strPage .="<td>&nbsp;&nbsp;&nbsp;&nbsp;Goto page:</td>";
		$strPage .="<td><input name=\"txtpageno\" type=\"text\" class=\"paging-textbox\" style=\"width:34px;height:15px;\" maxlength='5'></td>";
		
		$strPage .="<td>&nbsp;&nbsp;<a href=\"Javascript: void(0)\"  onclick = \"_" . $frm ."_GotoPage('-1');\"><img src=\"" . ADMIN_THEME . "images/icons/right.gif\" alt=\"Go!\" align=\"absmiddle\" border=\"0\"></a>";
				
		$strPage .="		" . $this->strHiddenvars ."";
		$strPage .="		<input type=\"hidden\" name=\"txtcurrentpage\" value=\"". $this->intCurrentPage ."\">";
		$strPage .="		<input type=\"hidden\" name=\"txtpageno1\" value=\"".$this->intCurrentPage ."\">";
		$strPage .="		<input name=\"txtSearchText\" type=\"hidden\" id=\"txtSearchText1\" value=\"". $this->txtSearchText ."\">";
		$strPage .="		<input type=\"hidden\" name=\"txtSort\" value=\"" .$this->_strSort ."\">";
		$strPage .="		<input type=\"hidden\" name=\"hdnorderby\" value=\"" .$this->strorderby ."\">";
		$strPage .="		<input type=\"hidden\" name=\"hdnorder\" value=\"" .$this->strorder ."\">";
		$strPage .="		<script language=\"javascript\" type=\"text/javascript\">". $this->strHiddenScripts . "</script></td></tr></table>";
			
		return $strPage;
	}
	
	function draw_panel_hidden($frm="frm")
	{
		$strPage = "";
		$this->intPageSize = 0;
		$this->printJScript($frm);
		$strPage .="		" . $this->strHiddenvars ."";
		$strPage .="		<input type=\"hidden\" name=\"txtcurrentpage\" value=\"". $this->intCurrentPage ."\">";
		$strPage .="		<input type=\"hidden\" name=\"txtpageno1\" value=\"".$this->intCurrentPage ."\">";
		$strPage .="		<input name=\"txtSearchText\" type=\"hidden\" id=\"txtSearchText1\" value=\"". $this->txtSearchText ."\">";
		$strPage .="		<input type=\"hidden\" name=\"txtSort\" value=\"" .$this->_strSort ."\">";
		$strPage .="		<input type=\"hidden\" name=\"hdnorderby\" value=\"" .$this->strorderby ."\">";
		$strPage .="		<input type=\"hidden\" name=\"hdnorder\" value=\"" .$this->strorder ."\">";
		$strPage .="		<script language=\"javascript\" type=\"text/javascript\">". $this->strHiddenScripts . "</script>";
			
		return $strPage;
	}	
	
	function draw_panel_page($frm = "frm", $first_link = "", $last_link = "")
	{
		$strNextButton 	= "";
		$strLastButton 	= "";
		$strPrevPage	= "";
		$strFirstPage	= "";
		$strPage		= "";
		
		if (intval($this->intCurrentPage) == 1)
		{	
			if ($first_link != "")
				$strPrevPage = "<td><a href=". $first_link . " title=\"Previous\"  ><img src=\"" . ADMIN_THEME . "images/arrow_back.gif\" alt=\"Previous\" align=\"absmiddle\" border=\"0\"></a></td>";
			
			$strFirstPage ="<td><img src=\"" . ADMIN_THEME . "images/icons/arrow_first_1_disabled.gif\" alt=\"First\" title=\"First\" align=\"absmiddle\" border=\"0\"></td>";
		}
		else
		{
			$strPrevPage  ="<td><a href=\"Javascript:_" . $frm ."_changepage('". $this->intPrevPage ."');\" title=\"Previous\" ><img src=\"" . ADMIN_THEME . "images/arrow_back.gif\" alt=\"Previous\" title=\"Previous\" align=\"absmiddle\" border=\"0\" ></a></td>";
			$strFirstPage ="<td><a href=\"Javascript:_" . $frm ."_changepage('1');\" title=\"First\"><img src=\"" . ADMIN_THEME . "images/icons/arrow_first_1.gif\" alt=\"First\" title=\"First\" align=\"absmiddle\" border=\"0\"></a></td>";
		}
		if ((intval($this->intCurrentPage)*intval($this->intRowsPerPage) >= intval($this->intTotalRecords)))
		{
			if ($last_link != "")
				$strNextButton ="<td><a href=". $last_link . " title=\"Next\" ><img src=\"" . ADMIN_THEME . "images/arrow_next.gif\" alt=\"Next\" title=\"Next\" align=\"absmiddle\" border=\"0\"></a></td>";			
			
			$strLastButton ="<td><img src=\"" . ADMIN_THEME . "images/icons/arrow_last_1_disabled.gif\" alt=\"Last\" title=\"Last\" align=\"absmiddle\" border=\"0\"></td>";
		}
		else 
		{
			$strNextButton ="<td><a href=\"Javascript:_" . $frm ."_changepage('" .$this->intNextPage ."');\" title=\"Next\" ><img src=\"" . ADMIN_THEME . "images/arrow_next.gif\" alt=\"Next\" title=\"Next\" align=\"absmiddle\" border=\"0\"  ></a></td>";
			$strLastButton ="<td><a href=\"Javascript:_" . $frm ."_changepage('" . intval($this->intPageSize) . "');\" title=\"Last\" ><img src=\"" . ADMIN_THEME . "images/icons/arrow_last_1.gif\" alt=\"Last\" title=\"Last\" align=\"absmiddle\" border=\"0\"></a></td>";
		}
		
		$this->printJScript($frm);
		$strPage .="<table ><tr>";
		//$strPage .= $strFirstPage;
		$strPage .= $strPrevPage;
		$strPage .="<td>&nbsp;&nbsp;Page ". $this->intCurrentPage . " of ". $this->intPageSize . "&nbsp;&nbsp;</td>";
		$strPage .= $strNextButton;
//		$strPage .= $strLastButton;
				
		$strPage .="		" . $this->strHiddenvars ."";
		$strPage .="		<input type=\"hidden\" name=\"txtcurrentpage\" value=\"". $this->intCurrentPage ."\">";
		$strPage .="		<input type=\"hidden\" name=\"txtpageno1\" value=\"".$this->intCurrentPage ."\">";
		$strPage .="		<input name=\"txtSearchText\" type=\"hidden\" id=\"txtSearchText1\" value=\"". $this->txtSearchText ."\">";
		$strPage .="		<input type=\"hidden\" name=\"txtSort\" value=\"" .$this->_strSort ."\">";
		$strPage .="		<input type=\"hidden\" name=\"hdnorderby\" value=\"" .$this->strorderby ."\">";
		$strPage .="		<input type=\"hidden\" name=\"hdnorder\" value=\"" .$this->strorder ."\">";
		$strPage .="		<script language=\"javascript\" type=\"text/javascript\">". $this->strHiddenScripts . "</script></td></tr></table>";
			
		return $strPage;
	}
	
	function draw_panel_new($frm="frm",$height="20",$cssTextbox="textbox",$cssFont="tahoma11grays",$cssLine="doline")
	{
		$strNextButton 	= "";
		$strLastButton 	= "";
		$strPrevPage	= "";
		$strFirstPage	= "";
		$strPage		= "";
		
		if (intval($this->intCurrentPage) == 1)
		{
			$strPrevPage  ="		<td width=\"14\"><img src=\"admin/" . ADMIN_THEME . "images/icons/arrow_left_disabled.gif\" alt=\"Previous\" title=\"Previous\" border=\"0\"></td>";
			$strFirstPage ="		<td width=\"14\"><img src=\"admin/" . ADMIN_THEME . "images/icons/arrow_first_disabled.gif\" alt=\"First\" title=\"First\" border=\"0\"></td>";
		}
		else
		{
			$strPrevPage  ="		<td width=\"14\"><a href=\"Javascript:_" . $frm ."_changepage('". $this->intPrevPage ."');\" title=\"Previous\" ><img src=\"admin/" . ADMIN_THEME . "images/icons/arrow_first.gif\" alt=\"Previous\" title=\"Previous\" border=\"0\" ></a></td>";
			$strFirstPage ="		<td width=\"14\"><a href=\"Javascript:_" . $frm ."_changepage('1');\" title=\"First\" ><img src=\"admin/" . ADMIN_THEME . "images/icons/tostart.gif\" alt=\"First\" title=\"First\" border=\"0\"></a></td>";
		}
		if ((intval($this->intCurrentPage)*intval($this->intRowsPerPage) >= intval($this->intTotalRecords)))
		{
			$strNextButton ="		<td width=\"14\"><img src=\"admin/" . ADMIN_THEME . "images/icons/arrow_right_disabled.gif\" alt=\"Next\" border=\"0\"></td>";
			$strLastButton ="		<td width=\"14\"><img src=\"admin/" . ADMIN_THEME . "images/icons/arrow_last_disabled.gif\" alt=\"Last\" border=\"0\"></td>";
		}
		else 
		{
			$strNextButton ="		<td width=\"14\"><a href=\"Javascript:_" . $frm ."_changepage('" .$this->intNextPage ."');\" title=\"Next\" ><img src=\"admin/" . ADMIN_THEME . "images/icons/arrow_right.gif\" alt=\"Next\" title=\"Next\" border=\"0\"  ></a></td>";
			$strLastButton ="		<td width=\"14\"><a href=\"Javascript:_" . $frm ."_changepage('" . intval($this->intPageSize) . "');\" title=\"Last\" ><img src=\"admin/" . ADMIN_THEME . "images/icons/arrow_last.gif\" alt=\"Last\" title=\"Last\" border=\"0\"></a></td>";
		}
		$intSelectedPageSize = "";
		
		$pagesizearray = array (10,20,50,75,100);
		
		$intSelectedPageSize = " <select class=\"txtbox\" onChange=\"Javascript:_" . $frm ."_changepagesize(this.value);\" name=\"txtpagesize\" class=\"". $cssTextbox ."\" maxlength='3'> ";

		foreach($pagesizearray as $key=>$value)
		{			
			$intSelectedPageSize .= "<option value='$value' ";
			
			if ($value == $this->intRowsPerPage) 
				$intSelectedPageSize .= "selected=\"selected\"";
			
			$intSelectedPageSize .= ">$value</option>";	
			
		}
		
		$intSelectedPageSize .= "</select>";
		
		$this->printJScript($frm);
		$strPage .="<table class=\"tblpaging\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
		$strPage .="	<tr>";
	    $strPage .="    <td height=\"". $height ."\" class=\"" .$cssLine . "\">";
		$strPage .="	<table  border=\"0\" align=\"center\" cellpadding=\"0\" cellspacing=\"4\">";
		$strPage .="	  <tr>";
		$strPage .="		<td width=\"200\" align=\"left\">";

		$strPage .="<table  border=\"0\" cellspacing=\"0\" cellpadding=\"0\">";
		$strPage .="	<tr>";
		$strPage .="		<td align=\"right\">Records per page:&nbsp;&nbsp;";
		$strPage .=		$intSelectedPageSize;
		$strPage .="	<tr>";
		$strPage .="	</table>";
		
		$strPage .="		</td>";
		$strPage .= $strFirstPage;
		$strPage .= $strPrevPage;
		$strPage .="		<td width=\"141\" align=\"center\" valign=\"middle\" class=\"". $cssFont ."\">Page ". $this->intCurrentPage . " of ". $this->intPageSize . " </td>";
		$strPage .= $strNextButton;
		$strPage .= $strLastButton;
		$strPage .="		<td width=\"70\" align=\"right\" class=\"". $cssFont ."\">Goto page:&nbsp;&nbsp;</td>";
		$strPage .="		<td width=\"36\"><input name=\"txtpageno\" type=\"text\" class=\"txtbox\" style=\"width:34px;height:15px;\" maxlength='5'></td>";
		$strPage .="		<td width=\"20\"><a href=\"Javascript:_" . $frm ."_GotoPage('-1');\"><img src=\"admin/" . ADMIN_THEME . "images/icons/arrow_right.gif\" alt=\"Go!\" border=\"0\"></a></td>";
		$strPage .="	  </tr>";
		$strPage .="	</table>";
				
		$strPage .="		" . $this->strHiddenvars ."";
		$strPage .="		<input type=\"hidden\" name=\"txtcurrentpage\" value=\"". $this->intCurrentPage ."\">";
		$strPage .="		<input type=\"hidden\" name=\"txtpageno1\" value=\"".$this->intCurrentPage ."\">";
		$strPage .="		<input name=\"txtSearchText\" type=\"hidden\" id=\"txtSearchText1\" value=\"". $this->txtSearchText ."\">";
		$strPage .="		<input type=\"hidden\" name=\"txtSort\" value=\"" .$this->_strSort ."\">";
		$strPage .="		<input type=\"hidden\" name=\"hdnorderby\" value=\"" .$this->strorderby ."\">";
		$strPage .="		<input type=\"hidden\" name=\"hdnorder\" value=\"" .$this->strorder ."\">";
		$strPage .="		<script language=\"javascript\" type=\"text/javascript\">". $this->strHiddenScripts . "</script>";
		$strPage .="	</td> </tr> </table>";
			
		return $strPage;
	}
	
	function printJScript($frm)
	{
		$strJScript="<script language=\"javascript\">
		function _" . $frm ."_setpagesize()
		{
			//alert(\"sss\");
			if (document." . $frm .".txtpagesize.value < 1)
			{
				alert(\"You are requested to enter a non decimal numeric value grater than 0.\");
				document." . $frm .".txtpagesize.value='". $this->intPageSize ."';
				document." . $frm .".txtpagesize.focus();
				return false;
			}
			if (!checkInt(document." . $frm .".txtpagesize.value))
			{
				document." . $frm .".txtpagesize.value='".$this->intPageSize ."';
				document." . $frm .".txtpagesize.focus();
				alert(\"You are requested to enter numeric value.\");
				document." . $frm .".txtpagesize.focus();
				return false;
			}
		
			document." . $frm .".action=\"". $this->page ."\";
			document." . $frm .".submit();
		}
		
		function _" . $frm ."_changepagesize()
		{						
			document.frm.txtcurrentpage.value = 1;
			document.frm.action=\"". $this->page ."\";
			document.frm.submit();
		}
		
		function _" . $frm ."_changepage(a)
		{
			//alert(a);
			//if(_" . $frm ."_chkpgsize())
			{
					document.frm.txtcurrentpage.value=a;
					if (a==-1) 
					{
						document.frm.txtcurrentpage.value=document.frm.txtpageno.value;
					}
					
					document.frm.action=\"". $this->page ."\";
					document.frm.submit();
			}
		}
		
		function isInteger(a)
		{
			if (a.split(\" \").join(\"\").length == 0)
			{
				return false;
			}
			
			var Anum = \"0123456789\";
			
			for (i=0;i<a.length;i++)
			{
				if (Anum.indexOf(a.substr(i,1)) == -1)
				{
					return false;
				}		
			}
			
			return true;
		}

		function _" . $frm ."_GotoPage(a)
		{
			if(_" . $frm ."_chkpgsize())
			{
				if(isInteger(document.frm.txtpageno.value))
				{
					if(document.frm.txtpageno.value<=". $this->intPageSize ." && document.frm.txtpageno.value>0)
					{
						document.frm.txtcurrentpage.value=a;
						if (a==-1) 
						{
							document.frm.txtcurrentpage.value=document.frm.txtpageno.value;
						}
						document.frm.action=\"" . $this->page ."\";
						document.frm.submit();
					}
					else
					{
						alert(\"Please enter valid page no.\");
					}
				}
				else
				{
					alert(\"Please enter valid page no.\");
					document.frm.txtpageno.focus();
					return false;
				}
			}
		}
		
		function _" . $frm ."_intDigits()
		{
			if(event.keyCode>=48 && event.keyCode<=57) {}
			else
			{	event.keyCode=0;	}
		}
		
		function _" . $frm ."_trim(tmp)
		{
			//var temp;
			temp = tmp;
			//tmp = \"      this is test     \";
			pat = /^\s+/;
			temp = temp.replace(pat, \"\");
			pat = /\s+$/;
			temp = temp.replace(pat, \"\");
			//alert(\":\" + tmp + \":\");
			return temp;
		}
		
		/* function is_int(value){
		  if((parseFloat(value) == parseInt(value)) && !isNaN(value)){
			  return true;
		  } else { 
			  return false;
		  } 
		} */
		
		function _" . $frm ."_chkpgsize()
		{
			//var flg=false;
			if(_" . $frm ."_trim(document.frm.txtpagesize.value).length>0)
			{
				if(parseInt(_" . $frm ."_trim(document.frm.txtpagesize.value))>0)
				{
					
					flg=true;
				}
				else
				{
					alert(\"Records per page can not be zero or less than zero.\");
					document." . $frm .".txtpagesize.focus();
				}
			}
			else
			{
				alert(\"Please enter No. of Records per page.\")
			}
			
			return flg;
		}
		function go(a,b,action)
		{
			
			if (b != 'go')
			{
				if ( a != 'nothing' && a != '' )
				{ 
					document.frm.hdnorderby.value = a;
					document.frm.hdnorder.value = b;	
				}
			}
			
			if (b == 'go')
			{
			}	
		
			document.frm.submit();
		}
		
		</script>";
		
		print $strJScript;
	
	}
	
	function _sortimages($colname, $strActionFile)
	{	
		$colname = strtolower(trim($colname));
		
		if (!empty($_REQUEST['hdnorderby']))	$sortcolumn = $_REQUEST['hdnorderby'];
		else 								$sortcolumn = "";
		
		if (!empty($_REQUEST['hdnorder']))		$sortorder = $_REQUEST['hdnorder'];
		else 								$sortorder = "";
		

		//For Default Sort column & sort order
		if (!empty($this->strorderby)) $sortcolumn = $this->strorderby;
		
		if (!empty($this->strorder)) $sortorder = $this->strorder;


		if ($sortcolumn == $colname)
		{
			if ($sortorder == "desc")
			{
				print "<a href=\"JavaScript:go('$colname','asc','$strActionFile');\" title='Ascending'><img src=\"" . ADMIN_THEME . "images/icons/arrow_down_mini.gif\" align=\"top\" border=\"0\"></a>";
				print "<a href=\"JavaScript:go('$colname','desc','$strActionFile');\" title='Descending'><img src=\"" . ADMIN_THEME . "images/icons/arrow_up_green_mini.gif\" align=\"top\" border=\"0\"></a>";
			}
			else
			{
				print "<a href=\"JavaScript:go('$colname','asc','$strActionFile');\" title='Ascending'><img src=\"" . ADMIN_THEME . "images/icons/arrow_down_green_mini.gif\" align=\"top\" border=\"0\"></a>";
				print "<a href=\"JavaScript:go('$colname','desc','$strActionFile');\" title='Descending'><img src=\"" . ADMIN_THEME . "images/icons/arrow_up_mini.gif\" align=\"top\" border=\"0\"></a>";
			}
		}
		else
		{
			print "<a href=\"JavaScript:go('$colname','asc','$strActionFile');\" title='Ascending'><img src=\"" . ADMIN_THEME . "images/icons/arrow_down_mini.gif\" align=\"top\" border=\"0\"></a>";
			print "<a href=\"JavaScript:go('$colname','desc','$strActionFile');\" title='Descending'><img src=\"" . ADMIN_THEME . "images/icons/arrow_up_mini.gif\" align=\"top\" border=\"0\"></a>";
		}
	
		return true;
	}
}

?>