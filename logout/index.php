<?php 
session_start();

if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
    $uri = 'https://';
} else {
    $uri = 'http://';
}
$uri .= $_SERVER['HTTP_HOST'];
include_once("../includes/config.php");
include_once("../includes/functions.php");
if (func::deleteCookie()) {
	header("location:".$uri."/travelcart.co.zw");
	exit();
}
func::deleteCookie();
header("location:".$uri."/travelcart.co.zw");
exit();
?>