<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors',1);
error_reporting(E_ALL);

require_once("cntt.php");


	$dbh = new PDO('mysql:host='.DBHOST.';dbname='.DBNAME, DBUSER, DBPW);
	
	if ($dbc = mysqli_connect (DBHOST, DBUSER, DBPW)) {
		if (!mysqli_select_db ($dbc,DBNAME)) {
			trigger_error("Could not select the database!<br />MySQL Error: " . mysqli_error($dbc));
			exit();
			}
	
	} else {
		trigger_error("Could not connect to MySQL!<br />MySQL Error: " . mysqli_error($dbc));
		exit();
	}


 ?>