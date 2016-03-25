<?php
include("include/class.php");
require_once("../webservice/custom_functions.php");
$obj=new admin;
//global $start;
$obj->conn();

if(isset($_REQUEST['edit_password']))
{
$id = $_REQUEST['userid'];
$pwd = $_REQUEST['pwd'];
$status = $_REQUEST['status'];
$old_date=date('Y-m-d');
$old_date="$old_date";
$new_date="";
if($status=='0')
{
$new_date=add_days($old_date,14);
}
else if($status=='1')
{
$new_date=$old_date;
}
else if($status=='2')
{
$new_date=add_days($old_date,30);
}
else if($status=='3')
{
$new_date=$old_date;
}



$value=mysql_query("update signup set password='$pwd',status='$status',expiring_on='$new_date' where id='$id'");
if($value)
{
$obj->search_users($uname,$email,$status3);
}
else
{

echo "Password Change Not Successful !".mysql_error();
}
}

?>
