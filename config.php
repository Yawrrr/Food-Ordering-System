<?php
//set the database connection variables
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'webpdb';

//login to MySQL Server from PHP
$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

if (!$conn) {       //checking connection to DB	
  die("Connection failed: " . mysqli_connect_error());
}
?>