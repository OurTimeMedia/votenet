<?php
require_once 'include/general_includes.php';

// check if user has logged in
$cmn->isAuthorized("index.php", ADMIN_USER_ID);

$userID = $cmn->getSession(ADMIN_USER_ID);
$objClient = new client();
$client_id = $objClient->fieldValue("client_id", $userID);

$objEncDec = new encdec();
$objUser = new user();

$recentlyVisited = $cmn->getLatestVisits($cmn->getSession(ADMIN_USER_ID),5);

$objMenu = new menu();
$vistitedURLs = '';

if (!empty($recentlyVisited)) {
  foreach ($recentlyVisited as $visitedUrlVal) {
    $visitedUrl = $visitedUrlVal['visited_url'];
    if ($visitedUrl != '') {
      $aModuleUrlParts = explode(".", $visitedUrl);
      $moduleName = $aModuleUrlParts[0];

      $imenuParantDtl = $objMenu->getParentMenuID($moduleName);
	  
      $imenuParantDtl = explode("##", $imenuParantDtl);

      $sParentMenu = $objMenu->getMainParentMenu($imenuParantDtl[0]);

      if ($sParentMenu != '') {
        $fileEdit = explode("?", $visitedUrl);

        if (isset($fileEdit[1]) && strpos($fileEdit[0], "addedit") > -1) {
          $vistitedURLs.= '<li>' . $sParentMenu . ' &gt; <a href=' . CLIENT_SITE_URL . $visitedUrl . ' title="Edit">Edit</a></li>';
        } else {
          if (isset($imenuParantDtl[1])) {
            $vistitedURLs.= "<li>" . $sParentMenu . " &gt; <a href=" . CLIENT_SITE_URL . $visitedUrl . " title=" . htmlspecialchars($imenuParantDtl[1]) . ">" . htmlspecialchars($imenuParantDtl[1]) . "</a></li>";
          }
        }
      } else {
        if (isset($imenuParantDtl[1]))
          $vistitedURLs.= '<li>' . $imenuParantDtl[1] . ' &gt; <a href=' . CLIENT_SITE_URL . $visitedUrl . '>'. htmlspecialchars($imenuParantDtl[1]) .'</a></li>';
      }
    }
  }
}

$extraJs = array("jquery-1.4.4.js");

$aNotificationAccess = $cmn->getAccessClient("notifications_list.php", "notifications_list", 1);
$aNotificationAccess[0] = 1;

$objAdminMenu = new adminmenu();
$condition = " AND client_id = '" . $client_id . "' ";

$objClientDetail = new topclientreport();
$aryClientDetail = $objClientDetail->datewisedetail(date('Y-m-d'), date('Y-m-d'), '', $client_id);

if (!isset($aryClientDetail[0]['tot_cnt']))
  $aryClientDetail[0]['tot_cnt'] = 0;
