<?php
	require_once 'include/general_includes.php';
	
	$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);
	
	$objpaging = new paging();
	
	$objLanguage = new language();
		
	require_once SERVER_ADMIN_ROOT.'language_db.php';
	
	$condition = "";
	
	$objpaging->strorderby = "language_id";
	$objpaging->strorder = "desc";
	
	$arr = $objpaging->setPageDetails($objLanguage,"language_list.php",PAGESIZE,$condition);
	
	$extraJs = array("language.js");

	$aAccess = $cmn->getAccess("language_detail.php", "language_detail", 3);	
	
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
                  <div class="fleft">Languages</div>
                  <div class="fright"> <?php print $cmn->getAdminMenuLink("language_addedit.php","language_addedit","Create","","add_new.png");?> </div>
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
                         
                            <td width="40%" align="left" nowrap="nowrap"><strong>Language Name</strong></a><?php $objpaging->_sortImages("language_name", $cmn->getCurrentPageName()); ?></td>
                           <td width="10%" align="left"><strong>Active</strong><?php $objpaging->_sortImages("language_isactive", $cmn->getCurrentPageName()); ?></td>
                            <?php 
							if ($aAccess[0])
							{
							?>
                           <td width="10%" align="center">Action</td>
                           <?PHP } ?>
                          </tr>
                          <?php 
						for ($i=0;$i<count($arr);$i++)
						{ 
							$arlanguage_id[] = $arr[$i]["language_id"] ?>
                          <?php if($i%2==0) $strrow_class = "row01"; else $strrow_class="row2";?>
                          <tr class="<?php echo $strrow_class?>">
                          
                            <td align="left">
                            
                             <?php 
							if ($aAccess[0])
							{
							?>
                            
                            <a href="language_detail.php?language_id=<?php print $cmn->getVal($arr[$i]["language_id"]); ?>" title="<?php print htmlspecialchars($arr[$i]["language_name"]); ?>"><?php print htmlspecialchars($arr[$i]["language_name"]); ?></a>
                            <?php 
							} 
							else 
							{
								print htmlspecialchars($arr[$i]["language_name"]);	
							}
							
							?>
                            
                            </td>
                            <td align="left">&nbsp;<?php if ($arr[$i]["language_isactive"] == 1) { echo "Yes"; } else { echo "No";} ?></td>
                             <?php 
							if ($aAccess[0])
							{
							?>
                           <td align="center">
                           
                            
								
                            <a href="language_detail.php?language_id=<?php print $cmn->getVal($arr[$i]["language_id"]); ?>" class="gray_btn_view" title="View">View</a>
                           
                            </td>
                           <?php 
							
							} 
							
							?>
                           
                           
                          </tr>
                          <?php 
						}
						 if(!empty($arlanguage_id)) 
						 	$inactiveids = implode(",",$arlanguage_id); 
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
