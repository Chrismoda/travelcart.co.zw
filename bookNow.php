<?php
include_once("includes/config.php");
include_once("includes/functions.php");

$bID = func::escape_data($dbc, $_GET['bus']);
$user = func::escape_data($dbc, $_GET['user']);
$dt = func::escape_data($dbc, $_GET['dt']);
$uql = "SELECT * FROM `lgt` WHERE `emtl`='$user'";
$ury = mysqli_query($dbc, $uql);
$urs = mysqli_fetch_assoc($ury);

$bql = "SELECT * FROM `posts` WHERE `post_id`='$bID'";
$bry = mysqli_query($dbc, $bql);
$brs = mysqli_fetch_assoc($bry);

$fee = $brs['fee'];
$usID = $urs['us_id'];
$route = $brs['post_title'];
$osql = "SELECT * FROM `orders` WHERE `user_name`='$user' AND `bus_id`='$bID'";
$osry = mysqli_query($dbc, $osql);
if(mysqli_num_rows($osry) > 0){
	echo "<script>alert('You have already booked for this route' )</script>";
    echo "<script>window.open('index.php?action=1&acc=".$id."&emtl=0', '_self')</script>";
	
	exit();
}
if(isset($_GET['bus']) && isset($_GET['user'])){
	$sql = "INSERT INTO `orders`(`order_id`, `bus_id`, `user_id`, `user_name`, `date`, `cost`, `paid`) VALUES ('','$bID','$usID','$user','$dt','$fee', '0')";
	$qry = mysqli_query($dbc, $sql);
	
	if($qry){
		
		$data = json_encode(array(
				"category"=>"2",
				"email"=> $user,
				"message"=>"Your bus booking for route ".$route." has been processed successfully. Please proceed to payment."
		));


		$curl = curl_init();

		curl_setopt_array($curl, array(
			CURLOPT_URL => "http://mail.teamvelocity.co.zw",
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => $data,
			CURLOPT_HTTPHEADER => array(
				"Content-Type: application/json",
				"cache-control: no-cache"
			),
		));

		$response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

		if ($err) {
			echo "<script>alert('Successfully booked Reservation! Please proceed to payment')</script>";
			echo "<script>window.open('profile.php?action=1&acc=".$id."&emtl=0', '_self')</script>";
		} else {
			$rs = json_decode($response,true);
			if($rs['status'] == "Sent"){
				echo "<script>alert('Successfully booked Reservation! An email Notification has been sent to your email')</script>";
				echo "<script>window.open('profile.php?action=1&acc=".$id."&emtl=0', '_self')</script>";
			}else{
				echo "<script>alert('Successfully booked Reservation! Email failed to send!')</script>";
			echo "<script>window.open('profile.php?action=1&acc=".$id."&emtl=0', '_self')</script>";
			}
			
			
		}
		
		
	}else{
		echo "<script>alert('Failed to book Reservation')</script>";
        echo "<script>window.open('index.php?action=0&error=', '_self')</script>";
	}
}else{
		echo "<script>alert('Invalid Parameters. Please reload and try again')</script>";
		echo "<script>window.open('index.php?action=0&error=', '_self')</script>";
}
?>