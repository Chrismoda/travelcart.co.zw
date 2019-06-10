<?php
session_start();
if (!empty($_SERVER['HTTPS']) && ('on' == $_SERVER['HTTPS'])) {
    $uri = 'https:/';
} else {
    $uri = 'http:/';
}

if(isset($_POST["srch"])){ 
 
      if(!empty($_POST["srch-qry"]))  
      {  
           $search_query = str_replace(" ", "+", $_POST["srch-qry"]);  
           header("location:index.php?search=" . $search_query."&cat=".$_POST["cat"]);  
      }  
 }else{
	 header("location:".$uri."/teamvelocity.co.zw?utm-error=invalid-access-detected");
	 exit();
 }
?>