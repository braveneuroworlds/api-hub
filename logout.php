<?php
session_start();
session_destroy(); // Destroy the session data
header("Location: home.php"); // Redirect to home.php
exit();
?>