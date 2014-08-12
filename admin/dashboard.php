<?php
//include general base file
require_once("include/general_includes.php");

//check admin authentication
$cmn->isAuthorized(SERVER_ADMIN_HOST."index.php", SYSTEM_ADMIN_USER_ID);

// css file	array		
$extraCss = array();

// JS file	array		
$extraJs  = array();

//call adminmenu class
$objAdminMenu = new adminmenu();
$condition="";

$objTopClient = new topclientreport();
$sourcedata=$objTopClient->topResourceDetailDashboard();

include SERVER_ADMIN_ROOT."include/header.php";
include SERVER_ADMIN_ROOT."include/top.php";
?>
<!--Start content -->
  <div class="content_mn">
    <div class="content_mn2">
      <div class="cont_mid">
        <div class="cont_lt">
          <div class="cont_rt">            
          <?php $msg->displayMsg(); ?>          
            <div class="txt18blue padlttop"><strong><?php echo $cmn->getSession(SYSTEM_ADMIN_USER_DISPLAYNAME) ?>,</strong> welcome to Election Impact System Administration Control Panel.</div>
            <div class="blue_title_cont">
                <table cellpadding="0" cellspacing="0" width="100%">
                  <tr valign="top">                   
                    <td>
						<div class="tabmn">
                        <div class="cont_tabs"> <span>
                          <label>Summary Till Date</label>
                        </span> </div>
						<div class="summary">&nbsp;
                            <div class="left">Clients</div>
                        <div class="left_cnt"><b><?PHP echo $objAdminMenu->getTotClients(); ?></b></div>
                        <div class="left">Voter Registration</div>
                        <div class="left_cnt"><b>
                          <?PHP 
						echo $sourcedata[0]['tot_registration']; ?>
                        </b></div>
                        <div class="left">Facebook Users</div>
                        <div class="left_cnt"><b>
						<?PHP 
						echo $sourcedata[0]['tot_cnt_facebook']; ?>
						</b></div>                      
                        <div class="left">Gadget</div>
                        <div class="left_cnt"><b><?PHP 
						echo $sourcedata[0]['tot_cnt_gadget']; ?></b></div>
                        <div class="fclear"></div>
                      </div>                      
                      <div class="cont_tabs_bott">&nbsp;</div>
                    </div>
					<?php $sourcedata=$objTopClient->topResourceDetailDashboard("today"); ?>
                        <div class="tabmn">
                          <div class="cont_tabs"> <span>
                            <label>Today's Summary </label>
                          </span></div>
							<div class="summary"> &nbsp;
                              <div class="left">Clients</div>
                            <div class="left_cnt"><b><?PHP echo $objAdminMenu->getTotClients("today"); ?></b></div>
                            <div class="left">Voter Registration</div>
							<div class="left_cnt"><b>
							  <?PHP 
							echo $sourcedata[0]['tot_registration']; ?>
							</b></div>
							<div class="left">Facebook Users</div>
							<div class="left_cnt"><b>
							<?PHP 
							echo $sourcedata[0]['tot_cnt_facebook']; ?>
							</b></div>                      
							<div class="left">Gadget</div>
							<div class="left_cnt"><b><?PHP 
							echo $sourcedata[0]['tot_cnt_gadget']; ?></b></div>
                            <div class="fclear"></div>
                          </div>                          
                          <div class="cont_tabs_bott">&nbsp;</div>
                        </div>
						<?php $sourcedata=$objTopClient->topResourceDetailDashboard(7); ?>
                      <div class="tabmn">
                          <div class="cont_tabs"> <span>
                            <label><span>Summary Of The Week </span></label>
                          </span></div>
                        <div class="summary"> &nbsp;
                              <div class="left">Clients</div>
							<div class="left_cnt"><b><?PHP echo $objAdminMenu->getTotClients(7); ?></b></div>
							<div class="left">Voter Registration</div>
							<div class="left_cnt"><b>
							  <?PHP 
							echo $sourcedata[0]['tot_registration']; ?>
							</b></div>
							<div class="left">Facebook Users</div>
							<div class="left_cnt"><b>
							<?PHP 
							echo $sourcedata[0]['tot_cnt_facebook']; ?>
							</b></div>                      
							<div class="left">Gadget</div>
							<div class="left_cnt"><b><?PHP 
							echo $sourcedata[0]['tot_cnt_gadget']; ?></b></div>
                          <div class="fclear"></div>
                        </div>
                        <div class="cont_tabs_bott">&nbsp;</div>
                      </div>
					  <?php $sourcedata=$objTopClient->topResourceDetailDashboard(30); ?>
                      <div class="tabmn">
                          <div class="cont_tabs"> <span>
                            <label><span>Last 30 Days Summary</span></label>
                          </span></div>
                        <div class="summary"> &nbsp;
                              <div class="left">Clients</div>
							<div class="left_cnt"><b><?PHP echo $objAdminMenu->getTotClients(30); ?></b></div>
							<div class="left">Voter Registration</div>
							<div class="left_cnt"><b>
							  <?PHP 
							echo $sourcedata[0]['tot_registration']; ?>
							</b></div>
							<div class="left">Facebook Users</div>
							<div class="left_cnt"><b>
							<?PHP 
							echo $sourcedata[0]['tot_cnt_facebook']; ?>
							</b></div>                      
							<div class="left">Gadget</div>
							<div class="left_cnt"><b><?PHP 
							echo $sourcedata[0]['tot_cnt_gadget']; ?></b></div>
                          <div class="fclear"></div>
                        </div>
                        <div class="cont_tabs_bott">&nbsp;</div>
                      </div>
					  <?php $sourcedata=$objTopClient->topResourceDetailDashboard("Year"); ?>
                      <div class="tabmn">
                          <div class="cont_tabs"> <span>
                            <label>Summary of this Year </label>
                          </span></div>
                        <div class="summary"> &nbsp;
                              <div class="left">Clients</div>
							<div class="left_cnt"><b><?PHP echo $objAdminMenu->getTotClients("Year"); ?></b></div>
							<div class="left">Voter Registration</div>
							<div class="left_cnt"><b>
							  <?PHP 
							echo $sourcedata[0]['tot_registration']; ?>
							</b></div>
							<div class="left">Facebook Users</div>
							<div class="left_cnt"><b>
							<?PHP 
							echo $sourcedata[0]['tot_cnt_facebook']; ?>
							</b></div>                      
							<div class="left">Gadget</div>
							<div class="left_cnt"><b><?PHP 
							echo $sourcedata[0]['tot_cnt_gadget']; ?></b></div>
                          <div class="fclear"></div>
                        </div>
                        <div class="cont_tabs_bott">&nbsp;</div>
                      </div>
                    </td>
                  </tr>
                </table>
            </div>
          </div>
        </div>
      </div>
    </div>
   </div>
<?php
	include SERVER_ADMIN_ROOT."include/footer.php";
?>