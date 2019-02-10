<?php
/**
 * Created by PhpStorm.
 * User: joann
 * Date: 1/31/2019
 * Time: 10:37 PM
 */
header('Content-type: application/json');

define('TRACKER', TRUE);

include('../includes/header.php');

$user = isValidSession($session, $badgeID);
$isAdmin = isAdmin($badgeID);

$ret['code'] = -1;
//$ret['msg'] = "Unknown Action.";

if ($user == null) {
    $ret['msg'] = "Not authenticated.";
} elseif (!isset($_POST['action'])) {
    $ret['msg'] = "No data provided.";
} else if (!$isAdmin && sizeof(checkKiosk(session_id())) == 0) {
    $ret['code'] = 0;
    $ret['msg'] = "Kiosk not authorized.";
} else if (!$isAdmin && getSiteStatus() == 0) {
    $ret['code'] = 0;
    $ret['msg'] = "Site is disabled.";
} else {
    $action = $_POST['action'];

    if ($action == "checkIn") {
        $dept = $_POST['dept'];

        if ($dept == "-1") {
            $ret['code'] = 0;
            $ret['msg'] = "Invalid department specified.";
        } else {
            checkIn($badgeID, $dept);

            $ret['code'] = 1;
            $ret['msg'] = "Clocked in.";
            //$ret['msg'] = "Not Implemented ...YET!\nBUT HEY LOOK THERE'S A JSON \"API\" CALLBACK AT LEAST! \xF0\x9F\x98\x81";
        }
    } else if ($action == "checkOut") {
        checkOut($badgeID);

        $ret['code'] = 1;
        $ret['msg'] = "Clocked out.";
    } else if ($action == "getClockTime") {
        $ret['code'] = 1;
        $ret['val'] = getClockTime($badgeID);
    } else if ($action == "getMinutesToday") {
        $ret['code'] = 1;
        $ret['val'] = getMinutesToday($badgeID);
    } else if ($action == "getEarnedTime") {
        $ret['code'] = 1;
        $ret['val'] = calculateBonusTime($badgeID) + getMinutesTotal($badgeID);
    }

    // MANAGER FUNCTIONS
    /*
     *
     */

    // ADMIN FUNCTIONS
    if (!$isAdmin && $ret['code'] === -1) {
        $ret['code'] = 0;
        $ret['msg'] = "Unauthorized.";
    } else {
        $status = $_POST['status'];

        if ($action == "setSiteStatus") {
            $ret['code'] = 1;
            $ret['val'] = setSiteStatus($status);
        } else if ($action == "setKioskAuth") {
            if ($status == 1) authorizeKiosk(session_id());
            if ($status == 0) deauthorizeKiosk(session_id());

            $ret['code'] = 1;
            $ret['val'] = 1;
        }
    }
}

die(json_encode($ret));