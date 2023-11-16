<?php
// Set session timeout to 30 minutes
ini_set('session.gc_maxlifetime', 1800);
session_start(); // Need to know what session to destroy

session_destroy();

header("Location: index.php");
exit;
