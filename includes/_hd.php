<?php
session_start();
if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
    $uri = 'https://';
} else {
    $uri = 'http://';
}
$uri .= $_SERVER['HTTP_HOST'];
$title = "";
if (isset($tt)) {
    $title = $tt. " - TravelCart";
}else{
    $title = "TravelCart";
}

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="<?php echo $uri; ?>/travelcart.co.zw/lib/images/system/favicon.ico">

    <title>Travel Cart</title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo $uri;?>/travelcart.co.zw/lib/css/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $uri;?>/travelcart.co.zw/lib/fontawesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo $uri; ?>/travelcart.co.zw/lib/css/main.css"  rel="stylesheet">
  </head>

  <body>

    <header>
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark rounded">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#bus1" aria-controls="bus1" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse justify-content-md-center" id="bus1">
          <ul class="navbar-nav">
            <li class="nav-item active">
              <a class="nav-link" href="<?php echo $uri; ?>/travelcart.co.zw/">TravelCart</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo $uri; ?>/travelcart.co.zw/routes">Routes</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo $uri; ?>/travelcart.co.zw/buses">Buses</a>
            </li>
            <?php if (func::checkLoginState($dbh)) {
              ?>
              <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="" id="dropdown10" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">My Account</a>
              <div class="dropdown-menu" aria-labelledby="dropdown10">
                <a class="dropdown-item" href="<?php echo $uri; ?>/travelcart.co.zw/account">Profile</a>
                <a class="dropdown-item" href="<?php echo $uri; ?>/travelcart.co.zw/account/settings">Settings</a>
                <a class="dropdown-item" href="<?php echo $uri; ?>/travelcart.co.zw/logout">Logout</a>
              </div>
            </li>
              <?php
            }?>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo $uri; ?>/travelcart.co.zw/contact">Contact</a>
            </li>
          </ul>
        </div>
      </nav>
    </header>
