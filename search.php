<?php include "includes/db.php"; 
include_once("includes/config.php");
include_once("includes/functions.php");
?>
<?php include "includes/header.php"; ?>
    
    <!-- Navigation -->
    <?php include "includes/navigation.php"; ?>

    <!-- Page Content -->
	<section class="search-sec">
		<h4>Bus Search</h4>
				<hr>
		<div class="container" style="margin-top: 50px;">
			<form action="" method="post">
				<div class="row">
					<div class="col-lg-12">
						<div class="row">
							<div class="col-lg-3 col-md-3 col-sm-12 p-0">
								<label for="source">Pickup City</label>
								<input type="text" name="source" id="source" class="form-control search-slt" placeholder="Enter Pickup City">
							</div>
							<div class="col-lg-3 col-md-3 col-sm-12 p-0">
								<label for="">Destination</label>
								<input type="text" name="destination" class="form-control search-slt" placeholder="Enter Drop City">
							</div>
							<div class="col-lg-3 col-md-3 col-sm-12 p-0">
								<label for="dt">Pick Travel Date</label>
								<input type="date" id="dt"  name="dat" class="form-control search-slt" placeholder="Enter Drop City">
							</div>
							<div class="col-lg-3 col-md-3 col-sm-12 p-0">
								<br>
								<button type="submit" name="submit" style="margin-top: 5px;" class="btn btn-danger wrn-btn">Search</button>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</section>
	<section class="container">
		<div class="row">
			<div class="col-md-8">
				<div class="row">
					<div class="panel panel-default">
						<div class="panel-body row">
							
							 <?php 

								if(isset($_POST['submit'])) {
									$source = func::escape_data($dbc,$_POST['source']);
									$destination = func::escape_data($dbc, $_POST['destination']);
									$date = func::escape_data($dbc, $_POST['date']);
									//echo $date;
									$query = "SELECT * FROM posts WHERE  `post_via` LIKE '%$source%' AND `post_destination` LIKE '%$destination%' AND `post_category_id`='3' ORDER BY RAND() LIMIT 0,4";
									$search_query = mysqli_query($dbc,$query);
									if(mysqli_num_rows($search_query) == 0){
										if (!func::checkLoginState($dbh)) {
											//we dont know the user, we suggest our most popular
											$sql = "SELECT * FROM posts WHERE `post_category_id`='3' AND `rating`>='3' ORDER BY RAND() LIMIT 0,3";
											$qry = mysqli_query($dbc,$sql);
											if(mysqli_num_rows($qry)!= 0){
												
												//now loop through and display with heading, these are our most popular buses
												?>
												<div class="col-md-12">
													<div class="row">
														<h3 class="col-md-6 "><i>(0) results found for search query.</i></h3>
													</div>
												</div>
												<hr>
												<div class="col-md-12 panel panel-heading">
													<div class="row">
														<h3 class="col-md-6 text-warning">Try our most Popular Buses <i class="fa fa-star text-danger"></i></h3>
													</div>
												</div>
												<?php
												while($prs = mysqli_fetch_assoc($qry)) {
													$post_title = $prs['post_title'];
													$post_author = $prs['post_author'];
													$post_date = $prs['post_date'];
													$post_image = $prs['post_image'];
													$post_content = $prs['post_content'];
													$post_id = $prs['post_id'];
													$rt = $prs['rating'];
													?>

												   <div class="col-md-6">
														<div class="panel panel-default">
															<div class="panel-body">
																<h2><a href="bus_info.php?bus_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a></h2>
																<hr>
																<a href="bus_info.php?bus_id=<?php echo $post_id; ?>"><img class="img-responsive" src="images/<?php echo $post_image; ?>" width="300" alt=""></a>
																<hr>
																<p><?php echo $post_content ?></p>
																<a class="btn btn-primary" href="bus_info.php?bus_id=<?php echo $post_id; ?>">Book Now <span class="glyphicon glyphicon-chevron-right"></span></a>

																<hr>
																<p>
																	<?php
																		
																		for($i=0; $i<$rt; $i++){
																			echo '<i class="fa fa-star text-danger"></i> ';
																		}
																		
																	?>
																	<span class="text-danger">rated!</span>
																</p>
															</div>
														</div>
												   </div>
												<?php }
											}else{
												$sql = "SELECT * FROM posts WHERE `post_category_id`='5'";
												$qry = mysqli_query($dbc,$sql);
												//suggest our daily routes for each routes
												?>
												<div class="col-md-12">
													<div class="row">
														<h3 class="col-md-6 "><i>(0) results found for search query.</i></h3>
													</div>
												</div>
												<hr>
												<div class="col-md-12 panel panel-heading">
													<div class="row">
														<h3 class="col-md-6 text-warning">Try our Daily Buses</h3>
													</div>
												</div>
												<?php
												while($drs = mysqli_fetch_assoc($qry)) {
													$post_title = $drs['post_title'];
													$post_author = $drs['post_author'];
													$post_date = $drs['post_date'];
													$post_image = $drs['post_image'];
													$post_content = $drs['post_content'];
													$post_id = $drs['post_id'];
													?>

												   <div class="col-md-6">
														<div class="panel panel-default">
															<div class="panel-body">
																<h2><a href="bus_info.php?bus_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a></h2>
																<hr>
																<a href="bus_info.php?bus_id=<?php echo $post_id; ?>"><img class="img-responsive" src="images/<?php echo $post_image; ?>" width="300" alt=""></a>
																<hr>
																<p><?php echo $post_content ?></p>
																<a class="btn btn-primary" href="bus_info.php?bus_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

																<hr>
															</div>
														</div>
												   </div>
												<?php }
											}
											
										}else{
											$usid = $_SESSION['username'];
											$ssql = "SELECT * FROM `orders` WHERE `user_name`='$usid'";
											$ssqry = mysqli_query($dbc, $ssql);
											$rs = mysqli_fetch_assoc($ssqry);
											for($i = 0; $i<=1; $i++){
												
												$bus = $rs['bus_id'];
												
												
											}
											//check previous search data and previous trips, and suggest next bus as per that data
											
											$busql = "SELECT * FROM `posts` WHERE `post_id` = '$bus'";
											$buqry = mysqli_query($dbc, $busql);
											$buss = mysqli_fetch_assoc($buqry);
											$cat = $buss['post_category_id'];
											
											$sugsql = "SELECT * FROM `posts` WHERE `post_category_id`='$cat'";
											$suqry = mysqli_query($dbc, $sugsql);
											
											print_r($usgrs);
											//iterate and display suggestions for the date 
											//your favoured our. use `rating`>= '3' to show most popular first, then the rest on load more
											while($usgrs = mysqli_fetch_assoc($suqry)) {
													$post_title = $usgrs['post_title'];
													$post_author = $usgrs['post_author'];
													$post_date = $usgrs['post_date'];
													$post_image = $usgrs['post_image'];
													$post_content = $usgrs['post_content'];
													$post_id = $usgrs['post_id'];
													?>

												   <div class="col-md-6">
														<div class="panel panel-default">
															<div class="panel-body">
																<h2><a href="bus_info.php?bus_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a></h2>
																<hr>
																<a href="bus_info.php?bus_id=<?php echo $post_id; ?>"><img class="img-responsive" src="images/<?php echo $post_image; ?>" width="300" alt=""></a>
																<hr>
																<p><?php echo $post_content ?></p>
																<a class="btn btn-primary" href="bus_info.php?bus_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

																<hr>
															</div>
														</div>
												   </div>
												<?php }
										}
										
									}else{
									$count = mysqli_num_rows($search_query); 
									if($count > 0){
										echo '<h5 style="padding: 10px; font-style: bold;">(<b>'.$count.'</b>) <strong>Buses Found</strong> </h5>';
									}
									
										while($row = mysqli_fetch_assoc($search_query)) {
											$post_title = $row['post_title'];
											$post_author = $row['post_author'];
											$post_date = $row['post_date'];
											$post_image = $row['post_image'];
											$post_content = $row['post_content'];
											$post_id = $row['post_id'];
											?>

										   <div class="col-md-6">
												<div class="panel panel-default">
													<div class="panel-body">
														<h2><a href="bus_info.php?bus_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a></h2>
														<hr>
														<a href="bus_info.php?bus_id=<?php echo $post_id; ?>"><img class="img-responsive" src="images/<?php echo $post_image; ?>" width="300" alt=""></a>
														<hr>
														<p><?php echo $post_content ?></p>
														<a class="btn btn-primary" href="bus_info.php?bus_id=<?php echo $post_id; ?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>

														<hr>
													</div>
												</div>
										   </div>
										<?php }
										}
										
								}else{
									//no searching done yet. Display popular busses
									
									
								}
								?>
							
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-4">
                <!-- Login -->
                <?php

                    if (!func::checkLoginState($dbh)) {
                        ?>
						<div class="well">
							<h4>Login</h4>
							<form action="login-reg/index.php" method="post">

								
									<input name="username" type="email" required class="form-control" placeholder="Username">
									<input name="pd" type="password" required class="form-control" placeholder="Password" style="margin-top: 10px;">

									<button class="btn btn-primary" name="login" style="margin-left: 130px; margin-top: 10px;">Login</button>
								
							</form>
							<!-- /.input-group -->
						</div>
                        
                <?php 
					} 
				?>

                



                <!-- Blog Categories Well -->
                <div class="well">
                    <?php 

                        $query = "SELECT *  FROM  categories";
                        $select_categories_sidebar = mysqli_query($connection,$query);

                     ?>
                    <h4>Bus Categories</h4>
                    <div class="row">
                        <div class="col-lg-6">
                            <ul class="list-unstyled">

                                <?php  
                                    while($row = mysqli_fetch_assoc($select_categories_sidebar)) {
                                        $cat_title = $row['cat_title'];
                                        $cat_id = $row['cat_id'];
                                         echo "<li> <a href='category.php?category=$cat_id'> $cat_title </a></li>";
                                    }

                                ?>
                                
                            </ul>
                        </div>

                    </div>
                    <!-- /.row -->
                </div>
                <!-- Side Widget Well -->
                <?php include "widget.php"; ?>
            </div>
		</div>
	</section>
	<hr>

<?php include "includes/footer.php"; ?>
<script>
	var x = document.getElementById("demo");

	function getLocation() {
	  if (navigator.geolocation) {
		navigator.geolocation.getCurrentPosition(showPosition, showError);
	  } else { 
		x.innerHTML = "Geolocation is not supported by this browser.";
	  }
	}

	function showPosition(position) {
		var lat = position.coords.latitude;
	    var longi = position.coords.longitude;
	}

	function showError(error) {
	  switch(error.code) {
		case error.PERMISSION_DENIED:
		  x.innerHTML = "User denied the request for Geolocation."
		  break;
		case error.POSITION_UNAVAILABLE:
		  x.innerHTML = "Location information is unavailable."
		  break;
		case error.TIMEOUT:
		  x.innerHTML = "The request to get user location timed out."
		  break;
		case error.UNKNOWN_ERROR:
		  x.innerHTML = "An unknown error occurred."
		  break;
	  }
	}
</script>