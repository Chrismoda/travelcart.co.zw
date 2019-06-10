<?php 
session_start();
include_once("../includes/config.php");
include_once("../includes/encrt/lib/password.php");
include_once("../includes/functions.php");

if(isset($_POST['username']) && isset($_POST['pd'])){

    $err = "";
    $preg_error  ="";

    if (preg_match ('%^[A-Za-z0-9._\%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$%', stripslashes(trim($_POST['username'])))) {

        $u = func:: escape_data($dbc, $_POST['username']);

    } else {

        $u = FALSE;

        echo "<script>alert('Invalid email. Please enter a valid email')</script>";
        echo "<script>window.open('../index.php?action=0&error=invalid inputs', '_self')</script>";

    }

    if (preg_match ('%^[A-Za-z0-9]\S{8,20}$%', stripslashes(trim($_POST['pd'])))) {

        $p = func:: escape_data($dbc, $_POST['pd']);

    } else {
        $p = FALSE;
		echo "<script>alert('Password should be atleast 8 characters, containing letters and numeric numbers. Please enter a valid Password')</script>";
        echo "<script>window.open('../index.php?action=0&error=invalid inputs', '_self')</script>";
        

    }
    if ($u && $p) {
    	$sql = "SELECT COUNT(*) FROM `lgt` WHERE `emtl` = '$u'";
		if ($res = $dbh->query($sql)) {

			if ($res->fetchColumn() == 1) {
				
				$query="SELECT * FROM `lgt` WHERE `emtl` = :username";
				$stmt = $dbh ->prepare($query);
				$stmt->execute(array(':username' =>$u));

				$row = $stmt-> fetch(PDO::FETCH_ASSOC);

				$hash = $row['ptwd'];

				$options = array('cost' => 11);

				if (password_verify($p, $hash)) {
				
					if (password_needs_rehash($hash, PASSWORD_DEFAULT, $options)) {

							$newHash = password_hash($p, PASSWORD_DEFAULT, $options);
							$sql = "UPDATE lgt SET `ptwd`='$newHash' WHERE `emtl`='$u'";
							$db_insert = mysqli_query($dbc, $sql);
						}
						
						func::createRecord($dbh, $u, $row['us_id']);
						header('Location:' . $uri . '/travelcart.co.zw/?utm_meg=login-successful!');
						exit();
					
					
				}else{
						echo "<script>alert('Invalid Login Parameters, please try again')</script>";
        				echo "<script>window.open('../index.php?action=0&error=invalid inputs', '_self')</script>";
				}
			}else{
				echo "<script>alert('Invalid Login Parameters, please try again')</script>";
        		echo "<script>window.open('../index.php?action=0&error=invalid inputs', '_self')</script>";
			}
		}
    }
}else{
	
	echo "<script>alert('Invalid access detected')</script>";
    echo "<script>window.open('../index.php?action=0&error=invalid inputs', '_self')</script>";
		
}
?>
