<?php

// Main definitions file to be required at the top of most, if not all, pages.

define("ROOT_DIR", __DIR__);

require ROOT_DIR . "/config.php";

include ROOT_DIR . "/database.php";
include ROOT_DIR . "/includes/functions.php";
include ROOT_DIR . "/vendor/autoload.php";

$session = "";

if(!isset($_SESSION)) session_start();
$badgeID = "";
if (isset($_SESSION['badgeid'])) $badgeID = $_SESSION['badgeid'];

if (!isset($_COOKIE["session"])) {
    setcookie("session", session_id(), 0, "/");
    $session = session_id();
} else {
    $session = $_COOKIE["session"];
}


if (isset($_COOKIE["kiosk"])) {
    $kiosksession = $_COOKIE["kiosk"];
} else {
    $kiosksession = "UNAUTHORIZED";
}

$loader = new \Twig\Loader\FilesystemLoader(ROOT_DIR . "/templates");
$twig = new \Twig\Environment($loader);

$db = new Database($DB_HOST, $DB_NAME, $DB_USERNAME, $DB_PASSWORD);

$user = isValidSession($session, $badgeID);
$devMode = $db->getDevMode();
$siteStatus = $db->getSiteStatus();
$kioskAuth = (isset($_COOKIE["kiosknonce"]) && $db->checkKiosk($_COOKIE["kiosknonce"])->fetch()) ? 1 : 0;

$roles = $db->getUserRole($badgeID)->fetch();
$isAdmin = $roles ? (bool) $roles["admin"] : false;
$isManager = $roles ? (bool) $roles["manager"] : false;
$isLead = $roles ? (bool) $roles["lead"] : false;
$isBanned = $db->getUserBan($badgeID);
$notifs = $db->listNotifications($badgeID, 1)->fetchAll();

$twig->addGlobal("user", $user);
$twig->addGlobal("devMode", $devMode);
$twig->addGlobal("siteStatus", $siteStatus);
$twig->addGlobal("kioskAuth", $kioskAuth);
$twig->addGlobal("isAdmin", $isAdmin);
$twig->addGlobal("isManager", $isManager);
$twig->addGlobal("isLead", $isLead);
$twig->addGlobal("isBanned", $isBanned);
$twig->addGlobal("notifs", $notifs);

?>