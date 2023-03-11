<?php

require "main.php";

logoutSession($session);

setcookie("session", '', 0, "/");
setcookie("badge", '', 0, "/");
//header('Location: /');

if (isset($_SESSION['accessToken'])){
    $encoded_url = urlencode($CANONICAL_URL);
    header("Refresh:0; url={$OAUTH_CONCAT_BASE_URL}/oauth/logout?next=$encoded_url&client_id={$OAUTH_CLIENT_ID}&access_token=" . $_SESSION['accessToken'], true, 303);
}else{
    header("Refresh:0; url=$CANONICAL_URL", true, 303);
}

session_unset();
session_regenerate_id();

?>
