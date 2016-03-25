<?php
session_start();
include("include/class.php");
$obj = new admin;
$obj->conn();
if(isset($_REQUEST['sstart']))
{
	$start = $_REQUEST['sstart'];
	$uname = $_REQUEST['uname'];
	$email = $_REQUEST['email'];
	$address = $_REQUEST['address'];
	$status = $_REQUEST['status1'];
	$obj->start = $start;
	$obj->search_users($uname, $email, $status);
}
else if(isset($_REQUEST['start']))
{
	echo "<script>alert('show')</script>";
	$start = $_REQUEST['start'];
	$obj->start = $start;
	$obj->show_users();
}
?>