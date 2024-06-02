<?php
// logout.php
session_start();
session_unset();
session_destroy();
header("Location: Acceuil_Stan.php");
exit();
?>