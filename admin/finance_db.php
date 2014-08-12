<?php
	require_once("include/general_includes.php");
	$main_menu = 1;
	$submenu_id = 3;
	
	/**
	 * If you want to add any specific js Or css for this particular page please 
	 * add this in array & put that files in particular admin js Or admin css folder
	 * 
	 * i.e. $extraCss = array('extra1.css', 'extra2.css', 'extra3.css');
	 * 		$extraJs = array('extra1.js', 'extra2.js', 'extra3.js');
	 */
	$extraCss = array();
	$extraJs  = array();
	
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

                  <div class="fleft">All Payments</div>
                  <div class="fright"> <!--<img src="images/add_new.png" alt="" /> <a href="admin_user_addedit.php">Create</a>-->
				  <?php print $cmn->getMenuLink("admin_user_addedit.php","admin_user_add","Create","","add_new.png");?>
				  </div>
                </div>
              </div>
            </div>
            <div class="blue_title_cont">
              <table width="100%" cellpadding="0" cellspacing="0" border="0">
                <form id="frm" name="frm" method="post">
                  <tr>
                    <td><div class="">
                        <table cellpadding="0" cellspacing="0" border="0" class="listtab" width="100%" style="clear:both;" >
                          <tr>
                            <td colspan="7" align="left"><table width="100%" cellspacing="0" cellpadding="0">
                                <tbody>
                                  <tr>
                                    <td width="5%" valign="middle" align="left"><strong>Keyword:</strong></td>
                                    <td width="18%" valign="middle"><input type="text" value="" class="input-small" name="txtsearchname"/></td>
                                    <td width="74%" valign="middle"><input type="button" onClick="javascript: search_record(this.form);" class="btn" value="Search" name="btnsearch" id="btnsearch"/>
                                      &nbsp;&nbsp;
                                      <input type="button" class="btn" value="Clear" name="btnclear" id="btnclear"/></td>
                                  </tr>
                                </tbody>
                              </table></td>
                          </tr>
                          <tr bgcolor="#a9cdf5" class="txtbo">
                            <td width="12%" align="left" nowrap="nowrap"><a href="#"><strong>Username</strong></a><img border="0" align="texttop" src="images/arrow_down_green_mini.gif"/></td>
                            <td  width="12%" align="left"><a href="#"><strong>First Name</strong></a></td>
                            <td width="12%" align="left"><a href="#"><strong>Last Name</strong></a></td>
                            <td width="15%" align="left"><a href="#"><strong>Designation</strong></a></td>
                            <td width="22%" align="left"><a href="#"><strong>E-mail</strong></a></td>
                            <td width="17%" align="center"><a href="#"><strong>Phone</strong></a></td>
                            <td width="10%" align="center">Action</td>
                          </tr>
                          <tr class="row01">
                            <td align="left"><a href="admin_user_detail.php">fmorris</a></td>
                            <td align="left">Forrest</td>
                            <td align="left">Morris</td>
                            <td align="left">CEO</td>
                            <td align="left"><a href="mailto:fmorris@domainname.com">fmorris@domainname.com</a></td>
                            <td align="center">(295) 193-4744</td>
                            <td align="center"><a href="admin_user_detail.php" class="gray_btn_view">View</a></td>
                          </tr>
                          <tr class="row2">
                            <td align="left"><a href="admin_user_detail.php">iweeks</a></td>
                            <td align="left">Ivor</td>
                            <td align="left">Weeks</td>
                            <td align="left">Sales and Marketing</td>
                            <td align="left"><a href="mailto:iweeks@domainname.com">iweeks@domainname.com</a></td>
                            <td align="center">(961) 215-1408</td>
                            <td align="center"><a href="admin_user_detail.php" class="gray_btn_view">View</a></td>
                          </tr>
                          <tr class="row01">
                            <td align="left"><a href="admin_user_detail.php">lolson</a></td>
                            <td align="left">Len</td>
                            <td align="left">Olson</td>
                            <td align="left">Human Resources</td>
                            <td align="left"><a href="mailto:lolson@domainname.com">lolson@domainname.com</a></td>
                            <td align="center">(974) 675-6687</td>
                            <td align="center"><a href="admin_user_detail.php" class="gray_btn_view">View</a></td>
                          </tr>
                          <tr class="row2">
                            <td align="left"><a href="admin_user_detail.php">ksaunders</a></td>
                            <td align="left">Keane</td>
                            <td align="left">Saunders</td>
                            <td align="left">Finances</td>
                            <td align="left"><a href="mailto:ksaunders@domainname.com">ksaunders@domainname.com</a></td>
                            <td align="center">(768) 938-8730</td>
                            <td align="center"><a href="admin_user_detail.php" class="gray_btn_view">View</a></td>
                          </tr>
                          <tr class="row01">
                            <td align="left"><a href="admin_user_detail.php">ptanner</a></td>
                            <td align="left">Patrick</td>
                            <td align="left">Tanner</td>
                            <td align="left">Tech Support</td>
                            <td align="left"><a href="mailto:ptanner@domainname.com">ptanner@domainname.com</a></td>
                            <td align="center">(554) 296-3521</td>
                            <td align="center"><a href="admin_user_detail.php" class="gray_btn_view">View</a></td>
                          </tr>
                        </table>
                        <div class="fclear"></div>
                      </div></td>
                  </tr>
                  <tr>
                    <td><?php include SERVER_ROOT."include/pager.php";?></td>
                  </tr>
                </form>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include "include/footer.php";?>

