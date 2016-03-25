<?php 
session_start();
include("include/class.php");

$obj = new admin;
$obj->conn();

$obj->uname = $_REQUEST['uname'];
$obj->email = $_REQUEST['email'];
$obj->status = $_REQUEST['status'];

$obj->search_users($obj->uname, $obj->email, $obj->status);
?> 