<?php
if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
    $uri = 'https:/';
} else {
    $uri = 'http:/';
}
require_once("../inclt/config.php");
require_once("../inclt/functions.php");

if(!isset($_GET['search'])){
	
	header("location:".$uri."/teamvelocity.co.zw/?utm-err=invalid-access-detected");
}else
	
	$rw = "tittle";
	
	$table = "h_pages";
	
	$condition = '';  

	$search_query = explode(" ", $_GET["search"]);
	
	foreach($search_query as $text){  
	   $condition .= $rw." LIKE '%".func::escape_data($dbc,$text)."%' AND lnk LIKE'%".func::escape_data($dbc,$text)."%' OR ";  
	}  
	
	$condition = substr($condition, 0, -4); 
	
	if(!empty($condition)){
		
		$sql= "SELECT * FROM ".$table." WHERE ".$condition;  
		
		$query = mysqli_query($dbc, $sql);
		
		if(mysqli_num_rows($query) > 0){
			$rows = mysqli_num_rows($query);
			$results = "";
			while($rs = mysqli_fetch_array($query)){
				
			$results .='<li class="list-group-item flex-md-row mb-4 m-t-5 box-shadow">
							<ul class="list-inline align-items-start ">
								<li class="list-inline-item"><h5><a href="">'.$rs["tittle"].'</a></h5></li>
								<li class="list-inline-item float-right"><img src="'.$uri.'/teamvelocity.co.zw/wpv-content/2018/uploads/imgs/articwBf5HC/'.$rs["img"].'" class="card-img-right" alt="'.$rs["tittle"].' Image" height="100px" width="150px" /></li>
							</ul>
							<p class="text-dark">'.$rs["h_intro"].'</p>
						</li>';
			}
		}else{
			$rows = 0;
			$results = '
			    <div class="p-3 bg-light text-danger rounded">No Results Found for Search Keywords.</div>
			';
		}
		
	}else{
		$results = "Condition Invalid";
	}
include("../_hd.php");
?>
<main class="container-fluid">
	<div class="row">
		<div class="col-md-12 m-b-10 search-header">
			<ul class="list-inline list-unstyled  m-t-40">
				<li class="list-inline-item"><h2>Search Velocity Wellness Incentives</h2></li>
				<li class="list-inline-item float-right"><p class="text-white">Found (<?php echo $rows; ?>) Results</p></li>
			</ul>
		</div>
		<div class="col-md-4">
			<form class="card p-2" method="post" action="search.php">
				<div class="form-group ">
                    <label for="cl"><h4 class="text-info">Choose Category to Search</h4></label>
					<select name="cat" class="form-control input-rounded" id="cl">
						<option value="0" selected>All</option>
						<option value="1">Events</option>
						<option value="2">Articles</option>
					</select>
				</div>
				<div class="form-group">
					<input type="text" name="srch-qry" class="form-control input-rounded" value="<?php if(isset($_GET['search'])){ echo $_GET['search']; } ?>" placeholder="Type Keywords here to Search..........." required>
				</div>
				<div class="form-group center">
					<button type="submit" class="btn  btn-outline-info btn-lg btn-rounded" name="srch">Search</button>
				</div>
			</form>
		</div>
		<div class="col-md-8 search-results m-b-30">
			<ul class="list-unstyled list-group">
				<?php echo $results."</br>"; ?>
                <!--<li class="row container center">
                    <ul class="col-md-12 list-inline">
                        <li class="list-inline-item badge badge-info badge-pill">Start</li>
                        <li class="list-inline-item badge badge-dark badge-pill">1</li>
                        <li class="list-inline-item badge badge-success badge-pill">2</li>
                        <li class="list-inline-item badge badge-dark badge-pill">3</li>
                        <li class="list-inline-item badge badge-dark badge-pill">4</li>
                        <li class="list-inline-item badge badge-dark badge-pill">5</li>
                        <li class="list-inline-item badge badge-danger badge-pill ">End</li>
                    </ul>
                </li> -->
			</ul>
		</div>
	</div>
	

</main>
<?php include("../_ftr.php");
?>