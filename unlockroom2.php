<?php
session_start();
$_SESSION["kamer_2_toegang"] = true;
header("Location: room_2.php");
exit;
?>
