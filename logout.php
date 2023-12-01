<?php
session_start();

$_SESSION = array();
sleep(3);

session_destroy();
header("Location: login.php");
exit();
?>
