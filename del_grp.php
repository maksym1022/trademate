
<?php
include("include/class.php");
$obj=new admin;
$obj->conn();
//$obj->start=$_REQUEST['start'];
$id=$_REQUEST['del'];
mysql_query("delete from products where group_id=$id");
$value=mysql_query("delete from groups where id=$id");
if($value)
{
$obj->show_groups();
}
else{
echo "sorry".mysql_error();
}



?>