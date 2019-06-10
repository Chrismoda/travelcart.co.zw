<?php
include_once("includes/config.php");
include_once("includes/functions.php");

$order = func::escape_data($dbc, $_GET['id']);

$osql = "SELECT * FROM `orders` WHERE `order_id`='$order' AND `paid` = '0'";
$osry = mysqli_query($dbc, $osql);
if(mysqli_num_rows($osry) == 0){
	echo "<script>alert('Cannot Cancel reservation. Booking already Paid Or booking non existing. Contact admin for refund and cancelation' )</script>";
    echo "<script>window.open('index.php?action=1&acc=".$id."&emtl=0', '_self')</script>";
	
	exit();
}
if(isset($_GET['id'])){
	$sql = "DELETE FROM `orders` WHERE `order_id`='$order'";
	$qry = mysqli_query($dbc, $sql);
	
	if($qry){
		//send email here
		echo "<script>alert('Successfully Cancelled Resevation')</script>";
       echo "<script>window.open('profile.php?action=1&acc=".$id."&emtl=0', '_self')</script>";
	}else{
		echo "<script>alert('Payment Failed')</script>";
        echo "<script>window.open('index.php?action=0&error=', '_self')</script>";
	}
}else{
		echo "<script>alert('Invalid Parameters. Please reload and try again')</script>";
		echo "<script>window.open('index.php?action=0&error=', '_self')</script>";
}
?>