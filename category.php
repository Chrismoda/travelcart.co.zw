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

            <!-- Blog Entries Column -->
            <div class="col-md-8">

                <?php 

                    if (isset($_GET['category'])) {
                        $cat_type = $_GET['category'];
                    }

                    $query = "SELECT *  FROM  posts WHERE post_category_id=$cat_type";
                    $select_all_bus = mysqli_query($connection,$query);

                    // $count = mysqli_num_rows($search_all_bus);
                    // if($count == 0) {
                    //     echo "<h1>NO RESULT</h1>";
                    // }
                    // else {
                        
                    // }
                    while($row = mysqli_fetch_assoc($select_all_bus)) {
                        $post_title = $row['post_title'];
                        $post_author = $row['post_author'];
                        $post_date = $row['post_date'];
                        $post_image = $row['post_image'];
                        $post_content = $row['post_content'];
                        $post_id = $row['post_id'];
                        ?>


                        <!-- First Blog Post -->
                        <h2>
                            <a href="bus_info.php?bus_id=<?php echo $post_id; ?>"><?php echo $post_title; ?></a>
                        </h2>
                        <hr>
                        <a href="bus_info.php?bus_id=<?php echo $post_id; ?>"><img class="img-responsive" src="images/<?php echo $post_image; ?>" alt=""></a>
                        <!-- <img class="img-responsive" src="images/<?php echo $post_image; ?>" alt=""> -->
                        <hr>
                        <p><?php echo $post_content ?></p>
                       
						<hr>
						<div class="input-group">
							<div class="input-group-btn">
								<a href="bus_info.php?bus_id=<?php echo $post_id ?>" class="btn btn-info">Read More</a>
<?php if(func::checkLoginState($dbh)){
	?>
									<a href="bookNow.php?bus=<?php echo $post_id ?>&user=<?php echo $_COOKIE['username']; ?>" class="btn btn-default">Book Now</a>

	<?php
} ?>							</div>
						</div>
                        <hr>
                    <?php } ?>      

            </div>

            <!-- Blog Sidebar Widgets Column -->
            <?php include "includes/sidebar.php"; ?>

        </div>
        <!-- /.row -->

        <hr>

<?php include "includes/footer.php"; ?>