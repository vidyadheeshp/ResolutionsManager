<?php
ini_set('MAX_EXECUTION_TIME', -1);
$dbhost = 'localhost';
$dbuser = 'gitedu_resmanager';
$dbpass = 'gitedu_ResManager';
$database = 'gitedu_resmanager';
$con=mysqli_connect($dbhost, $dbuser, $dbpass, $database);
	// Check connection
	 if(!$con )
	  {
	  echo "Failed to connect to MySQL: " . mysql_error();
	  }
?>