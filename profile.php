<?php
session_start();
include "includes/db.php"; 
include_once("includes/config.php");
include_once("includes/functions.php");
if(!func::checkLoginState($dbh)){
	header("location: http://travelcart.co.zw");
	exit();
}
$id = $_COOKIE['username'];
$sql = "SELECT * FROM `lgt` WHERE `emtl`='$id'";
$qry = mysqli_query($dbc, $sql);
$rs = mysqli_fetch_assoc($qry);

$user_firstname = $rs['nmt'];
$user_lastname = $rs['snt'];
$user_email = $rs['emtl'];
$user_phoneno = $rs['tel_num'];
?>
<?php include "includes/header.php"; ?>
    
    <!-- Navigation -->
    <?php include "includes/navigation.php"; ?>

    <!-- Page Content -->
    <!-- <div class="container jumbotron" style="width: 45%; border-radius: 15px"> -->

    <div class="container" style="width: 50%;">
                              
        <h2 style="margin-left: 40%;">Profile</h2>
        <?php $image = $rs['user_image'] ; ?>
        <img src="admin/images/user_default.jpg" width="200" style="margin-left: 32%;" class="img-circle" alt="Profile"> 
        <br><br><br><br>
        <div class="tab">
            <button id="active" class="tablinks" style="width: 50%" onclick="openCity(event, 'Personel Details')">Personal Details</button>
            <button class="tablinks" style="width: 50%" onclick="openCity(event, 'Tickets Booked')">Tickets Booked</button>
        </div>


        <div id="Personel Details" class="tabcontent">
          <h3>Details</h3>
          <!-- <?php echo $_COOKIE['username'];?> -->
          <br>
            <table class="table table-striped" style="width: 50%">
              <tbody>
                <tr>
                  <td><b>Username:</b> </td>
                  <td><?php echo $id; ?></td>
                </tr>
                <tr>
                  <td><b>FirstName:</b> </td>
                  <td><?php echo ucfirst($user_firstname); ?></td>
                </tr>
                <tr>
                  <td><b>Lastname: </b></td>
                  <td><?php echo ucfirst($user_lastname); ?></td>
                </tr>
                <tr>
                  <td><b>Email: </b></td>
                  <td><?php echo $user_email; ?></td>
                </tr>
                <tr>
                  <td><b>Phone No: </b></td>
                  <td><?php echo $user_phoneno; ?></td>
                </tr>
              </tbody>
            </table>
        </div>

        <div id="Tickets Booked" class="tabcontent row">
          <h3>Tickets Booked</h3>
          <br>
		  <?php 
		  
		  $tsql = "SELECT * FROM `orders` WHERE `user_name`='$id' ORDER BY `order_id` DESC LIMIT 0,5";
		  $tqr = mysqli_query($dbc,$tsql);
		  while($ts = mysqli_fetch_assoc($tqr)){
		  $bus = $ts['bus_id'];
		  $oder = $ts['order_id'];
		  $paid = $ts['paid'];
		  
		  $psql = "SELECT * FROM `posts` WHERE  `post_id` = '$bus'";
		  $pqry = mysqli_query($dbc, $psql);
		  while($prs = mysqli_fetch_assoc($pqry) ){
			  ?>
			  <div class="col-md-12 panel panel-default">
					<div class="panel-body">
						<h3>Route:  <?php echo $prs['post_title'];?></h3>
						
						<hr>
						<div class="row">
							<div class="col-md-6">
								<h2 style="margin: 0 auto;">Fee: $<?php echo $prs['fee'].".00"; ?></h2>
								<hr>
								<h3 style="margin: 0 auto;">Date: <?php echo date("j, M y",strtotime($ts['date'])); ?></h3>
							</div>
							<div class="col-md-6">
								<ul>
									<h3>Routes</h3>
								<?php
									$routes = explode(" ",$prs['post_via'] );
									for($i = 0; $i < count($routes); $i++){
										echo '<li class="color: #000;">'.$routes[$i].'</li>';
									}
								?>
								</ul>
							</div>
							<div class="col-md-12">
								<hr>
								<div class="input-group">
									<div class="input-group-btn">
										
										<?php if($paid == 0){ ?>
										<a href="cancel.php?id=<?php echo $oder; ?>" class="btn btn-danger">Cancel Reservation</a>
										<a href="reg.php?bus=<?php echo $bus; ?>&user=<?php echo $_COOKIE['username']; ?>&order=<?php echo $oder  ?>" class="btn btn-info">Pay Reservation</a><?php }
										else{
											echo '<button class="btn btn-success">Paid</button>';
										} ?>
									</div>
								</div>
							</div>
							
						</div>
					</div>
				 </div>
			  <?php
			  
		  }
		}
		  
		  ?>



        </div>
    </div>
        <hr>


    <script>

    function myFunction() {
        var x = document.getElementById("myInput");
        if (x.type === "password") {
            x.type = "text";
        } else {
            x.type = "password";
        }
    }


    function openCity(evt, tabName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " active";
    }
	window.onload=function(){
	  document.getElementById("active").click();
	};
    </script>

<?php include "includes/footer.php"; ?> 