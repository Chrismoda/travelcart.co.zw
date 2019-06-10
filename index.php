<?php
session_start();
include "includes/db.php";
include_once("includes/config.php");
include_once("includes/functions.php");
include "includes/header.php"; 





if(func::checkLoginState($dbh)){
	//user is logged in, now search for unpaid up bookings and calculate days,
	$us = $_SESSION['username'];
	$uql = "SELECT * FROM `orders` WHERE `user_name`='$us' AND `date` < now()";
	$uqqry = mysqli_query($dbc, $uql);
	if (mysqli_num_rows($uqqry) != 0) {
		#check status
		while ($rs = mysqli_fetch_assoc($uqqry)) {
			$dat = $rs['date'];
			if ($rs['paid'] == 0) {
				# code...
			}elseif ($rs['paid'] == 1) {
				# code...
			}
		}

	}


}


?>
    
    <!-- Navigation -->
    <?php include "includes/navigation.php"; ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">
            <!-- Blog Entries Column -->
			<h3>Welcome to <span class="text-info"><i style="font-size: 35px;" class="fa fa-bus"></i>TravelCart </span></h3>
				<hr>
            <div class="col-md-8">
				<div class="row">
				<?php 
				if(func::checkLoginState($dbh)){
					$uid = $_COOKIE['username'];
					$usql = "SELECT * FROM `lgt` WHERE `emtl`='$uid'";
					$uqry = mysqli_query($dbc, $usql);
					$urs = mysqli_fetch_assoc($uqry);
					$userCity = $urs['city'];
				
					$dsql = "SELECT * FROM `posts` WHERE `post_category_id`= '3' OR  `post_source`='' OR `post_destination`='' OR  `post_via` LIKE '%$userCity%'";
					$dqry = mysqli_query($dbc, $dsql);
					if(mysqli_num_rows($dqry) == 0){
						echo "Please login or Register";
					}else
						 while($rs = mysqli_fetch_assoc($dqry)){
							 ?>
							 <div class="col-md-12">
								<div class="panel panel-default">
									<div class="panel-body">
										<h3><?php echo $rs['post_title'];?></h3>
										
										<hr>
										<div class="row">
											<div class="col-md-6"><img src="images/<?php echo $rs['post_image']; ?>" width="300"/> </div>
											<div class="col-md-6">
												<p><strong><i class="fa fa-info-circle text-info"></i></strong> <?php echo $rs['post_content']; ?></p>
												<ul>
													<h3>Routes</h3>
												<?php
													$routes = explode(" ",$rs['post_via'] );
													for($i = 0; $i < count($routes); $i++){
														echo '<li class="color: #000;">'.$routes[$i].'</li>';
													}
												?>
												</ul>
											</div>
										</div>
										<div class="clearfix"></div>							  
										<hr>
										<div class="input-group">
											<div class="input-group-btn">
												<a href="bus_info.php?bus_id=<?php echo $rs['post_id']; ?>" class="btn btn-info">Read More</a>
												<a href="bookNow.php?bus=<?php echo $rs['post_id']; ?>&user=<?php echo $_COOKIE['username']; ?>" class="btn btn-default">Book Now</a>
											</div>
										</div>
									</div>
								 </div>
							</div>
							 <?php
						 }
				}else{
					?>
				
					<div class="col-md-12">
						<div class="panel panel-default">
							<div class="panel-body">
								<h3>Register or Login</h3>
							</div>
						 </div>
					</div>
					
					<?php
				}
				?>
					
				</div>
                   


            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php"; ?>

        </div>
        <!-- /.row -->

        <hr>


        <ul class="pager">
            <?php
                for ($i=1; $i <= $count; $i++) { 
                    if($i !== $page) {
                        echo "<li class='active'><a href='index.php?page=$i'>$i</a></li>";
                    }
                    else {
                        echo "<li><a href='index.php?page=$i'>$i</a></li>";
                    }
                    //echo $page;
                }

            ?>
        </ul>


<?php include "includes/footer.php"; ?>