<?php

session_start(); // Need to know what session to destroy

session_destroy();

header("Location: index.php");
exit;
