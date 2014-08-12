<?php
require_once 'include/general_includes.php';
	
$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);
$objpaging = new paging();
$objStateParty = new party_state();
$objState = new state();

$state_id = 0;

require_once 'partystate_db.php';
/*$join = "right join ".DB_PREFIX."party_state on ".DB_PREFIX."party_state.state_id=".DB_PREFIX."state.state_id join ".DB_PREFIX."party on ".DB_PREFIX."party.party_id=".DB_PREFIX."party_state.party_id ";
$condition = "group by ".DB_PREFIX."state.state_id";*/

$condition = '';
if(isset($_REQUEST['selState']))
{
	$state_id = $_REQUEST['selState'];
	
	if (trim($_REQUEST['selState'])!="")
		$condition .= " AND s.state_id = '".$state_id."' ";	
					
}

$objpaging->strorderby = "s.state_code";
$objpaging->strorder = "asc";
$objStateParty->pagingType="statedata";
//$arr = $objpaging->setPageDetails($objState,"partystate_list.php",PAGESIZE,$condition,0,$join);
$arr = $objpaging->setPageDetails($objStateParty,"partystate_list.php",PAGESIZE,$condition);
$extraJs = array("party_state.js");
$aAccess = $cmn->getAccess("partystate_list.php", "partystate_list", 11);	
//print_r($arr);

$arrState = $objState->fetchAllAsArray();

include SERVER_ADMIN_ROOT."include/header.php";
include SERVER_ADMIN_ROOT."include/top.php";
?>
<div class="content_mn">
  <div class="content_mn2">
    <div class="cont_mid">
      <div class="cont_lt">
        <div class="cont_rt">
         <div class="user_tab_mn">
           <?php $msg->displayMsg(); ?> 
            <div class="blue_title">
              <div class="blue_title_lt">
                <div class="blue_title_rt">
                  <div class="fleft">State - Party Join</div>
                  <div class="fright"> 
				  	<?php print $cmn->getAdminMenuLink("partystate_addedit.php","partystate_addedit","Create","","add_new.png");?> 
				  </div>
                </div>
              </div>
            </div>
            <div class="blue_title_cont">
            <form id="frm" name="frm" method="post">			 
              <table cellpadding="0" cellspacing="0" border="0" width="100%">				
                <tr>
                  <td><div>
                    <table cellpadding="0" cellspacing="0" border="0" class="listtab" width="100%" style="clear:both;">
					  <tr>
					  <td <?php if ($aAccess[0]) { ?> colspan="4"<?php } else { ?> colspan="3"<?php } ?> class="row2">	
						<table width="100%" cellspacing="0" cellpadding="0">                                
						 <tr>                                   
						  <td width="100%" alogn="left" valign="middle">
							<strong>State:</strong>&nbsp;                  
								<select name="selState" id="selState" onchange="document.frm.submit();">
								  <option value="">All State</option>
								  <?php for ($i=0;$i<count($arrState);$i++){ ?>
								  <option value="<?php echo $arrState[$i]['state_id'];?>" <?php if($arrState[$i]['state_id'] == $state_id) { echo "selected";} ?>><?php echo $arrState[$i]['state_code'];?> - <?php echo $arrState[$i]['state_name'];?></option>
								  <?php } ?>
							  </select>
						  </td>
						</tr>
						</table>
					  </td>
					</tr>	
                      <tr bgcolor="#a9cdf5" class="txtbo">
                        <td width="30%" align="left" nowrap="nowrap"><strong>State Code</strong>
                            <?php $objpaging->_sortImages("state_code", $cmn->getCurrentPageName()); ?></td>
						<td width="30%" align="left" nowrap="nowrap"><strong>State Name</strong>
                            <?php $objpaging->_sortImages("state_name", $cmn->getCurrentPageName()); ?></td>	
						<td width="30%" align="left" nowrap="nowrap"><strong>Party Name</strong></td>
                        <?php  
							if ($aAccess[0])
							{
							?>
                        <td width="10%" align="center">Action</td>
                        <?php
							}
							?>
                      </tr>
                      <?php 
				for ($i=0;$i<count($arr);$i++)
				{ 
					$condition=" and s.state_id=".$arr[$i]['state_id'];
			$partydata=$objStateParty->fetchAllAsArray($condition);
			//print_r($partydata);
			//$arparty_state_id[] = $partydata[$i]["party_state_id"] 
?>
                      <?php if($i%2==0) $strrow_class = "row01"; 
					  else $strrow_class="row2";
					  ?>
					  
                      <tr class="<?php echo $strrow_class?>">
					  <td align="left" valign="top"><?php echo $cmn->readValueDetail($arr[$i]["state_code"]);?>&nbsp;</td>  
                        <td align="left" valign="top"><?php echo $cmn->readValueDetail($arr[$i]["state_name"]);?>&nbsp;</td>  
                        <td align="left" valign="top">
					 
                <?php
					for($k=0;$k<count($partydata);$k++)
echo $cmn->readValueDetail($partydata[$k]["party_name"])."<br> ";?>         
			&nbsp;	</td>
                        <?php 
			
							if ($aAccess[0])
							{
							?>
                        <td align="center" valign="top"><a title="View" href="partystate_detail.php?state_id=<?php print $cmn->readValueDetail($arr[$i]["state_id"]); ?>" class="gray_btn_view">View</a></td>
                        <?php
							}
							
					  
                            ?>
                      </tr>
                      <?php 
						
}
						 if(!empty($arparty_state_id)) 
						 	$inactiveids = implode(",",$arparty_state_id); 
						 if (count($arr)==0){ ?>
                      <tr>
                        <td colspan="<?php echo $aAccess[1] ?>" align="center">No record found.</td>
                      </tr>
                      <?php } else { ?>
                      <input type="hidden" name="inactiveids" value="<?php print $inactiveids; ?>" />
                      <input type="hidden" name="hdnmode" id="hdnmode" value="<?php echo $strmode; ?>"/>
                      <?php } ?>
                    </table>
                  </div>
                    <div class="fclear"></div></td>
                </tr>
                <tr>
                  <td><div id="pager"><?php print $objpaging->drawPanel("panel1"); ?></div></td>
                </tr>
              </table>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
	<?php include SERVER_ADMIN_ROOT."include/footer.php"; ?>