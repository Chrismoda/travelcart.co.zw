<?php
include_once("includes/config.php");
include_once("includes/functions.php");

$bID = func::escape_data($dbc, $_GET['bus']);
$order = func::escape_data($dbc, $_GET['order']);
$user = func::escape_data($dbc, $_GET['user']);

$uql = "SELECT * FROM `lgt` WHERE `emtl`='$user'";
$ury = mysqli_query($dbc, $uql);
$urs = mysqli_fetch_assoc($ury);

$bql = "SELECT * FROM `posts` WHERE `post_id`='$bID'";
$bry = mysqli_query($dbc, $bql);
$brs = mysqli_fetch_assoc($bry);

$fee = $brs['fee'];
$usID = $urs['us_id'];
$address = $urs['addr'];
$dt = $urs['date'];
$usEmail = $urs['user_name'];
$route = $brs['post_title'];

$osql = "SELECT * FROM `orders` WHERE `order_id` = '$order' AND `user_name`='$user' AND `bus_id`='$bID'";
$osry = mysqli_query($dbc, $osql);
if(mysqli_num_rows($osry) == 0){
	echo "<script>alert('Cannot Find Reservation. Please book a reservation now' )</script>";
    echo "<script>window.open('index.php?action=1&acc=".$id."&emtl=0', '_self')</script>";
	
	exit();
}
if(isset($_GET['order'])){
	$sql = "UPDATE `orders` SET `paid`='1' WHERE `user_name`='$user' AND `bus_id`='$bID'";
	$qry = mysqli_query($dbc, $sql);
	if($qry){
		//acquire order information
		
		
		//send email here
		

		$data = json_encode(array(
				"category" => "1",
				"email" => $user,
				"message" => "Your Payment of <strong>$".$fee.".00</strong> for <strong>Route: ".$route."</strong> on <strong>".date('D, j ', strtotime($dt)).date('Y')."</strong> was successful. <br><br> Your ticket has been mailed to your billing address: <strong>".nl2br($address)."</strong>"
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
			echo "<script>alert('Payment Successful. Safe Journey')</script>";
			echo "<script>window.open('profile.php?action=1&acc=".$id."&emtl=0', '_self')</script>";
		} else {
			$rs = json_decode($response,true);
			if($rs['status'] == "Sent"){
				echo "<script>alert('Payment Successful. Please check Email for Invoice and Ticket. Safe Journey')</script>";
				echo "<script>window.open('profile.php?action=1&acc=".$id."&emtl=0', '_self')</script>";
			}else{
				echo "<script>alert('Payment Successful. Ticket has been mailed to your billing address')</script>";
				echo "<script>window.open('profile.php?action=1&acc=".$id."&emtl=0', '_self')</script>";
			}
			
			
		}
	}else{
		echo "<script>alert('Payment Failed')</script>";
        echo "<script>window.open('index.php?action=0&error=', '_self')</script>";
	}
}else{
		echo "<script>alert('Invalid Parameters. Please reload and try again')</script>";
		echo "<script>window.open('index.php?action=0&error=', '_self')</script>";
}
?>