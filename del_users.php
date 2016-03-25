<?php
session_start();
include("include/class.php");
$obj = new admin;
$obj->conn();
//$obj->start=$_REQUEST['start'];
$id = $_REQUEST['del'];
$uname = $_REQUEST['uname'];
$email = $_REQUEST['email'];
$status = $_REQUEST['status1'];
$value = mysql_query("delete from signup where id=$id");
if($value)
{
	$obj->search_users($uname, $email, $status);
}
else {
    echo "sorry" . mysql_error();
}
?>