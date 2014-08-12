<?php
	require_once 'include/general_includes.php';
	
	$cmn->isAuthorized("index.php", ADMIN_USER_ID);
	$objEncDec = new encdec();
	$objpaging = new paging();
	
	$objEmaiTemplates = new email_templates();
		
	require_once SERVER_CLIENT_ROOT.'email_template_db.php';
	
	$userID = $cmn->getSession(ADMIN_USER_ID);
	$objClient = new client();
	$client_id = $objClient->fieldValue("client_id",$userID);

	$condition = " AND ".DB_PREFIX."email_templates.client_id='".$client_id."' AND email_isactive='1'";
	$condition1 = " AND ".DB_PREFIX."email_templates.client_id='0' AND email_isactive='1' AND ".DB_PREFIX."email_templates.email_type NOT IN (select email_type from ".DB_PREFIX."email_templates where client_id='".$client_id."' AND email_isactive='1') AND email_templates_id IN (2,4) ";
	$objpaging->strorderby = "email_templates_name";
	$objpaging->strorder = "desc";
	
	if(isset($_REQUEST['txtsearchname']))
	{
		if (trim($_REQUEST['txtsearchname'])!="")
		{
			$condition .= " and (".DB_PREFIX."email_templates.email_templates_name like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%' ) ";
			$condition1 .= " and (".DB_PREFIX."email_templates.email_templates_name like '%".$cmn->setVal(trim($_REQUEST['txtsearchname']))."%' ) ";
		}	
	}
	
	$condition_arr = array($condition, $condition1);
	$arr = $objpaging->setPageDetailsNew($objEmaiTemplates,"email_template_list.php",PAGESIZE,$condition_arr);
	
	$extraJs = array("email_template.js");

	$aAccess = $cmn->getAccessClient("email_template_addedit.php", "email_template_addedit", 2);	
	
	include SERVER_CLIENT_ROOT."include/header.php";
	include SERVER_CLIENT_ROOT."include/top.php";
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
           
            <div class="content-box">
              	<div class="content-left-shadow">
                	<div class="content-right-shadow">
                        <div class="content-box-lt">
                            <div class="content-box-rt">
                                <div class="blue_title_cont">								
            <form id="frm" name="frm" method="post">
              <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                  <td width="100%"><div class="white">                      
                        <table cellpadding="5" cellspacing="0" border="0" class="border-none" width="100%" style="clear:both;" >
                          <tr class="row02">
                              <td width="100%" align="left"><table width="100%" class="listtab-rt-bro" cellspacing="0" cellpadding="5">
                                <tbody>
                                  <tr>
                                    <td width="5%" valign="middle" align="left"><strong>Keyword:</strong></td>
                                    <td width="18%" valign="middle"><input type="text" class="input-small" name="txtsearchname" value="<?php print htmlspecialchars($cmn->readValue($_REQUEST['txtsearchname'],""));?>" /></td>
                                    <td width="74%" valign="middle"><input type="submit" onClick="document.frm.txtcurrentpage.value = 1; document.frm.txtpageno1.value = 1;  javascript: search_record(this.form);" class="btn" value="Search" title="Search" alt="Search" name="btnsearch" id="btnsearch"/>
                                      &nbsp;&nbsp;
                                      <input type="button" class="btn" title="Clear" alt="Clear" value="Clear" name="btnclear" id="btnclear" onclick="javascript: window.location.href='email_template_list.php';"/></td>
                                  </tr>
                                </tbody>
                              </table></td>
                          </tr>
						  <table cellpadding="0" cellspacing="0" border="0" class="listtab" width="100%" style="clear:both;" >
                          <tr bgcolor="#a9cdf5" class="txtbo">
                         
                            <td width="78%" align="left" nowrap="nowrap"><strong>Email Template Name</strong></a><?php $objpaging->_sortImages("email_templates_name", $cmn->getCurrentPageName()); ?></td>
                            <?php 
							if ($aAccess[0])
							{
							?>
                           <td width="22%" align="center" class="listtab-rt-bro-user"><strong>Action</strong></td>
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
                            <a title="<?php print htmlspecialchars($arr[$i]["email_templates_name"]); ?>" href="email_template_addedit.php?hdnemail_templates_id=<?php print $objEncDec->encrypt($cmn->readValueDetail($arr[$i]["email_templates_id"])); ?>"><?php print $cmn->readValueDetail($arr[$i]["email_templates_name"]); ?></a>
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
                           <td align="center" class="listtab-rt-bro-user"><a title="Edit" href="email_template_addedit.php?hdnemail_templates_id=<?php print $objEncDec->encrypt($cmn->readValueDetail($arr[$i]["email_templates_id"])); ?>" class="gray_btn_view">Edit</a></td>
                           <? }
                           ?>
                          </tr>
                          <?php 
						}
						 if(!empty($aremail_templates_id)) 
						 	$inactiveids = implode(",",$aremail_templates_id); 
						 if (count($arr)==0){ ?>
                          <tr>
                            <td colspan="<?php echo $aAccess[1]; ?>" align="center" class="listtab-rt-bro-user">No record found.</td>
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
              </table></td>
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
        </div>
      </div>
    </div>
  </div>
</div>
<?php include SERVER_CLIENT_ROOT."include/footer.php"; ?>
</body>
</html>