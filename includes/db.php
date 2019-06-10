<?php

$connection = mysqli_connect("localhost",'root','','travel');

if(!$connection) {
	die("Unable to connect" . mysqli_error($connection));
}

?>