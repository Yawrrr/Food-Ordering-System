<?php
include("../connection.php");
error_reporting(0);
session_start();

mysqli_query($conn,"DELETE FROM user WHERE id = '".$_GET['uid']."'");
header("location:user_management.php");  

?>