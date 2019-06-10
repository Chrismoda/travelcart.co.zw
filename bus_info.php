<?php
include_once("includes/config.php");
include_once("includes/functions.php");
include "includes/db.php"; ?>
<?php include "includes/header.php"; ?>
    
    <!-- Navigation -->
    <?php include "includes/navigation.php"; ?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

			<div class="col-md-12 jumbotron w-100"></div>
            <!-- Blog Entries Column -->
			<div class="col-md-12"><hr></div>
            <div class="col-md-8">

                <?php 

                    if(isset($_GET['bus_id'])) {
                        $selected_bus = $_GET['bus_id'];
                    }

                    $query = "SELECT *  FROM  posts WHERE post_id = $selected_bus ";

                    $select_all_bus_query = mysqli_query($connection,$query);

                    while($row = mysqli_fetch_assoc($select_all_bus_query)) {
                        $bus_title = $row['post_title'];
                        $bus_author = $row['post_author'];
                        $bus_date = $row['post_date'];
                        $bus_image = $row['post_image'];
                        $bus_content = $row['post_content'];
                        $bus_id = $row['post_id'];
                        $bus_via = $row['post_via'];
                        $times = $row['post_via_time'];
                        $bus_cat = $row['post_category_id'];
                        $available_seats = $row['available_seats'];
                        $max_seats = $row['max_seats'];
						$rt = $row['rating'];
                      $bus_stations = explode(" ",$bus_via);
                      $bus_times = explode(" ",$times);
                        ?>

                        <!-- First Blog Post -->
                        <h2><span class="text-warning">Route: </span><?php echo $bus_title; ?></h2>
                        <hr>
                        <img class="img-responsive" src="images/<?php echo $bus_image; ?>" alt="">

                        <hr>
						<div class="row">
							<p class="col-md-6"><?php echo $bus_content ?></p>
							<p class="col-md-6">
								<?php
									echo '<b class="text-danger">'.$rt.' </b>';
									for($i=0; $i<$rt; $i++){
										echo '<i class="fa fa-star text-danger"></i> ';
									}
									
								?>
								<span class="text-danger"> rated!</span>
							</p>
						</div>
                        
						
                        <hr>
                        <div class="jumbotron jumb ">
							<div class="row">
								<div class="col-md-12">
									<h2><b>Seat Matrix:</b></h2>
									<div class="row">
										<div class="col-md-6">
											<h5>Max:         <?php echo $max_seats ?></h5>
											<h5>Available:   <?php echo $available_seats ?></h5>
										</div>
										<?php

											if($available_seats != 0){
												
												?>
												<div class="col-md-6">
													<div class="input-group">
														<div class="input-group-btn">
															<?php if(func::checkLoginState($dbh)){
																
																?>
																	<a href="bookNow.php?bus=<?php echo $_GET['bus_id']; ?>&user=<?php echo $_COOKIE['username']; ?>" class="btn btn-default">Book Now</a>

																<?php
															} ?>
															
														</div>
													</div>
												</div>
												<?php
												
											}else{
												
												echo "<strong>No Available Seats</strong>";
												
											}
										?>
									</div>
									
								</div>
								
								
							</div>
                            <h2><b>Stations Covered:</b>
							
							</h2>
                            <table class="table table-striped" style="width: 100%; margin-top:-20px;">
                              <thead>
                                  <th><u>Station</u></th>
                                  <th><u>Time</u> </th>
                              </thead>
                              <tbody>
                                <?php

                                    for ($i=0; $i < sizeof($bus_stations); $i++) { ?>
                                        <tr>
                                          <td><?php echo $bus_stations[$i]; ?></td>
                                          <td><?php echo $bus_times[$i]; ?></td>
                                        </tr> <?php 
                                    }

                                ?>
                                <br>
								
                              </tbody>
                            </table>
                        </div>


                        <?php
?>

                        <hr>
                    <?php } ?>


                    <!-- Blog Comments -->

                <?php 

                    if (isset($_POST['submit_query'])) {
                        $user_name = ucfirst($_SESSION['s_username']) ;
                        if($user_name == "") {
                            $user_name = "(unknown)";
                        }
                        $user_email = $_POST['user_email'];
                        $user_query = $_POST['user_query'];

                        $query = "INSERT INTO query(query_bus_id, query_user, query_email, query_date, query_content, query_replied) VALUES ('$selected_bus', '$user_name', '$user_email', now(), '$user_query', 'no')";

                        $query_insert = mysqli_query($connection, $query);
                        if(!$query_insert) {
                            die("Query Failed" . mysqli_error($connection));
                        }

                        $query = "UPDATE posts SET post_query_count = post_query_count + 1 WHERE post_id = $bus_id";
                        $increase_query_count = mysqli_query($connection,$query);
                    }

                ?>



                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form action="bus_info.php?bus_id=<?php echo $selected_bus ?>" method="post" role="form">
                        
                        <!-- <div class="form-group">
                            <label for="name">Name</label>
                            <input class="form-control" name="user_name"></textarea>
                        </div> -->

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" name="user_email"></textarea>
                        </div>

                        <div class="form-group">
                            <label> Query</label>
                            <textarea class="form-control" rows="3" name="user_query"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" name="submit_query">Submit</button>
                    </form>
                </div>

                <hr>

                <!-- Posted Comments -->

                <?php 

                $query = "SELECT * FROM query WHERE query_bus_id = $bus_id";
                $get_query = mysqli_query($connection,$query);

                while ($row = mysqli_fetch_assoc($get_query)) {
                    
                $query_user = $row['query_user'];
                $query_content = $row['query_content'];
                $query_date = $row['query_date'];

                ?>

      
                <?php } ?>

            </div>

            <!-- Blog Sidebar Widgets Column -->
			 <div class="col-md-4">
			 
            <?php

                    if (!func::checkLoginState($dbh)) {
                        ?>
                            <div class="well">
								<div class="col-md-12 panel panel-heading">
									<h4 class="text-default"><a style="text-decoration: none; color: orange;" href="registration.php">Register</a> / Login to Book Now</h4>
								</div>
                                <h4>Login Now</h4>
                                <form action="login-reg/index.php" method="post">

                                    
                                        <input name="username" type="email" required class="form-control" placeholder="Username">
                                        <input name="pd" type="password" required class="form-control" placeholder="Password" style="margin-top: 10px;">

                                        <button class="btn btn-primary" name="login" style="margin-left: 130px; margin-top: 10px;">Login</button>
                                    
                                </form>
                                <!-- /.input-group -->
                            </div>
                        
                <?php } ?>
				</div>

        </div>
        <!-- /.row -->

        <hr>

<?php include "includes/footer.php"; ?>