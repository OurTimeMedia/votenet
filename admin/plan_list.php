<?php
	require_once 'include/general_includes.php';
	
	$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);
	
	$objpaging = new paging();
	
	$objPlan = new plan();
		
	require_once 'plan_db.php';
	
	$condition = "";
	
	$objpaging->strorderby = "plan_id";
	$objpaging->strorder = "desc";
	
	$arr = $objpaging->setPageDetails($objPlan,"plan_list.php",PAGESIZE,$condition);
	
	$extraJs = array("plan.js");
	
	$aAccess = $cmn->getAccess("plan_detail.php", "plan_detail" , 7);		
	
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
                  <div class="fleft"> Plans</div>
                  <div class="fright"> <?php print $cmn->getAdminMenuLink("plan_addedit.php","plan_addedit","Create","","add_new.png");?> </div>
                </div>
              </div>
            </div>
           
            <div class="blue_title_cont">
            <form id="frm" name="frm" method="post">
              <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                  <td width="100%"><div style="width:100%;">
                      
                        <table cellpadding="0" cellspacing="0" border="0" class="listtab" width="100%" style="clear:both;">
                        
                          <tr bgcolor="#a9cdf5" class="txtbo">
                         
                            <td width="12%" align="left" nowrap="nowrap"><strong>Plan Title</strong></a><?php $objpaging->_sortImages("plan_title", $cmn->getCurrentPageName()); ?></td>
                            <td  width="40%" align="left"><strong>Description</strong><?php $objpaging->_sortImages("plan_description", $cmn->getCurrentPageName()); ?></td>
                            <td width="10%" align="right"><strong>Amount</strong><?php $objpaging->_sortImages("plan_amount", $cmn->getCurrentPageName()); ?></td>
                            <td width="10%" align="left"><strong>Active</strong><?php $objpaging->_sortImages("plan_isactive", $cmn->getCurrentPageName()); ?></td>
                            <td width="12%" align="left"><strong>Published</strong><?php $objpaging->_sortImages("plan_ispublish", $cmn->getCurrentPageName()); ?></td>
                             <?php 
							if ($aAccess[0])
							{
							?>
                            <td width="10%" align="center">Action</td>
                            <?php
                            
							} ?>
                          </tr>
                          <?php 
						for ($i=0;$i<count($arr);$i++)
						{ 
							$arplan_id[] = $arr[$i]["plan_id"] ?>
                          <?php if($i%2==0) $strrow_class = "row01"; else $strrow_class="row2";?>
                          <tr class="<?php echo $strrow_class?>">
                          
                            <td align="left">
                            
                             <?php 
							if ($aAccess[0])
							{
							?>
                            
                            <a title="<?php print htmlspecialchars($arr[$i]["plan_title"]); ?>" href="plan_detail.php?plan_id=<?php print htmlspecialchars($arr[$i]["plan_id"]); ?>"><?php print htmlspecialchars($arr[$i]["plan_title"]); ?></a>
                            <?php
							}
							else 
							{
								print htmlspecialchars($arr[$i]["plan_title"]); 
							}
							
                            ?>
                            </td>
                            <td align="left"><?php print htmlspecialchars($arr[$i]["plan_description"]); ?></td>
                            <td align="right">$<?php print htmlspecialchars($arr[$i]["plan_amount"]); ?></td>
                            <td align="left">&nbsp;<?php if ($arr[$i]["plan_isactive"] == 1) { echo "Yes"; } else { echo "No";} ?></td>
                            <td align="left"><?php if ($arr[$i]["plan_ispublish"] == 1) { echo "Yes"; } else { echo "No";} ?></td>
                            <?php 
							if ($aAccess[0])
							{
							?>
                            <td align="center">
                           <a title="View" href="plan_detail.php?plan_id=<?php print htmlspecialchars($arr[$i]["plan_id"]); ?>" class="gray_btn_view">View</a></td>
                           <?php 
							}
							?>
                          </tr>
                          <?php 
						}
						 if(!empty($arplan_id)) 
						 	$inactiveids = implode(",",$arplan_id); 
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
