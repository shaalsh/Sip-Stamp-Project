<?php
// Lab 8: start the session, destroy it, then go back to the login page
session_start();
session_destroy();

header("Location: login.php");
exit;
?>
