<?php
	require_once 'include/general_includes.php';
	
	$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);
	
	$objpaging = new paging();
	
	$objTemplate = new template();
		
	require_once SERVER_ADMIN_ROOT.'template_db.php';
	
	$condition = "";
	
	$objpaging->strorderby = "template_id";
	$objpaging->strorder = "desc";
	
	$arr = $objpaging->setPageDetails($objTemplate,"template_list.php",PAGESIZE,$condition);
	
	$extraJs = array("template.js");
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
                  <div class="fleft">WebSite Templates</div>
                  <div class="fright">&nbsp;</div>
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
                         	<td width="22%" align="left" nowrap="nowrap"><strong>WebSite Image</strong></td>
                            <td width="58%" align="left" nowrap="nowrap"><strong>WebSite Name</strong></a><?php $objpaging->_sortImages("template_name", $cmn->getCurrentPageName()); ?></td>
                           
                            <td width="10%" align="left"><strong>Active</strong><?php $objpaging->_sortImages("template_isactive", $cmn->getCurrentPageName()); ?></td>
                           <td width="10%" align="left"><strong>Private</strong><?php $objpaging->_sortImages("template_isprivate", $cmn->getCurrentPageName()); ?></td>
                          </tr>
                          <?php 
						for ($i=0;$i<count($arr);$i++)
						{ 
							$artemplate_id[] = $arr[$i]["template_id"] ?>
                          <?php if($i%2==0) $strrow_class = "row01"; else $strrow_class="row2";?>
                          <tr class="<?php echo $strrow_class?>">
                          	<td width="22%" align="center" nowrap="nowrap"><img src='<?php echo SERVER_HOST ?>common/files/image.php/<?php echo $cmn->getVal($arr[$i]["template_thumb_image"])?>?width=135&amp;height=88&amp;cropratio=1:1&amp;image=/files/templates/<?php echo $cmn->getVal($arr[$i]["template_thumb_image"])?>' alt='<?php echo htmlspecialchars($arr[$i]["template_name"]); ?>' title='<?php echo htmlspecialchars($arr[$i]["template_name"]); ?>' /></td>
                            <td align="left"><?php print htmlspecialchars($arr[$i]["template_name"]); ?></td>
                       
                            <td align="left">&nbsp;<input type="checkbox" name="activeids[]" value="<?php print trim($arr[$i]['template_id']); ?>" <?php if($cmn->getVal($arr[$i]["template_isactive"])== 1) echo "checked=checked"; ?> /></td>
                          	<td align="left">&nbsp;<input type="checkbox" name="privateids[]" value="<?php print trim($arr[$i]['template_id']); ?>" <?php if($cmn->getVal($arr[$i]["template_isprivate"])== 1) echo "checked=checked"; ?> /></td>
                          </tr>
                          <?php 
						} $inactiveids = implode(",",$artemplate_id); ?>
						<tr>
                        	<td align="right" valign="top" colspan="4"><input title="Update" type="button" name="btnupdate" class="btn" value="Update" onclick="javascript: setaction('update','template_db.php');"/>
                      		</td>
                        </tr>
						<?PHP if(!empty($artemplate_id)) 
						 	$inactiveids = implode(",",$artemplate_id); 
						 if (count($arr)==0){ ?>
                          <tr>
                            <td colspan="4" align="center">No record found.</td>
                          </tr>
                          <?php } else { ?>
          
                              <input type="hidden" name="inactiveids" value="<?php print $inactiveids; ?>" />
                              <input type="hidden" name="hdnmode" id="hdnmode" value=""/>
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
