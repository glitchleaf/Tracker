<?php
session_start();
header("Refresh:0; url=https://reg.goblfc.org/oauth/logout?next=https%3A%2F%2Ftracker.goblfc.org%2F&client_id=4&access_token=" . $_SESSION['accessToken'], true, 303);