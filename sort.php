<?php
include("include/class.php");
$obj=new admin;
$obj->conn();
$corder=$_REQUEST['o'];
$uname=$_REQUEST['uname'];
	$email=$_REQUEST['email'];
	$address=$_REQUEST['address'];
	$status=$_REQUEST['status1'];
//$start=$_REQUEST['start'];
if($corder=='asc')
		{
			$obj->order='desc';
			//echo $order;
		}
		else
		{
			$obj->order='asc';
			//echo $order;
		}
$obj->search_users($uname,$email,$address,$status);
?>