?>
<?php
$cmn->defaultMenu = 0;
include SERVER_CLIENT_ROOT . "include/header_menu.php";
include SERVER_CLIENT_ROOT . "include/top.php";
?>
<div class="content_mn">
  <div class="content_mn2">
    <div class="cont_mid">
      <div class="cont_lt">
        <div class="cont_rt">
          <?php $msg->displayMsg(); ?>
          <div class="dashboard-cont">
            <table width="100%" cellspacing="0" cellpadding="0" border="0">
              <tbody><tr>
                  <td width="290" valign="top" align="left">
                    <?PHP
                    if ($aNotificationAccess[0]) {
                      include SERVER_CLIENT_ROOT . "setNotification.php";
                    }
                    ?>
                    <div class="glossymenu"><a style="background:url(<?PHP echo SERVER_CLIENT_HOST ?>images/most-recent-bg.png) no-repeat; height:45px; float:left; cursor:pointer; width:270px; padding:0px; z-index:999;" class="menuitem submenuheader blue_cat" href="javascript:;" headerindex="0h"><span class="accordprefix"></span><strong class="yellow_btn">&nbsp;</strong><span class="accordsuffix"><img class="statusicon" src="<?PHP echo SERVER_CLIENT_HOST ?>images/minus.gif"></span></a>
                      <div class="submenu-main">
                        <div style="float:left; width:100%;" class="submenu" contentindex="0c">
                          <ul>
                            <?php echo $vistitedURLs; ?>
                          </ul>
                        </div>
                        <div class="submenu-bot">&nbsp;</div>
                      </div>
                    </div>
                  </td>
                  <td valign="top" align="left">
                    <div class="dashboard-top-panel">
                      <table width="100%" cellspacing="0" cellpadding="0" border="0">
                        <tbody><tr>
                            <td width="100%" valign="top" align="left"><div class="dashboard-left-panel">
                                <div class="dashboard-bl-panel">
                                  <div class="dashboard-br-panel">
                                    <div class="dashboard-title">
                                      <div class="dashboard-tr-title">
                                        <div class="dashboard-tl-title">Voter Registration Count</div>
                                      </div>
                                    </div>
                                    <div class="dashboard-content">
                                      <table width="100%" cellspacing="0" cellpadding="0" border="0" style="clear:both;" class="listtab">
                                        <tbody><tr onmouseout="this.className='row01'" onmouseover="this.className='rowActive'" class="row01">
                                            <td align="left">Total Voters Registration </td>
                                            <td align="center" class="listtab-rt-bro-user"><a href="voter_registration_report.php?for=total"><?PHP echo $objAdminMenu->getTotVoters($condition); ?></a></td>
                                          </tr>
                                          <tr onmouseout="this.className='row02'" onmouseover="this.className='rowActive'" class="row01">
                                            <td align="left">Today</td>
                                            <td align="center" class="listtab-rt-bro-user"><a href="voter_registration_report.php?for=today"><?PHP echo $aryClientDetail[0]['tot_cnt']; ?></a></td>
                                          </tr>
                                          <tr onmouseout="this.className='row01'" onmouseover="this.className='rowActive'" class="row02">
                                            <td align="left">This Week</td>
                                            <td align="center" class="listtab-rt-bro-user"><a href="voter_registration_report.php?for=week"><?PHP echo $objAdminMenu->getTotVoters($condition, 7); ?></a></td>
                                          </tr>
                                          <tr onmouseout="this.className='row02'" onmouseover="this.className='rowActive'" class="row01">
                                            <td align="left">This Month</td>
                                            <td align="center" class="listtab-rt-bro-user"><a href="voter_registration_report.php?for=month"><?PHP echo $objAdminMenu->getTotVoters($condition, "Month"); ?></a></td>
                                          </tr>
                                          <tr onmouseout="this.className='row02'" onmouseover="this.className='rowActive'" class="row02">
                                            <td align="left">This Year</td>
                                            <td align="center" class="listtab-rt-bro-user"><a href="voter_registration_report.php?for=year"><?PHP echo $objAdminMenu->getTotVoters($condition, "Year"); ?></a></td>
                                          </tr>
                                        </tbody></table>
                                    </div>
                                  </div>
                                </div>
                              </div></td>
                          </tr>
                        </tbody></table>
                    </div>
                    <div id="map-text">State Registration Summary</div>
                    <div id="mapDiv">
					<?php 
					$flashvar = '<object codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0" width="640" height="393">
  <param name="flashvars" value="client_id='.$client_id.'" />				
  <param name="movie" value="http://www.electionimpact.com/client/map/usa1.swf" />  
  <param name="quality" value="high" />
  <embed flashvars="client_id='.$client_id.'" src="http://www.electionimpact.com/client/map/usa1.swf" quality="high" pluginspage="http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash" type="application/x-shockwave-flash" width="640" height="393"></embed>
</object>';
					echo $flashvar;
					?>
					
                    </div>
                  </td>
                </tr>
              </tbody></table>
            <div class="clear"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php include "include/footer.php"; ?>
</body>
</html>