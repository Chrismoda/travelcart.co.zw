<?php include "includes/db.php"; 
include_once("includes/config.php");
include_once("includes/encrt/lib/password.php");
include_once("includes/functions.php");
?>
<?php include "includes/header.php"; ?>
    
    <!-- Navigation -->
    <?php include "includes/navigation.php"; ?>

<?php

if (isset($_POST['register'])) {
//echo "registered";
    $username = func::escape_data($dbc, $_POST['username']);
    $firstname = func::escape_data($dbc,$_POST['firstname']);
    $lastname = func::escape_data($dbc,$_POST['lastname']);
    $phone_no = func::escape_data($dbc,$_POST['phone_no']);
	if (preg_match ('%^[A-Za-z0-9]\S{6,20}$%', stripslashes(trim($_POST['password'])))) {
        if($_POST['password'] == $_POST['cpd']){
            $password = func:: escape_data($dbc, $_POST['cpd']);
        }else {

            $password = FALSE;
    
            $err = '<div class="alert alert-danger">
                     <a href="#" class="close" data-dismiss="alert">&times;</a>
                     <strong>Error!</strong> Password do not match. Please try again
                  </div>';
    
        }
		

	} else {

		$password = FALSE;

		$err = '<div class="alert alert-danger">
				 <a href="#" class="close" data-dismiss="alert">&times;</a>
				 <strong>Error!</strong> Please enter a valid Password. Passwords should be atleaset 8 characters in length with atleast one Capital letter and can contain alphanumeric values.
			  </div>';

	}
    $city = func::escape_data($dbc,$_POST['city']);
    $addr = func::escape_data($dbc,$_POST['addr']);
    $sex = func::escape_data($dbc,$_POST['gender']);

	$options = array('cost' => 10);
	$newHash = password_hash($password, PASSWORD_DEFAULT, $options);
	
	if($username && $firstname && $lastname && $phone_no && $newHash && $city && $addr && $sex){
		$query = "INSERT INTO `lgt`(`us_id`, `emtl`, `ptwd`, `sex`, `nmt`, `snt`, `user_image`, `tel_num`, `addr`, `city`, `user_role`) VALUES ('','$username','$newHash','$sex','$firstname','$lastname','','$phone_no','$addr','$city','subscriber')";
		$reg = mysqli_query($dbc, $query);
		if($reg){
			 echo "<script>alert(' Registration Successful')</script>";
             echo "<script>window.open('index.php?action=1&acc=created', '_self')</script>";
		}
	}


}


?>

    <!-- Page Content -->
    <!-- <div class="container jumbotron" style="width: 45%; border-radius: 15px"> -->

    <div class="container">
        <div class="row">
            <div class="col-lg-6">
			<?php if(isset($err))
					echo $err;
				?>
                <img src="images/bus_regis.png" style="margin-top: 30%;">
            </div>
            <div class="col-lg-6">
                
              
              <h2 style="margin-left: 40%;">Registration</h2>
              <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                
                <div class="form-group">
                  <label for="email">Email:</label>
                  <input type="email" required class="form-control" id="email" placeholder="Enter email" name="username">
                </div>

                <div class="form-group">
                  <label for="email">Firstname:</label>
                  <input type="text" required class="form-control" id="email" placeholder="Enter Firstname" name="firstname">
                </div>

                <div class="form-group">
                  <label for="email">Lastname:</label>
                  <input type="text" required class="form-control" id="email" placeholder="Enter Lastname" name="lastname">
                </div>
				
				<div class="form-group">
                  <label for="pwd">Gender:</label>
                  <select required class="form-control" id="gender"  name="gender">
					<option>Select Gender</option>
					<option value="Female">Female</option>
					<option value="Male">Male</option>
				  </select>
                </div>
                
                <div class="form-group">
                  <label for="pwd">Phone No:</label>
                  <input type="text"  required class="form-control" id="pwd" placeholder="Enter password" name="phone_no">
                </div>
				<div class="form-group">
                  <label for="addr">Address:</label>
                  <textarea required class="form-control" id="addr" rows="8" placeholder="Enter your address" name="addr"></textarea>
                </div>
				<div class="form-group">
                  <label for="pwd">City:</label>
                  <select required class="form-control" id="city"  name="city">
					<option>Select City</option>
					<option value="Harare">Harare</option>
					<option value="Bulawayo">Bulawayo</option>
					<option value="Mutare">Mutare</option>
					<option value="Gweru">Gweru</option>
					<option value="Kwekwe">Kwekwe</option>
					<option value="Victoria Falls">Victoria Falls</option>
					<option value="Kadoma">Kadoma</option>
				  </select>
                </div>

                <div class="form-group">
                  <label for="pwd">Password:</label>
                  <input type="password" required class="form-control" id="pwd" placeholder="Enter password" name="password">
                </div>
				
				<div class="form-group">
                  <label for="pwd">Confirm Password:</label>
                  <input type="password"  required class="form-control" id="cpd" placeholder="Confirm password" name="cpd">
                </div>
        
                <button type="submit" class="btn btn-primary" name="register" style="margin-left: 45%; margin-top: 20px;">Register</button>
              </form>
            

            </div>
        </div>

    </div>
        <hr>

<?php include "includes/footer.php"; ?>