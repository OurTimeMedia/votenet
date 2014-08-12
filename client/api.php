<?php	
require_once 'include/general_includes.php';
$cmn->isAuthorized("index.php", ADMIN_USER_ID);

$userID = $cmn->getSession(ADMIN_USER_ID);
$objClient = new client();
$client_id = $objClient->fieldValue("client_id",$userID);
//echo($client_id);
$objEncDec = new encdec();
$objpaging = new paging();
$extraCss = array("ui-lightness/jquery-ui-1.8.4.custom.css");	

$objWebsite = new website();
$objWebsite->selectAPIKeyByClientID($client_id);

if($objWebsite->IsActive) 
{
  $_REQUEST['st'] = 2;
  $_SESSION["APIKey"] = $objWebsite->api_key;
}
else
{
  $_REQUEST['st']=5;  
} 


?>
<?php
include SERVER_CLIENT_ROOT."include/header.php";
include SERVER_CLIENT_ROOT."include/top.php";

if(isset($_POST['submit']) || isset($_POST['submit_x']))
{
  $randNumber = random();
  $IsActive = 1;
  
  $objWebsite = new website();
  $objWebsite->client_id = $client_id;  
  $objWebsite->api_key = $randNumber;
  $objWebsite->IsActive = $IsActive;
  $objWebsite->updateAPI();
  
  $_REQUEST["st"] = 2;
}

function random()
{     
    $chars = 'bcdf789ghjk0lmnp456rstvwxzaeiou123';
    $result = '';
    for ($p = 0; $p < 26; $p++)
    {
        $result .= ($p%2) ? $chars[mt_rand(19, 23)] : $chars[mt_rand(0, 18)];
    }   
    $charid = strtoupper($result);
    $result =   substr($charid,  0, 4) . '-' .
                substr($charid,  4, 4) . '-' .
                substr($charid, 8, 8) . '-' .
                substr($charid, 16, 4) . '-' .
                substr($charid, 20, 4);
    return $result;
}
?>
<!--Start content -->
<div class="content_mn">
  <div class="content_mn2">
    <div class="cont_mid">
      <div class="cont_lt">
        <div class="cont_rt">
          <div class="user_tab_mn">
            <div class="blue_title">
              <div class="blue_title_lt">
                <div class="blue_title_rt">
                  <div class="fleft">API</div>
                  <div class="fright"></div>
                </div>
              </div>
            </div>
            <div class="content-box">
              <div class="content-left-shadow">
                <div class="content-right-shadow">
                  <div class="content-box-lt">
                    <div class="content-box-rt">
                      <div class="blue_title_cont">
                        <?PHP if($_REQUEST['st']==2) { ?>
<table cellpadding="0" cellspacing="0" border="0" width="100%"  class="table-bg" style="clear:both;" align="center">
                          <tr>
                            <td colspan="10" valign="middle" class="table-raw-title" style="text-align:left; height:30px;">
                              <div class="section-title">Your EI API Key</div>
                            </td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                          </tr>
                          <tr>
                            <td colspan="10" class="api-key" style="padding:0 0 0 35px;">
                              <?PHP echo $objWebsite->api_key;?>
                            </td>
                          </tr>
                        </table>
                        <br />
                        <br />
                        <table cellpadding="0" cellspacing="0" border="0" width="100%"  class="table-bg"style="clear:both;" align="center" >
                          <tr>
                            <td colspan="10" valign="middle" class="table-raw-title" style="text-align:left; height:30px;">
                              <div class="section-title">Download Sample Code</div>
                            </td>
                          </tr>
                          <tr>
                            <td>&nbsp;</td>
                          </tr>

                          <tr>
                            <td colspan="10" style="text-align:left; height:30px; padding:0 0 0 35px;">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
  <td width="35%" valign="middle" align="center">
	<img src="<?PHP echo SERVER_CLIENT_HOST; ?>images/arrow_down_green_mini.gif" width="16" height="16" />
	<span class="blue14">Click to download  sample code in PHP</span>
  </td>
  <td width="38%" valign="middle" align="center">
	<img src="<?PHP echo SERVER_CLIENT_HOST; ?>images/arrow_down_green_mini.gif" width="16" height="16" />
	<span class="blue14">Click to download  sample code in ASP.net</span>
  </td>
  <td width="29%" valign="middle">&nbsp;</td>
</tr>
<tr align="center">
  <td colspan="3">&nbsp;</td>
</tr>
<tr>
	<td width="35%" valign="middle" align="center">
		<a href="<?PHP echo SERVER_CLIENT_HOST; ?>/php_sample_code.zip">
			<img src="<?PHP echo SERVER_CLIENT_HOST; ?>images/php-logo.png" width="160" height="122" />
		</a>
	</td>
	<td width="36%" valign="middle" align="center">
		<a href="<?PHP echo SERVER_CLIENT_HOST; ?>/DOT_NET_samplecode.zip">
		  <img src="<?PHP echo SERVER_CLIENT_HOST; ?>images/asp-logo.png" width="160" height="122" />
		</a>
	</td>
	<td width="29%" valign="middle">&nbsp;</td>
</tr>
                              </table>
                            </td>
                          </tr>
                        </table>
                        <?PHP } else { ?>
                        <form name="frm" id="frm" method="post" action=""
                          <?php echo $_SERVER['REQUEST_URI']; ?>">
                          <table cellpadding="0" cellspacing="0" border="0" width="100%"  class="table-bg"style="clear:both;" align="center" >
                            <tr>
                              <td align="left" valign="top" style="padding-top:20px;">
                                <table width="95%" align="center" cellpadding="0" cellspacing="0" class="listtab">
                                  <tr class="row4">
                                    <td width="20%" class="listtab-rt-bro-user">
                                      <input type="image" value="submit" name="submit" src="<?PHP echo SERVER_CLIENT_HOST; ?>images/active-api.png" />
                                    </td>
                                  </tr>
                                </table>
                              </td>
                            </tr>
                          </table>
                        </form>
                        <?PHP } ?>
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
<div class="clear"></div>
</div>
<!--Start footer -->
<?php include "include/footer.php"; ?>