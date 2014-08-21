<?php
require_once("include/common_includes.php");
require_once("include/general_includes.php");
require_once(COMMON_CLASS_DIR . "clsclient.php");
require_once(COMMON_CLASS_DIR . "clsstate.php");

$cmn->setSession('voter_firstname',     !empty($_REQUEST['first_name']) ? $_REQUEST['first_name'] : '');
$cmn->setSession('voter_lastname',       !empty($_REQUEST['last_name']) ? $_REQUEST['last_name'] : '');
$cmn->setSession('voter_dateofbirth',   !empty($_REQUEST['date_of_birth']) ? $_REQUEST['date_of_birth'] : '');
$cmn->setSession('voter_phone',         !empty($_REQUEST['phone']) ? $_REQUEST['phone'] : '');

if ((!empty($_REQUEST['txtzipcode']) || !empty($_REQUEST['selstate'])) && !empty($_REQUEST['txtemail'])) {
    $objState = new state();

    if (!empty($_REQUEST['txtzipcode'])) {
        $condition = " and " . DB_PREFIX . "state_zipcode.zip_code='" . $_REQUEST['txtzipcode'] . "'";

        if (!empty($_REQUEST['selstate'])) {
            $condition .= " and " . DB_PREFIX . "state.state_id='" . $_REQUEST['selstate'] . "'";
        }

        $homestate = $objState->findhomestate($condition);

        if (count($homestate)) {
            $condition = "  and " . DB_PREFIX . "state.state_id=" . $homestate[0]['state_id'];
            $statedetail = $objState->fetchAllAsArrayLanguage(1, $condition);

            $cmn->setSession('Home_State_ID', $statedetail[0]['state_id']);
            $cmn->setSession('Home_State', $statedetail[0]['state_name']);
            $cmn->setSession('Home_ZipCode', $_REQUEST['txtzipcode']);
            $cmn->setSession('voter_email', $_REQUEST['txtemail']);

            header("Location: registrationform1.php");
            exit;
        } else {
            $msg->sendMsg("index.php", "Zipcode ", 111);
        }
    } elseif (!empty($_REQUEST['selstate'])) {
        $condition = "  and " . DB_PREFIX . "state.state_id=" . $_REQUEST['selstate'];
        $statedetail = $objState->fetchAllAsArrayLanguage(1, $condition);

        if (count($statedetail)) {
            $cmn->setSession('Home_State_ID', $statedetail[0]['state_id']);
            $cmn->setSession('Home_State', $statedetail[0]['state_name']);
            $cmn->setSession('voter_email', $_REQUEST['txtemail']);

            header("Location: registrationform1.php");
            exit;
        } else {
            $msg->sendMsg("index.php", "State ", 111);
        }
    }
} else if ((!empty($_REQUEST['zipcode']) || !empty($_REQUEST['state'])) && !empty($_REQUEST['txtemail'])) {
    $objState = new state();

    if (!empty($_REQUEST['zipcode'])) {
        $condition = " and " . DB_PREFIX . "state_zipcode.zip_code='" . $_REQUEST['zipcode'] . "'";

        if (!empty($_REQUEST['state'])) {
            $condition .= " and " . DB_PREFIX . "state.state_code='" . $_REQUEST['state'] . "'";
        }

        $homestate = $objState->findhomestate($condition);

        if (count($homestate)) {
            $condition = "  and " . DB_PREFIX . "state.state_id=" . $homestate[0]['state_id'];
            $statedetail = $objState->fetchAllAsArrayLanguage(1, $condition);

            $cmn->setSession('Home_State_ID', $statedetail[0]['state_id']);
            $cmn->setSession('Home_State', $statedetail[0]['state_name']);
            $cmn->setSession('Home_ZipCode', $_REQUEST['zipcode']);
            $cmn->setSession('voter_email', $_REQUEST['txtemail']);

            header("Location: registrationform1.php");
            exit;
        } else {
            $msg->sendMsg("index.php", "Zipcode ", 111);
        }
    } elseif (!empty($_REQUEST['state'])) {
        $condition = "  and " . DB_PREFIX . "state.state_code='" . $_REQUEST['state'] . "'";
        $statedetail = $objState->fetchAllAsArrayLanguage(1, $condition);

        if (count($statedetail)) {
            $cmn->setSession('Home_State_ID', $statedetail[0]['state_id']);
            $cmn->setSession('Home_State', $statedetail[0]['state_name']);
            $cmn->setSession('voter_email', $_REQUEST['txtemail']);

            header("Location: registrationform1.php");
            exit;
        } else {
            $msg->sendMsg("index.php", "State ", 111);
        }
    }
} else {
    $msg->sendMsg("index.php", "Zip Code or State", 111);
}
