<?php 
include("include/class.php");

$obj=new admin;$obj->conn();

$id=$_REQUEST['productid'];
$qry=mysql_query("select img from products where id='$id'");
if($x=mysql_fetch_array($qry))
{
$file=$x['img'];
	if(file_exists($file))
	{
	unlink($file);
	}
$value=mysql_query("delete from products where id=$id");
if($value){$obj->show_products();}
else{echo "sorry".mysql_error();}
}


?>