<?php 
include 'authenticateLogin.php';

$logFile = 'logs/activity.log';
$redirect = '../index.php';


// prepare log for user logout 📝
$event = $_SESSION['user_name'] . " has logged out —— Success ✅✓";


session_unset();
session_destroy();

$timestamp = date('l jS, F Y h:i:s A');
$status = "[$timestamp] —— [$event]" . PHP_EOL;
file_put_contents($logFile, $status, FILE_APPEND | LOCK_EX) !== false;


header('location: ' . $redirect);
exit();