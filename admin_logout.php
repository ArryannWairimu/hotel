<?php
session_start();
ob_start(); // Start output buffering

session_destroy();

header("Location: admin_login.php");
exit();
