<?php
require_once("include/general_includes.php");

// check if user is logged in.
$cmn->isAuthorized("index.php", ADMIN_USER_ID);
$objEncDec = new encdec();
$currentuserID = $cmn->getSession(ADMIN_USER_ID);

$user_id = 0; 

if (isset($_REQUEST['user_id']) && trim($_REQUEST['user_id']) != "") {
  $user_id = $objEncDec->decrypt($_REQUEST['user_id']);
  $entityID = $objEncDec->decrypt($_REQUEST['user_id']);
}

//CHECK FOR RECORED EXISTS
$record_condition = "";
if (!($cmn->isRecordExists("user", "user_id", $user_id, $record_condition)))
  $msg->sendMsg("client_admin_list.php", "", 46);
//END CHECK

$objClientAdmin = new client();

// cancel button link
$cancel_button = "javascript: window.location.href='client_admin_list.php';";

$objClientAdmin->setAllValues($user_id);
?>
<?php
include SERVER_CLIENT_ROOT . "include/header.php";
include SERVER_CLIENT_ROOT . "include/top.php";
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
                  <div class="fleft">Admin Details</div>
                  <div class="fright">
                    <?php print $cmn->getClientMenuLink("client_admin_list.php", "client_admin_list", "Back", "", "back.png", false); ?>
                    <?php print $cmn->getClientMenuLink("client_admin_addedit.php", "client_admin_addedit", "Edit", "?hdnuser_id=" . $objEncDec->encrypt($user_id), "edit.png", false); ?>
                    <?php
                    if ($user_id != $currentuserID) {
                      print $cmn->getClientMenuLink("client_admin_delete.php", "client_admin_delete", "Delete", "?user_id=" . $objEncDec->encrypt($user_id), "delete.png", false);
                    }
                    ?>
                    <?php print $cmn->getClientMenuLink("client_admin_access.php", "client_admin_access", "Access Rights", "?user_id=" . $objEncDec->encrypt($user_id), "access.png"); ?> </div>
                </div>
              </div>
            </div>
            <div class="content-box">
              <div class="content-left-shadow">
                <div class="content-right-shadow">
                  <div class="content-box-lt">
                    <div class="content-box-rt">
                      <div class="blue_title_cont">
                        <table cellpadding="0" cellspacing="0" border="0" class="listtab" width="100%">

                          <tr class="row4">
                            <td align="left" valign="top" width="13%" class="left-none">
                              <strong>Username:</strong>
                            </td>

                            <td class="listtab-rt-bro-user">
                              &nbsp;<?php echo $cmn->readValueDetail($objClientAdmin->user_username); ?>
                            </td>

                          </tr>

                          <tr class="row4">
                            <td align="left" valign="top" class="left-none">
                              <strong>First Name:</strong>
                            </td>

                            <td class="listtab-rt-bro-user">
                              &nbsp;<?php echo $cmn->readValueDetail($objClientAdmin->user_firstname); ?>
                            </td>

                          </tr>

                          <tr class="row4">
                            <td align="left" valign="top" class="left-none">
                              <strong>Last Name:</strong>
                            </td>

                            <td class="listtab-rt-bro-user">
                              &nbsp;<?php echo $cmn->readValueDetail($objClientAdmin->user_lastname); ?>
                            </td>

                          </tr>

                          <tr class="row4">
                            <td align="left" valign="top" class="left-none">
                              <strong>Designation:</strong>
                            </td>

                            <td class="listtab-rt-bro-user">
                              &nbsp;<?php echo $cmn->readValueDetail($objClientAdmin->user_designation); ?>
                            </td>

                          </tr>

                          <tr class="row4">
                            <td align="left" valign="top" class="left-none">
                              <strong>Email:</strong>
                            </td>

                            <td class="listtab-rt-bro-user">
                              &nbsp;<a title="<?php print htmlspecialchars($objClientAdmin->user_email); ?>" href="mailto:<?php print htmlspecialchars($objClientAdmin->user_email); ?>"><?php echo $cmn->readValueDetail($objClientAdmin->user_email); ?></a>
                            </td>

                          </tr>



                          <tr class="row4">
                            <td align="left" valign="top" class="left-none">
                              <strong>Phone:</strong>
                            </td>

                            <td class="listtab-rt-bro-user">
                              &nbsp;<?php echo $cmn->readValueDetail($objClientAdmin->user_phone); ?>
                            </td>

                          </tr>

                          <tr class="row4">
                            <td align="left" valign="top" class="left-none">
                              <strong>Address1:</strong>
                            </td>

                            <td class="listtab-rt-bro-user">
                              &nbsp;<?php echo $cmn->readValueDetail($objClientAdmin->user_address1); ?>
                            </td>

                          </tr>

                          <tr class="row4">
                            <td align="left" valign="top" class="left-none">
                              <strong>Address2:</strong>
                            </td>

                            <td class="listtab-rt-bro-user">
                              &nbsp;<?php echo $cmn->readValueDetail($objClientAdmin->user_address2); ?>
                            </td>

                          </tr>

                          <tr class="row4">
                            <td align="left" valign="top" class="left-none">
                              <strong>City:</strong>
                            </td>

                            <td class="listtab-rt-bro-user">
                              &nbsp;<?php echo $cmn->readValueDetail($objClientAdmin->user_city); ?>
                            </td>

                          </tr>

                          <tr class="row4">
                            <td align="left" valign="top" class="left-none">
                              <strong>State:</strong>
                            </td>

                            <td class="listtab-rt-bro-user">
                              &nbsp;<?php echo $cmn->readValueDetail($objClientAdmin->user_state); ?>
                            </td>

                          </tr>

                          <tr class="row4">
                            <td align="left" valign="top" class="left-none">
                              <strong>Zip Code:</strong>
                            </td>

                            <td class="listtab-rt-bro-user">
                              &nbsp;<?php echo $cmn->readValueDetail($objClientAdmin->user_zipcode); ?>
                            </td>

                          </tr>

                          <tr class="row4">
                            <td align="left" valign="top" class="left-none">
                              <strong>Country:</strong>
                            </td>

                            <td class="listtab-rt-bro-user">
                              &nbsp;<?php if ($cmn->getContryNameById($objClientAdmin->user_country != 0))
                      echo $cmn->getContryNameById($objClientAdmin->user_country) ?>
                            </td>

                          </tr>


                          <tr class="row4">
                            <td align="left" valign="top" class="left-none">
                              <strong>Active:</strong>
                            </td>

                            <td class="listtab-rt-bro-user">

                              &nbsp;<?php ($objClientAdmin->user_isactive == 1) ? print 'Yes'  : print 'No'  ?>
                            </td>

                          </tr>

                        </table>
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
<?php include SERVER_CLIENT_ROOT . "include/footer.php"; ?>
</body>
</html>