<?php
	require_once 'include/general_includes.php';
	
	$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);
	
	$objpaging = new paging();
	
	$objResource = new resource();
		
	require_once 'resource_db.php';
	
	$condition = "";
	
	$objpaging->strorderby = "resource_id";
	$objpaging->strorder = "desc";
	
	$arr = $objpaging->setPageDetails($objResource,"resource_list.php",PAGESIZE,$condition);
	
	$extraJs = array("resource.js");
?>
<?php
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
                  <div class="fleft">Resources</div>
                  <div class="fright"> <img src="<?php echo SERVER_ADMIN_HOST ?>images/add_new.png"  /> <a href="<?php echo SERVER_ADMIN_HOST ?>resource_addedit.php"> Create </a> </div>
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
                         
                            <td width="12%" align="left" nowrap="nowrap"><strong>Resource Title</strong></a><?php $objpaging->_sortImages("resource_name", $cmn->getCurrentPageName()); ?></td>
                            <td  width="40%" align="left"><strong>Resource Text</strong><?php $objpaging->_sortImages("resource_text", $cmn->getCurrentPageName()); ?></td>
                            
                            <td  width="20%" align="left"><strong>Resource Page</strong><?php $objpaging->_sortImages("resource_page", $cmn->getCurrentPageName()); ?></td>
                            <td width="10%" align="left"><strong>Active</strong><?php $objpaging->_sortImages("resource_isactive", $cmn->getCurrentPageName()); ?></td>
                            <td width="12%" align="left"><strong>Action</strong></td>
                            
                          </tr>
                          <?php 
						for ($i=0;$i<count($arr);$i++)
						{ 
							$arresource_id[] = $arr[$i]["resource_id"] ?>
                          <?php if($i%2==0) $strrow_class = "row01"; else $strrow_class = "row2";?>
                          <tr class="<?php echo $strrow_class?>">
                          
                            <td align="left"><a href="resource_detail.php?resource_id=<?php print $cmn->getVal($arr[$i]["resource_id"]); ?>"><?php print $cmn->getVal($arr[$i]["resource_name"]); ?></a></td>
                            <td align="left"><?php print $cmn->getVal($arr[$i]["resource_text"]); ?></td>
                            <td align="left"><?php print $cmn->getVal($arr[$i]["resource_page"]); ?></td>
                            <td align="left">&nbsp;<?php if ($arr[$i]["resource_isactive"] == 1) { echo "Yes"; } else { echo "No";} ?></td>
                            <td> <a href="resource_addedit.php?hdnresource_id=<?php print $cmn->getVal($arr[$i]["resource_id"]); ?>"> Edit </a> &nbsp; <a href="resource_list.php?resource_id=<?php print $cmn->getVal($arr[$i]["resource_id"]); ?>&btndelete=1"> Delete </a></td>
                          
                          </tr>
                          <?php 
						}
						 if(!empty($arresource_id)) 
						 	$inactiveids = implode(",",$arresource_id); 
						 if (count($arr)==0){ ?>
                          <tr>
                            <td colspan="5" align="center">No record found.</td>
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
