<?php include"db.php" ?>
    <nav class="navbar navbar-inverse navbar-fixed-top" style="background-color: #182c39;" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">TravelCart</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <?php 

                        $query = "SELECT *  FROM  categories";
                        $select_all_categories_query = mysqli_query($connection,$query);

                        while($row = mysqli_fetch_assoc($select_all_categories_query)) {
                            $cat_title = $row['cat_title'];
                            $cat_id = $row['cat_id'];
                            echo "<li> <a href='category.php?category=$cat_id'> {$cat_title} </a></li>";
                        }
                     ?>
                </ul>
                <ul class="nav navbar-nav navbar-right">

                    <?php 
                    if(isset($_SESSION['s_username'])) {
                        if ($_SESSION['s_role']=='admin') {
                            ?>
                            <li>
                                <a href="admin/index.php"><i class="fa fa-fw fa-child"></i>Admin</a>
                            </li>

						<?php
						} 
					}  ?>

                    
					

					<!--<li>
                        <a href="#">About</a>
                    </li>
                    <li>
                        <a href="#">Services</a>
                    </li>
                    <li>
                        <a href="#">Contact</a>
                    </li> -->

                    <?php 
                        if (func::checkLoginState($dbh)) {
                            # code...
                            ?>
							<li class="dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
								<?php 

                                if(isset($_SESSION['username']))
                                echo $_SESSION['username']; ?>
								<span class="caret"></span></a>
								<ul class="dropdown-menu">
								  <li><a href="profile.php"><i class="fa fa-fw fa-user"></i> Profile</a></li>
								  <li><a href="#"><i class="fa fa-fw fa-cog"></i> Settings</a></li>
								  <li role="separator" class="divider"></li>
								  <li><a href="logout"><i class="fa fa-fw fa-power-off"></i>Logout</a></li>
								</ul>
							  </li>                            
                    <?php    }else{
						?>
						<li>
							<a href="registration.php"><i class="fa fa-fw fa-pencil-o"></i> Register Here!</a>
						</li>
						<?php
					}
                    ?>
                    

                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>
