<?php
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

session_start();
ob_start();
function __autoload($name)
{
	require 'classes/_'.$name.'.class.php';
}
$db = new db();
new router($db);
?>