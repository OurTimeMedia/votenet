<?php
	require_once 'include/general_includes.php';
	
	$cmn->isAuthorized("index.php", SYSTEM_ADMIN_USER_ID);
	
	$objpaging = new paging();
	
	$objEmaiTemplates = new email_templates();
		
	require_once SERVER_ADMIN_ROOT.'email_template_db.php';
	
	$condition = " AND ".DB_PREFIX."email_templates.client_id='0' AND email_isactive='1'";
	$objpaging->strorderby = "email_templates_id";
	$objpaging->strorder = "desc";
	
	$arr = $objpaging->setPageDetails($objEmaiTemplates,"email_template_list.php",PAGESIZE,$condition);
	
	$extraJs = array("email_template.js");

	$aAccess = $cmn->getAccess("email_template_addedit.php", "email_template_addedit", 4);	
	
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
                  <div class="fleft">Email Templates</div>
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
                         
                            <td width="78%" align="left" nowrap="nowrap"><strong>Email Template Name</strong></a><?php $objpaging->_sortImages("email_templates_name", $cmn->getCurrentPageName()); ?></td>
                            <?php 
							if ($aAccess[0])
							{
							?>
                           <td width="22%" align="center">Action</td>
                           <?php
							}
							?>
                          </tr>
                          <?php 
						for ($i=0;$i<count($arr);$i++)
						{ 
							$aremail_templates_id[] = $arr[$i]["email_templates_id"] ?>
                          <?php if($i%2==0) $strrow_class = "row01"; else $strrow_class="row2";?>
                          <tr class="<?php echo $strrow_class?>">
                          
                            <td align="left">
                            
                             <?php 
							if ($aAccess[0])
							{
							?>
                            <a title="<?php print $cmn->readValueDetail($arr[$i]["email_templates_name"]); ?>" href="email_template_addedit.php?hdnemail_templates_id=<?php print $cmn->readValueDetail($arr[$i]["email_templates_id"]); ?>"><?php print $cmn->readValueDetail($arr[$i]["email_templates_name"]); ?></a>
                            <?php
							}
							else 
							{
								print $cmn->readValueDetail($arr[$i]["email_templates_name"]);
							}
							?>
                            </td>
                            <?php 
							if ($aAccess[0])
							{
							?>
                           <td align="center"><a title="Edit" href="email_template_addedit.php?hdnemail_templates_id=<?php print $cmn->readValueDetail($arr[$i]["email_templates_id"]); ?>" class="gray_btn_view">Edit</a></td>
                           <?php }
                           ?>
                          </tr>
                          <?php 
						}
						 if(!empty($aremail_templates_id)) 
						 	$inactiveids = implode(",",$aremail_templates_id); 
						 if (count($arr)==0){ ?>
                          <tr>
                            <td colspan="<?php echo $aAccess[1]; ?>" align="center">No record found.</td>
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